<?php

namespace App\Dashboard\Controller;

use App\Dashboard\Repository\DashboardRepository;
use App\Despesas\Model\Despesa;
use App\Utils\AbstractSlimController;
use App\Utils\Moeda;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DashboardController extends AbstractSlimController
{
    private DashboardRepository $repository;
    public function __construct()
    {
        parent::__construct();
        $this->repository = new DashboardRepository($this->conn);
    }

    public function index(Request $request,Response $response,array $args)
    {
        $dados['quantidadeAlunos'] = $this->repository->getQuantidadeAlunos();
        $dados['quantidadeAlunosAtivos'] = $this->repository->getQuantidadeAlunosContratoAtivo();
        $dados['quantidadeAvaliacoes'] = $this->repository->getAgendamentosHoje();
        $dados['quantidadeMensaldadesAtraso'] = $this->repository->getMensalidadesAtraso();
        $despesa = new Despesa(null,null,null,null,null,null,null,null,null);
        $periodo['dataInicial'] = date("Y-m-01");
        $periodo['dataFinal'] = date("Y-m-t");
        $somaDespesas = $despesa->obterSomaDespesasPeriodo($this->conn,$periodo);
        $somaReceitas = $despesa->obterSomaReceitasPeriodo($this->conn,$periodo);
        $valor = $somaReceitas - $somaDespesas;
        $valor = Moeda::MoedaBR($valor);
        $dados['valorMes'] = $valor;
        return $this->view->render($response,"/Dashboard/View/dashboard.php",$dados);
    }
}