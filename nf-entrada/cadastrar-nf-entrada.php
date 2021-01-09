<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

// INSERIR TOPO DA NF 
if (isset($_POST['topo'])) :

    $nfent_id = clear($_POST['id']);
    $nfent_tipo = clear($_POST['tipo']);
    $nfent_numero = clear($_POST['numero']);
    $nfent_fornecedor_id = clear($_POST['fornecedor']);
    $nfent_obra_id = clear($_POST['obrapadrao']);
    $nfent_dt_emissao = clear(str_replace('/', '-', $_POST['dt-emissao']));
    $nfent_dt_emissao_conv = date("Y-m-d H:i:s", strtotime($nfent_dt_emissao));
    $nfent_dt_lancamento = clear(str_replace('/', '-', $_POST['dt-entrada']));
    $nfent_dt_lancamento_conv = date("Y-m-d H:i:s", strtotime($nfent_dt_lancamento));
    $nfent_desc_por = clear($_POST['desc-por']);
    $nfent_subtotal = clear($_POST['subtotal']);
    $nfent_subtotal = str_replace(',', '.', str_replace('.', '', $nfent_subtotal));
    $nfent_status = clear($_POST['status']);

    // ALTERAR TOPO DA NF
    if ($nfent_id > 0) :

        $sqlTitulos = "select p.pagar_numero, p.pagar_sequencia, p.pagar_dt_venc, p.pagar_dt_pagto, p.pagar_vl_final, p.pagar_status
                        from pagar p, nf_entrada nf
                        where p.pagar_nf_entrada_id = nf.nfent_id and nf.nfent_id = '$nfent_id'";
        $resultadoTitulos = mysqli_query($conexao, $sqlTitulos);

        if ($resultadoTitulos->num_rows <= 0) :

            $sql = "select sum(it.it_nfent_valor_total) subtotal 
                    from itens_nf_entrada it
                    where it_nfent_nf_entrada_id = '$nfent_id'";
            $resultado = mysqli_query($conexao, $sql);
            $dados = mysqli_fetch_array($resultado);
            $subtotal = $dados['subtotal'];

            $nfent_desc_vl = ($nfent_desc_por / 100) * $subtotal;
            $nfent_total = $subtotal - $nfent_desc_vl;

            $sql = "update nf_entrada set nfent_tipo = '$nfent_tipo', nfent_numero = '$nfent_numero', 
                    nfent_fornecedor_id = '$nfent_fornecedor_id', nfent_obra_id = '$nfent_obra_id', 
                    nfent_dt_emissao = '$nfent_dt_emissao_conv', nfent_dt_lancamento = '$nfent_dt_lancamento_conv', 
                    nfent_desc_por = '$nfent_desc_por', nfent_desc_vl = '$nfent_desc_vl', 
                    nfent_subtotal = '$subtotal', nfent_total = '$nfent_total', nfent_status = '$nfent_status' 
                    where nfent_id = '$nfent_id'";
            mysqli_query($conexao, $sql);

            $_SESSION['msg'] = "<script>mostraDialogo('Nota Fiscal de Entrada alterada com sucesso!', 'success');</script>";

        else :
            $_SESSION['msg'] = "<script>mostraDialogo('<strong>Nota Fiscal de Entrada não pode ser alterada!</strong><br>O documento já possui títulos no financeiro!', 'warning', 5000);</script>";
        endif;
    // INCLUIR TOPO DA NF 
    else :
        $sql = "insert into nf_entrada (nfent_tipo, nfent_numero, nfent_fornecedor_id, nfent_obra_id, 
                nfent_dt_emissao, nfent_dt_lancamento, nfent_desc_por, nfent_desc_vl, nfent_subtotal, 
                nfent_total, nfent_status) values('$nfent_tipo', '$nfent_numero','$nfent_fornecedor_id',
                '$nfent_obra_id', '$nfent_dt_emissao_conv', '$nfent_dt_lancamento_conv', '$nfent_desc_por', 
                '0.0', '0.0', '0.0', 'D')";
        mysqli_query($conexao, $sql);

        // BUSCAR O ID DA NF INSERIDA
        $sql = "select * from nf_entrada order by nfent_id desc limit 1";
        $resultado = mysqli_query($conexao, $sql);
        $dados = mysqli_fetch_array($resultado);
        $nfent_id = $dados['nfent_id'];

        $_SESSION['msg'] = "<script>mostraDialogo('Nota Fiscal de Entrada incluída com sucesso!', 'success');</script>";
    endif;

    mysqli_close($conexao);
    header("Location: cadastrar-nf-entrada.php?nf=$nfent_id&msg=sim");
endif;

// INSERIR ITENS DA NF
if (isset($_POST['itens'])) :
    $it_nfent_nf_entrada_id = clear($_POST['id']);
    $it_nfent_produto_id = clear($_POST['produto']);
    $it_nfent_obra_id = clear($_POST['obra']);
    $it_nfent_quantidade = clear($_POST['quantidade']);
    $it_nfent_quantidade = str_replace(',', '.', str_replace('.', '', $it_nfent_quantidade));
    $it_nfent_valor_unitario = clear($_POST['vr-unitario']);
    $it_nfent_valor_unitario = str_replace(',', '.', str_replace('.', '', $it_nfent_valor_unitario));
    $it_nfent_valor_total = $it_nfent_quantidade * $it_nfent_valor_unitario;
    $sql = "insert into itens_nf_entrada (it_nfent_nf_entrada_id, it_nfent_produto_id, it_nfent_obra_id, 
            it_nfent_quantidade, it_nfent_valor_unitario, it_nfent_valor_total) 
            values('$it_nfent_nf_entrada_id','$it_nfent_produto_id','$it_nfent_obra_id', '$it_nfent_quantidade',
            '$it_nfent_valor_unitario','$it_nfent_valor_total')";

    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Produto incluído com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('<strong>Verifique!</strong><br>Produto já inserido na NF!', 'warning', 6000);</script>";
    endif;

    // BUSCAR O ID DA NF INSERIDA
    $sql = "select * from nf_entrada where nfent_id = '$it_nfent_nf_entrada_id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $nfent_id = $dados['nfent_id'];
    $nfent_desc_por = $dados['nfent_desc_por'];
    $nfent_subtotal = $dados['nfent_subtotal'];

    $sql = "select sum(it.it_nfent_valor_total) subtotal 
                    from itens_nf_entrada it
                    where it_nfent_nf_entrada_id = '$nfent_id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $subtotal = $dados['subtotal'];

    $nfent_desc_vl = ($nfent_desc_por / 100) * $subtotal;
    $nfent_total = $subtotal - $nfent_desc_vl;

    $sql = "update nf_entrada set nfent_desc_vl = '$nfent_desc_vl', nfent_subtotal = '$subtotal', 
            nfent_total = '$nfent_total' where nfent_id = '$nfent_id'";
    mysqli_query($conexao, $sql);

    mysqli_close($conexao);
    header("Location: cadastrar-nf-entrada.php?nf=$nfent_id&msg=sim");

endif;

// EXCLUIR ITENS DA NF
if (isset($_GET['excluir'])) :
    $topo_id = $_GET['topo-id'];
    $itens_id = $_GET['itens-id'];
    $itens_total = $_GET['itens-total'];

    $sql = "delete from itens_nf_entrada where it_nfent_id = '$itens_id'";
    $resultado = mysqli_query($conexao, $sql);

    $_SESSION['msg'] = "<script>mostraDialogo('Produto excluído com sucesso!', 'success');</script>";

    // BUSCAR O ID DA NF INSERIDA
    $sql = "select * from nf_entrada where nfent_id = '$topo_id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $nfent_id = $dados['nfent_id'];
    $nfent_desc_por = $dados['nfent_desc_por'];
    $nfent_subtotal = $dados['nfent_subtotal'];

    $nfent_subtotal = $nfent_subtotal - $itens_total;
    $nfent_desc_vl = ($nfent_desc_por / 100) * $nfent_subtotal;
    $nfent_total = $nfent_subtotal - $nfent_desc_vl;

    $sql = "update nf_entrada set nfent_desc_vl = '$nfent_desc_vl', nfent_subtotal = '$nfent_subtotal', 
            nfent_total = '$nfent_total' where nfent_id = '$nfent_id'";
    mysqli_query($conexao, $sql);

    mysqli_close($conexao);
    header("Location: cadastrar-nf-entrada.php?nf=$nfent_id&msg=sim");

endif;

// CARREGAR NF
if (isset($_GET['nf'])) :

    $nf = $_GET['nf'];
    $sql = "select nf.*, f.for_razaosocial, o.obra_nome
            from nf_entrada nf, fornecedor f, obra o 
            where nf.nfent_obra_id = o.obra_id and nf.nfent_fornecedor_id = f.for_id and nf.nfent_id = '$nf'";

    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $nfent_id = $dados['nfent_id'];
    $nfent_tipo = $dados['nfent_tipo'];
    $nfent_numero = $dados['nfent_numero'];
    $nfent_fornecedor_id = $dados['nfent_fornecedor_id'];
    $fornecedor_nome = $dados['for_razaosocial'];
    $nfent_obra_id = $dados['nfent_obra_id'];
    $nfent_obra_nome = $dados['obra_nome'];
    $nfent_dt_emissao = $dados['nfent_dt_emissao'];
    $nfent_dt_lancamento = $dados['nfent_dt_lancamento'];
    $nfent_desc_por = $dados['nfent_desc_por'];
    $nfent_desc_vl = $dados['nfent_desc_vl'];
    $nfent_subtotal = $dados['nfent_subtotal'];
    $nfent_total = $dados['nfent_total'];
    $nfent_status = $dados['nfent_status'];
endif;

// EXCLUIR NF
if (isset($_GET['excluir-topo'])) :

    $nf = $_GET['topo-id'];

    $sql = "delete from itens_nf_entrada where it_nfent_nf_entrada_id = '$nf'";
    $resultado = mysqli_query($conexao, $sql);

    $sql = "delete from nf_entrada where nfent_id = '$nf'";
    $resultado = mysqli_query($conexao, $sql);

    mysqli_close($conexao);
    header("Location: listar-nf-entrada.php");

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
        <h3 class="h3">Entrada de Produtos</h3>
        <hr>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="id" id="id" value="<?= $nfent_id ?>" />
            <div class="row">
                <div class="col-md-3">
                    <label for="numero">Tipo *</label><br>
                    <input type="radio" name="tipo" id="tipoN" value="N" <?= $nfent_tipo == 'N' ? 'checked' : '' ?> required checked><label for="tipoN">&nbsp;NOTA FISCAL &nbsp;</label>
                    <input type="radio" name="tipo" id="tipoP" value="P" <?= $nfent_tipo == 'P' ? 'checked' : '' ?>><label for="tipoP">&nbsp;PEDIDO</label>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <label for="numero">Nº Documento *</label>
                    <input class="form-control" type="text" name="numero" id="numero" maxlength="100" value="<?= $nfent_numero ?>" required />
                </div>
                <div class="col-md-2">
                    <label for="dt-emissao">Data Emissão *</label>
                    <input class="form-control" type="date" name="dt-emissao" id="dt-emissao" value="<?= $nfent_dt_emissao ?>" required />
                </div>
                <div class="col-md-2">
                    <label for="dt-entrada">Data Entrada *</label>
                    <input class="form-control" type="date" name="dt-entrada" id="dt-entrada" value="<?= $nfent_dt_lancamento ?>" required />
                </div>
                <div class="col-md-2">
                    <label for="desc-por">Desconto % *</label>
                    <input class="form-control" type="text" name="desc-por" id="desc-por" onKeyPress="return(moeda(this,'','.',event))" value="<?= $nfent_desc_por != null ? $nfent_desc_por : 0 ?>" required />
                </div>
            </div>

            <?php if ($nfent_id != null) : ?>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <label for="desc-vl">Total Desconto R$</label>
                        <input class="form-control" type="text" name="desc-vl" id="desc-vl" value="<?= $nfent_desc_vl != null ? number_format($nfent_desc_vl, 2, ',', '.') : 0.00 ?>" readonly />
                    </div>
                    <div class="col-md-2">
                        <label for="subtotal">SubTotal R$</label>
                        <input class="form-control" type="text" name="subtotal" id="subtotal" value="<?= $nfent_subtotal != null ? number_format($nfent_subtotal, 2, ',', '.') : 0 ?>" readonly />
                    </div>

                    <div class="col-md-2">
                        <label for="total">Valor Total R$</label>
                        <input class="form-control" type="text" name="total" id="total" value="<?= number_format($nfent_total, 2, ',', '.') ?>" readonly />
                    </div>
                    <div class="col-md-2">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="D" <?= $nfent_status == 'D' ? 'selected' : '' ?>>DIGITADA</option>
                            <option value="F" <?= $nfent_status == 'F' ? 'selected' : '' ?>>FINALIZADA</option>
                            <option value="C" <?= $nfent_status == 'C' ? 'selected' : '' ?>>CANCELADA</option>
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
                        <input class="form-control" type="text" name="fornecedor" id="fornecedor" value="<?= $nfent_fornecedor_id ?>" readonly required />
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
                        <input class="form-control" type="text" name="obrapadrao" id="obrapadrao" value="<?= $nfent_obra_id ?>" readonly required />
                    </div>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="nomeobrapadrao" id="nomeobrapadrao" value="<?= $nfent_obra_nome ?>" readonly />
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
                        <i class="fa fa-plus"></i><?= $nfent_id == null ? ' Incluir' : ' Alterar' ?>
                    </button>
                    <?php

                    switch ($nfent_status):

                        case 'D':
                            echo "<a class='btn btn-danger' href='cadastrar-nf-entrada.php?topo-id=$nfent_id&excluir-topo=sim'><i class='fa fa-trash'></i> Excluir</a>";
                            break;
                        case 'F':
                            echo "<button type='button' id='btnPagamento' class='btn btn-primary' data-toggle='modal' data-target='#pesqPagto'>
                                        <i class='fa fa-usd'></i> Títulos à Pagar</button>";
                            break;
                    endswitch;

                    ?>
                    <a class="btn btn-warning" href="<?= isset($_GET['obra']) ? "./../obra/alterar-obra.php?id={$_GET['obra']}" : './listar-nf-entrada.php' ?>"><i class="fa fa-reply"></i> Voltar</a>
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
        if ($nfent_id != null) :
            if ($nfent_status != 'F') :
        ?>
                <h3 class="h3">Inserir Itens/Produtos</h3>
                <div class="row">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <input type="hidden" name="id" id="id" value="<?= $nfent_id ?>" />
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
                                <input class="form-control" type="text" name="obra" id="obra" value="<?= $nfent_obra_id ?>" readonly required />
                            </div>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="nomeobra" id="nomeobra" value="<?= $nfent_obra_nome ?>" readonly />
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
            $sql = "select it.*, o.obra_nome, p.pro_descricao from itens_nf_entrada it, obra o, produto p
                    where it.it_nfent_produto_id = p.pro_id and it.it_nfent_obra_id = o.obra_id and it_nfent_nf_entrada_id = '$nfent_id'";
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
                            <?= $nfent_status != 'F' ? "<th class='text-center'>Excluir</th>" : "" ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($dados = mysqli_fetch_array($resultado)) :
                            $it_nfent_id = $dados['it_nfent_id'];
                            $it_nfent_nf_entrada_id = $dados['it_nfent_nf_entrada_id'];
                            $it_nfent_produto_id = $dados['it_nfent_produto_id'];
                            $it_produto_descricao = $dados['pro_descricao'];
                            $it_nfent_obra_id = $dados['it_nfent_obra_id'];
                            $it_obra_nome = $dados['obra_nome'];
                            $it_nfent_quantidade = $dados['it_nfent_quantidade'];
                            $it_nfent_valor_unitario = $dados['it_nfent_valor_unitario'];
                            $it_nfent_valor_total = $dados['it_nfent_valor_total'];
                        ?>
                            <tr>
                                <td class="text-center"><?= $it_obra_nome ?></td>
                                <td class="text-center"><?= $it_produto_descricao ?></td>
                                <td class="text-center"><?= $it_nfent_quantidade ?></td>
                                <td class="text-center">R$ <?= number_format($it_nfent_valor_unitario, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($it_nfent_valor_total, 2, ',', '.') ?></td>
                                <?php
                                if ($nfent_status != 'F') :
                                ?>
                                    <td class="text-center">
                                        <a href='cadastrar-nf-entrada.php?topo-id=<?= $it_nfent_nf_entrada_id ?>&itens-id=<?= $it_nfent_id ?>&itens-total=<?= $it_nfent_valor_total ?>&excluir=sim'>
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

    <!-- Modal Forma Pagto -->

    <div class="modal fade" id="pesqPagto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Títulos à Pagar</h5>
                </div>
                <div class="modal-body">
                    <?php
                    $sqlTitulos = "select p.pagar_id, p.pagar_numero, p.pagar_sequencia, p.pagar_dt_venc, p.pagar_dt_pagto, p.pagar_vl_final, p.pagar_status
                            from pagar p, nf_entrada nf
                            where p.pagar_nf_entrada_id = nf.nfent_id and nf.nfent_id = '$nfent_id'";
                    $resultadoTitulos = mysqli_query($conexao, $sqlTitulos);
                    if ($resultadoTitulos->num_rows <= 0) :
                    ?>

                        <div class="formulario">
                            <span id="msg-cad"></span><br>
                            <form id="addTitulos" method="POST">
                                <input type="hidden" name="idNF" id="idNF" value="<?= $nfent_id ?>" />
                                <input type="hidden" name="numero" id="numero" value="<?= $nfent_numero ?>" />
                                <input type="hidden" name="fornecedor" id="fornecedor" value="<?= $nfent_fornecedor_id ?>" />
                                <input type="hidden" name="obra" id="obra" value="<?= $nfent_obra_id ?>" />
                                <input type="hidden" name="emissao" id="emissao" value="<?= $nfent_dt_emissao ?>" />
                                <input type="hidden" name="total" id="total" value="<?= $nfent_total ?>" />
                                <div class="col-md-3">
                                    <label>Valor NF R$</label>
                                    <input class="form-control" type="text" name="vl-total" id="vl-total" value="<?= number_format($nfent_total, 2, ',', '.') ?>" readonly />
                                </div>

                                <div class="col-md-3">
                                    <label>Qtd Parcelas</label>
                                    <input class="form-control" min="1" max="120" type="number" name="qtd" id="qtd" required />
                                </div>

                                <div class="col-md-3">
                                    <label>Intervalo (dias)</label>
                                    <input class="form-control" min="1" max="31" type="number" name="intervalo" id="intervalo" required />
                                </div>

                                <div class="col-md-1">
                                    <br>
                                    <button class="btn btn-primary" type="submit" name="itens">
                                        <i class="glyphicon glyphicon-flash"></i> Gerar Títulos à Pagar
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php
                    else :
                    ?>
                        <div class="tabela">
                            <table class="table">
                                <tr>
                                    <th>Número</th>
                                    <th>Vencimento</th>
                                    <th>Pagamento</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                <?php
                                while ($dados = mysqli_fetch_array($resultadoTitulos)) :
                                ?>

                                    <tr>
                                        <td><?= $dados['pagar_numero'] . " - " . $dados['pagar_sequencia'] ?></td>
                                        <td><?= date('d/m/Y', strtotime($dados['pagar_dt_venc'])) ?></td>
                                        <td><?= $dados['pagar_dt_pagto'] == '' ? '' : date('d/m/Y', strtotime($dados['pagar_dt_pagto'])) ?></td>
                                        <td>R$ <?= number_format($dados['pagar_vl_final'], 2, ',', '.') ?></td>
                                        <td><?= $dados['pagar_status'] == 'A' ? 'Aberto' : 'Pago' ?></td>
                                        <td><a href="../pagar/alterar-pagar.php?id=<?= $dados['pagar_id'] ?>"><span class="glyphicon glyphicon-search"></span></a></td>
                                    </tr>

                                <?php
                                endwhile;
                                ?>
                            </table>

                        </div>
                    <?php
                    endif;
                    ?>
                </div>
                <br><br><br><br>
                <div class="modal-footer">
                    <button type="button" id="btn-close-modal" class="btn btn-secondary">Fechar</button>
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

    <script src="./cadastrar-nf-entrada.js?id=124"></script>
</body>

</html>