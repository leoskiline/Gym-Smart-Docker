<?php
include __DIR__."/../../Template/header.php";
include __DIR__."/../../Utils/validaSessao.php";
?>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-12 row">
                    <div class="col-lg-3 col-6 mt-2">

                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?=$data['quantidadeAlunosAtivos']?></h3>
                                <p>Alunos Com Contrato Ativo</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="/Contrato" class="small-box-footer">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-2">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?=$data['quantidadeMensaldadesAtraso']?></h3>
                                <p>Mensalidades com atraso</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-close"></i>
                            </div>
                            <a href="Contrato?atraso=1" class="small-box-footer">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-2">

                        <div class="small-box bg-warning" style="color:white !important;">
                            <div class="inner">
                                <h3><?=$data['quantidadeAvaliacoes']?></h3>
                                <p>Avaliações Físicas Hoje</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-calendar"></i>
                            </div>
                            <a href="/Gerenciar/AvaliacaoFisica" class="small-box-footer" style="color:white !important;">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-2">

                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>R$ <?=$data['valorMes']?></h3>
                                <p>Saldo Mensal</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-cash"></i>
                            </div>
                            <a href="/Despesas" class="small-box-footer">Visualizar <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0"><i class="fas fa-user-graduate"></i> Boas-Vindas.</h5>
                        </div>
                        <div class="card-body">
                            Bem-vindo ao sistema.
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


<?php
include __DIR__."/../../Template/footer.php";
?>