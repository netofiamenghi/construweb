<?php

include_once '../util/conexao.php';
include_once '../util/funcoes.php';

$que_id = $_POST['que_id'];

if ($que_id != null) :
    $id = clear($_POST['cli_id']);
    $sql = "select * from cliente where cli_id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $nome = $dados['cli_nome'];
    $nomefantasia = $dados['cli_fantasia'];

    $que_id = clear($_POST['que_id']);
    $que_moram = clear($_POST['moram']);
    $que_garagem = clear($_POST['garagem']);
    $que_quartos = clear($_POST['quartos']);
    $que_integracao = clear($_POST['integracao']);
    $que_escritorio = clear($_POST['escritorio']);
    $que_acabamento = clear($_POST['acabamento']);
    $que_banheiro = clear($_POST['banheiro']);
    $que_lavabo = clear($_POST['lavabo']);
    $que_pne = clear($_POST['pne']);
    $que_tamBanheiro = clear($_POST['tamBanheiro']);
    $que_armazenamento = clear($_POST['armazenamento']);
    $que_lavanderia = clear($_POST['lavanderia']);
    $que_areaLazer = clear($_POST['areaLazer']);
    $que_vegetacao = clear($_POST['vegetacao']);
    $que_alarme = clear($_POST['alarme']);
    $que_camera = clear($_POST['camera']);
    $que_porteiro = clear($_POST['porteiro']);
    $que_observacao = clear($_POST['observacao']);
    $sql = "update questionario set que_moram = '$que_moram', que_garagem = '$que_garagem', que_quartos = '$que_quartos', "
        . "que_integracao = '$que_integracao', que_escritorio = '$que_escritorio', que_acabamento = '$que_acabamento', "
        . "que_banheiro = '$que_banheiro', que_lavabo = '$que_lavabo', que_pne = '$que_pne', que_tamBanheiro = '$que_tamBanheiro', "
        . "que_armazenamento = '$que_armazenamento', que_lavanderia = '$que_lavanderia', que_areaLazer = '$que_areaLazer', "
        . "que_vegetacao = '$que_vegetacao', que_alarme = '$que_alarme', que_camera = '$que_camera', que_porteiro = '$que_porteiro', "
        . "que_observacao = '$que_observacao' where que_id = '$que_id' ";

    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Questionário respondido com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('Erro ao responder o Questionário!', 'error');</script>";
    endif;
    header("Location: questionario-cliente.php?id=$id&msg=sim");

elseif (isset($_POST['btnenviar'])) :
    $id = clear($_POST['cli_id']);
    $sql = "select * from cliente where cli_id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $nome = $dados['cli_nome'];
    $nomefantasia = $dados['cli_fantasia'];

    $_SESSION['msg'] = "";
    $que_moram = clear($_POST['moram']);
    $que_garagem = clear($_POST['garagem']);
    $que_quartos = clear($_POST['quartos']);
    $que_integracao = clear($_POST['integracao']);
    $que_escritorio = clear($_POST['escritorio']);
    $que_acabamento = clear($_POST['acabamento']);
    $que_banheiro = clear($_POST['banheiro']);
    $que_lavabo = clear($_POST['lavabo']);
    $que_pne = clear($_POST['pne']);
    $que_tamBanheiro = clear($_POST['tamBanheiro']);
    $que_armazenamento = clear($_POST['armazenamento']);
    $que_lavanderia = clear($_POST['lavanderia']);
    $que_areaLazer = clear($_POST['areaLazer']);
    $que_vegetacao = clear($_POST['vegetacao']);
    $que_alarme = clear($_POST['alarme']);
    $que_camera = clear($_POST['camera']);
    $que_porteiro = clear($_POST['porteiro']);
    $que_observacao = clear($_POST['observacao']);
    $que_status = 'R';
    $cli_id = clear($_POST['cli_id']);

    $sql = "insert into questionario (que_moram, que_garagem, que_quartos, que_integracao, que_escritorio, "
        . "que_acabamento, que_banheiro, que_lavabo, que_pne, que_tamBanheiro, que_armazenamento, "
        . "que_lavanderia, que_areaLazer, que_vegetacao, que_alarme, que_camera, que_porteiro, que_observacao, "
        . "que_status, cli_id) "
        . "values('$que_moram','$que_garagem','$que_quartos','$que_integracao','$que_escritorio', '$que_acabamento',"
        . "'$que_banheiro','$que_lavabo','$que_pne','$que_tamBanheiro','$que_armazenamento',"
        . "'$que_lavanderia','$que_areaLazer','$que_vegetacao','$que_alarme','$que_camera', '$que_porteiro',"
        . "'$que_observacao', '$que_status', '$cli_id')";

    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Questionário respondido com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('Erro ao responder o Questionário!', 'error');</script>";
    endif;
    header("Location: questionario-cliente.php?id=$id&msg=sim");
    
else :
    $id = clear($_GET['id']);
    $sql = "select * from cliente where cli_id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $nome = $dados['cli_nome'];
    $nomefantasia = $dados['cli_fantasia'];

    $sql2 = "select * from questionario where cli_id = '$id'";
    $resultado2 = mysqli_query($conexao, $sql2);
    $dados2 = mysqli_fetch_array($resultado2);
    $que_id = $dados2['que_id'];
    $que_moram = $dados2['que_moram'];
    $que_garagem = $dados2['que_garagem'];
    $que_quartos = $dados2['que_quartos'];
    $que_integracao = $dados2['que_integracao'];
    $que_escritorio = $dados2['que_escritorio'];
    $que_acabamento = $dados2['que_acabamento'];
    $que_banheiro = $dados2['que_banheiro'];
    $que_lavabo = $dados2['que_lavabo'];
    $que_pne = $dados2['que_pne'];
    $que_tamBanheiro = $dados2['que_tamBanheiro'];
    $que_armazenamento = $dados2['que_armazenamento'];
    $que_lavanderia = $dados2['que_lavanderia'];
    $que_areaLazer = $dados2['que_areaLazer'];
    $que_vegetacao = $dados2['que_vegetacao'];
    $que_alarme = $dados2['que_alarme'];
    $que_camera = $dados2['que_camera'];
    $que_porteiro = $dados2['que_porteiro'];
    $que_observacao = $dados2['que_observacao'];
    $que_status = $dados2['que_status'];
endif;
?>

<!DOCTYPE html>
<html lang="pt-br">

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
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
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
        <h3 class="h3 text-center">Questionário Inicial</h3>
        <h4 class="h4">Cliente: <?= $nome == '0' ? $nomefantasia : $nome ?></h4>
        <br>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="form-horizontal form-label-left">
            <input type="hidden" name="cli_id" id="cli_id" value="<?= $id ?>" />
            <input type="hidden" name="que_id" id="que_id" value="<?= $que_id ?>" />
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" for="moram">Quantas pessoas irão morar? *</label>
                <div class="col-md-6 col-sm-6">
                    <input value="<?= $que_moram ?>" min="1" type="number" id="moram" name="moram" required class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" for="garagem">Garagem para quantos carros? *</label>
                <div class="col-md-6 col-sm-6">
                    <input value="<?= $que_garagem ?>" min="1" type="number" id="garagem" name="garagem" required class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" for="quartos">Quantos quartos? *</label>
                <div class="col-md-6 col-sm-6">
                    <input value="<?= $que_quartos ?>" min="1" type="number" id="quartos" name="quartos" required class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3">Integração de ambiente? *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="integracao" value="s" <?= $que_integracao == "s" ? "checked" : "" ?>> &nbsp; Sim &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="integracao" value="n" <?= $que_integracao == "n" ? "checked" : "" ?>> Não
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3">Escritório à parte? *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_escritorio == 's' ? 'checked' : '' ?> type="radio" name="escritorio" value="s"> &nbsp; Sim &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_escritorio == 'n' ? 'checked' : '' ?> type="radio" name="escritorio" value="n"> Não
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3">Tipo de acabamento? *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_acabamento == 'b' ? 'checked' : '' ?> type="radio" name="acabamento" value="b"> &nbsp; Básico &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_acabamento == 'i' ? 'checked' : '' ?> type="radio" name="acabamento" value="i"> Intermediário para fino
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_acabamento == 'f' ? 'checked' : '' ?> type="radio" name="acabamento" value="f"> Fino
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" for="banheiro">Mínimo de banheiros? *</label>
                <div class="col-md-6 col-sm-6">
                    <input value="<?= $que_banheiro ?>" min="1" type="number" id="banheiro" name="banheiro" required class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3">Necessita de lavabo? *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_lavabo == 's' ? 'checked' : '' ?> type="radio" name="lavabo" value="s"> &nbsp; Sim &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_lavabo == 'n' ? 'checked' : '' ?> type="radio" name="lavabo" value="n"> Não
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3">Adaptações para PNE? *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_pne == 's' ? 'checked' : '' ?> type="radio" name="pne" value="s"> &nbsp; Sim &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_pne == 'n' ? 'checked' : '' ?> type="radio" name="pne" value="n"> Não
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" for="first-name">Banherios: *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_tamBanheiro == 'l' ? 'checked' : '' ?> type="radio" name="tamBanheiro" value="l"> &nbsp; Largos e grandes &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_tamBanheiro == 'd' ? 'checked' : '' ?> type="radio" name="tamBanheiro" value="d"> Dimensões mínimas e confortáveis
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3">Armazenamento: *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_armazenamento == 'd' ? 'checked' : '' ?> type="radio" name="armazenamento" value="d"> &nbsp; Despensa &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_armazenamento == 'm' ? 'checked' : '' ?> type="radio" name="armazenamento" value="m"> Móveis Planejados
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3">Lavanderia? *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_lavanderia == 's' ? 'checked' : '' ?> type="radio" name="lavanderia" value="s"> &nbsp; Sim &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_lavanderia == 'n' ? 'checked' : '' ?> type="radio" name="lavanderia" value="n"> Não
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" for="areaLazer">Na área de lazer, quais os desejos? *</label>
                <div class="col-md-6 col-sm-6">
                    <textarea id="areaLazer" name="areaLazer" required="required" class="form-control col-md-7 col-xs-12"><?= $que_areaLazer ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3">Vegetação em abundância? *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_vegetacao == 's' ? 'checked' : '' ?> type="radio" name="vegetacao" value="s"> &nbsp; Sim &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_vegetacao == 'n' ? 'checked' : '' ?> type="radio" name="vegetacao" value="n"> Não
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3">Alarme? *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_alarme == 's' ? 'checked' : '' ?> type="radio" name="alarme" value="s"> &nbsp; Sim &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_alarme == 'n' ? 'checked' : '' ?> type="radio" name="alarme" value="n"> Não
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3">Câmera de vídeo? *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_camera == 's' ? 'checked' : '' ?> type="radio" name="camera" value="s"> &nbsp; Sim &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_camera == 'n' ? 'checked' : '' ?> type="radio" name="camera" value="n"> Não
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3">Porteiro? *</label>
                <div class="col-md-6 col-sm-6">
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_porteiro == 's' ? 'checked' : '' ?> type="radio" name="porteiro" value="s"> &nbsp; Sim &nbsp;
                    </label>
                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input <?= $que_porteiro == 'n' ? 'checked' : '' ?> type="radio" name="porteiro" value="n"> Não
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" for="obs">Observações: *</label>
                <div class="col-md-6 col-sm-6">
                    <textarea id="observacao" name="observacao" required class="form-control col-md-7 col-xs-12"><?= $que_observacao ?></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
                <a class="btn btn-warning" href="listar-cliente.php"><i class="fa fa-reply"></i> Voltar</a>
            </div>
        </form>
        <br><br>
        <?php
            if(isset($_GET['msg'])):
                echo $_SESSION['msg'];
            endif;
        ?>
    </div>
    <br>
    </div>
    <!-- End SmartWizard Content -->
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
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- jQuery Smart Wizard -->
    <script src="../vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.min.js"></script>
</body>

</html>