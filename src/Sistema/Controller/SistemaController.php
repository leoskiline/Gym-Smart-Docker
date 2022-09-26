<?php

namespace App\Sistema\Controller;

use App\Sistema\Model\Informacoes;
use App\Utils\AbstractSlimController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class SistemaController extends AbstractSlimController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request,Response $response)
    {
        return $this->view->render($response,"/Sistema/View/index.php");
    }

    public function update(Request $request,Response $response)
    {
        $params = $request->getParsedBody();
        $arquivo = $request->getUploadedFiles()['logo'];
        $informacoes = new Informacoes(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
        $dados = $informacoes->getInformacoesById($params['idInformacoes_Sistema'],$this->conn);
        $retorno = ['status' => false, 'icon' => 'error', 'message' => 'Não  foi possivel obter sistema cadastrado'];
        if($dados)
        {
            $informacoes->setIdInformacoesSistema($params['idInformacoes_Sistema']);
            $informacoes->setTituloLogin($params['tituloLogin']);
            $informacoes->setTituloNavbar($params['tituloNavbar']);
            $informacoes->setNomeSistema($params['nomeSistema']);
            $informacoes->setCnpj($params['cnpj']);
            $informacoes->setContato($params['contato']);
            $informacoes->setEmail($params['emailSistema']);
            $informacoes->setLogo($this->getFileLogo($dados['logo'],$arquivo));
            $informacoes->setRua($params['rua']);
            $informacoes->setNrcasa($params['nrcasa']);
            $informacoes->setBairro($params['bairro']);
            $informacoes->setCidade($params['cidade']);
            $informacoes->setUf($params['estado']);
            $informacoes->setPais($params['pais']);
            $informacoes->setCep($params['cep']);
            if($informacoes->atualizarInformacoesById($this->conn))
            {
                $_SESSION['informacoesSistema'] = $informacoes;
                $retorno = ['status' => true, 'icon' => 'success', 'message' => 'Configurações do Sistema atualizadas com sucesso!'];
            }
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    private function getFileLogo($logo, mixed $arquivo)
    {
        $path = $logo;
        if(!$arquivo->getError())
        {
            if($path != "/storage/logos/default.png")
            {
                unlink(__DIR__."/../../..".$path);
            }
            $novoArquivo = "/storage/logos/".md5($arquivo->getClientFilename().$arquivo->getSize()).date("YmdHis").".png";
            $arquivo->moveTo(__DIR__."/../../..".$novoArquivo);
            $path = $novoArquivo;
        }
        return $path;
    }
}