<?php

require_once './recaptcha/Config.php';
require_once './recaptcha/Captcha.php';

const VERSAO = "v.1.9.0";
session_start();

if (isset($_POST['logar'])) :

  $ObjCaptcha = new Captcha();
  $Retorno = $ObjCaptcha->getCaptcha($_POST['g-recaptcha-response']);

  if ($Retorno->success == false && $Retorno->score < 0.9) :
    header("Location: index.php");
  endif;

  session_unset();
  session_start();

  $_SESSION['MINHA_SESSAO'] = time();
  $codempresa = $_POST['empresa'];
  $_SESSION['codempresa'] = $codempresa;

  include_once 'util/conexao.php';
  include_once 'util/funcoes.php';

  $email = clear($_POST['email']);
  $senha = clear($_POST['senha']);

  if (($email == "ADM@GHITECNOLOGIA.COM.BR") and ($senha == "SWXAQZ33")) :

    $_SESSION['versao'] = VERSAO;
    $_SESSION['idUsuario'] = 999;
    $_SESSION['nomeUsuario'] = "Administrador";
    header('Location: ./geral/pagina-inicial.php');

  elseif (($codempresa == "000") and ($email == "VENDAS@GHITECNOLOGIA.COM.BR") and ($senha == "VENDAS")) :

    $_SESSION['versao'] = VERSAO;
    $_SESSION['idUsuario'] = 998;
    $_SESSION['nomeUsuario'] = "Vendas";
    header('Location: ./geral/pagina-inicial.php');

  else :

    $sql = "select * from usuario where usu_email = '$email' and usu_status = 'A'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) == 1) :

      $dados = mysqli_fetch_array($resultado);
      if (password_verify($senha, $dados['usu_senha'])) :
        $_SESSION['versao'] = VERSAO;
        $_SESSION['idUsuario'] = $dados['usu_id'];
        $_SESSION['nomeUsuario'] = $dados['usu_nome'];
        header('Location: geral/pagina-inicial.php');
      else :
          $_SESSION['msg'] = "<script>mostraDialogo('Senha incorreta!', 'error', 5000);</script>";
          header('Location: ./index.php?msg=sim');
      endif;
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('Usuário não encontrado!', 'error', 5000);</script>";
        header('Location: ./index.php?msg=sim');
    endif;

  endif;
  mysqli_close($conexao);
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

  <title>ConstruWeb | GHI Tecnologia</title>

  <!-- Bootstrap -->
  <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="css/custom.min.css" rel="stylesheet">

  <link href="css/estilo.css?id=2" rel="stylesheet">

  <!-- Mensagens -->
  <script src="js/mensagens.js"></script>
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</head>

<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />

            <h1><i class="fas fa-home"></i> ConstruWeb</h1>

            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
              <input maxlength="3" type="text" name="empresa" class="form-control has-feedback-left" placeholder="Empresa" required />
              <span class="fa fa-bank form-control-feedback left" aria-hidden="true"></span>
            </div>

            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
              <input maxlength="100" type="email" name="email" class="form-control has-feedback-left" id="email" placeholder="Email" required />
              <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
            </div>

            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback">
              <input maxlength="100" type="password" name="senha" class="form-control has-feedback-left" placeholder="Senha" required />
              <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
            </div>

            <div>
              <input type="submit" class="col-md-9 btn btn-success submit" name="logar" value="Entrar" />
            </div>

            <div class="clearfix"></div>
            <div class="card-footer">
              <div class="d-flex justify-content-center erro_entrar">
                <br>
                <?php
                if (isset($_GET['msg'])) :
                  echo $_SESSION['msg'];
                  $_SESSION['idUsuario'] = false;
                endif;
                ?>
              </div>
            </div>
            <div class="separator">
              <div class="clearfix"></div><br />
              <a href="http://www.ghitecnologia.com.br" target="_blank">
                <img width="100px" src="./img/ghi.png" />
              </a>
          </form>
        </section>
      </div>
    </div>
  </div>

  <!-- FastClick -->
  <script src="vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="vendors/nprogress/nprogress.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="js/custom.min.js"></script>

  <script src="https://www.google.com/recaptcha/api.js?render=<?= FRONT_END_KEY ?>"></script>
  <script src="recaptcha/recaptcha.js"></script>
  <script src="https://kit.fontawesome.com/44f5bae32e.js" crossorigin="anonymous"></script>
</body>

</html>