<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

if (isset($_POST['btnenviar'])) :

    $numero = clear($_POST['numero']);
    $sequencia = clear($_POST['sequencia']);
    $fornecedor = clear($_POST['fornecedor']);
    $obra = clear($_POST['obra']);
    $dtVenc = clear($_POST['dtVenc']);
    $valor = clear($_POST['valor']);
    $valor = str_replace(',', '.', str_replace('.', '', $valor));
    $historico = clear($_POST['historico']);
    $hoje = date('d/m/Y');
    $historico .= ", Título incluído manualmente no dia $hoje";
    $status = 'A';

    $sql = "insert into pagar (pagar_numero, pagar_sequencia, pagar_fornecedor_id, pagar_obra_id, pagar_dt_venc, 
            pagar_vl_orig, pagar_vl_final, pagar_historico, pagar_status) 
            values('$numero', '$sequencia', '$fornecedor', '$obra', '$dtVenc','$valor', '$valor', '$historico', '$status')";
    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Título incluído com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('<strong>Título não incluído!</strong><br>O conjunto Número - Sequência e Fornecedor já existem!', 'warning', 5000);</script>";
    endif;

    header("Location: cadastrar-pagar.php?msg=sim");
endif;
?>
<!doctype html>
<html class="corpo_login" lang="pt-br">

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
    <!-- Custom Theme Style -->
    <link href="../css/custom.min.css" rel="stylesheet">

    <link href="../css/estilo.css" rel="stylesheet">

    <!-- Mensagens -->
    <script src="../js/mensagens.js"></script>
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#numero").blur(function() {
                novoNumero = Number(this.value).toString();
                this.value = novoNumero;
            });
        });
    </script>
</head>

<body class="nav-md">
    <?php
    include_once '../layout/cabecalho.php';
    ?>

    <!-- page content -->
    <div class="right_col" role="main">
        <h3 class="h3">Inclusão de Títulos à Pagar</h3>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="col-md-4">
                <label for="numero">Número *</label>
                <input class="form-control" type="text" name="numero" id="numero" required /><br>
            </div>
            <div class="col-md-2">
                <label for="numero">Sequência *</label>
                <input class="form-control" type="number" min="1" max="120" name="sequencia" id="sequencia" required /><br>
            </div>
            <div class="col-md-6">
                <label for="dtVenc">Data Vencimento *</label>
                <input class="form-control" type="date" name="dtVenc" id="dtVenc" required /><br>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <label for="tipo">Selecione o Fornecedor *</label>
                </div>
                <div class="col-md-2">
                    <input class="form-control" type="text" name="fornecedor" id="fornecedor" readonly required />
                </div>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="nomefornecedor" id="nomefornecedor" readonly />
                </div>
                <div class="col-md-2">
                    <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqFornecedor">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <label for="produto">Selecione a Obra *</label>
                </div>
                <div class="col-md-2">
                    <input class="form-control" type="text" name="obra" id="obra" readonly required />
                </div>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="nomeobra" id="nomeobra" readonly />
                </div>
                <div class="col-md-2">
                    <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqObra">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <label for="valor">Valor *</label>
                <input class="form-control" type="text" name="valor" id="valor" onKeyPress="return(moeda(this,'.',',',event))" required /><br>
            </div>
            <div class="col-md-12">
                <label for="historico">Histórico</label>
                <textarea class="form-control" name="historico" id="historico" rows="5" cols="100"></textarea><br>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
                <a class="btn btn-warning" href="./listar-pagar.php"><i class="fa fa-reply"></i> Voltar</a>
            </div>
        </form>
        <br><br><br>
        <?php
            if(isset($_GET['msg'])):
                echo $_SESSION['msg'];
            endif;
        ?>
    </div>
    </div>
    <br />
    </div>
    <!-- /page content -->


    <!-- Modal Fornecedor -->

    <div class="modal fade" id="pesqFornecedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;
                        </span></button>
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisa de Fornecedor</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-pesquisa">
                        <input class="form-control" type="text" name="pesquisa-fornecedor" id="pesquisa-fornecedor" placeholder="Digite a razão social do fornecedor" />
                    </form><br>
                    <small>Clique no resultado para selecionar</small>
                    <ul class="fornecedor"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fim modal -->


    <!-- Modal Obra -->

    <div class="modal fade" id="pesqObra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;
                        </span></button>
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisa de Obra</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-pesquisa">
                        <input class="form-control" type="text" name="pesquisa-obra" id="pesquisa-obra" placeholder="Digite o nome da obra" />
                    </form><br>
                    <small>Clique no resultado para selecionar</small>
                    <ul class="obra"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fim modal -->


    <?php
    include_once '../layout/rodape.php';
    ?>

    </div>

    </div>

    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- jquery.inputmask -->
    <script src="../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.min.js"></script>
    <!-- CEP -->
    <script src="../js/funcoes.js"></script>
    <!-- < !-- Pesquisas modal -->
    <script src="../js/pesquisas-modal.js"></script>
    <!-- Moeda -->
    <script src="../js/moeda.js"></script>
</body>

</html>