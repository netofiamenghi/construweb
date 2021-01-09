<?php

include_once '../util/conexao.php';

$pesquisa = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);

$sql = "select * from produto where pro_descricao like '%$pesquisa%' limit 10 ";
$resultado = mysqli_query($conexao, $sql);

if (($resultado) and ($resultado->num_rows != 0)) :
    while ($dados = mysqli_fetch_array($resultado)) :

        $sql2 = "select (sum(i.it_nfent_valor_unitario) / count(i.it_nfent_valor_unitario)) media
                from itens_nf_entrada i, nf_entrada nf
                where i.it_nfent_nf_entrada_id = nf.nfent_id and nf.nfent_status = 'F' and 
                i.it_nfent_produto_id = '{$dados['pro_id']}'";

        $resultado2 = mysqli_query($conexao, $sql2);
        $dados2 = mysqli_fetch_array($resultado2);
        $media = number_format($dados2['media'], 2, ',', '.');

        echo "<li class='item-produto'>
                {$dados['pro_descricao']} | $media | {$dados['pro_id']}
            </li>";
    endwhile;
else :
    echo "Nenhum produto encontrado!";
endif;
