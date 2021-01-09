<?php
include_once '../util/conexao.php';
include_once '../util/funcoes.php';

if (isset($_GET['id'])) :
    $id = $_GET['id'];
    $sql = "select o.*, c.cli_nome, c.cli_fantasia, p.fun_nome proj_nome, t.fun_nome tec_nome
            from obra o, cliente c, funcionario p, funcionario t
            where o.cliente_cli_id = c.cli_id and o.obra_resp_projeto = p.fun_id and o.obra_resp_tecnico = t.fun_id and o.obra_id = $id";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    $nome = $dados['obra_nome'];
    $tipo = $dados['obra_tipo'];
    $tipo_contrato = $dados['obra_tipo_contrato'];
    $cliente_id = $dados['cliente_cli_id'];
    $cliente_nome = $dados['cli_nome'];
    $resp_tecnico = $dados['obra_resp_tecnico'];
    $resp_tecnico_nome = $dados['tec_nome'];
    $resp_projeto = $dados['obra_resp_projeto'];
    $resp_projeto_nome = $dados['proj_nome'];
    $art = $dados['obra_art'];
    $dtinicio = $dados['obra_dt_inicio'];
    $dtfinal = $dados['obra_dt_final'];
    $valor = $dados['obra_valor'];
    $valor = str_replace('.', ',', str_replace('', '.', $valor));
    $contrato = $dados['obra_num_contrato'];
    $cep = $dados['obra_cep'];
    $logradouro = $dados['obra_logradouro'];
    $complemento = $dados['obra_complemento'];
    $numero = $dados['obra_numero'];
    $bairro = $dados['obra_bairro'];
    $cidade = $dados['obra_cidade'];
    $estado = $dados['obra_estado'];
    $status = $dados['obra_status'];

elseif (isset($_POST['btnenviar'])) :

    $id = clear($_POST['id']);
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
    $status = clear($_POST['status']);

    $sql = "update obra set obra_nome = '$nome', obra_tipo = '$tipo', obra_tipo_contrato = '$tipo_contrato', 
            cliente_cli_id = '$cliente_id', obra_dt_inicio = '$dtinicio', obra_dt_final = '$dtfinal', 
            obra_valor = '$valor', obra_num_contrato = '$contrato', obra_cep = '$cep', 
            obra_logradouro = '$logradouro', obra_complemento = '$complemento', obra_numero = '$numero', 
            obra_bairro = '$bairro',  obra_cidade = '$cidade', obra_estado = '$estado', obra_status = '$status', 
            obra_resp_tecnico = '$resp_tecnico', obra_resp_projeto = '$resp_tecnico', obra_art = '$art' 
            where obra_id = '$id'";
    if (mysqli_query($conexao, $sql)) :
        $_SESSION['msg'] = "<script>mostraDialogo('Obra alterada com sucesso!', 'success');</script>";
    else :
        $_SESSION['msg'] = "<script>mostraDialogo('Erro ao alterar Obra!', 'error');</script>";
    endif;
    mysqli_close($conexao);
    header("Location: alterar-obra.php?id=$id&msg=sim");
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

    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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

        <br><br><br>

        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Cadastro</a></li>
                <li role="presentation" class=""><a href="#tab_content6" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">ART</a></li>
                <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Devolução</a></li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">NF de Entrada</a></li>
                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Título à Pagar</a></li>
                <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Título à Receber</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                    <h3 class="h3">Alterar Obra</h3>
                    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>" /><br>
                        <div class="col-md-6">
                            <label for="nome">Nome da Obra *</label>
                            <input class="form-control" type="text" name="nome" id="nome" maxlength="100" required value="<?= $nome ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo">Tipo de Obra *</label>
                            <select class="form-control" name="tipo">
                                <option value="INICIAL" <?= $tipo == 'INICIAL' ? 'selected' : '' ?>>CONSTRUÇÃO INICIAL</option>
                                <option value="REFORMA" <?= $tipo == 'REFORMA' ? 'selected' : '' ?>>REFORMA</option>
                            </select><br>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_contrato">Tipo de Contrato *</label>
                            <select class="form-control" name="tipo_contrato" id="tipo_contrato">
                                <option <?= $tipo_contrato == 'TOTAL' ? 'selected' : '' ?> value="TOTAL">TOTAL</option>
                                <option <?= $tipo_contrato == 'MAODEOBRA' ? 'selected' : '' ?> value="MAODEOBRA">MÃO DE OBRA</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <label for="tipo">Selecione o Cliente *</label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control" type="text" name="cliente" id="cliente" value="<?= $cliente_id ?>" readonly required />
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="nomecliente" id="nomecliente" value="<?= $cliente_nome ?>" readonly />
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
                                <input class="form-control" type="text" name="resp_tecnico" id="resp_tecnico" value="<?= $resp_tecnico ?>" readonly required />
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="nometecnico" id="nometecnico" value="<?= $resp_tecnico_nome ?>" readonly />
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
                                <input class="form-control" type="text" name="resp_projeto" id="resp_projeto" value="<?= $resp_projeto ?>" readonly required />
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="nomeprojeto" id="nomeprojeto" value="<?= $resp_projeto_nome ?>" readonly />
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="form-control btn btn-primary" data-toggle="modal" data-target="#pesqProjeto">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="art">Número ART</label>
                            <input class="form-control" type="text" name="art" id="art" value="<?= $art ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="dtinicio">Data Inicial *</label>
                            <input class="form-control" type="date" name="dtinicio" id="dtinicio" value="<?= $dtinicio ?>" required /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="dtfinal">Data Final *</label>
                            <input class="form-control" type="date" name="dtfinal" id="dtfinal" value="<?= $dtfinal ?>" required /><br>
                        </div>

                        <div class="col-md-6">
                            <label for="valor">Valor</label>
                            <input class="form-control" type="text" name="valor" id="valor" value="<?= $valor ?>" onKeyPress="return(moeda(this,'.',',',event))" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="contrato">Número do Contrato</label>
                            <input class="form-control" type="text" name="contrato" id="contrato" value="<?= $contrato ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="cep">CEP *</label>
                            <input class="form-control" type="text" name="cep" id="cep" required value="<?= $cep ?>" data-inputmask="'mask' : '99.999-999'" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="logradouro">Logradouro *</label>
                            <input class="form-control" type="text" name="logradouro" id="logradouro" value="<?= $logradouro ?>" required /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="numero">Número</label>
                            <input class="form-control" type="text" name="numero" id="numero" value="<?= $numero ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="complemento">Complemento</label>
                            <input class="form-control" type="text" name="complemento" id="complemento" value="<?= $complemento ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="bairro">Bairro *</label>
                            <input class="form-control" type="text" name="bairro" id="bairro" value="<?= $bairro ?>" required /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="cidade">Cidade *</label>
                            <input class="form-control" type="text" name="cidade" id="cidade" value="<?= $cidade ?>" required /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="estado">Estado *</label>
                            <select class="form-control" name="estado" id="estado">
                                <option <?= $estado == 'AL' ? 'selected' : '' ?> value="AL">ALAGOAS</option>
                                <option <?= $estado == 'AP' ? 'selected' : '' ?> value="AP">AMAPÁ</option>
                                <option <?= $estado == 'AM' ? 'selected' : '' ?> value="AM">AMAZONAS</option>
                                <option <?= $estado == 'BA' ? 'selected' : '' ?> value="BA">BAHIA</option>
                                <option <?= $estado == 'CE' ? 'selected' : '' ?> value="CE">CEARÁ</option>
                                <option <?= $estado == 'DF' ? 'selected' : '' ?> value="DF">DISTRITO FEDERAL</option>
                                <option <?= $estado == 'ES' ? 'selected' : '' ?> value="ES">ESPÍRITO SANTO</option>
                                <option <?= $estado == 'GO' ? 'selected' : '' ?> value="GO">GOIÁS</option>
                                <option <?= $estado == 'MA' ? 'selected' : '' ?> value="MA">MARANHÃO</option>
                                <option <?= $estado == 'MT' ? 'selected' : '' ?> value="MT">MATO GROSSO</option>
                                <option <?= $estado == 'MS' ? 'selected' : '' ?> value="MS">MATO GROSSO DO SUL</option>
                                <option <?= $estado == 'MG' ? 'selected' : '' ?> value="MG">MINAS GERAIS</option>
                                <option <?= $estado == 'PA' ? 'selected' : '' ?> value="PA">PARÁ</option>
                                <option <?= $estado == 'PB' ? 'selected' : '' ?> value="PB">PARAÍBA</option>
                                <option <?= $estado == 'PR' ? 'selected' : '' ?> value="PR">PARANÁ</option>
                                <option <?= $estado == 'PE' ? 'selected' : '' ?> value="PE">PERNAMBUCO</option>
                                <option <?= $estado == 'PI' ? 'selected' : '' ?> value="PI">PIAUÍ</option>
                                <option <?= $estado == 'RJ' ? 'selected' : '' ?> value="RJ">RIO DE JANEIRO</option>
                                <option <?= $estado == 'RN' ? 'selected' : '' ?> value="RN">RIO GRANDE DO NORTE</option>
                                <option <?= $estado == 'RS' ? 'selected' : '' ?> value="RS">RIO GRANDE DO SUL</option>
                                <option <?= $estado == 'RO' ? 'selected' : '' ?> value="RO">RONDÔNIA</option>
                                <option <?= $estado == 'RR' ? 'selected' : '' ?> value="RR">RORAIMA</option>
                                <option <?= $estado == 'SC' ? 'selected' : '' ?> value="SC">SANTA CATARINA</option>
                                <option <?= $estado == 'SP' ? 'selected' : '' ?> value="SP">SÃO PAULO</option>
                                <option <?= $estado == 'SE' ? 'selected' : '' ?> value="SE">SERGIPE</option>
                                <option <?= $estado == 'TO' ? 'selected' : '' ?> value="TO">TOCANTINS</option>
                            </select><br>
                        </div>
                        <div class="col-md-6">
                            <label for="status">Status</label>
                            <select class="form-control" name="status">
                                <option value="A" <?= $status == 'A' ? 'selected' : '' ?>>ATIVO</option>
                                <option value="I" <?= $status == 'I' ? 'selected' : '' ?>>INATIVO</option>
                                <option value="E" <?= $status == 'E' ? 'selected' : '' ?>>EXCLUÍDO</option>
                            </select>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
                            <a class="btn btn-warning" href="./listar-obra.php"><i class="fa fa-reply"></i> Voltar</a>
                        </div>
                    </form>
                    <br>
                    <br><br>
                    <?php
                    if (isset($_GET['msg'])) :
                        echo $_SESSION['msg'];
                    endif;
                    ?>

                </div>

                <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">


                    <h3 class="h3">Lista de Devoluções</h3>
                    <br>

                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">NF/Pedido</th>
                                <th class="text-center">Fornecedor</th>
                                <th class="text-center">Dt Emissão</th>
                                <th class="text-center">Valor Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select * from devolucao dev, fornecedor f 
                            where dev.dev_fornecedor_id = f.for_id and dev.dev_obra_id = '$id'";
                            $resultado = mysqli_query($conexao, $sql);
                            if ($resultado) :
                                while ($dados = mysqli_fetch_array($resultado)) :
                                    $dev_id = $dados['dev_id'];
                                    $dev_numero = $dados['dev_numero'];
                                    $for_razaosocial = mb_substr($dados['for_razaosocial'], 0, 35);
                                    $dev_dt_emissao = $dados['dev_dt_emissao'];
                                    $dev_total = $dados['dev_total'];

                                    switch ($dados['dev_status']):
                                        case 'D':
                                            $dev_status = 'Digitada';
                                            break;
                                        case 'C':
                                            $dev_status = 'Cancelada';
                                            break;
                                        case 'F':
                                            $dev_status = 'Finalizada';
                                            break;
                                    endswitch;
                            ?>
                                    <tr>
                                        <td class="text-center"><?= $dev_numero ?></td>
                                        <td><?= $for_razaosocial ?></td>
                                        <td class="text-center"><?= date('d/m/Y', strtotime($dev_dt_emissao)) ?></td>
                                        <td class="text-center"><?= 'R$ ' . number_format($dev_total, 2, ',', '.') ?></td>
                                        <td class="text-center"><?= $dev_status ?></td>
                                        <td class="text-center"><a href='../devolucao/cadastrar-devolucao.php?nf=<?= $dev_id ?>&obra=<?= $id ?>'><span class="glyphicon glyphicon-search"></span></a></td>
                                    </tr>
                            <?php
                                endwhile;
                            endif;
                            ?>
                        </tbody>
                    </table>
                    <a class="btn btn-warning" href="./listar-obra.php"><i class="fa fa-reply"></i> Voltar</a>

                </div>


                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">


                    <h3 class="h3">Lista de NFs de Entrada</h3>
                    <br>

                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">NF/Pedido</th>
                                <th class="text-center">Fornecedor</th>
                                <th class="text-center">Dt Emissão</th>
                                <th class="text-center">Valor Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select * from nf_entrada nf, fornecedor f 
                                    where nf.nfent_fornecedor_id = f.for_id and nf.nfent_obra_id = '$id'";
                            $resultado = mysqli_query($conexao, $sql);
                            if ($resultado) :
                                while ($dados = mysqli_fetch_array($resultado)) :
                                    $nfent_id = $dados['nfent_id'];
                                    $nfent_numero = $dados['nfent_numero'];
                                    $for_razaosocial = mb_substr($dados['for_razaosocial'], 0, 35);
                                    $nfent_dt_emissao = $dados['nfent_dt_emissao'];
                                    $nfent_total = $dados['nfent_total'];
                                    if ($dados['nfent_status'] == 'D') :
                                        $nfent_status = 'Digitada';
                                    elseif ($dados['nfent_status'] == 'C') :
                                        $nfent_status = 'Cancelada';
                                    else :
                                        $nfent_status = 'Finalizada';
                                    endif;
                            ?>
                                    <tr>
                                        <td class="text-center"><?= $nfent_numero ?></td>
                                        <td><?= $for_razaosocial ?></td>
                                        <td class="text-center"><?= date('d/m/Y', strtotime($nfent_dt_emissao)) ?></td>
                                        <td class="text-center"><?= 'R$ ' . number_format($nfent_total, 2, ',', '.') ?></td>
                                        <td class="text-center"><?= $nfent_status ?></td>
                                        <td class="text-center"><a href='../nf-entrada/cadastrar-nf-entrada.php?nf=<?= $nfent_id ?>&obra=<?= $id ?>'><span class="glyphicon glyphicon-search"></span></a></td>
                                    </tr>
                            <?php
                                endwhile;
                            endif;
                            ?>
                        </tbody>
                    </table>
                    <a class="btn btn-warning" href="./listar-obra.php"><i class="fa fa-reply"></i> Voltar</a>

                </div>

                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">

                    <h3 class="h3">Lista de Títulos à Pagar</h3>
                    <br>
                    <table id="datatable-responsive1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Número</th>
                                <th class="text-center">Fornecedor</th>
                                <th class="text-center">Vencimento</th>
                                <th class="text-center">Valor</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select p.*, f.for_razaosocial
                                    from pagar p, fornecedor f
                                    where p.pagar_obra_id = '$id' and p.pagar_fornecedor_id = f.for_id order by p.pagar_dt_venc";

                            $resultado = mysqli_query($conexao, $sql);

                            while ($dados = mysqli_fetch_array($resultado)) :
                                $pagar_id = $dados['pagar_id'];
                                $numero = $dados['pagar_numero'];
                                $sequencia = $dados['pagar_sequencia'];
                                $fornecedor = mb_substr($dados['for_razaosocial'], 0, 30);
                                $dtVenc = $dados['pagar_dt_venc'];
                                $dtPagto = $dados['pagar_dt_pagto'];
                                $valor = $dados['pagar_vl_orig'];
                                $historico = $dados['pagar_historico'];
                                $status = $dados['pagar_status'];
                            ?>
                                <tr>
                                    <td class="text-center"><?= $numero . ' - ' . $sequencia ?> </span></td>
                                    <td><?= $fornecedor ?></td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($dtVenc)) ?></td>
                                    <td class="text-center">R$ <?= number_format($valor, 2, ',', '.') ?></td>
                                    <td class="text-center"><?= $status == 'A' ? 'Aberto' : 'Pago' ?></td>
                                    <td class="text-center"><a href='../pagar/alterar-pagar.php?id=<?= $pagar_id ?>&obra=<?= $id ?>'><span class="glyphicon glyphicon-search"></span></a></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                        </tbody>
                    </table>
                    <a class="btn btn-warning" href="./listar-obra.php"><i class="fa fa-reply"></i> Voltar</a>

                </div>


                <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">

                    <h3 class="h3">Lista de Títulos à Receber</h3>
                    <br>
                    <table id="datatable-responsive2" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Número</th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Vencimento</th>
                                <th class="text-center">Valor</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select r.*, c.cli_nome 
                                    from receber r, cliente c
                                    where r.receber_obra_id = '$id' and r.receber_cliente_id = c.cli_id order by r.receber_dt_venc";

                            $resultado = mysqli_query($conexao, $sql);

                            while ($dados = mysqli_fetch_array($resultado)) :
                                $receber_id = $dados['receber_id'];
                                $numero = $dados['receber_numero'];
                                $sequencia = $dados['receber_sequencia'];
                                $cliente = mb_substr($dados['cli_nome'], 0, 30);
                                $dtVenc = $dados['receber_dt_venc'];
                                $dtPagto = $dados['receber_dt_pagto'];
                                $valor = $dados['receber_vl_orig'];
                                $historico = $dados['receber_historico'];
                                $status = $dados['receber_status'];
                            ?>
                                <tr>
                                    <td class="text-center"><?= $numero . ' - ' . $sequencia ?> </span></td>
                                    <td><?= $cliente ?></td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($dtVenc)) ?></td>
                                    <td class="text-center">R$ <?= number_format($valor, 2, ',', '.') ?></td>
                                    <td class="text-center"><?= $status == 'A' ? 'Aberto' : 'Pago' ?></td>
                                    <td class="text-center"><a href='../receber/alterar-receber.php?id=<?= $receber_id ?>&obra=<?= $id ?>'><span class="glyphicon glyphicon-search"></span></a></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                        </tbody>
                    </table>
                    <a class="btn btn-warning" href="./listar-obra.php"><i class="fa fa-reply"></i> Voltar</a>

                </div>


                <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab">

                    <h3 class="h3">Lista de ARTs</h3>
                    <br>
                    <table id="datatable-responsive2" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Número</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Data</th>
                                <th class="text-center">Valor</th>
                                <th class="text-center">Arquivo</th>
                                <th class="text-center">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select a.*, t.tipo_descricao from art a, tipo_art t 
                                    where a.art_tipo_art_id = t.tipo_id and a.art_obra_id = '$id' 
                                    order by a.art_data";

                            $resultado = mysqli_query($conexao, $sql);

                            while ($dados = mysqli_fetch_array($resultado)) :
                                $art_id = $dados['art_id'];
                                $art_numero = $dados['art_numero'];
                                $art_tipo = $dados['art_tipo_art_id'];
                                $art_data = $dados['art_data'];
                                $art_valor = $dados['art_valor'];
                                $tipo_descricao = mb_substr($dados['tipo_descricao'], 0, 30);
                                $art_arquivo = $dados['art_arquivo'];
                            ?>
                                <tr>
                                    <td class="text-center"><?= $art_numero ?> </span></td>
                                    <td class="text-center"><?= $tipo_descricao ?></td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($art_data)) ?></td>
                                    <td class="text-center">R$ <?= number_format($art_valor, 2, ',', '.') ?></td>
                                    <?php
                                    if ($art_arquivo != "") :
                                    ?>
                                        <td class="text-center"><a target="_blank" href='./../art/arquivos/<?= $art_arquivo ?>'><span class="glyphicon glyphicon-download"></span></a></td>
                                    <?php
                                    else :
                                    ?>
                                        <td class="text-center">sem arquivo</td>
                                    <?php
                                    endif
                                    ?>
                                    <td class="text-center"><a href='./../art/excluir-art.php?id=<?= $art_id ?>&obra=<?= $id ?>&arquivo=<?= $art_arquivo ?>'><span class="glyphicon glyphicon-trash"></span></a></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                        </tbody>
                    </table>
                    <a class="btn btn-success" href="../art/cadastrar-art.php?obra=<?= $id ?>"><i class="fa fa-plus"></i> Novo</a>
                    <a class="btn btn-warning" href="./listar-obra.php"><i class="fa fa-reply"></i> Voltar</a>
                </div>


            </div>
        </div>



    </div>
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

    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- jquery.inputmask -->
    <script src="../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.js"></script>
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- CEP -->
    <script src="../js/funcoes.js?id=123"></script>
    <!-- Moeda -->
    <script src="../js/moeda.js"></script>
    <!-- < !-- Pesquisas modal -->
    <script src="../js/pesquisas-modal.js?id=1"></script>
</body>

</html>