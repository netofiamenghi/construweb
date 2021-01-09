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
$cliente = clear($_POST['cliente']);
$dtInicio = clear($_POST['dtInicio']);
$dtFim = clear($_POST['dtFim']);

$datas = " and r.receber_dt_venc between '$dtInicio' and '$dtFim' ";

if ($status == 'ABERTOS') :
    $where = "and r.receber_status = 'A' ";
elseif ($status == 'PAGOS') :
    $where = "and r.receber_status = 'P' ";
else :
    $where = '';
endif;

if($fornecedor != null):
    $where .= "and r.receber_cliente_id = '$cliente'";
endif;

if ($obra != null) :
    $sql = "select sum(r.receber_vl_final) total, obra_nome
        from receber r, obra
        where r.receber_obra_id = obra_id $where and r.receber_obra_id = $obra $datas
        group by obra_nome";
else :
    $sql = "select sum(r.receber_vl_final) total
        from receber r, obra
        where r.receber_obra_id = obra_id $where $datas";
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
                <span style='font-size: 16px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relatório de Títulos à Receber</span>
                <span style='font-size: 10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data</span>
                <h5 class='h5'>Obra: $obra_nome</h5>
                <p class='p'>Valor total: R$ $total</p>
                <hr>
                <table style='font-size: 12px;' class='table'>
                <thead>
                    <tr>
                        <th class='text-center' scope='col'>Número</th>
                        <th class='text-center' scope='col'>Vencimento</th>
                        <th scope='col'>Cliente</th>
                        <th class='text-right' scope='col'>Valor</th>
                        <th class='text-center' scope='col'>Status</th>
                    </tr>
                </thead>";

if ($status == 'ABERTOS') :
    $where = "and r.receber_status = 'A' ";
elseif ($status == 'PAGOS') :
    $where = "and r.receber_status = 'P' ";
else :
    $where = '';
endif;

if($cliente != null):
    $where .= "and r.receber_cliente_id = '$cliente'";
endif;

if ($obra != null) :
    $obra = "r.receber_obra_id = $obra and";
else :
    $obra = "";
endif;

if ($ordem == 'VENCIMENTO') :
    $order = "order by r.receber_dt_venc";
else :
    $order = "order by r.receber_vl_final";
endif;

$sql2 = "select r.*, c.cli_nome from receber r, cliente c
        where $obra r.receber_cliente_id = c.cli_id $where $datas $order";

$resultado2 = mysqli_query($conexao, $sql2);
if ($resultado2) :
    while ($dados2 = mysqli_fetch_array($resultado2)) :
        $status = $dados2['receber_status'] == 'A' ? 'ABERTO' : 'PAGO';
        $vencimento = date('d/m/Y', strtotime($dados2['receber_dt_venc']));
        $vl_final = number_format($dados2['receber_vl_final'], 2, ',', '.');
        $nomecliente = mb_substr($dados2['cli_nome'], 0, 40);
        $html .= "<tr>
                 <td class='text-center'> {$dados2['receber_numero']} - {$dados2['receber_sequencia']} </td>
                 <td class='text-center'> $vencimento </td>
                 <td> $nomecliente </td>
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
