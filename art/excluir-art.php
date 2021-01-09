<?php 

include_once '../util/conexao.php';
include_once '../util/funcoes.php';

$art_id = clear($_GET['id']);
$obra_id = clear($_GET['obra']);
$arquivo = clear($_GET['arquivo']);

$sql = "delete from art where art_id = '$art_id' ";
$resultado = mysqli_query($conexao, $sql);

unlink("arquivos/$arquivo");

header("Location: ./../obra/alterar-obra.php?id=$obra_id");

?>