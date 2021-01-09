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
                <span style='font-size: 16px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relatório de Balanço Financeiro</span>
                <span style='font-size: 10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data</span>
                <hr>
                <table style='font-size: 12px;' class='table'>
                <thead>
                    <tr>
                        <th class='text-center' scope='col' style='width: 50px'>Cód.</th>
                        <th scope='col' style='width: 270px'>Obra</th>
                        <th class='text-center' scope='col' style='width: 50px'>Status</th>
                        <th class='text-right' scope='col'>Receitas</th>
                        <th class='text-right' scope='col'>Despesas</th>
                        <th class='text-right' scope='col'>Resultado</th>
                    </tr>
                </thead>";

if ($status == 'A') :
    $where = "where obra_status = 'A' ";
elseif ($status == 'I') :
    $where = "where obra_status = 'I' ";
else :
    $where = '';
endif;

if ($ordem == 'codigo') :
    $order = "order by obra_id";
else :
    $order = "order by obra_nome";
endif;

$sql2 = "select * from obra  $where $order";

$resultado2 = mysqli_query($conexao, $sql2);
if ($resultado2) :
    while ($dados2 = mysqli_fetch_array($resultado2)) :

        // DESPESAS
        $sql3 = "select sum(p.pagar_vl_final) as despesas from pagar p 
                where p.pagar_status = 'P' and p.pagar_obra_id = '{$dados2['obra_id']}'";
        $resultado3 = mysqli_query($conexao, $sql3);
        $dados3 = mysqli_fetch_array($resultado3);
        $despesas = number_format($dados3['despesas'], 2, ',', '.');

        // RECEITAS
        $sql4 = "select sum(r.receber_vl_final) as receitas from receber r 
                where r.receber_status = 'P' and r.receber_obra_id = '{$dados2['obra_id']}' ";
        $resultado4 = mysqli_query($conexao, $sql4);
        $dados4 = mysqli_fetch_array($resultado4);
        $receitas = number_format($dados4['receitas'], 2, ',', '.');

        $obra = mb_substr($dados2['obra_nome'], 0, 40);
        $status = $dados2['obra_status'] == 'A' ? 'Ativo' : 'Inativo';

        $saldo = $dados4['receitas'] - $dados3['despesas'];
        $saldo = number_format($saldo, 2, ',', '.');

        if($saldo > 0):
            $saldoFinal = "+$saldo";
        else:
            $saldoFinal = $saldo;
        endif;    

        $html .= "<tr>
                 <td class='text-center'> {$dados2['obra_id']} </td>
                 <td> $obra </td>
                 <td class='text-center'> $status </td>
                 <td class='text-right'>+ $receitas</td>
                 <td class='text-right'>- $despesas </td>
                 <td class='text-right'>$saldoFinal</td>
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
