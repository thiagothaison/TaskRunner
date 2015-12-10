<aside class="control-sidebar chat control-sidebar-dark">

    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active">
            <a href="#contatos" data-toggle="tab">
                <i class="fa fa-user"></i>
                <span class="label label-danger">8</span>
            </a>
        </li>
        <li><a href="javascript:;">&nbsp;</a></li>
        <li><a href="javascript:;">&nbsp;</a></li>
        <!-- <li>
            <a href="#grupos" data-toggle="tab">
                <i class="fa fa-users"></i>
                <span class="label label-danger">2</span>
            </a>
        </li>
        <li><a href="#config" data-toggle="tab"><i class="fa fa-gears"></i></a></li> -->
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="contatos">
            <h3 class="control-sidebar-heading">Contatos</h3>

            <input type="text" name="q" class="form-control" placeholder="Pesquisar Contatos..." />

            <ul class="control-sidebar-menu">
                
                <?php foreach( $ultimos_contatos as $contato ){ ?>
                
                    <li role="contato-chat" data-id="<?php echo md5($contato["id"]) ?>">
                        <a href="javascript:;">
                            <div class="pull-left img-user-chat">
                                <img src="<?php echo base_url() ?>imagem-usuario/<?php echo md5($contato["id"]) ?>" class="img-circle" alt="User Image">
                            </div>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading"><i class="fa fa-circle text-success"></i> <?php echo shortName($contato["nome"]); ?></h4>
                                <p><?php echo ucwords( strtolower( $contato["cargo"]["descricao"] ) ); ?></p>
                            </div>
                        </a>
                    </li>
                
                <?php } ?>
                    
            </ul>

        </div>

        <div class="tab-pane" id="grupos">
            <h3 class="control-sidebar-heading">Grupos</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-user bg-yellow"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                            <p>New phone +1(800)555-1234</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                            <p>nora@example.com</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-file-code-o bg-green"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                            <p>Execution time 5 seconds</p>
                        </div>
                    </a>
                </li>
            </ul><!-- /.control-sidebar-menu -->

        </div>

        <div class="tab-pane" id="config">
            <h3 class="control-sidebar-heading">Configurações</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-user bg-yellow"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                            <p>New phone +1(800)555-1234</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                            <p>nora@example.com</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-file-code-o bg-green"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                            <p>Execution time 5 seconds</p>
                        </div>
                    </a>
                </li>
            </ul><!-- /.control-sidebar-menu -->

        </div>

    </div>
</aside>