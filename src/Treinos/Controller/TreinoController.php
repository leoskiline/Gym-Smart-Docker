<?php

namespace App\Treinos\Controller;

use App\AvaliacaoFisica\Model\AvaliacaoFisica;
use App\Contrato\Model\Contrato;
use App\ExercicioFisico\Model\ExercicioFisico;
use App\ExercicioFisico\Model\GrupoMuscular;
use App\Treinos\Model\Treino;
use App\Utils\AbstractSlimController;
use App\Utils\MYPDF;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class TreinoController extends AbstractSlimController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obterPDF(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false];
        try{
            $dados = $request->getQueryParams();
            if(!empty($dados['idTreino']))
            {
                $treino = new Treino($dados['idTreino'],null,null,null,null,null,null,null,null);
                $exerciciosFisicos = $treino->obterExerciciosPorTreino($this->conn);
                $dadosPessoais = $treino->obterDadosPessoaisPorTreino($this->conn);
                if(!empty($exerciciosFisicos) && !empty($dadosPessoais))
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
                    $pdf->setTitle($_SESSION['informacoesSistema']->getNomeSistema() . " - Treino");
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
                    $informacoesPessoais = <<<EOD
                                                <pre>
                                                <label><b>Informações Pessoais</b></label><br>
                                                <label><b>Aluno:</b></label><span>{$dadosPessoais['aluno']}</span>          <label><b>Treinador:</b></label><span>{$dadosPessoais['treinador']}</span>
                                                <label><b>Avaliação Física:</b></label><span>{$dadosPessoais['avaliacaofisica']}</span>                       <label><b>Plano:</b></label><span>{$dadosPessoais['plano']}</span>                     
                                                </pre>
                                             EOD;
                    $pdf->writeHTML($informacoesPessoais);
                    $pdf->SetFont('helvetica', '', 6);
                    $trows = "";
                    for($i = 0; $i < 4;$i++)
                    {
                        $trows .= <<<EOD
                                             <tr>
                                                <td style="width: 40px"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        EOD;
                    }
                    $dias = <<<EOD
                                    <table cellspacing="0" cellpadding="3" border="1">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">Mês</th>
                                                <th>1</th>
                                                <th>2</th>
                                                <th>3</th>
                                                <th>4</th>
                                                <th>5</th>
                                                <th>6</th>
                                                <th>7</th>
                                                <th>8</th>
                                                <th>9</th>
                                                <th>10</th>
                                                <th>11</th>
                                                <th>12</th>
                                                <th>13</th>
                                                <th>14</th>
                                                <th>15</th>
                                                <th>16</th>
                                                <th>17</th>
                                                <th>18</th>
                                                <th>19</th>
                                                <th>20</th>
                                                <th>21</th>
                                                <th>22</th>
                                                <th>23</th>
                                                <th>24</th>
                                                <th>25</th>
                                                <th>26</th>
                                                <th>27</th>
                                                <th>28</th>
                                                <th>29</th>
                                                <th>30</th>
                                                <th>31</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            {$trows}
                                        </tbody>
                                    </table>
                            EOD;
                    $pdf->writeHTML("<h2>FREQUÊNCIA: MÊS/DIA</h2>",true,false,false,false,'C');
                    $pdf->Ln(2);
                    $pdf->writeHTML($dias);
                    $trows = "";
                    foreach ($exerciciosFisicos as $exs){
                        $trows .= <<<EOD
                                        <tr>
                                            <td>{$exs['dia']}</td>
                                            <td>{$exs['grupomuscular']}</td>
                                            <td>{$exs['exerciciofisico']}</td>
                                            <td>{$exs['series']}</td>
                                            <td>{$exs['repeticoes']}</td>
                                            <td>{$exs['peso']}</td>
                                        </tr>
                                EOD;
                    }
                    $txt = <<<EOD
                             <table cellspacing="0" cellpadding="3" border="1">
                                <thead>
                                    <tr>
                                        <th>Dia</th>
                                        <th>Grupo Muscular</th>
                                        <th>Exercicio Físico</th>
                                        <th>Séries</th>
                                        <th>Repetições</th>
                                        <th>Peso</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    ${trows}
                                </tbody>
                            </table>
                        EOD;
                    $nomeArquivo = "Treino.pdf";
                    $pdf->writeHTML("<h2>TREINO</h2>",true,false,false,false,'C');
                    $pdf->Ln(2);
                    $pdf->writeHTML($txt);
                    $pdf->Output($nomeArquivo, 'I');
                }
            }

        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function obterExercicios(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false];
        try{
            $dados = $request->getQueryParams();
            if(!empty($dados['idTreino']))
            {
                $treino = new Treino($dados['idTreino'],null,null,null,null,null,null,null,null);
                $exerciciosFisicos = $treino->obterExerciciosPorTreino($this->conn);
                if(!empty($exerciciosFisicos))
                {
                    $retorno = ['status' => true, 'resultSet' => $exerciciosFisicos];
                }
            }

        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function list(Request $request,Response $response,array $args)
    {
       $retorno = ['status' => false];
       try{
            $treino = new Treino(null,null,null,null,null,null,null,null,null);
            $treinos = $treino->obterTodos($this->conn);
            if(!empty($treinos))
            {
                $retorno = ['status' => true, "resultSet" => $treinos];
            }
       }catch (\Exception $e)
       {

       }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function index(Request $request,Response $response,array $args)
    {
        return $this->view->render($response,"/Treinos/View/index.php");
    }

    public function ObterAlunosContrato(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false, "icon" => 'info' , "message" => "Não há nenhum aluno com contrato ativo"];
        try{
            $contrato = new Contrato(null,null,null,null,null,null,null,null,null,null);
            $contratosAtivos = $contrato->obterTodosContratosAtivos($this->conn);
            if(!empty($contratosAtivos))
            {
                $retorno = ['status' => true, "resultSet" => $contratosAtivos];
            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function avaliacaoFisicaPorContrato(Request $request,Response $response,array $args){
        try{
            $retorno = ['status' => false];
            $dados = $request->getQueryParams();
            if(!empty($dados['idContrato']))
            {
                $contrato = new Contrato($dados['idContrato'],null,null,null,null,null,null,null,null,null);
                $contrato->obterContratoById($this->conn);
                if(!empty($contrato->getIdContrato()))
                {
                    $treino = new Treino(null,$contrato,null,null,null,null,null,null,null);
                    $avaliacaoFisica = $treino->obterAvaliacaoFisicaPorContrato($this->conn);
                    if(!empty($avaliacaoFisica))
                    {
                        $retorno = ['status' => true, 'resultSet' => $avaliacaoFisica];
                    }
                }
            }

        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function store(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false, "icon" => 'error' , "message" => "Não foi possivel cadastrar treino."];
        try{
            $dados = $request->getParsedBody();
            $contrato = new Contrato($dados['contrato'],null,null,null,null,null,null,null,null,null);
            $contrato->obterContratoById($this->conn);
            $treino = null;
            $avaliacaoFisica = null;
            if(!empty($dados['avaliacaoFisica']))
            {
                $avaliacaoFisica = new AvaliacaoFisica($dados['avaliacaoFisica'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                $avaliacaoFisica->obterAvaliacaoPorId($this->conn);
            }
            if(!empty($_SESSION['usuario']->getAdministrador()))
            {
                $treino = new Treino(null,$contrato,$dados['dataCriacao'],$dados['dataInicio'],$dados['dataFim'],$_SESSION['usuario']->getAdministrador(),null,$dados['listaExercicios'],$avaliacaoFisica);
            }else if($_SESSION['usuario']->getInstrutor())
            {
                $treino = new Treino(null,$contrato,$dados['dataCriacao'],$dados['dataInicio'],$dados['dataFim'],null,$_SESSION['usuario']->getInstrutor(),$dados['listaExercicios'],$avaliacaoFisica);
            }
            if(!empty($treino))
            {
                if(!$treino->obterUltimoTreino($this->conn))
                {
                    $this->conn->beginTransaction();
                    if($treino->gravar($this->conn))
                    {
                        $this->conn->commit();
                        $retorno = ['status' => true, "icon" => 'success' , "message" => "Treino cadastrado com sucesso!"];
                    }else{
                        $this->conn->rollBack();
                    }
                }else{
                    $retorno = ['status' => false, "icon" => 'error' , "message" => "Já existe um treino em andamento neste periodo para o aluno selecionado."];
                }


            }
        }catch (\Exception $e)
        {
            $this->conn->rollBack();
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function obterExerciciosFisicosPorGrupoMuscular(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false, "icon" => 'info' , "message" => "Não há exercicios fisicos cadastrados para esse grupo muscular"];
        $dados = $request->getParsedBody();
        try {
            if(!empty($dados['idGrupoMuscular']))
            {
                $grupoMuscular = new GrupoMuscular($dados['idGrupoMuscular'],null);
                $grupoMuscular->obterGrupoMuscularByID($this->conn);
                $exercicio = new ExercicioFisico(null,null,$grupoMuscular);
                $naoListar = null;
                if(!empty($dados['NaoListar']))
                {
                    $naoListar = $dados['NaoListar'];
                }
                $exercicios = $exercicio->obterExerciciosFisicosPorGrupoMuscular($this->conn,$naoListar);
                if(!empty($exercicios))
                {
                    $retorno = ['status' => true, "resultSet" => $exercicios];
                }
            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }
}