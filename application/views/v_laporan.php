<?php
if($this->session->userdata('role') == "operasi" && $this->session->userdata('session') != NULL && $tipe == "darat" ){
?>
    <body>
    <script>
        //ambil data ketika form pencarian memiliki perubahan value
        $(document).ready(function(){
            $("#cari").click(function(){
                search();
            });
            $("#clear").click(function () {
                $("#laporan").html('');
            })
        });

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?= base_url('main/laporan_darat')?>",
                method: "POST",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir
                },
                dataType: 'json',
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    if (response.status == "success") {
                        $("#laporan").html(response.tabel);
                    } else {
                        alert('Data Tidak Ditemukan');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
    <script>
        var myVar = setInterval(showNotifRealisasi, 3000);

        function showNotifRealisasi() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText != "0"){
                        document.getElementById("notifKapal").innerHTML = "<a class='btn btn-danger' title='Realisasi Pembayaran' href='<?= base_url("main")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                    }
                }
            };
            xmlhttp.open("GET", "<?php echo base_url('main/cekNotifBayar') ?>" , true);
            xmlhttp.send();
        }
    </script>
    <div class="topright" align="right">
        <span id="notifKapal" ></span>
    </div>
    <div class="container container-fluid">
        <h3>Pembuatan Laporan Pelayanan Air Untuk Rumah Tangga Dan Perusahaan</h3><br><br>
        <div class="row col-sm-6">
            <table class="table table-responsive table-condensed">
                <tr>
                    <td>
                        <span>Tanggal Pembuatan Laporan</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datepicker').datepicker({
                                    clearBtn: true,
                                    autoclose: true,
                                    format: "yyyy-mm-dd"
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row col-sm-10">
            <div id="laporan"></div>
        </div>
    </div>
    </body>
    <?php
}
else if($this->session->userdata('role') == "operasi" && $this->session->userdata('session') != NULL && $tipe == "laut"){
    ?>
    <body>
    <script>
        //ambil data ketika form pencarian memiliki perubahan value
        $(document).ready(function(){
            $("#cari").click(function(){
                search();
            });
            $("#clear").click(function () {
                $("#laporan").html('');
            })
        });

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?= base_url('main/laporan_laut')?>",
                method: "POST",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir
                },
                dataType: 'json',
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    if (response.status == "success") {
                        $("#laporan").html(response.tabel);
                    } else {
                        alert('Data Tidak Ditemukan');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
    <script>
        var myVar = setInterval(showNotifRealisasi, 3000);

        function showNotifRealisasi() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText != "0"){
                        document.getElementById("notifKapal").innerHTML = "<a class='btn btn-danger' title='Realisasi Pembayaran' href='<?= base_url("main")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                    }
                }
            };
            xmlhttp.open("GET", "<?php echo base_url('main/cekNotifBayar') ?>" , true);
            xmlhttp.send();
        }
    </script>
    <div class="topright" align="right">
        <span id="notifKapal" ></span>
    </div>
    <div class="container container-fluid">
        <h3>Pembuatan Laporan Pelayanan Air Untuk Kapal</h3><br><br>
        <div class="row col-sm-6">
            <table class="table table-responsive table-condensed">
                <tr>
                    <td>
                        <span>Tanggal Pembuatan Laporan</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datepicker').datepicker({
                                    clearBtn: true,
                                    autoclose: true,
                                    format: "yyyy-mm-dd"
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row col-sm-10">
            <div id="laporan"></div>
        </div>
    </div>
    </body>
<?php
}
else if($this->session->userdata('role') == "operasi" && $this->session->userdata('session') != NULL && $tipe == "ruko"){
?>
    <body>
    <script>
        //ambil data ketika form pencarian memiliki perubahan value
        $(document).ready(function(){
            $("#cari").click(function(){
                search();
            });
            $("#clear").click(function () {
                $("#laporan").html('');
            })
        });

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?= base_url('main/laporan_ruko')?>",
                method: "POST",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir
                },
                dataType: 'json',
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    if (response.status == "success") {
                        $("#laporan").html(response.tabel);
                    } else {
                        alert('Data Tidak Ditemukan');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
    <div class="container container-fluid">
        <h3>Pembuatan Laporan Pelayanan Air Untuk Ruko</h3><br><br>
        <div class="row col-sm-6">
            <table class="table table-responsive table-condensed">
                <tr>
                    <td>
                        <span>Tanggal Pembuatan Laporan</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datepicker').datepicker({
                                    clearBtn: true,
                                    autoclose: true,
                                    format: "yyyy-mm-dd"
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row col-sm-10">
            <div id="laporan"></div>
        </div>
    </div>
    </body>
<?php
}
else if($this->session->userdata('role') == "loket" && $this->session->userdata('session') != NULL && $tipe == "darat"){
?>
    <body>
    <script>
        //ambil data ketika form pencarian memiliki perubahan value
        $(document).ready(function(){
            $("#cari").click(function(){
                search();
            });
            $("#clear").click(function () {
                $("#laporan").html('');
            })
        });

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?= base_url('main/laporanDarat')?>",
                method: "POST",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir
                },
                dataType: 'json',
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    if (response.status == "success") {
                        $("#laporan").html(response.tabel);
                    } else {
                        alert('Data Tidak Ditemukan');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
    <script>
        var myVar = setInterval(showNotifAntar, 3000);

        function showNotifAntar() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText != "0")
                        document.getElementById("notifAntar").innerHTML = "<a class='btn btn-danger' title='Antar' href='<?= base_url("main/view?id=monitoring_darat")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                }
            };
            xmlhttp.open("GET", "<?php echo base_url('main/cekNotifAntar') ?>" , true);
            xmlhttp.send();
        }
    </script>
    <div class="topright" align="right">
        <span id="notifAntar" ></span>
    </div>
    <div class="container container-fluid">
        <h3>Pembuatan Laporan Pelayanan Air Untuk Rumah Tangga Dan Perusahaan</h3><br><br>
        <div class="row col-sm-6">
            <table class="table table-responsive table-condensed">
                <tr>
                    <td>
                        <span>Tanggal Pembuatan Laporan</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datepicker').datepicker({
                                    clearBtn: true,
                                    autoclose: true,
                                    format: "yyyy-mm-dd"
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row col-sm-10">
            <div id="laporan"></div>
        </div>
    </div>
    </body>
<?php
}
else if($this->session->userdata('role') == "keuangan" && $this->session->userdata('session') != NULL && $tipe == "darat"){
    ?>
    <body>
    <script>
        //ambil data ketika form pencarian memiliki perubahan value
        $(document).ready(function(){
            $("#cari").click(function(){
                search();
            });
            $("#clear").click(function () {
                $("#laporan").html('');
            })
        });

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?= base_url('main/laporan_darat')?>",
                method: "POST",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir
                },
                dataType: 'json',
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    if (response.status == "success") {
                        $("#laporan").html(response.tabel);
                    } else {
                        alert('Data Tidak Ditemukan');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
    <script>
        var myVar = setInterval(showNotifAntar, 3000);

        function showNotifAntar() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText != "0")
                        document.getElementById("notifAntar").innerHTML = "<a class='btn btn-danger' title='Realisasi Piutang' href='<?= base_url("main")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                }
            };
            xmlhttp.open("GET", "<?php echo base_url('main/cekNotifBayar') ?>" , true);
            xmlhttp.send();
        }
    </script>
    <div class="topright" align="right">
        <span id="notifAntar" ></span>
    </div>
    <div class="container container-fluid">
        <h3>Pembuatan Laporan Pelayanan Air Untuk Rumah Tangga Dan Perusahaan</h3><br><br>
        <div class="row col-sm-6">
            <table class="table table-responsive table-condensed">
                <tr>
                    <td>
                        <span>Tanggal Pembuatan Laporan</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datepicker').datepicker({
                                    clearBtn: true,
                                    autoclose: true,
                                    format: "yyyy-mm-dd"
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row col-sm-10">
            <div id="laporan"></div>
        </div>
    </div>
    </body>
    <?php
}
else if($this->session->userdata('role') == "keuangan" && $this->session->userdata('session') != NULL && $tipe == "laut"){
    ?>
    <body>
    <script>
        //ambil data ketika form pencarian memiliki perubahan value
        $(document).ready(function(){
            $("#cari").click(function(){
                search();
            });
            $("#clear").click(function () {
                $("#laporan").html('');
            })
        });

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?= base_url('main/laporan_laut')?>",
                method: "POST",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir
                },
                dataType: 'json',
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    if (response.status == "success") {
                        $("#laporan").html(response.tabel);
                    } else {
                        alert('Data Tidak Ditemukan');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
    <script>
        var myVar = setInterval(showNotifRealisasi, 3000);

        function showNotifRealisasi() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText != "0"){
                        document.getElementById("notifKapal").innerHTML = "<a class='btn btn-danger' title='Realisasi Pembayaran' href='<?= base_url("main")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                    }
                }
            };
            xmlhttp.open("GET", "<?php echo base_url('main/cekNotifBayar') ?>" , true);
            xmlhttp.send();
        }
    </script>
    <div class="topright" align="right">
        <span id="notifKapal" ></span>
    </div>
    <div class="container container-fluid">
        <h3>Pembuatan Laporan Pelayanan Air Untuk Kapal</h3><br><br>
        <div class="row col-sm-6">
            <table class="table table-responsive table-condensed">
                <tr>
                    <td>
                        <span>Tanggal Pembuatan Laporan</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datepicker').datepicker({
                                    clearBtn: true,
                                    autoclose: true,
                                    format: "yyyy-mm-dd"
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row col-sm-10">
            <div id="laporan"></div>
        </div>
    </div>
    </body>
    <?php
}
else if($this->session->userdata('role') == "wtp" && $this->session->userdata('session') != NULL && $tipe == "laut"){
?>
    <script>
        //ambil data ketika form pencarian memiliki perubahan value
        $(document).ready(function(){
            $("#cari").click(function(){
                search();
            });
            $("#clear").click(function () {
                $("#laporan").html('');
            })
        });

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?= base_url('main/laporan_laut')?>",
                method: "POST",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir
                },
                dataType: 'json',
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    if (response.status == "success") {
                        $("#laporan").html(response.tabel);
                    } else {
                        alert('Data Tidak Ditemukan');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
    <script>
        var myVar = setInterval(showNotifTransaksiKapal, 3000);
        var myVar2 = setInterval(showNotifTransaksiDarat, 3000);

        function showNotifTransaksiKapal() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText != "0")
                        document.getElementById("notifKapal").innerHTML = "<a class='btn btn-danger' title='Kapal' href='<?= base_url("main/view?id=transaksi_laut")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
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
                        document.getElementById("notifDarat").innerHTML = "<a class='btn btn-danger' title='Darat' href='<?= base_url("main")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
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
    <div class="container container-fluid">
        <h3>Pembuatan Laporan Pelayanan Air Untuk Kapal</h3><br><br>
        <div class="row col-sm-6">
            <table class="table table-responsive table-condensed">
                <tr>
                    <td>
                        <span>Tanggal Pembuatan Laporan</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datepicker').datepicker({
                                    clearBtn: true,
                                    autoclose: true,
                                    format: "yyyy-mm-dd"
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row col-sm-10">
            <div id="laporan"></div>
        </div>
    </div>
    </body>
<?php
}
else if($this->session->userdata('role') == "wtp" && $this->session->userdata('session') != NULL && $tipe == "darat"){
    ?>
    <body>
    <script>
        //ambil data ketika form pencarian memiliki perubahan value
        $(document).ready(function(){
            $("#cari").click(function(){
                search();
            });
            $("#clear").click(function () {
                $("#laporan").html('');
            })
        });

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?= base_url('main/laporanDarat')?>",
                method: "POST",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir
                },
                dataType: 'json',
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    if (response.status == "success") {
                        $("#laporan").html(response.tabel);
                    } else {
                        alert('Data Tidak Ditemukan');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
    <script>
        var myVar = setInterval(showNotifTransaksiKapal, 3000);
        var myVar2 = setInterval(showNotifTransaksiDarat, 3000);

        function showNotifTransaksiKapal() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText != "0")
                        document.getElementById("notifKapal").innerHTML = "<a class='btn btn-danger' title='Kapal' href='<?= base_url("main/view?id=transaksi_laut")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
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
                        document.getElementById("notifDarat").innerHTML = "<a class='btn btn-danger' title='Darat' href='<?= base_url("main")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
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
    <div class="container container-fluid">
        <h3>Pembuatan Laporan Pelayanan Air Untuk Rumah Tangga Dan Perusahaan</h3><br><br>
        <div class="row col-sm-6">
            <table class="table table-responsive table-condensed">
                <tr>
                    <td>
                        <span>Tanggal Pembuatan Laporan</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datepicker').datepicker({
                                    clearBtn: true,
                                    autoclose: true,
                                    format: "yyyy-mm-dd"
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row col-sm-10">
            <div id="laporan"></div>
        </div>
    </div>
    </body>
    <?php
}
else if($this->session->userdata('role') == "perencanaan" && $this->session->userdata('session') != NULL && $tipe == "laut"){
    ?>
    <script>
        //ambil data ketika form pencarian memiliki perubahan value
        $(document).ready(function(){
            $("#cari").click(function(){
                search();
            });
            $("#clear").click(function () {
                $("#laporan").html('');
            })
        });

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?= base_url('main/laporan_laut')?>",
                method: "POST",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir
                },
                dataType: 'json',
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    if (response.status == "success") {
                        $("#laporan").html(response.tabel);
                    } else {
                        alert('Data Tidak Ditemukan');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
    <script>
        var myVar = setInterval(showNotifTransaksiKapal, 3000);
        var myVar2 = setInterval(showNotifTransaksiDarat, 3000);

        function showNotifTransaksiKapal() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if(xmlhttp.responseText != "0")
                        document.getElementById("notifAntar").innerHTML = "<a class='btn btn-danger' title='Realisasi Pengisisan' href='<?= base_url("main")?>'><span class='glyphicon glyphicon-refresh'> " + xmlhttp.responseText + "</a>";
                }
            };
            xmlhttp.open("GET", "<?php echo base_url('main/cekNotifRealisasi') ?>" , true);
            xmlhttp.send();
        }
    </script>
    <div class="topright" align="right">
        <span id="notifAntar" ></span>
    </div>
    <div class="container container-fluid">
        <h3>Pembuatan Laporan Pelayanan Air Untuk Kapal</h3><br><br>
        <div class="row col-sm-6">
            <table class="table table-responsive table-condensed">
                <tr>
                    <td>
                        <span>Tanggal Pembuatan Laporan</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datepicker').datepicker({
                                    clearBtn: true,
                                    autoclose: true,
                                    format: "yyyy-mm-dd"
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row col-sm-10">
            <div id="laporan"></div>
        </div>
    </div>
    </body>
    <?php
}
else {
$web = base_url('main');
?>
<script>
    alert('Maaf Anda Tidak Mempunyai Hak Akses Ke Halaman Ini. Silahkan Login Terlebih Dahulu');
    window.location.replace('<?= $web?>');
</script>
<?php
}
?>