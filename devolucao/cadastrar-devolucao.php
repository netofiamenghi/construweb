<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

// TOPO 
if (isset($_POST['topo'])) :

    $dev_id = clear($_POST['id']);
    $dev_tipo = clear($_POST['tipo']);
    $dev_numero = clear($_POST['numero']);
    $dev_fornecedor_id = clear($_POST['fornecedor']);
    $dev_obra_id = clear($_POST['obrapadrao']);
    $dev_dt_emissao = clear(str_replace('/', '-', $_POST['dt-emissao']));
    $dev_dt_emissao_conv = date("Y-m-d H:i:s", strtotime($dev_dt_emissao));
    $dev_dt_lancamento = clear(str_replace('/', '-', $_POST['dt-entrada']));
    $dev_dt_lancamento_conv = date("Y-m-d H:i:s", strtotime($dev_dt_lancamento));
    $dev_desc_por = clear($_POST['desc-por']);
    $dev_subtotal = clear($_POST['subtotal']);
    $dev_subtotal = str_replace(',', '.', str_replace('.', '', $dev_subtotal));
    $dev_status = clear($_POST['status']);

    // ALTERAR TOPO
    if ($dev_id > 0) :

        $sql = "select sum(it.it_dev_valor_total) total 
                from itens_devolucao it where it_dev_dev_id = '$dev_id'";
        $resultado = mysqli_query($conexao, $sql);
        $dados = mysqli_fetch_array($resultado);
        $total = $dados['total'];

        $sql = "update devolucao set dev_tipo = '$dev_tipo', dev_numero = '$dev_numero', 
                dev_fornecedor_id = '$dev_fornecedor_id', dev_obra_id = '$dev_obra_id', 
                dev_dt_emissao = '$dev_dt_emissao_conv', 
                dev_dt_lancamento = '$dev_dt_lancamento_conv', dev_total = '$total', 
                dev_status = '$dev_status' where dev_id = '$dev_id'";
        mysqli_query($conexao, $sql);

        $_SESSION['msg'] = "<script>mostraDialogo('Devolução alterada com sucesso!', 'success');</script>";


    // INCLUIR TOPO
    else :
        $sql = "insert into devolucao (dev_tipo, dev_numero, dev_fornecedor_id, dev_obra_id, 
                dev_dt_emissao, dev_dt_lancamento, dev_total, dev_status) values
                ('$dev_tipo','$dev_numero','$dev_fornecedor_id','$dev_obra_id', '$dev_dt_emissao_conv', 
                '$dev_dt_lancamento_conv', '0.0', 'D')";
        mysqli_query($conexao, $sql);

        // BUSCAR O ID DA DEVOLUCAO INSERIDA
        $sql = "select * from devolucao order by dev_id desc limit 1";
        $resultado = mysqli_query($conexao, $sql);
        $dados = mysqli_fetch_array($resultado);
        $dev_id = $dados['dev_id'];

        $_SESSION['msg'] = "<script>mostraDialogo('Devolução incluída com sucesso!', 'success');</script>";
    endif;

    mysqli_close($conexao);
    header("Location: cadastrar-devolucao.php?nf=$dev_id&msg=sim");
endif;

// INSERIR ITENS
if (isset($_POST['itens'])) :
    $it_dev_dev_id = clear($_POST['id']);
    $it_dev_produto_id = clear($_POST['produto']);
    $it_dev_obra_id = clear($_POST['obra']);
    $it_dev_quantidade = clear($_POST['quantidade']);
    $it_dev_quantidade = str_replace(',', '.', str_replace('.', '', $it_dev_quantidade));
    $it_dev_valor_unitario = clear($_POST['vr-unitario']);
    $it_dev_valor_unitario = str_replace(',', '.', str_replace('.', '', $it_dev_valor_unitario));
    $it_dev_valor_total = $it_dev_quantidade * $it_dev_valor_unitario;

    $sql = "insert into itens_devolucao (it_dev_dev_id, it_dev_produto_id, it_dev_obra_id, 
            it_dev_quantidade, it_dev_valor_unitario, it_dev_valor_total) 
            values('$it_dev_dev_id','$it_dev_produto_id','$it_dev_obra_id', '$it_dev_quantidade',
            '$it_dev_valor_unitario','$it_dev_valor_total')";

    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Produto incluído com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('<strong>Verifique!</strong><br>Produto já inserido na Devolução!', 'warning', 6000);</script>";
    endif;

    // BUSCAR O ID DA DEVOLUÇÃO INSERIDA
    $dev_id = $it_dev_dev_id;

    $sql = "select sum(it.it_dev_valor_total) total 
            from itens_devolucao it where it_dev_dev_id = '$dev_id'";

    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $total = $dados['total'];

    $sql = "update devolucao set dev_total = '$total' where dev_id = '$dev_id'";
    mysqli_query($conexao, $sql);

    mysqli_close($conexao);
    header("Location: cadastrar-devolucao.php?nf=$dev_id&msg=sim");

endif;

// EXCLUIR ITENS DA DEVOLUCAO
if (isset($_GET['excluir'])) :
    $topo_id = $_GET['topo-id'];
    $itens_id = $_GET['itens-id'];
    $itens_total = $_GET['itens-total'];

    $sql = "delete from itens_devolucao where it_dev_id = '$itens_id'";
    $resultado = mysqli_query($conexao, $sql);

    $_SESSION['msg'] = "<script>mostraDialogo('Produto excluído com sucesso!', 'success');</script>";

    // BUSCAR O ID DA DEVOLUCAO INSERIDA
    $sql = "select * from devolucao where dev_id = '$topo_id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $dev_id = $dados['dev_id'];
    $dev_total = $dados['dev_total'] - $itens_total;

    $sql = "update devolucao set dev_total = '$dev_total' where dev_id = '$dev_id'";
    mysqli_query($conexao, $sql);

    mysqli_close($conexao);
    header("Location: cadastrar-devolucao.php?nf=$dev_id&msg=sim");

endif;

// CARREGAR NF
if (isset($_GET['nf'])) :

    $nf = $_GET['nf'];
    $sql = "select dev.*, f.for_razaosocial, o.obra_nome
            from devolucao dev, fornecedor f, obra o 
            where dev.dev_obra_id = o.obra_id and dev.dev_fornecedor_id = f.for_id and dev.dev_id = '$nf'";

    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $dev_id = $dados['dev_id'];
    $dev_tipo = $dados['dev_tipo'];
    $dev_numero = $dados['dev_numero'];
    $dev_fornecedor_id = $dados['dev_fornecedor_id'];
    $fornecedor_nome = $dados['for_razaosocial'];
    $dev_obra_id = $dados['dev_obra_id'];
    $dev_obra_nome = $dados['obra_nome'];
    $dev_dt_emissao = $dados['dev_dt_emissao'];
    $dev_dt_lancamento = $dados['dev_dt_lancamento'];
    $dev_total = $dados['dev_total'];
    $dev_status = $dados['dev_status'];
endif;

// EXCLUIR NF
if (isset($_GET['excluir-topo'])) :

    $nf = $_GET['topo-id'];

    $sql = "delete from itens_devolucao where it_dev_dev_id = '$nf'";
    $resultado = mysqli_query($conexao, $sql);

    $sql = "delete from devolucao where dev_id = '$nf'";
    $resultado = mysqli_query($conexao, $sql);

    mysqli_close($conexao);
    header("Location: listar-devolucao.php");

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

    <link href="../css/estilo.css?id=1" rel="stylesheet">
    <!-- Mensagens -->
    <script src="../js/mensagens.js"></script>
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#numero").blur(function() {
                novoNumero = Number(this.value).toString();
                this.value = novoNumero;
            });
        });
    </script>

</head>

<body class="nav-md">
    <?php
    include_once '../layout/cabecalho.php';
    ?>

    <!-- page content -->
    <div class="right_col" role="main">
        <h3 class="h3">Devolução de Compras</h3>
        <hr>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="id" id="id" value="<?= $dev_id ?>" />
            <div class="row">
                <div class="col-md-3">
                    <label for="numero">Tipo *</label><br>
                    <input type="radio" name="tipo" id="tipoN" value="N" <?= $dev_tipo == 'N' ? 'checked' : '' ?> required checked><label for="tipoN">&nbsp;NOTA FISCAL &nbsp;</label>
                    <input type="radio" name="tipo" id="tipoP" value="P" <?= $dev_tipo == 'P' ? 'checked' : '' ?>><label for="tipoP">&nbsp;PEDIDO</label>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <label for="numero">Nº Documento *</label>
                    <input class="form-control" type="text" name="numero" id="numero" maxlength="100" value="<?= $dev_numero ?>" required />
                </div>
                <div class="col-md-2">
                    <label for="dt-emissao">Data Emissão *</label>
                    <input class="form-control" type="date" name="dt-emissao" id="dt-emissao" value="<?= $dev_dt_emissao ?>" required />
                </div>
                <div class="col-md-2">
                    <label for="dt-entrada">Data Entrada *</label>
                    <input class="form-control" type="date" name="dt-entrada" id="dt-entrada" value="<?= $dev_dt_lancamento ?>" required />
                </div>
            </div>

            <?php if ($dev_id != null) : ?>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <label for="total">Valor Total R$</label>
                        <input class="form-control" type="text" name="total" id="total" value="<?= number_format($dev_total, 2, ',', '.') ?>" readonly />
                    </div>
                    <div class="col-md-2">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="D" <?= $dev_status == 'D' ? 'selected' : '' ?>>DIGITADA</option>
                            <option value="F" <?= $dev_status == 'F' ? 'selected' : '' ?>>FINALIZADA</option>
                            <option value="C" <?= $dev_status == 'C' ? 'selected' : '' ?>>CANCELADA</option>
                        </select>
                    </div>

                </div>

            <?php endif; ?>
            <br>
            <div class="row">
                <div class="col-md-7">
                    <div class="col-md-12">
                        <label for="fornecedor">Selecione o Fornecedor *</label>
                    </div>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="fornecedor" id="fornecedor" value="<?= $dev_fornecedor_id ?>" readonly required />
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="nomefornecedor" id="nomefornecedor" value="<?= $fornecedor_nome ?>" readonly />
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqFornecedor">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="col-md-12">
                        <label for="obrapadrao">Selecione a Obra padrão *</label>
                    </div>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="obrapadrao" id="obrapadrao" value="<?= $dev_obra_id ?>" readonly required />
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="nomeobrapadrao" id="nomeobrapadrao" value="<?= $dev_obra_nome ?>" readonly />
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqObraPadrao">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-12">
                    <br>
                    <button class="btn btn-success" type="submit" name="topo">
                        <i class="fa fa-plus"></i><?= $dev_id == null ? ' Incluir' : ' Alterar' ?>
                    </button>
                    <?php

                    switch ($dev_status):

                        case 'D':
                            echo "<a class='btn btn-danger' href='cadastrar-devolucao.php?topo-id=$dev_id&excluir-topo=sim'><i class='fa fa-trash'></i> Excluir</a>";
                            break;
                        
                    endswitch;

                    ?>
                    <a class="btn btn-warning" href="<?= isset($_GET['obra']) ? "./../obra/alterar-obra.php?id={$_GET['obra']}" : './listar-devolucao.php' ?>"><i class="fa fa-reply"></i> Voltar</a>
                    <?php
                    if (isset($_GET['msg'])) :
                        echo $_SESSION['msg'];
                        $_SESSION['msg'] = '';
                    endif;
                    ?>
                </div>
            </div>
        </form>
        <hr>
        <?php
        if ($dev_id != null) :
            if ($dev_status != 'F') :
        ?>
                <h3 class="h3">Inserir Itens/Produtos</h3>
                <div class="row">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <input type="hidden" name="id" id="id" value="<?= $dev_id ?>" />
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <label for="produto">Selecione o Produto *</label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="text" name="produto" id="produto" readonly required />
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="nomeproduto" id="nomeproduto" readonly />
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqProduto">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="quantidade">Qtd *</label>
                            <input class="form-control" type="text" name="quantidade" id="quantidade" onKeyPress="return(moeda(this,'.',',',event))" required />
                        </div>
                        <div class="col-md-1">
                            <label for="vr-unitario">Vl Unit. *</label>
                            <input class="form-control" type="text" name="vr-unitario" id="vr-unitario" onKeyPress="return(moeda(this,'.',',',event))" required />
                        </div>
                        <div class="col-md-5">
                            <div class="col-md-12">
                                <label for="produto">Selecione a Obra *</label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="text" name="obra" id="obra" value="<?= $dev_obra_id ?>" readonly required />
                            </div>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="nomeobra" id="nomeobra" value="<?= $dev_obra_nome ?>" readonly />
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pesqObra">
                                    <i class="fa fa-search"></i>
                                </button>
                                <button class="btn btn-success" type="submit" name="itens">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php
            endif;
            ?>
            <hr>
            <?php
            $sql = "select it.*, o.obra_nome, p.pro_descricao 
                    from itens_devolucao it, obra o, produto p
                    where it.it_dev_produto_id = p.pro_id and it.it_dev_obra_id = o.obra_id and 
                    it_dev_dev_id = '$dev_id'";
            $resultado = mysqli_query($conexao, $sql);
            if ($resultado->num_rows > 0) :
            ?>
                <h3 class="h3">Itens Inseridos</h3>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Obra</th>
                            <th class="text-center">Produto</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-center">Valor Unitário</th>
                            <th class="text-center">Valor Total</th>
                            <?= $dev_status != 'F' ? "<th class='text-center'>Excluir</th>" : "" ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($dados = mysqli_fetch_array($resultado)) :
                            $it_dev_id = $dados['it_dev_id'];
                            $it_dev_dev_id = $dados['it_dev_dev_id'];
                            $it_dev_produto_id = $dados['it_dev_produto_id'];
                            $it_produto_descricao = $dados['pro_descricao'];
                            $it_dev_obra_id = $dados['it_dev_obra_id'];
                            $it_obra_nome = $dados['obra_nome'];
                            $it_dev_quantidade = $dados['it_dev_quantidade'];
                            $it_dev_valor_unitario = $dados['it_dev_valor_unitario'];
                            $it_dev_valor_total = $dados['it_dev_valor_total'];
                        ?>
                            <tr>
                                <td class="text-center"><?= $it_obra_nome ?></td>
                                <td class="text-center"><?= $it_produto_descricao ?></td>
                                <td class="text-center"><?= $it_dev_quantidade ?></td>
                                <td class="text-center">R$ <?= number_format($it_dev_valor_unitario, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($it_dev_valor_total, 2, ',', '.') ?></td>
                                <?php
                                if ($dev_status != 'F') :
                                ?>
                                    <td class="text-center">
                                        <a href='cadastrar-devolucao.php?topo-id=<?= $it_dev_dev_id ?>&itens-id=<?= $it_dev_id ?>&itens-total=<?= $it_dev_valor_total ?>&excluir=sim'>
                                            <button class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </a>
                                    </td>
                                <?php
                                endif;
                                ?>
                            </tr>
                        <?php
                        endwhile;
                        ?>

                    </tbody>
                </table>
        <?php
            endif;
        endif;
        ?>

    </div>
    <br>
    </div>
    <!-- /page content -->


    <!-- Modal Fornecedor -->

    <div class="modal fade" id="pesqFornecedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;
                        </span></button>
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisa de Fornecedor</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-pesquisa">
                        <input class="form-control" type="text" name="pesquisa-fornecedor" id="pesquisa-fornecedor" placeholder="Digite o nome do fornecedor" />
                    </form><br>
                    <small>Clique no resultado para selecionar</small>
                    <ul class="fornecedor"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fim modal -->


    <!-- Modal Produto -->

    <div class="modal fade" id="pesqProduto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;
                        </span></button>
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisa de Produto</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-pesquisa">
                        <input class="form-control" type="text" name="pesquisa-produto" id="pesquisa-produto" placeholder="Digite o nome do produto" />
                    </form><br>
                    <small>Clique no resultado para selecionar</small>
                    <ul class="produto"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fim modal -->

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

    <!-- Modal Obra Padrão -->

    <div class="modal fade" id="pesqObraPadrao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;
                        </span></button>
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisa de Obra Padrão</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-pesquisa">
                        <input class="form-control" type="text" name="pesquisa-obra-padrao" id="pesquisa-obra-padrao" placeholder="Digite o nome da obra padrão" />
                    </form><br>
                    <small>Clique no resultado para selecionar</small>
                    <ul class="obrapadrao"></ul>
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

    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.min.js"></script>
    <!-- jquery.inputmask -->
    <script src="../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- Moeda -->
    <script src="../js/moeda.js"></script>
    <!-- < !-- Pesquisas modal -->
    <script src="../js/pesquisas-modal.js?id=2"></script>
    <!-- Validacoes  -->
    <script src="../js/funcoes.js"></script>

    <script src="./cadastrar-nf-entrada.js?id=123"></script>
</body>

</html>