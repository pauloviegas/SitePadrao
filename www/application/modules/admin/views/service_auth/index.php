<!DOCTYPE html>
<html>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <title><?= $nomeProjeto ?></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- BEGIN CORE CSS FRAMEWORK -->
        <link href="<?= $url_base . 'assets/plugins/pace/pace-theme-flash.css" rel="stylesheet' ?>" type="text/css" media="screen"/>
        <link href="<?= $url_base . 'assets/plugins/boostrapv3/css/bootstrap.min.css' ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= $url_base . 'assets/plugins/boostrapv3/css/bootstrap-theme.min.css' ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= $url_base . 'assets/plugins/font-awesome/css/font-awesome.css' ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= $url_base . 'assets/css/animate.min.css' ?>" rel="stylesheet" type="text/css"/>
        <!-- END CORE CSS FRAMEWORK -->

        <!-- BEGIN CSS TEMPLATE -->
        <link href="<?= $url_base . 'assets/css/style.css' ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= $url_base . 'assets/css/responsive.css' ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= $url_base . 'assets/css/custom-icon-set.css' ?>" rel="stylesheet" type="text/css"/>
        <!-- END CSS TEMPLATE -->
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="error-body no-top">
        <div class="container" style="margin-top: 20px;">

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

            <div class="row login-container column-seperation">  
                <div class="col-md-5 col-md-offset-1" style="min-height: 260px;">
                    <h2><?= $alliasNomeProjeto ?></h2>
                    <p>
                        <strong>Título para Descrição:</strong><br>
                        <br>
                        Descrição
                    </p>
                </div>
                <div class="col-md-5 ">
                    <br>
                    <form id="login-form" class="login-form" action="<?= base_url('/admin/serviceauth/logar') ?>" method="post">
                        <div class="row">
                            <div class="form-group col-md-10">
                                <label class="form-label">E-mail:</label>
                                <div class="controls">
                                    <div class="input-with-icon right">                                       
                                        <i class=""></i>
                                        <input id="email" type="text" name="email" class="form-control">                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-10">
                                <label class="form-label">Senha</label>
                                <span class="help"></span>
                                <div class="controls">
                                    <div class="input-with-icon right">                                       
                                        <i class=""></i>
                                        <input id="senha" type="password" name="senha" class="form-control">                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <input type="submit" value="Login" class="btn btn-primary btn-cons pull-right">
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN CORE JS FRAMEWORK-->
        <script src="<?= $url_base . 'assets/plugins/jquery-1.8.3.min.js' ?>" type="text/javascript"></script>
        <script src="<?= $url_base . 'assets/plugins/bootstrap/js/bootstrap.min.js' ?>" type="text/javascript"></script>
        <script src="<?= $url_base . 'assets/plugins/pace/pace.min.js' ?>" type="text/javascript"></script>
        <script src="<?= $url_base . 'assets/plugins/jquery-validation/js/jquery.validate.min.js' ?>" type="text/javascript"></script>
        <script src="<?= $url_base . 'assets/plugins/jquery-validation/lenguage/messages_pt_BR.min.js' ?>" type="text/javascript"></script>
        <!-- BEGIN CORE TEMPLATE JS -->
        <!-- END CORE TEMPLATE JS -->
    </body>
</html>
<script>
    $("#login-form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            senha: "required"
        }
    });
</script>