<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

if (isset($_GET['excluir'])) :
    $id = $_GET['id'];
    $sql = "delete from pagar where pagar_id = '$id'";
    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Título excluído com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('Erro ao excluir Título!', 'error');</script>";
    endif;

    mysqli_close($conexao);
    header("Location: listar-pagar.php?msg=sim");

// carregar título
elseif (isset($_GET['id'])) :

    $id = $_GET['id'];
    $sql = "select p.*, f.for_razaosocial, o.obra_nome 
            from pagar p, fornecedor f, obra o 
            where p.pagar_obra_id = o.obra_id and p.pagar_fornecedor_id = f.for_id and p.pagar_id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);

    $pagar_numero = $dados['pagar_numero'];
    $pagar_sequencia = $dados['pagar_sequencia'];
    $pagar_fornecedor_id = $dados['pagar_fornecedor_id'];
    $fornecedor_nome = $dados['for_razaosocial'];
    $pagar_obra_id = $dados['pagar_obra_id'];
    $obra_nome = $dados['obra_nome'];
    $pagar_dt_venc = $dados['pagar_dt_venc'];
    $pagar_dt_pagto = $dados['pagar_dt_pagto'];
    $pagar_vl_orig = $dados['pagar_vl_orig'];
    $pagar_vl_orig = str_replace('.', ',', str_replace('', '.', $pagar_vl_orig));
    $pagar_historico = $dados['pagar_historico'];
    $pagar_status = $dados['pagar_status'];

//  alterar título    
elseif (isset($_POST['btnenviar'])) :

    $id = clear($_POST['id']);
    $numero = clear($_POST['numero']);
    $sequencia = clear($_POST['sequencia']);
    $fornecedor = clear($_POST['fornecedor']);
    $obra = clear($_POST['obra']);
    $dtVenc = clear($_POST['dtVenc']);
    $valor = clear($_POST['valor']);
    $valor = str_replace(',', '.', str_replace('.', '', $valor));
    $historico = clear($_POST['historico']);

    $sql = "update pagar set pagar_numero = '$numero', pagar_sequencia = '$sequencia', 
            pagar_fornecedor_id = '$fornecedor', pagar_obra_id = '$obra', pagar_dt_venc = '$dtVenc',
            pagar_vl_orig = '$valor', pagar_vl_final = '$valor', pagar_historico = '$historico' 
            where pagar_id = '$id'";

    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Título alterado com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('Erro ao alterar Título!', 'error');</script>";
    endif;

    mysqli_close($conexao);
    header("Location: alterar-pagar.php?id=$id&msg=sim");
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

        <div class="col-md-12">
            <div class="col-md-10">
                <h3 class="h3">Alterar Título à Pagar</h3>
            </div>
            <?php
            if ($pagar_status == 'A') :
            ?>
                <div class="col-md-2">
                    <h1 class="text-right text-danger">Aberto</h1>
                </div>
            <?php
            else :
            ?>
                <div class="col-md-2">
                    <h1 class="text-right text-success">Pago</h1>
                </div>
            <?php endif; ?>
        </div>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="id" id="id" value="<?= $id ?>" />
            <div class="col-md-4">
                <label for="numero">Número *</label>
                <input class="form-control" type="text" name="numero" id="numero" value="<?= $pagar_numero ?>" required /><br>
            </div>
            <div class="col-md-2">
                <label for="numero">Sequência *</label>
                <input class="form-control" type="number" min="1" max="120" name="sequencia" id="sequencia" value="<?= $pagar_sequencia ?>" required /><br>
            </div>
            <div class="col-md-6">
                <label for="dtVenc">Data Vencimento *</label>
                <input class="form-control" type="date" name="dtVenc" id="dtVenc" value="<?= $pagar_dt_venc ?>" required /><br>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <label for="tipo">Selecione o Fornecedor *</label>
                </div>
                <div class="col-md-2">
                    <input class="form-control" type="text" name="fornecedor" id="fornecedor" value="<?= $pagar_fornecedor_id ?>" readonly required />
                </div>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="nomefornecedor" id="nomefornecedor" value="<?= $fornecedor_nome ?>" readonly />
                </div>
                <div class="col-md-2">
                    <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqFornecedor">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <label for="produto">Selecione a Obra *</label>
                </div>
                <div class="col-md-2">
                    <input class="form-control" type="text" name="obra" id="obra" value="<?= $pagar_obra_id ?>" readonly required />
                </div>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="nomeobra" id="nomeobra" value="<?= $obra_nome ?>" readonly />
                </div>
                <div class="col-md-2">
                    <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqObra">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <label for="valor">Valor *</label>
                <input class="form-control" type="text" name="valor" id="valor" onKeyPress="return(moeda(this,'.',',',event))" value="<?= $pagar_vl_orig ?>" required /><br>
            </div>
            <div class="col-md-12">
                <label for="historico">Histórico</label>
                <textarea class="form-control" name="historico" id="historico" rows="5" cols="100"><?= $pagar_historico ?></textarea><br>
            </div>
            <div class="col-md-12">
                <?php
                if ($pagar_status == 'A') :
                ?>
                    <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
                    <a href="./alterar-pagar.php?excluir=sim&id=<?= $id ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Excluir</a>
                <?php endif; ?>

                <?php

                if (isset($_GET['obra'])) :
                    $retorno = "./../obra/alterar-obra.php?id={$_GET['obra']}";
                elseif (isset($_GET['fornecedor'])) :
                    $retorno = "./../fornecedor/alterar-fornecedor.php?id={$_GET['fornecedor']}";
                else :
                    $retorno = "./listar-pagar.php";
                endif;
                ?>



                <a class="btn btn-warning" href="<?= $retorno ?>"><i class="fa fa-reply"></i> Voltar</a>
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
    </div>
    </div>
    <br />
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
                        <input class="form-control" type="text" name="pesquisa-fornecedor" id="pesquisa-fornecedor" placeholder="Digite a razão social do fornecedor" />
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
    <!-- < !-- Pesquisas modal -->
    <script src="../js/pesquisas-modal.js"></script>
    <!-- Moeda -->
    <script src="../js/moeda.js"></script>
</body>

</html>