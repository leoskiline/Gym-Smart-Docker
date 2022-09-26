<?php

use App\Sistema\Controller\MenuController;

include __DIR__."/../Utils/validaSessao.php";
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$_SESSION['informacoesSistema']->getNomeSistema();?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/src/Template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/src/Template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/src/Template/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/src/Template/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/src/Template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/src/Template/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/src/Template/plugins/summernote/summernote-bs4.min.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="/node_modules/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="/node_modules/intro.js/minified/introjs.min.css">

    <!-- Calendar -->
    <link rel="stylesheet" href="/node_modules/fullcalendar-scheduler/main.min.css">

    <!-- Select Picker -->
    <link rel="stylesheet" href="/node_modules/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/node_modules/@yaireo/tagify/dist/tagify.css">
    <link rel="stylesheet" href="/src/Template/dist/css/global.css">
</head>
<body class="hold-transition sidebar-mini">
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
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item">
               <div class="dropdown">
                   <a class="nav-link" data-toggle="dropdown" aria-expanded="false" href="javascript:void(0)">
                       <i class="fa-solid fa-user mr-1"></i><?=MenuController::getNomeUsuario()?>
                   </a>
                   <div class="dropdown-menu">
                       <a class="dropdown-item" href="/Usuario/Logout"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
                       <a class="dropdown-item" href="/storage/manual/Manual%20do%20Usuário.pdf" target="_blank"><i class="fa-solid fa-book-atlas"></i> Manual do Usuário</a>
                   </div>
               </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/Dashboard" class="brand-link">
            <img src="<?=$_SESSION['informacoesSistema']->getLogo()?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light" style="white-space: break-spaces;"><?=$_SESSION['informacoesSistema']->getTituloNavbar();?></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar mt-2">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <?= MenuController::getMenu();?>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper mt-4">
        <!-- Content Header (Page header) -->
        <!-- /.content-header -->

