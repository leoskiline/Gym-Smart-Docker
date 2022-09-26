<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuração do Sistema</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/src/Template/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/src/Template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/src/Template/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="/src/Usuario/View/css/usuario.css">
    <link rel="stylesheet" href="/src/Template/plugins/bs-stepper/css/bs-stepper.min.css">
</head>
<body class="hold-transition configuracao-page">
<noscript>
    <h1 style="font-weight: bolder;color:red">Navegador precisa estar com javascript habilitado para utilizar o sistema!</h1>
</noscript>
<div class="configuracao-box" style="max-height: 100vh;overflow-y: auto;">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="/" class="h1">Página de Configuração do Sistema</a>
        </div>
        <div class="card-body">
            <form id="formConfiguracao" name="formConfiguracao" onsubmit="return false;">
                <div class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#logins-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label" style="white-space: break-spaces;">Informações do Sistema</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#information-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label" style="white-space: break-spaces;">Informações do Administrador</span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <!-- your steps content here -->
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h2>Informações do Sistema</h2>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label for="tituloLogin">Titulo Longo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="tituloLogin" name="tituloLogin" required>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label for="tituloNavbar">Titulo Curto <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="tituloNavbar" name="tituloNavbar" required>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label for="nomeSistema">Nome do Sistema <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nomeSistema" name="nomeSistema" required>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label for="cnpj">CNPJ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cnpj" name="cnpj" required>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label for="contato">Contato <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="contato" name="contato" required>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label for="emailSistema">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="emailSistema" name="emailSistema" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="sistemaCep">CEP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sistemaCep" name="sistemaCep" required>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <label for="sistemaRua">Endereço <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sistemaRua" name="sistemaRua" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="sistemaNrcasa">Número <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" min="0" id="sistemaNrcasa" name="sistemaNrcasa" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="sistemaBairro">Bairro <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sistemaBairro" name="sistemaBairro" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="sistemaCidade">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sistemaCidade" name="sistemaCidade" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="sistemaEstado">Estado <span class="text-danger">*</span></label>
                                    <select class="form-control" id="sistemaEstado" name="sistemaEstado" required>
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
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="sistemaPais">Pais <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sistemaPais" name="sistemaPais" required>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label for="logo">Logo do Sistema</label>
                                    <input type="file" accept="image/png"  id="logo" name="logo">
                                </div>
                            </div>
                            <div class="row justify-content-start ml-2 mt-3">Todos os Campos com <span class="text-danger font-weight-bold mx-1">*</span> são obrigatórios.</div>
                            <button class="btn btn-primary float-right" onclick="_Configuracao.proximo()">Proximo</button>
                        </div>
                        <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                            <div class="row mt-2">
                                <div class="col-lg-12 text-center">
                                    <h2>Informações do Administrador</h2>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="email">E-mail <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="senha">Senha <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="nome">Nome <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="salario">Salário <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="salario" name="salario" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="dataNascimento">Data de Nascimento <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="sexo">Sexo <span class="text-danger">*</span></label>
                                    <select class="form-control" id="sexo" name="sexo" required>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Feminino">Feminino</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="estadoCivil">Estado Civil <span class="text-danger">*</span></label>
                                    <select class="form-control" id="estadoCivil" name="estadoCivil" required>
                                        <option value="Solteiro">Solteiro</option>
                                        <option value="Casado">Casado</option>
                                        <option value="Divorciado">Divorciado</option>
                                        <option value="Viuvo">Viuvo</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="cep">CEP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cep" name="cep" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="rua">Endereço <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="rua" name="rua" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="nrcasa">Número <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" min="0" id="nrcasa" name="nrcasa" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="bairro">Bairro <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="cidade">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
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
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="pais">Pais <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pais" name="pais" required>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <label for="telefone">Contato <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="contatoadm" name="contatoadm" required>
                                </div>
                            </div>
                            <div class="row justify-content-start ml-2 mt-3">Todos os Campos com <span class="text-danger font-weight-bold mx-1">*</span> são obrigatórios.</div>
                            <div class="row justify-content-between mt-3 mr-2">
                                <button type="submit" class="btn btn-primary" onclick="_Configuracao.voltar()">Voltar</button>
                                <button type="submit" class="btn btn-success" onclick="_Configuracao.Cadastrar()">Cadastrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/node_modules/jquery/dist/jquery.min.js"></script>

<!-- jQuery Validator -->
<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="/node_modules/jquery-validation/dist/additional-methods.min.js"></script>
<script src="/node_modules/jquery-validation/dist/localization/messages_pt_BR.min.js"></script>
<script src="/node_modules/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/src/Template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/src/Template/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="/src/Template/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/src/Template/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="/node_modules/trans-form/dist/transForm.min.js"></script>
<script src="/src/Usuario/View/js/configuracao.js"></script>
</body>
</html>
