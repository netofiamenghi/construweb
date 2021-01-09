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
$obra = clear($_POST['obra']);
$fornecedor = clear($_POST['fornecedor']);
$dtInicio = clear($_POST['dtInicio']);
$dtFim = clear($_POST['dtFim']);

$datas = " and p.pagar_dt_venc between '$dtInicio' and '$dtFim' ";

if ($status == 'ABERTOS') :
    $where = "and p.pagar_status = 'A' ";
elseif ($status == 'PAGOS') :
    $where = "and p.pagar_status = 'P' ";
else :
    $where = '';
endif;

if($fornecedor != null):
    $where .= "and p.pagar_fornecedor_id = '$fornecedor'";
endif;

if ($obra != null) :
    $sql = "select sum(p.pagar_vl_final) total, obra_nome
        from pagar p, obra
        where p.pagar_obra_id = obra_id $where and p.pagar_obra_id = $obra $datas
        group by obra_nome";
else :
    $sql = "select sum(p.pagar_vl_final) total
        from pagar p, obra
        where p.pagar_obra_id = obra_id $where $datas";
endif;

// TOTAL TÍTULOS POR OBRA

$resultado = mysqli_query($conexao, $sql);
if ($resultado) :
    $dados = mysqli_fetch_array($resultado);
    if($obra != null):
        $obra_nome = $dados['obra_nome']; 
    else:
        $obra_nome = 'GERAL';    
    endif;
    $total = number_format($dados['total'], 2, ',', '.');
else :
    $total = 0;
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
                <span style='font-size: 16px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relatório de Títulos à Pagar</span>
                <span style='font-size: 10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data</span>
                <h5 class='h5'>Obra: $obra_nome</h5>
                <p class='p'>Valor total: R$ $total</p>
                <hr>
                <table style='font-size: 12px;' class='table'>
                <thead>
                    <tr>
                        <th class='text-center' scope='col'>Número</th>
                        <th class='text-center' scope='col'>Vencimento</th>
                        <th scope='col'>Fornecedor</th>
                        <th class='text-right' scope='col'>Valor</th>
                        <th class='text-center' scope='col'>Status</th>
                    </tr>
                </thead>";

if ($status == 'ABERTOS') :
    $where = "and p.pagar_status = 'A' ";
elseif ($status == 'PAGOS') :
    $where = "and p.pagar_status = 'P' ";
else :
    $where = '';
endif;

if($fornecedor != null):
    $where .= "and p.pagar_fornecedor_id = '$fornecedor'";
endif;

if ($obra != null) :
    $obra = "p.pagar_obra_id = $obra and";
else :
    $obra = "";
endif;

if ($ordem == 'VENCIMENTO') :
    $order = "order by p.pagar_dt_venc";
else :
    $order = "order by p.pagar_vl_final";
endif;

$sql2 = "select p.*, f.for_razaosocial from pagar p, fornecedor f
        where $obra p.pagar_fornecedor_id = f.for_id $where $datas $order";

$resultado2 = mysqli_query($conexao, $sql2);
if ($resultado2) :
    while ($dados2 = mysqli_fetch_array($resultado2)) :
        $status = $dados2['pagar_status'] == 'A' ? 'ABERTO' : 'PAGO';
        $vencimento = date('d/m/Y', strtotime($dados2['pagar_dt_venc']));
        $vl_final = number_format($dados2['pagar_vl_final'], 2, ',', '.');
        $nomefornecedor = mb_substr($dados2['for_razaosocial'], 0, 40);
        $html .= "<tr>
                 <td class='text-center'> {$dados2['pagar_numero']} - {$dados2['pagar_sequencia']} </td>
                 <td class='text-center'> $vencimento </td>
                 <td> $nomefornecedor </td>
                 <td class='text-right'>R$ $vl_final </td>
                 <td class='text-center'> $status </td>
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
