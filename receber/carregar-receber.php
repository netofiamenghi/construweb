<?php

include_once '../util/conexao.php';
include_once '../util/funcoes.php';

$dados = filter_input_array(INPUT_GET, FILTER_DEFAULT);

$id = clear($dados['id']);

$sql = "select r.*,  
        format(r.receber_vl_orig,2,'de_DE') valor,
        format(r.receber_vl_final,2,'de_DE') final,
        DATE_FORMAT(STR_TO_DATE(receber_dt_venc, '%Y-%m-%d'), '%d/%m/%Y') as vencimento,
        DATE_FORMAT(STR_TO_DATE(receber_dt_pagto, '%Y-%m-%d'), '%d/%m/%Y') as pagamento, 
        c.cli_nome, o.obra_nome 
        from receber r, cliente c, obra o
        where r.receber_obra_id = o.obra_id and r.receber_cliente_id = c.cli_id and r.receber_id = '$id'";

$resultado = mysqli_query($conexao, $sql);

$retorna = mysqli_fetch_array($resultado);

header('Content-Type: application/json');
echo json_encode($retorna);
