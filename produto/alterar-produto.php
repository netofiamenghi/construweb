<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';


if (isset($_GET['id'])) :

    $id = $_GET['id'];
    $sql = "select * from produto where pro_id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);

    $descricao = $dados['pro_descricao'];
    $unidade = $dados['pro_unidade'];
    $status = $dados['pro_status'];

elseif (isset($_POST['btnenviar'])) :

    $id = clear($_POST['id']);
    $descricao = clear($_POST['descricao']);
    $unidade = clear($_POST['unidade']);
    $status = clear($_POST['status']);

    $sql = "update produto set pro_descricao = '$descricao', pro_unidade = '$unidade', pro_status = '$status' where pro_id = '$id'";
    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Produto alterado com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('<strong>Erro ao incluir Produto!</strong><br>Produto já existe!', 'error', 5000);</script>";
    endif;

    mysqli_close($conexao);
    header("Location: alterar-produto.php?id=$id&msg=sim");

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

    <!-- Mensagens -->
    <script src="../js/mensagens.js"></script>
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
</head>

<body class="nav-md">
    <?php
    include_once '../layout/cabecalho.php';
    ?>

    <!-- page content -->
    <div class="right_col" role="main">

        <br><br><br>

        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Cadastro</a></li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Histórico de Compra</a></li>
            </ul>

            <div id="myTabContent" class="tab-content">

                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                    <h3 class="h3">Alterar Produto</h3>
                    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>" /><br>
                        <div class="col-md-6">
                            <label for="descricao">Descrição *</label>
                            <input class="form-control" type="text" name="descricao" id="descricao" maxlength="100" required value="<?= $descricao ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="unidade">Unidade de Medida *</label>
                            <select class="form-control" name="unidade" id="unidade" required>
                                <option value="BARRA" <?= $unidade == 'BARRA' ? 'selected' : '' ?>>BARRA</option>
                                <option value="CAIXA" <?= $unidade == 'CAIXA' ? 'selected' : '' ?>>CAIXA</option>
                                <option value="GALÃO" <?= $unidade == 'GALÃO' ? 'selected' : '' ?>>GALÃO</option>
                                <option value="GRAMA" <?= $unidade == 'GRAMA' ? 'selected' : '' ?>>GRAMA</option>
                                <option value="QUILOGRAMA" <?= $unidade == 'QUILOGRAMA' ? 'selected' : '' ?>>QUILOGRAMA</option>
                                <option value="LATA" <?= $unidade == 'LATA' ? 'selected' : '' ?>>LATA</option>
                                <option value="LITRO" <?= $unidade == 'LITRO' ? 'selected' : '' ?>>LITRO</option>
                                <option value="METRO" <?= $unidade == 'METRO' ? 'selected' : '' ?>>METRO</option>
                                <option value="M2" <?= $unidade == 'M2' ? 'selected' : '' ?>>M2</option>
                                <option value="M3" <?= $unidade == 'M3' ? 'selected' : '' ?>>M3</option>
                                <option value="PEÇA" <?= $unidade == 'PEÇA' ? 'selected' : '' ?>>PEÇA</option>
                                <option value="ROLO" <?= $unidade == 'ROLO' ? 'selected' : '' ?>>ROLO</option>
                                <option value="SACO" <?= $unidade == 'SACO' ? 'selected' : '' ?>>SACO</option>
                                <option value="UNIDADE" <?= $unidade == 'UNIDADE' ? 'selected' : '' ?>>UNIDADE</option>
                            </select><br>
                        </div>
                        <div class="col-md-6">
                            <label for="status">Status *</label>
                            <select class="form-control" name="status">
                                <option value="A" <?= $status == 'A' ? 'selected' : '' ?>>ATIVO</option>
                                <option value="I" <?= $status == 'I' ? 'selected' : '' ?>>INATIVO</option>
                                <option value="E" <?= $status == 'E' ? 'selected' : '' ?>>EXCLUÍDO</option>
                            </select><br>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
                            <a class="btn btn-warning" href="./listar-produto.php"><i class="fa fa-reply"></i> Voltar</a>
                        </div>
                    </form>
                    <br>
                    <br><br>
                    <?php
                    if (isset($_GET['msg'])) :
                        echo $_SESSION['msg'];
                    endif;
                    ?>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">


                    <h3 class="h3">Últimas Compras</h3>
                    <br>

                    <?php
                    $sql = "select i.it_nfent_nf_entrada_id id, nf.nfent_numero nf, 
                                    DATE_FORMAT (STR_TO_DATE(nf.nfent_dt_emissao, '%Y-%m-%d'), '%d/%m/%Y') data, 
                                    f.for_razaosocial fornecedor, i.it_nfent_quantidade qtd, i.it_nfent_valor_unitario valor
                                    from itens_nf_entrada i, nf_entrada nf, fornecedor f
                                    where i.it_nfent_nf_entrada_id = nf.nfent_id and nf.nfent_fornecedor_id = f.for_id and 
                                    i.it_nfent_produto_id = '$id' order by data desc";

                    $resultado = mysqli_query($conexao, $sql);

                    if ($resultado->num_rows > 0) :

                    ?>

                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class='text-center'>NF/Pedido</th>
                                    <th class='text-center'>Data</th>
                                    <th class='text-center'>Fornecedor</th>
                                    <th class='text-center'>Quantidade</th>
                                    <th class='text-center'>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($dados = mysqli_fetch_array($resultado)) :

                                    $fornecedor = mb_substr($dados['fornecedor'], 0, 30);

                                    $valor = number_format($dados['valor'], 2, ',', '.');
                                ?>
                                    <tr>
                                        <td class='text-center'><?= $dados['nf'] ?></td>
                                        <td class='text-center'><?= $dados['data'] ?></td>
                                        <td><?= $fornecedor ?></td>
                                        <td class='text-center'><?= $dados['qtd'] ?></td>
                                        <td class='text-center'>R$ <?= $valor ?></td>
                                    </tr>

                                <?php
                                endwhile;
                                ?>
                            </tbody>
                        </table>
                    <?php
                    else :
                        echo "<h4 class='h4 text-center'>Nenhuma compra efetuada para esse produto!</h4>";
                    endif;
                    ?>

                    <a class="btn btn-warning" href="./listar-produto.php"><i class="fa fa-reply"></i> Voltar</a>

                </div>



            </div>
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

    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- jquery.inputmask -->
    <script src="../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.min.js"></script>
    <!-- CEP -->
    <script src="../js/funcoes.js"></script>


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


</body>

</html>