<?php

namespace App\Aluno\Controller;

use App\Aluno\Model\Aluno;
use App\Utils\AbstractSlimController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AlunoController extends AbstractSlimController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function list(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => true, "icon" => "info", "message" => "Nao ha nenhum registro."];
        $model = new Aluno(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
        $alunos = $model->obterTodosAlunos($this->conn);
        if($alunos){
            $retorno = ["status" => true, "resultSet" => $alunos];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function delete(Request $request,Response $response)
    {
        $retorno = ['status' => false, 'icon' => 'error', 'message' => 'Parametros incorretos'];
        $model = new Aluno($request->getParsedBody()['id'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
        if($model->getIdAluno())
        {
            try {
                if($model->deletarAluno($this->conn))
                {
                    $retorno = ['status' => true, 'icon' => 'success', 'message' => "Aluno deletado com sucesso!"];
                }
            }catch (\Exception $e)
            {
                $retorno = ['status' => false, 'icon' => 'error', 'message' => "Não pode deletar aluno, possui vínculo em alguma atividade da academia."];
            }
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function index(Request $request,Response $response, array $args)
    {
        return $this->view->render($response, "/Aluno/View/index.php");
    }

    private function dateBRtoUS($data)
    {
        $us = explode("/",$data);
        return $us[2]."-".$us[1]."-".$us[0];
    }

    public function update(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel atualizar registro de aluno."];
        $aluno = $request->getParsedBody();
        $model = new Aluno($aluno['ModalIdAluno'],$_SESSION['usuario']->getIdUsuario(),$aluno['ModalNome'],$aluno['ModalDataNascimento'],$aluno['ModalSexo'],$aluno['ModalEstadoCivil'],$aluno['ModalRua'],$aluno['ModalNrcasa'],$aluno['ModalBairro'],$aluno['ModalCidade'],$aluno['ModalEstado'],$aluno['ModalPais'],$aluno['ModalCep'],$aluno['ModalContato'],$aluno['ModalEmail'],$aluno['ModalCPF']);
       try{
           $model->obterAlunoPorCPF($this->conn);
           if($model->getIdAluno()) // Verifica se o CPF já está cadastrado e trazer o nome do aluno caso esteja.
           {
               $retorno = ["status" => false, "icon" => "info", "message" => "Aluno {$model->getNome()} já está cadastrado com este cpf."];
           }else{
               $model->setIdAluno($aluno['ModalIdAluno']);
               $model->obterAlunoPorEmail($this->conn);
               if(!$model->getIdAluno())
               {
                   $model->setIdAluno($aluno['ModalIdAluno']);
                   if($model->atualizarAluno($this->conn))
                   {
                       $retorno = ["status" => true, "icon" => "success", "message" => "Registro de aluno atualizado com sucesso."];
                   }
               }else{
                   $retorno = ["status" => false, "icon" => "info", "message" => "Aluno {$model->getNome()} já está com esse e-mail cadastrado."];
               }
           }
       }catch (\Exception $e)
       {

       }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function store(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel gravar registro de aluno."];
        try{
            $aluno = $request->getParsedBody();
            $model = new Aluno(null,$_SESSION['usuario']->getIdUsuario(),$aluno['nome'],$aluno['dataNascimento'],$aluno['sexo'],$aluno['estadoCivil'],$aluno['rua'],$aluno['nrcasa'],$aluno['bairro'],$aluno['cidade'],$aluno['estado'],$aluno['pais'],$aluno['cep'],$aluno['contato'],$aluno['email'],$aluno['cpf']);
            $model->obterAlunoPorCPF($this->conn);
            if($model->getIdAluno()) // Verifica se o CPF já está cadastrado e trazer o nome do aluno caso esteja.
            {
                $retorno = ["status" => false, "icon" => "info", "message" => "Aluno {$model->getNome()} já está cadastrado com este cpf."];
            }else{
                $model->obterAlunoPorEmail($this->conn);
                if(!$model->getIdAluno())
                {
                    if($model->gravarAluno($this->conn))
                    {
                        $retorno = ["status" => true, "icon" => "success", "message" => "Registro de aluno gravado com sucesso."];
                    }
                }else{
                    $retorno = ["status" => false, "icon" => "info", "message" => "Aluno {$model->getNome()} já está com esse e-mail cadastrado."];
                }
            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }
}