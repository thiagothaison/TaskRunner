<!-- icon -->
<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png">

<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url(); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            <!--<b>B</b>OT-->
            <img src="<?php echo base_url("assets/images/icon.png");?>" />
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><?php echo $title; ?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle hidden-sm hidden-md hidden-lg" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="user-image"> 
                            <img src="<?php echo base_url(); ?>assets/dist/img/avatar5.png" class="" alt="User Image">
                        </div>
                        <span class="hidden-xs" style="display: table;">Fulano de Tal</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            
                            <div class="img-user">
                                <img src="<?php echo base_url(); ?>assets/dist/img/avatar5.png" class="" alt="User Image">
                            </div>
                            <p>
                                Fulano de Tal
                                <small>Um cara qualquer</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo base_url(); ?>meu-perfil" class="btn btn-default btn-flat">Meu Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url(); ?>sair" class="btn btn-default btn-flat">Sair</a>
                            </div>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </div>
    </nav>
</header>