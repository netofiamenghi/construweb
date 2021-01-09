<?php

include_once '../util/conexao.php';
include_once '../util/funcoes.php';

$dados = filter_input_array(INPUT_GET, FILTER_DEFAULT);

$id = clear($dados['id']);

$sql = "select p.*,  
        format(p.pagar_vl_orig,2,'de_DE') valor,
        format(p.pagar_vl_final,2,'de_DE') final,
        DATE_FORMAT(STR_TO_DATE(pagar_dt_venc, '%Y-%m-%d'), '%d/%m/%Y') as vencimento,
        DATE_FORMAT(STR_TO_DATE(pagar_dt_pagto, '%Y-%m-%d'), '%d/%m/%Y') as pagamento, 
        f.for_razaosocial, o.obra_nome 
        from pagar p, fornecedor f, obra o
        where p.pagar_obra_id = o.obra_id and p.pagar_fornecedor_id = f.for_id and p.pagar_id = '$id'";

$resultado = mysqli_query($conexao, $sql);

$retorna = mysqli_fetch_array($resultado);

header('Content-Type: application/json');
echo json_encode($retorna);
 