<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
<link rel="stylesheet" href="/src/AtividadeFisica/View/assets/atividadefisica.css">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fas fa-running"></i> Gerenciar Atividade Fisica</h5>
                            </div>
                            <div class="card-body">
                              <form class="form" id="formAtividadeFisica" onsubmit="return false;">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <label for="atividadeFisica">Atividade Fisica <span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" class="form-control" id="atividadeFisica" name="atividadeFisica" required>
                                    </div>
                                    <div class="col-12">
                                        <span> Todos os campos com <span class="text-danger font-weight-bold">*</span> são obrigatórios.</span>
                                    </div>
                                </div>
                                <div class="row justify-content-end mt-3 mr-2">
                                    <button type="submit" class="btn btn-outline-success" onclick="_atividade.cadastrar()"><i class="far fa-check-square mr-1"></i> Cadastrar</button>
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
                            <div class="card-header">
                                <h5 class="m-0"><i class="fas fa-dumbbell"></i> Lista de Atividades Físicas</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" style="font-size: 13px;">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 40%;">Descrição Atividade Física</th>
                                                <th scope="col" style="width: 40%;">Ativa</th>
                                                <th scope="col" style="width: 20%;">Opçõces</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr>
                                                <td colspan="3" class="text-center">Carregando...</td>
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
                    <h5 class="modal-title" id="modalAlunoLabel">Alterar Informações da Atividade Física</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" id="formAtividadeFisicaModal" onsubmit="return false;">
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <label for="ModalDescricao">Atividade Física</label>
                                    <input type="hidden" id="ModalIdAtividadeFisica" name="ModalIdAtividadeFisica" required>
                                    <input type="text" class="form-control" id="ModalDescricao" name="ModalDescricao" required>
                                </div>
                                <div class="col-6">
                                    <label for="ModalAtiva">Ativa</label>
                                    <select class="form-control" id="ModalAtiva" name="ModalAtiva" required>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success" id="botaoSalvar"><i class="far fa-check-square mr-1"></i> Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
include __DIR__."/../../Template/footer.php";
?>
<script src="/src/AtividadeFisica/View/assets/atividadefisica.js"></script>
