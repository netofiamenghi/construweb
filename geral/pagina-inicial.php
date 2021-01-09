<?php include_once '../util/conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/favicon.ico" type="image/ico" />

    <title><?= $_SESSION['empresa'] ?> | GHI Tecnologia</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../css/custom.min.css" rel="stylesheet">

    <link href="../css/estilo.css" rel="stylesheet">


</head>

<body class="nav-md">
    <?php
    include_once '../layout/cabecalho.php';
    ?>

    <!-- page content -->
    <div class="right_col" role="main">

        <!-- top tiles -->
        <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-building-o"></i> Obras Ativas</span>
                <div class="count green">
                    <?php
                    $sql = "select count(obra_id) as qtd from obra where obra_status = 'A'";
                    $resultado = mysqli_query($conexao, $sql);
                    $dados = mysqli_fetch_array($resultado);
                    echo $dados['qtd'];
                    ?>
                </div>
                <span class="count_bottom"><?= "em " . date('d/m/Y') ?></span>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-dollar"></i> Títulos à Pagar</span>
                <div class="count red">
                    <?php
                    $sql = "SELECT COALESCE(sum(pagar_vl_orig),0) as total from pagar where pagar_dt_venc <= now() and pagar_status = 'A'";
                    $resultado = mysqli_query($conexao, $sql);
                    $dados = mysqli_fetch_array($resultado);
                    echo "R$" . number_format($dados['total'], 2, ',', '.');
                    ?>
                </div>
                <span class="count_bottom">até <?= date('d/m/Y') ?></span>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-dollar"></i> Títulos à Receber</span>
                <div class="count blue">
                    <?php
                    $sql = "SELECT COALESCE(sum(receber_vl_orig),0) as total from receber where receber_dt_venc <= now() and receber_status = 'A'";
                    $resultado = mysqli_query($conexao, $sql);
                    $dados = mysqli_fetch_array($resultado);
                    echo "R$" . number_format($dados['total'], 2, ',', '.');
                    ?>
                </div>
                <span class="count_bottom">até <?= date('d/m/Y') ?></span>
            </div>

        </div>
        <!-- /top tiles -->

        <!-- Gráfico Fornecedores -->

        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Top 5 - Fornecedores</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?php

                    $sql = "select f.for_razaosocial fornecedor, sum(nf.nfent_total) valor 
                            from nf_entrada nf, fornecedor f
                            where nf.nfent_fornecedor_id = f.for_id and nf.nfent_status = 'F' and f.for_status = 'A'
                            group by fornecedor
                            order by valor desc limit 5";

                    $resultado = mysqli_query($conexao, $sql);

                    $i = 0;
                    $fornecedores = array();
                    $valores = array();

                    while ($dados = mysqli_fetch_array($resultado)) :

                        $fornecedores[$i] = mb_substr($dados['fornecedor'], 0, 30);
                        $valores[$i] = $dados['valor'];
                        $i++;

                    endwhile;

                    ?>

                    <input type="hidden" id="fornecedor1" value="<?= $fornecedores[0] ?>" />
                    <input type="hidden" id="fornecedor2" value="<?= $fornecedores[1] ?>" />
                    <input type="hidden" id="fornecedor3" value="<?= $fornecedores[2] ?>" />
                    <input type="hidden" id="fornecedor4" value="<?= $fornecedores[3] ?>" />
                    <input type="hidden" id="fornecedor5" value="<?= $fornecedores[4] ?>" />


                    <input type="hidden" id="valor1" value="<?= $valores[0] ?>" />
                    <input type="hidden" id="valor2" value="<?= $valores[1] ?>" />
                    <input type="hidden" id="valor3" value="<?= $valores[2] ?>" />
                    <input type="hidden" id="valor4" value="<?= $valores[3] ?>" />
                    <input type="hidden" id="valor5" value="<?= $valores[4] ?>" />

                    <div id="maioresFornecedores" style="height:350px;"></div>

                </div>
            </div>
        </div>

        <!-- Fim Gráfico Fornecedores -->


        <!-- Gráfico Obras -->

        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Top 5 - Obras</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?php

                    $sql = "select o.obra_nome nome, sum(o.obra_valor) valor
                            from obra o
                            where o.obra_status = 'A'
                            group by nome
                            order by valor desc limit 5";

                    $resultado = mysqli_query($conexao, $sql);

                    $i = 0;
                    $obras = array();
                    $valores  = array();

                    while ($dados = mysqli_fetch_array($resultado)) :

                        $obras[$i] = mb_substr($dados['nome'], 0, 30);
                        $valores[$i]  = $dados['valor'];
                        $i++;

                    endwhile;

                    ?>

                    <input type="hidden" id="obra1" value="<?= $obras[0] ?>" />
                    <input type="hidden" id="obra2" value="<?= $obras[1] ?>" />
                    <input type="hidden" id="obra3" value="<?= $obras[2] ?>" />
                    <input type="hidden" id="obra4" value="<?= $obras[3] ?>" />
                    <input type="hidden" id="obra5" value="<?= $obras[4] ?>" />


                    <input type="hidden" id="valorO1" value="<?= $valores[0] ?>" />
                    <input type="hidden" id="valorO2" value="<?= $valores[1] ?>" />
                    <input type="hidden" id="valorO3" value="<?= $valores[2] ?>" />
                    <input type="hidden" id="valorO4" value="<?= $valores[3] ?>" />
                    <input type="hidden" id="valorO5" value="<?= $valores[4] ?>" />

                    <div id="maioresObras" style="height:350px;"></div>

                </div>
            </div>
        </div>

        <!-- Fim Gráfico Obras -->


        <!-- Lista Aniversariantes -->

        <div class="col-md-4">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Aniversariantes do Mês <small>Clientes</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul class="list-unstyled msg_list">

                        <?php
                        $sql = "select c.cli_nome, date_format(c.cli_dt_nasc, '%d/%m') data, c.cli_celular 
                                    from cliente c
                                    where extract(month from c.cli_dt_nasc) =  extract(month from curdate()) and 
                                    c.cli_status = 'A' order by extract(day from c.cli_dt_nasc)";
                        $resultado = mysqli_query($conexao, $sql);
                        while ($dados = mysqli_fetch_array($resultado)) :

                            $cliente = mb_substr($dados['cli_nome'], 0, 30);
                        ?>


                            <li>
                                <a>
                                    <span>
                                        <span><?= $cliente ?></span>
                                        <span class="time"><?= $dados['data'] ?></span>
                                    </span>
                                    <!-- <span class="message"> -->
                                   
                                    <!-- </span> -->
                                </a>
                            </li>

                        <?php

                        endwhile;

                        ?>


                    </ul>
                </div>
            </div>
        </div>

        <!-- Fim Lista Aniversariantes -->

    </div>
    </div>
    <br />
    </div>
    <!-- /page content -->

    <?php
    include_once '../layout/rodape.php';
    ?>
    </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.js"></script>
    <!-- ECharts -->
    <script src="../vendors/echarts/dist/echarts.min.js"></script>
</body>

</html>