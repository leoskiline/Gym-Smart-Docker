<?php

namespace App\Professor\Controller;

use App\Professor\Model\Professor;
use App\Utils\AbstractSlimController;
use App\Utils\Moeda;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ProfessorController extends AbstractSlimController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function list(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "info", "message" => "Nao ha nenhum registro."];
        $professor = new Professor(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
        $professores = $professor->obterTodosProfessores($this->conn);
        if($professores){
            $retorno = ["status" => true, "resultSet" => $professores];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function delete(Request $request,Response $response,array $args)
    {
        $retorno = ["status" => false, "icon" => "info", "message" => "Nao foi possivel apagar registro."];
        try{
            $dados = $request->getParsedBody();
            $professor = new Professor($dados['idProfessor'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            if(!$professor->possuiAgendamento($this->conn)){
                $this->conn->beginTransaction();
                if($professor->deletarUsuario($this->conn) && $professor->deletar($this->conn))
                {
                    $this->conn->commit();
                    $retorno = ["status" => true, "icon" => "success", "message" => "Registro deletado com sucesso."];
                }
                else{
                    $this->conn->rollBack();
                }
            }else{
                $retorno = ["status" => false, "icon" => "info", "message" => "Não foi possivel excluir professor pois possui agendamento de avaliação física vinculada."];
            }

        }catch (\Exception $e)
        {
            $this->conn->rollBack();

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function index(Request $request,Response $response, array $args)
    {
        return $this->view->render($response, "/Professor/View/index.php");
    }

    private function dateBRtoUS($data)
    {
        $us = explode("/",$data);
        return $us[2]."-".$us[1]."-".$us[0];
    }

    public function update(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel atualizar registro de professor."];
        $professor = $request->getParsedBody();
        $senha = hash("sha512",$professor['ModalSenha']);
        $model = new Professor($professor['ModalIdProfessor'],$professor['ModalNome'],Moeda::MoedaDB($professor['ModalSalario']),$professor['ModalDataNascimento'],$professor['ModalSexo'],$professor['ModalEstadoCivil'],$professor['ModalRua'],$professor['ModalNrCasa'],$professor['ModalBairro'],$professor['ModalCidade'],$professor['ModalEstado'],$professor['ModalPais'],$professor['ModalCep'],$professor['ModalContato'],$professor['ModalEmail'],$professor['ModalRG'],$professor['ModalCPF'],$professor['ModalDataAdmissao'],$professor['ModalDataDemissao']);
        $this->conn->beginTransaction();
        try{
            if($model->atualizarUsuario($this->conn,$senha))
            {
                if($model->atualizarProfessor($this->conn))
                {
                    $this->conn->commit();
                    $retorno = ["status" => true, "icon" => "success", "message" => "Registro de professor atualizado com sucesso."];
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
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel gravar registro de professor."];
        $professor = $request->getParsedBody();
        $senha = hash("sha512",$professor['senha']);
        $model = new Professor(null,$professor['nome'],Moeda::MoedaDB($professor['salario']),$professor['dataNascimento'],$professor['sexo'],$professor['estadoCivil'],$professor['rua'],$professor['nrcasa'],$professor['bairro'],$professor['cidade'],$professor['estado'],$professor['pais'],$professor['cep'],$professor['contato'],$professor['email'],$professor['rg'],$professor['cpf'],$professor['dataAdmissao'],$professor['dataDemissao']);
        $this->conn->beginTransaction();
        try{
            $model->obterProfessorPorCPF($this->conn);
            if($model->getIdProfessor()) // Verifica se o CPF já está cadastrado e trazer o nome do professor caso esteja.
            {
                $retorno = ["status" => true, "icon" => "info", "message" => "Professor {$model->getNome()} já está cadastrado com este CPF."];
            }else{
                $emailJaExiste = $model->obtemEmailCadastrado($this->conn);
                if(in_array(true,$emailJaExiste))
                {
                    if(is_array($emailJaExiste[0]))
                    {
                        $retorno = ["status" => true, "icon" => "info", "message" => "E-mail já existe e pertence ao usuário {$emailJaExiste[0]['nome']}."];
                    }
                    else if(is_array($emailJaExiste[1]))
                    {
                        $retorno = ["status" => true, "icon" => "info", "message" => "E-mail já existe e pertence ao usuário {$emailJaExiste[1]['nome']}."];
                    }
                    else if(is_array($emailJaExiste[2]))
                    {
                        $retorno = ["status" => true, "icon" => "info", "message" => "E-mail já existe e pertence ao usuário {$emailJaExiste[2]['nome']}."];
                    }
                }else{
                    $model->gravarProfessor($this->conn);
                    if($model->getIdProfessor())
                    {
                        if($model->gravarUsuario($this->conn,$senha))
                        {
                            $retorno = ["status" => true, "icon" => "success", "message" => "Registro de professor gravado com sucesso."];
                            $this->conn->commit();
                        }
                        else{
                            $this->conn->rollBack();
                        }
                    }
                    else{
                        $this->conn->rollBack();
                    }
                }

            }
        }catch (\PDOException $e)
        {
            $this->conn->rollBack();
        }

        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }
}