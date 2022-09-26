<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
<link rel="stylesheet" href="/src/Professor/View/assets/professor.css">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fas fa-chalkboard-teacher"></i> Gerenciar Professores</h5>
                            </div>
                            <div class="card-body">
                              <form class="form" id="formProfessor" onsubmit="return false;">
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
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-1 col-sm-12">
                                        <label for="cep">CEP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cep" name="cep" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="rua">Rua <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="rua" name="rua" required>
                                    </div>
                                    <div class="col-lg-1 col-sm-12">
                                        <label for="nrcasa">Número <span class="text-danger">*</span></label>
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
                                            <option value="AP">Amapá</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PR">Paraná</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="pais">Pais <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pais" name="pais" required>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="cpf">CPF <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cpf" name="cpf" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="rg">RG <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="rg" name="rg" required>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label for="contato">Contato</label>
                                        <input type="text" class="form-control" id="contato" name="contato">
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label for="email">E-mail <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                  <div class="row mt-2 justify-content-end">
                                      <div class="col-lg-2 col-sm-12">
                                          <label for="senha">Senha <span class="text-danger">*</span></label>
                                          <input type="password" class="form-control" id="senha" name="senha" required>
                                      </div>
                                      <div class="col-lg-2 col-sm-12">
                                          <label for="dataAdmissao">Data de Admissao <span class="text-danger">*</span></label>
                                          <input type="date" class="form-control" id="dataAdmissao" name="dataAdmissao" required>
                                      </div>
                                      <div class="col-lg-2 col-sm-12">
                                          <label for="dataDemissao">Data de Demissao</label>
                                          <input type="date" class="form-control" id="dataDemissao" name="dataDemissao">
                                      </div>
                                  </div>
                                <div class="row justify-content-between mt-3 mr-2">
                                    <span> Todos os campos com <span class="text-danger font-weight-bold">*</span> são obrigatórios.</span>
                                    <button type="submit" class="btn btn-outline-success" onclick="_professor.cadastrar()"><i class="far fa-check-square mr-1"></i> Cadastrar</button>
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
                                <h5 class="m-0"><i class="fas fa-users"></i> Lista de Professores</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" style="font-size: 13px;">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Informações Pessoais</th>
                                                <th scope="col">Endereço</th>
                                                <th scope="col">Contato</th>
                                                <th scope="col">Informações Contratuais</th>
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
                <form class="form" id="formModal" onsubmit="return false;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAlunoLabel">Alterar Informações do Professor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label for="ModalNome">Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalNome" name="ModalNome" required>
                                    <input type="hidden" id="ModalIdProfessor" name="ModalIdProfessor" required>
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
                                    <label for="ModalNrCasa">Número <span class="text-danger">*</span></label>
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
                                    <label for="ModalEstado">Estado <span class="text-danger">*</span></label>
                                    <select class="form-control" id="ModalEstado" name="ModalEstado" required>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
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
                                <div class="col-lg-6 col-sm-12">
                                    <label for="ModalEmail">E-mail <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalEmail" name="ModalEmail" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalCPF">CPF <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalCPF" name="ModalCPF" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalRG">RG <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ModalRG" name="ModalRG" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="ModalSenha">Senha <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="ModalSenha" name="ModalSenha" required>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label for="ModalDataAdmissao">Data de Adminissao <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="ModalDataAdmissao" name="ModalDataAdmissao" required>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label for="ModalDataDemissao">Data de Demissao</label>
                                    <input type="date" class="form-control" id="ModalDataDemissao" name="ModalDataDemissao">
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
<script src="/src/Professor/View/assets/professor.js"></script>
