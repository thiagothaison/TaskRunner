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
                            <div class="box box-primary allow-preloader">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo $subTitle; ?></h3>
                                </div><!-- /.box-header -->

                                <div class="box-body">

                                    <div class="row push">
                                        <div class="col-xs-2 col-sm-4 col-md-5 col-lg-8">
                                            <a href="<?php echo base_url(); ?>grupos/adicionar" class="btn btn-success btn-flat">Adicionar</a>
                                        </div>
                                        <div class="col-xs-9 col-xs-offset-1 col-sm-8 col-sm-offset-0 col-md-7 col-lg-4 text-right">
                                            <input name="search" class="form-control" autocomplete="off" placeholder="Pesquisar" type="text" role="data-table-filter" target="#data-table-grupos">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box-body">
                                    <table class="table table-bordered table-striped table-hover data-table" id="data-table-grupos" pageLength="15" ignoreOrder="1,2" aaSorting='[]'>
                                        <thead>
                                            <tr>
                                                <th>Descrição</th>
                                                <th>Observacões</th>
                                                <th style="width: 75px" class="text-center">Ativo</th>
                                                <th style="width: 95px" class="text-center"><i class="fa fa-flash"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($grupos as $grupo){?>
                                                <tr data-id="<?php echo md5($grupo["id"]); ?>">
                                                    <td class="truncate"><?php echo $grupo["descricao"];?></td>
                                                    <td class="truncate"><?php echo $grupo["observacoes"];?></td>
                                                    <td class="text-center"><?php echo $grupo["ativo"] == 1 ? 'Sim' : 'Não';?></td>
                                                    <td class="text-center">
                                                        <div class="btn-group" data-id="<?php echo md5($grupo["id"]); ?>">
                                                            <button type="button" class="btn btn-<?php echo $grupo["ativo"] == 1 ? 'primary' : 'danger';?> btn-flat">Ações</button>
                                                            <button type="button" class="btn btn-<?php echo $grupo["ativo"] == 1 ? 'primary' : 'danger';?> btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                <span class="caret"></span>
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <ul class="dropdown-menu pull-right" role="menu">
                                                                <li><a href="<?php echo base_url(); ?>grupos/editar/<?php echo md5($grupo["id"]); ?>"><i class='glyphicon glyphicon-pencil'></i> Editar</a></li>
                                                                
                                                                <?php if ( $grupo["ativo"] == 1 ){ ?>
                                                                    <li><a href="javscript:;" role="inativar-grupo"><i class='glyphicon glyphicon-remove'></i> Inativar</a></li>
                                                                <?php }else{ ?>
                                                                    <li><a href="javscript:;" role="ativar-grupo"><i class='glyphicon glyphicon-ok'></i> Ativar</a></li>
                                                                <?php } ?>
                                                                    
                                                                <li><a href="javscript:;" role="excluir-grupo"><i class='glyphicon glyphicon-trash'></i> Excluir</a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="<?php echo base_url(); ?>portal/grupos/editar/<?php echo md5($grupo["id"]); ?>"><i class='glyphicon glyphicon-calendar'></i> Agendamentos</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

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
        <script src="<?php echo base_url() ?>assets/custom/js/application.custom.js"></script>
        <script src="<?php echo base_url() ?>assets/custom/js/grupos.custom.js"></script>

    </body>
</html>
