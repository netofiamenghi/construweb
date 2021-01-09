<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';


if (isset($_POST['btnenviar'])) :

    $nome = clear($_POST['nome']);
    $tipo = clear($_POST['tipo']);
    $tipo_contrato = clear($_POST['tipo_contrato']);
    $cliente_id = clear($_POST['cliente']);
    $resp_tecnico = clear($_POST['resp_tecnico']);
    $resp_projeto = clear($_POST['resp_projeto']);
    $art = clear($_POST['art']);
    $dtinicio = clear($_POST['dtinicio']);
    $dtfinal = clear($_POST['dtfinal']);
    $valor = clear($_POST['valor']);
    $valor = str_replace(',', '.', str_replace('.', '', $valor));
    $contrato = clear($_POST['contrato']);
    $cep = clear($_POST['cep']);
    $logradouro = clear($_POST['logradouro']);
    $complemento = clear($_POST['complemento']);
    $numero = clear($_POST['numero']);
    $bairro = clear($_POST['bairro']);
    $cidade = clear($_POST['cidade']);
    $estado = clear($_POST['estado']);

    $sql = "insert into obra (obra_nome,obra_tipo,obra_tipo_contrato,cliente_cli_id,obra_dt_inicio,obra_dt_final, 
            obra_valor,obra_num_contrato,obra_logradouro,obra_complemento,obra_numero,obra_bairro,obra_cep, 
            obra_cidade,obra_estado,obra_resp_tecnico,obra_resp_projeto,obra_art,obra_status) 
            values('$nome','$tipo','$tipo_contrato','$cliente_id','$dtinicio','$dtfinal','$valor','$contrato',
            '$logradouro','$complemento','$numero','$bairro','$cep','$cidade','$estado','$resp_tecnico', 
            '$resp_projeto','$art','A')";

    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Obra incluída com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('Erro ao incluir Obra!', 'error');</script>";
    endif;

    mysqli_close($conexao);
    header("Location: cadastrar-obra.php?msg=sim");

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

    <link href="../css/estilo.css?id=1" rel="stylesheet">

    <!-- Mensagens -->
    <script src="../js/mensagens.js"></script>
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</head>

<body class="nav-md">
    <?php
    include_once '../layout/cabecalho.php';
    ?>

    <!-- page content -->
    <div class="right_col" role="main">
        <h3 class="h3">Cadastro de Obra</h3>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="col-md-6">
                <label for="nome">Nome da Obra *</label>
                <input class="form-control" type="text" name="nome" id="nome" maxlength="100" required /><br>
            </div>
            <div class="col-md-6">
                <label for="tipo">Tipo de Obra *</label>
                <select class="form-control" name="tipo" id="tipo">
                    <option value="INICIAL">CONSTRUÇÃO INICIAL</option>
                    <option value="REFORMA">REFORMA</option>
                </select><br>
            </div>
            <div class="col-md-6">
                <label for="tipo_contrato">Tipo de Contrato *</label>
                <select class="form-control" name="tipo_contrato" id="tipo_contrato">
                    <option value="TOTAL">TOTAL</option>
                    <option value="MAODEOBRA">MÃO DE OBRA</option>
                </select>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <label for="tipo">Selecione o Cliente *</label>
                </div>
                <div class="col-md-2">
                    <input class="form-control" type="text" name="cliente" id="cliente" readonly required />
                </div>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="nomecliente" id="nomecliente" readonly />
                </div>
                <div class="col-md-2">
                    <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqCliente">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <label for="tipo">Selecione o Responsável Técnico *</label>
                </div>
                <div class="col-md-2">
                    <input class="form-control" type="text" name="resp_tecnico" id="resp_tecnico" readonly required />
                </div>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="nometecnico" id="nometecnico" readonly />
                </div>
                <div class="col-md-2">
                    <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqTecnico">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <label for="tipo">Selecione o Responsável pelo Projeto *</label>
                </div>
                <div class="col-md-2">
                    <input class="form-control" type="text" name="resp_projeto" id="resp_projeto" readonly required />
                </div>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="nomeprojeto" id="nomeprojeto" readonly />
                </div>
                <div class="col-md-2">
                    <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqProjeto">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <label for="art">Número ART</label>
                <input class="form-control" type="text" name="art" id="art" /><br>
            </div>
            <div class="col-md-6">
                <label for="dtinicio">Data Inicial *</label>
                <input class="form-control" type="date" name="dtinicio" id="dtinicio" required /><br>
            </div>
            <div class="col-md-6">
                <label for="dtfinal">Data Final *</label>
                <input class="form-control" type="date" name="dtfinal" id="dtfinal" required /><br>
            </div>


            <div class="col-md-6">
                <label for="valor">Valor *</label>
                <input class="form-control" type="text" name="valor" id="valor" onKeyPress="return(moeda(this,'.',',',event))" required /><br>
            </div>
            <div class="col-md-6">
                <label for="contrato">Número do Contrato</label>
                <input class="form-control" type="text" name="contrato" id="contrato" /><br>
            </div>
            <div class="col-md-6">
                <label for="cep">CEP *</label>
                <input class="form-control" type="text" name="cep" id="cep" data-inputmask="'mask' : '99.999-999'" required /><br>
            </div>
            <div class="col-md-6">
                <label for="logradouro">Logradouro *</label>
                <input class="form-control" type="text" name="logradouro" id="logradouro" maxlength="100" required /><br>
            </div>
            <div class="col-md-6">
                <label for="complemento">Complemento</label>
                <input class="form-control" type="text" name="complemento" id="complemento" /><br>
            </div>
            <div class="col-md-6">
                <label for="numero">Número</label>
                <input class="form-control" type="text" name="numero" id="numero" /><br>
            </div>
            <div class="col-md-6">
                <label for="bairro">Bairro *</label>
                <input class="form-control" type="text" name="bairro" id="bairro" maxlength="100" required /><br>
            </div>
            <div class="col-md-6">
                <label for="cidade">Cidade *</label>
                <input class="form-control" type="text" name="cidade" id="cidade" maxlength="100" required /><br>
            </div>
            <div class="col-md-6">
                <label for="estado">Estado *</label>
                <select class="form-control" name="estado" id="estado">
                    <option value="AC">ACRE</option>
                    <option value="AL">AlAGOAS</option>
                    <option value="AP">AMAPÁ</option>
                    <option value="AM">AMAZONAS</option>
                    <option value="BA">BAHIA</option>
                    <option value="CE">CEARÁ</option>
                    <option value="DF">DISTRITO FEDERAL</option>
                    <option value="ES">ESPÍRITO SANTO</option>
                    <option value="GO">GOIÁS</option>
                    <option value="MA">MARANHÃO</option>
                    <option value="MT">MATO GROSSO</option>
                    <option value="MS">MATO GROSSO DO SUL</option>
                    <option value="MG">MINAS GERAIS</option>
                    <option value="PA">PARÁ</option>
                    <option value="PB">PARAÍBA</option>
                    <option value="PR">PARANÁ</option>
                    <option value="PE">PERNAMBUCO</option>
                    <option value="PI">PIAUÍ</option>
                    <option value="RJ">RIO DE JANEIRO</option>
                    <option value="RN">RIO GRANDE DO NORTE</option>
                    <option value="RS">RIO GRANDE DO SUL</option>
                    <option value="RO">RONDÔNIA</option>
                    <option value="RR">RORAIMA</option>
                    <option value="SC">SANTA CATARINA</option>
                    <option value="SP">SÃO PAULO</option>
                    <option value="SE">SERGIPE</option>
                    <option value="TO">TOCANTINS</option>
                </select><br>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
                <a class="btn btn-warning" href="./listar-obra.php"><i class="fa fa-reply"></i> Voltar</a>
            </div>
        </form>
        <br>
        <br><br>
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


    <!-- Modal Cliente -->

    <div class="modal fade" id="pesqCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;
                        </span></button>
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisa de Cliente</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-pesquisa">
                        <input class="form-control" type="text" name="pesquisa-cliente" id="pesquisa-cliente" placeholder="Digite o nome do cliente" />
                    </form><br>
                    <small>Clique no resultado para selecionar</small>
                    <ul class="cliente"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fim modal -->


    <!-- Modal Resp. Tecnico -->

    <div class="modal fade" id="pesqTecnico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;
                        </span></button>
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisa de Responsável Técnico</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-pesquisa">
                        <input class="form-control" type="text" name="pesquisa-tecnico" id="pesquisa-tecnico" placeholder="Digite o nome do responsável técnico" />
                    </form><br>
                    <small>Clique no resultado para selecionar</small>
                    <ul class="tecnico"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fim modal -->

    <!-- Modal Resp. Tecnico -->

    <div class="modal fade" id="pesqProjeto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;
                        </span></button>
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisa de Responsável pelo Projeto</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-pesquisa">
                        <input class="form-control" type="text" name="pesquisa-projeto" id="pesquisa-projeto" placeholder="Digite o nome do responsável pelo projeto" />
                    </form><br>
                    <small>Clique no resultado para selecionar</small>
                    <ul class="projeto"></ul>
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
    
    <!-- < !-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- < !-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- < !-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- < !-- jquery.inputmask -->
    <script src="../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- < !-- Custom Theme Scripts -->
    <script src="../js/custom.min.js"></script>
    <!-- < !-- CEP -->
    <script src="../js/funcoes.js?id=123"></script>
    <!-- < !-- Moeda -->
    <script src="../js/moeda.js"></script>
    <!-- < !-- Pesquisas modal -->
    <script src="../js/pesquisas-modal.js"></script>
</body>

</html>