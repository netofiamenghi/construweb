<?php

session_start();

if ($_SESSION['idUsuario'] == false) :
    $_SESSION['msg'] = "<script>mostraDialogo('<strong>Acesso negado!</strong><br>Faça o login novamente!', 'error', 6000);</script>";
    header('Location: ./../index.php?msg=sim');
endif;

if (time() - $_SESSION['MINHA_SESSAO'] > 7200) :
    $_SESSION['msg'] = "<script>mostraDialogo('<strong>A sua sessão expirou!</strong><br>Faça o login novamente!', 'error', 6000);</script>";
    header('Location: ./../index.php?msg=sim');
endif;

$producao = false;
$codempresa = $_SESSION['codempresa'];

if ($producao == false) :
    if ($codempresa == "001") :
        $_SESSION['empresa'] = 'Eccons Engenharia';
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $db_name = "eccons";
    endif;
else:
    if ($codempresa == "000") :
        $_SESSION['empresa'] = 'Teste';
        $servername = "localhost";
        $username = "plugas91_teste";
        $password = "Swxaqz33";
        $db_name = "plugas91_construtora";
    endif;
    if ($codempresa == "001") :
        $_SESSION['empresa'] = 'Eccons Engenharia';
        $servername = "localhost";
        $username = "plugas91_eccons";
        $password = "Swxaqz33";
        $db_name = "plugas91_eccons";
    endif;
endif;

$conexao = mysqli_connect($servername, $username, $password, $db_name);

// if (mysqli_connect_error()) :
//     $_SESSION['msg'] = "Falha na conexão com o banco de dados: " . mysqli_connect_error();
// endif;
