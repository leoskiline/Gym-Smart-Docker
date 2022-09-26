<?php

namespace App\AtividadeFisica\Controller;

use App\AtividadeFisica\Model\AtividadeFisica;
use App\Utils\AbstractSlimController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AtividadeFisicaController extends AbstractSlimController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function delete(Request $request,Response $response,array $args)
    {
        try{
            $retorno = ["status" => false, "icon" => "info", "message" => "Não foi possivel deletar o registro"];
            $dados = $request->getParsedBody();
            $atividadeFisica = new atividadeFisica($dados['idAtividadeFisica'],null,null);
            if($atividadeFisica->deletar($this->conn))
            {
                $retorno = ["status" => true, "icon" => "success", "message" => "Deletado com sucesso!"];
            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function list(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "info", "message" => "Nao ha nenhum registro."];
        try{
            $atividadesFisicas = new AtividadeFisica(null,null,null);
            $todasAtividades = $atividadesFisicas->obterTodasAtividadesFisicas($this->conn);
            if($todasAtividades){
                $retorno = ["status" => true, "resultSet" => $todasAtividades];
            }
        }catch(\PDOException $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function index(Request $request,Response $response, array $args)
    {
        return $this->view->render($response, "/AtividadeFisica/View/index.php");
    }



    public function update(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel atualizar registro de Atividade Física."];
        $params = $request->getParsedBody();
        $atividadeFisica = new AtividadeFisica($params['ModalIdAtividadeFisica'],$params['ModalDescricao'],$params['ModalAtiva']);
        if($atividadeFisica->atualizar($this->conn))
        {
            $retorno = ["status" => true, "icon" => "success", "message" => "Atividade Fìsica atualizada com sucesso."];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }



    public function store(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel gravar registro."];
        $dados = $request->getParsedBody();
        $atividadeFisica = new AtividadeFisica(null,$dados['atividadeFisica'],null);
        $cadastrado = $atividadeFisica->verificarCadastrado($this->conn);
        if(!$cadastrado)
        {
            $this->conn->beginTransaction();
            try{
                if($atividadeFisica->cadastrar($this->conn))
                {
                    $this->conn->commit();
                    $retorno = ["status" => true, "icon" => "success", "message" => "Atividade Física cadastrada com sucesso."];
                }
                else{
                    $this->conn->rollBack();
                }
            }catch (\PDOException $e)
            {
                $this->conn->rollBack();
            }
        }
        else{
            $retorno = ["status" => false, "icon" => "info", "message" => "Atividade Física já está cadastrada."];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }
}