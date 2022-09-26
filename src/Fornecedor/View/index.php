<?php
include __DIR__."/../../Template/header.php";
?>
<link rel="stylesheet" href="/src/Fornecedor/View/assets/fornecedor.css">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fas fa-truck-moving"></i> Gerenciar Fornecedores</h5>
                            </div>
                            <div class="card-body">
                              <form class="form" id="formFornecedor" name="formFornecedor" onsubmit="return false;">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <label for="descricao">Descricao <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="contato">Contato <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="contato" name="contato" required>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="pessoaContato">Pessoa Contato <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pessoaContato" name="pessoaContato" required>
                                    </div>
                                </div>
                                <div class="row justify-content-between mt-3 mr-2">
                                    <span> Todos os campos com <span class="text-danger font-weight-bold">*</span> são obrigatórios.</span>
                                    <button type="submit" class="btn btn-outline-success" onclick="_fornecedor.cadastrar()"><i class="far fa-check-square mr-1"></i> Cadastrar</button>
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
                                <h5 class="m-0"><i class="fas fa-truck-moving"></i> Lista de Fornecedores</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" style="font-size: 13px;">
                                        <thead>
                                            <tr>
                                                <th scope="col">Descricao</th>
                                                <th scope="col">Contato</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Pessoa Contato</th>
                                                <th scope="col">Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr>
                                                <td colspan="6" class="text-center">Carregando...</td>
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
                <form class="form" id="formFornecedorModal" name="formFornecedorModal" onsubmit="return false;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAlunoLabel">Alterar Informações do Fornecedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <label for="ModalDescricao">Descricao <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalDescricao" name="ModalDescricao" required>
                                    <input type="hidden" id="ModalIdFornecedor" name="ModalIdFornecedor" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalContato">Contato <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalContato" name="ModalContato" required>
                                </div>
                                <div>
                                    <label for="ModalEmail">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="ModalEmail" name="ModalEmail" required></div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalPessoaContato">Pessoa Contato <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalPessoaContato" name="ModalPessoaContato" required></div>
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
<script src="/src/Fornecedor/View/assets/fornecedor.js"></script>
