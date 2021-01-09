<?php 

include_once '../util/conexao.php';
include_once '../util/funcoes.php'; 

$sql = "select * from empresa";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);

$emp_razao = $dados['emp_razao'];
$emp_cidade = $dados['emp_cidade'];
$emp_estado = $dados['emp_estado'];

if(isset($_GET)):

    $id = $_GET['id'];

    $sql = "select p.*, f.for_razaosocial 
            from pagar p, fornecedor f 
            where p.pagar_fornecedor_id = f.for_id and p.pagar_id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    
    $for_razaosocial = mb_substr($dados['for_razaosocial'],0,35);
    $titulo = 'pagamento do título nº ' . $dados['pagar_numero'] . '-' . $dados['pagar_sequencia'];
    $valor = $dados['pagar_vl_final'];
    $valor = str_replace('.', ',', str_replace('', '.', $valor));
    $pagar_dt_pagto = $dados['pagar_dt_pagto'];

endif;

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
        <h3 class="h3">Impressão de Recibo</h3>
        <br>
        <form method="POST" action="recibo.php" target="_blank">
            <div class="col-md-12">
                <label for="recebi">RECEBI DE</label> 
                <input class="form-control" type="text" name="recebi" id="recebi" value="<?= $emp_razao ?>"/><br>
            </div>
            <div class="col-md-12">
                <label for="recebedor">RECEBEDOR</label> 
                <input class="form-control" type="text" name="recebedor" id="recebedor" value="<?= $for_razaosocial ?>"/><br>
            </div>
            <div class="col-md-12">
                <label for="referente">REFERENTE</label> 
                <input class="form-control" type="text" name="referente" id="referente" placeholder="Ex: pagamento de NF 233 de 23/01/2020" value="<?= $titulo ?>"/><br>
            </div>
            <div class="col-md-6">
                <label for="local">LOCAL</label> 
                <input class="form-control" type="text" name="local" id="local" placeholder="Digite a cidade/estado" value="<?= $emp_cidade . '/' . $emp_estado ?>"/><br>
            </div>
            <div class="col-md-6">
                <label for="data">DATA</label> 
                <input class="form-control" type="date" name="data" id="data" value="<?= $pagar_dt_pagto ?>"/><br>
            </div>
            <div class="col-md-6">
                <label for="valor">VALOR</label> 
                <input class="form-control" type="text" name="valor" id="valor" onKeyPress="return(moeda(this,'.',',',event))" value="<?= $valor ?>"/><br>
            </div>
            <div class="col-md-12">
                <button class="btn btn-success" type="submit" name="btnenviar"><i class="fa fa-print"></i> Visualizar Recibo</button>
                <a class="btn btn-warning" href="<?= $_SERVER['HTTP_REFERER'] ?>"><i class="fa fa-reply"></i> Voltar</a>
            </div>
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
    <!-- Moeda -->
    <script src="../js/moeda.js"></script>
</body>

</html>