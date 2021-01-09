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
                <span style='font-size: 16px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relatório de Clientes</span>
                <span style='font-size: 10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data</span>
                <hr>
                <table style='font-size: 12px;' class='table'>
                <thead>
                    <tr>
                        <th scope='col' class='text-center' style='width:60px; display:block;'>Código</th>
                        <th scope='col' style='width:120px; display:block;'>CPF/CNPJ</th>
                        <th scope='col' style='width:220px; display:block;'>Nome/Nome Fantasia</th>
                        <th scope='col' style='width:220px; display:block;'>E-mail</th>
                        <th scope='col'>Status</th>
                    </tr>
                </thead>";

if ($status == 'A') :
    $where = "where cli_status = 'A' ";
elseif ($status == 'I') :
    $where = "where cli_status = 'I' ";
else :
    $where = '';
endif;

if ($ordem == 'CODIGO') :
    $order = "order by cli_id";
else :
    $order = "order by cli_nome";
endif;

$sql2 = "select cli_id, cli_cnpj, cli_cpf, cli_status, cli_email, 
        case when cli_nome = '0' then cli_fantasia 
            else cli_nome 
            end as cli_nome 
        from cliente $where $order";

$resultado2 = mysqli_query($conexao, $sql2);
while ($dados2 = mysqli_fetch_array($resultado2)) :
    $cpf_cnpj = $dados2['cli_cnpj'] == '0_.___.___/____-__' ? $dados2['cli_cpf'] : $dados2['cli_cnpj'];
    $status = $dados2['cli_status'] == 'A' ? 'Ativo' : 'Inativo';
    $html .= "<tr>
                 <td class='text-center'> {$dados2['cli_id']} </td>
                 <td> $cpf_cnpj </td>
                 <td> {$dados2['cli_nome']} </td>
                 <td> {$dados2['cli_email']} </td>
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
