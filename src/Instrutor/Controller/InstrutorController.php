<?php

namespace App\Instrutor\Controller;

use App\Instrutor\Model\Instrutor;
use App\Usuario\Model\Usuario;
use App\Utils\AbstractSlimController;
use App\Utils\Moeda;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class InstrutorController extends AbstractSlimController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function list(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "info", "message" => "Nao ha nenhum registro."];
        $model = new Instrutor(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
        $instrutores = $model->obterTodosInstrutores($this->conn);
        if($instrutores){
            $retorno = ["status" => true, "resultSet" => $instrutores];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function index(Request $request,Response $response, array $args)
    {
        return $this->view->render($response, "/Instrutor/View/index.php");
    }

    private function dateBRtoUS($data)
    {
        $us = explode("/",$data);
        return $us[2]."-".$us[1]."-".$us[0];
    }

    public function delete(Request $request,Response $response,array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel deletar registro de instrutor."];
        try{
            $dados = $request->getParsedBody();
            $instrutor = new Instrutor($dados['idInstrutor'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            $this->conn->beginTransaction();
            if($instrutor->deletarUsuario($this->conn) && $instrutor->deletar($this->conn))
            {
                $this->conn->commit();
                $retorno = ["status" => true, "icon" => "success", "message" => "Registro de instrutor deletado com sucesso"];
            }else{
                $this->conn->rollBack();
            }
        }catch (\Exception $e)
        {
            $this->conn->rollBack();
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function update(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel atualizar registro de instrutor."];
        $dados = $request->getParsedBody();
        $senha = hash("sha512",$dados['ModalSenha']);
        $instrutor = new Instrutor($dados['ModalIdInstrutor'],$dados['ModalNome'],Moeda::MoedaDB($dados['ModalSalario']),$dados['ModalDataNascimento'],$dados['ModalSexo'],$dados['ModalEstadoCivil'],$dados['ModalRua'],$dados['ModalNrCasa'],$dados['ModalBairro'],$dados['ModalCidade'],$dados['ModalEstado'],$dados['ModalPais'],$dados['ModalCep'],$dados['ModalContato'],$dados['ModalEmail'],$dados['ModalRG'],$dados['ModalCPF'],$dados['ModalDataAdmissao'],$dados['ModalDataDemissao']);
        $this->conn->beginTransaction();
        try{
            if($instrutor->atualizarUsuario($this->conn,$senha))
            {
                if($instrutor->atualizar($this->conn))
                {
                    $this->conn->commit();
                    $retorno = ["status" => true, "icon" => "success", "message" => "Registro de instrutor atualizado com sucesso."];
                }
                else{
                    $this->conn->rollBack();
                }
            }
            else{
                $this->conn->rollBack();
            }
        }catch (\PDOException $e)
        {
            $this->conn->rollBack();
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function store(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel gravar registro de instrutor."];
        $dados = $request->getParsedBody();
        $senha = hash("sha512",$dados['senha']);
        $instrutor = new Instrutor(null,$dados['nome'],Moeda::MoedaDB($dados['salario']),$dados['dataNascimento'],$dados['sexo'],$dados['estadoCivil'],$dados['rua'],$dados['nrcasa'],$dados['bairro'],$dados['cidade'],$dados['estado'],$dados['pais'],$dados['cep'],$dados['contato'],$dados['email'],$dados['rg'],$dados['cpf'],$dados['dataAdmissao'],$dados['dataDemissao']);
        $instrutor->obterInstrutorPorCPF($this->conn);
        if($instrutor->getIdInstrutor()) // Verifica se o CPF já está cadastrado e trazer o nome do instrutor caso esteja.
        {
            $retorno = ["status" => true, "icon" => "info", "message" => "Instrutor {$instrutor->getNome()} já está cadastrado."];
        }else{
            $emailJaExiste = $instrutor->verificarEmailCadastrado($this->conn);
            if(in_array(true,$emailJaExiste)) {
                if (is_array($emailJaExiste[0])) {
                    $retorno = ["status" => true, "icon" => "info", "message" => "E-mail já existe e pertence ao usuário {$emailJaExiste[0]['nome']}."];
                } else if (is_array($emailJaExiste[1])) {
                    $retorno = ["status" => true, "icon" => "info", "message" => "E-mail já existe e pertence ao usuário {$emailJaExiste[1]['nome']}."];
                } else if (is_array($emailJaExiste[2])) {
                    $retorno = ["status" => true, "icon" => "info", "message" => "E-mail já existe e pertence ao usuário {$emailJaExiste[2]['nome']}."];
                }
            }else{
                $this->conn->beginTransaction();
                $instrutor->gravar($this->conn);
                if($instrutor->getIdInstrutor())
                {
                    $usuario = new Usuario(null,"Instrutor",$instrutor->getEmail(),$senha,date("Y-m-d"),1,null,null,$instrutor);
                    if($usuario->gravar($this->conn))
                    {
                        $this->conn->commit();
                        $retorno = ["status" => true, "icon" => "success", "message" => "Registro de instrutor gravado com sucesso."];
                    }else{
                        $this->conn->rollBack();
                    }
                }
                else{
                    $this->conn->rollBack();
                }
            }

        }

        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }
}