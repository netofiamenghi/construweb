<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

    $id = $_GET['id'];

    $sql = "select * from lancamento where lancamento_id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $tipo = $dados['lancamento_tipo'];
    $valor = $dados['lancamento_valor'];

    $sql = "delete from lancamento where lancamento_id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Lançamento excluído!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('<strong>Erro ao excluir Lançamento!</strong>', 'error', 5000);</script>";
    endif;

    // ATUALIZAR SALDO DA CONTA CAIXA
    $sql1 = "select * from conta";
    $resultado1 = mysqli_query($conexao, $sql1);
    $dados1 = mysqli_fetch_array($resultado1);
    $saldo = $dados1['conta_saldo'];

    if ($tipo == 'C') :
        $saldo = $saldo - $valor;
    else :
        $saldo = $saldo + $valor;
    endif;

    $sql = "update conta set conta_saldo = '$saldo'";
    $resultado = mysqli_query($conexao, $sql);

    mysqli_close($conexao);
    header("Location: listar-lancamento.php?id=$id&msg=sim");


?>
