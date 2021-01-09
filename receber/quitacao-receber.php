<?php

include_once '../util/conexao.php';
include_once '../util/funcoes.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$id = clear($dados['id']);
$dtPagto = clear($dados['dtPagto']);
$vlInicial = clear($dados['vlInicial']);
$vlFinal = clear($dados['vlFinal']);
$vlFinal = str_replace(',', '.', str_replace('.', '', $vlFinal));
$hoje = date('d/m/Y');
$historico = clear($dados['historico']);
$historico .= " - QUITAÇÃO EFETUADA NO DIA $hoje";
$status = 'P';

$sql = "update receber set receber_dt_pagto = '$dtPagto', receber_vl_final = '$vlFinal', 
        receber_historico = '$historico', receber_status = '$status' where receber_id = '$id'";

if (mysqli_query($conexao, $sql)) :
    $retorna = ['sit' => true, 'msg' => '<div class="alert alert-success" role="alert">Quitação efetuada!</div>'];
else :
    $retorna = ['sit' => false, 'msg' => '<div class="alert alert-danger" role="alert">Erro: Quitação não foi realizada!</div>'];
endif;


// INSERIR DOC NO CAIXA

$sql = "select * from receber where receber_id = '$id'";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);

$numero = $dados['receber_numero'];
$sequencia = $dados['receber_sequencia'];
$doc = $numero . ' - ' . $sequencia;
$valor = $dados['receber_vl_final'];
$historico = $dados['receber_historico'];

$sql = "insert into lancamento (lancamento_conta_id, lancamento_documento, lancamento_valor, 
            lancamento_tipo, lancamento_data, lancamento_observacao, lancamento_receber_id)
            values ('1', '$doc','$valor','C', '$dtPagto', '$historico', '$id')";

$resultado = mysqli_query($conexao, $sql);

// ATUALIZAR SALDO DA CONTA CAIXA
$sql1 = "select * from conta";
$resultado1 = mysqli_query($conexao, $sql1);
$dados1 = mysqli_fetch_array($resultado1);

$saldo = $dados1['conta_saldo'];
$saldo = $saldo + $valor;

$sql = "update conta set conta_saldo = '$saldo'";
$resultado = mysqli_query($conexao, $sql);

header('Content-Type: application/json');
echo json_encode($retorna);
