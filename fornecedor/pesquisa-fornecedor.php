<?php
 
include_once '../util/conexao.php';

$pesquisa = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);

$sql = "select * from fornecedor where for_razaosocial like '%$pesquisa%' or for_fantasia like '%$pesquisa%' limit 10 ";
$resultado = mysqli_query($conexao, $sql);

if (($resultado) and ($resultado->num_rows != 0)) :
    while ($dados = mysqli_fetch_array($resultado)) :

        $nome = $dados['for_razaosocial'];
        if ($dados['for_tipo_pessoa'] == "FISICA") :
            $doc = $dados['for_cpf'];
        else :
            $doc = $dados['for_cnpj'];
        endif;

        echo "<li class='item-fornecedor'>
                $nome | $doc | {$dados['for_id']}
            </li>";
    endwhile;
else :
    echo "Nenhum fornecedor encontrado!";
endif;
