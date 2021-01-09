<?php
include_once 'conexao.php';

function clear($input){
    global $conexao;
    // limpar espaços
    $var = trim($input);
    // limpar sql
    $var = mysqli_escape_string($conexao, $var);
    // limpar xss (cross site scriting)
    $var = htmlspecialchars($var);
    // caracteres em maiúsculo
    $var = strtoupper($var);
    return $var;
}

