<?php
require "../config/global.php";
if (strlen(session_id()) < 1) 
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= NOMBRE_EMPRESA ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/favicon.ico">
    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/general.css">
  </head>
  <body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="escritorio.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"> <img src="../files/favicon.png" width="40" alt=""></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="../files/logo-white.png" width="100" alt=""></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="nav-item dropdown ">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                  <i class="fa fa-bell"></i>
                  <span class="badge badge-warning navbar-badge" id="totalRecordatorios"></span>
                </a> <!--  <span class="float-right text-muted text-sm">3 mins</span> -->
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
             <!--      <span class="dropdown-item dropdown-header">Reuniones Pendientes</span> -->
                  <div class="dropdown-divider"></div>
                  <div id="containerMensaje">
                  </div>
                  
                </div>
              </li>
              <?php
              
              ?>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagenusuario']; ?>" class="user-image" alt="<?php echo $_SESSION['nomusuario']; ?>">
                  <span class="hidden-xs"><?php echo $_SESSION['nomusuario']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagenusuario']; ?>" class="img-circle" alt="<?php echo $_SESSION['nomusuario']; ?>">
                    <p>
                    <?php echo $_SESSION['nomusuario']; ?>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                  <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                    </div>
                  </li>
                </ul>
              </li>

            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            <?php 
            $menu = $_SESSION['permisos_nommodulos'];
            foreach($_SESSION['permisos_idmodulos'] as $permiso){
              ?>
              <li id="<?php echo $menu['id'][$permiso]  ?>">
                <a href="<?php echo $menu['url'][$permiso] ?>">
                  <i class="fa <?php echo $menu['icono'][$permiso] ?>"></i> <span><?php echo $menu[$permiso] ?></span>
                </a>
              </li>
              <?php
            }
            ?>
           
          </ul>
        </section>
      </aside>