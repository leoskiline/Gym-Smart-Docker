<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
<link rel="stylesheet" href="/src/Despesas/View/assets/despesas.css">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fa-solid fa-cash-register mr-1"></i>Gerenciar Despesas</h5>
                            </div>
                            <div class="card-body">
                              <form class="form" id="formDespesas" onsubmit="return false;">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <label for="descricao">Descrição <span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="tipo">Tipo de Despesa <span class="text-danger font-weight-bold">*</span></label>
                                        <select class="form-control" id="tipo" name="tipo" required>
                                            <option value="Fixa">Fixa</option>
                                            <option value="Variavél">Variável</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label for="fornecedor">Fornecedor <span class="text-danger font-weight-bold">*</span></label>
                                        <select class="form-control selectpicker" data-actions-box="true" data-live-search="true" name="fornecedor" id="fornecedor"></select>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="dataVencimento">Data de Vencimento <span class="text-danger font-weight-bold">*</span></label>
                                        <input type="date" class="form-control" id="dataVencimento" name="dataVencimento" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="valorDespesa">Valor da Despesa <span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" class="form-control" id="valorDespesa" name="valorDespesa" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="dataPagamento">Data do Pagamento</label>
                                        <input type="date" class="form-control" id="dataPagamento" name="dataPagamento">
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="valorPagamento">Valor do Pagamento</label>
                                        <input type="text" class="form-control" id="valorPagamento" name="valorPagamento">
                                    </div>
                                    <div class="col-12">
                                        <span> Todos os campos com <span class="text-danger font-weight-bold">*</span> são obrigatórios.</span>
                                    </div>
                                </div>
                                <div class="row justify-content-end mt-3 mr-2">
                                    <button type="submit" class="btn btn-outline-success" onclick="_despesas.cadastrar()"><i class="far fa-check-square mr-1"></i> Cadastrar</button>
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
                            <div class="card-header d-flex">
                                <h5 class="m-0"><i class="fa-solid fa-cash-register"></i> Lista de Despesas</h5>
                                <button type="button" class="btn btn-success ml-auto" data-toggle="modal" data-target="#modalRelatorioDespesas">
                                    Relatório Despesas/Receitas por Periodo
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" style="font-size: 13px;">
                                        <thead>
                                            <tr>
                                                <th scope="col">Descrição</th>
                                                <th scope="col">Fornecedor</th>
                                                <th scope="col">Cadastrado por</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Data de Vencimento</th>
                                                <th scope="col">Valor da Despesa</th>
                                                <th scope="col">Data de Pagamento</th>
                                                <th scope="col">Valor de Pagamento</th>
                                                <th scope="col">Status de Pagamento</th>
                                                <th scope="col">Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr>
                                                <td colspan="10" class="text-center">Carregando...</td>
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

<div class="modal fade" id="modalRelatorioDespesas" tabindex="-1" role="dialog" aria-labelledby="modalRelatorioDespesasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="min-width: 50%">
        <form id="formRelatorio" onsubmit="return false;" style="min-width: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRelatorioDespesasLabel">Relatório Despesas/Receitas (Periodo)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <label for="relDataInicial">Data Inicial</label>
                            <input type="date" class="form-control" id="relDataInicial" name="relDataInicial" required>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="relDataFinal">Data Final</label>
                            <input type="date" class="form-control" id="relDataFinal" name="relDataFinal" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success" onclick="_despesas.gerarRelatorio()">Gerar</button>
                </div>
            </div>
        </form>
    </div>
</div>

    <div class="modal fade" id="modalDespesa" tabindex="-1" role="dialog" aria-labelledby="modalDespesaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDespesaLabel">Alterar Informações do Plano</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" id="formDespesaModal" onsubmit="return false;">
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <label for="descricaoModal">Descrição <span class="text-danger font-weight-bold">*</span></label>
                                    <input type="text" class="form-control" id="descricaoModal" name="descricaoModal" required>
                                    <input type="hidden" id="idDespesa" name="idDespesa">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="tipoModal">Tipo de Despesa <span class="text-danger font-weight-bold">*</span></label>
                                    <select class="form-control" id="tipoModal" name="tipoModal" required>
                                        <option value="Fixa">Fixa</option>
                                        <option value="Variavél">Variável</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label for="fornecedorModal">Fornecedor <span class="text-danger font-weight-bold">*</span></label>
                                    <select class="form-control selectpicker" data-actions-box="true" data-live-search="true" name="fornecedorModal" id="fornecedorModal"></select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="dataVencimentoModal">Data de Vencimento <span class="text-danger font-weight-bold">*</span></label>
                                    <input type="date" class="form-control" id="dataVencimentoModal" name="dataVencimentoModal" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="valorDespesaModal">Valor da Despesa <span class="text-danger font-weight-bold">*</span></label>
                                    <input type="text" class="form-control" id="valorDespesaModal" name="valorDespesaModal" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="dataPagamentoModal">Data de Pagamento</label>
                                    <input type="date" class="form-control" id="dataPagamentoModal" name="dataPagamentoModal">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="valorPagamentoModal">Valor do Pagamento</label>
                                    <input type="text" class="form-control" id="valorPagamentoModal" name="valorPagamentoModal">
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
<script src="/src/Despesas/View/assets/despesas.js"></script>
