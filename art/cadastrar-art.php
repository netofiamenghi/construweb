<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

// inserir
if (isset($_POST['btnenviar'])) :

    $obra_id = clear($_POST['obra']);
    $tipoart = clear($_POST['tipoart']);
    $numero = clear($_POST['numero']);
    $data = clear($_POST['data']);
    $valor = clear($_POST['valor']);
    $valor = str_replace(',', '.', str_replace('.', '', $valor));
   // $descricao = clear($_POST['descricao']);
    $formatospermitidos = array("pdf");
    $extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

    // COM IMAGEM
    if ($extensao != null) :
        if (in_array($extensao, $formatospermitidos)) :
            $pasta = "./arquivos/";
            $temporario = $_FILES['arquivo']['tmp_name'];
            $novoNome = uniqid() . ".$extensao";
            if (move_uploaded_file($temporario, $pasta . $novoNome)) :
                $sql = "insert into art (art_obra_id, art_tipo_art_id, art_numero, art_data, art_valor, art_arquivo) 
                        values('$obra_id','$tipoart','$numero','$data','$valor','$novoNome')";
                if (mysqli_query($conexao, $sql)) :
                    $_SESSION['msg'] = "<script>mostraDialogo('ART incluída com sucesso!', 'success');</script>";
                else :
                    $_SESSION['msg'] = "<script>mostraDialogo('<strong>ART não incluída!</strong><br>Número de ART já incluída para essa obra!', 'warning', 5000);</script>";
                endif;
            else :
                $_SESSION['msg'] = "<script>mostraDialogo('Não foi possível fazer o upload do ARQUIVO!', 'error');</script>";
            endif;
        else :
            $_SESSION['msg'] = "<script>mostraDialogo('Formato de ARQUIVO incompátivel!', 'error');</script>";
        endif;

    else :
        $sql = "insert into art (art_obra_id, art_tipo_art_id, art_numero, art_data, art_valor) 
                values('$obra_id','$tipoart','$numero','$data','$valor')";
        if (mysqli_query($conexao, $sql)) :
            $_SESSION['msg'] = "<script>mostraDialogo('ART incluída com sucesso!', 'success');</script>";
        else :
            $_SESSION['msg'] = "<script>mostraDialogo('<strong>ART não incluída!</strong><br>Número de ART já incluída para essa obra!', 'warning', 5000);</script>";
            //$_SESSION['msg'] = mysqli_error($conexao);
        endif; 
    endif;

    mysqli_close($conexao);
    header("Location: cadastrar-art.php?msg=sim&obra=$obra_id");

// carregar    
elseif ($_GET['obra']) :

    $obra_id = $_GET['obra'];
    $sql = "select obra_nome from obra where obra_id = '$obra_id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $obra_nome = mb_substr($dados['obra_nome'], 0, 50);

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
        <h3 class="h3">Cadastro de ART</h3>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
            <div class="col-md-6">
                <div class="col-md-12">
                    <label for="obra">Obra *</label>
                </div>
                <div class="col-md-2">
                    <input class="form-control" type="text" name="obra" id="obra" value="<?= $obra_id ?>" readonly required />
                </div>
                <div class="col-md-10">
                    <input class="form-control" type="text" name="nomeobra" id="nomeobra" value="<?= $obra_nome ?>" readonly />
                </div>
            </div>
            <div class="col-md-4">
                <label for="tipoart">Tipo de ART *</label>
                <select class="form-control" name="tipoart" id="tipoart">

                    <?php
                    $sql = "select * from tipo_art order by tipo_descricao";
                    $resultado = mysqli_query($conexao, $sql);
                    while ($dados = mysqli_fetch_array($resultado)) :
                        $tipo_id = $dados['tipo_id'];
                        $tipo_descricao = mb_substr($dados['tipo_descricao'], 0, 30);
                    ?>
                        <option value="<?= $tipo_id ?>"><?= $tipo_descricao ?></option>
                    <?php
                    endwhile;
                    ?>
                </select><br>
            </div>

            <div class="col-md-3">
                <label for="numero">Número *</label>
                <input class="form-control" type="text" name="numero" id="numero" required /><br>
            </div>
            <div class="col-md-3">
                <label for="data">Data *</label>
                <input class="form-control" type="date" name="data" id="data" required /><br>
            </div>
            <div class="col-md-3">
                <label for="valor">Valor *</label>
                <input class="form-control" type="text" name="valor" id="valor" onKeyPress="return(moeda(this,'.',',',event))" required /><br>
            </div>

            <!-- <div class="col-md-10">
                <label for="descricao">Descrição *</label>
                <textarea class="form-control" name="descricao" id="descricao" rows="5" cols="100" required></textarea><br>
            </div> -->
            <div class="col-md-6">
                <label for="arquivo">Selecione o arquivo</label>
                <input class="form-control" type="file" name="arquivo" id="arquivo" /><br>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
                <a class="btn btn-warning" href="./../obra/alterar-obra.php?id=<?= $obra_id ?>"><i class="fa fa-reply"></i> Voltar</a>
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
    <br><br>
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
    <!-- Moeda -->
    <script src="../js/moeda.js"></script>
</body>

</html>