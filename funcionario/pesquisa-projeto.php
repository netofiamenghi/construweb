<?php

include_once '../util/conexao.php';

$pesquisa = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);

$sql = "select * from funcionario where fun_nome like '%$pesquisa%' limit 10 ";
$resultado = mysqli_query($conexao, $sql);

if (($resultado) and ($resultado->num_rows != 0)) :
    while ($dados = mysqli_fetch_array($resultado)) :

        $nome = $dados['fun_nome'];
        $doc = $dados['fun_cpf'];

        echo "<li class='item-projeto'>
                $nome | $doc | {$dados['fun_id']}
            </li>";
    endwhile;
else :
    echo "Nenhum funcionário encontrado!";
endif;
