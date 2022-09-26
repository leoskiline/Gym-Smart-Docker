<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
<link rel="stylesheet" href="/src/Template/plugins/imageviewer/assets/css/master.css">
<link rel="stylesheet" href="/src/Sistema/View/assets/sistema.css">
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg-12">
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <a href="/Parametrizacao" class="h3"><i class="fa-solid fa-sitemap"></i> Informações do Sistema</a>
                    </div>
                    <div class="card-body">
                        <form id="formConfiguracao" name="formConfiguracao" onsubmit="return false;">
                            <div class="row">
                                <div class="col-12 text-center">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="tituloLogin">Titulo Login <span class="text-danger">*</span></label>
                                    <input type="hidden" id="idInformacoes_Sistema" name="idInformacoes_Sistema" value="<?=$_SESSION['informacoesSistema']->getIdInformacoesSistema()?>">
                                    <input type="text" class="form-control" id="tituloLogin" name="tituloLogin" value="<?=$_SESSION['informacoesSistema']->getTituloLogin()?>" required>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="tituloNavbar">Titulo Barra de Navegação <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="tituloNavbar" name="tituloNavbar" value="<?=$_SESSION['informacoesSistema']->getTituloNavbar()?>" required>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="nomeSistema">Nome do Sistema <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nomeSistema" name="nomeSistema" value="<?=$_SESSION['informacoesSistema']->getNomeSistema()?>" required>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="cnpj">CNPJ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?=$_SESSION['informacoesSistema']->getCnpj()?>" required>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="contato">Contato <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="contato" name="contato" value="<?=$_SESSION['informacoesSistema']->getContato()?>" required>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="emailSistema">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="emailSistema" name="emailSistema" value="<?=$_SESSION['informacoesSistema']->getEmail()?>" required>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label for="cep">CEP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cep" name="cep" value="<?=$_SESSION['informacoesSistema']->getCep()?>" required>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label for="rua">Endereço <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="rua" name="rua" value="<?=$_SESSION['informacoesSistema']->getRua()?>" required>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label for="nrcasa">Número <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" min="0" id="nrcasa" name="nrcasa" value="<?=$_SESSION['informacoesSistema']->getNrcasa()?>" required>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label for="bairro">Bairro <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" value="<?=$_SESSION['informacoesSistema']->getBairro()?>" required>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label for="cidade">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" value="<?=$_SESSION['informacoesSistema']->getCidade()?>" required>
                                </div>
                                <div class="col-lg-3 col-sm-12">
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
                                <div class="col-lg-3 col-sm-12">
                                    <label for="pais">Pais <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pais" name="pais" value="<?=$_SESSION['informacoesSistema']->getPais()?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="logo">Logo do Sistema</label>
                                    <div class="col-12 images">
                                        <input type="file" accept="image/png" id="logo" name="logo" class="col-lg-4 col-sm-12">
                                        <img class="thumbnail" title="Logo atual" src="<?=$_SESSION['informacoesSistema']->getLogo()?>" style="max-height: 120px">
                                        <span class="float-right">Todos os Campos com <span class="text-danger font-weight-bold mx-1">*</span> são obrigatórios.</span>
                                        <div id="image-viewer">
                                            <span class="close">&times;</span>
                                            <img class="modal-content" id="full-image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end mt-3 mr-2">
                                <button type="submit" class="btn btn-outline-success" onclick="_Sistema.Atualizar()">Atualizar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>

<?php
include __DIR__."/../../Template/footer.php";
?>
<script src="/src/Template/plugins/imageviewer/assets/js/main.js"></script>
<script src="/src/Sistema/View/assets/sistema.js"></script>
<script>
    document.getElementById("estado").value = '<?=$_SESSION['informacoesSistema']->getUf()?>'
</script>

