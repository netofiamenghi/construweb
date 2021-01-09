<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

if (isset($_POST['btnenviar'])) :
    
    $nome = clear($_POST['nome']);
    $cpf = clear($_POST['cpf']);
    $sexo = clear($_POST['sexo']);
    $funcao = clear($_POST['funcao']);
    $estadocivil = clear($_POST['estadocivil']);
    $numpasta = clear($_POST['numpasta']);
    $cep = clear($_POST['cep']);
    $logradouro = clear($_POST['logradouro']);
    $numero = clear($_POST['numero']);
    $complemento = clear($_POST['complemento']);
    $bairro = clear($_POST['bairro']);
    $cidade = clear($_POST['cidade']);
    $estado = clear($_POST['estado']);

    $sql = "insert into funcionario (fun_nome, fun_cpf, fun_sexo, fun_funcao, fun_est_civil, fun_num_pasta, "
        . "fun_cep, fun_logradouro, fun_complemento, fun_numero, fun_bairro, fun_cidade, fun_estado, "
        . "fun_status) values('$nome', '$cpf', '$sexo','$funcao','$estadocivil','$numpasta',"
        . "'$cep', '$logradouro', '$complemento', '$numero', '$bairro', '$cidade', '$estado', 'A')";
    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Funcionário incluído com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('<strong>Erro ao incluir Funcionário!</strong><br>Funcionário já cadastrado!', 'error', 6000);</script>";
    endif;
    mysqli_close($conexao);
    header("Location: cadastrar-funcionario.php?msg=sim");
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
        <h3 class="h3">Cadastro de Funcionário</h3>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="col-md-6">
                <label for="nome">Nome *</label>
                <input class="form-control" type="text" name="nome" id="nome" maxlength="100" required /><br>
            </div>
            <div class="col-md-6">
                <label for="cpf">CPF *</label>
                <input class="form-control" type="text" name="cpf" id="cpf" required data-inputmask="'mask' : '999.999.999-99'" /><br>
            </div>
            <div class="col-md-6">
                <label for="sexo">Sexo *</label>
                <select class="form-control" name="sexo" id="sexo">
                    <option value="M">MASCULINO</option>
                    <option value="F">FEMININO</option>
                </select><br>
            </div>
            <div class="col-md-6">
                <label for="funcao">Função *</label>
                <select class="form-control" name="funcao" id="funcao">
                    <option value="AJULEGISTA">AJULEGISTA</option>
                    <option value="ARQUITETO">ARQUITETO(A)</option>
                    <option value="CARPINTEIRO">CARPINTEIRO(A)</option>
                    <option value="ENGENHEIRO">ENGENHEIRO(A)</option>
                    <option value="ELETRICISTA">ELETRICISTA</option>
                    <option value="ELETRICISTA/ENCANADOR">ELETRICISTA/ENCANADOR(A)</option>
                    <option value="ENCANADOR">ENCANADOR(A)</option>
                    <option value="ESTAGIÁRIO">ESTAGIÁRIO(A)</option>
                    <option value="FINANCEIRO">FINANCEIRO(A)</option>
                    <option value="MARCENEIRO">MARCENEIRO(A)</option>
                    <option value="MESTRE">MESTRE DE OBRA</option>
                    <option value="PEDREIRO">PEDREIRO(A)</option>
                    <option value="PINTOR">PINTOR(A)</option>
                    <option value="SECRETÁRIO">SECRETÁRIO(A)</option>
                    <option value="SERRALHEIRO">SERRALHEIRO(A)</option>
                    <option value="SERVENTE">SERVENTE DE PEDREIRO</option>
                    <option value="SERVIÇOS GERAIS">SERVIÇOS GERAIS</option>
                </select><br>
            </div>
            <div class="col-md-6">
                <label for="estadocivil">Estado Civil *</label>
                <select class="form-control" name="estadocivil" id="estadocivil">
                    <option value="CASADO">CASADO</option>
                    <option value="DIVORCIADO">DIVORCIADO</option>
                    <option value="SOLTEIRO">SOLTEIRO</option>
                    <option value="VIÚVO">VIÚVO</option>
                </select><br>
            </div>
            <div class="col-md-6">
                <label for="numpasta">Número da Pasta</label>
                <input class="form-control" type="text" name="numpasta" id="numpasta" maxlength="100" /><br>
            </div>
            <div class="col-md-6">
                <label for="cep">CEP *</label>
                <input class="form-control" type="text" name="cep" id="cep" required data-inputmask="'mask' : '99.999-999'" /><br>
            </div>
            <div class="col-md-6">
                <label for=" logradouro">Logradouro *</label>
                <input class="form-control" type="text" name="logradouro" id="logradouro" maxlength="100" required /><br>
            </div>
            <div class="col-md-6">
                <label for="complemento">Complemento</label>
                <input class="form-control" type="text" name="complemento" id="complemento" /><br>
            </div>
            <div class="col-md-6">
                <label for="numero">Número</label>
                <input class="form-control" type="text" name="numero" id="numero" /><br>
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
                <a class="btn btn-warning" href="listar-funcionario.php"><i class="fa fa-reply"></i> Voltar</a>
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
</body>

</html>