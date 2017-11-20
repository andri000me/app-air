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
                        <a href="<?php echo base_url('main'); ?>">Beranda</a>
                    </li>
                    <?php
                    if($this->session->userdata('role') != NULL) {
                        if ($this->session->userdata('role') == "loket") {
                            ?>
                            <li>
                                <a href="<?php echo base_url('main/view?id=darat'); ?>">Transaksi Baru</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('main/view?id=monitoring_darat'); ?>">Monitoring Layanan Jasa Air</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('main/master?id=darat'); ?>">Master Pengguna Jasa</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('main/view?id=cetak_laporan_darat'); ?>">Laporan Transaksi Air Darat</a>
                            </li>
                            <?php
                        }
                        else if ($this->session->userdata('role') == "perencanaan") {
                            ?>
                            <li>
                                <a href="<?php echo base_url('main/view?id=laut'); ?>">Permohonan Baru</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('main/master?id=laut'); ?>">Master VESSEL</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('main/view?id=cetak_laporan_laut'); ?>">Laporan Transaksi Air Kapal</a>
                            </li>
                            <?php
                        }
                        else if($this->session->userdata('role') == "operasi"){
                            ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_darat'); ?>">Laporan Transaksi Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_laut'); ?>">Laporan Transaksi Air Kapal</a>
                                    </li>
                                    <li><a href="<?php echo base_url('main/view?id=cetak_laporan_ruko'); ?>">Laporan Air Ruko</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo base_url('main/tarif'); ?>">Penyesuaian Tarif</a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tenant</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=lumpsum'); ?>">Master Lumpsum</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=tagihan'); ?>">Penagihan Ruko</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=daftar_tagihan'); ?>">Daftar Tagihan</a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        else if($this->session->userdata('role') == "wtp"){
                            ?>
                            <li>
                                <a href="<?php echo base_url('main/view?id=transaksi_laut'); ?>">Transaksi Air Kapal</a>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Monitoring</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=monitoring_darat'); ?>">Monitoring Layanan Jasa Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=monitoring_kapal'); ?>">Monitoring Layanan Jasa Air Kapal</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_laut'); ?>">Laporan Transaksi Air Kapal</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_darat'); ?>">Laporan Transaksi Air Darat</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_flow'); ?>">Laporan Pencatatan Flow Meter</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_sumur'); ?>">Laporan Pencatatan Sumur</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Flow Meter</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=flowmeter'); ?>">Master Flow Meter</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=transaksi_tenant'); ?>">Pencatatan Harian Penggunaan Air</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=riwayat_pencatatan_flow'); ?>">Riwayat Pencatatan Harian Penggunaan Air</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Sumur</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=pompa'); ?>">Master Pompa</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=catat_sumur'); ?>">Pencatatan Harian Sumur</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=riwayat_pencatatan_sumur'); ?>">Riwayat Pencatatan Harian Sumur</a>
                                    </li>
                                </ul>
                            </li>

                            <?php
                        }
                        else if($this->session->userdata('role') == "keuangan"){
                            ?>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Pembayaran</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href='<?php echo base_url('main/view?id=realisasi_pembayaran_darat'); ?>'>Realisasi Pembayaran Air Darat</a>
                                    </li>
                                    <li>
                                        <a href='<?php echo base_url('main/view?id=validasi_pembayaran_darat'); ?>'>Validasi Pembayaran Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cancel_pembayaran_darat'); ?>">Pembatalan Pembayaran Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=realisasi_pembayaran_tenant'); ?>">Realisasi Pembayaran Air Tenant</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo base_url('main/agent'); ?>">Master Agent</a>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_laut'); ?>">Laporan Transaksi Air Kapal</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_darat'); ?>">Laporan Transaksi Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_ruko'); ?>">Laporan Transaksi Air Ruko</a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        else{
                            ?>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Menu Loket</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=main_loket'); ?>">Daftar Permohonan Pelayanan</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=darat'); ?>">Transaksi Baru</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=monitoring_darat'); ?>">Monitoring Layanan Jasa Air</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Menu Keuangan</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=main_keuangan'); ?>">Realisasi Pembayaran Jasa Air Kapal</a>
                                    </li>
                                    <li>
                                        <a href='<?php echo base_url('main/view?id=realisasi_pembayaran_darat'); ?>'>Realisasi Pembayaran Air Darat</a>
                                    </li>
                                    <li>
                                        <a href='<?php echo base_url('main/view?id=validasi_pembayaran_darat'); ?>'>Validasi Pembayaran Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cancel_pembayaran_darat'); ?>">Pembatalan Pembayaran Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=realisasi_pembayaran_tenant'); ?>">Realisasi Pembayaran Air Tenant</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Menu WTP</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=main_wtp'); ?>">Transaksi Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=transaksi_laut'); ?>">Transaksi Air Kapal</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=monitoring_darat'); ?>">Monitoring Layanan Jasa Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=monitoring_kapal'); ?>">Monitoring Layanan Jasa Air Kapal</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=transaksi_tenant'); ?>">Pencatatan Harian Penggunaan Air</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=riwayat_pencatatan_flow'); ?>">Riwayat Pencatatan Harian Penggunaan Air</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=catat_sumur'); ?>">Pencatatan Harian Sumur</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=riwayat_pencatatan_sumur'); ?>">Riwayat Pencatatan Harian Sumur</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Menu Operasi</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=main_operasi'); ?>">Daftar Tagihan Air Kapal</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/tarif'); ?>">Penyesuaian Tarif</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=tagihan'); ?>">Penagihan Ruko</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=daftar_tagihan'); ?>">Daftar Tagihan</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Menu Perencanaan</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=main_perencanaan'); ?>">Daftar Pelayanan Jasa Air Kapal</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=laut'); ?>">Permohonan Baru</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_laut'); ?>">Laporan Transaksi Air Kapal</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_darat'); ?>">Laporan Transaksi Air Darat</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_flow'); ?>">Laporan Pencatatan Flow Meter</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_sumur'); ?>">Laporan Pencatatan Sumur</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=cetak_laporan_ruko'); ?>">Laporan Air Ruko</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Master Data</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=sumur'); ?>">Master Sumur</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=pompa'); ?>">Master Pompa</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=flowmeter'); ?>">Master Flow Meter</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/master?id=darat'); ?>">Master Pengguna Jasa</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/master?id=laut'); ?>">Master VESSEL</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/agent'); ?>">Master Agent</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=tenant'); ?>">Master Tenant</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('main/view?id=lumpsum'); ?>">Master Lumpsum</a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            <a class="glyphicon glyphicon-log-out" href="<?php echo base_url('main/logout'); ?>">&nbsp;Logout</a>
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
    <?php
    if($this->session->userdata('role') == 'loket'){
    ?>
        <script>
            var myVar = setInterval(showNotifAntar, 3000);

            function showNotifAntar() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifAntar").innerHTML = "<a class='btn btn-danger' title='Antar' href='<?php echo base_url("main/view?id=monitoring_darat")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                        else
                            document.getElementById("notifAntar").innerHTML = '';
                    }
                };
                xmlhttp.open("GET", "<?php echo base_url('main/cekNotifAntar') ?>" , true);
                xmlhttp.send();
            }
        </script>
        <div class="topright" align="right">
            <span id="notifAntar" ></span>
        </div>
        <?php
    }
    else if($this->session->userdata('role') == 'keuangan'){
    ?>
        <script>
            var myVar = setInterval(showNotifTransaksiKapal, 3000);
            var myVar2 = setInterval(showNotifTransaksiDarat, 3000);
            var myVar3 = setInterval(showNotifBayarRuko, 3000);

            function showNotifTransaksiKapal() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifKapal").innerHTML = "<a class='btn btn-danger' title='Realisasi Piutang Kapal' href='<?php echo base_url("main")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                        else
                            document.getElementById("notifKapal").innerHTML = '';
                    }
                };
                xmlhttp.open("GET", "<?php echo base_url('main/cekNotifBayar') ?>" , true);
                xmlhttp.send();
            }

            function showNotifTransaksiDarat() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifDarat").innerHTML = "<a class='btn btn-danger' title='Realisasi Piutang Darat' href='<?php echo base_url("main/view?id=realisasi_pembayaran_darat")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                        else
                            document.getElementById("notifDarat").innerHTML = '';
                    }
                };
                xmlhttp.open("GET", "<?php echo base_url('main/cekNotifBayarDarat') ?>" , true);
                xmlhttp.send();
            }
            function showNotifBayarRuko() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifRuko").innerHTML = "<a class='btn btn-danger' title='Realisasi Pembayaran Ruko' href='<?php echo base_url("main/view?id=realisasi_pembayaran_tenant")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                        else
                            document.getElementById("notifRuko").innerHTML = '';
                    }
                };
                xmlhttp.open("GET", "<?php echo base_url('main/cekNotifBayarRuko') ?>" , true);
                xmlhttp.send();
            }
        </script>
        <div class="topright" align="right">
            <span id="notifKapal" ></span>
            <span id="notifDarat" ></span>
            <span id="notifRuko" ></span>
        </div>
    <?php
    }
    else if($this->session->userdata('role') == 'perencanaan'){
    ?>
        <script>
            var myVar = setInterval(showNotifTransaksiKapal, 3000);

            function showNotifTransaksiKapal() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifAntar").innerHTML = "<a class='btn btn-danger' title='Realisasi Pengisisan' href='<?php echo base_url("main")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                        else
                            document.getElementById("notifAntar").innerHTML ='';
                    }
                };
                xmlhttp.open("GET", "<?php echo base_url('main/cekNotifRealisasi') ?>" , true);
                xmlhttp.send();
            }
        </script>
        <div class="topright" align="right">
            <span id="notifAntar" ></span>
        </div>
        <?php
    }
    else if($this->session->userdata('role') == 'wtp'){
    ?>
        <script>
            var myVar = setInterval(showNotifTransaksiKapal, 3000);
            var myVar2 = setInterval(showNotifTransaksiDarat, 3000);

            function showNotifTransaksiKapal() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifKapal").innerHTML = "<a class='btn btn-danger' title='Kapal' href='<?php echo base_url("main/view?id=transaksi_laut")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                        else
                            document.getElementById("notifKapal").innerHTML = '';
                    }
                };
                xmlhttp.open("GET", "<?php echo base_url('main/cekNotifKapal') ?>" , true);
                xmlhttp.send();
            }

            function showNotifTransaksiDarat() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifDarat").innerHTML = "<a class='btn btn-danger' title='Darat' href='<?php echo base_url("main")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                        else
                            document.getElementById("notifDarat").innerHTML = '';
                    }
                };
                xmlhttp.open("GET", "<?php echo base_url('main/cekNotifDarat') ?>" , true);
                xmlhttp.send();
            }
        </script>
        <div class="topright" align="right">
            <span id="notifKapal" ></span>
            <span id="notifDarat" ></span>
        </div>
    <?php
    }
    else if($this->session->userdata('role') == 'operasi'){
        ?>
        <script>
            var myVar = setInterval(showNotifRealisasi, 3000);
            var myVar1 = setInterval(showNotifBayarRuko, 3000);

            function showNotifRealisasi() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifKapal").innerHTML = "<a class='btn btn-danger' title='Realisasi Pembayaran Kapal' href='<?php echo base_url("main")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                        else
                            document.getElementById("notifKapal").innerHTML = '';
                    }
                };
                xmlhttp.open("GET", "<?php echo base_url('main/cekNotifBayar') ?>" , true);
                xmlhttp.send();
            }
            function showNotifBayarRuko() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifRuko").innerHTML = "<a class='btn btn-danger' title='Realisasi Pembayaran Ruko' href='<?php echo base_url("main/view?id=daftar_tagihan")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                        else
                            document.getElementById("notifRuko").innerHTML = '';
                    }
                };
                xmlhttp.open("GET", "<?php echo base_url('main/cekNotifBayarRuko') ?>" , true);
                xmlhttp.send();
            }
        </script>
        <div class="topright" align="right">
            <span id="notifKapal" ></span>
            <span id="notifRuko" ></span>
        </div>
    <?php
    }
    else {

    }
    ?>
</header>
