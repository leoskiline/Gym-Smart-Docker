<?php

namespace App\Usuario\Controller;

use App\Administrador\Model\Administrador;
use App\Sistema\Model\Informacoes;
use App\Usuario\Model\Permissoes;
use App\Utils\AbstractSlimController;
use App\Usuario\Model\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\UploadedFile;


class UsuarioController extends AbstractSlimController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function obterAvaliadores(Request $request,Response $response)
    {
        $usuario = new Usuario(null,null,null,null,null,null,null,null,null);
        $response->getBody()->write(json_encode($usuario->obterAvaliadores($this->conn)));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    private function getLogoSistema(UploadedFile $arquivo)
    {
        $caminhoArquivo = "/storage/logos/default.png";
        if(!$arquivo->getError())
        {
            $caminhoArquivo = "/storage/logos/".md5($arquivo->getClientFilename().$arquivo->getSize()).date("YmdHis").".png";
        }
        return $caminhoArquivo;
    }

    public function configuracao(Request $request,Response $response)
    {
        $dados = $request->getParsedBody();
        $arquivo = $request->getUploadedFiles();
        $sistema = new Informacoes(null,$dados['tituloLogin'],$dados['tituloNavbar'],$dados['nomeSistema'],$dados['cnpj'],$dados['contato'],$dados['emailSistema'],$this->getLogoSistema($arquivo['logo']),$dados['sistemaRua'],$dados['sistemaNrcasa'],$dados['sistemaBairro'],$dados['sistemaCidade'],$dados['sistemaEstado'],$dados['sistemaPais'],$dados['sistemaCep']);
        $administrador = new Administrador(null,$dados['nome'],$dados['salario'],$dados['dataNascimento'],$dados['sexo'],$dados['estadoCivil'],$dados['rua'],$dados['nrcasa'],$dados['bairro'],$dados['cidade'],$dados['estado'],$dados['pais'],$dados['cep'],$dados['contatoadm'],$dados['email']);
        $this->conn->beginTransaction();
        if($administrador->gravar($this->conn))
        {
            $usuario = new Usuario(null,"Administrador",$dados['email'],hash("sha512",$dados['senha']),date("Y-m-d"),1,$administrador,null,null);
            if($usuario->gravar($this->conn))
            {
                $sistema->gravarInformacoesSistema($this->conn);
                if($sistema->getIdInformacoesSistema() && $usuario->getIdUsuario() && $administrador->getIdAdministrador())
                {
                    $this->conn->commit();
                    if(!$arquivo['logo']->getError())
                        $arquivo['logo']->moveTo(__DIR__."/../../..".$sistema->getLogo());
                    $response->getBody()->write(json_encode(["status" => true, "icon" => "success", "message" => "Configuracao Efetuada com Sucesso."]));
                    return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
                }
            }
        }
        $this->conn->rollBack();
        $response->getBody()->write(json_encode(["status" => false, "icon" => "error", "message" => "Náo foi possivel fazer a Configuração."]));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function index(Request $request,Response $response,array $args)
    {
        $sistema = new Informacoes(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
        $informacoes = $sistema->obterInformacoesSistema($this->conn);
        if($informacoes)
        {
            $sistema->setIdInformacoesSistema($informacoes['idInformacoes_Sistema']);
            $sistema->setTituloLogin($informacoes['tituloLogin']);
            $sistema->setTituloNavbar($informacoes['tituloNavbar']);
            $sistema->setNomeSistema($informacoes['nomeSistema']);
            $sistema->setCnpj($informacoes['cnpj']);
            $sistema->setEmail($informacoes['email']);
            $sistema->setContato($informacoes['contato']);
            $sistema->setLogo($informacoes['logo']);
            $sistema->setRua($informacoes['rua']);
            $sistema->setNrcasa($informacoes['nrcasa']);
            $sistema->setBairro($informacoes['bairro']);
            $sistema->setCidade($informacoes['cidade']);
            $sistema->setUf($informacoes['uf']);
            $sistema->setPais($informacoes['pais']);
            $sistema->setCep($informacoes['cep']);
            $_SESSION['informacoesSistema'] = $sistema;
            return $this->view->render($response,"/Usuario/View/login.php");
        }
        else{
            return $this->view->render($response,"/Usuario/View/configuracao.php");
        }
    }

    public function logout(Request $request,Response $response)
    {
        session_destroy();
        return $response->withHeader("Location","/")->withStatus(302);
    }

    public function login(Request $request,Response $response,array $args)
    {
        $dados = $request->getParsedBody();
        $usuario = new Usuario(null,null,$dados['email'],hash("sha512",$dados['senha']),null,null,null,null,null);
        $usuario->getUsuarioLogin($this->conn);
        if($usuario->getIdUsuario())
        {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['permissoes'] = Permissoes::getPermissions();
            $response->getBody()->write(json_encode(["status" => true, "icon" => "success", "message" => "Logado com sucesso."]));
            return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
        }
        else{
            $_SESSION['usuario'] = null;
            $_SESSION['permissoes'] = null;
                $response->getBody()->write(json_encode(["status" => false, "icon" => "error", "message" => "Usuario e/ou senha inválidos."]));
            return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
        }
    }
}