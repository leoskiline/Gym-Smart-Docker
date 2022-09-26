<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
<link rel="stylesheet" href="/src/AgendamentoAvaliacao/View/assets/agendamento.css">
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg-12">

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0"><i class="fa-solid fa-calendar-days"></i> Gerenciar Agendamentos para Avaliação Física</h5>
                    </div>
                    <div class="card-body">
                        <div class="row" id="calendar">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>


<form id="formFilter" onsubmit="return false">
    <div class="modal fade" tabindex="-1" role="dialog" id="modalFilter">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filtrar Agendamento de Avaliação Física</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <label for="filterAluno">Aluno</label>
                            <select class="form-control selectpicker" data-live-search="true" id="filterAluno"></select>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <label for="filterAvaliador">Avaliador</label>
                            <select class="form-control selectpicker" data-live-search="true" id="filterAvaliador"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="btnFiltrar">Filtrar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="formEdit" onsubmit="return false">
    <div class="modal fade" tabindex="-1" role="dialog" id="schedule-edit">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atualizar/Visualizar Agendamento de Avaliação Física</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 row" id="schedule-edit-body">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="_agendamento.deletar()" style="margin-right: auto">Deletar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="_agendamento.atualizar()">Atualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>


<form id="formAgendar" onsubmit="return false">
    <div class="modal fade" tabindex="-1" role="dialog" id="modalAgendar">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agendar Avaliação Física</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 row">
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label for="aluno">Aluno</label><a href="/Gerenciar/Aluno" target="_blank" title="Cadastrar Novo Aluno"><i class="fas fa-plus-circle" style="font-size: 1.0em;margin-left: 5px;"></i></a> <a href="javascript:void(0)" onclick="_agendamento.obterAlunos()" title="Atualizar Alunos"><i id="loading" class="fa-solid fa-rotate" style="font-size: 1.0em;margin-left:5px"></i></a>
                            <select class="selectpicker" id="aluno" name="aluno" data-live-search="true"></select>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label for="tipoAvaliacao">Tipo de Avaliação</label>
                            <select class="form-control" id="tipoAvaliacao" name="tipoAvaliacao">
                                <option value="Completa">Completa</option>
                                <option value="Parcial">Parcial</option>
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label for="avaliador">Avaliador</label>
                            <select class="selectpicker" id="avaliador" data-live-search="true" name="avaliador"></select>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label for="inicio">Inicio da Avaliação</label>
                            <input type="datetime-local" class="form-control" id="inicio" name="inicio">
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label for="fim">Fim da Avaliação</label>
                            <input type="datetime-local" class="form-control" id="fim" name="fim">
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <label for="color">Cor do Marcador</label>
                            <input type="color" class="form-control" id="color" name="color" value="#293e80">
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <label for="valor">Valor da Avaliação</label>
                            <input type="text" class="form-control" id="valor" name="valor" value="000">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="_agendamento.agendar()">Agendar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
include __DIR__."/../../Template/footer.php";
?>
<script src="/node_modules/trans-form/dist/transForm.min.js"></script>
<script src="/src/AgendamentoAvaliacao/View/assets/agendamento.js"></script>
