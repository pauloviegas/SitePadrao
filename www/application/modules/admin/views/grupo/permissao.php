<?= $topo ?>

<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">

    <?= $menulateral ?>

    <!-- BEGIN PAGE CONTAINER-->
    <div class="page-content"> 

        <div class="clearfix"></div>
        <div class="content">  

            <div class="page-title"> <i class="icon-user"></i>
                <h3>Grupo de Usuário: <span class="semi-bold"><?= $nomeGrupo ?></span></h3>
            </div>

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

            <?php foreach ($paginas as $pagina => $permissoes) : ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="grid simple" style="opacity: 1; z-index: 0;">
                                    <div class="grid-title" style="height: 50px;">
                                        <h4>Permissão de <?= ucfirst($pagina) ?></h4>
                                        <div class="tools">
                                            <a href="javascript:;" class="expand"></a>
                                        </div>
                                    </div>
                                    <div class="grid-body" style="display: none;">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                                            <div class="scroller" style="overflow: hidden; width: auto;">
                                                <?php foreach ($permissoes as $permissao => $action) : ?>
                                                    <div class="row-fluid">
                                                        <div class="checkbox check-primary checkbox-circle">
                                                            <input class="permissao" name="<?= $action['action'] ?>" value="<?= $action['id'] ?>" id="checkbox<?= $action['id'] ?>" type="checkbox" value="<?= $action['id'] ?>" <?= (in_array($action['id'], $permitidos)) ? 'checked' : '' ?>>
                                                            <label for="checkbox<?= $action['id'] ?>"><?= $action['action'] ?></label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 			
                        </div>
                    </div>		
                </div>
            <?php endforeach; ?>
        </div>
    </div>




    <!-- END CONTAINER --> 
    <?= $rodape ?>

    <script>

        $(".permissao").change(function () {
            idGrupo = $("#idGrupo").val();
            idPagina = $(this).val();
            nomePagina = $(this).attr("name");
            $.ajax({
                url: '/admin/grupo/atualizarPermissao',
                type: 'post',
                data: {
                    'idGrupo': <?= $id ?>,
                    'idPagina': idPagina
                },
                dataRype: "json",
                success: function (resposta) {
                    valor = resposta.match(/true/);
                    valor = false;
                    if (!valor)
                    {
                        //Put this your code
                    }
                }
            });
        });
    </script>