<?php
include_once '../util/conexao.php';

$stt = 'E';
$sql = "select * from cliente where cli_status <> '$stt'";
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

        <h3 class="h3">Lista de Clientes</h3>
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center">CPF/CNPJ</th>
                    <th class="text-center">Nome</th>
                    <th class="text-center">Telefone/Celular</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Questionário</th>
                    <th class="text-center">Detalhes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($dados = mysqli_fetch_array($resultado)) :
                    $id = $dados['cli_id'];
                    $cpf = $dados['cli_cpf'];
                    $cnpj = $dados['cli_cnpj'];
                    $nome = $dados['cli_nome'];
                    $nomeFantasia = $dados['cli_fantasia'];
                    $telefone = $dados['cli_telefone'];
                    $celular = $dados['cli_celular'];
                    $status = $dados['cli_status'];

                    if ($telefone == '' || $telefone == '(0_) ____-____') :
                        $telefone = $celular;
                    endif;
                ?>
                    <tr>
                        <td class="text-center"><?= $cpf == '0__.___.___-__' ? $cnpj : $cpf ?></td>
                        <td class="text-center"><?= $nome == '0' ? $nomeFantasia : $nome ?></td>
                        <td class="text-center"><?= $telefone  ?></td>
                        <td class="text-center">
                            <?php
                            switch ($status):
                                case 'A':
                                    echo 'ATIVO';
                                    break;
                                case 'N':
                                    echo 'EM NEGOCIAÇÃO';
                                    break;
                                case 'I':
                                    echo 'INATIVO';
                                    break;
                            endswitch;
                            ?>
                        </td>
                        <td class="text-center"><a href='questionario-cliente.php?id=<?= $id ?>'><span class="glyphicon glyphicon-pencil"></span></a></td>
                        <td class="text-center"><a href='alterar-cliente.php?id=<?= $id ?>'><span class="glyphicon glyphicon-search"></span></a></td>
                    </tr>
                <?php
                endwhile;
                ?>
            </tbody>
        </table>
        <a class="btn btn-success" href="cadastrar-cliente.php"><i class="fa fa-plus"></i> Novo</a>
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