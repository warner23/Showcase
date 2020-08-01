<?php

include "WICore/WIClass/WI.php";

if (! isset($_GET['k'])) {
    redirect('index.php');
}

$valid = $validator->prKeyValid($_GET['k']);

?>
<!doctype html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="WICMS - Warner Infinity">
        <meta name="author" content="Jules Warner">
        
        <title><?php echo WILang::get('password_reset'); ?> | WICMS</title>
        <link rel='stylesheet' href='WITheme/WICMS/site/css/frameworks/bootstrap.css' type='text/css' media='all' />
        <link rel='stylesheet' href='WITheme/WICMS/site/css/style.css' type='text/css' media='all' />
        <link rel='stylesheet' href='WITheme/WICMS/site/css/vender/bootstrap.min.css' type='text/css' media='all' />
        <link rel='stylesheet' href='WITheme/WICMS/site/css/style3.css' type='text/css' media='all' />
        <script type="text/javascript" src="WITheme/WICMS/site/js/frameworks/JQuery.js"></script>
        <script type="text/javascript" src="WITheme/WICMS/site/js/frameworks/bootstrap.js"></script>

        <link rel="icon" type="image/png" href="WIAdmin/WIMedia/Img/favicon/wi_cms_logo.PNG"/>
          <script type="text/javascript">
            var $_lang = <?php echo WILang::all(); ?>;
        </script> 

    </head>
    <body>
        <div class="container">
            <div class="modal modal-visible" id="password-reset-modal">
                <div class="modal-dialog" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3><?php echo WEBSITE_NAME; ?></h3>
                        </div>
                        <div class="modal-body">
                            <div class="well">
                                <?php if ($valid) : ?>
                                    <form class="form-horizontal" id="password-reset-form">
                                        <fieldset>
                                            <div id="legend">
                                                <legend class=""><?php echo WILang::get('password_reset'); ?></legend>
                                            </div>

                                            <div class="control-group form-group">
                                                <label class="control-label col-lg-4"  for="login-username">
                                                    <?php echo WILang::get('new_password'); ?>
                                                </label>
                                                <div class="controls col-lg-8">
                                                    <input type="password" id="password-reset-new-password"
                                                           class="input-xlarge form-control" />
                                                </div>
                                            </div>

                                            <div class="control-group  form-group">
                                            <label class="control-label col-lg-4" for="password-reset-repeat-password"><?php echo WILang::get("repeat_password") ?> <span class="required">*</span></label>
                                            <div class="controls col-lg-8">
                                                <input type="password" id="password-reset-repeat-password" class="input-xlarge form-control">
                                            </div>
                                         </div>

                                  
                                            <div class="control-group form-group">
                                                <div class="controls col-lg-offset-4 col-lg-8">
                                                    <button id="btn-reset-pass" class="btn btn-success">
                                                       <?php echo WILang::get('reset_password'); ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                <?php else : ?>
                                    <h5 class="text-error text-center"><?php echo WILang::get('invalid_password_reset_key') ?></h5>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="WICore/WIJ/sha512.js"></script>
        <script type="text/javascript" src="WICore/WIJ/WICore.js"></script>
        <script type="text/javascript" src="WICore/WIJ/WIPasswordReset.js"></script>

    </body>
</html>