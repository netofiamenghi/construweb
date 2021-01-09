<?php

include_once '../util/conexao.php';
include_once '../util/funcoes.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = clear($dados['id']);

$sql = "select * from receber where receber_id = '$id'";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
$vl_orig = $dados['receber_vl_orig'];
$historico = $dados['receber_historico'];

$hoje = date('d/m/Y');
$historico .= " - TÍTULO ESTORNADO NO DIA $hoje";
$status = 'A';

$sql = "update receber set receber_dt_pagto = '', receber_vl_final = '$vl_orig', 
        receber_historico = '$historico', receber_status = '$status' where receber_id = '$id'";

if (mysqli_query($conexao, $sql)) :
    $retorna = ['sit' => true, 'msg' => '<div class="alert alert-success" role="alert">Título Estornado!</div>'];
else :
    $retorna = ['sit' => false, 'msg' => '<div class="alert alert-danger" role="alert">Erro: Não foi possível realizar o estorno do título!</div>'];
endif;

header('Content-Type: application/json');
echo json_encode($retorna);
