<?php

namespace App\Contrato\Controller;

use App\Aluno\Model\Aluno;
use App\Contrato\Model\Contrato;
use App\Contrato\Model\FormaPagamento;
use App\Mensalidade\Model\Mensalidade;
use App\Mensalidade\Model\MensalidadeAtraso;
use App\Planos\Model\Plano;
use App\Receita\Model\Receita;
use App\Utils\AbstractSlimController;
use App\Utils\Moeda;
use App\Utils\MYPDF;
use App\Utils\ObjectHelper;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ContratoController extends AbstractSlimController
{

    public function __construct()
    {
        parent::__construct();
    }


    public function report(Request $request,Response $response,array $args)
    {
        $retorno = "Não há contratos para o periodo informado";
        try{
            $dados = $request->getQueryParams();
            if(empty($dados['dataInicial']) && empty($dados['dataFinal']))
            {
                $retorno = "Parametros Invalidos";
            }else{
                $contratoModel = new Contrato(null,null,null,null,$dados['dataInicial'],$dados['dataFinal'],null,null,null,null);
                $contratos = $contratoModel->obterTodosContratosPeriodo($this->conn);
                $dataInicial = date("d/m/Y",strtotime($dados['dataInicial']));
                $dataFinal = date("d/m/Y",strtotime($dados['dataFinal']));
                if(!empty($contratos))
                {
                    if (!empty($_SESSION['usuario']->getAdministrador())) {
                        $nomeUsuario = $_SESSION['usuario']->getAdministrador()->getNome();
                    } else if (!empty($_SESSION['usuario']->getInstrutor())) {
                        $nomeUsuario = $_SESSION['usuario']->getInstrutor()->getNome();
                    } else if (!empty($_SESSION['usuario']->getProfessor())) {
                        $nomeUsuario = $_SESSION['usuario']->getProfessor()->getNome();
                    }
                    $pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
                    $pdf->setEmitidoPor($nomeUsuario);
                    $pdf->setCreator($_SESSION['informacoesSistema']->getNomeSistema());
                    $pdf->setAuthor($nomeUsuario);
                    $pdf->setTitle($_SESSION['informacoesSistema']->getNomeSistema() . " - Contratos");
                    $pdf->SetSubject('TCPDF Tutorial');
                    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
                    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                    $pdf->AddPage();
                    $pdf->SetFont('helvetica', '', 10);
                    $pdf->writeHTML("<h2>Relatório de Contratos por Periodo ({$dataInicial}) à ({$dataFinal})</h2>",true,false,false,false,'C');
                    $pdf->Ln(2);
                    $nomeArquivo = "RelatorioContratosPeriodo.pdf";
                    $trows = "";
                    foreach ($contratos as $contrato)
                    {
                        $trows .= <<<EOD
                                        <tr>
                                            <td align="center">{$contrato['codigoContrato']}</td>
                                            <td>{$contrato['nomeAluno']}</td>
                                            <td>{$contrato['plano']}</td>
                                            <td align="center">{$contrato['formaPagamento']}</td>
                                            <td align="center">{$contrato['dataInicio']}</td>
                                            <td align="center">{$contrato['dataFim']}</td>
                                            <td align="center">{$contrato['dataContrato']}</td>
                                            <td align="center">{$contrato['ativo']}</td>
                                            <td align="center">{$contrato['dataCancelamento']}</td>
                                            <td align="center">{$contrato['valorMensalidade']}</td>
                                            <td align="center">{$contrato['diaPagamento']}</td>
                                        </tr>
                                    EOD;

                    }
                    $txt = <<<EOD
                                <table border="1" cellspacing="0" cellpadding="2" >
                                    <thead>
                                        <tr>
                                            <th align="center">Código do Contrato</th>
                                            <th align="center">Nome do Aluno</th>
                                            <th align="center">Plano</th>
                                            <th align="center">Forma de Pagamento</th>
                                            <th align="center">Data de Inicio</th>
                                            <th align="center">Data de Fim</th>
                                            <th align="center">Data do Contrato</th>
                                            <th align="center">Ativo</th>
                                            <th align="center">Data de Cancelamento</th>
                                            <th align="center">Valor Mensalidade</th>
                                            <th align="center">Dia de Pagamento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$trows}
                                    </tbody>
                                </table>
                            EOD;
                    $pdf->SetFont('helvetica', '', 8);
                    $pdf->writeHTML($txt);
                    $pdf->Output($nomeArquivo, 'I');
                }
            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write($retorno);
        return $response;
    }

    public function VerificarMensalidadeCronologica(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false];
        try{
            $dados = $request->getParsedBody();
            $mensalidade = new Mensalidade($dados['idMensalidade'],null,null,null,null,null,null);
            $mensalidade->obterMensalidadePorId($this->conn);
            if($mensalidade->getIdMensalidade())
            {
                if($mensalidade->verificarMensalidadesAnterioresNaoPagas($this->conn))
                {
                    $retorno = ['status' => true];
                }
            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function estornoMensalidade(Request $request, Response $response, array $args)
    {
        $retorno = ['status' => false, "icon" => "error", "message" => "Não foi possivel estornar mensalidade"];
        try{
            $dados = $request->getParsedBody();
            $mensalidade = new Mensalidade($dados['idMensalidade'],null,null,null,null,null,null);
            $this->conn->beginTransaction();
            if($mensalidade->estornar($this->conn))
            {
                $receita = new Receita(null,null,null,null,$mensalidade->getIdMensalidade(),null);
                if($receita->deletarByMensalidade($this->conn)){
                    $this->conn->commit();
                    $retorno = ['status' => true, "icon" => "success", "message" => "Mensalidade estornada com sucesso!"];
                }

            }
        }catch (\PDOException $e)
        {
            $this->conn->rollBack();
        }
        catch (\Exception $e)
        {
            $this->conn->rollBack();
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function alterarDiaPagamento(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false, "icon" => "error", "message" => "Não foi possivel alterar dia de pagamento"];
        try {
            $dados = $request->getParsedBody();
            $contrato = new Contrato($dados['idContrato'],null,null,null,null,null,null,null,null,null);
            $contrato->obterContratoById($this->conn);
            $contrato->setDiaPagamento($dados['diaPagamento']);
            $this->conn->beginTransaction();
            if($contrato->alterarDiaPagamento($this->conn))
            {
                $this->conn->commit();
                $retorno = ['status' => true, "icon" => "success", "message" => "Dia de Pagamento Alterado com Sucesso!"];
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

    public function pagamentoMensalidade(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false, "icon" => "error", "message" => "Não foi possivel efetuar o pagamento"];
        try{
            $dados = $request->getParsedBody();
            $mensalidade = new Mensalidade($dados['idMensalidade'],null,null,null,null,null,null);
            $mensalidade->obterMensalidadePorId($this->conn);
            $formaPagamento = new FormaPagamento($dados['idFormaPagamento'],null,null);
            $formaPagamento->obterFormaPagamentoPorId($this->conn);
            $this->conn->beginTransaction();
            $mensalidade->setFormaPagamento($formaPagamento);
            if($mensalidade->efetuarPagamento($this->conn))
            {
                $receita = new Receita(null,"Pagamento de Mensalidade",date("Y-m-d"),$mensalidade->getValor(),$mensalidade->getIdMensalidade(),null);
                if($receita->gerarReceitaPagamentoMensalidade($this->conn)){
                    $mensalidadeAtraso = new MensalidadeAtraso(null,null,$mensalidade->getIdMensalidade());
                    $mensalidadeAtraso->apagarMensalidadeAtraso($this->conn);
                    $this->conn->commit();
                    $retorno = ['status' => true, "icon" => "success", "message" => "Pagamento Efetuado com Sucesso!"];
                }
            }
        }catch (\PDOException $e)
        {
            $this->conn->rollBack();
        }catch (\Exception $e)
        {
            $this->conn->rollBack();
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function obterMensalidades(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false];
        try{
            $dados = $request->getParsedBody();
            $plano = new Plano($dados['plano']['idPlano'],$dados['plano']['descricao'],$dados['plano']['idTipoPlano'],Moeda::MoedaDB($dados['plano']['valorPadrao']),$dados['plano']['percentualDesconto'],$dados['plano']['valorComDesconto']);
            $aluno = new Aluno($dados['aluno']['idAluno'],$dados['aluno']['idUsuario'],$dados['aluno']['nome'],$dados['aluno']['dataNascimento'],$dados['aluno']['sexo'],$dados['aluno']['estadoCivil'],$dados['aluno']['rua'],$dados['aluno']['nrcasa'],$dados['aluno']['bairro'],$dados['aluno']['cidade'],$dados['aluno']['uf'],$dados['aluno']['pais'],$dados['aluno']['cep'],$dados['aluno']['contato'],$dados['aluno']['email'],$dados['aluno']['cpf']);
            $formaPagamento = new FormaPagamento($dados['formaPagamento']['idFormaPagamento'],$dados['formaPagamento']['descricao'],$dados['formaPagamento']['pagamentoAutomatico']);
            $contrato = new Contrato($dados['idContrato'],$plano,$aluno,$formaPagamento,$dados['dataInicio'],$dados['dataFim'],$dados['dataContrato'],$dados['dataCancelamento'],Moeda::MoedaDB($dados['valor']),$dados['diaPagamento']);
            $mensalidade = new Mensalidade(null,$contrato,$formaPagamento,null,null,null,null);
            $mensalidades = $mensalidade->obterTodasMensalidadesPorContrato($this->conn);
            if(!empty($mensalidades))
            {
                $mensalidades = ObjectHelper::dismount($mensalidades);
                $retorno = ['status' => true, "resultSet" => $mensalidades];
            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function index(Request $request,Response $response,array $args)
    {
        return $this->view->render($response,"/Contrato/View/index.php");
    }

    public function formasPagamento(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false];
        $formasPagamento = new FormaPagamento(null,null,null);
        $formasPagamentos = $formasPagamento->obterTodasFormasPagamento($this->conn);
        if(!empty($formasPagamentos))
        {
            $retorno = ['status' => true, "resultSet" => $formasPagamentos];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function cancel(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false, "icon" => 'error' , "message" => "Não foi possível cancelar"];
        $dados = $request->getParsedBody();
        $this->conn->beginTransaction();
        try{
            $contrato = new Contrato($dados['idContrato'],null,null,null,null,null,null,null,null,null);
            $contrato->obterContratoById($this->conn);
            $mensalidade = new Mensalidade(null,$contrato,null,null,null,null,null);
            $mensalidadesCanceladas = $mensalidade->cancelar($this->conn);
            $contratoCancelado = $contrato->cancelar($this->conn);
            if($mensalidadesCanceladas || $contratoCancelado)
            {
                $retorno = ['status' => true, "icon" => 'success' , "message" => "Cancelamento efetuado com sucesso."];
                $this->conn->commit();
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

    public function list(Request $request,Response $response,array $args)
    {
        $retorno = false;
        try{
            $params = $request->getQueryParams();
            $atraso = false;
            if(!empty($params['atraso']))
                $atraso = true;
            $contrato = new Contrato(null,null,null,null,null,null,null,null,null,null);
            $retorno = $contrato->obterTodosContratos($this->conn,$atraso);
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function store(Request $request,Response $response,array $args)
    {
        $dados = $request->getParsedBody();
        try{
            $aluno = new Aluno($dados['aluno'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            $aluno->obterAlunoPorId($this->conn);
            $plano = new Plano($dados['plano'],null,null,null,null,null);
            $plano->obterPlanoPorId($this->conn);
            $formaPagamento = new FormaPagamento($dados['formasPagamento'],null,null);
            $formaPagamento->obterFormaPagamentoPorId($this->conn);
            $contrato = new Contrato(null,$plano,$aluno,$formaPagamento,$dados['dataInicial'],$dados['dataFinal'],$dados['dataContrato'],null,$plano->getValorComDesconto(),$dados['diaPagamento']);
            $retorno = ["status" => false, "icon" => "error", "message" => "Não foi possível gravar registro"];
            $this->conn->beginTransaction();
            if($contrato->obterContratosPorAluno($this->conn)){
                $retorno = ["status" => false, "icon" => "info", "message" => "Este aluno já possui um contrato ativo."];
            }
            else if($contrato->gravar($this->conn))
            {
                $dataInicial = date_create($contrato->getDataInicio());
                $dataFinal = date_create($contrato->getDataFim());
                $intervalo = date_diff($dataInicial, $dataFinal);
                $mesesGerarMensalidade = intval(floor($intervalo->days / 30));
                $dataMensalidade = date_create(substr($contrato->getDataInicio(),0,8).$contrato->getDiaPagamento());
                $mensalidadesGeradas = [];
                for($i = 0;$i < $mesesGerarMensalidade;$i++)
                {
                    $mensalidade = new Mensalidade(null,$contrato,$formaPagamento,$plano->getValorComDesconto(),null,null,null);
                    if($i == 0)
                    {
                        $dataMensalidade = new \DateTime("NOW");
                        $mensalidade->setDataMensalidade($dataMensalidade->format("Y-m-d"));
                        $mensalidade->setDataPagamento($dataMensalidade->format("Y-m-d"));

                    }
                    else{
                        date_add($dataMensalidade,date_interval_create_from_date_string("1 month"));
                        $mensalidade->setDataMensalidade(substr($dataMensalidade->format("Y-m-d"),0,8).$contrato->getDiaPagamento());
                    }
                    if($mensalidade->gravar($this->conn))
                    {
                        if($i == 0)
                        {
                            $receita = new Receita(null,"Pagamento de Mensalidade",$mensalidade->getDataPagamento(),$mensalidade->getValor(),$mensalidade->getIdMensalidade(),null);
                            $receita->gerarReceitaPagamentoMensalidade($this->conn);
                        }
                        $mensalidadesGeradas[] = $mensalidade;
                    }
                }
                if(!in_array(false,$mensalidadesGeradas))
                {

                    $codContrato = str_pad($contrato->getIdContrato(),6,"0",STR_PAD_LEFT);
                    if(count($mensalidadesGeradas) > 1)
                    {
                        $primeiroVencimento = date("d/m/Y",strtotime($mensalidadesGeradas[1]->getDataMensalidade()));
                        $valorPrimeiraMensalidade = Moeda::MoedaBR($mensalidadesGeradas[1]->getValor());
                        $retorno = ["status" => true, "icon" => "success", "message" => "Contrato Nº: {$codContrato} gerado com sucesso. O proximo vencimento é dia {$primeiroVencimento} no valor de R$ {$valorPrimeiraMensalidade}"];
                    }
                    else{
                        $valorPrimeiraMensalidade = Moeda::MoedaBR($mensalidade->getValor());
                        $retorno = ["status" => true, "icon" => "success", "message" => "Contrato Nº: {$codContrato} gerado com sucesso. Pagamento da Mensalidade efetuado com sucesso no valor de {$valorPrimeiraMensalidade}!"];
                    }
                    $this->conn->commit();
                }
                else{
                    $this->conn->rollBack();
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