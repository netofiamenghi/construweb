<?php

include_once '../vendor/autoload.php';
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

if (!isset($_POST)) :
    header("Location: config-recibo.php");
else :
    $recebi = clear($_POST['recebi']);
    $recebedor = clear($_POST['recebedor']);
    $referente = clear($_POST['referente']);
    $local = clear($_POST['local']);
    $data = date('d/m/Y', strtotime(clear($_POST['data'])));

    $valor = clear($_POST['valor']);


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
                <span style='font-size: 20px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RECIBO
                </span>
                <hr>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Recebi(emos) de $recebi a quantia de R$ $valor,
                    correspondente ao $referente, e para clareza firmo(amos) o presente na cidade de $local, no dia $data.</p>
                    <br><br><p>Assinatura:............................................................................</p>
                    <br><p>Nome por extenso: $recebedor</p>";

    $html .= "<hr><p style='font-size: 10px;' class='text-center'>GHI Tecnologia</p>
            </body>
        </html>";
    $mpdf->WriteHTML($html);
    $mpdf->Output();
    exit;
endif;
