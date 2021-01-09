<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';


if (isset($_POST['btnenviar'])) :
    
    $descricao = clear($_POST['descricao']);
    $unidade = clear($_POST['unidade']);
    $status = 'A';

    $sql = "insert into produto (pro_descricao, pro_unidade, pro_status) values('$descricao','$unidade','$status')";
    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Produto incluído com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('<strong>Erro ao incluir Produto!</strong><br>Produto já existe!', 'error', 5000);</script>";
    endif;

    mysqli_close($conexao);
    header("Location: cadastrar-produto.php?msg=sim");
    
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
</head>

<body class="nav-md">
    <?php
    include_once '../layout/cabecalho.php';
    ?>

    <!-- page content -->
    <div class="right_col" role="main">
        <h3 class="h3">Cadastro de Produto</h3>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="col-md-6">
                <label for="descricao">Descrição *</label>
                <input class="form-control" type="text" name="descricao" id="descricao" maxlength="100" required /><br>
            </div>
            <div class="col-md-6">
                <label for="unidade">Unidade de Medida *</label>
                <select class="form-control" name="unidade" id="unidade" required>
                    <option value="BARRA">BARRA</option>
                    <option value="CAIXA">CAIXA</option>
                    <option value="GALÃO">GALÃO</option>
                    <option value="GRAMA">GRAMA</option>
                    <option value="QUILOGRAMA">QUILOGRAMA</option>
                    <option value="LATA">LATA</option>
                    <option value="LITRO">LITRO</option>
                    <option value="METRO">METRO</option>
                    <option value="M2">M2</option>
                    <option value="M3">M3</option>
                    <option value="PEÇA">PEÇA</option>
                    <option value="ROLO">ROLO</option>
                    <option value="SACO">SACO</option>
                    <option value="UNIDADE">UNIDADE</option>
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
            if(isset($_GET['msg'])):
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
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.min.js"></script>
</body>

</html>