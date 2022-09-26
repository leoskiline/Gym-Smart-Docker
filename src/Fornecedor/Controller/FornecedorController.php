<?php

namespace App\Fornecedor\Controller;

use App\Fornecedor\Model\Fornecedor;
use App\Utils\AbstractSlimController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class FornecedorController extends AbstractSlimController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function list(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "info", "message" => "Nao ha nenhum registro."];
        try{
            $model = new Fornecedor(null,null,null,null,null);
            $fornecedores = $model->obterTodosFornecedores($this->conn);
            if($fornecedores){
                $retorno = ["status" => true, "resultSet" => $fornecedores];
            }
        }catch(\PDOException $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function index(Request $request,Response $response, array $args)
    {
        return $this->view->render($response, "/Fornecedor/View/index.php");
    }



    public function update(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel atualizar registro de fornecedor."];
        $fornecedor = $request->getParsedBody();
        $model = new Fornecedor($fornecedor['ModalIdFornecedor'],$fornecedor['ModalDescricao'],$fornecedor['ModalContato'],$fornecedor['ModalEmail'],$fornecedor['ModalPessoaContato']);
        try{
            if(!$model->obterFornecedorCadastradoAtualizar($this->conn))
            {
                if($model->atualizarFornecedor($this->conn))
                {
                    $retorno = ["status" => true, "icon" => "success", "message" => "Registro de fornecedor atualizado com sucesso."];
                }
            }else{
                $retorno = ["status" => false, "icon" => "error", "message" => "Fornecedor com esse nome já cadastrado."];
            }

        }catch (\PDOException $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function delete(Request $request,Response $response, array $args){
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel excluir registro de fornecedor."];
        $fornecedor = $request->getParsedBody();
        $model = new Fornecedor($fornecedor['idFornecedor'],null,null,null,null);
        try{
            if($model->excluir($this->conn))
            {
                $retorno = ["status" => true, "icon" => "success", "message" => "Registro de fornecedor excluido com sucesso."];
            }
        }catch (\PDOException $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function store(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel gravar registro de fornecedor."];
        $fornecedor = $request->getParsedBody();
        $model = new Fornecedor(null,$fornecedor['descricao'],$fornecedor['contato'],$fornecedor['email'],$fornecedor['pessoaContato']);
        try{
            $jaExiste = $model->obterFornecedorCadastrado($this->conn);
            if($jaExiste)
            {
                $retorno = ["status" => true, "icon" => "info", "message" => "Fornecedor ja cadastrado."];
            }
            else{
                if($model->gravar($this->conn)) {
                    $retorno = ["status" => true, "icon" => "success", "message" => "Registro de fornecedor gravado com sucesso."];
                }
            }
        }catch(\PDOException $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }
}