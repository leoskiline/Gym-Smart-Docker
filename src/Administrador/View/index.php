<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
<link rel="stylesheet" href="/src/Administrador/View/assets/administrador.css">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fas fa-user-cog"></i> Gerenciar Administradores</h5>
                            </div>
                            <div class="card-body">
                              <form class="form" id="formCadastro" onsubmit="return false;">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <label for="nome">Nome <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="salario">Salario <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="salario" name="salario" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="dataNascimento">Data de Nascimento <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="sexo">Sexo <span class="text-danger">*</span></label>
                                        <select class="form-control" id="sexo" name="sexo" required>
                                            <option value="Feminino">Feminino</option>
                                            <option value="Masculino">Masculino</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="estadoCivil">Estado Civil <span class="text-danger">*</span></label>
                                        <select class="form-control" id="estadoCivil" name="estadoCivil" required>
                                            <option value="Solteiro">Solteiro</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Viuvo">Viuvo</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="cep">CEP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cep" name="cep" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="rua">Rua <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="rua" name="rua" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="nrcasa">Numero <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nrcasa" name="nrcasa" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="bairro">Bairro <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="bairro" name="bairro" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="cidade">Cidade <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cidade" name="cidade" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="estado">Estado <span class="text-danger">*</span></label>
                                        <select class="form-control" id="estado" name="estado" required>
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amap??</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Cear??</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Esp??rito Santo</option>
                                            <option value="GO">Goi??s</option>
                                            <option value="MA">Maranh??o</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Par??</option>
                                            <option value="PB">Para??ba</option>
                                            <option value="PR">Paran??</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piau??</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rond??nia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">S??o Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="pais">Pais <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pais" name="pais" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="contato">Contato</label>
                                        <input type="text" class="form-control" id="contato" name="contato">
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label for="email">E-mail <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="senha">Senha <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="senha" name="senha" required>
                                    </div>
                                </div>
                                <div class="row justify-content-between mt-3 mr-2">
                                    <span>Todos os campos com <span class="text-danger">*</span> s??o obrigat??rios.</span>
                                    <button type="submit" class="btn btn-outline-success" onclick="_administrador.cadastrar()"><i class="far fa-check-square mr-1"></i> Cadastrar</button>
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
                                <h5 class="m-0"><i class="fas fa-users"></i> Lista de Administradores</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" style="font-size: 13px;">
                                        <thead>
                                            <tr>
                                                <th scope="col">Codigo</th>
                                                <th scope="col">Informa????es Pessoais</th>
                                                <th scope="col">Endere??o</th>
                                                <th scope="col">Contato</th>
                                                <th scope="col">Op????es</th>
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
                <form class="form" id="formAlterar" onsubmit="return false;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAlunoLabel">Alterar Informa????es do Administrador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label for="ModalNome">Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalNome" name="ModalNome" required>
                                    <input type="hidden" id="ModalIdAdministrador">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalSalario">Salario <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalSalario" name="ModalSalario" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalDataNascimento">Data de Nascimento <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="ModalDataNascimento" name="ModalDataNascimento" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalSexo">Sexo <span class="text-danger">*</span></label>
                                    <select class="form-control" id="ModalSexo" name="ModalSexo" required>
                                        <option value="Feminino">Feminino</option>
                                        <option value="Masculino">Masculino</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalEstadoCivil">Estado Civil <span class="text-danger">*</span></label>
                                    <select class="form-control" id="ModalEstadoCivil" name="ModalEstadoCivil" required>
                                        <option value="Solteiro">Solteiro</option>
                                        <option value="Casado">Casado</option>
                                        <option value="Divorciado">Divorciado</option>
                                        <option value="Viuvo">Viuvo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalCep">CEP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalCep" name="ModalCep" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalRua">Rua <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalRua" name="ModalRua" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalNrCasa">N??mero <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalNrCasa" name="ModalNrCasa" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalBairro">Bairro <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalBairro" name="ModalBairro" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalCidade">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalCidade" name="ModalCidade" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalEstado">UF <span class="text-danger">*</span></label>
                                    <select class="form-control" id="ModalEstado" name="ModalEstado" required>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amap??</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Cear??</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Esp??rito Santo</option>
                                        <option value="GO">Goi??s</option>
                                        <option value="MA">Maranh??o</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Par??</option>
                                        <option value="PB">Para??ba</option>
                                        <option value="PR">Paran??</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piau??</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rond??nia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">S??o Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalPais">Pais <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalPais" name="ModalPais" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalContato">Contato</label>
                                    <input type="text" class="form-control" id="ModalContato" name="ModalContato">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="ModalEmail">E-mail <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalEmail" name="ModalEmail" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalSenha">Senha <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="ModalSenha" name="ModalSenha" required>
                                </div>
                            </div>
                            <div class="row">
                                <span>Todos os campos com <span class="text-danger">*</span> s??o obrigat??rios.</span>
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
<script src="/src/Administrador/View/assets/administrador.js"></script>
