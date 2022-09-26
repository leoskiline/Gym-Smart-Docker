<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
<link rel="stylesheet" href="/src/Treinos/View/assets/treinos.css">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <form id="formTreino" onsubmit="return false;">
                        <div class="col-lg-12">

                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="m-0"><i class="fa-solid fa-hand-fist mr-1"></i>Gerenciar Treinos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-12">
                                            <label for="aluno">Contrato (Aluno) <span class="text-danger font-weight-bold">*</span></label><a href="javascript:void(0)" onclick="_treinos.obterAlunos()" title="Atualizar Alunos"><i id="loading" class="fa-solid fa-rotate" style="font-size: 1.0em;margin-left:5px"></i></a>
                                            <select class="selectpicker col-12 pl-0" id="aluno" name="aluno" data-live-search="true"></select>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <label for="avaliacaoFisica">Avaliação Física</label>
                                            <select class="selectpicker col-12 pl-0" id="avaliacaoFisica" name="avaliacaoFisica" data-live-search="true">
                                                <option value="">Selecione um aluno</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-sm-12">
                                            <label for="data">Data de Criação <span class="text-danger font-weight-bold">*</span></label>
                                            <input type="datetime-local" class="form-control" id="data" name="data" required>
                                        </div>
                                        <div class="col-lg-2 col-sm-12">
                                            <label for="dataInicio">Data de Inicio <span class="text-danger font-weight-bold">*</span></label>
                                            <input type="date" class="form-control" id="dataInicio" name="dataInicio" required>
                                        </div>
                                        <div class="col-lg-2 col-sm-12">
                                            <label for="dataFim">Data de Fim <span class="text-danger font-weight-bold">*</span></label>
                                            <input type="date" class="form-control" id="dataFim" name="dataFim" required>
                                        </div>
                                        <div class="col-lg-2 col-sm-12">
                                            <label for="grupoMuscular">Grupo Muscular </label>
                                            <select class="form-control selectpicker" data-actions-box="true" data-live-search="true" name="grupoMuscular" id="grupoMuscular"></select>
                                        </div>
                                        <div class="col-lg-2 col-sm-12">
                                            <label for="exercicioFisico">Exercicios Físicos</label>
                                            <select class="form-control selectpicker" data-live-search="true" data-action-box="true" id="exercicioFisico" name="exercicioFisico">
                                                <option value="">Selecione um Grupo Muscular</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 col-sm-12">
                                            <label for="series">Séries</label>
                                            <input type="text" class="form-control" id="series" name="series">
                                        </div>
                                        <div class="col-lg-1 col-sm-12">
                                            <label for="repeticoes">Repetições</label>
                                            <input type="text" class="form-control" id="repeticoes" name="repeticoes">
                                        </div>
                                        <div class="col-lg-2 col-sm-12">
                                            <label for="peso">Peso Sugerido</label>
                                            <input type="text" class="form-control" id="peso" name="peso">
                                        </div>
                                        <div class="col-lg-2 col-sm-11 col-11">
                                            <label for="diaExercicio">Dia do Exercício</label>
                                            <select class="form-control" id="diaExercicio" name="diaExercicio">
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-sm-1 col-1">
                                            <div></div>
                                            <a href="javascript:void(0)" class="text-success d-block" title="Adicionar Exercício à Lista" onclick="_treinos.adicionarExercicios()"><i style="font-size: 25px;margin-top: 36px" class="fa-solid fa-circle-plus"></i></a>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-12 col-md-12">
                                            <label for="listaExercicios">Lista de Exercicios <span class="text-danger font-weight-bold">*</span></label>
                                            <input type="text" id="listaExercicios" name="listaExercicios">
                                        </div>
                                    </div>
                                    <div class="row justify-content-end mt-3 mr-2">
                                        <button type="submit" class="btn btn-outline-success" onclick="_treinos.cadastrar()"><i class="far fa-check-square mr-1"></i> Cadastrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /.col-md-6 -->
                </div>
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fa-solid fa-hand-fist"></i> Lista de Treinos</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" style="font-size: 13px;" id="tabelaTreinos">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Aluno</th>
                                                <th scope="col">Avaliação Física</th>
                                                <th scope="col">Data de Criação</th>
                                                <th scope="col">Data de Inicio</th>
                                                <th scope="col">Data de Fim</th>
                                                <th scope="col">Treinador</th>
                                                <th scope="col">Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr>
                                                <td colspan="8" class="text-center">Carregando...</td>
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
    <div class="modal fade" id="modalTreino" tabindex="-1" role="dialog" aria-labelledby="modalTreinoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTreinoLabel">Visualizar Treino</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="row col-12 p-3" id="infoAluno">

                        </div>
                        <div class="col-12">
                            <h3 class="text-center">Treino</h3>
                           <table class="table table-hover table-striped" id="tabelaModal">
                               <thead>
                                    <tr>
                                        <th>Dia</th>
                                        <th>Grupo Muscular</th>
                                        <th>Exercicio Físico</th>
                                        <th>Series</th>
                                        <th>Repetições</th>
                                        <th>Peso Sugerido</th>
                                    </tr>
                               </thead>
                               <tbody id="tbodyModal">

                               </tbody>
                           </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
            </div>
        </div>
    </div>


<?php
include __DIR__."/../../Template/footer.php";
?>
<script src="/src/Treinos/View/assets/treinos.js"></script>
