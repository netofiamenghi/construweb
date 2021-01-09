<?php

$idUsuario = $_SESSION['idUsuario'];
$nomeUsuario = $_SESSION['nomeUsuario'];
$empresa = $_SESSION['empresa'];

?>
<!-- Custom fonts for this template-->
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="../geral/pagina-inicial.php" class="site_title"><i class="fa fa-home"></i> <span><?= $empresa ?></span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <!-- <div class="profile_pic">
                        <img src="../img/img.jpg" alt="..." class="img-circle profile_img">
                    </div> -->
                    <div class="profile_info">
                        <span>Bem-vindo,</span>
                        <h2><?= $nomeUsuario ?></h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->
                <br />
                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>ConstruWeb - <?= $_SESSION['versao'] ?></h3>
                        <ul class="nav side-menu">
                            <li><a href="../geral/pagina-inicial.php"><i class="fa fa-home"></i> Início </a></li>
                            <li><a><i class="fa fa-pencil"></i> Cadastros <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="../cliente/listar-cliente.php">Cliente</a></li>
                                    <li><a href="../empresa/empresa.php">Empresa</a></li>
                                    <li><a href="../fornecedor/listar-fornecedor.php">Fornecedor</a></li>
                                    <li><a href="../funcionario/listar-funcionario.php">Funcionário</a></li>
                                    <li><a href="../obra/listar-obra.php">Obra</a></li>
                                    <li><a href="../produto/listar-produto.php">Produto</a></li>
                                    <li><a href="../tipo-art/listar-tipo-art.php">Tipo ART</a></li>
                                    <li><a href="../usuario/listar-usuario.php">Usuário</a></li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-shopping-cart"></i> Compras <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="../devolucao/listar-devolucao.php">Devolução</a></li>
                                    <li><a href="../nf-entrada/listar-nf-entrada.php">Entrada</a></li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-money"></i> Financeiro <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="../lancamento/listar-lancamento.php">Caixa</a></li>
                                    <li><a>Títulos à Pagar<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="../pagar/config-recibo.php">Gerar Recibo</a></li>
                                            <li><a href="../pagar/listar-pagar.php">Títulos à Pagar</a></li>
                                        </ul>
                                    </li>
                                    <!-- <li><a>Títulos à Receber<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu"> -->
                                    <li><a href="../receber/listar-receber.php">Títulos à Receber</a></li>
                                    <!-- </ul>
                                    </li> -->
                                </ul>
                            </li>
                            <li><a><i class="fa fa-line-chart"></i> Relatórios <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a>Cadastros Gerais<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="../cliente/config-rel-cliente.php">Cliente</a></li>
                                            <li><a href="../fornecedor/config-rel-fornecedor.php">Fornecedor</a></li>
                                            <li><a href="../funcionario/config-rel-funcionario.php">Funcionário</a></li>
                                            <li><a href="../produto/config-rel-produto.php">Produto</a></li>
                                            <li><a href="../usuario/config-rel-usuario.php">Usuário</a></li>
                                        </ul>
                                    </li>
                                    <li><a>Compras<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="../devolucao/config-rel-devolucao.php">Devolução</a></li>
                                            <li><a href="../nf-entrada/config-rel-nf-entrada.php">Entrada</a></li>
                                        </ul>
                                    </li>
                                    <li><a>Financeiro<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="../pagar/config-rel-pagar.php">Títulos à Pagar</a></li>
                                            <li><a href="../receber/config-rel-receber.php">Títulos à Receber</a></li>
                                        </ul>
                                    </li>
                                    <li><a>Obra<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="../obra/config-rel-balanco.php">Balanço Financeiro</a></li>
                                            <li><a href="../obra/config-rel-prod-obra.php">Produtos por Obra</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Início" href="../geral/pagina-inicial.php">
                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Novidades" href="../geral/novidades-versao.php">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Suporte Técnico" href="../geral/suporte.php">
                        <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Sair" href="../logout.php">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <!-- <img src="../img/img.jpg" alt=""> -->
                                <?= $nomeUsuario ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="../geral/novidades-versao.php"><i class="fa fa-exclamation-circle pull-right"></i> Novidades da Versão</a></li>
                                <li><a href="../geral/suporte.php"><i class="fa fa-phone pull-right"></i> Suporte Técnico</a></li>
                                <li><a href="../logout.php"><i class="fa fa-power-off pull-right"></i> Sair</a></li>
                            </ul>
                        </li>
                        <li>
                            <a target="_blank" href="https://api.whatsapp.com/send?phone=5517997941983">
                                <img width="70px" style="border-radius: 10px;" src="../img/Whatsapp.jpg" alt="" class="img-responsive">
                            </a>
                        </li>
                        <li>
                            <br>+55 17 99794 1983 &nbsp;
                        </li>
                        <li>
                            <br>Suporte Técnico: &nbsp;&nbsp;
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->