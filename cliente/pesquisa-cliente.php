<?php
 
include_once '../util/conexao.php';

$pesquisa = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);

$sql = "select * from cliente where cli_nome like '%$pesquisa%' or cli_fantasia like '%$pesquisa%' limit 10 ";
$resultado = mysqli_query($conexao, $sql);

if (($resultado) and ($resultado->num_rows != 0)) :
    while ($dados = mysqli_fetch_array($resultado)) :

        if ($dados['cli_nome'] != "0") :
            $nome = $dados['cli_nome'];
            $doc = $dados['cli_cpf'];
        else :
            $nome = $dados['cli_fantasia'];
            $doc = $dados['cli_cnpj'];
        endif;

        echo "<li class='item-cliente'>
                $nome | $doc | {$dados['cli_id']}
            </li>";
    endwhile;
else :
    echo "Nenhum cliente encontrado!";
endif;
