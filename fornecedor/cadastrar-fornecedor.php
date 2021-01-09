<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

if (isset($_POST['btnenviar'])) :
    $tipo = clear($_POST['tipop']);
    $nomefantasia = clear($_POST['nomefantasia']);
    $razaosocial = clear($_POST['razaosocial']);
    $cnpj = clear($_POST['cnpj']);
    $cpf = clear($_POST['cpf']);
    $ie = clear($_POST['ie']);
    $rg = clear($_POST['rg']);
    $emissor = clear($_POST['emissor']);
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
    $contato = clear($_POST['contato']);
    $status = 'A';

    if ($tipo == 'FISICA') :
        $sql = "select for_id from fornecedor where for_cpf = '$cpf'";
    else :
        $sql = "select for_id from fornecedor where for_cnpj = '$cnpj'";
    endif;

    $resultado = mysqli_query($conexao, $sql);
    if ($resultado->num_rows > 0) :
        $_SESSION['msg'] = "<script>mostraDialogo('<strong>Cadastro não efetuado!</strong><br>CPF/CNPJ já cadastrado!', 'warning', 6000);</script>";
    else :
        $sql = "insert into fornecedor (for_tipo_pessoa, for_fantasia, for_razaosocial, for_cnpj, for_cpf, for_ie, 
                for_rg, for_emissor_rg, for_telefone, for_celular, for_email, for_logradouro, for_complemento, 
                for_numero, for_bairro, for_cep, for_cidade, for_estado, for_contato, for_status)
                values ('$tipo', '$nomefantasia','$razaosocial','$cnpj', '$cpf', '$ie', '$rg', '$emissor', '$telefone', 
                '$celular', '$email','$logradouro','$complemento','$numero','$bairro', '$cep','$cidade','$estado',
                '$contato', 'A')";
        if (mysqli_query($conexao, $sql)) :
            $_SESSION['msg'] = "<script>mostraDialogo('Fornecedor incluído com sucesso!', 'success');</script>";
        else :
            $_SESSION['msg'] = "<script>mostraDialogo('Erro ao incluir Fornecedor!', 'error');</script>";
        endif;
    endif;
    mysqli_close($conexao);
    header("Location: cadastrar-fornecedor.php?msg=sim");
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
        <h3 class="h3">Cadastro de Fornecedor</h3>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="col-md-12">
                <label for="tipop">Tipo Pessoa *</label><br>
                <input type="radio" value="FISICA" name="tipop" id="fisica" required /><label for="fisica">&nbsp;FÍSICA&nbsp;</label>
                <input type="radio" value="JURIDICA" name="tipop" id="juridica" /><label for="juridica">&nbsp;JURÍDICA</label><br><br>
            </div>
            <div id="div-nomefantasia">
                <div class="col-md-6">
                    <label for="nomefantasia">Nome Fantasia *</label>
                    <input class="form-control" type="text" name="nomefantasia" id="nomefantasia" maxlength="100" required /><br>
                </div>
            </div>
            <div id="div-nome">
                <div class="col-md-6">
                    <label for="razaosocial">Nome/Razão Social *</label>
                    <input class="form-control" type="text" name="razaosocial" id="razaosocial" maxlength="100" required /><br>
                </div>
            </div>
            <div id="div-cnpj">
                <div class="col-md-6">
                    <label for="cnpj">CNPJ *</label>
                    <input class="form-control" type="text" name="cnpj" id="cnpj" required data-inputmask="'mask' : '99.999.999/9999-99'" /><br>
                </div>
            </div>
            <div id="div-cpf">
                <div class="col-md-6">
                    <label for="cpf">CPF *</label>
                    <input class="form-control" type="text" name="cpf" id="cpf" required data-inputmask="'mask' : '999.999.999-99'" /><br>
                </div>
            </div>
            <div id="div-ie">
                <div class="col-md-6">
                    <label for="ie">Inscrição Estadual</label>
                    <input class="form-control" type="text" name="ie" id="ie" /><br>
                </div>
            </div>
            <div id="div-rg">
                <div class="col-md-6">
                    <label for="rg">RG</label>
                    <input class="form-control" type="text" name="rg" id="rg" /><br>
                </div>
            </div>
            <div id="div-emissor">
                <div class="col-md-6">
                    <label for="emissor">Órgão Emissor</label>
                    <input class="form-control" type="text" name="emissor" id="emissor" /><br>
                </div>
            </div>
            <div class="col-md-6">
                <label for="telefone">Telefone</label>
                <input class="form-control" type="text" name="telefone" id="telefone" data-inputmask="'mask' : '(99) 9999-9999'" /><br>
            </div>
            <div class="col-md-6">
                <label for="celular">Celular</label>
                <input class="form-control" type="text" name="celular" id="celular" data-inputmask="'mask' : '(99) 99999-9999'" /><br>
            </div>
            <div class="col-md-6">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" maxlength="100" /><br>
            </div>
            <div class="col-md-6">
                <label for="contato">Contato</label>
                <input class="form-control" type="text" name="contato" id="contato" maxlength="100" /><br>
            </div>
            <div class="col-md-6">
                <label for="cep">CEP *</label>
                <input class="form-control" type="text" name="cep" id="cep" required data-inputmask="'mask' : '99.999-999'" /><br>
            </div>
            <div class="col-md-6">
                <label for="logradouro">Logradouro *</label>
                <input class="form-control" type="text" name="logradouro" id="logradouro" maxlength="100" required /><br>
            </div>
            <div class="col-md-6">
                <label for="complemento">Complemento</label>
                <input class="form-control" type="text" name="complemento" id="complemento" /><br>
            </div>
            <div class="col-md-6">
                <label for="numero">Número *</label>
                <input class="form-control" type="text" name="numero" id="numero" required /><br>
            </div>
            <div class="col-md-6">
                <label for="bairro">Bairro *</label>
                <input class="form-control" type="text" name="bairro" id="bairro" maxlength="100" required /><br>
            </div>
            <div class="col-md-6">
                <label for="cidade">Cidade *</label>
                <input class="form-control" type="text" name="cidade" id="cidade" maxlength="100" required /><br>
            </div>
            <div class="col-md-6">
                <label for="estado">Estado *</label>
                <select class="form-control" name="estado" id="estado">
                    <option value="AC">ACRE</option>
                    <option value="AL">AlAGOAS</option>
                    <option value="AP">AMAPÁ</option>
                    <option value="AM">AMAZONAS</option>
                    <option value="BA">BAHIA</option>
                    <option value="CE">CEARÁ</option>
                    <option value="DF">DISTRITO FEDERAL</option>
                    <option value="ES">ESPÍRITO SANTO</option>
                    <option value="GO">GOIÁS</option>
                    <option value="MA">MARANHÃO</option>
                    <option value="MT">MATO GROSSO</option>
                    <option value="MS">MATO GROSSO DO SUL</option>
                    <option value="MG">MINAS GERAIS</option>
                    <option value="PA">PARÁ</option>
                    <option value="PB">PARAÍBA</option>
                    <option value="PR">PARANÁ</option>
                    <option value="PE">PERNAMBUCO</option>
                    <option value="PI">PIAUÍ</option>
                    <option value="RJ">RIO DE JANEIRO</option>
                    <option value="RN">RIO GRANDE DO NORTE</option>
                    <option value="RS">RIO GRANDE DO SUL</option>
                    <option value="RO">RONDÔNIA</option>
                    <option value="RR">RORAIMA</option>
                    <option value="SC">SANTA CATARINA</option>
                    <option value="SP">SÃO PAULO</option>
                    <option value="SE">SERGIPE</option>
                    <option value="TO">TOCANTINS</option>
                </select><br>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
                <a class="btn btn-warning" href="./listar-fornecedor.php"><i class="fa fa-reply"></i> Voltar</a>
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
</body>

</html>