<?php

namespace App\AvaliacaoFisica\Controller;

use App\AgendamentoAvaliacao\Model\AgendamentoAvaliacao;
use App\AvaliacaoFisica\Model\AvaliacaoFisica;
use App\Contrato\Model\Contrato;
use App\Sistema\Model\Informacoes;
use App\Utils\AbstractSlimController;
use App\Utils\Moeda;
use App\Utils\MYPDF;
use App\Utils\ObjectHelper;
use Dompdf\Dompdf;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AvaliacaoFisicaController extends AbstractSlimController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function gerarPDF(Request $request,Response $response, array $args)
    {
        try{
            $dados = $request->getQueryParams();
            if(!empty($dados['idAvaliacaoFisica']))
            {
                $avaliacao = new AvaliacaoFisica($dados['idAvaliacaoFisica'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                $avaliacao->obterAvaliacaoPorId($this->conn);
                if($avaliacao->getIdAvaliacaoFisica()) {
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
                    $pdf->setTitle($_SESSION['informacoesSistema']->getNomeSistema() . " - Avaliação Física");
                    $pdf->SetSubject('TCPDF Tutorial');
                    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
                    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                    $pdf->SetFont('times', 'BI', 12);
                    $pdf->AddPage();
//                    $avaliacao = ObjectHelper::dismount($avaliacao);
                    $txt = <<<EOD
                        <div>
                            <div style="text-align: center"><h2>Ficha Técnica</h2></div>
                            <hr>
                            <div>
                                <label for="detalheAnamnese">Nível de Aptidão Física</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getNivelaptidaofisica()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalheBancoWells">Peso</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getPeso()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalhedesviopostura">Altura</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getAltura()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalhedobrascutaneas">Dores</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getDores()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalhedores">Histórico de Saúde</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getHistoricosaude()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalheflexibilidades">Desvios e Postura</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getDesviospostura()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalhemetas">Percentual de Gordura</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getPercentualgordura()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalhepafc">Percentual de Massa Magra</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getPercentualmassamagra()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalheparq">Metas</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getMetas()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalhepesoaltura">Objetivo</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getObjetivo()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalhepesoosseo">Hábitos Alimentares</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getHabitosalimentares()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalherepeticaomaxima">Qualidade do Sono</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getQualidadesono()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalheresistenciamuscular">Bebida Alcoólica</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getBebidaalcoolica()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalhevo2">Fumante</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getFumante()}</div>
                            </div>
                            <hr>
                            <div>
                                <label for="detalhevo2">Medicamentos</label>
                                <div style="word-wrap: break-word;font-weight: normal;">{$avaliacao->getMedicamentos()}</div>
                            </div>
                        </div>
            EOD;
                    $nomeArquivo = "AvaliaçãoFísica".str_replace(" ","",$avaliacao->getIdAgendamentoAvaliacaoFisica()->getTitle());
                    $pdf->writeHTML($txt);
                    $pdf->Output($nomeArquivo, 'I');
                }

            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write("ERROR");
        return $response->withHeader("Content-Type","text/html")->withStatus(200);
    }

    public function list(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false];
        try{
            $avaliacaoFisica = new AvaliacaoFisica(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            $params = $request->getQueryParams();
            $avaliacoesFisicas = $avaliacaoFisica->obterAvaliacoesFisicas($this->conn,$params);
            if(!empty($avaliacoesFisicas))
            {
                $retorno = ["status" => true, "resultSet" => $avaliacoesFisicas];
            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possível salvar avaliação física."];
        try{
            $dados = $request->getParsedBody();
            $agendamento = new AgendamentoAvaliacao($dados['agendamentoAvaliacao'],null,null,null,null,null,null,null,null,null,null);
            $agendamento->obterAgendamentoPorId($this->conn);
            if($agendamento->getIdAgendamentoAvaliacaoFisica())
            {
                $avaliacaoFisica = new AvaliacaoFisica(null,$agendamento,$dados['nivelaptidaofisica'],$dados['peso'],$dados['altura'],$dados['dores'],$dados['historicosaude'],$dados['desviospostura'],$dados['percentualgordura'],$dados['percentualmassamagra'],$dados['metas'],$dados['objetivo'],$dados['habitosalimentares'],$dados['qualidadesono'],$dados['bebidaalcoolica'],$dados['fumante'],$dados['medicamentos']);
                if($avaliacaoFisica->gravar($this->conn))
                {
                    $retorno = ["status" => true, "icon" => "success", "message" => "Avaliação Física salva com sucesso!"];
                }
            }else{
                $retorno = ["status" => false, "icon" => "error", "message" => "Agendamento de avaliação física não informado."];
            }

        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function ObterAgendamentosHoje(Request $request,Response $response,array $args)
    {
        $retorno = ["status" => false, "icon" => "info", "message" => "Nao ha nenhum registro."];
        try{
            $agendamentos = new AgendamentoAvaliacao(null,null,null,null,null,null,null,null,null,null,null);
            $agendamentosDiaAtual = $agendamentos->obterTodosAgendamentosDiaAtual($this->conn);
            if(!empty($agendamentosDiaAtual))
            {
                $retorno = ["status" => true, "resultSet" => $agendamentosDiaAtual];
            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function index(Request $request,Response $response, array $args)
    {
        return $this->view->render($response, "/AvaliacaoFisica/View/index.php");
    }
}

