<?= $topo ?>

<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">

    <?= $menulateral ?>

    <!-- BEGIN PAGE CONTAINER-->
    <div class="page-content"> 

        <div class="clearfix"></div>
        <div class="content">  

            <?php if ($sucesso) : ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert"></button>
                    <?= $sucesso ?>
                </div>
            <?php endif; ?>
            <?php if ($noticia) : ?>
                <div class="alert">
                    <button class="close" data-dismiss="alert"></button>
                    <?= $noticia ?>
                </div>
            <?php endif; ?>
            <?php if ($validacao) : ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert"></button>
                    <?= $validacao ?>
                </div>
            <?php endif; ?>
            <?php if ($erro) : ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert"></button>
                    <?= $erro ?>
                </div>
            <?php endif; ?>

            <form id="form" method="post">
                <div class="grid simple">
                    <div class="grid-title no-border">
                        <h4>Cadastrar Página do Sistema</h4>
                    </div>
                    <div class="grid-body no-border"><br>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <div class="form-group">
                                    <label class="form-label">Módulo</label>
                                    <div class="controls">
                                        <input type="text" name="modulo" value="<?= ($pagina->modulo) ? $pagina->modulo : 'admin' ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Controller</label>
                                    <div class="controls">
                                        <input type="text" name="controller" value="<?= set_value('controller') ? set_value('controller') : $pagina->controller ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Action</label>
                                    <div class="controls">
                                        <input type="text" name="action" value="<?= set_value('action') ? set_value('action') : $pagina-> action ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Apelido para o Controller:</label>
                                    <div class="controls">
                                        <input type="text" name="alias_controller" value="<?= set_value('alias_controller') ? set_value('alias_controller') : $pagina->alias_controller ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Apelido para a Action:</label>
                                    <div class="controls">
                                        <input type="text" name="alias_action" value="<?= set_value('alias_action') ? set_value('alias_action') : $pagina->alias_action ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Permissão:</label>
                                    <div class="radio radio-success">
                                        <input id="yes" type="radio" name="ativo" value="1" <?= ($pagina->ativo == 1) ? 'checked' : '' ?>>
                                        <label for="yes">Sim</label>
                                        <input id="no" type="radio" name="ativo" value="0" <?= ($pagina->ativo == 1) ? '' : 'checked' ?>>
                                        <label for="no">Não</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="controls">
                                        <input type="hidden" name="id" value="<?= $pagina->id ?>">
                                        <button id="salvar" type="button" class="btn btn-primary btn-cons">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END CONTAINER --> 
<?= $rodape ?>

<script>
    $("#salvar").click(function () {
        $("#form").attr('action', '/admin/pagina/alterar');
        $("#form").submit();
    });
</script>