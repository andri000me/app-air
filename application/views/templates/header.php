<html>
<head>
  <title><?php echo $title ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker3.min.css')?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css')?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-clockpicker.min.css')?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery-ui.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sweetalert.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.bootstrap.min.css')?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/datatables.min.css')?>" >
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


    <style type="text/css">
        td {
            cursor: pointer;
            font-size: 13;
            font-family: "Arial";
        }
        th {
            cursor: pointer;
            font-size: 13;
            font-family: "Arial";
            color: #4A9166;
        }
        .editor{
            display: none;
        }
        .table>tbody>tr>td,
        .table>tbody>tr>th {
            border-top: none;
        }
        .topright {
            position: fixed;
            top: 65px;
            right: 25px;
            padding:3px 3px 3px 3px;
        }
        .form-control[disabled] {
            background-color: #4dc027;
        }
    </style>
</head>
<header>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav ">
                    <li>
                        <a href="<?= base_url('main'); ?>">Beranda</a>
                    </li>
                    <?php
                    if($this->session->userdata('role') != NULL) {
                        if ($this->session->userdata('role') == "loket") {
                            ?>
                            <li>
                                <a href="<?= base_url('main/view?id=darat'); ?>">Transaksi Baru</a>
                            </li>
                            <li>
                                <a href="<?= base_url('main/view?id=monitoring_darat'); ?>">Monitoring Layanan Jasa Air</a>
                            </li>
                            <li>
                                <a href="<?= base_url('main/master?id=darat'); ?>">Master Pengguna Jasa</a>
                            </li>
                            <li>
                                <a href="<?= base_url('main/view?id=cetak_laporan_darat'); ?>">Laporan Transaksi Air Darat</a>
                            </li>
                            <?php
                        }
                        else if ($this->session->userdata('role') == "perencanaan") {
                            ?>
                            <li>
                                <a href="<?= base_url('main/view?id=laut'); ?>">Permohonan Baru</a>
                            </li>
                            <li>
                                <a href="<?= base_url('main/master?id=laut'); ?>">Master VESSEL</a>
                            </li>
                            <li>
                                <a href="<?= base_url('main/view?id=cetak_laporan_laut'); ?>">Laporan Transaksi Air Kapal</a>
                            </li>
                            <?php
                        }
                        else if($this->session->userdata('role') == "operasi"){
                            ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url('main/view?id=cetak_laporan_darat'); ?>">Laporan Transaksi Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('main/view?id=cetak_laporan_laut'); ?>">Laporan Transaksi Air Kapal</a>
                                    </li>
                                    <!----<li><a href="<?= base_url('main/view?id=cetak_laporan_ruko'); ?>">Laporan Air Ruko</a></li>--->
                                </ul>
                            </li>
                            <li><a href="<?= base_url('main/tarif'); ?>">Penyesuaian Tarif</a></li>
                            <?php
                        }
                        else if($this->session->userdata('role') == "wtp"){
                            ?>
                            <li>
                                <a href="<?= base_url('main/view?id=transaksi_laut'); ?>">Transaksi Air Kapal</a>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Monitoring</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url('main/view?id=monitoring_darat'); ?>">Monitoring Layanan Jasa Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('main/view?id=monitoring_kapal'); ?>">Monitoring Layanan Jasa Air Kapal</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url('main/view?id=cetak_laporan_laut'); ?>">Laporan Transaksi Air Kapal</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('main/view?id=cetak_laporan_darat'); ?>">Laporan Transaksi Air Darat</a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        else if($this->session->userdata('role') == "keuangan"){
                            ?>
                            <li>
                                <a href="<?= base_url('main/view?id=validasi_pembayaran_darat'); ?>">Validasi Pembayaran Air Darat</a>
                            </li>
                            <li>
                                <a href="<?= base_url('main/view?id=cancel_pembayaran_darat'); ?>">Pembatalan Pembayaran Air Darat</a>
                            </li>
                            <li>
                                <a href="<?= base_url('main/agent'); ?>">Master Agent</a>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url('main/view?id=cetak_laporan_laut'); ?>">Laporan Transaksi Air Kapal</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('main/view?id=cetak_laporan_darat'); ?>">Laporan Transaksi Air Darat</a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            <a class="glyphicon glyphicon-log-out" href="<?= base_url('main/logout'); ?>">&nbsp;Logout</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
  <br /><br /><br />
</header>
