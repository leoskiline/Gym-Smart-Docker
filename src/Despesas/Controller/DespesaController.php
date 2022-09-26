<?php

namespace App\Despesas\Controller;

use App\Despesas\Model\Despesa;
use App\Fornecedor\Model\Fornecedor;
use App\Receita\Model\Receita;
use App\Utils\AbstractSlimController;
use App\Utils\Moeda;
use App\Utils\MYPDF;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DespesaController extends AbstractSlimController
{
        public function __construct()
        {
            parent::__construct();
        }

    public function report(Request $request,Response $response,array $args)
    {
        $retorno = "Nenhum dado a ser exportado";
        try{
            $dados = $request->getQueryParams();
            if(empty($dados['dataInicial']) && empty($dados['dataFinal']))
            {
                $retorno = "Parametros Inválidos";
            }else{
                $despesa = new Despesa(null,null,null,null,null,null,null,null,null);
                $despesasReceitas = $despesa->obterTodosPeriodo($this->conn,$dados);
                $somaDespesas = floatval($despesa->obterSomaDespesasPeriodo($this->conn,$dados));
                $somaReceitas = floatval($despesa->obterSomaReceitasPeriodo($this->conn,$dados));
                $valor = $somaReceitas - $somaDespesas;
                $somaDespesas = Moeda::MoedaBR($somaDespesas);
                $somaReceitas = Moeda::MoedaBR($somaReceitas);
                $valor = Moeda::MoedaBR($valor);
                $dataInicial = date("d/m/Y",strtotime($dados['dataInicial']));
                $dataFinal = date("d/m/Y",strtotime($dados['dataFinal']));
                if(!empty($despesasReceitas))
                {
                    if (!empty($_SESSION['usuario']->getAdministrador())) {
                        $nomeUsuario = $_SESSION['usuario']->getAdministrador()->getNome();
                    } else if (!empty($_SESSION['usuario']->getInstrutor())) {
                        $nomeUsuario = $_SESSION['usuario']->getInstrutor()->getNome();
                    } else if (!empty($_SESSION['usuario']->getProfessor())) {
                        $nomeUsuario = $_SESSION['usuario']->getProfessor()->getNome();
                    }
                    $pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
                    $pdf->setEmitidoPor($nomeUsuario);
                    $pdf->setCreator($_SESSION['informacoesSistema']->getNomeSistema());
                    $pdf->setAuthor($nomeUsuario);
                    $pdf->setTitle($_SESSION['informacoesSistema']->getNomeSistema() . " - Despesas/Receitas");
                    $pdf->SetSubject('TCPDF Tutorial');
                    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
                    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                    $pdf->AddPage();
                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->writeHTML("<h2>Relatório de Despesas/Receitas por Periodo ({$dataInicial}) à ({$dataFinal})</h2>",true,false,false,false,'C');
                    $pdf->writeHTML("<span><b>Total de Receita:</b> R$ {$somaReceitas}</span><br><span><b>Total de Despesa:</b> R$ {$somaDespesas}</span><br><span><b>Total:</b> R$ {$valor}</span>",true,false,false,false,'R');
                    $pdf->Ln(2);
                    $nomeArquivo = "RelatorioDespesasReceita.pdf";
                    $trows = "";
                    foreach ($despesasReceitas as $dr)
                    {
                        $trows .= <<<EOD
                                        <tr>
                                            <td align="center">{$dr['tipo']}</td>
                                            <td align="center">{$dr['descricao']}</td>
                                            <td align="center">{$dr['data']}</td>
                                            <td align="center">{$dr['valor']}</td>
                                            <td align="center">{$dr['operacao']}</td>
                                        </tr>
                                    EOD;

                    }
                    $txt = <<<EOD
                                <table border="1" cellspacing="0" cellpadding="2" >
                                    <thead>
                                        <tr>
                                            <th align="center">TIPO</th>
                                            <th align="center">DESCRIÇÃO</th>
                                            <th align="center">DATA</th>
                                            <th align="center">VALOR</th>
                                            <th align="center">OPERAÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {$trows}
                                    </tbody>
                                </table>
                            EOD;
                    $pdf->SetFont('helvetica', '', 7);
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

        public function index(Request $request,Response $response,array $args)
        {
            return $this->view->render($response,"/Despesas/View/index.php");
        }

        public function update(Request $request,Response $response,array $args)
        {
            $retorno = ['status' => false,"icon" => "error", "message" => "Não foi possível atualizar registro."];
            $dados = $request->getParsedBody();
            $fornecedor = new Fornecedor($dados['fornecedorModal'],null,null,null,null,null);
            $fornecedor->obterFornecedorPorID($this->conn);
            $model = new Despesa($dados['idDespesa'],$fornecedor,$_SESSION['usuario'],$dados['descricaoModal'],$dados['tipoModal'],$dados['dataVencimentoModal'],Moeda::MoedaDB($dados['valorPagamentoModal']),$dados['dataPagamentoModal'],Moeda::MoedaDB($dados['valorDespesaModal']));
            if($model->atualizar($this->conn))
            {
                $retorno = ['status' => true,"icon" => "success", "message" => "Registro atualizado com sucesso."];
            }
            $response->getBody()->write(json_encode($retorno));
            return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
        }

        public function store(Request $request,Response $response,array $args)
        {
            $retorno = ['status' => false,"icon" => "error", "message" => "Não foi possível gravar registro."];
            $dados = $request->getParsedBody();
            $fornecedor = new Fornecedor($dados['fornecedor'],null,null,null,null,null);
            $fornecedor->obterFornecedorPorID($this->conn);
            $model = new Despesa(null,$fornecedor,$_SESSION['usuario'],$dados['descricao'],$dados['tipo'],$dados['dataVencimento'],Moeda::MoedaDB($dados['valorPagamento']),$dados['dataPagamento'],Moeda::MoedaDB($dados['valorDespesa']));
            if($model->gravar($this->conn))
            {
                $retorno = ['status' => true,"icon" => "success", "message" => "Despesa cadastrada com sucesso."];
            }
            $response->getBody()->write(json_encode($retorno));
            return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
        }

        public function delete(Request $request,Response $response,array $args)
        {
            $retorno = ['status' => false,"icon" => "error", "message" => "Não foi possível deletar registro."];
            $dados = $request->getParsedBody();
            $model = new Despesa($dados['idDespesa'],null,null,null,null,null,null,null,null);
            if($model->deletar($this->conn))
            {
                $retorno = ['status' => true,"icon" => "success", "message" => "Registro deletado com sucesso."];
            }
            $response->getBody()->write(json_encode($retorno));
            return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
        }

        public function list(Request $request,Response $response,array $args)
        {
            $retorno = ['status' => false];
            $model = new Despesa(null,null,null,null,null,null,null,null,null);
            $dados = $model->obterTodos($this->conn);
            if(!empty($dados))
            {
                $retorno = ['status' => true,"resultSet" => $dados];
            }
            $response->getBody()->write(json_encode($retorno));
            return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
        }
}