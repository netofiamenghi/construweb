<?php

include_once '../util/conexao.php';
include_once '../util/funcoes.php';

if (isset($_GET['id'])) :

    $id = $_GET['id'];
    $sql = "select * from fornecedor where for_id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);

    $tipo = $dados['for_tipo_pessoa'];
    $nomefantasia = $dados['for_fantasia'];
    $razaosocial = $dados['for_razaosocial'];
    $cnpj = $dados['for_cnpj'];
    $cpf = $dados['for_cpf'];
    $ie = $dados['for_ie'];
    $rg = $dados['for_rg'];
    $emissor = $dados['for_emissor_rg'];
    $telefone = $dados['for_telefone'];
    $celular = $dados['for_celular'];
    $email = $dados['for_email'];
    $logradouro = $dados['for_logradouro'];
    $complemento = $dados['for_complemento'];
    $numero = $dados['for_numero'];
    $bairro = $dados['for_bairro'];
    $cep = $dados['for_cep'];
    $cidade = $dados['for_cidade'];
    $estado = $dados['for_estado'];
    $contato = $dados['for_contato'];
    $status = $dados['for_status'];

elseif (isset($_POST['btnenviar'])) :

    $id = clear($_POST['id']);
    $tipo = clear($_POST['tipop']);
    $nomefantasia = clear($_POST['nomefantasia']);
    $razaosocial = clear($_POST['razaosocial']);
    $cnpjNovo = clear($_POST['cnpj']);
    $cnpjA = clear($_POST['cnpjA']);
    $cpfNovo = clear($_POST['cpf']);
    $cpfA = clear($_POST['cpfA']);
    $ie = clear($_POST['ie']);
    $rg = clear($_POST['rg']);
    $emissor = clear($_POST['emissor']);
    $telefone = clear($_POST['telefone']);
    $celular = clear($_POST['celular']);
    $email = clear($_POST['email']);
    $logradouro = clear($_POST['logradouro']);
    $complemento = clear($_POST['complemento']);
    $numero = clear($_POST['numero']);
    $bairro = clear($_POST['bairro']);
    $cep = clear($_POST['cep']);
    $cidade = clear($_POST['cidade']);
    $estado = clear($_POST['estado']);
    $contato = clear($_POST['contato']);
    $status = clear($_POST['status']);

    $verificarDoc = false;
    $alterar = true;

    if (($tipo == 'FISICA') && ($cpfA != $cpfNovo)) :
        $sql = "select for_id from fornecedor where for_cpf = '$cpfNovo'";
        $verificarDoc = true;
    elseif (($tipo == 'JURIDICA') && ($cnpjA != $cnpjNovo)) :
        $sql = "select for_id from fornecedor where for_cnpj = '$cnpjNovo'";
        $verificarDoc = true;
    endif;


    if ($verificarDoc == true) :
        $resultado = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($resultado) >= 1) :
            $_SESSION['msg'] = "<script>mostraDialogo('<strong>Alteração não efetuada!</strong><br>CPF/CNPJ já cadastrado!', 'warning', 6000);</script>";
            $alterar = false;
        endif;
    endif;


    if ($alterar == true) :
        $sql = "update fornecedor set for_tipo_pessoa = '$tipo', for_fantasia = '$nomefantasia', 
                for_razaosocial = '$razaosocial', for_cnpj = '$cnpjNovo', for_cpf = '$cpfNovo', for_ie = '$ie', 
                for_rg = '$rg', for_emissor_rg = '$emissor', for_telefone = '$telefone', for_celular = '$celular', 
                for_email = '$email', for_logradouro = '$logradouro', for_complemento = '$complemento', 
                for_numero = '$numero', for_bairro = '$bairro', for_cep = '$cep', for_cidade = '$cidade', 
                for_estado = '$estado', for_contato = '$contato', for_status = '$status' where for_id = '$id' ";

        if (mysqli_query($conexao, $sql)) :
            $_SESSION['msg'] = "<script>mostraDialogo('Fornecedor alterado com sucesso!', 'success');</script>";
        else :
            $_SESSION['msg'] = "<script>mostraDialogo('Erro ao alterar Fornecedor!', 'error');</script>";
        endif;
    endif;

    header("Location: alterar-fornecedor.php?id=$id&msg=sim");

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

    <link href="./../css/estilo.css" rel="stylesheet">

    <!-- Mensagens -->
    <script src="../js/mensagens.js"></script>
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

     <!-- Datatables -->
     <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Cadastro</a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Títulos à Pagar</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">


                    <h3 class="h3">Alterar Fornecedor</h3>
                    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>" />
                        <input type="hidden" name="cpfA" id="cpfA" value="<?= $cpf ?>" />
                        <input type="hidden" name="cnpjA" id="cnpjA" value="<?= $cnpj ?>" />


                        <div class="col-md-12">
                            <label for="tipop">Tipo Pessoa *</label><br>
                            <input type="radio" value="FISICA" name="tipop" id="fisica" required <?= $tipo == 'FISICA' ? 'checked' : '' ?> /><label for="fisica">&nbsp;FÍSICA&nbsp;</label>
                            <input type="radio" value="JURIDICA" name="tipop" id="juridica" <?= $tipo == 'JURIDICA' ? 'checked' : '' ?> /><label for="juridica">&nbsp;JURÍDICA</label><br><br>
                        </div>
                        <div id="div-nomefantasia">
                            <div class="col-md-6">
                                <label for="nomefantasia">Nome Fantasia *</label>
                                <input class="form-control" type="text" name="nomefantasia" id="nomefantasia" maxlength="100" required value="<?= $nomefantasia ?>" /><br>
                            </div>
                        </div>
                        <div id="div-nome">
                            <div class="col-md-6">
                                <label for="razaosocial">Nome/Razão Social *</label>
                                <input class="form-control" type="text" name="razaosocial" id="razaosocial" maxlength="100" required value="<?= $razaosocial ?>" /><br>
                            </div>
                        </div>
                        <div id="div-cnpj">
                            <div class="col-md-6">
                                <label for="cnpj">CNPJ *</label>
                                <input class="form-control" type="text" name="cnpj" id="cnpj" required data-inputmask="'mask' : '99.999.999/9999-99'" value="<?= $cnpj ?>" /><br>
                            </div>
                        </div>
                        <div id="div-cpf">
                            <div class="col-md-6">
                                <label for="cpf">CPF *</label>
                                <input class="form-control" type="text" name="cpf" id="cpf" required data-inputmask="'mask' : '999.999.999-99'" value="<?= $cpf ?>" /><br>
                            </div>
                        </div>
                        <div id="div-ie">
                            <div class="col-md-6">
                                <label for="ie">Inscrição Estadual</label>
                                <input class="form-control" type="text" name="ie" id="ie" value="<?= $ie ?>" /><br>
                            </div>
                        </div>
                        <div id="div-rg">
                            <div class="col-md-6">
                                <label for="rg">RG</label>
                                <input class="form-control" type="text" name="rg" id="rg" value="<?= $rg ?>" /><br>
                            </div>
                        </div>
                        <div id="div-emissor">
                            <div class="col-md-6">
                                <label for="emissor">Órgão Emissor</label>
                                <input class="form-control" type="text" name="emissor" id="emissor" value="<?= $emissor ?>" /><br>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="telefone">Telefone</label>
                            <input class="form-control" type="text" name="telefone" id="telefone" data-inputmask="'mask' : '(99) 9999-9999'" value="<?= $telefone ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="celular">Celular</label>
                            <input class="form-control" type="text" name="celular" id="celular" data-inputmask="'mask' : '(99) 99999-9999'" value="<?= $celular ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" id="email" maxlength="100" value="<?= $email ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="contato">Contato</label>
                            <input class="form-control" type="text" name="contato" id="contato" maxlength="100" value="<?= $contato ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="cep">CEP *</label>
                            <input class="form-control" type="text" name="cep" id="cep" required data-inputmask="'mask' : '99.999-999'" value="<?= $cep ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="logradouro">Logradouro *</label>
                            <input class="form-control" type="text" name="logradouro" id="logradouro" maxlength="100" required value="<?= $logradouro ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="complemento">Complemento</label>
                            <input class="form-control" type="text" name="complemento" id="complemento" value="<?= $complemento ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="numero">Número *</label>
                            <input class="form-control" type="text" name="numero" id="numero" value="<?= $numero ?>" required /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="bairro">Bairro *</label>
                            <input class="form-control" type="text" name="bairro" id="bairro" maxlength="100" required value="<?= $bairro ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="cidade">Cidade *</label>
                            <input class="form-control" type="text" name="cidade" id="cidade" maxlength="100" required value="<?= $cidade ?>" /><br>
                        </div>
                        <div class="col-md-6">
                            <label for="estado">Estado *</label>
                            <select class="form-control" name="estado" id="estado">
                                <option <?= $estado == 'AC' ? 'selected' : '' ?> value="AC">ACRE</option>
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
                            <label for="status">Status *</label>
                            <select class="form-control" name="status">
                                <option value="A" <?= $status == 'A' ? 'selected' : '' ?>>ATIVO</option>
                                <option value="I" <?= $status == 'I' ? 'selected' : '' ?>>INATIVO</option>
                                <option value="E" <?= $status == 'E' ? 'selected' : '' ?>>EXCLUÍDO</option>
                            </select><br>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success" name="btnenviar"><i class="fa fa-save"></i> Salvar</button>
                            <a class="btn btn-warning" href="listar-fornecedor.php"><i class="fa fa-reply"></i> Voltar</a>
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


                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                    <h3 class="h3">Lista de Títulos à Pagar</h3>
                    <br>
                    <table id="datatable-responsive1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Número</th>
                                <th class="text-center">Obra</th>
                                <th class="text-center">Vencimento</th>
                                <th class="text-center">Valor</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select p.*, o.obra_nome
                                    from pagar p, obra o
                                    where p.pagar_obra_id = o.obra_id and p.pagar_fornecedor_id = '$id' 
                                    order by p.pagar_dt_venc";

                            $resultado = mysqli_query($conexao, $sql);

                            while ($dados = mysqli_fetch_array($resultado)) :
                                $pagar_id = $dados['pagar_id'];
                                $numero = $dados['pagar_numero'];
                                $sequencia = $dados['pagar_sequencia'];
                                $obra = mb_substr($dados['obra_nome'], 0, 30);
                                $dtVenc = $dados['pagar_dt_venc'];
                                $dtPagto = $dados['pagar_dt_pagto'];
                                $valor = $dados['pagar_vl_orig'];
                                $historico = $dados['pagar_historico'];
                                $status = $dados['pagar_status'];
                            ?>
                                <tr>
                                    <td class="text-center"><?= $numero . ' - ' . $sequencia ?> </span></td>
                                    <td><?= $obra ?></td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($dtVenc)) ?></td>
                                    <td class="text-center">R$ <?= number_format($valor, 2, ',', '.') ?></td>
                                    <td class="text-center"><?= $status == 'A' ? 'Aberto' : 'Pago' ?></td>
                                    <td class="text-center"><a href='../pagar/alterar-pagar.php?id=<?= $pagar_id ?>&fornecedor=<?= $id ?>'><span class="glyphicon glyphicon-search"></span></a></td>
                                </tr>
                            <?php
                            endwhile;
                            ?>
                        </tbody>
                    </table>
                    <a class="btn btn-warning" href="./listar-fornecedor.php"><i class="fa fa-reply"></i> Voltar</a>

                </div>


            </div> 
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
    <!-- CEP -->
    <script src="../js/funcoes.js?id=123"></script>

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
</body>

</html>