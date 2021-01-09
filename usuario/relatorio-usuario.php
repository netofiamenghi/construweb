<?php

include_once '../vendor/autoload.php';
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

$sql = "select * from empresa";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
$emp_fantasia = $dados['emp_fantasia'];
$logo = $dados['emp_imagem'];
$data = date('d/m/Y \à\s H:i:s');

$status = clear($_POST['status']);
$ordem = clear($_POST['ordem']);

$mpdf = new \Mpdf\Mpdf();

$html = "<html>
            <head>
                <link rel='icon' href='../img/favicon.ico' type='image/ico' />
                <title> {$_SESSION['empresa']} | GHI Tecnologia</title>
                <!-- Bootstrap -->
                <link href='../vendors/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet'>
                <!-- Font Awesome -->
                <link href='../vendors/font-awesome/css/font-awesome.min.css' rel='stylesheet'>
                <!-- NProgress -->
                <link href='../vendors/nprogress/nprogress.css' rel='stylesheet'>
            </head>
            <body>
                <img width='70px' src='./../img/empresa/$logo'/>
                <span style='font-size: 16px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relatório de Usuários</span>
                <span style='font-size: 10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data</span>
                <hr>
                <table style='font-size: 12px;' class='table'>
                <thead>
                    <tr>
                        <th class='text-center' scope='col'>Código</th>
                        <th scope='col'>Nome</th>
                        <th scope='col'>E-mail</th>
                        <th scope='col'>Status</th>
                    </tr>
                </thead>";

if ($status == 'A') :
    $where = "where usu_status = 'A' ";
elseif ($status == 'I') :
    $where = "where usu_status = 'I' ";
else :
    $where = '';
endif;

if ($ordem == 'codigo') :
    $order = "order by usu_id";
else :
    $order = "order by usu_nome";
endif;

$sql2 = "select * from usuario $where $order";

$resultado2 = mysqli_query($conexao, $sql2);
while ($dados2 = mysqli_fetch_array($resultado2)) :
    $status = $dados2['usu_status'] == 'A' ? 'Ativo' : 'Inativo';
    $html .= "<tr>
                 <td class='text-center'> {$dados2['usu_id']} </td>
                 <td> {$dados2['usu_nome']} </td>
                 <td> {$dados2['usu_email']} </td>
                 <td> $status </td>
            </tr>";
endwhile;

$html .= "</table>
            <hr>
            <p style='font-size: 10px;' class='text-center'>GHI Tecnologia</p>
            </body>
        </html>";
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;