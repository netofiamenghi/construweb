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

$dtInicio = clear($_GET['inicio']);
$dtFim = clear($_GET['fim']);

if($dtInicio == "CURDATE()"):
    $sql2 = "select * from lancamento where lancamento_data = curdate() ";
else:
    $sql2 = "select * from lancamento where lancamento_data between '$dtInicio' and '$dtFim' ";
endif;

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
                <span style='font-size: 16px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Movimentações do Caixa</span>
                <span style='font-size: 10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data</span>
                <hr>
                <table style='font-size: 12px;' class='table'>
                <thead>
                    <tr>
                        <th class='text-center' scope='col'>Nº Documento</th>
                        <th class='text-center' scope='col'>Data</th>
                        <th class='text-center' scope='col'>Tipo</th>
                        <th class='text-center' scope='col'>Valor</th>
                        <th class='text-center' scope='col'>Observação</th>
                    </tr>
                </thead>";

$resultado2 = mysqli_query($conexao, $sql2);
if ($resultado2) :
    $saldo = 0;
    while ($dados2 = mysqli_fetch_array($resultado2)) :
        $numero = $dados2['lancamento_documento'];
        $tipo = $dados2['lancamento_tipo'] == 'C' ? 'CRÉDITO' : 'DÉBITO';
        $data = date('d/m/Y', strtotime($dados2['lancamento_data']));
        $valor = number_format($dados2['lancamento_valor'], 2, ',', '.');
        if($tipo == 'CRÉDITO'):
            $saldo = $saldo + $dados2['lancamento_valor'];
        else:
            $saldo = $saldo - $dados2['lancamento_valor'];
        endif;
        $observacao = mb_substr($dados2['lancamento_observacao'], 0, 30);
        $html .= "<tr>
                 <td class='text-center'> $numero </td>
                 <td class='text-center'> $data </td>
                 <td class='text-center'> $tipo </td>
                 <td class='text-right'>R$ $valor </td>
                 <td class='text-center'> $observacao </td>
            </tr>";

    endwhile;
    $saldo = number_format($saldo, 2, ',', '.');
endif;

$html .= "</table>
            <hr>
            <p class='p text-right'>Saldo do período: R$ $saldo</p>
            <hr>
            <p style='font-size: 10px;' class='text-center'>GHI Tecnologia</p>
            </body>
        </html>";
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
