<?php
include_once '../vendor/autoload.php';
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

$obra = clear($_POST['obra']);
$ordem = clear($_POST['ordem']);

// DADOS DA EMPRESA
$sql = "select * from empresa";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
$emp_fantasia = $dados['emp_fantasia'];
$logo = $dados['emp_imagem'];
$data = date('d/m/Y \à\s H:i:s');

// DADOS DA OBRA
$sql = "select * from obra where obra_id = $obra";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
$obra_nome = $dados['obra_nome'];

// CUSTO TOTAL DA OBRA
$sql = "select (
        (select coalesce(sum(it.it_nfent_valor_total),0) as valor_compra 
        from nf_entrada nf, itens_nf_entrada it, produto p
        where nf.nfent_id = it.it_nfent_nf_entrada_id and 
        it.it_nfent_produto_id = p.pro_id and it.it_nfent_obra_id = '$obra' and nf.nfent_status = 'F')
        -
        (select coalesce(sum(it.it_dev_valor_total),0) as valor_devolucao
        from devolucao dev, itens_devolucao it, produto p
        where dev.dev_id = it.it_dev_dev_id and 
        it.it_dev_produto_id = p.pro_id and it.it_dev_obra_id = '$obra' and dev.dev_status = 'F')
        ) as valor_total";
$resultado = mysqli_query($conexao, $sql);
if ($resultado) :
    $dados = mysqli_fetch_array($resultado);
    $valor_total = number_format($dados['valor_total'], 2, ',', '.');
else :
    $valor_total = 0;
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
                <span style='font-size: 16px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relatório de Produtos por Obra</span>
                <span style='font-size: 10px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data</span>
                <h5 class='h5'>Obra: $obra_nome</h5>
                <p class='p'>Custo total: R$ $valor_total</p>
                <hr>
                <table style='font-size: 12px;' class='table'>
                <thead>
                    <tr>
                        <th class='text-center' scope='col' style='width: 20px'>Tipo</th>
                        <th class='text-center' scope='col' style='width: 50px'>Cód</th>
                        <th scope='col' style='width: 150px'>Item</th>
                        <th class='text-center' scope='col' style='width: 20px'>Quantidade</th>
                        <th class='text-right' scope='col' style='width: 30px'>Vr Unitário</th>
                        <th class='text-right' scope='col' style='width: 30px'>Vr Total</th>";

if ($ordem == 'ENTRADA') :
    $html .= "<th class='text-center' scope='col' style='width: 60px'>Data Entrada</th>";
endif;

$html .= "</tr></thead>";

if ($ordem == 'CODIGO') :
    $sql2 = "select * from (
                select 'C' as tipo, p.pro_id, p.pro_descricao, 
                    (sum(it.it_nfent_valor_total) / sum(it.it_nfent_quantidade)) as valor_unitario, 
                    sum(it.it_nfent_valor_total) as valor_total, sum(it.it_nfent_quantidade) as qtd 
                from nf_entrada nf, itens_nf_entrada it, produto p
                where nf.nfent_id = it.it_nfent_nf_entrada_id and it.it_nfent_produto_id = p.pro_id and 
                    it.it_nfent_obra_id = '$obra' and nf.nfent_status = 'F'
                group by p.pro_id, p.pro_descricao
                union
                select 'D' as tipo, p.pro_id, p.pro_descricao,
                    (sum(it.it_dev_valor_total) / sum(it.it_dev_quantidade)) as valor_unitario, 
                    sum(it.it_dev_valor_total) as valor_total, sum(it.it_dev_quantidade) as qtd 
                from devolucao dev, itens_devolucao it, produto p
                where dev.dev_id = it.it_dev_dev_id and it.it_dev_produto_id = p.pro_id and 
                    it.it_dev_obra_id = '$obra' and dev.dev_status = 'F'
                group by p.pro_id, p.pro_descricao
            ) as resultado order by resultado.pro_id";
else :
    $sql2 = "select * from (
                select 'C' as tipo, p.pro_id, p.pro_descricao, nf.nfent_dt_lancamento as lancamento, 
                    (sum(it.it_nfent_valor_total) / sum(it.it_nfent_quantidade)) as valor_unitario, 
                    sum(it.it_nfent_valor_total) as valor_total, sum(it.it_nfent_quantidade) as qtd 
                from nf_entrada nf, itens_nf_entrada it, produto p
                where nf.nfent_id = it.it_nfent_nf_entrada_id and it.it_nfent_produto_id = p.pro_id and 
                    it.it_nfent_obra_id = '$obra' and nf.nfent_status = 'F'
                group by p.pro_id, p.pro_descricao, nf.nfent_dt_lancamento
                union
                select 'D' as tipo, p.pro_id, p.pro_descricao, dev.dev_dt_lancamento as lancamento, 
                    (sum(it.it_dev_valor_total) / sum(it.it_dev_quantidade)) as valor_unitario, 
                    sum(it.it_dev_valor_total) as valor_total, sum(it.it_dev_quantidade) as qtd 
                from devolucao dev, itens_devolucao it, produto p
                where dev.dev_id = it.it_dev_dev_id and it.it_dev_produto_id = p.pro_id and 
                    it.it_dev_obra_id = '$obra' and dev.dev_status = 'F'
                group by p.pro_id, p.pro_descricao, dev.dev_dt_lancamento
            ) as resultado order by resultado.lancamento";
endif;

$resultado2 = mysqli_query($conexao, $sql2);
if ($resultado2) :
    while ($dados2 = mysqli_fetch_array($resultado2)) :
        $produto = mb_substr($dados2['pro_descricao'], 0, 35);
        $unitario = number_format($dados2['valor_unitario'], 2, ',', '.');
        $total = number_format($dados2['valor_total'], 2, ',', '.');
        $html .= "<tr>
                 <td class='text-center'>{$dados2['tipo']}</td>    
                 <td class='text-center'>{$dados2['pro_id']} </td>
                 <td>$produto</td>";

        if($dados2['tipo'] == 'D'):
            $html .= "<td class='text-center'>- {$dados2['qtd']}</td>
                      <td class='text-right'>- R$ $unitario</td>
                      <td class='text-right'>- R$ $total</td>";
        else:
            $html .= "<td class='text-center'>{$dados2['qtd']}</td>
                      <td class='text-right'>R$ $unitario</td>
                      <td class='text-right'>R$ $total</td>";
        endif;
        if ($ordem == 'ENTRADA') :
            $entrada = date('d/m/Y', strtotime($dados2['lancamento']));
            $html .= "<td class='text-center'>$entrada</td>";
        endif;
        $html .= "</tr>";
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
