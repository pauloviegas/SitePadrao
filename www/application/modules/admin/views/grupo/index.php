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

            <div class="row-fluid">
                <div class="span12">
                    <div class="grid simple ">
                        <div class="grid-title">
                            <h4>Grupos de Usuários</h4>
                        </div>
                        <div class="grid-body ">
                            <form id="form" method="post">
                                <div id="example2_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div id="example2_length" class="dataTables_length">
                                                <?php if ($cadastragrupousuario) : ?>
                                                    <button id="adicionar" type="button" class="btn btn-primary btn-cons">
                                                        <i class="icon-plus"></i>&nbsp;&nbsp;&nbsp;Novo Grupo de usuário
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped dataTable" id="example2" width="100%" aria-describedby="example2_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 70%;">Grupos de Usuários</th>
                                                <?php if ($editargrupousuario || $permissaogrupousuario || $deletargrupousuario) : ?>
                                                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 30%;">Ação</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                                            <?php if (count($grupos) > 0) : ?>
                                                <?php foreach ($grupos as $grupo) : ?>
                                                    <tr id="<?= $grupo->id ?>" class="gradeX odd">
                                                        <td class=" "><?= $grupo->grupo ?></td>
                                                        <?php if ($editargrupousuario || $permissaogrupousuario || $deletargrupousuario) : ?>
                                                            <td class="center ">
                                                                <?php if ($editargrupousuario) : ?>
                                                                    <button id="<?= $grupo->id ?>" type="button" class="btn btn-default btn-xs btn-mini editar">
                                                                        <i class="icon-pencil"></i>&nbsp;Editar
                                                                    </button>
                                                                <?php endif; ?>
                                                                <?php if ($permissaogrupousuario) : ?>
                                                                    <button id="<?= $grupo->id ?>" name="<?= $grupo->grupo ?>" type="button" class="btn btn-default btn-xs btn-mini permissao">
                                                                        <i class="icon-eye-open"></i>&nbsp;Permissões
                                                                    </button>
                                                                <?php endif; ?>
                                                                <?php if ($deletargrupousuario) : ?>
                                                                    <button id="<?= $grupo->id ?>" name="<?= $grupo->grupo ?>" type="button" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-xs btn-mini deletar">
                                                                        <i class="icon-trash"></i>&nbsp;Deletar
                                                                    </button>
                                                                <?php endif; ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr class="gradeX odd">
                                                    <td colspan="4" style="text-align: center;">Não existe nenhum Grupo de Usuário cadastrado!!!</td>
                                                <tr
                                            <?php endif; ?>
                                    </tbody>
                                </table>
                                <!--<div class="row"><div class="col-md-12"><div class="dataTables_paginate paging_bootstrap pagination"><ul><li class="prev disabled"><a href="#"><i class="icon-chevron-left"></i></a></li><li class="active"><a href="#">1</a></li><li><a href="#">2</a></li><li><a href="#">3</a></li><li><a href="#">4</a></li><li><a href="#">5</a></li><li class="next"><a href="#"><i class="icon-chevron-right"></i></a></li></ul></div><div class="dataTables_info" id="example2_info">Showing <b>1 to 10</b> of 57 entries</div></div></div></div>-->
                            </div>
                            <input id="idGrupo" type="hidden" name="idGrupo">
                            <input id="nomeGrupo" type="hidden" name="nomeGrupo">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalTitulo"></h4>
                </div>
                <div id="myModalTexto" class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button id="deletar" type="button" class="btn btn-primary">Deletar</button>
                </div>
            </div>
        </div>
    </div>

</div>



<!-- END CONTAINER --> 
<?= $rodape ?>






<script>
    var form = $("#form");

    grupoUsuario = 0;

    $("#adicionar").click(function () {
        form.attr('action', '/admin/grupo/criar');
        form.submit();
    });

    $(".editar").click(function () {
        me = $(this);
        id = me.attr("id");

        $("#idGrupo").attr('value', id);
        form.attr('action', '/admin/grupo/editar');
        form.submit();
    });

    $(".permissao").click(function () {
        me = $(this);
        id = me.attr("id");
        nome = me.attr("name");

        $("#idGrupo").attr('value', id);
        $("#nomeGrupo").attr('value', nome);
        form.attr('action', '/admin/grupo/permitir');
        form.submit();
    });

    $(".deletar").click(function () {
        grupoUsuario = $(this);
        name = grupoUsuario.attr("name");

        $("#myModal").show();
        $("#myModalTitulo").html("Aviso: Deletar Usuário");
        $("#myModalTexto").html("Você tem certeza que deseja deletar o Grupo de Usuário " + name + "?");
    });

    $("#deletar").click(function () {
        id = grupoUsuario.attr("id");
        nome = grupoUsuario.attr("name");

        $("#idGrupo").attr('value', id);
        $("#nomeGrupo").attr('value', nome);
        form.attr('action', '/admin/grupo/deletar');
        form.submit();
    });
</script>