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
                        <h4>Cadastrar Grupo de Usuário</h4>
                    </div>
                    <div class="grid-body no-border"><br>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <div class="form-group">
                                    <label class="form-label">Nome do Grupo de Usuário</label>
                                    <div class="controls">
                                        <input type="text" name="grupo" value="<?= set_value('grupo') ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="controls">
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
        $("#form").attr('action', '/admin/grupo/inserir');
        $("#form").submit();
    });
</script>