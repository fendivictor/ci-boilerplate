<?php  
    $title = isset($title) ? $title : '';
    $profile_name = isset($data_user->profile_name) ? $data_user->profile_name : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= lang('dashboard'); ?> <?= ($current_menu <> '') ? ' : '.lang($current_menu) : ' : '.$title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/img/'); ?>logo__1.png">
    <meta name="theme-color" content="#0f5934">
    <meta name="msapplication-navbutton-color" content="#0f5934">
    <meta name="apple-mobile-web-app-status-bar-style" content="#0f5934">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/custom-loader.css">
    <style>
        .selected {
            background: aquamarine;
        }
    </style>
    <?php 
        $style = isset($style) ? $style : [];
        if ($style) {
            foreach ($style as $row) {
                foreach ($row as $val) {
                    echo '<link rel="stylesheet" href="'.base_url($val).'">' . PHP_EOL;
                }
            }
        }
    ?>

    <?= isset($css) ? $css : ''; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-success">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-success elevation-4">
            <!-- Brand Logo -->
            <a href="javascript:;" class="brand-link">
                <img src="<?php echo base_url() ?>assets/img/fukuryo_favi_fix_0712.png" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">
                    Management Project
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo base_url() ?>assets/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $profile_name; ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <?= isset($menu) ? $menu : ''; ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>