<?php

namespace App\Administrador\Controller;

use App\Administrador\Model\Administrador;
use App\Usuario\Model\Usuario;
use App\Utils\AbstractSlimController;
use App\Utils\Moeda;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AdministradorController extends AbstractSlimController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function delete(Request $request,Response $response,array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Não foi possivel deletar"];
        $dados = $request->getParsedBody();
        try {
            if(!empty($dados['idAdministrador']))
            {
                $administrador = new Administrador($dados['idAdministrador'],null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                $administrador->obterAdministradorById($this->conn);
                $usuario = new Usuario(null,null,null,null,null,null,$administrador,null,null);
                $this->conn->beginTransaction();
                if($usuario->deletarByIdAdministrador($this->conn) && $administrador->deletarById($this->conn))
                {
                    $retorno = ["status" => true, "icon" => "success", "message" => "Deletado com sucesso."];
                    $this->conn->commit();
                }
                else{
                    $this->conn->rollBack();
                }
            }else{
                $retorno = ["status" => false, "icon" => "error", "message" => "Administrador não informado"];
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
            $model = new Administrador(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            $administradores = $model->obterTodosAdministradores($this->conn);
            if($administradores){
                $retorno = ["status" => true, "resultSet" => $administradores];
            }
        }catch(\PDOException $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function index(Request $request,Response $response, array $args)
    {
        return $this->view->render($response, "/Administrador/View/index.php");
    }

    private function dateBRtoUS($data)
    {
        $us = explode("/",$data);
        return $us[2]."-".$us[1]."-".$us[0];
    }

    public function update(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel atualizar registro de administrador."];
        $administrador = $request->getParsedBody();
        $senha = hash("sha512",$administrador['ModalSenha']);
        $model = new Administrador($administrador['ModalIdAdministrador'],$administrador['ModalNome'],Moeda::MoedaDB($administrador['ModalSalario']),$administrador['ModalDataNascimento'],$administrador['ModalSexo'],$administrador['ModalEstadoCivil'],$administrador['ModalRua'],$administrador['ModalNrCasa'],$administrador['ModalBairro'],$administrador['ModalCidade'],$administrador['ModalEstado'],$administrador['ModalPais'],$administrador['ModalCep'],$administrador['ModalContato'],$administrador['ModalEmail']);
        $this->conn->beginTransaction();
        try{
            if($model->atualizarUsuario($this->conn,$senha))
            {
                if($model->atualizarAdministrador($this->conn))
                {
                    $this->conn->commit();
                    $retorno = ["status" => true, "icon" => "success", "message" => "Registro de administrador atualizado com sucesso."];
                }
                else{
                    $this->conn->rollBack();
                }
            }else{
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
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel gravar registro de administrador."];
        $administrador = $request->getParsedBody();
        $senha = hash("sha512",$administrador['senha']);
        $model = new Administrador(null,$administrador['nome'],Moeda::MoedaDB($administrador['salario']),$administrador['dataNascimento'],$administrador['sexo'],$administrador['estadoCivil'],$administrador['rua'],$administrador['nrcasa'],$administrador['bairro'],$administrador['cidade'],$administrador['estado'],$administrador['pais'],$administrador['cep'],$administrador['contato'],$administrador['email']);
        $this->conn->beginTransaction();
        try{
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
            }
            else{
                $idAdministrador = $model->gravarAdministrador($this->conn);
                if($idAdministrador)
                {
                    $model->setIdAdministrador($idAdministrador);
                    if($model->gravarUsuario($this->conn,$senha))
                    {
                        $this->conn->commit();
                        $retorno = ["status" => true, "icon" => "success", "message" => "Registro de administrador gravado com sucesso."];
                    }
                    else {
                        $this->conn->rollBack();
                    }
                }
            }
        }catch(\PDOException $e)
        {
            $this->conn->rollBack();
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }
}