<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/plugins/images/favicon.png">
    <title>Rumah Sakit - Tindakan</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url() ?>assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css') ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css') ?>"/>
    <!-- Menu CSS -->
    <link href="<?= base_url() ?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- Animation CSS -->
    <link href="<?= base_url() ?>assets/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
	<link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css') ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css') ?>"/>
    
    <!-- jQuery -->
      
      <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
      
    <script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
    <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
      
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url() ?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?= base_url() ?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="<?= base_url() ?>assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?= base_url() ?>assets/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?= base_url() ?>assets/js/custom.min.js"></script>

    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (blue.css) for this starter
          page. However, you can choose any other skin from folder css / colors .
	-->
	<link href="<?= base_url() ?>assets/css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a>
                <div class="top-left-part"><a class="logo" href="#"><b><img src="<?= base_url() ?>assets/plugins/images/pixeladmin-logo.png" alt="home" /></b><span class="hidden-xs"><img src="<?= base_url() ?>assets/plugins/images/pixeladmin-text.png" alt="home" /></span></a></div>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a class="profile-pic" href="#"> <img src="<?= base_url() ?>assets/plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">Steave</b> </a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li style="padding: 10px 0 0;">
                        <a href="index.html" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i><span class="hide-menu">Dashboard</span></a>
                    </li>
                    <li>
                        <a href="<?= base_url()?>index.php/penyakit" class="waves-effect"><i class="fa fa-stethoscope fa-fw" aria-hidden="true"></i><span class="hide-menu">Penyakit</span></a>
                    </li>
                    <li>
                        <a href="<?= base_url()?>index.php/tindakan" class="waves-effect"><i class="fa fa-gavel fa-fw" aria-hidden="true"></i><span class="hide-menu">Jenis Tindakan</span></a>
                    </li>
                    <li>
                        <a href="<?= base_url()?>index.php/rawat_jalan" class="waves-effect"><i class="fa fa-ambulance fa-fw" aria-hidden="true"></i><span class="hide-menu">Rawat Jalan</span></a>
                    </li>
                    <li>
                        <a href="<?= base_url()?>index.php/rawat_inap" class="waves-effect"><i class="fa fa-hospital-o fa-fw" aria-hidden="true"></i><span class="hide-menu">Rawat Inap</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?= $this->uri->segment(1)?> </h4> </div>
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active"><?= $this->uri->segment(1)?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
						<?php echo $content; ?>
						</div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2017 &copy; Pixel Admin brought to you by wrappixel.com </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
</body>
</html>

                            