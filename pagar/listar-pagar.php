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

        <h3 class="h3">Lista de Títulos a Pagar</h3>
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center">Número</th>
                    <th class="text-center">Fornecedor</th>
                    <th class="text-center">Obra</th>
                    <th class="text-center">Vencimento</th>
                    <th class="text-center">Valor</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Detalhes</th>
                    <th class="text-center">Quitação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "select p.*, f.for_razaosocial, o.obra_nome 
                        from pagar p, fornecedor f, obra o
                        where p.pagar_obra_id = o.obra_id and p.pagar_fornecedor_id = f.for_id"; 

                $resultado = mysqli_query($conexao, $sql);

                while ($dados = mysqli_fetch_array($resultado)) :
                    $id = $dados['pagar_id'];
                    $numero = $dados['pagar_numero'];
                    $sequencia = $dados['pagar_sequencia'];
                    $fornecedor = mb_substr($dados['for_razaosocial'], 0, 20);
                    $obra = mb_substr($dados['obra_nome'], 0, 20);
                    $dtVenc = $dados['pagar_dt_venc'];
                    $dtPagto = $dados['pagar_dt_pagto'];
                    $valor = $dados['pagar_vl_orig'];
                    $historico = $dados['pagar_historico'];
                    $status = $dados['pagar_status'];
                ?>
                    <tr>
                        <td class="text-center"><?= $numero . ' - ' . $sequencia ?> </span></td>
                        <td><?= $fornecedor ?></td>
                        <td><?= $obra ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($dtVenc)) ?></td>
                        <td class="text-center">R$ <?= number_format($valor, 2, ',', '.') ?></td>
                        <td class="text-center"><?= $status == 'A' ? 'Aberto' : 'Pago' ?></td>
                        <td class="text-center"><a href='alterar-pagar.php?id=<?= $id ?>'><span class="glyphicon glyphicon-search"></span></a></td>
                        <td class="text-center">
                             <a class="btnPesqPagar" href="./carregar-pagar.php?id=<?= $id ?>"><span class="glyphicon glyphicon-usd"></span></a>
                        </td>

                    </tr>
                <?php
                endwhile;
                ?>
            </tbody>
        </table>
        <a class="btn btn-success" href="cadastrar-pagar.php"><i class="fa fa-plus"></i> Novo</a>
        <?php
        if (isset($_GET['msg'])) :
            echo $_SESSION['msg'];
        endif;
        ?>
    </div>
    <br />
    </div>
    <!-- /page content -->


    <!-- Modal Pagar -->

    <div class="modal fade" id="pesqPagar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Quitação de Título</h5>
                </div>
                <div class="modal-body">
                    <span id="msg-cad"></span><br>
                    <div class="col-md-3">
                        <label>Número:</label>
                        <span id="numero"></span>
                    </div>
                    <div class="col-md-9">
                        <label>Fornecedor:</label>
                        <span id="fornecedor"></span>
                    </div>
                    <div class="col-md-6">
                        <label>Obra:</label>
                        <span id="obra"></span>
                    </div>
                    <div class="col-md-3">
                        <label>Vencimento:</label>
                        <span id="dtVenc"></span>
                    </div>
                    <div class="col-md-3">
                        <label>Valor Inicial:</label>
                        <span id="vlInicial"></span>
                    </div>

                    <div class="divPago">
                        <div class="col-md-6">
                            <label>Pagamento:</label>
                            <span id="pagamento"></span>
                        </div>
                        <div class="col-md-3">
                            <label>Valor Final:</label>
                            <span id="final"></span>
                        </div>
                        <div class="col-md-12">
                            <label>Histórico:</label>
                            <span id="pghistorico"></span>
                        </div>
                        <br><br><br><br><br><br><br>
                    </div>

                    <div class="formPagamento">
                        <form id="addPagamento" method="POST">
                            <input type="hidden" name="id" id="md-id" class="md-id" />
                            <dl class="col-md-6">
                                <label for="dtVenc">Data Pagamento *</label>
                                <input class="form-control" type="date" name="dtPagto" id="dtPagto" value="<?= date("Y-m-d") ?>" required />
                            </dl>
                            <dl class="col-md-6">
                                <label for="valor">Valor Final *</label>
                                <input class="form-control" type="text" name="vlFinal" id="vlFinal" onKeyPress="return(moeda(this,'.',',',event))" required />
                            </dl>
                            <dl class="col-md-12">
                                <label for="historico">Histórico</label>
                                <textarea class="form-control" name="historico" id="historico" rows="5" cols="100"></textarea><br>
                            </dl>
                    </div>
                </div>
                <div class="modal-footer formPagamento">
                    <button type="submit" class="btn btn-success formPagamento" name="btnsalvar" id="btnsalvar"><i class="fa fa-save"></i> Realizar Pagamento</button>
                    </form>
                    <button type="button" class="btn btn-secondary fechar-modal">Fechar</button>
                </div>

                <div class="modal-footer divPago">
                    <form id="estornarPagamento" method="POST">
                        <input type="hidden" name="id" id="md-id" class="md-id" />
                        <button type="submit" class="btn btn-warning divPago" name="btnestornar" id="btnestornar">
                            <i class="fa fa-undo"></i> Estornar Quitação
                        </button>
                        <button type="submit" class="btn btn-success divPago btnRecibo">
                            <i class="fa fa-print"></i> Gerar Recibo
                        </button>
                        <button type="button" class="btn btn-secondary fechar-modal">Fechar</button>
                    </form>
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
    <!-- Moeda -->
    <script src="../js/moeda.js"></script>

    <script src="./listar-pagar.js?id=132"></script>

</body>

</html>