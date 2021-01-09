<?php

include_once '../util/conexao.php';

$pesquisa = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);

if ($pesquisa != '') :
    $sql = "select * from obra where obra_status = 'A' and obra_nome like '%$pesquisa%' limit 10 ";
else :
    $sql = "select * from obra where obra_status = 'A' order by obra_nome limit 10 ";
endif;

$resultado = mysqli_query($conexao, $sql);

if (($resultado) and ($resultado->num_rows != 0)) :
    while ($dados = mysqli_fetch_array($resultado)) :

        echo "<li class='item-obra'>
                {$dados['obra_nome']} | {$dados['obra_id']}
            </li>";
    endwhile;
else :
    echo "Nenhuma obra encontrada!";
endif;
