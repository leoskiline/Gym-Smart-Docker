<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
<link rel="stylesheet" href="/src/Planos/View/assets/planos.css">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fa-solid fa-wallet mr-1"></i>Gerenciar Planos</h5>
                            </div>
                            <div class="card-body">
                              <form class="form" id="formPlanos" onsubmit="return false;">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <label for="descricao">Descrição <span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label for="atividadesFisicas">Atividades Físicas <span class="text-danger font-weight-bold">*</span></label>
                                        <select class="form-control selectpicker" data-actions-box="true" data-live-search="true" multiple name="atividadesFisicas" id="atividadesFisicas"></select>
                                    </div>
                                    <div class="col-lg-1 col-sm-12">
                                        <label for="tipoPlano">Tipo de Plano <span class="text-danger font-weight-bold">*</span></label>
                                        <select class="form-control" id="tipoPlano" name="tipoPlano" required>
                                            <option value="1">Mensal</option>
                                            <option value="2">Bimestral</option>
                                            <option value="3">Trimestral</option>
                                            <option value="6">Semestral</option>
                                            <option value="12">Anual</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="valor">Valor Mensal<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" class="form-control" id="valor" name="valor" required>
                                    </div>
                                    <div class="col-lg-1 col-sm-12">
                                        <label for="desconto">Desconto <span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" class="form-control" id="desconto" name="desconto" required value="0">
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="valorDesconto">Valor com Desconto <span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" class="form-control" id="valorDesconto" name="valorDesconto" required readonly>
                                    </div>
                                    <div class="col-12">
                                        <span> Todos os campos com <span class="text-danger font-weight-bold">*</span> são obrigatórios.</span>
                                    </div>
                                </div>
                                <div class="row justify-content-end mt-3 mr-2">
                                    <button type="submit" class="btn btn-outline-success" onclick="_planos.cadastrar()"><i class="far fa-check-square mr-1"></i> Cadastrar</button>
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
                                <h5 class="m-0"><i class="fa-solid fa-wallet"></i> Lista de Planos</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" style="font-size: 13px;">
                                        <thead>
                                            <tr>
                                                <th scope="col">Descrição</th>
                                                <th scope="col">Atividades Físicas</th>
                                                <th scope="col">Tipo de Plano</th>
                                                <th scope="col">Valor</th>
                                                <th scope="col">Desconto</th>
                                                <th scope="col">Valor com Desconto</th>
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
    <div class="modal fade" id="modalPlano" tabindex="-1" role="dialog" aria-labelledby="modalPlanoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPlanoLabel">Alterar Informações do Plano</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" id="formPlanoModal" onsubmit="return false;">
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <label for="descricaoModal">Descrição <span class="text-danger font-weight-bold">*</span></label>
                                    <input type="text" class="form-control" id="descricaoModal" name="descricaoModal" required>
                                    <input type="hidden" id="idPlanoModal" name="idPlanoModal" required>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="atividadesFisicasModal">Atividades Físicas <span class="text-danger font-weight-bold">*</span></label>
                                    <select class="form-control selectpicker" data-actions-box="true" data-live-search="true" multiple name="atividadesFisicasModal" id="atividadesFisicasModal"></select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="tipoPlanoModal">Tipo de Plano <span class="text-danger font-weight-bold">*</span></label>
                                    <select class="form-control" id="tipoPlanoModal" name="tipoPlanoModal" required>
                                        <option value="1">Mensal</option>
                                        <option value="2">Bimestral</option>
                                        <option value="3">Trimestral</option>
                                        <option value="6">Semestral</option>
                                        <option value="12">Anual</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="valorModal">Valor Mensal <span class="text-danger font-weight-bold">*</span></label>
                                    <input type="text" class="form-control" id="valorModal" name="valorModal" required>
                                </div>
                                <div class="col-lg-1 col-sm-12">
                                    <label for="descontoModal">Desconto <span class="text-danger font-weight-bold">*</span></label>
                                    <input type="text" class="form-control" id="descontoModal" name="descontoModal" required value="0">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="valorDescontoModal">Valor com Desconto <span class="text-danger font-weight-bold">*</span></label>
                                    <input type="text" class="form-control" id="valorDescontoModal" name="valorDescontoModal" required readonly>
                                </div>
                                <div class="col-12">
                                    <span> Todos os campos com <span class="text-danger font-weight-bold">*</span> são obrigatórios.</span>
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
<script src="/src/Planos/View/assets/planos.js"></script>
