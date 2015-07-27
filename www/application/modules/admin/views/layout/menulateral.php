<?php
$pusuario = $this->viewGrupoAcaoModel->verificaPermissao('admin/usuario/index');
$pgrupo = $this->viewGrupoAcaoModel->verificaPermissao('admin/grupo/index');
$pacao = $this->viewGrupoAcaoModel->verificaPermissao('admin/acao/index');
?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar" id="main-menu" style="padding-top: 10px;"> 
    <!-- BEGIN MINI-PROFILE -->
    <div class="user-info-wrapper">
        <div class="user-info">
            <div class="greeting">Seja bem Vindo</div>
            <div class="username"><?= (array_key_exists('1', $nomeUsuarioLogado)) ? $nomeUsuarioLogado[0] . ' ' . $nomeUsuarioLogado[1] : $nomeUsuarioLogado[0] ?></div>
            <div class="status">Status<a href="#" style="font-size: 12px"><div class="status-icon green"></div>Em dia</a></div>
        </div>
    </div>
    <!-- END MINI-PROFILE -->

    <!-- BEGIN MINI-WIGETS -->

    <!-- END MINI-WIGETS -->

    <!-- BEGIN SIDEBAR MENU -->	
    <ul>
        <hr>
        <?php if ($pusuario || $pgrupo || $pacao) : ?>
            <li class="">
                <a href="javascript:;">
                    <i class="icon-key"></i>
                    <span class="title">Acessos</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <?php if ($pusuario) : ?>
                        <li><a href="<?= base_url('admin/usuario/index') ?>">Usuários</a></li>
                    <?php endif; ?>
                    <?php if ($pgrupo) : ?>
                        <li><a href="<?= base_url('admin/grupo/index') ?>">Grupos de Usuários</a></li>
                    <?php endif; ?>
                    <?php if ($pacao) : ?>
                        <li><a href="<?= base_url('admin/acao/index') ?>">Ações do Sistema</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <hr>
        <!-- Folder e projects para tablet  -->
        <li class="hidden-lg hidden-md hidden-xs" id="more-widgets" style="display:" > <a href="javascript:;"> <i class="icon-ellipsis-horizontal"></i></a> 
            <ul class="sub-menu">
                <div class="side-bar-widgets">
                    <p class="menu-title">
                        FOLDER teste
                        <span class="pull-right">
                            <a href="#" class="create-folder">
                                <i class="icon-plus"></i>
                            </a>
                        </span>
                    </p>
                    <ul class="folders" id="folders">
                        <li><a href="#"><div class="status-icon green"></div> My quick tasks </a> </li>
                        <li><a href="#"><div class="status-icon red"></div> To do list </a> </li>
                        <li><a href="#"><div class="status-icon blue"></div> Projects </a> </li>
                        <li id="folder-input" class="folder-input" style="display:none"><input type="text" placeholder="Name of folder" class="no-boarder folder-name" name="" id="folder-name"></li>
                    </ul>
                    <p class="menu-title">PROJECTS </p>
                    <div class="status-widget">
                        <div class="status-widget-wrapper">
                            <div class="title">Freelancer<a href="#" class="remove-widget"><i class="icon-custom-cross"></i></a></div>
                            <p>Redesign home page</p>
                        </div>
                    </div>
                    <div class="status-widget">
                        <div class="status-widget-wrapper">
                            <div class="title">envato<a href="#" class="remove-widget"><i class="icon-custom-cross"></i></a></div>
                            <p>Statistical report</p>
                        </div>
                    </div>
                </div>
            </ul>
        </li>
    </ul>

    <a href="#" class="scrollup">Scroll</a>
    <div class="clearfix"></div>
    <!-- END SIDEBAR MENU --> 
</div>
<!-- END SIDEBAR --> 