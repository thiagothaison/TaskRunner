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
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.css" />  
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/plugins/jquery-ui-autocomplete/jquery-ui.css">
        
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/custom/css/application.custom.css">

        <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script>var app_u = '<?php echo base_url(); ?>'; </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
        <div class="wrapper">

            <?php $this->view('elements/header'); ?>

            <?php $this->view('elements/nav'); ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo $title; ?>
                    </h1>
                    
                </section>

                <!-- Main content -->
                <section class="content">
                    
                    <?php $this->view('elements/message'); ?>

                    <div class="row">
                        <div class="col-xs-12">
                            
                            <div class="nav-tabs-custom box box-no-border allow-preloader">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?php echo $subTitle; ?></a></li>
                                </ul>
                                <div class="tab-content">

                                    <div class="tab-pane active" id="tab_1">

                                        <form role="ajax-form-grupo" method="post" action="<?php echo base_url("grupos/salvar"); ?>" enctype="multipart/form-data" autocomplete="off">

                                            <input type="hidden" name="id" value="<?php echo $grupo["id"]; ?>" />
                                            
                                            <div class="row">

                                                <div class="col-xs-12">
                                                    
                                                    <div class="form-group">
                                                        <div class="form-group col-xxs-12 col-xs-12 col-sm-6 col-md-5">
                                                            <label>Descrição <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="descricao" value="<?php echo $grupo["descricao"]; ?>" placeholder="..."/>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-xs-12">
                                                    
                                                    <div class="form-group">
                                                        <div class="form-group col-xxs-12 col-xs-12 col-sm-6 col-md-5">
                                                            <label>Observações </label>
                                                            <textarea rows="5" class="form-control" name="observacoes" placeholder="..."><?php echo $grupo["observacoes"]; ?></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="box-footer text-right">
                                                        <a href="<?php echo base_url("grupos"); ?>" class="btn btn-flat btn-primary"><i class="fa fa-reply"></i> Voltar</a>
                                                        <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-check"></i> Salvar</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                    </div><!-- /.tab-pane -->

                                </div><!-- /.tab-content -->
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                    

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <?php $this->view('elements/footer'); ?>

        </div><!-- ./wrapper -->

        <script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/fastclick/fastclick.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url() ?>assets/dist/js/app.min.js"></script>
        <script src="<?php echo base_url() ?>assets/dist/js/demo.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/moment/moment-with-locales.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jquery-ui-autocomplete/jquery-ui.js"></script>
        
        <script src="<?php echo base_url() ?>assets/custom/js/application.custom.js"></script>
        <script src="<?php echo base_url() ?>assets/custom/js/grupos.custom.js"></script>

    </body>
</html>
