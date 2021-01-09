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
                <title> {$_SESSION['empresa']}  | GHI Tecnologia</title>
                <!-- Bootstrap -->
                <link href='../vendors/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet'>
                <!-- Font Awesome -->
                <link href='../vendors/font-awesome/css/font-awesome.min.css' rel='stylesheet'>
                <!-- NProgress -->
                <link href='../vendors/nprogress/nprogress.css' rel='stylesheet'>
            </head>
            <body>
                <img width='70px' src='./../img/empresa/$logo'/>
                <span style='font-size: 16px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relatório de Devolução</span>
                <span style='font-size: 10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data</span>
                <hr>
                <table style='font-size: 12px;' class='table'>
                <thead>
                    <tr>
                        <th class='text-center' scope='col' style='width: 80px'>Documento</th>
                        <th class='text-center' scope='col' style='width: 80px'>Dt Emissão</th>
                        <th class='text-center' scope='col' style='width: 80px'>Dt Entrada</th>
                        <th class='text-center' scope='col' style='width: 50px'>Tipo</th>
                        <th scope='col'>Fornecedor</th>
                        <th scope='col' style='width: 80px'>Valor Total</th>
                        <th scope='col'>Status</th>
                    </tr>
                </thead>";

if ($status == 'D') :
    $where = "and d.dev_status = 'D' ";
elseif ($status == 'F') :
    $where = "and d.dev_status = 'F' ";
elseif ($status == 'C') :
    $where = "and d.dev_status = 'C' ";
else :
    $where = '';
endif;

if ($ordem == 'dt-emissao') :
    $order = "order by d.dev_dt_emissao";
else :
    $order = "order by d.dev_dt_lancamento";
endif;

$sql2 = "select d.*, f.for_razaosocial from devolucao d, fornecedor f where d.dev_fornecedor_id = f.for_id $where $order";

$resultado2 = mysqli_query($conexao, $sql2);
if ($resultado2) :
    while ($dados2 = mysqli_fetch_array($resultado2)) :
        $emissao = date('d/m/Y', strtotime($dados2['dev_dt_emissao']));
        $entrada = date('d/m/Y', strtotime($dados2['dev_dt_lancamento']));
        $tipo = $dados2['dev_tipo'] == 'p' ? 'PD' : 'NF';
        $total = number_format($dados2['dev_total'], 2, ',', '.');
        $status = $dados2['dev_status'] == 'D' ? 'Digitada' : 'Finalizada';
        $html .= "<tr>
                 <td class='text-center'> {$dados2['dev_numero']} </td>
                 <td class='text-center'> $emissao </td>
                 <td class='text-center'> $entrada </td>
                 <td class='text-center'> $tipo </td>
                 <td> {$dados2['for_razaosocial']} </td>
                 <td> R$ $total </td>
                 <td> $status </td>
            </tr>";
    endwhile;
endif;

$html .= "</table>
            <hr>
            <p style='font-size: 10px;' class='text-center'>GHI Tecnologia</p>
            </body>
        </html>";
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
