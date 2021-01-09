<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

if (isset($_GET['id'])) :

    $id = $_GET['id'];
    $sql = "select * from funcionario where fun_id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    mysqli_close($conexao);
    $nome = $dados['fun_nome'];
    $cpf = $dados['fun_cpf'];
    $sexo = $dados['fun_sexo'];
    $funcao = $dados['fun_funcao'];
    $estadocivil = $dados['fun_est_civil'];
    $numpasta = $dados['fun_num_pasta'];
    $cep = $dados['fun_cep'];
    $logradouro = $dados['fun_logradouro'];
    $numero = $dados['fun_numero'];
    $complemento = $dados['fun_complemento'];
    $bairro = $dados['fun_bairro'];
    $cidade = $dados['fun_cidade'];
    $estado = $dados['fun_estado'];
    $status = $dados['fun_status'];

elseif (isset($_POST['btnenviar'])) :
    
    $id = clear($_POST['id']);
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
    $status = clear($_POST['status']);

    $sql = "select * from obra where obra_resp_tecnico = '$id' or obra_resp_tecnico = '$id'";
    $verifica = mysqli_query($conexao, $sql);
    if ((@mysqli_num_rows($verifica) > 0) && ($status == "E")) {
        $_SESSION['msg'] = "<script>mostraDialogo('O Funcionário não pode ser excluído!', 'warning');</script>";
    } else {
        $sql = "update funcionario set fun_nome = '$nome', fun_cpf = '$cpf', fun_sexo = '$sexo', fun_funcao = '$funcao', fun_est_civil = '$estadocivil',  "
            . "fun_num_pasta = '$numpasta', fun_cep = '$cep', fun_logradouro = '$logradouro', fun_complemento = '$complemento', "
            . "fun_numero = '$numero', fun_bairro = '$bairro', fun_cidade = '$cidade', fun_estado = '$estado', fun_status = '$status' where fun_id = '$id'";
        if (mysqli_query($conexao, $sql)) :
            $_SESSION['msg'] = "<script>mostraDialogo('Funcionário alterado com sucesso!', 'success');</script>";
        else :
            $_SESSION['msg'] = "<script>mostraDialogo('<strong>Erro ao alterar Funcionário!</strong><br>Funcionário já cadastrado!', 'error', 6000);</script>";
        endif;
    }
    mysqli_close($conexao);
    header("Location: alterar-funcionario.php?id=$id&msg=sim");
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

        <h3 class="h3">Alterar Funcionário</h3>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="id" id="id" value="<?= $id ?>" /><br>
            <div class="col-md-6">
                <label for="nome">Nome *</label>
                <input class="form-control" type="text" name="nome" id="nome" maxlength="100" required value="<?= $nome ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="cpf">CPF *</label>
                <input class="form-control" type="text" name="cpf" id="cpf" required data-inputmask="'mask' : '999.999.999-99'" value="<?= $cpf ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="sexo">Sexo *</label>
                <select class="form-control" name="sexo" id="sexo">
                    <option value="M" <?= $sexo == 'M' ? 'selected' : '' ?>>MASCULINO</option>
                    <option value="F" <?= $sexo == 'F' ? 'selected' : '' ?>>FEMININO</option>
                </select><br>
            </div>
            <div class="col-md-6">
                <label for="funcao">Função *</label>
                <select class="form-control" name="funcao" id="funcao">
                    <option value="AJULEGISTA" <?= $funcao == 'AJULEGISTA' ? 'selected' : '' ?>>AJULEGISTA</option>
                    <option value="ARQUITETO" <?= $funcao == 'ARQUITETO' ? 'selected' : '' ?>>ARQUITETO(A)</option>
                    <option value="CARPINTEIRO" <?= $funcao == 'CARPINTEIRO' ? 'selected' : '' ?>>CARPINTEIRO(A)</option>
                    <option value="ENGENHEIRO" <?= $funcao == 'ENGENHEIRO' ? 'selected' : '' ?>>ENGENHEIRO(A)</option>
                    <option value="ELETRICISTA" <?= $funcao == 'ELETRICISTA' ? 'selected' : '' ?>>ELETRICISTA</option>
                    <option value="ELETRICISTA/ENCANADOR" <?= $funcao == 'ELETRICISTA/ENCANADOR' ? 'selected' : '' ?>>ELETRICISTA/ENCANADOR(A)</option>
                    <option value="ENCANADOR" <?= $funcao == 'ENCANADOR' ? 'selected' : '' ?>>ENCANADOR(A)</option>
                    <option value="ESTAGIÁRIO" <?= $funcao == 'ESTAGIÁRIO' ? 'selected' : '' ?>>ESTAGIÁRIO(A)</option>
                    <option value="FINANCEIRO" <?= $funcao == 'FINANCEIRO' ? 'selected' : '' ?>>FINANCEIRO(A)</option>
                    <option value="MARCENEIRO" <?= $funcao == 'MARCENEIRO' ? 'selected' : '' ?>>MARCENEIRO(A)</option>
                    <option value="MESTRE" <?= $funcao == 'MESTRE' ? 'selected' : '' ?>>MESTRE DE OBRA</option>
                    <option value="PEDREIRO" <?= $funcao == 'PEDREIRO' ? 'selected' : '' ?>>PEDREIRO(A)</option>
                    <option value="PINTOR" <?= $funcao == 'PINTOR' ? 'selected' : '' ?>>PINTOR(A)</option>
                    <option value="SECRETÁRIO" <?= $funcao == 'SECRETÁRIO' ? 'selected' : '' ?>>SECRETÁRIO(A)</option>
                    <option value="SERRALHEIRO" <?= $funcao == 'SERRALHEIRO' ? 'selected' : '' ?>>SERRALHEIRO(A)</option>
                    <option value="SERVENTE" <?= $funcao == 'SERVENTE' ? 'selected' : '' ?>>SERVENTE DE PEDREIRO</option>
                    <option value="SERVIÇOS GERAIS" <?= $funcao == 'SERVIÇOS GERAIS' ? 'selected' : '' ?>>SERVIÇOS GERAIS</option>
                </select><br>
            </div>
            <div class="col-md-6">
                <label for="estadocivil">Estado Civil *</label>
                <select class="form-control" name="estadocivil" id="estadocivil">
                    <option value="CASADO" <?= $estadocivil == 'CASADO' ? 'selected' : '' ?>>CASADO</option>
                    <option value="DIVORCIADO" <?= $estadocivil == 'DIVORCIADO' ? 'selected' : '' ?>>DIVORCIADO</option>
                    <option value="SOLTEIRO" <?= $estadocivil == 'SOLTEIRO' ? 'selected' : '' ?>>SOLTEIRO</option>
                    <option value="VIÚVO" <?= $estadocivil == 'VIÚVO' ? 'selected' : '' ?>>VIÚVO</option>
                </select><br>
            </div>
            <div class="col-md-6">
                <label for="numpasta">Número da Pasta</label>
                <input class="form-control" type="text" name="numpasta" id="numpasta" maxlength="100" value="<?= $numpasta ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="cep">CEP *</label>
                <input class="form-control" type="text" name="cep" id="cep" required value="<?= $cep ?>" data-inputmask="'mask' : '99.999-999'" /><br>
            </div>
            <div class="col-md-6">
                <label for="logradouro">Logradouro *</label>
                <input class="form-control" type="text" name="logradouro" id="logradouro" required value="<?= $logradouro ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="complemento">Complemento</label>
                <input class="form-control" type="text" name="complemento" id="complemento" value="<?= $complemento ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="numero">Número</label>
                <input class="form-control" type="text" name="numero" id="numero" value="<?= $numero ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="bairro">Bairro *</label>
                <input class="form-control" type="text" name="bairro" id="bairro" required value="<?= $bairro ?>" /><br>
            </div>
            <div class="col-md-6">
                <label for="cidade">Cidade *</label>
                <input class="form-control" type="text" name="cidade" id="cidade" required value="<?= $cidade ?>" /><br>
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
                <label for="status">Status *</label>
                <select class="form-control" name="status">
                    <option value="A" <?= $status == 'A' ? 'selected' : '' ?>>ATIVO</option>
                    <option value="I" <?= $status == 'I' ? 'selected' : '' ?>>INATIVO</option>
                    <option value="E" <?= $status == 'E' ? 'selected' : '' ?>>EXCLUÍDO</option>
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