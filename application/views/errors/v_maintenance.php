<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker3.min.css')?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css')?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-clockpicker.min.css')?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery-ui.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sweetalert.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css')?>" >

    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/moment.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/transition.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/collapse.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datetimepicker.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-clockpicker.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/sweetalert.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.form.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/id.js')?>"></script>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<!-- Content Wrapper. Contains page content -->
<div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="error-page">
        <h2 class="headline text-red">500</h2>

        <div class="error-content">
        <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>

        <p>
        We will work on fixing that right away.
        Meanwhile, you may <a href="<?php echo base_url();?>">return to dashboard</a> or try using the search form.
        </p>

        </div>
    </div>
    <!-- /.error-page -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

</body>
</html>
