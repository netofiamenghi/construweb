<?php include_once '../util/conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

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
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
    <?php
    include_once '../layout/cabecalho.php';
    ?>

    <!-- page content -->
    <div class="right_col" role="main">
        <h3 class="h3 text-center text-primary">ConstruWeb - Lista de Atualizações</h3>
        <hr>
        <h4 class="h4 text-center text-primary">V.1.9.0 - 11/09/2020</h4>
        <h5 class="h5 text-success">Novidades</h5>
        <ul class="ul">
            <li>Movimentação de Caixa.</li>
        </ul>
        <hr>
        <h4 class="h4 text-center text-primary">V.1.8.1 - 03/09/2020</h4>
        <h5 class="h5 text-danger">Correções</h5>
        <ul class="ul">
            <li>NF Entrada/Devolução/Pagar/Receber - número não pode começar com zero.</li>
            <li>Listas Pagar/Receber - correção no tamanho da tabela para se ajustar em telas menores.</li>
        </ul>
        <h5 class="h5 text-success">Novidades</h5>
        <ul class="ul">
            <li>Cadastro de Devoluções.</li>
            <li>Relatório de Devoluções.</li>
            <li>Cadastro de Tipo de ART.</li>
            <li>Cadastro de ART (Obras podem ter várias ARTs).</li>
        </ul>
        <hr>
        <h4 class="h4 text-center text-primary">V.1.7.0 - 18/04/2020</h4>
        <h5 class="h5 text-danger">Correções</h5>
        <ul class="ul">
            <li>Lista de Títulos à Pagar: incluído coluna OBRA.</li>
            <li>Agora as obras inativas ou excluídas não aparecem nas consultas.</li>
            <li>Na lista de clientes não estava aparecendo os telefones/celulares de alguns cadastros.</li>
        </ul>
        <h5 class="h5 text-success">Novidades</h5>
        <ul class="ul">
            <li>Novo Layout das Telas.</li>
            <li>Página Inicial com informações das obras.</li>
            <li>Validação de datas, CPF e CNPJ.</li>
            <li>Novas telas para pesquisar produtos, clientes, etc.</li>
            <li>Tempo de sessão: o usuário precisa se logar novamente após 2 horas.</li>
            <li>Nota Fiscal de Entrada: inclusão de títulos à pagar.</li>
            <li>Financeiro: títulos à pagar.</li>
            <li>Relatório de Títulos à Pagar: filtro por fornecedor.</li>
        </ul>
        <hr>
    </div>
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
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.min.js"></script>
</body>

</html>