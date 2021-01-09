<?php 

include_once '../util/conexao.php'; 

?>

<!doctype html>
<html class="corpo_login" lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/favicon.ico" type="image/ico" />

    <title><?= $_SESSION['empresa'] ?> | GHI Tecnologia</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../css/custom.min.css" rel="stylesheet">

    <link href="../css/estilo.css" rel="stylesheet">
</head>

<body class="nav-md">
    <?php
    include_once '../layout/cabecalho.php';
    ?>

    <!-- page content -->
    <div class="right_col" role="main">
        <h3 class="h3">Relatório de Títulos à Receber</h3>
        <br>
        <form method="POST" action="relatorio-receber.php" target="_blank">

            <fieldset class="col-md-12">
                <legend>Filtrar por:</legend>
                <div class="col-md-12">
                    <label for="obra">Obra</label>
                </div>
                <div class="col-md-1">
                    <input class="form-control" type="text" name="obra" id="obra" readonly />
                </div>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="nomeobra" id="nomeobra" readonly />
                </div>
                <div class="col-md-1">
                    <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqObra">
                        <i class="fa fa-search"></i>
                    </button>
                </div>

                <div class="col-md-12">
                    <label for="cliente">Cliente</label>
                </div>
                <div class="col-md-1">
                    <input class="form-control" type="text" name="cliente" id="cliente" readonly />
                </div>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="nomecliente" id="nomecliente" readonly />
                </div>
                <div class="col-md-1">
                    <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqCliente">
                        <i class="fa fa-search"></i>
                    </button>
                </div>

                <div class="col-md-5">
                    <label for="ordem">Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="TODOS">TODOS</option>
                        <option value="ABERTOS">ABERTOS</option>
                        <option value="PAGOS">PAGOS</option>
                    </select><br>
                </div>
            </fieldset>
            <fieldset class="col-md-12">
                <legend>Data Vencimento</legend>
                <div class="col-md-4">
                    <label for="dtInicio">Inicial *</label>
                    <input class="form-control" type="date" name="dtInicio" id="dtInicio" required />
                </div>
                <div class="col-md-4">
                    <label for="dtFim">Final *</label>
                    <input class="form-control" type="date" name="dtFim" id="dtFim" required /><br>
                </div>
            </fieldset>
            <fieldset class="col-md-12">
                <legend>Ordernar por: *</legend>
                <div class="col-md-4">
                    <input type="radio" value="VENCIMENTO" name="ordem" required checked> DATA VENCIMENTO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" value="VALOR" name="ordem"> VALOR<br><br><br>
                </div>
            </fieldset>
            <div class="col-md-12">
                <button class="btn btn-success" type="submit" name="btnenviar"><i class="fa fa-print"></i> Visualizar Relatório</button>
            </div>
        </form>
        <br>
        <br><br>
    </div>
    <br />
    </div>
    <!-- /page content -->


    <!-- Modal Obra -->

    <div class="modal fade" id="pesqObra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;
                        </span></button>
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisa de Obra</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-pesquisa">
                        <input class="form-control" type="text" name="pesquisa-obra" id="pesquisa-obra" placeholder="Digite o nome da obra" />
                    </form><br>
                    <small>Clique no resultado para selecionar</small>
                    <ul class="obra"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fim modal -->

    <!-- Modal Cliente -->

    <div class="modal fade" id="pesqCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;
                        </span></button>
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisa de Cliente</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-pesquisa">
                        <input class="form-control" type="text" name="pesquisa-cliente" id="pesquisa-cliente" placeholder="Digite o nome do cliente" />
                    </form><br>
                    <small>Clique no resultado para selecionar</small>
                    <ul class="cliente"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fim modal -->


    <?php
    include_once '../layout/rodape.php';
    ?>

    </div>

    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.min.js"></script>
    <!-- < !-- Pesquisas modal -->
    <script src="../js/pesquisas-modal.js"></script>
</body>

</html>