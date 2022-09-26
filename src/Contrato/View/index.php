<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
<link rel="stylesheet" href="/src/Contrato/View/assets/contrato.css">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="m-0"><i class="fas fa-id-card mr-1"></i>Gerenciar Contratos</h5>
<!--                                <i class="fa-solid fa-circle-question ml-auto" title="Ajuda" style="cursor:pointer" onclick="_global.introJsPTBR()"></i>-->
                            </div>
                            <div class="card-body" data-title="Cadastro de Contrato." data-intro="Nesse card você poderá efetuar o cadastramento de contrato dos alunos. Todos os campos são obrigatórios.">
                              <form class="form" id="formContrato" onsubmit="return false;">
                                <div class="col-12 row">
                                    <div class="col-lg-5 col-sm-12">
                                        <label for="aluno">Aluno <span class="text-danger">*</span></label><a href="/Gerenciar/Aluno" target="_blank" title="Cadastrar Novo Aluno" data-title="Novo Aluno." data-intro="Nesse botão você poderá abrir a página de gerenciar alunos para cadastrar um novo aluno caso seja necessário."><i class="fas fa-plus-circle" style="font-size: 1.0em;margin-left: 5px;"></i></a> <a data-title="Atualizar Alunos." data-intro="Nesse botão você poderá atualizar a lista de alunos do campo abaixo com um simples clique." href="javascript:void(0)" onclick="_contrato.obterAlunos()" title="Atualizar Alunos"><i id="loading" class="fa-solid fa-rotate" style="font-size: 1.0em;margin-left:5px"></i></a>
                                        <select class="selectpicker col-12 pl-0" id="aluno" name="aluno" data-live-search="true"></select>
                                    </div>
                                    <div class="col-lg-5 col-sm-12">
                                        <label for="plano">Planos <span class="text-danger">*</span></label>
                                        <select class="selectpicker col-12 pl-0" id="plano" name="plano"></select>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="dataContrato">Data do Contrato <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control col-12 pl-0" id="dataContrato" name="dataContrato" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="dataInicial">Data Inicial <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control col-12 pl-0" id="dataInicial" name="dataInicial" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="dataFinal">Data Final</label>
                                        <input type="date" class="form-control col-12 pl-0" id="dataFinal" name="dataFinal" readonly>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="diaPagamento">Dia de Pagamento <span class="text-danger">*</span></label>
                                        <select class="form-control col-12 pl-0" id="diaPagamento" name="diaPagamento" required>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="formasPagamento">Forma de Pagamento <span class="text-danger">*</span></label>
                                        <select class="form-control" id="formasPagamento" name="formasPagamento" required></select>
                                    </div>
                                </div>
                                <div class="row justify-content-between mt-3 mr-2">
                                    <span> Todos os campos com <span class="text-danger font-weight-bold">*</span> são obrigatórios.</span>
                                    <button type="submit" class="btn btn-outline-success" data-title="Efetuar Cadastro" data-intro="Com o preenchimento de todos os campos você pode cadastrar o novo contrato nesse botão." onclick="_contrato.cadastrar()"><i class="far fa-check-square mr-1"></i> Cadastrar</button>
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

                        <div class="card" data-title="Contratos." data-intro="Nesse card você visualizará todos os contratos cadastrados, estejam eles cancelados ou não. Aqui você terá possibilidade de visualizar as mensalidades para quitar ou estornar, alterar dia de pagamento, cancelar contrato ou visualizar atividades físicas de cada contrato através do plano.">
                            <div class="card-header d-flex">
                                <h5 class="m-0"><i class="fas fa-id-card mr-1"></i>Lista de Contratos</h5>

                                <button type="button" class="btn btn-success ml-auto" data-title="Relatório" data-intro="Nesse botão você poderá extrair um relatório em PDF de contratos de determinado período." data-toggle="modal" data-target="#modalRelatorioContrato">
                                    Relatório por Periodo
                                </button>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" id="tableContratos" style="font-size: 13px;">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código Contrato</th>
                                                <th scope="col">Aluno</th>
                                                <th scope="col">Plano</th>
                                                <th scope="col">Data do Contrato</th>
                                                <th scope="col">Data de Inicio</th>
                                                <th scope="col">Data Fim</th>
                                                <th scope="col">Data Cancelamento</th>
                                                <th scope="col">Valor</th>
                                                <th scope="col">Dia de Pagamento</th>
                                                <th scope="col">Mensalidades</th>
                                                <th scope="col" style="min-width: 200px;">Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tContratos">
                                            <tr>
                                                <td colspan="11" class="text-center">Carregando...</td>
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
<div class="modal fade" id="modalRelatorioContrato" tabindex="-1" role="dialog" aria-labelledby="modalRelatorioContratoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="min-width: 50%">
        <form id="formRelatorio" onsubmit="return false;" style="min-width: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRelatorioContratoLabel">Relatório de Contratos (Periodo)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <label for="relContratoDataInicial">Data Inicial</label>
                            <input type="date" class="form-control" id="relContratoDataInicial" name="relContratoDataInicial" required>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="relContratoDataFinal">Data Final</label>
                            <input type="date" class="form-control" id="relContratoDataFinal" name="relContratoDataFinal" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success" onclick="_contrato.gerarRelatorio()">Gerar</button>
                </div>
          </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalMensalidade" tabindex="-1" role="dialog" aria-labelledby="modalMensalidadeLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="min-width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMensalidadeLabel">Mensalidades do Contrato</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tabelaMensalidades">
                            <thead>
                            <tr>
                                <th style="width: 30%">Cliente</th>
                                <th>Valor</th>
                                <th>Forma de Pagamento</th>
                                <th>Data de Vencimento</th>
                                <th>Data de Pagamento</th>
                                <th>Pagamento</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyMensalidade">

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
                                <div class="col-3">
                                    <label for="descricaoModal">Descrição <span class="text-danger font-weight-bold">*</span></label>
                                    <input type="text" class="form-control" id="descricaoModal" name="descricaoModal" required>
                                    <input type="hidden" id="idPlanoModal" name="idPlanoModal" required>
                                </div>
                                <div class="col-4">
                                    <label for="atividadesFisicasModal">Atividades Físicas <span class="text-danger font-weight-bold">*</span></label>
                                    <select class="form-control selectpicker" data-actions-box="true" data-live-search="true" multiple name="atividadesFisicasModal" id="atividadesFisicasModal"></select>
                                </div>
                                <div class="col-2">
                                    <label for="valorModal">Valor <span class="text-danger font-weight-bold">*</span></label>
                                    <input type="text" class="form-control" id="valorModal" name="valorModal" required>
                                </div>
                                <div class="col-1">
                                    <label for="descontoModal">Desconto <span class="text-danger font-weight-bold">*</span></label>
                                    <input type="text" class="form-control" id="descontoModal" name="descontoModal" required value="0">
                                </div>
                                <div class="col-2">
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
<script src="/src/Contrato/View/assets/contrato.js"></script>
