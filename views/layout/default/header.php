<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <link rel="icon verdum" href="<?php echo BASE_URL ?>public/dist/img/favicon.png" />
  <title>RECURSOS HUMANOS | VERDUM PERU S.A.C.</title>

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- BEGIN: Vendor CSS-->
  <?php if (isset($_layoutParams['cssSp']) && count($_layoutParams['cssSp'])) : ?>
    <?php foreach ($_layoutParams['cssSp'] as $layoutcssSp) : ?>
      <link rel="stylesheet" href="<?php echo  $layoutcssSp ?>">
    <?php endforeach; ?>
  <?php endif; ?>
  <!-- END: Custom CSS-->

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <!-- <body class="hold-transition sidebar-mini layout-fixed"> -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-success">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo BASE_URL ?>nosotros/index" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo BASE_URL ?>viveverdum/index" class="nav-link">Beneficios</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo BASE_URL ?>documentospago/index" class="nav-link">Boletas de pago</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="<?php echo BASE_URL?>timelinenotificacion/index">
            <i class="far fa-bell fa-shake"></i>&nbsp;&nbsp;Notificaciones
            <span class="badge badge-danger navbar-badge"><?php echo $_SESSION['num_notificaciones']?></span>
          </a>
          <!-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            <span class="dropdown-item dropdown-header"><?php //echo $_SESSION['num_notificaciones']?> Notificacion(es)</span>
            <div class="dropdown-divider"></div>
            
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>

            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">Todas las notificaciones</a>
          </div> -->
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4 sidebar-light-success">
      <!-- Brand Logo -->
      <a href="<?php echo BASE_URL ?>perfil/index" class="brand-link">
        <img src="<?php echo BASE_URL ?>public/dist/img/favicon.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
        <span style="color:gray;" class="brand-text font-weight-bold"><b><?php echo $_SESSION['razon'] ?></b></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img id="imagen-logo" src="<?php echo BASE_URL . $_SESSION['foto'] ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block" style="color:gray;"><strong><?php echo $_SESSION['usuario'] ?></strong></a>
            <a><span class="badge badge-secondary right"><strong><?php echo $_SESSION['perfil'] ?></strong></span></a>
          </div>

        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <!-- <a href="<?php //echo BASE_URL 
                            ?>index/logout" style="font-size:13px;">Cerrar Sesion</a> -->
              <button type="button" id="btncerrarsession" class="btn btn-block bg-gradient-danger btn-sm"><b>SALIR</b></button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <?php echo $_SESSION['menuinicial'] ?>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>