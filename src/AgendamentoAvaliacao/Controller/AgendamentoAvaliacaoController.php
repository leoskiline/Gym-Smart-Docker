<?php

namespace App\AgendamentoAvaliacao\Controller;

use App\Administrador\Model\Administrador;
use App\AgendamentoAvaliacao\Model\AgendamentoAvaliacao;
use App\Aluno\Model\Aluno;
use App\Instrutor\Model\Instrutor;
use App\Professor\Model\Professor;
use App\Receita\Model\Receita;
use App\Usuario\Model\Usuario;
use App\Utils\AbstractSlimController;
use App\Utils\Date;
use App\Utils\Enums\EnumOrigem;
use App\Utils\Moeda;
use DateTime;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AgendamentoAvaliacaoController extends AbstractSlimController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request,Response $response)
    {
        return $this->view->render($response, "/AgendamentoAvaliacao/View/index.php");
    }

    public function atualizar(Request $request,Response $response)
    {
        $dados = $request->getParsedBody();
        $usuario = new Usuario($dados['editAvaliador'],null,null,null,null,null,null,null,null);
        $usuario->obterUsuarioById($this->conn);
        $aluno = new Aluno($dados['editAluno'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
        $aluno->obterAlunoPorId($this->conn);
        if($usuario->getInstrutor())
        {
            $agendamento = new AgendamentoAvaliacao($dados['idAgendamentoAvaliacaoFisica'],$usuario->getInstrutor(),null,null,$dados['editAluno'],$dados['editTipoAvaliacao'],Date::DataBanco($dados['editInicio']),Date::DataBanco($dados['editFim']),$aluno->getNome(),$dados['editColor'],Moeda::MoedaDB($dados['editValor']));

        }
        if($usuario->getProfessor())
        {
            $agendamento = new AgendamentoAvaliacao($dados['idAgendamentoAvaliacaoFisica'],null,null,$usuario->getProfessor(),$dados['editAluno'],$dados['editTipoAvaliacao'],Date::DataBanco($dados['editInicio']),Date::DataBanco($dados['editFim']),$aluno->getNome(),$dados['editColor'],Moeda::MoedaDB($dados['editValor']));

        }
        if($usuario->getAdministrador())
        {
            $agendamento = new AgendamentoAvaliacao($dados['idAgendamentoAvaliacaoFisica'],null,$usuario->getAdministrador(),null,$dados['editAluno'],$dados['editTipoAvaliacao'],Date::DataBanco($dados['editInicio']),Date::DataBanco($dados['editFim']),$aluno->getNome(),$dados['editColor'],Moeda::MoedaDB($dados['editValor']));
        }
        $receita = new Receita(null,EnumOrigem::AGENDAMENTOAVALIACAOFISICA,date("Y-m-d"),$agendamento->getValor(),null,$agendamento->getIdAgendamentoAvaliacaoFisica());
        $diffMinutes = $this->obterDiferencaMinutos($dados['editInicio'],$dados['editFim']);
        if($diffMinutes <= 60 && $diffMinutes > 20)
        {
            if(!$agendamento->verificarAvaliadorDisponivel($this->conn))
            {
                $this->conn->beginTransaction();
                if($agendamento->atualizar($this->conn) && $receita->atualizarByAgendamentoAvaliacao($this->conn))
                {
                    $this->conn->commit();
                    $retorno = ['status' => true, "icon" => 'success', "message" => 'Agendamento atualizado com sucesso'];
                }else{
                    $this->conn->rollBack();
                    $retorno = ['status' => false, "icon" => 'error', "message" => 'Não foi possivel atualizar agendamento'];
                }
            }else{
                $retorno = ['status' => false, "icon" => 'error', "message" => 'Avaliador não disponivel no periodo selecionado.'];
            }
        }else{
            $retorno = ['status' => false, "icon" => 'error', "message" => 'Periodo não permitido, minimo 20 minutos, máximo 1 hora.'];
        }

        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function deletar(Request $request,Response $response)
    {
        $agendamento = new AgendamentoAvaliacao($request->getParsedBody()['idAgendamentoAvaliacaoFisica'],null,null,null,null,null,null,null,null,null,null);
        $receita = new Receita(null,null,null,null,null,$agendamento->getIdAgendamentoAvaliacaoFisica());
        $this->conn->beginTransaction();
        if($receita->deletarByAgendamentoAvaliacaoFisica($this->conn) && $agendamento->deletarById($this->conn))
        {
            $this->conn->commit();
            $retorno = ['status' => true, "icon" => 'success', "message" => 'Agendamento deletado com sucesso'];
        }else{
            $this->conn->rollBack();
            $retorno = ['status' => false, "icon" => 'error', "message" => 'Não foi possivel deletar agendamento'];
        }
        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function agendar(Request $request,Response $response)
    {
        $params = $request->getParsedBody();
        $usuario = new Usuario($params['avaliador'],null,null,null,null,null,null,null,null);
        $usuario->obterUsuarioById($this->conn);
        $aluno = new Aluno($params['aluno'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
        $aluno->obterAlunoPorId($this->conn);
        $valor = (float)Moeda::MoedaDB($params['valor']);
        $inicio = Date::DataBR($params['inicio']);
        $fim = Date::DataBR($params['fim']);
        if($usuario->getAdministrador())
        {
            $administrador = new Administrador($usuario->getAdministrador(),null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            $administrador->obterAdministradorById($this->conn);
            $agendamentoAvaliacao = new AgendamentoAvaliacao(null,null,$usuario->getAdministrador(),null,$params['aluno'],$params['tipoAvaliacao'],Date::DataBanco($params['inicio']),Date::DataBanco($params['fim']),$aluno->getNome(),$params['color'],$valor);
        }
        if($usuario->getProfessor())
        {
            $professor = new Professor($usuario->getProfessor(),null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            $professor->obterProfessorById($this->conn);
            $agendamentoAvaliacao = new AgendamentoAvaliacao(null,null,null,$usuario->getProfessor(),$params['aluno'],$params['tipoAvaliacao'],Date::DataBanco($params['inicio']),Date::DataBanco($params['fim']),$aluno->getNome(),$params['color'],$valor);
        }
        if($usuario->getInstrutor())
        {
            $instrutor = new Instrutor($usuario->getInstrutor(),null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            $instrutor->obterInstrutorById($this->conn);
            $agendamentoAvaliacao = new AgendamentoAvaliacao(null,$usuario->getInstrutor(),null,null,$params['aluno'],$params['tipoAvaliacao'],Date::DataBanco($params['inicio']),Date::DataBanco($params['fim']),$aluno->getNome(),$params['color'],$valor);
        }
        $diffMinutes = $this->obterDiferencaMinutos($params['inicio'],$params['fim']);
        if($diffMinutes <= 60 && $diffMinutes > 20) // Verifica se o Agendamento eh inferior ou igual a 60 minutos e maior que 20 minutos
        {
            if(!$agendamentoAvaliacao->verificarAgendadoDia($this->conn))
            {
                if(!$agendamentoAvaliacao->verificarAvaliadorDisponivel($this->conn))
                {
                    $this->conn->beginTransaction();
                    if($agendamentoAvaliacao->gravarAgendamento($this->conn)){
                        $receita = new Receita(null,EnumOrigem::AGENDAMENTOAVALIACAOFISICA,date("Y-m-d"),$agendamentoAvaliacao->getValor(),null,$agendamentoAvaliacao->getIdAgendamentoAvaliacaoFisica());
                        if($receita->gerarReceitaAvaliacaoFisica($this->conn)){
                            $retorno = ['status' => true, "icon" => 'success', "message" => 'Agendado com sucesso'];
                            $this->conn->commit();
                        }
                        else{
                            $retorno = ['status' => false, "icon" => 'error', "message" => 'Não foi possivel realizar o agendamento'];
                            $this->conn->rollBack();
                        }
                    }
                    else{
                        $retorno = ['status' => false, "icon" => 'error', "message" => 'Não foi possivel realizar o agendamento'];
                        $this->conn->rollBack();
                    }
                }else{
                    $retorno = ['status' => false, "icon" => 'error', "message" => 'Avaliador não disponivel no periodo selecionado.'];
                }
            }else{
                $retorno = ['status' => false, "icon" => 'error', "message" => 'Pessoa já possui um agendamento para o dia informado.'];
            }
        }
        else{
            $retorno = ['status' => false, "icon" => 'error', "message" => 'Periodo não permitido, minimo 20 minutos, máximo 1 hora.'];
        }

        $response->getBody()->write(json_encode($retorno));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    public function events(Request $request,Response $response)
    {
        $dados = $request->getParsedBody();
        $agendamentoAvaliacao = new AgendamentoAvaliacao(null,null,null,null,null,null,null,null,null,null,null);
        if(!empty($dados['filterAluno']) || !empty($dados['filterAvaliador']))
        {
            $agendamentos = $agendamentoAvaliacao->obterAgendamentosFiltrados($this->conn,$dados);
        }
        else{
            $agendamentos = $agendamentoAvaliacao->obterTodosAgendamentos($this->conn);
        }
        $response->getBody()->write(json_encode($agendamentos));
        return $response->withHeader("Content-Type","application/json;charset=utf-8")->withStatus(200);
    }

    private function obterDiferencaMinutos($inicio,$fim)
    {
        $origin = new DateTime(Date::DataBanco($inicio));
        $target = new DateTime(Date::DataBanco($fim));
        return ($target->getTimestamp() - $origin->getTimestamp()) / 60;
    }
}