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
                url: "<?php echo base_url('main/laporan_darat')?>",
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
                url: "<?php echo base_url('main/laporanLaut')?>",
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
                url: "<?php echo base_url('main/laporan_ruko')?>",
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
                url: "<?php echo base_url('main/laporanDarat')?>",
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
                url: "<?php echo base_url('main/laporan_darat')?>",
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
                url: "<?php echo base_url('main/laporan_laut')?>",
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
else if($this->session->userdata('role') == "keuangan" && $this->session->userdata('session') != NULL && $tipe == "ruko"){
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
                url: "<?php echo base_url('main/laporan_ruko_keuangan')?>",
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
                url: "<?php echo base_url('main/laporanLaut')?>",
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
                url: "<?php echo base_url('main/laporanDarat')?>",
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
else if($this->session->userdata('role') == "wtp" && $this->session->userdata('session') != NULL && $tipe == "flow"){
    ?>
    <body>

    <script>
        //ambil data ketika form pencarian memiliki perubahan value
        $(window).on("load",function(){
            $('#cari').click(function(){
                search();
            });

            $('#clear').click(function () {
                $('#laporan').html('');
            });

            $('#datepicker').datepicker({
                clearBtn: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });

            $('input[type=radio][name=pilihan]').on("change", function(e) {
                e.preventDefault();
                var script = document.createElement('script');
                var php = '<?php echo site_url('main/get_nama_flow'); ?>';
                var text_date = document.createTextNode('' +
                    '$(\'#datepicker\').datepicker({\n' +
                    '    clearBtn: true,\n' +
                    '    autoclose: true,\n' +
                    '    format: "yyyy-mm-dd"\n' +
                    '});' +
                    '$(\'#cari\').click(function(){\n' +
                    '    search();\n' +
                    '});\n' +
                    '\n' +
                    '$(\'#cari_flow\').click(function(){\n' +
                    '    search_flow();\n' +
                    '});\n' +
                    '\n' +
                    '$(\'#clear\').click(function () {\n' +
                    '    $(\'#laporan\').html(\'\');\n' +
                    '});' +
                    '$(\'#id_flow\').autocomplete({\n'+
                    '     minLength:1,\n'+
                    '     delay:0,\n'+
                    '     source:"'+ php +'",\n'+
                    '     select:function(event, ui){\n'+
                    '         $(\'#id_flowmeter\').val(ui.item.id_flow);\n'+
                    '         $(\'#nama_flow\').val(ui.item.nama_flow);\n'+
                    '     }\n'+
                    '});'
                );
                script.appendChild(text_date);
                if (this.value == 'perTanggal') {
                    $("#laporan").html('');
                    $("#tabel").html('' +
                        '<tr>' +
                        '   <td>' +
                        '       <span>Tanggal Pembuatan Laporan</span>' +
                        '   </td>' +
                        '   <td>:</td>' +
                        '   <td>' +
                        '       <div class="input-group date" id="datepicker">\n' +
                        '           <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />\n' +
                        '           <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>\n' +
                        '       </div>' +
                        '   </td>' +
                        '</tr>' +
                        '<tr>' +
                        '   <td>' +
                        '       <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>\n' +
                        '   </td>' +
                        '   <td>' +
                        '       <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>' +
                        '   </td>' +
                        '</tr>'
                    );
                }
                else if (this.value == 'perFlowmeter') {
                    $("#laporan").html('');
                    $("#tabel").html('' +
                        '<tr>' +
                        '   <td>' +
                        '       <span>Tanggal Perekaman</span>' +
                        '   </td>' +
                        '   <td>:</td>' +
                        '   <td>' +
                        '       <div class="input-daterange input-group" id="datepicker">\n' +
                        '           <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>\n' +
                        '           <span class="input-group-addon">to</span>\n' +
                        '           <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />' +
                        '       </div>' +
                        '   </td>' +
                        '</tr>' +
                        '<tr>' +
                        '   <td>' +
                        '       <span>ID Flow Meter</span>' +
                        '   </td>' +
                        '   <td>:</td>' +
                        '   <td>' +
                        '       <input type="text" class="form-control" id="id_flow" name="id_flow" placeholder="Masukkan ID Flow Meter"/>' +
                        '       <input type="hidden" class="form-control" id="id_flowmeter" name="id_flowmeter" />' +
                        '   </td>' +
                        '</tr>' +
                        '<tr>' +
                        '   <td>' +
                        '       <span>Nama Flow Meter</span>' +
                        '   </td>' +
                        '   <td>:</td>' +
                        '   <td>' +
                        '       <input type="text" disabled class="form-control" id="nama_flow"/>' +
                        '   </td>' +
                        '</tr>' +
                        '<tr>' +
                        '   <td>' +
                        '       <a class="btn btn-primary" id="cari_flow" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>\n' +
                        '   </td>' +
                        '   <td>' +
                        '       <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>' +
                        '   </td>' +
                        '</tr>'
                    );
                }
                $("#tabel").append(script);
            });
        });

        function search_flow() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var id_flow = $('#id_flowmeter').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?php echo base_url('main/laporan_per_flow')?>",
                method: "POST",
                data: {
                    id_flow : id_flow,
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

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?php echo base_url('main/laporan_flow')?>",
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
        <h3>Laporan Pencatatan Flow Meter</h3><br>
        <div class="row col-sm-6">
            <div class="row col-sm-6">
                <table class="table">
                    <tr>
                        <td>
                            <label class="radio-inline"><input type="radio" name="pilihan" id="perTanggal" checked="checked" value="perTanggal">Per Tanggal</label>
                        </td>
                        <td>
                            <label class="radio-inline"><input type="radio" name="pilihan" id="perFlowmeter" value="perFlowmeter">Per Flow Meter</label>
                        </td>
                    </tr>
                </table>
            </div>
            <table class="table table-responsive table-condensed" id="tabel">
                <tr>
                    <td>
                        <span>Tanggal Pembuatan Laporan</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-group date" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
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
else if($this->session->userdata('role') == "wtp" && $this->session->userdata('session') != NULL && $tipe == "sumur"){
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
                url: "<?php echo base_url('main/laporan_sumur')?>",
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
        <h3>Pembuatan Laporan Pencatatan Sumur</h3><br><br>
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
                url: "<?php echo base_url('main/laporanLaut')?>",
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
    window.location.replace('<?php echo $web?>');
</script>
<?php
}
?>