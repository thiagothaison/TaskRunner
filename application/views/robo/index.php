<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?> | <?php echo strip_tags($subTitle); ?></title>
		
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dist/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dist/css/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/skins/_all-skins.min.css">
        
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/custom/css/application.custom.css">
        
        <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script>
            var app_u = '<?php echo base_url(); ?>'; 
        </script>
    </head>
    <body class="hold-transition skin-blue">
        <div class="wrapper">

            <?php $this->view('elements/header'); ?>

            <?php $this->view('elements/nav'); ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo strip_tags($title); ?>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    
                    <?php $this->view('elements/message'); ?>

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <?php $this->view('elements/footer'); ?>

        </div><!-- ./wrapper -->

        <script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/fastclick/fastclick.min.js"></script>
        <script src="<?php echo base_url() ?>assets/dist/js/app.js"></script>
        <script src="<?php echo base_url() ?>assets/dist/js/demo.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jQueryUI/jquery-ui.js"></script>
        
        <script src="<?php echo base_url() ?>assets/plugins/moment/moment-with-locales.js"></script>
        <script src="<?php echo base_url() ?>assets/custom/js/application.custom.js"></script>
        
    </body>
</html>
