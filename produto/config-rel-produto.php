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
        <h3 class="h3">Relatório de Produtos</h3>
        <br>
        <form method="POST" action="relatorio-produto.php" target="_blank">
            <div class="col-md-6">
                <label for="status">Status</label>
                <select class="form-control" name="status">
                    <option value="T">TODOS</option>
                    <option value="A">ATIVOS</option>
                    <option value="I">INATIVOS</option>
                </select><br>
            </div>
            <div class="col-md-6">
                <label for="ordem">Ordenar por:</label>
                <select class="form-control" name="ordem">
                    <option value="codigo">CÓDIGO</option>
                    <option value="descricao">DESCRIÇÃO</option>
                </select><br>
            </div>
            <button class="btn btn-success" type="submit" name="btnenviar"><i class="fa fa-print"></i> Visualizar Relatório</button>
        </form>
        <br>
        <br><br>
    </div>
    <br />
    </div>
    <!-- /page content -->
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
</body>

</html>