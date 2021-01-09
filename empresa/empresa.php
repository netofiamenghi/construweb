<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

// alterar
if ($_POST['id'] != null) :
    $id = clear($_POST['id']);
    $fantasia = clear($_POST['nomefantasia']);
    $razao = clear($_POST['razaosocial']);
    $cnpj = clear($_POST['cnpj']);
    $telefone = clear($_POST['telefone']);
    $celular = clear($_POST['celular']);
    $email = clear($_POST['email']);
    $logradouro = clear($_POST['logradouro']);
    $complemento = clear($_POST['complemento']);
    $numero = clear($_POST['numero']);
    $bairro = clear($_POST['bairro']);
    $cep = clear($_POST['cep']);
    $cidade = clear($_POST['cidade']);
    $estado = clear($_POST['estado']);
    $responsavel = clear($_POST['responsavel']);
    $formatospermitidos = array("png", "jpeg", "jpg", "gif");
    $extensao = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);

    // alterar com imagem
    if ($extensao != null) :
        if (in_array($extensao, $formatospermitidos)) :
            $pasta = "../img/empresa/";
            $temporario = $_FILES['logo']['tmp_name'];
            $novoNome = uniqid() . ".$extensao";
            if (move_uploaded_file($temporario, $pasta . $novoNome)) :
                $sql = "update empresa set emp_fantasia = '$fantasia', emp_razao = '$razao', emp_cnpj = '$cnpj', 
                emp_telefone = '$telefone', emp_celular = '$celular', emp_email = '$email', emp_logradouro = '$logradouro',
                emp_complemento = '$complemento', emp_numero = '$numero', emp_bairro = '$bairro', emp_cep = '$cep', 
                emp_cidade = '$cidade', emp_estado = '$estado', emp_responsavel = '$responsavel', emp_imagem = '$novoNome' 
                where emp_id = '$id' ";
                if (mysqli_query($conexao, $sql)) :
                    $_SESSION['msg'] = "<script>mostraDialogo('Empresa alterada com sucesso!', 'success');</script>";
                else :
                    $_SESSION['msg'] = "<script>mostraDialogo('Erro ao alterar Empresa!', 'error');</script>";
                endif;
            else :
                $_SESSION['msg'] = "<script>mostraDialogo('Não foi possível fazer o upload da imagem!', 'error');</script>";
            endif;
        else :
            $_SESSION['msg'] = "<script>mostraDialogo('Formato de imagem incompátivel!', 'error');</script>";
        endif;
        mysqli_close($conexao);
        header("Location: empresa.php?msg=sim");
    // alterar sem imagem    
    else :
        $sql = "update empresa set emp_fantasia = '$fantasia', emp_razao = '$razao', emp_cnpj = '$cnpj', 
                emp_telefone = '$telefone', emp_celular = '$celular', emp_email = '$email', emp_logradouro = '$logradouro',
                emp_complemento = '$complemento', emp_numero = '$numero', emp_bairro = '$bairro', emp_cep = '$cep', 
                emp_cidade = '$cidade', emp_estado = '$estado', emp_responsavel = '$responsavel' 
                where emp_id = '$id' ";
        if (mysqli_query($conexao, $sql)) :
            $_SESSION['msg'] = "<script>mostraDialogo('Empresa alterada com sucesso!', 'success');</script>";
        else :
            $_SESSION['msg'] = "<script>mostraDialogo('Erro ao alterar Empresa!', 'error');</script>";
        endif;
    endif;

    mysqli_close($conexao);
    header("Location: empresa.php?msg=sim");

// inserir
elseif (isset($_POST['btnenviar'])) :
    $nomefantasia = clear($_POST['nomefantasia']);
    $razaosocial = clear($_POST['razaosocial']);
    $cnpj = clear($_POST['cnpj']);
    $telefone = clear($_POST['telefone']);
    $celular = clear($_POST['celular']);
    $email = clear($_POST['email']);
    $logradouro = clear($_POST['logradouro']);
    $complemento = clear($_POST['complemento']);
    $numero = clear($_POST['numero']);
    $bairro = clear($_POST['bairro']);
    $cep = clear($_POST['cep']);
    $cidade = clear($_POST['cidade']);
    $estado = clear($_POST['estado']);
    $responsavel = clear($_POST['responsavel']);

    $formatospermitidos = array("png", "jpeg", "jpg", "gif");
    $extensao = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
    if (in_array($extensao, $formatospermitidos)) :
        $pasta = "../img/empresa/";
        $temporario = $_FILES['logo']['tmp_name'];
        $novoNome = uniqid() . ".$extensao";
        if (move_uploaded_file($temporario, $pasta . $novoNome)) :
            $sql = "insert into empresa (emp_fantasia, emp_razao, emp_cnpj, emp_telefone, emp_celular, emp_email, emp_logradouro, emp_complemento, emp_numero, "
                . "emp_bairro, emp_cep, emp_cidade, emp_estado, emp_responsavel, emp_imagem, emp_status) values('$nomefantasia','$razaosocial','$cnpj','$telefone', '$celular', '$email',"
                . "'$logradouro','$complemento','$numero','$bairro','$cep', '$cidade', '$estado', '$responsavel', '$novoNome', 'A')";
            if (mysqli_query($conexao, $sql)) :
                $_SESSION['msg'] = "<script>mostraDialogo('Empresa incluída com sucesso!', 'success');</script>";
            else :
                $_SESSION['msg'] = "<script>mostraDialogo('Erro ao incluir a Empresa!', 'error');</script>";
            endif;
        else :
            $_SESSION['msg'] = "<script>mostraDialogo('Não foi possível fazer o upload da Imagem!', 'error');</script>";
        endif;
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('Formato de Imagem incompátivel!', 'error');</script>";
    endif;
    mysqli_close($conexao);
    header("Location: empresa.php?msg=sim");

// carregar
else :
    $sql = "select * from empresa";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado->num_rows > 0) :

        $dados = mysqli_fetch_array($resultado);
        $id = $dados['emp_id'];
        $fantasia = $dados['emp_fantasia'];
        $razao = $dados['emp_razao'];
        $cnpj = $dados['emp_cnpj'];
        $telefone = $dados['emp_telefone'];
        $celular = $dados['emp_celular'];
        $email = $dados['emp_email'];
        $logradouro = $dados['emp_logradouro'];
        $complemento = $dados['emp_complemento'];
        $numero = $dados['emp_numero'];
        $bairro = $dados['emp_bairro'];
        $cep = $dados['emp_cep'];
        $cidade = $dados['emp_cidade'];
        $estado = $dados['emp_estado'];
        $logo = $dados['emp_imagem'];
        $responsavel = $dados['emp_responsavel'];

    endif;
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
        <h3 class="h3">Cadastro de Empresa</h3>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="<?= $id ?>" />
            <div class="col-md-6">
                <label for="nomefantasia">Nome Fantasia *</label>
                <input class="form-control" type="text" name="nomefantasia" id="nomefantasia" maxlength="100" required value="<?= $fantasia ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="razaosocial">Razão Social *</label>
                <input class="form-control" type="text" name="razaosocial" id="razaosocial" maxlength="100" required value="<?= $razao ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="cnpj">CNPJ *</label>
                <input class="form-control" type="text" name="cnpj" id="cnpj" required data-inputmask="'mask' : '99.999.999/9999-99'" value="<?= $cnpj ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="telefone">Telefone</label>
                <input class="form-control" type="text" name="telefone" id="telefone" data-inputmask="'mask' : '(99) 9999-9999'" value="<?= $telefone ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="celular">Celular</label>
                <input class="form-control" type="text" name="celular" id="celular" data-inputmask="'mask' : '(99) 99999-9999'" value="<?= $celular ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" maxlength="100" value="<?= $email ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="responsavel">Responsável</label>
                <input class="form-control" type="text" name="responsavel" id="responsavel" maxlength="100" value="<?= $responsavel ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="cep">CEP *</label>
                <input class="form-control" type="text" name="cep" id="cep" required data-inputmask="'mask' : '99.999-999'" value="<?= $cep ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="logradouro">Logradouro *</label>
                <input class="form-control" type="text" name="logradouro" id="logradouro" maxlength="100" required value="<?= $logradouro ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="complemento">Complemento</label>
                <input class="form-control" type="text" name="complemento" id="complemento" value="<?= $complemento ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="numero">Número *</label>
                <input class="form-control" type="text" name="numero" id="numero" required value="<?= $numero ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="bairro">Bairro *</label>
                <input class="form-control" type="text" name="bairro" id="bairro" maxlength="100" required value="<?= $bairro ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="cidade">Cidade *</label>
                <input class="form-control" type="text" name="cidade" id="cidade" maxlength="100" required value="<?= $cidade ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="estado">Estado *</label>
                <select class="form-control" name="estado" id="estado">
                    <option <?= $estado == 'AC' ? 'selected' : '' ?> value="AC">ACRE</option>
                    <option <?= $estado == 'AL' ? 'selected' : '' ?> value="AL">ALAGOAS</option>
                    <option <?= $estado == 'AP' ? 'selected' : '' ?> value="AP">AMAPÁ</option>
                    <option <?= $estado == 'AM' ? 'selected' : '' ?> value="AM">AMAZONAS</option>
                    <option <?= $estado == 'BA' ? 'selected' : '' ?> value="BA">BAHIA</option>
                    <option <?= $estado == 'CE' ? 'selected' : '' ?> value="CE">CEARÁ</option>
                    <option <?= $estado == 'DF' ? 'selected' : '' ?> value="DF">DISTRITO FEDERAL</option>
                    <option <?= $estado == 'ES' ? 'selected' : '' ?> value="ES">ESPÍRITO SANTO</option>
                    <option <?= $estado == 'GO' ? 'selected' : '' ?> value="GO">GOIÁS</option>
                    <option <?= $estado == 'MA' ? 'selected' : '' ?> value="MA">MARANHÃO</option>
                    <option <?= $estado == 'MT' ? 'selected' : '' ?> value="MT">MATO GROSSO</option>
                    <option <?= $estado == 'MS' ? 'selected' : '' ?> value="MS">MATO GROSSO DO SUL</option>
                    <option <?= $estado == 'MG' ? 'selected' : '' ?> value="MG">MINAS GERAIS</option>
                    <option <?= $estado == 'PA' ? 'selected' : '' ?> value="PA">PARÁ</option>
                    <option <?= $estado == 'PB' ? 'selected' : '' ?> value="PB">PARAÍBA</option>
                    <option <?= $estado == 'PR' ? 'selected' : '' ?> value="PR">PARANÁ</option>
                    <option <?= $estado == 'PE' ? 'selected' : '' ?> value="PE">PERNAMBUCO</option>
                    <option <?= $estado == 'PI' ? 'selected' : '' ?> value="PI">PIAUÍ</option>
                    <option <?= $estado == 'RJ' ? 'selected' : '' ?> value="RJ">RIO DE JANEIRO</option>
                    <option <?= $estado == 'RN' ? 'selected' : '' ?> value="RN">RIO GRANDE DO NORTE</option>
                    <option <?= $estado == 'RS' ? 'selected' : '' ?> value="RS">RIO GRANDE DO SUL</option>
                    <option <?= $estado == 'RO' ? 'selected' : '' ?> value="RO">RONDÔNIA</option>
                    <option <?= $estado == 'RR' ? 'selected' : '' ?> value="RR">RORAIMA</option>
                    <option <?= $estado == 'SC' ? 'selected' : '' ?> value="SC">SANTA CATARINA</option>
                    <option <?= $estado == 'SP' ? 'selected' : '' ?> value="SP">SÃO PAULO</option>
                    <option <?= $estado == 'SE' ? 'selected' : '' ?> value="SE">SERGIPE</option>
                    <option <?= $estado == 'TO' ? 'selected' : '' ?> value="TO">TOCANTINS</option>
                </select><br>
            </div>
            <div class="col-md-6">
                <label for="imagem">Selecione a imagem</label>
                <input class="form-control" type="file" name="logo" id="logo" /><br>
                <img src="./../img/empresa/<?= $logo ?>" width="100px" alt="Sem Logo" /><br><br>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
                <a class="btn btn-warning" href="./../geral/pagina-inicial.php"><i class="fa fa-reply"></i> Voltar</a>
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
</body>

</html>