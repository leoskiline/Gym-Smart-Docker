<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$_SESSION['informacoesSistema']->getNomeSistema();?> | Area de Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/src/Template/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/src/Template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/src/Template/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="/src/Usuario/View/css/usuario.css">
    <link rel="stylesheet" href="/src/Template/dist/css/global.css">
</head>
<body class="hold-transition login-page" style="min-height: 100%">
<noscript>
    <h1 style="font-weight: bolder;color:red">Navegador precisa estar com javascript habilitado para utilizar o sistema!</h1>
</noscript>
<div class="overlay-loader">
    <div class="loader">
        <div class="loader-inner one"></div>
        <div class="loader-inner two"></div>
        <div class="loader-inner three"></div>
    </div>
</div>
<div class="login-box">
    <!-- /.login-logo -->

    <div class="card card-outline card-primary">
        <div class="card-header text-center"><a href="/" class="h1"><?=$_SESSION['informacoesSistema']->getTituloLogin();?></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Faça o login para acessar o sistema.</p>

            <form onsubmit="return false;">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" id="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Senha" id="senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Lembrar-me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="button" class="btn btn-primary btn-block" onclick="_usuario.logar()">Entrar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>



        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/src/Template/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/src/Template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/src/Template/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="/src/Template/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/src/Template/dist/js/global.js"></script>
<script src="/node_modules/aes-js/index.js"></script>
<script src="/src/Usuario/View/js/Usuario.js"></script>
</body>
</html>
