<?php

use App\AgendamentoAvaliacao\Controller\AgendamentoAvaliacaoController;
use \App\Aluno\Controller\AlunoController;
use App\AvaliacaoFisica\Controller\AvaliacaoFisicaController;
use App\Contrato\Controller\ContratoController;
use App\Despesas\Controller\DespesaController;
use App\Middleware\PermissionMiddleware;
use App\Planos\Controller\PlanoController;
use \App\Professor\Controller\ProfessorController;
use App\Sistema\Controller\SistemaController;
use App\Treinos\Controller\TreinoController;
use \App\Usuario\Controller\UsuarioController;
use \App\Dashboard\Controller\DashboardController;
use \App\Instrutor\Controller\InstrutorController;
use \App\Administrador\Controller\AdministradorController;
use \App\ExercicioFisico\Controller\ExercicioFisicoController;
use \App\AtividadeFisica\Controller\AtividadeFisicaController;
use \App\Fornecedor\Controller\FornecedorController;
use Slim\Routing\RouteCollectorProxy;


/** @var \Slim\App $app */

//Usuario

$app->get("/", UsuarioController::class . ":index");
$app->group("/Usuario", function (RouteCollectorProxy $group) {
    $group->post("/Login", UsuarioController::class . ":login");
    $group->post("/Configuracao", UsuarioController::class . ":configuracao");
    $group->get("/Logout", UsuarioController::class . ":logout");
    $group->get("/ObterAvaliadores", UsuarioController::class . ":obterAvaliadores");
});


//Parametrização
$app->group("/Parametrizacao", function (RouteCollectorProxy $group) {
    $group->get("", SistemaController::class . ":index");
    $group->post("/Atualizar", SistemaController::class . ":update");
})->add(new PermissionMiddleware());


//Dashboard
$app->get("/Dashboard", DashboardController::class . ":index");

// Aluno
$app->group("/Gerenciar/Aluno", function (RouteCollectorProxy $group) {
    $group->get("", AlunoController::class . ":index");
    $group->post("/Gravar",AlunoController::class . ":store");
    $group->post("/Atualizar",AlunoController::class . ":update");
    $group->post("/Excluir",AlunoController::class . ":delete");
    $group->get("/ObterTodos", AlunoController::class . ":list");
})->add(new PermissionMiddleware());



// Professor
$app->group("/Gerenciar/Professor", function (RouteCollectorProxy $group) {
    $group->get("", ProfessorController::class . ":index");
    $group->post("/Gravar",ProfessorController::class . ":store");
    $group->post("/Atualizar",ProfessorController::class . ":update");
    $group->post("/Excluir",ProfessorController::class . ":delete");
    $group->get("/ObterTodos", ProfessorController::class . ":list");
})->add(new PermissionMiddleware());


// Instrutor
$app->group("/Gerenciar/Instrutor", function (RouteCollectorProxy $group) {
    $group->get("", InstrutorController::class . ":index");
    $group->post("/Gravar",InstrutorController::class . ":store");
    $group->post("/Atualizar",InstrutorController::class . ":update");
    $group->post("/Excluir",InstrutorController::class . ":delete");
    $group->get("/ObterTodos", InstrutorController::class . ":list");
})->add(new PermissionMiddleware());


// Administrador
$app->group("/Gerenciar/Administrador", function (RouteCollectorProxy $group) {
    $group->get("", AdministradorController::class . ":index");
    $group->post("/Gravar",AdministradorController::class . ":store");
    $group->post("/Atualizar",AdministradorController::class . ":update");
    $group->post("/Excluir",AdministradorController::class . ":delete");
    $group->get("/ObterTodos", AdministradorController::class . ":list");
})->add(new PermissionMiddleware());


// ExercicioFisico
$app->group("/Gerenciar/ExercicioFisico", function (RouteCollectorProxy $group) {
    $group->get("", ExercicioFisicoController::class . ":index");
    $group->post("/Gravar",ExercicioFisicoController::class . ":store");
    $group->post("/Atualizar",ExercicioFisicoController::class . ":update");
    $group->post("/Excluir",ExercicioFisicoController::class . ":delete");
    $group->get("/ObterTodos", ExercicioFisicoController::class . ":list");
    $group->get("/ObterExerciciosFisicos", ExercicioFisicoController::class . ":getExerciciosFisicos");
    $group->post("/CadastrarExercicioFisico", ExercicioFisicoController::class . ":cadastrarExercicioFisico");
    $group->post("/CadastrarGrupoMuscular", ExercicioFisicoController::class . ":cadastrarGrupoMuscular");
    $group->get("/ObterGruposMusculares", ExercicioFisicoController::class . ":getGruposMusculares");
    $group->get("/Relatorio",ExercicioFisicoController::class . ":obterExerciciosFisicosPorAluno");
    $group->get("/obterAlunos",ExercicioFisicoController::class . ":obterAlunos");
})->add(new PermissionMiddleware());


// AtividadeFisica
$app->group("/Gerenciar/AtividadeFisica", function (RouteCollectorProxy $group) {
    $group->get("", AtividadeFisicaController::class . ":index");
    $group->post("/Gravar",AtividadeFisicaController::class . ":store");
    $group->post("/Atualizar",AtividadeFisicaController::class . ":update");
    $group->post("/Excluir",AtividadeFisicaController::class . ":delete");
    $group->get("/ObterTodos", AtividadeFisicaController::class . ":list");
})->add(new PermissionMiddleware());


// Fornecedor
$app->group("/Gerenciar/Fornecedor", function (RouteCollectorProxy $group) {
    $group->get("", FornecedorController::class . ":index");
    $group->post("/Gravar",FornecedorController::class . ":store");
    $group->post("/Atualizar",FornecedorController::class . ":update");
    $group->post("/Excluir",FornecedorController::class . ":delete");
    $group->get("/ObterTodos", FornecedorController::class . ":list");
})->add(new PermissionMiddleware());


// Agendamento Avaliacao Fisica
$app->group("/AgendamentoAvaliacao", function (RouteCollectorProxy $group) {
    $group->get("", AgendamentoAvaliacaoController::class . ":index");
    $group->post("/Eventos", AgendamentoAvaliacaoController::class . ":events");
    $group->post("/Agendar", AgendamentoAvaliacaoController::class . ":agendar");
    $group->post("/Deletar", AgendamentoAvaliacaoController::class . ":deletar");
    $group->post("/Atualizar", AgendamentoAvaliacaoController::class . ":atualizar");
})->add(new PermissionMiddleware());


// Planos
$app->group("/Planos", function (RouteCollectorProxy $group) {
    $group->get("",PlanoController::class . ":index");
    $group->post("/Gravar",PlanoController::class . ":store");
    $group->post("/Excluir",PlanoController::class . ":delete");
    $group->post("/Atualizar",PlanoController::class . ":update");
    $group->get("/ObterTodos",PlanoController::class . ":list");
})->add(new PermissionMiddleware());


// Despesas
$app->group("/Despesas", function (RouteCollectorProxy $group) {
    $group->get("",DespesaController::class . ":index");
    $group->post("/Gravar",DespesaController::class . ":store");
    $group->post("/Excluir",DespesaController::class . ":delete");
    $group->post("/Atualizar",DespesaController::class . ":update");
    $group->get("/ObterTodos",DespesaController::class . ":list");
    $group->get("/Relatorio",DespesaController::class . ":report");
})->add(new PermissionMiddleware());


// Gerenciar Contratos
$app->group("/Contrato", function (RouteCollectorProxy $group) {
    $group->get("", ContratoController::class . ":index");
    $group->post("/Gravar", ContratoController::class . ":store");
    $group->get("/ObterTodos", ContratoController::class . ":list");
    $group->post("/Cancelar", ContratoController::class . ":cancel");
    $group->get("/FormasPagamento", ContratoController::class . ":formasPagamento");
    $group->get("/Relatorio", ContratoController::class . ":report");
    $group->post("/ObterMensalidades", ContratoController::class . ":obterMensalidades");
    $group->post("/PagamentoMensalidade", ContratoController::class . ":pagamentoMensalidade");
    $group->post("/EstornoMensalidade", ContratoController::class . ":estornoMensalidade");
    $group->post("/VerificarMensalidadeCronologica", ContratoController::class . ":VerificarMensalidadeCronologica");
    $group->post("/AlterarDiaPagamento", ContratoController::class . ":alterarDiaPagamento");
})->add(new PermissionMiddleware());


// Gerenciar Treinos
$app->group("/Treinos", function (RouteCollectorProxy $group) {
    $group->get("", TreinoController::class . ":index");
    $group->post("/ExerciciosPorGrupoMuscular", TreinoController::class . ":obterExerciciosFisicosPorGrupoMuscular");
    $group->post("/Gravar", TreinoController::class . ":store");
    $group->get("/ObterTodos", TreinoController::class . ":list");
    $group->get("/ObterAlunosContrato", TreinoController::class . ":ObterAlunosContrato");
    $group->get("/ObterAvaliacaoFisicaPorContrato",TreinoController::class . ":avaliacaoFisicaPorContrato");
    $group->get("/obterExercicios",TreinoController::class . ":obterExercicios");
    $group->get("/obterPDF",TreinoController::class . ":obterPDF");
})->add(new PermissionMiddleware());

// Avaliação Física
$app->group("/Gerenciar/AvaliacaoFisica", function (RouteCollectorProxy $group)
{
   $group->get("",AvaliacaoFisicaController::class . ":index");
   $group->post("/Salvar",AvaliacaoFisicaController::class . ":store");
   $group->get("/ObterTodos",AvaliacaoFisicaController::class . ":list");
   $group->get("/ObterAgendamentosHoje",AvaliacaoFisicaController::class . ":ObterAgendamentosHoje");
   $group->get("/GerarPDF",AvaliacaoFisicaController::class . ":gerarPDF");
});

