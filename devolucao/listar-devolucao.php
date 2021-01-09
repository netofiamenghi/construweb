<?php
include_once '../util/conexao.php';

$sql = "select * from devolucao dev, fornecedor f where dev.dev_fornecedor_id = f.for_id";
$resultado = mysqli_query($conexao, $sql);
mysqli_close($conexao);

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
</head>

<body class="nav-md">
    <?php
    include_once '../layout/cabecalho.php';
    ?>

    <!-- page content -->
    <div class="right_col" role="main">

        <h3 class="h3">Lista de Devoluções</h3>
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center">NF/Pedido</th>
                    <th class="text-center">Fornecedor</th>
                    <th class="text-center">Dt Emissão</th>
                    <th class="text-center">Valor Total</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Detalhes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado) :
                    while ($dados = mysqli_fetch_array($resultado)) :
                        $dev_id = $dados['dev_id'];
                        $dev_numero = $dados['dev_numero'];
                        $for_razaosocial = mb_substr($dados['for_razaosocial'], 0, 35);
                        $dev_dt_emissao = $dados['dev_dt_emissao'];
                        $dev_total = $dados['dev_total'];

                        switch ($dados['dev_status']):
                            case 'D':
                                $dev_status = 'Digitada';
                                break;
                            case 'C':
                                $dev_status = 'Cancelada';
                                break;
                            default:
                                $dev_status = 'Finalizada';
                        endswitch;

                ?>
                        <tr>
                            <td class="text-center"><?= $dev_numero ?></td>
                            <td><?= $for_razaosocial ?></td>
                            <td class="text-center"><?= date('d/m/Y', strtotime($dev_dt_emissao)) ?></td>
                            <td class="text-center"><?= 'R$ ' . number_format($dev_total, 2, ',', '.') ?></td>
                            <td class="text-center"><?= $dev_status ?></td>
                            <td class="text-center"><a href='cadastrar-devolucao.php?nf=<?= $dev_id ?>'><span class="glyphicon glyphicon-search"></span></a></td>
                        </tr>
                <?php
                    endwhile;
                endif;
                ?>
            </tbody>
        </table>
        <a class="btn btn-success" href="cadastrar-devolucao.php"><i class="fa fa-plus"></i> Novo</a>
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