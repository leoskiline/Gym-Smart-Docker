<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
<link rel="stylesheet" href="/src/ExercicioFisico/View/assets/exercicio.css">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fas fa-dumbbell"></i> Gerenciar Exercicio Fisico</h5>
                            </div>
                            <div class="card-body">
                              <form class="form" onsubmit="return false;">
                                <div class="row">
                                    <div class="col-lg-5 col-sm-11 col-11">
                                        <label for="ExercicioFisico">Exercicio Físico <span class="text-danger font-weight-bold">*</span></label>
                                        <select class="from-control" id="ExercicioFisico"></select>
                                        <span class="d-none text-danger obrigatorio1 font-weight-bold">Este campo é requerido.</span>
                                    </div>
                                    <div class="col-lg-1 col-sm-1 col-1 mt-4">
                                        <a href="javascript:void(0)" onclick="_exercicio.cadastrarExercicio()" title="Cadastrar Exercicio"><i class="fas fa-plus-circle" style="font-size: 1.5em;margin-top:14px"></i></a>
                                    </div>
                                    <div class="col-lg-5 col-sm-11 col-11">
                                        <label for="GrupoMuscular">Grupo Muscular <span class="text-danger font-weight-bold">*</span></label>
                                        <select class="from-control" id="GrupoMuscular"></select>
                                        <span class="d-none text-danger obrigatorio2 font-weight-bold">Este campo é requerido.</span>
                                    </div>
                                    <div class="col-lg-1 col-sm-1 col-1 mt-4">
                                        <a href="javascript:void(0)" onclick="_exercicio.cadastrarGrupoMuscular()" title="Cadastrar Grupo Muscular"><i class="fas fa-plus-circle" style="font-size: 1.5em;margin-top:14px"></i></a>
                                    </div>
                                </div>
                                <div class="row justify-content-between mt-3 mr-2">
                                    <span> Todos os campos com <span class="text-danger font-weight-bold">*</span> são obrigatórios.</span>
                                    <button class="btn btn-outline-success" onclick="_exercicio.cadastrar()"><i class="far fa-check-square mr-1"></i> Vincular</button>
                                </div>
                              </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-header row justify-content-between">
                                <h5 class="m-0"><i class="fas fa-dumbbell"></i> Lista de Exercicios Fisicos</h5>
                                <button type="button" class="btn btn-success ml-auto" data-toggle="modal" data-target="#modalRelatorioExercicio">
                                    Relatório por Aluno
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" style="font-size: 13px;">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 40%;">Descricao Exercicio Fisico</th>
                                                <th scope="col" style="width: 40%;">Descricao Grupo Muscular</th>
                                                <th scope="col" style="width: 20%;">Opcoes</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr>
                                                <td colspan="5" class="text-center">Carregando...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<!-- Modais -->
    <div class="modal fade" id="modalAluno" tabindex="-1" role="dialog" aria-labelledby="modalAlunoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAlunoLabel">Alterar Vínculos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" onsubmit="return false;">
                        <div class="row">
                            <div class="col-6">
                                <label for="ModalIdExercicioFisico">Descricao Exercicio Fisico</label>
                                <select class="form-control" id="ModalIdExercicioFisico">

                                </select>
                                <span class="d-none text-danger obrigatorioModal1 font-weight-bold">Este campo é requerido.</span>
                            </div>
                            <div class="col-6">
                                <label for="ModalIdGrupoMuscular">Descricao Grupo Muscular</label>
                                <select class="form-control" id="ModalIdGrupoMuscular">

                                </select>
                                <span class="d-none text-danger obrigatorioModal2 font-weight-bold">Este campo é requerido.</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" id="botaoSalvar"><i class="far fa-check-square mr-1"></i> Salvar</button>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="modalRelatorioExercicio" tabindex="-1" role="dialog" aria-labelledby="modalRelatorioExercicioLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="min-width: 50%">
        <form id="formRelatorio" onsubmit="return false;" style="min-width: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRelatorioExercicioLabel">Relatório de Exercícios por Aluno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <label for="relAluno">Aluno</label>
                            <select class="form-control selectpicker" data-live-search="true" id="relAluno" name="relAluno" required></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success" onclick="_exercicio.gerarRelatorio()">Gerar</button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php
include __DIR__."/../../Template/footer.php";
?>
<script src="/src/ExercicioFisico/View/assets/exercicio.js"></script>
