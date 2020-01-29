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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css')?>" >
    <link rel="stylesheet" href="<?php echo base_url()?>/assets/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>/assets/sweetalert2/dist/sweetalert2.min.css">

    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/moment.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/transition.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/collapse.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datetimepicker.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-clockpicker.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.form.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/id.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url()?>/assets/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url()?>/assets/loadingoverlay/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url()?>/assets/sweetalert2/dist/sweetalert2.min.js"></script>

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

        .select2-container {
            width: 100% !important;
            padding: 0;
        }
    </style>
</head>
<header>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
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
                        if($this->session->status == 'TRUE'){
                    ?>
                    <?php
                        $role = $this->session->role;
                        $queryMenu = "SELECT * 
                                    FROM `vw_user_access_menu`
                                    WHERE `parent_id` = 0 && `is_active` = 1 AND `id_role` = $role
                                    ORDER BY menu_id ASC";
                        $menu = $this->db->query($queryMenu)->result_array();
                    ?>
                    <?php foreach($menu as $m) : ?>
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $m['title']?><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                        <?php
                            $role = $this->session->role;
                            $menuID = $m['menu_id'];
                            $querySubMenu = "SELECT `url`,`second_uri`,`title`,`parent_id` 
                                            FROM `vw_user_access_menu`
                                            WHERE `parent_id` = $menuID && `is_active` = 1 AND `id_role` = $role
                                            ORDER BY parent_id DESC";
                            $subMenu = $this->db->query($querySubMenu)->result_array();                    
                        ?>
                            <?php foreach($subMenu as $sm) :?>
                                <li><a href="<?php echo site_url('main/'.$sm['url']);?>"><?php echo $sm['title']?></a></li>
                            <?php endforeach;?>
                        </ul>
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <a href="<?php echo base_url('admin/logout'); ?>">Log Out</a>
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
    if($this->session->userdata('role_name') == 'loket'){
    ?>
        <script>
            var myVar = setInterval(showNotifAntar, 3000);

            function showNotifAntar() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifAntar").innerHTML = "<a class='btn btn-danger' title='Antar' href='<?php echo base_url("main/monitoring/monitoring_air_darat")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
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
    else if($this->session->userdata('role_name') == 'keuangan'){
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
    else if($this->session->userdata('role_name') == 'perencanaan'){
    ?>
        <script>
            var myVar = setInterval(showNotifTransaksiKapal, 3000);

            function showNotifTransaksiKapal() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifAntar").innerHTML = "<a class='btn btn-danger' title='Realisasi Pengisisan' href='<?php echo base_url("main/monitoring/permintaan_air_kapal")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
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
    else if($this->session->userdata('role_name') == 'wtp'){
    ?>
        <script>
            var myVar = setInterval(showNotifTransaksiKapal, 3000);
            var myVar2 = setInterval(showNotifTransaksiDarat, 3000);

            function showNotifTransaksiKapal() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if(xmlhttp.responseText != "0")
                            document.getElementById("notifKapal").innerHTML = "<a class='btn btn-danger' title='Kapal' href='<?php echo base_url("main/monitoring/")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
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
                            document.getElementById("notifDarat").innerHTML = "<a class='btn btn-danger' title='Darat' href='<?php echo base_url("main/monitoring/pengantaran_air_darat")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
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
    else if($this->session->userdata('role_name') == 'operasi'){
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
