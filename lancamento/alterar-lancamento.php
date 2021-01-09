<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

if (isset($_GET['id'])) :

    $id = $_GET['id'];
    $sql = "select * from lancamento where lancamento_id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);

    $conta = $dados['lancamento_conta_id'];
    $numero = $dados['lancamento_documento'];
    $data = $dados['lancamento_data'];
    $tipo = $dados['lancamento_tipo'];
    $valor = $dados['lancamento_valor'];
    $valor = str_replace('.', ',', str_replace('', '.', $valor));
    $obs = $dados['lancamento_observacao'];
    $pagar_id = $dados['lancamento_pagar_id'];
    $receber_id = $dados['lancamento_receber_id'];

elseif (isset($_POST['btnenviar'])) :

    $id = clear($_POST['id']);
    $conta = clear($_POST['conta']);
    $numero = clear($_POST['numero']);
    $data = clear($_POST['data']);
    $valor = clear($_POST['valor']);
    $valor = str_replace(',', '.', str_replace('.', '', $valor));
    $obs = clear($_POST['obs']);
    $valorAnterior = clear($_POST['valorAnterior']);
    $tipoAnterior = clear($_POST['tipoAnterior']);

    $sql = "update lancamento set lancamento_conta_id = '$conta', lancamento_documento = '$numero', 
            lancamento_valor = '$valor', lancamento_data = '$data', 
            lancamento_observacao = '$obs' where lancamento_id = '$id'";
    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Lançamento alterado com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('<strong>Erro ao alterar Lançamento!</strong>', 'error', 5000);</script>";
    endif;

    // ATUALIZAR SALDO DA CONTA CAIXA
    $sql1 = "select * from conta";
    $resultado1 = mysqli_query($conexao, $sql1);
    $dados1 = mysqli_fetch_array($resultado1);
    $saldo = $dados1['conta_saldo'];

    if ($tipoAnterior == 'C') :
        $saldo = $saldo - $valorAnterior;
        $saldo = $saldo + $valor;
    else :
        $saldo = $saldo + $valorAnterior;
        $saldo = $saldo - $valor;
    endif;

    $sql = "update conta set conta_saldo = '$saldo'";
    $resultado = mysqli_query($conexao, $sql);

    mysqli_close($conexao);
    header("Location: alterar-lancamento.php?id=$id&msg=sim");

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
        <h3 class="h3">Alterar Lançamento no Caixa</h3>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="id" id="id" value="<?= $id ?>" />
            <input type="hidden" name="conta" id="conta" value="<?= $conta ?>" />
            <input type="hidden" name="valorAnterior" id="valorAnterior" value="<?= $valor ?>" />
            <input type="hidden" name="tipoAnterior" id="tipoAnterior" value="<?= $tipo ?>" />
            <div class="col-md-2">
                <label for="numero">Nº Documento</label>
                <input class="form-control" type="text" name="numero" id="numero" value="<?= $numero ?>" /><br>
            </div>
            <div class="col-md-2">
                <label for="data">Data *</label>
                <input class="form-control" type="date" name="data" id="data" value="<?= $data ?>" required /><br>
            </div>
            <div class="col-md-2">
                <label for="tipo">Tipo *</label>
                <input readonly class="form-control" type="text" name="tipo" id="tipo" value="<?= $tipo == 'C' ? 'CRÉDITO' : 'DÉBITO' ?>" /><br><br>
            </div>
            <div class="col-md-2">
                <label for="valor">Valor *</label>
                <input class="form-control" type="text" name="valor" id="valor" value="<?= $valor ?>" onKeyPress="return(moeda(this,'.',',',event))" required /><br>
            </div>
            <div class="col-md-10">
                <label for="obs">Observação</label>
                <textarea class="form-control" name="obs" id="obs" rows="5" cols="100"><?= $obs ?></textarea><br>
            </div>
            <div class="col-md-12">
                <?php
                if ($pagar_id == '' && $receber_id == '') :
                ?>
                    <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
                <?php
                endif;
                ?>
                <a class="btn btn-warning" href="./listar-lancamento.php"><i class="fa fa-reply"></i> Voltar</a>
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
    <script src="../js/funcoes.js?id=123"></script>
    <!-- Moeda -->
    <script src="../js/moeda.js"></script>
</body>

</html>