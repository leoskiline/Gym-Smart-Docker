<?php

namespace App\ExercicioFisico\Controller;

use App\Aluno\Model\Aluno;
use App\ExercicioFisico\Model\ExercicioFisico;
use App\ExercicioFisico\Model\GrupoMuscular;
use App\Utils\AbstractSlimController;
use App\Utils\MYPDF;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ExercicioFisicoController extends AbstractSlimController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obterAlunos(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false];
        try{
            $aluno = new Aluno(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            $alunos = $aluno->obterAlunosPossuemExericicios($this->conn);
            if(!empty($alunos))
            {
                $retorno = ['status' => true, "resultSet" => $alunos];
            }
        }catch (\Exception $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function obterExerciciosFisicosPorAluno(Request $request,Response $response,array $args)
    {
        $retorno = ['status' => false, "message" => "Aluno inválido"];
        try{
            $param = $request->getQueryParams();
            if(!empty($param['relAluno']))
            {
                $aluno = new Aluno($param['relAluno'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                $aluno->obterAlunoPorId($this->conn);

                if($aluno->getIdAluno())
                {
                    $exericicoFisico = new ExercicioFisico(null,null,null);
                    $exerciciosFisicos = $exericicoFisico->obterTodosExerciciosFisicosPorAluno($this->conn,$aluno->getIdAluno());
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
                    $pdf->writeHTML("<h2>Relatório de Exercícios Físicos do Aluno {$aluno->getNome()}</h2>",true,false,false,false,'C');
                    $pdf->Ln(2);
                    $nomeArquivo = "RelatorioContratosPeriodo.pdf";
                    $trows = "";
                    foreach ($exerciciosFisicos as $exs)
                    {
                        $trows .= <<<EOD
                                        <tr>
                                            <td align="center">{$exs['grupo']}</td>
                                            <td align="center">{$exs['exercicio']}</td>
                                            <td align="center">{$exs['series']}</td>
                                            <td align="center">{$exs['repeticoes']}</td>
                                            <td align="center">{$exs['peso']}</td>
                                            <td align="center">{$exs['dia']}</td>
                                            <td align="center">{$exs['dataContrato']}</td>
                                            <td align="center">{$exs['idContrato']}</td>
                                        </tr>
                                    EOD;

                    }
                    $txt = <<<EOD
                                <table border="1" cellspacing="0" cellpadding="2" >
                                    <thead>
                                        <tr>
                                            <th align="center">Grupo Muscular</th>
                                            <th align="center">Exercício Físicio</th>
                                            <th align="center">Series</th>
                                            <th align="center">Repetições</th>
                                            <th align="center">Peso</th>
                                            <th align="center">Dia</th>
                                            <th align="center">Data Contrato</th>
                                            <th align="center">Código do Contrato</th>
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
            $retorno['message'] = "Ocorreu um erro inesperado";
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function delete(Request $request,Response $response,array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Não foi possivel desvincular."];
        $dados = $request->getParsedBody();
        $grupomuscular = new GrupoMuscular($dados['idGrupoMuscular'],null);
        $grupomuscular->obterGrupoMuscularByID($this->conn);
        $exercicio = new ExercicioFisico($dados['idExercicioFisico'],null,$grupomuscular);
        $exercicio->obterExercicoFisicoByID($this->conn);
        if($exercicio->desvincularGrupoMuscular($this->conn)){
            $retorno = ["status" => true, "icon" => "success", "message" => "Desvinculado com sucesso."];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function list(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "info", "message" => "Nao ha nenhum registro."];
        try{
            $exercicioFisico = new ExercicioFisico(null,null,null);
            $vinculos = $exercicioFisico->obterTodosVinculos($this->conn);
            if($vinculos){
                $retorno = ["status" => true, "resultSet" => $vinculos];
            }
        }catch(\PDOException $e)
        {

        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function index(Request $request,Response $response, array $args)
    {
        return $this->view->render($response, "/ExercicioFisico/View/index.php");
    }

    private function dateBRtoUS($data)
    {
        $us = explode("/",$data);
        return $us[2]."-".$us[1]."-".$us[0];
    }

    public function update(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel atualizar registro de administrador."];
        $params = $request->getParsedBody();
        $grupoMuscular = new GrupoMuscular($params['grupoMuscular'],null);
        $grupoMuscular->obterGrupoMuscularByID($this->conn);
        $exercicioFisico = new ExercicioFisico($params['exercicioFisico'],null,$grupoMuscular);
        $exercicioFisico->obterExercicoFisicoByID($this->conn);
        $vinculado = $exercicioFisico->verificarVinculo($this->conn);
        if(!$vinculado)
        {
            if($exercicioFisico->criarVinculo($this->conn)){
                $retorno = ["status" => true, "icon" => "success", "message" => "Vinculo atualizado com sucesso."];
            }
        }
        else{
            $retorno = ["status" => false, "icon" => "info", "message" => "Vinculo de exercicio a grupo muscular ja cadastrado."];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function cadastrarExercicioFisico(Request $request,Response $response,array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Falhou ao cadastrar."];
        $dados = $request->getParsedBody();
        $exercicio = new ExercicioFisico(null,$dados['descricao'],null);
        $cadastrado = $exercicio->verificaExercicioCadastrado($this->conn);
        if($cadastrado)
        {
            $retorno = ["status" => false, "icon" => "info", "message" => "Exercicio Fisico {$cadastrado['descricao']} ja esta cadastrado."];
        }
        else{
            if($exercicio->gravar($this->conn)){
                $retorno = ["status" => true, "icon" => "success", "message" => "Cadastrado com sucesso."];
            }
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function cadastrarGrupoMuscular(Request $request, Response $response,array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Falhou ao cadastrar."];
        $dados = $request->getParsedBody();
        $grupoMuscular = new GrupoMuscular(null,$dados['descricao']);
        $cadastrado = $grupoMuscular->verificaCadastrado($this->conn);
        if($cadastrado)
        {
            $retorno = ["status" => false, "icon" => "info", "message" => "Grupo Muscular {$cadastrado['descricao']} ja esta cadastrado."];
        }
        else{
            if($grupoMuscular->gravar($this->conn))
            {
                $retorno = ["status" => true, "icon" => "success", "message" => "Cadastrado com sucesso."];
            }
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function getExerciciosFisicos(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false];
        $exercicio = new ExercicioFisico(null,null,null);
        $ExerciciosFisicos = $exercicio->obterTodosExerciciosFisicos($this->conn);
        if(is_array($ExerciciosFisicos))
        {
            $retorno = ["status" => true, "resultSet" => $ExerciciosFisicos];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function getGruposMusculares(Request $request,Response $response,array $args)
    {
        $retorno = ["status" => false];
        $grupoMuscular = new GrupoMuscular(null,null);
        $grupoMusculares = $grupoMuscular->obterTodosGruposMusculares($this->conn);
        if(is_array($grupoMusculares))
        {
            $retorno = ["status" => true, "resultSet" => $grupoMusculares];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function store(Request $request,Response $response, array $args)
    {
        $retorno = ["status" => false, "icon" => "error", "message" => "Nao foi possivel gravar registro."];
        $dados = $request->getParsedBody();
        $grupomuscular = new GrupoMuscular($dados['grupoMuscular'],null);
        $grupomuscular->obterGrupoMuscularByID($this->conn);
        $exercicio = new ExercicioFisico($dados['exercicioFisico'],null,$grupomuscular);
        $exercicio->obterExercicoFisicoByID($this->conn);
        $vinculado = $exercicio->verificarVinculo($this->conn);
        if(!$vinculado)
        {
            $this->conn->beginTransaction();
            try{
                if($exercicio->criarVinculo($this->conn))
                {
                    $this->conn->commit();
                    $retorno = ["status" => true, "icon" => "success", "message" => "Vinculado com sucesso."];
                }
                else{
                    $this->conn->rollBack();
                }
            }catch (\PDOException $e)
            {
                $this->conn->rollBack();
            }
        }
        else{
            $retorno = ["status" => false, "icon" => "info", "message" => "Vinculo de exercicio com grupo muscular ja cadastrado."];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }
}