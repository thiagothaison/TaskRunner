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
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/plugins/select2/select2.css" >
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/custom/css/application.custom.css">

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
                                        
                                        <div class="box-body">

                                            <form role="ajax-form-agenda" method="post" action="<?php echo base_url("agendamentos/salvar"); ?>" enctype="multipart/form-data" autocomplete="off">

                                                <input type="hidden" name="id" value="<?php echo $agenda["id"]; ?>" />

                                                <fieldset >

                                                    <legend>Dados da Execução</legend>

                                                    <div class="row">

                                                        <div class="col-xs-12">

                                                            <div class="form-group">

                                                                <div class="form-group col-sm-4 col-lg-2">
                                                                    <label>Grupo</label>
                                                                    <?php echo create_combobox($grupos, "id", "descricao", "id_grupo", $agenda["id_grupo"], 'role="select-box"', true);?>
                                                                </div>                                                                

                                                                <div class="form-group col-sm-6 col-lg-4">
                                                                    <label>Tipo <span class="text-red">*</span></label>
                                                                    <select class="form-control" name="tipo" role="select-box">
                                                                        <?php if ( (int) $agenda["id"] == 0 ) { ?>
                                                                            <option value="-">Selecione</option>
                                                                        <?php } ?>
                                                                        <option value="0" <?php echo $agenda["tipo"] == 0 ? 'selected' : '' ;?>>Arquivo</option>
                                                                        <option value="1" <?php echo $agenda["tipo"] == 1 ? 'selected' : '' ;?>>URL</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-sm-6 col-lg-4">
                                                                    <label>Nome <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="nome" value="<?php echo $agenda["nome"]; ?>" placeholder="..."/>
                                                                </div>

                                                                <div class="form-group col-sm-6 col-lg-4">
                                                                    <label>Descrição <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="descricao" value="<?php echo $agenda["descricao"]; ?>" placeholder="..."/>
                                                                </div>

                                                                <div class="form-group col-sm-3 col-lg-2">
                                                                    <label>Cron <span class="text-red">*</span></label>
                                                                    <input readonly type="text" class="form-control cron" name="cron" value="<?php echo $agenda["cron"]; ?>" placeholder="Preencha a configuração"/>
                                                                </div>

                                                                <div class="form-group col-sm-3 col-lg-3">
                                                                    <label>Servidor</label>
                                                                    <select class="form-control" name="id_servidor_execucao" role="select-box">
                                                                        <option value="-">Nenhum</option>
                                                                        <?php foreach ($servidores as $servidor) { ?>
                                                                            <option value="<?php echo $servidor["id"]; ?>" <?php echo $servidor["id"] == $agenda["id_servidor_execucao"] ? "selected" : ""; ?>><?php echo $servidor["nome"]; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-sm-6 col-lg-7">
                                                                    <label>Ação <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" name="exec" value='<?php echo $agenda["exec"]; ?>' placeholder="..."/>
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </fieldset>

                                                <fieldset class="top30">

                                                    <legend>Configuração do Agendamento</legend>

                                                    <div class="row">

                                                        <div class="col-xs-12">

                                                            <div class="form-group border-top">

                                                                <div class="form-group col-sm-6 col-lg-4">
                                                                    <label>Segundos <span class="text-red">*</span></label>
                                                                    <select role="tag-select-box" data-name="second" name="seg" multiple class="form-control" size="1">
                                                                        <option value="*"    <?php echo in_array("*", $agenda['cfg'][0])    ? "selected" : ""; ?> >Sempre</option>
                                                                        <option value="*/5"  <?php echo in_array("*/5", $agenda['cfg'][0])  ? "selected" : ""; ?> >A cada 5 segundos</option>
                                                                        <option value="*/15" <?php echo in_array("*/15", $agenda['cfg'][0]) ? "selected" : ""; ?> >A cada 15 segundos</option>
                                                                        <option value="*/30" <?php echo in_array("*/30", $agenda['cfg'][0]) ? "selected" : ""; ?> >A cada 30 segundos</option>

                                                                        <option value="0"    <?php echo in_array("0", $agenda['cfg'][0])    ? "selected" : "";?> >00 segundo</option>
                                                                        <option value="1"    <?php echo in_array("1", $agenda['cfg'][0])    ? "selected" : "";?> >01 segundo</option>
                                                                        <?php for($i=2; $i<=59; $i++){?>
                                                                            <option value="<?php echo $i; ?>"  <?php echo in_array($i, $agenda['cfg'][0]) ? "selected" : "";?> ><?php echo sprintf("%'02d\n", $i); ?> segundos</option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-sm-6 col-lg-4">
                                                                    <label>Minutos <span class="text-red">*</span></label>
                                                                    <select role="tag-select-box" data-name="minute" name="min" multiple class="form-control" size="1">
                                                                        <option value="*"    <?php echo in_array("*", $agenda['cfg'][1]) ? "selected" : ""; ?> >Sempre</option>
                                                                        <option value="*/1"  <?php echo in_array("*/1", $agenda['cfg'][1]) ? "selected" : ""; ?> >A cada 1 minuto</option>
                                                                        <option value="*/5"  <?php echo in_array("*/5", $agenda['cfg'][1]) ? "selected" : ""; ?> >A cada 5 minutos</option>
                                                                        <option value="*/15" <?php echo in_array("*/15", $agenda['cfg'][1]) ? "selected" : ""; ?> >A cada 15 minutos</option>
                                                                        <option value="*/30" <?php echo in_array("*/30", $agenda['cfg'][1]) ? "selected" : ""; ?> >A cada 30 minutos</option>
                                                                        
                                                                        <option value="0"    <?php echo in_array("0", $agenda['cfg'][1]) ? "selected" : ""; ?>>00 minuto</option>
                                                                        <option value="1"    <?php echo in_array("1", $agenda['cfg'][1]) ? "selected" : ""; ?>>01 minuto</option>
                                                                        <?php for($i=2; $i<=59; $i++){?>
                                                                            <option value="<?php echo $i; ?>" <?php echo in_array($i, $agenda['cfg'][1]) ? "selected" : ""; ?> ><?php echo sprintf("%'02d\n", $i); ?> minutos</option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-sm-6 col-lg-4">
                                                                    <label>Horas <span class="text-red">*</span></label>
                                                                    <select role="tag-select-box" data-name="hour" name="hor" multiple class="form-control" size="1">
                                                                        <option value="*"     <?php echo in_array("*", $agenda['cfg'][2])    ? "selected" : ""; ?> >Sempre</option>
                                                                        <option value="*/1"   <?php echo in_array("*/1", $agenda['cfg'][2])  ? "selected" : ""; ?>>A cada 1 hora</option>
                                                                        <option value="*/6"   <?php echo in_array("*/6", $agenda['cfg'][2])  ? "selected" : ""; ?>>A cada 6 horas</option>
                                                                        <option value="*/12"  <?php echo in_array("*/12", $agenda['cfg'][2]) ? "selected" : ""; ?>>A cada 12 horas</option>
                                                                        
                                                                        <option value="0"     <?php echo in_array("0", $agenda['cfg'][2])    ? "selected" : ""; ?>>00 hora</option>
                                                                        <option value="1"     <?php echo in_array("1", $agenda['cfg'][2])    ? "selected" : ""; ?>>01 hora</option>
                                                                        <?php for($i=2; $i<=23; $i++){?>
                                                                            <option value="<?php echo $i; ?>" <?php echo in_array($i, $agenda['cfg'][2])  ? "selected" : ""; ?> ><?php echo sprintf("%'02d\n", $i); ?> horas</option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-sm-6 col-lg-4">
                                                                    <label>Dias <span class="text-red">*</span></label>
                                                                    
                                                                    <select role="tag-select-box" data-name="day" name="dia" multiple class="form-control" size="1">
                                                                        <option value="*"    <?php echo in_array("*", $agenda['cfg'][3])    ? "selected" : ""; ?> >Sempre</option>
                                                                        <option value="*/7"  <?php echo in_array("*/7", $agenda['cfg'][3])  ? "selected" : ""; ?> >A cada 7 dias</option>
                                                                        <option value="*/15" <?php echo in_array("*/15", $agenda['cfg'][3]) ? "selected" : ""; ?> >A cada 15 dias</option>
                                                                        
                                                                        <?php for($i=1; $i<=31; $i++){?>
                                                                            <option value="<?php echo $i; ?>" <?php echo in_array($i, $agenda['cfg'][3]) ? "selected" : ""; ?> >Dia <?php echo sprintf("%'02d\n", $i); ?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                    
                                                                </div>

                                                                <div class="form-group col-sm-6 col-lg-4">
                                                                    <label>Meses <span class="text-red">*</span></label>
                                                                    <select role="tag-select-box" data-name="month" name="mes" multiple class="form-control" size="1">
                                                                        <option value="*"   <?php echo in_array("*", $agenda['cfg'][4])   ? "selected" : ""; ?>>Sempre</option>
                                                                        <option value="*/2" <?php echo in_array("*/2", $agenda['cfg'][4]) ? "selected" : ""; ?>>A cada 2 Meses</option>
                                                                        <option value="*/3" <?php echo in_array("*/3", $agenda['cfg'][4]) ? "selected" : ""; ?>>A cada 3 Meses</option>
                                                                        <option value="*/4" <?php echo in_array("*/4", $agenda['cfg'][4]) ? "selected" : ""; ?>>A cada 4 Meses</option>
                                                                        <option value="*/6" <?php echo in_array("*/6", $agenda['cfg'][4]) ? "selected" : ""; ?>>A cada 6 Meses</option>

                                                                        <option value="0"   <?php echo in_array("0", $agenda['cfg'][4])   ? "selected" : ""; ?>>Janeiro</option>
                                                                        <option value="1"   <?php echo in_array("1", $agenda['cfg'][4])   ? "selected" : ""; ?>>Fevereiro</option>
                                                                        <option value="2"   <?php echo in_array("2", $agenda['cfg'][4])   ? "selected" : ""; ?>>Março</option>
                                                                        <option value="3"   <?php echo in_array("3", $agenda['cfg'][4])   ? "selected" : ""; ?>>Abril</option>
                                                                        <option value="4"   <?php echo in_array("4", $agenda['cfg'][4])   ? "selected" : ""; ?>>Maio</option>
                                                                        <option value="5"   <?php echo in_array("5", $agenda['cfg'][4])   ? "selected" : ""; ?>>Junho</option>
                                                                        <option value="6"   <?php echo in_array("6", $agenda['cfg'][4])   ? "selected" : ""; ?>>Julho</option>
                                                                        <option value="7"   <?php echo in_array("7", $agenda['cfg'][4])   ? "selected" : ""; ?>>Agosto</option>
                                                                        <option value="8"   <?php echo in_array("8", $agenda['cfg'][4])   ? "selected" : ""; ?>>Setembro</option>
                                                                        <option value="9"   <?php echo in_array("9", $agenda['cfg'][4])   ? "selected" : ""; ?>>Outubro</option>
                                                                        <option value="10"  <?php echo in_array("10", $agenda['cfg'][4])  ? "selected" : ""; ?>>Novembro</option>
                                                                        <option value="11"  <?php echo in_array("11", $agenda['cfg'][4])  ? "selected" : ""; ?>>Dezembro</option>
                                                                        
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-sm-6 col-lg-4">
                                                                    <label>Semanas <span class="text-red">*</span></label>
                                                                    <select role="tag-select-box" data-name="weekday" name="sem" multiple class="form-control" size="1">
                                                                        <option value="*"   <?php echo in_array("*", $agenda['cfg'][5]) ? "selected" : ""; ?>>Sempre</option>
                                                                        <option value="1-5" <?php echo in_array("1-5", $agenda['cfg'][5]) ? "selected" : ""; ?>>Segunda à Sexta</option>
                                                                        <option value="0,6" <?php echo in_array("0,6", $agenda['cfg'][5]) ? "selected" : ""; ?>>Finais de Semana</option>
                                                                        
                                                                        <option value="0"   <?php echo in_array("0", $agenda['cfg'][5]) ? "selected" : ""; ?>>Segunda</option>
                                                                        <option value="1"   <?php echo in_array("1", $agenda['cfg'][5]) ? "selected" : ""; ?>>Terça</option>
                                                                        <option value="2"   <?php echo in_array("2", $agenda['cfg'][5]) ? "selected" : ""; ?>>Quarta</option>
                                                                        <option value="3"   <?php echo in_array("3", $agenda['cfg'][5]) ? "selected" : ""; ?>>Quinta</option>
                                                                        <option value="4"   <?php echo in_array("4", $agenda['cfg'][5]) ? "selected" : ""; ?>>Sexta</option>
                                                                        <option value="5"   <?php echo in_array("5", $agenda['cfg'][5]) ? "selected" : ""; ?>>Sábado</option>
                                                                        <option value="6"   <?php echo in_array("6", $agenda['cfg'][5]) ? "selected" : ""; ?>>Domingo</option>
                                                                        
                                                                    </select>
                                                                </div>

                                                            </div>


                                                        </div>

                                                    </div>

                                                </fieldset>

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="box-footer text-right">
                                                            <a href="<?php echo base_url("agendamentos"); ?>" class="btn btn-flat btn-primary"><i class="fa fa-reply"></i> Voltar</a>
                                                            <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-check"></i> Salvar</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                            
                                        </div>

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
        <script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/select2/i18n/pt-BR.js" type="text/javascript"></script>
        
        <script src="<?php echo base_url() ?>assets/custom/js/application.custom.js"></script>
        <script src="<?php echo base_url() ?>assets/custom/js/agenda.custom.js"></script>

    </body>
</html>
