<?php

namespace App\Planos\Controller;

use App\Planos\Model\Plano;
use App\Utils\AbstractSlimController;
use App\Utils\Moeda;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PlanoController extends AbstractSlimController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request,Response $response)
    {
        return $this->view->render($response,"Planos/View/index.php");
    }

    public function update(Request $request,Response $response)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Não foi possivel atualizar plano."];
        $dados = $request->getParsedBody();
        $planoModel = new Plano($dados['idPlanoModal'],$dados['descricaoModal'],$dados['tipoPlanoModal'],Moeda::MoedaDB($dados['valorModal']),$dados['descontoModal'],Moeda::MoedaDB($dados['valorDescontoModal']));

        if(!$planoModel->verificarExiste($this->conn)){
            $this->conn->beginTransaction();
            if($planoModel->atualizar($this->conn,$dados['atividadesFisicasModal']))
            {
                $this->conn->commit();
                $retorno = ["status" => true, "icon" => "success", "message" => "Plano atualizado com sucesso."];
            }else{
                $this->conn->rollBack();
            }
        }else{
            $retorno = ["status" => false, "icon" => "info", "message" => "Já existe um plano com essa descrição."];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function delete(Request $request,Response $response)
    {
        try{
            $retorno = ["status" => false, "icon" => "error", "message" => "Não foi possivel excluir registro."];
            $dados = $request->getParsedBody();
            $planoModel = new Plano($dados['idPlano'],null,null,null,null,null);
            $this->conn->beginTransaction();
            if(!$planoModel->verificarVinculadoMatricula($this->conn))
            {
                if($planoModel->deletar($this->conn))
                {
                    $retorno = ["status" => true, "icon" => "success", "message" => "Registro deletado com sucesso."];
                    $this->conn->commit();
                }
                else{
                    $this->conn->rollBack();
                }
            }else{
                $retorno = ["status" => false, "icon" => "info", "message" => "Não é possível excluir plano, pois está vinculado ao contrato de aluno."];
            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function list(Request $request,Response $response)
    {
        $retorno = ["status" => false, "icon" => "info", "message" => "Não há nenhum registro"];
        $planoModel = new Plano(null,null,null,null,null,null);
        $planos = $planoModel->obterTodos($this->conn);
        if($planos)
        {
            $retorno = ["status" => true, "icon" => "success", "resultSet" => $planos];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function store(Request $request,Response $response)
    {
        $dados = $request->getParsedBody();
        $retorno = ["status" => false, "icon" => "error", "message" => "Não foi possivel gravar registro"];
        $planoModel = new Plano(null,$dados['descricao'],$dados['tipoPlano'],Moeda::MoedaDB($dados['valor']),$dados['desconto'],Moeda::MoedaDB($dados['valorDesconto']));
        if(!$planoModel->verificarExiste($this->conn)){
            $this->conn->beginTransaction();
            if($planoModel->gravar($this->conn,$dados['atividadesFisicas']))
            {
                $this->conn->commit();
                $retorno = ["status" => true, "icon" => "success", "message" => "Registro gravado com sucesso"];
            }else{
                $this->conn->rollBack();
            }
        }else{
            $retorno = ["status" => false, "icon" => "info", "message" => "Já existe um plano com essa descrição"];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }
}