<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
<link rel="stylesheet" href="/src/AvaliacaoFisica/View/assets/avaliacao.css">
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg-12">

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0"><i class="fas fa-paste"></i> Realizar Avaliação Física</h5>
                    </div>
                    <div class="card-body">
                        <form id="avaliacaoFisica" onsubmit="return false;">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <label for="agendamentoAvaliacao">Agendamentos de Avaliações Hoje</label>
                                    <select class="form-control selectpicker" id="agendamentoAvaliacao" name="agendamentoAvaliacao">

                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="nivelaptidaofisica">Nivel de Aptidão Física</label>
                                    <input type="text" class="form-control" name="nivelaptidaofisica" id="nivelaptidaofisica">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="peso">Peso</label>
                                    <input type="text" class="form-control" name="peso" id="peso">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="altura">Altura</label>
                                    <input type="text" class="form-control" name="altura" id="altura">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="dores">Dores</label>
                                    <input type="text" class="form-control" name="dores" id="dores">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="historicosaude">Histórico de Saúde</label>
                                    <input type="text" class="form-control" name="historicosaude" id="historicosaude">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="desviospostura">Desvios e Posturas</label>
                                    <input type="text" class="form-control" name="desviospostura" id="desviospostura">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="percentualgordura">% de Gordura</label>
                                    <input type="text" class="form-control" name="percentualgordura" id="percentualgordura">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="percentualmassamagra">% de Massa Magra</label>
                                    <input type="text" class="form-control" name="percentualmassamagra" id="percentualmassamagra">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="metas">Metas</label>
                                    <input type="text" class="form-control" name="metas" id="metas">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="objetivo">Objetivo</label>
                                    <input type="text" class="form-control" name="objetivo" id="objetivo">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="habitosalimentares">Hábitos Alimentares</label>
                                    <input type="text" class="form-control" name="habitosalimentares" id="habitosalimentares">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="qualidadesono">Qualidade do Sono</label>
                                    <input type="text" class="form-control" name="qualidadesono" id="qualidadesono">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="bebidaalcoolica">Bebida Alcoólica</label>
                                    <input type="text" class="form-control" name="bebidaalcoolica" id="bebidaalcoolica">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="fumante">Fumante</label>
                                    <input type="text" class="form-control" name="fumante" id="fumante">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="medicamentos">Medicamentos</label>
                                    <input type="text" class="form-control" name="medicamentos" id="medicamentos">
                                </div>
                                <div class="col-lg-6 col-sm-12 mt-2 d-flex" style="align-items: center;justify-content: right;">
                                    <button type="button" class="btn btn-primary mr-1" onclick="_avaliacao.limparCampos()">Limpar</button>
                                    <button type="button" class="btn btn-success" onclick="_avaliacao.salvar()">Salvar Avaliação</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">

                <div class="card card-white">
                    <div class="card-header row justify-content-between">
                        <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                            <h5 class="m-0"><i class="fas fa-paste"></i> Lista de Avaliações Físicas</h5>
                        </div>
                        <div class="d-flex col-lg-5 col-md-12 col-sm-12 col-12 ml-auto">
                            <label for="dataInicio" class="mt-1">Período</label>
                            <input type="date" class="form-control ml-2" id="dataInicio" name="dataInicio">
                            <span class="data-ate">à</span>
                            <input type="date" class="form-control" id="dataFim" name="dataFim">
                            <button type="button" class="btn btn-outline-success w-100 ml-2" onclick="_avaliacao.obterAvaliacoesFisicas(document.getElementById('dataInicio').value,document.getElementById('dataFim').value)"><i class="fa-solid fa-filter"></i> FILTRAR</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="tabelaAvaliacoes">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Tipo</th>
                                        <th>Valor</th>
                                        <th>Data</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody id="listaAvaliacoes">
                                    <tr>
                                        <td colspan="10"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- Modal -->
<div class="modal fade" id="modalDetalhes" tabindex="-1" role="dialog" aria-labelledby="modalDetalhesCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetalhesLongTitle">Detalhes da Avaliação Física</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalDetalhesBody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->
</div>

<?php
include __DIR__."/../../Template/footer.php";
?>
<script src="/node_modules/trans-form/dist/transForm.min.js"></script>
<script src="/src/AvaliacaoFisica/View/assets/avaliacao.js"></script>
