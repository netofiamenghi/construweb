<?php

include_once '../util/conexao.php';
include_once '../util/funcoes.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$idNF = clear($dados['idNF']);
$numero = clear($dados['numero']);
$qtd = clear($dados['qtd']);
$fornecedor = clear($dados['fornecedor']);
$obra = clear($dados['obra']);
$total = clear($dados['total']); 
$intervalo = clear($dados['intervalo']);

$vencimento = clear(str_replace('/', '-', $dados['emissao']));
$vencimento = date("Y-m-d H:i:s", strtotime($vencimento));
$hoje = date('d/m/Y');
$historico = "Título incluído no dia $hoje, ref. NF: $numero.";
$status = 'A';

$valor = $total / $qtd;

for ($sequencia = 1; $sequencia <= $qtd; $sequencia++) {

    $vencimento =  date('Y-m-d', strtotime("+$intervalo days", strtotime($vencimento)));

    $sql = "insert into pagar (pagar_numero, pagar_sequencia, pagar_fornecedor_id, pagar_obra_id, 
            pagar_nf_entrada_id, pagar_dt_venc, pagar_vl_orig, pagar_vl_final, pagar_historico, pagar_status)
            values ('$numero','$sequencia','$fornecedor','$obra','$idNF','$vencimento','$valor','$valor',
            '$historico','$status')";

    if (mysqli_query($conexao, $sql)) :
        $retorna = ['sit' => true, 'msg' => "<div class='alert alert-success' role='alert'>Títulos incluídos!</div>"];
    else :
        $retorna = ['sit' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Títulos já inseridos!</div>"];
    endif;
}

header('Content-Type: application/json');
echo json_encode($retorna);
