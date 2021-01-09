<?php

include_once '../util/conexao.php';

$sql1 = "select * from conta";
$resultado1 = mysqli_query($conexao, $sql1);
$dados1 = mysqli_fetch_array($resultado1);
$saldo = $dados1['conta_saldo'];
$saldo = number_format($saldo, 2, ',', '.');

if (isset($_POST['btnenviar'])) :
    $dtInicio = $_POST['dtInicio'];
    $dtFim = $_POST['dtFim'];
    $sql = "select * from lancamento where lancamento_data between '$dtInicio' and '$dtFim' ";
else :
    $dtInicio = "curdate()";
    $dtFim = "curdate()";
    $sql = "select * from lancamento where lancamento_data = curdate() ";
endif;

$resultado = mysqli_query($conexao, $sql);

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
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../css/custom.min.css" rel="stylesheet">

    <link href="../css/estilo.css" rel="stylesheet">

    <!-- Mensagens -->
    <script src="../js/mensagens.js"></script>
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

</head>

<body class="nav-md">
    <?php
    include_once '../layout/cabecalho.php';
    ?>

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="col-md-12">
            <div class="col-md-8">
                <h2 class="h2">Caixa</h2>
            </div>
            <div class="col-md-4">
                <?php
                if ($saldo >= 0) :
                ?>
                    <h3 class="h3 text-success text-right">Saldo atual: R$ <?= $saldo ?></h3>
                <?php
                else :
                ?>
                    <h3 class="h3 text-danger text-right">Saldo atual: R$ <?= $saldo ?></h3>
                <?php
                endif;
                ?>
            </div>
        </div>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <fieldset class="col-md-12">
                <div class="col-md-2">
                    <label for="dtInicio">Início *</label>
                    <input class="form-control" type="date" name="dtInicio" id="dtInicio" required />
                </div>
                <div class="col-md-2">
                    <label for="dtFim">Fim *</label>
                    <input class="form-control" type="date" name="dtFim" id="dtFim" required /><br>
                </div>
                <div class="col-md-2">
                    <br><button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-search"></i> Filtrar</button>
                </div>
            </fieldset>
        </form>
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center">Nº Documento</th>
                    <th class="text-center">Data</th>
                    <th class="text-center">Valor</th>
                    <th class="text-center">Observação</th>
                    <th class="text-center">Detalhes</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($dados = mysqli_fetch_array($resultado)) :
                    $id = $dados['lancamento_id'];
                    $documento = $dados['lancamento_documento'];
                    $data = $dados['lancamento_data'];
                    $valor = $dados['lancamento_valor'];
                    $tipo = $dados['lancamento_tipo'];
                    $obs = mb_substr($dados['lancamento_observacao'], 0, 20);
                    $pagar_id = $dados['lancamento_pagar_id'];
                    $receber_id = $dados['lancamento_receber_id'];
                ?>
                    <tr>
                        <td class="text-center"><?= $documento == '0' ? '' : $documento ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($data)) ?></td>
                        <?php
                        if ($tipo == 'C') :
                        ?>
                            <td class="text-center text-success">+ R$ <?= number_format($valor, 2, ',', '.') ?></td>
                            <td class="text-center"><?= $obs ?></td>
                            <td class="text-center"><a href='alterar-lancamento.php?id=<?= $id ?>'><span class="glyphicon glyphicon-search"></span></a></td>
                            <?php
                            if ($receber_id == '') :
                            ?>
                                <td class="text-center"><a href='excluir-lancamento.php?id=<?= $id ?>'><span class="glyphicon glyphicon-trash"></span></a></td>
                            <?php
                            else :
                                echo "<td></td>";
                            endif;
                        else :
                            ?>
                            <td class="text-center text-danger">- R$ <?= number_format($valor, 2, ',', '.') ?></td>
                            <td class="text-center"><?= $obs ?></td>
                            <td class="text-center"><a href='alterar-lancamento.php?id=<?= $id ?>'><span class="glyphicon glyphicon-search"></span></a></td>
                            <?php
                            if ($pagar_id == '') :
                            ?>
                                <td class="text-center"><a href='excluir-lancamento.php?id=<?= $id ?>'><span class="glyphicon glyphicon-trash"></span></a></td>
                    <?php
                            else :
                                echo "<td></td>";
                            endif;
                        endif;
                        echo "</tr>";
                    endwhile;
                    ?>
            </tbody>
        </table>
        <a class="btn btn-success" href="cadastrar-lancamento.php"><i class="fa fa-plus"></i> Novo</a>
        <a class="btn btn-primary" href="relatorio-lancamento.php?inicio=<?= $dtInicio ?>&fim=<?= $dtFim ?>" target="_blank"><i class="fa fa-print"></i> Imprimir Movimentações</a>
        <?php
        if (isset($_GET['msg'])) :
            echo $_SESSION['msg'];
        endif;
        ?>
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
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.min.js"></script>
</body>

</html>