<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PCRS - Login</title>

    <!-- Core CSS - Include with every page -->
    <link href="<?= base_url("assets/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/font-awesome/css/font-awesome.css") ?>" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="<?= base_url("assets/css/sb-admin.css") ?>" rel="stylesheet">

    <style type="text/css">
<!--
.style4 {font-size: 11px}
-->
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
				<div align="center"><img src="../assets/images/logo_small.png"></div>
                    <div class="panel-body">
                        <form role="form" method="post" action="<?= base_url("auth/login")?>">
                            <fieldset>
                                <div class="form-group <?php echo (form_error('txtUsername'))?'has-error':'' ?>">
                                    <input class="form-control" placeholder="ID Pengguna" name="txtUsername" value="<?php echo set_value('txtUsername') ?>" autofocus>
                                </div>
                                <div class="form-group <?php echo (form_error('txtPassword'))?'has-error':'' ?>">
                                    <input class="form-control" placeholder="Katalaluan" name="txtPassword" type="password" value="">
                                </div>
                                <div class="form-group <?php echo (form_error('comDomain'))?'has-error':'' ?>">
                                	<select class="form-control" name="comDomain">
                                        <option value="kejora.gov.my" <?php echo set_select('comDomain', 'internal', (set_value('comDomain')=='KEJORA.GOV.MY')?TRUE:FALSE); ?>>KEJORA.GOV.MY</option>
                                        <option value="internal" <?php echo set_select('comDomain', 'internal', (set_value('comDomain')=='internal')?TRUE:FALSE); ?>>internal</option>
                                    </select>
                                </div>
                                <button name="btnLogin" class="btn btn-lg btn-success btn-block" type="submit">Login</button>
                            </fieldset>
                        </form>
                        <br/>
                        <?php if(isset($error)){?>
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <?php echo $error ?>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div align="center">

      <!-- Core Scripts - Include with every page -->
      <script src="<?= base_url("assets/js/jquery-1.10.2.js") ?>"></script>
      <script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>
      <script src="<?= base_url("assets/js/plugins/metisMenu/jquery.metisMenu.js") ?>"></script>

      <!-- SB Admin Scripts - Include with every page -->
      <script src="<?= base_url("assets/js/sb-admin.js") ?>"></script>

      <span class="style4">**Paparan terbaik adalah menggunakan pelayar <strong>Firefox Mozilla </strong></span><span class="style4"><br>
    atau<strong> Google Chrome</strong> dengan resolusi melebihi 1024 x 768 pixel**</span>
    <br/>
    <span class="style4">
        ENV : <?= isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development' ?> 
    </span>
    </div>
</body>

</html>
