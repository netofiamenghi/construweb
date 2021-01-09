<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

if (isset($_POST['btnenviar'])) :
    $conta = clear($_POST['conta']);
    $numero = clear($_POST['numero']);
    $data = clear($_POST['data']);
    $tipo = clear($_POST['tipo']);
    $valor = clear($_POST['valor']);
    $valor = str_replace(',', '.', str_replace('.', '', $valor));
    $obs = clear($_POST['obs']);

    $sql = "insert into lancamento (lancamento_conta_id, lancamento_documento, lancamento_valor, 
            lancamento_tipo, lancamento_data, lancamento_observacao)
            values ('$conta', '$numero','$valor','$tipo', '$data', '$obs')";

    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Lançamento incluído com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('Erro ao incluir Lançamento!', 'error');</script>";
    endif;

    // ATUALIZAR SALDO DA CONTA CAIXA
    $sql1 = "select * from conta";
    $resultado1 = mysqli_query($conexao, $sql1);
    $dados1 = mysqli_fetch_array($resultado1);
    $saldo = $dados1['conta_saldo'];

    if ($tipo == 'C') :
        $saldo = $saldo + $valor;
    else :
        $saldo = $saldo - $valor;
    endif;

    $sql = "update conta set conta_saldo = '$saldo'";
    $resultado = mysqli_query($conexao, $sql);

    mysqli_close($conexao);
    header("Location: cadastrar-lancamento.php?msg=sim");
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
        <h3 class="h3">Lançamento no Caixa</h3>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="conta" id="conta" value="1" />
            <div class="col-md-2">
                <label for="numero">Nº Documento</label>
                <input class="form-control" type="text" name="numero" id="numero" /><br>
            </div>
            <div class="col-md-2">
                <label for="data">Data *</label>
                <input class="form-control" type="date" name="data" id="data" required /><br>
            </div>
            <div class="col-md-2">
                <label for="tipo">Tipo *</label>
                <select class="form-control" name="tipo" id="tipo">
                    <option value="C">CRÉDITO</option>
                    <option value="D">DÉBITO</option>
                </select><br>
            </div>
            <div class="col-md-2">
                <label for="valor">Valor *</label>
                <input class="form-control" type="text" name="valor" id="valor" onKeyPress="return(moeda(this,'.',',',event))" required /><br>
            </div>
            <div class="col-md-10">
                <label for="obs">Observação</label>
                <textarea class="form-control" name="obs" id="obs" rows="5" cols="100"></textarea><br>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
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