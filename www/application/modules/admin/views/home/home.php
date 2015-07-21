<?= $topo ?>

<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">

    <?= $menulateral ?>

    <!-- BEGIN PAGE CONTAINER-->
    <div class="page-content condensed"> 

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
            
            

        </div>
    </div>
</div>
<!-- END CONTAINER --> 
<?= $rodape ?>