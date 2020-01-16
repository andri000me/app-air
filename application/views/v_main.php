<body>
<?php
if($this->session->userdata('role') == "loket" && ($this->session->userdata('sesi') != NULL || $this->session->userdata('sesi') != '')){
?>
<div class="container container-fluid">
    <div class="row">
        <script type="text/javascript">
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        myArr = JSON.parse(this.responseText);

                        var i=0;
                        var a = "<thead>" +
                            "<tr>" +
                            "<th><center>No</center></th>" +
                            "<th><center>Nama Perusahaan / Pemohon</center></th>" +
                            "<th><center>Waktu Permohonan</center></th>" +
                            "<th><center>Waktu Pelayanan</center></th>" +
                            "<th><center>Jenis</center></th>" +
                            "<th><center>Tarif (Rp.)</center></th>" +
                            "<th><center>Vol (Ton)</center></th>" +
                            "<th><center>Jumlah Bayar (Rp.)<center></th>" +
                            "<th><center>Aksi</center></th>" +
                            "</tr>" +
                            "</thead>" +
                            "<tbody>";
                        while (i < myArr.length) {
                            if(myArr[i]["color"] != null){
                                a +="<tr style='background-color:"+myArr[i]["color"]+"'>" +
                                    "<td align='center'>"+myArr[i]["no"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["nama"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tgl_transaksi"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tgl_permintaan"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["jenis"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tarif"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["total_pengisian"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["total_pembayaran"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["aksi"]+"</td>" +
                                    "</tr>";
                                i++;
                            } else {
                                a +="<tr>" +
                                    "<td align='center'>"+myArr[i]["no"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["nama"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tgl_transaksi"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tgl_permintaan"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["jenis"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tarif"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["total_pengisian"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["total_pembayaran"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["aksi"]+"</td>" +
                                    "</tr>";
                                i++;
                            }
                        }
                        a +="</tbody>" +
                            "<tfoot>" +
                            "<tr>" +
                            "<th><center>No</center></th>" +
                            "<th><center>Nama Perusahaan / Pemohon</center></th>" +
                            "<th><center>Waktu Permohonan</center></th>" +
                            "<th><center>Waktu Pelayanan</center></th>" +
                            "<th><center>Jenis</center></th>" +
                            "<th><center>Tarif (Rp.)</center></th>" +
                            "<th><center>Vol (Ton)</center></th>" +
                            "<th><center>Jumlah Bayar (Rp.)<center></th>" +
                            "<th><center>Aksi</center></th>" +
                            "</tr>" +
                            "</tfoot>";
                        document.getElementById("table").innerHTML= a;
                    }
                }
                xmlhttp.open("GET", "<?php echo base_url("main/tabel_pembayaran?id=darat")?>", true);
                xmlhttp.send();
        </script>
        <body>
        <div class="container container-fluid">
            <div class="row">
                <center><h4>Daftar Permohonan Pelayanan Jasa Pengisian Air Bersih</h4></center><br>
                <table class="table table-responsive table-bordered table-striped" id="table"></table>
            </div>
        </div>
        </body>
        <script>
            function batal(id){
                var url;
                var id = id;
                url = "<?php echo site_url('main/cancelTransaksiDarat')?>";
                if (confirm('Batalkan Transaksi ?')) {
                    $.ajax({
                        url : url,
                        type: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            alert('Transaksi Sudah Dibatalkan');
                            window.location.replace('<?php echo base_url('main');?>');
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Gagal Mengupdate Data'+" "+textStatus+" "+errorThrown);
                        }
                    });
                }
            }
        </script>
        <script>
            function cancel_kwitansi(id){
                var url;
                var id = id;
                url = "<?php echo site_url('main/cancelKwitansi')?>";
                if (confirm('Batalkan Kwitansi ?')) {
                    $.ajax({
                        url : url,
                        type: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            alert('Kwitansi Sudah Dibatalkan');
                            window.location.replace('<?php echo base_url('main');?>');
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Gagal Mengupdate Data'+" "+textStatus+" "+errorThrown);
                        }
                    });
                }
            }
        </script>
    </div>
</div>
<?php
}
else if($this->session->userdata('role') == "wtp" && ($this->session->userdata('sesi') != NULL || $this->session->userdata('sesi') != '')){
?>
    <script type="text/javascript">
        //function getData(){
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    myArr = JSON.parse(this.responseText);

                    var i = 0;
                    var a = "<thead>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>Nama Pengguna Jasa</center></th>" +
                        "<th><center>Alamat</center></th>" +
                        "<th><center>No Telepon</center></th>" +
                        "<th><center>Waktu Transaksi</center></th>" +
                        "<th><center>Waktu Permintaan Pengantaran</center></th>" +
                        "<th><center>Total Pengisian (Ton)</center></th>" +
                        "<th><center>Status Pengantaran<center></th>" +
                        "<th><center>Aksi</center></th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>";
                    while (i < myArr.length) {
                        a +="<tr>" +
                            "<td align='center'>"+myArr[i]["no"]+"</td>" +
                            "<td align='center'>"+myArr[i]["nama"]+"</td>" +
                            "<td align='center'>"+myArr[i]["alamat"]+"</td>" +
                            "<td align='center'>"+myArr[i]["no_telp"]+"</td>" +
                            "<td align='center'>"+myArr[i]["tanggal"]+"</td>" +
                            "<td align='center'>"+myArr[i]["tanggal_permintaan"]+"</td>" +
                            "<td align='center'>"+myArr[i]["total_pengisian"]+"</td>" +
                            "<td align='center'>"+myArr[i]["status_pengantaran"]+"</td>" +
                            "<td align='center'>"+myArr[i]["aksi"]+"</td>" +
                            "</tr>";
                        i++;
                    }
                    a +="</tbody>" +
                        "<tfoot>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>Nama Pengguna Jasa</center></th>" +
                        "<th><center>Alamat</center></th>" +
                        "<th><center>No Telepon</center></th>" +
                        "<th><center>Waktu Transaksi</center></th>" +
                        "<th><center>Waktu Permintaan Pengantaran</center></th>" +
                        "<th><center>Total Pengisian (Ton)</center></th>" +
                        "<th><center>Status Pengantaran<center></th>" +
                        "<th><center>Aksi</center></th>" +
                        "</tr>" +
                        "</tfoot>";
                    document.getElementById("table").innerHTML= a;
                }
            }
            xmlhttp.open("GET", "<?php echo base_url("main/tabel_pengantaran?id=darat")?>", true);
            xmlhttp.send();
        //}

        //setInterval(getData, 4000);
    </script>
    <body>
    <div class="container container-fluid">
        <div class="row">
            <center><h4>Status Pengantaran Pelayanan Jasa Air Bersih Di Darat</h4></center><br>
            <table class="table table-responsive table-bordered table-striped" id="table"></table>
        </div>
    </div>
    </body>
    <script type="text/javascript">
        var base_url = '<?php echo base_url();?>';

        function pengantaran(id){
            var url;
            var id = id;
            url = "<?php echo site_url('main/ubah_status_pengantaran')?>";
            if (confirm('Mulai Pengantaran ?')) {
                $.ajax({
                    url : url,
                    type: "POST",
                    data: {
                        id_transaksi: id
                    },
                    dataType: "JSON",
                    success: function(data) {
                        alert('Mulai Pengantaran');
                        window.location.replace('<?php echo base_url('main');?>');
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Gagal Mengupdate Data');
                    }
                });
            }
        }

        function realisasi(id) {
            $('#form_realisasi')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('main/realisasi_pengantaran_darat')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('[name="id-transaksi"]').val(data.id_transaksi);
                    $('[name="nama"]').val(data.nama_pengguna_jasa);
                    $('[name="alamat"]').val(data.alamat);
                    $('[name="no_telp"]').val(data.no_telp);
                    $('[name="tonnase"]').val(data.total_permintaan);
                    $('[name="tonnase_air"]').val(data.total_permintaan);
                    $('#modal_menu').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Realisasi Pengantaran'); // Set title to Bootstrap modal title
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error Mengambil Data Dari Ajax');
                }
            });
        }

        function save() {
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable
            var url;

            url = "<?php echo site_url('main/update_realisasi_darat')?>";

            // ajax adding data to database
            var formData = new FormData($('#form_realisasi')[0]);
            $.ajax({
                url : url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    if(data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_menu').modal('hide');
                        alert('Realisasi Berhasil Disimpan');
                        window.location.replace('<?php echo base_url('main');?>');

                    }
                    else
                    {
                        for (var i = 0; i < data.inputerror.length; i++)
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');
                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable

                }
            });
        }

    </script>
    <div class="modal fade" id="modal_menu" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Form Realisasi</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form_realisasi" class="form-horizontal">
                        <input type="hidden" value="" name="id-transaksi"/>
                        <input type="hidden" name="tonnase_air" value="">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama Pengguna Jasa</label>
                                <div class="col-md-9">
                                    <input disabled name="nama" id="nama_menu" placeholder="Nama Pengguna Jasa" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Alamat</label>
                                <div class="col-md-9">
                                    <input disabled name="alamat" placeholder="Alamat" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">No. Telepon</label>
                                <div class="col-md-9">
                                    <input disabled name="no_telp" placeholder="No. Telp" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Total Permintaan</label>
                                <div class="col-md-9">
                                    <input disabled name="tonnase" placeholder="tonnase" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Realisasi</label>
                                <div class="col-md-9">
                                    <input name="realisasi" placeholder="Satuan (Ton)" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Pengantar</label>
                                <div class="col-md-9">
                                    <input name="pengantar" placeholder="Pengantar" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save();" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php
}
else if($this->session->userdata('role') == "perencanaan" && ($this->session->userdata('sesi') != NULL || $this->session->userdata('sesi') != '')){
?>
    <script type="text/javascript">
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    myArr = JSON.parse(this.responseText);
                    var role = 'perencanaan';
                    var i = 0;
                    var a = "<thead>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>ID VESSEL</center></th>" +
                        "<th><center>Voy No</center></th>" +
                        "<th><center>Nama VESSEL</center></th>" +
                        "<th><center>Nama Perusahaan</center></th>" +
                        "<th><center>Nama Pemohon</center></th>" +
                        "<th><center>Tanggal Transaksi</center></th>" +
                        "<th><center>Jumlah Permintaan</center></th>" +
                        "<th><center>Flow Meter Sebelum Pengisian<center></th>" +
                        "<th><center>Flow Meter Sesudah Pengisian<center></th>" +
                        "<th><center>Realisasi</center></th>";
                        a+="<th><center>Aksi</center></th>";
                    a += "</tr>" +
                        "</thead>" +
                        "<tbody>";
                    while (i < myArr.length) {
                        a += "<tr>" +
                            "<td align='center'>" + myArr[i]["no"] + "</td>" +
                            "<td align='center'>" + myArr[i]["id_kapal"] + "</td>" +
                            "<td align='center'>" + myArr[i]["voy_no"] + "</td>" +
                            "<td align='center'>" + myArr[i]["nama_lct"] + "</td>" +
                            "<td align='center'>" + myArr[i]["nama_perusahaan"] + "</td>" +
                            "<td align='center'>" + myArr[i]["nama_pemohon"] + "</td>" +
                            "<td align='center'>" + myArr[i]["tgl_transaksi"] + "</td>" +
                            "<td align='center'>" + myArr[i]["total_permintaan"] + "</td>" +
                            "<td align='center'>" + myArr[i]["flow_sebelum"] + "</td>" +
                            "<td align='center'>" + myArr[i]["flow_sesudah"] + "</td>" +
                            "<td align='center'>" + myArr[i]["realisasi"] + "</td>";
                        if (myArr[i]["aksi"] != null) {
                            a += "<td align='center'>" + myArr[i]["aksi"] + "</td>";
                        }
                        a += "</tr>";
                        i++;
                    }
                    a += "</tbody>" +
                        "<tfoot>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>ID VESSEL</center></th>" +
                        "<th><center>Voy No</center></th>" +
                        "<th><center>Nama VESSEL</center></th>" +
                        "<th><center>Nama Perusahaan</center></th>" +
                        "<th><center>Nama Pemohon</center></th>" +
                        "<th><center>Tanggal Transaksi</center></th>" +
                        "<th><center>Jumlah Permintaan</center></th>" +
                        "<th><center>Flow Meter Sebelum Pengisian<center></th>" +
                        "<th><center>Flow Meter Sesudah Pengisian<center></th>" +
                        "<th><center>Realisasi</center></th>";
                        a+="<th><center>Aksi</center></th>";
                    a += "</tr>" +
                        "</tfoot>";
                    document.getElementById("table").innerHTML = a;
                }
            }
            xmlhttp.open("GET", "<?php echo base_url("main/tabel_pembayaran?id=laut_perencanaan")?>", true);
            xmlhttp.send();
    </script>
    <script>
        function batal(id){
            var url;
            var id = id;
            url = "<?php echo site_url('main/cancelTransaksiLaut')?>";
            if (confirm('Batalkan Transaksi ?')) {
                $.ajax({
                    url : url,
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if(response.status == "sukses"){
                            alert('Transaksi Sudah Dibatalkan');
                            window.location.replace('<?php echo base_url('main');?>');
                        } else{
                            alert('Transaksi Gagal Dibatalkan....Kemungkinan Pengisian Kapal Sudah Dilakukan');
                            window.location.replace('<?php echo base_url('main');?>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Gagal Mengupdate Data'+" "+textStatus+" "+errorThrown);
                    }
                });
            }
        }
    </script>
    <body>
    <div class="container container-fluid">
        <div class="row">
            <center><h4>Status Permintaan Pelayanan Jasa Air Bersih Untuk Kapal</h4></center><br>
            <table class="table table-responsive table-bordered table-striped" id="table"></table>
        </div>
    </div>
    </body>
    <?php
}
else if($this->session->userdata('role') == "keuangan" && ($this->session->userdata('sesi') != NULL || $this->session->userdata('sesi') != '' )){
    ?>
    <script type="text/javascript">
        //function getData(){
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    myArr = JSON.parse(this.responseText);

                    var i=0;
                    var a = "<thead>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>ID VESSEL</center></th>" +
                        "<th><center>Nama VESSEL</center></th>" +
                        "<th><center>Voy No</center></th>" +
                        "<th><center>Nama Perusahaan</center></th>" +
                        "<th><center>Nama Pemohon</center></th>" +
                        "<th><center>Tanggal Transaksi</center></th>" +
                        "<th><center>Tarif</center></th>" +
                        "<th><center>Volume</center></th>" +
                        "<th><center>Jumlah Pembayaran</center></th>"+
                        "<th><center>Aksi</center></th>"+
                        "</tr>" +
                        "</thead>" +
                        "<tbody>";
                    while (i < myArr.length) {
                        a +="<tr>" +
                            "<td align='center'>"+myArr[i]["no"]+"</td>" +
                            "<td align='center'>"+myArr[i]["id_kapal"]+"</td>" +
                            "<td align='center'>"+myArr[i]["nama_lct"]+"</td>" +
                            "<td align='center'>"+myArr[i]["voy_no"]+"</td>" +
                            "<td align='center'>"+myArr[i]["nama_perusahaan"]+"</td>" +
                            "<td align='center'>"+myArr[i]["nama_pemohon"]+"</td>" +
                            "<td align='center'>"+myArr[i]["tgl_transaksi"]+"</td>" +
                            "<td align='center'>"+myArr[i]["tarif"]+"</td>" +
                            "<td align='center'>"+myArr[i]["realisasi"]+"</td>" +
                            "<td align='center'>"+myArr[i]["pembayaran"]+"</td>";
                            if(myArr[i]["aksi"] != null){
                                a += "<td align='center'>"+myArr[i]["aksi"]+"</td>";
                            }
                        a += "</tr>";
                        i++;
                    }
                    a +="</tbody>" +
                        "<tfoot>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>ID VESSEL</center></th>" +
                        "<th><center>Nama VESSEL</center></th>" +
                        "<th><center>Voy No</center></th>" +
                        "<th><center>Nama Perusahaan</center></th>" +
                        "<th><center>Nama Pemohon</center></th>" +
                        "<th><center>Tanggal Transaksi</center></th>" +
                        "<th><center>Tarif</center></th>" +
                        "<th><center>Volume</center></th>" +
                        "<th><center>Jumlah Pembayaran</center></th>"+
                        "<th><center>Aksi</center></th>"+
                        "</tr>" +
                        "</tfoot>";
                    document.getElementById("table").innerHTML= a;
                }
            }
            xmlhttp.open("GET", "<?php echo base_url("main/tabel_pembayaran?id=laut")?>", true);
            xmlhttp.send();
        //}

        //setInterval(getData, 4000);
    </script>
    <body>
    <div class="container container-fluid">
        <div class="row">
            <center><h4>Status Pelayanan Jasa Air Bersih Untuk Kapal</h4></center><br>
            <table class="table table-responsive table-bordered table-striped" id="table"></table>

        </div>
    </div>
    </body>
    <div class="modal fade" id="modal_menu" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Form Realisasi</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form_realisasi" class="form-horizontal">
                        <input type="hidden" value="" name="id-transaksi"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">ID VESSEL</label>
                                <div class="col-md-9">
                                    <input disabled name="id_lct" id="id_lct" placeholder="ID LCT" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama VESSEL</label>
                                <div class="col-md-9">
                                    <input disabled name="nama_lct" placeholder="Nama LCT" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Voy No</label>
                                <div class="col-md-9">
                                    <input disabled name="voy_no" placeholder="Voy No" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama Agent</label>
                                <div class="col-md-9">
                                    <input disabled name="nama_perusahaan" placeholder="Nama Perusahaan" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama Pemohon</label>
                                <div class="col-md-9">
                                    <input disabled name="nama_pemohon" placeholder="Nama Pemohon" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tanggal Transaksi</label>
                                <div class="col-md-9">
                                    <input disabled name="tgl_transaksi" placeholder="Tanggal Transaksi" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Volume Pengisian</label>
                                <div class="col-md-9">
                                    <input disabled name="realisasi" placeholder="Satuan (Ton)" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Jumlah Pembayaran</label>
                                <div class="col-md-9">
                                    <input disabled name="pembayaran" placeholder="Rp. " class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">No Nota</label>
                                <div class="col-md-9">
                                    <input name="no_nota" placeholder="Masukkan No Nota" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">No Faktur</label>
                                <div class="col-md-9">
                                    <input name="no_faktur" placeholder="Masukkan No Faktur" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save();" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        var base_url = '<?php echo base_url();?>';

        function realisasi(id) {
            var total_bayar;
            var realisasi;
            $('#form_realisasi')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('main/realisasi_pengantaran_laut')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('[name="id-transaksi"]').val(data.id_transaksi);
                    $('[name="id_lct"]').val(data.id_vessel);
                    $('[name="voy_no"]').val(data.voy_no);
                    $('[name="nama_lct"]').val(data.nama_vessel);
                    $('[name="nama_perusahaan"]').val(data.nama_agent);
                    $('[name="nama_pemohon"]').val(data.nama_pemohon);
                    $('[name="tgl_transaksi"]').val(data.tgl_transaksi);
                    if(data.flowmeter_awal_4 != null){
                        realisasi = data.flowmeter_akhir_4 - data.flowmeter_awal_4;
                        if(data.flowmeter_awal_3 != null){
                            realisasi += data.flowmeter_akhir_3 - data.flowmeter_awal_3;
                            if(data.flowmeter_awal_2 != null){
                                realisasi += data.flowmeter_akhir_2 - data.flowmeter_awal_2;
                                realisasi += data.flowmeter_akhir - data.flowmeter_awal;
                            }
                        }
                        $('[name="realisasi"]').val(realisasi);
                    }
                    else if(data.flowmeter_awal_3 != null){
                        realisasi = data.flowmeter_akhir_3 - data.flowmeter_awal_3;
                        if(data.flowmeter_awal_2 != null){
                            realisasi += data.flowmeter_akhir_2 - data.flowmeter_awal_2;
                            realisasi += data.flowmeter_akhir - data.flowmeter_awal;
                        }
                        $('[name="realisasi"]').val(realisasi);
                    }
                    else if(data.flowmeter_awal_2 != null){
                        realisasi = data.flowmeter_akhir_2 - data.flowmeter_awal_2;
                        realisasi += data.flowmeter_akhir - data.flowmeter_awal;
                        $('[name="realisasi"]').val(realisasi);
                    }
                    else{
                        realisasi = data.flowmeter_akhir - data.flowmeter_awal;
                        $('[name="realisasi"]').val(realisasi);
                    }
                    if (data.diskon != null) {
                        total_bayar = (data.tarif - (data.tarif * data.diskon/100)) * realisasi;
                        if(total_bayar > 1000000 ) {
                            $('[name="pembayaran"]').val(total_bayar + 6000);
                        } else if(total_bayar >= 250000 && total_bayar <= 1000000){
                            $('[name="pembayaran"]').val(total_bayar + 3000);
                        } else{
                            $('[name="pembayaran"]').val(total_bayar);
                        }
                    }
                    else {
                        total_bayar = data.tarif * (data.flowmeter_akhir - data.flowmeter_awal);
                        if(total_bayar > 1000000 ){
                            $('[name="pembayaran"]').val(total_bayar + 6000);
                        } else if(total_bayar >= 250000 && total_bayar <= 1000000){
                            $('[name="pembayaran"]').val(total_bayar + 3000);
                        } else {
                            $('[name="pembayaran"]').val(total_bayar);
                        }
                    }
                    $('#modal_menu').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Realisasi Pengisian'); // Set title to Bootstrap modal title
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error Mengambil Data Dari Ajax');
                }
            });
        }

        function save() {
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable
            var url;

            url = "<?php echo site_url('main/realisasi_pembayaran_laut')?>";

            // ajax adding data to database
            var formData = new FormData($('#form_realisasi')[0]);
            $.ajax({
                url : url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    if(data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_menu').modal('hide');
                        alert('Realisasi Berhasil Disimpan');
                        window.location.replace('<?php echo base_url('main')?>');
                    }
                    else
                    {
                        for (var i = 0; i < data.inputerror.length; i++)
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');
                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable
                }
            });
        }
    </script>
    <?php
}
else if($this->session->userdata('role') == "operasi" && ($this->session->userdata('sesi') != NULL || $this->session->userdata('sesi') != '')){
    ?>
    <script type="text/javascript">
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                myArr = JSON.parse(this.responseText);
                var role = 'operasi';
                var i = 0;

                var a = "<thead>" +
                    "<tr>" +
                    "<th><center>No</center></th>" +
                    "<th><center>ID VESSEL</center></th>" +
                    "<th><center>Voy No</center></th>" +
                    "<th><center>Nama VESSEL</center></th>" +
                    "<th><center>Nama Perusahaan</center></th>" +
                    "<th><center>Nama Pemohon</center></th>" +
                    "<th><center>Tanggal Transaksi</center></th>" +
                    "<th><center>Jumlah Permintaan</center></th>" +
                    "<th><center>Flow Meter Sebelum Pengisian<center></th>" +
                    "<th><center>Flow Meter Sesudah Pengisian<center></th>" +
                    "<th><center>Realisasi</center></th>";
                if(role == '<?php echo $this->session->userdata('role')?>' ){
                    a+="<th><center>Aksi</center></th>";
                }
                a += "</tr>" +
                    "</thead>" +
                    "<tbody>";
                while (i < myArr.length) {
                    a += "<tr bgcolor='"+myArr[i]["warna"]+"'>" +
                        "<td align='center'>" + myArr[i]["no"] + "</td>" +
                        "<td align='center'>" + myArr[i]["id_kapal"] + "</td>" +
                        "<td align='center'>" + myArr[i]["voy_no"] + "</td>" +
                        "<td align='center'>" + myArr[i]["nama_lct"] + "</td>" +
                        "<td align='center'>" + myArr[i]["nama_perusahaan"] + "</td>" +
                        "<td align='center'>" + myArr[i]["nama_pemohon"] + "</td>" +
                        "<td align='center'>" + myArr[i]["tgl_transaksi"] + "</td>" +
                        "<td align='center'>" + myArr[i]["total_permintaan"] + "</td>" +
                        "<td align='center'>" + myArr[i]["flow_sebelum"] + "</td>" +
                        "<td align='center'>" + myArr[i]["flow_sesudah"] + "</td>" +
                        "<td align='center'>" + myArr[i]["realisasi"] + "</td>";
                    if (myArr[i]["aksi"] != null) {
                        a += "<td align='center'>" + myArr[i]["aksi"] + "</td>";
                    }
                    a += "</tr>";
                    i++;
                }
                a += "</tbody>" +
                    "<tfoot>" +
                    "<tr>" +
                    "<th><center>No</center></th>" +
                    "<th><center>ID VESSEL</center></th>" +
                    "<th><center>Voy No</center></th>" +
                    "<th><center>Nama VESSEL</center></th>" +
                    "<th><center>Nama Perusahaan</center></th>" +
                    "<th><center>Nama Pemohon</center></th>" +
                    "<th><center>Tanggal Transaksi</center></th>" +
                    "<th><center>Jumlah Permintaan</center></th>" +
                    "<th><center>Flow Meter Sebelum Pengisian<center></th>" +
                    "<th><center>Flow Meter Sesudah Pengisian<center></th>" +
                    "<th><center>Realisasi</center></th>";
                if(role == '<?php echo $this->session->userdata('role')?>' ){
                    a+="<th><center>Aksi</center></th>";
                }
                a += "</tr>" +
                    "</tfoot>";
                document.getElementById("table").innerHTML = a;
            }
        }
        xmlhttp.open("GET", "<?php echo base_url("main/tabel_pembayaran?id=laut_operasi")?>", true);
        xmlhttp.send();
    </script>
    <script>
        function reload() {
            location.reload();
        }
    </script>

    <body>
    <div class="topright" align="right">
        <span id="notifKapal" ></span>
    </div>
    <div class="container container-fluid">
        <div class="row">
            <center><h4>Status Permintaan Pelayanan Jasa Air Bersih Untuk Kapal</h4></center><br>
            <table class="table table-responsive table-bordered table-condensed" id="table">
            </table>
        </div>
    </div>
    </body>

<?php
}
else if($this->session->userdata('role') == "admin" && ($this->session->userdata('sesi') != NULL || $this->session->userdata('sesi') != '')){
?>
    <div class="container container-fluid">
        <div class="row">
            <h3>PT. Kaltim Kariangau Terminal</h3>
            <h3>Terminal Peti Kemas Balikpapan</h3>
            <br><br>
            <h3>Selamat Datang Di Aplikasi Pelayanan Jasa Air Bersih PT KKT</h3><br><br>
            <h3>Untuk Memulai Menggunakan Aplikasi, Silahkan Memilih Menu Yang Telah Disediakan Di Atas</h3>
            <script>
                $(function(){
                    $("#accordion").accordion();
                    $("#display").accordion();
                });
            </script>
            <body>
            <div class="container">
                <div class="row">
                    <div id="profile">
                        <h4>Untuk Mengubah Data Diri Anda, Silahkan Klik Tombol Ubah Data Di Bawah Ini</h4>
                        <br />
                        <div>
                            <button class="btn btn-info" data-toggle="collapse" data-target="#data" class="accordion-toggle">Ubah Password</button>
                        </div>
                        <div class="hiddenRow">
                            <div class="accordion-body collapse" id="data">
                                <div class="col-md-6">
                                    <h2>||&nbsp Ubah Password Anda &nbsp || </h2>
                                    <br>
                                    <br>
                                    <div class='error_msg'>
                                        <?php echo validation_errors(); ?>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th>Password Lama</th>
                                            <td>:</td>
                                            <td>
                                                <input id="pass_lama" type="password" class="form-control" required/>
                                                <input id="pass" value="<?php echo $this->session->userdata('password') ?>" required hidden/>
                                                <input id="username" value="<?php echo $this->session->userdata('username') ?>" required hidden/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Password Baru</th>
                                            <td>:</td>
                                            <td>
                                                <input id="pass_baru" type="password" class="form-control" required/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Konfirmasi Password Baru</th>
                                            <td>:</td>
                                            <td>
                                                <input id="confirm_pass" type="password" class="form-control" required/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input id="submit" type="button" class="btn btn-primary" value="Submit"/>
                                            </td><td></td><td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#submit").click(function(){
                            var username = $("#username").val();
                            var pass = $("#pass").val();
                            var pass_lama = $("#pass_lama").val();
                            var pass_baru = $("#pass_baru").val();
                            var confirm_pass = $("#confirm_pass").val();
                            // Returns successful data submission message when the entered information is stored in database.

                            console.log(status);
                            var dataString = 'username='+ username + '&password='+ pass_baru;
                            if(username==''||pass_baru==''||pass_lama==''||confirm_pass==''){
                                alert("Please Fill All Fields");
                            }
                            else if(pass_lama != pass){
                                alert("password lama anda salah");
                            }
                            else if(pass_baru != confirm_pass){
                                alert("password baru anda tidak sama dengan konfirmasi password anda")
                            }
                            else{
                                // AJAX Code To Submit Form.
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url('main/update_pass'); ?>",
                                    data: dataString,
                                    cache: false,
                                    success: function(result){
                                        alert("Sukses Mengupdate");
                                        $("#pass").val(pass_baru);
                                        $("#pass_lama").val("");
                                        $("#pass_baru").val("");
                                        $("#confirm_pass").val("");
                                    }
                                });
                                console.log(status);
                            }
                        });
                    });
                </script>
            </div>
            <br />
            <?php
            if($_SESSION['role'] == "admin"){
                ?>
                <div class="container">
                    <div class="row">
                        <button class="btn btn-info" data-toggle="collapse" data-target="#tabel-pengguna" class="accordion-toggle">Tabel Pengguna</button>
                    </div>
                    <div id="tabel-pengguna" class="hiddenRow accordion-body collapse">
                        <table class="table">
                            <tr>
                                <td>
                                    <h1 style="font-size:20pt">Data Pengguna</h1>
                                    <br />
                                    <br />
                                    <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Tambah Akun</button>
                                    <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>
                                    <button class="btn btn-danger" onclick="bulk_delete()"><i class="glyphicon glyphicon-trash"></i> Hapus Massal</button>
                                    <br />
                                    <br />
                                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th style="width:10px;"><input type="checkbox" id="check-all"></th>
                                            <th>Nama Akun</th>
                                            <th>Nama Pengguna</th>
                                            <th>Hak Akses</th>
                                            <th style="width:150px;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Nama Akun</th>
                                            <th>Nama Pengguna</th>
                                            <th>Hak Akses</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <script type="text/javascript">

                    var save_method; //for save method string
                    var table;
                    var base_url = '<?php echo base_url();?>';

                    $(document).ready(function() {

                        //datatables
                        table = $('#table').DataTable({

                            "processing": true, //Feature control the processing indicator.
                            "serverSide": true, //Feature control DataTables' server-side processing mode.
                            "order": [], //Initial no order.

                            // Load data for the table's content from an Ajax source
                            "ajax": {
                                "url": "<?php echo site_url('main/ajax_list')?>",
                                "type": "POST"
                            },

                            //Set column definition initialisation properties.
                            "columnDefs": [
                                {
                                    "targets": [ 0 ], //first column
                                    "orderable": false, //set not orderable
                                },
                                {
                                    "targets": [ -1 ], //last column
                                    "orderable": false, //set not orderable
                                },
                            ],
                        });

                        //set input/textarea/select event when change value, remove class error and remove text help block
                        $("input").change(function(){
                            $(this).parent().parent().removeClass('has-error');
                            $(this).next().empty();
                        });
                        $("select").change(function(){
                            $(this).parent().parent().removeClass('has-error');
                            $(this).next().empty();
                        });

                        //check all
                        $("#check-all").click(function () {
                            $(".data-check").prop('checked', $(this).prop('checked'));
                        });
                    });

                    function add_person() {
                        save_method = 'add';
                        $('#form')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string
                        $('#username').attr('type','text');
                        $('#nama').attr('type','text');
                        $('#password').attr('type','password');
                        $('#confirm_password').attr('type','password');
                        $('#modal_form').modal('show'); // show bootstrap modal
                        $('.modal-title').text('Tambah Data Akun'); // Set Title to Bootstrap modal title
                    }

                    function edit_person(id) {
                        save_method = 'update';
                        $('#form')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string

                        //Ajax Load data from ajax
                        $.ajax({
                            url : "<?php echo site_url('main/ajax_edit')?>/" + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function(data)
                            {
                                $('[name="id"]').val(data.id_user);
                                $('[name="username"]').val(data.username);
                                $('[name="nama"]').val(data.nama);
                                $('[name="role"]').val(data.role);
                                $('[name="pass"]').val(data.password);
                                $('[name="confirm_pass"]').val(data.password);
                                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                                $('.modal-title').text('Ubah Data Akun'); // Set title to Bootstrap modal title
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('Error Mendapat Data Dari Ajax');
                            }
                        });
                    }

                    function reload_table() {
                        table.ajax.reload(null,false); //reload datatable ajax
                    }

                    function save() {
                        $('#btnSave').text('Menyimpan...'); //change button text
                        $('#btnSave').attr('disabled',true); //set button disable
                        var url;

                        if(save_method == 'add') {
                            url = "<?php echo site_url('main/ajax_add')?>";
                        } else {
                            url = "<?php echo site_url('main/ajax_update')?>";
                        }

                        // ajax adding data to database
                        var formData = new FormData($('#form')[0]);
                        $.ajax({
                            url : url,
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: "JSON",
                            success: function(data)
                            {

                                if(data.status) //if success close modal and reload ajax table
                                {
                                    $('#modal_form').modal('hide');
                                    reload_table();
                                }
                                else
                                {
                                    for (var i = 0; i < data.inputerror.length; i++)
                                    {
                                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                                    }
                                }
                                $('#btnSave').text('Simpan'); //change button text
                                $('#btnSave').attr('disabled',false); //set button enable


                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('Error adding / update data');
                                $('#btnSave').text('Simpan'); //change button text
                                $('#btnSave').attr('disabled',false); //set button enable

                            }
                        });
                    }

                    function delete_person(id) {
                        if(confirm('Apakah Anda Yakin Ingin Menghapus Data Ini ?'))
                        {
                            // ajax delete data to database
                            $.ajax({
                                url : "<?php echo site_url('main/ajax_delete')?>/"+id,
                                type: "POST",
                                dataType: "JSON",
                                success: function(data)
                                {
                                    //if success reload ajax table
                                    $('#modal_form').modal('hide');
                                    reload_table();
                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    alert('Error Menghapus Data');
                                }
                            });

                        }
                    }

                    function bulk_delete() {
                        var list_id = [];
                        $(".data-check:checked").each(function() {
                            list_id.push(this.value);
                        });
                        if(list_id.length > 0)
                        {
                            if(confirm('Apakah Anda Yakin Ingin Menghapus '+list_id.length+' Data Ini ?'))
                            {
                                $.ajax({
                                    type: "POST",
                                    data: {id:list_id},
                                    url: "<?php echo site_url('main/ajax_bulk_delete')?>",
                                    dataType: "JSON",
                                    success: function(data)
                                    {
                                        if(data.status)
                                        {
                                            reload_table();
                                        }
                                        else
                                        {
                                            alert('Gagal.');
                                        }

                                    },
                                    error: function (jqXHR, textStatus, errorThrown)
                                    {
                                        alert('Error Menghapus Data');
                                    }
                                });
                            }
                        }
                        else
                        {
                            alert('Tidak Ada Data Yang Dipilih');
                        }
                    }

                </script>
                <!-- Bootstrap modal -->
                <div class="modal fade" id="modal_form" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title">Form Akun</h3>
                            </div>
                            <div class="modal-body form">
                                <form action="#" id="form" class="form-horizontal">
                                    <input type="hidden" value="" name="id"/>
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Nama Akun</label>
                                            <div class="col-md-9">
                                                <input name="username" id="username" placeholder="Nama Akun" class="form-control" type="text">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Nama Pengguna</label>
                                            <div class="col-md-9">
                                                <input name="nama" id="nama" placeholder="Nama Pengguna" class="form-control" type="text">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Hak Akses</label>
                                            <div class="col-md-9">
                                                <select name="role" class="form-control">
                                                    <option value="">--Pilih Hak Akses--</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="loket">Loket</option>
                                                    <option value="perencanaan">Perencanaan</option>
                                                    <option value="keuangan">Keuangan</option>
                                                    <option value="operasi">Operasi</option>
                                                    <option value="wtp">WTP</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Kata Sandi</label>
                                            <div class="col-md-9">
                                                <input name="pass" id="password" placeholder="********" class="form-control" type="password">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Konfirmasi Kata Sandi</label>
                                            <div class="col-md-9">
                                                <input name="confirm_pass" id="confirm_password" placeholder="*********" class="form-control" type="password">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                      <!-- End Bootstrap modal -->
                <br />
                <?php
            }
            ?>
            <br/>
            </body>
        </div>
    </div>
    <?php
}
else {
?>
    <div class="container container-fluid">
        <?php
        if (isset($_SESSION['message_display'])) {
        $message = $_SESSION['message_display'];
        ?>
        <body onload='swal({title: "Berhasil!",
                text: "<?php echo $message?>",
                timer: 3000,
                type: "success",
                showConfirmButton: true });'>
        <?php
        unset($_SESSION['message_display']);
        }
        ?>
        <?php
        if(isset($_SESSION['error_message'])) {
        $error = $_SESSION['error_message'];
        ?>
        <body onload='swal({title: "Gagal!",
                text: "<?php echo $error?>",
                timer: 3000,
                type: "error",
                showConfirmButton: true });'>
        <?php
        unset($_SESSION['error_message']);
        }
        ?>
        <div class="col-md-4">
            <?php echo form_open('main/login'); ?>
            <div class='error_msg'>
                <?php echo validation_errors(); ?>
            </div>
            <table class="table">
                <tr>
                    <td><label>User ID</label></td>
                    <td>:</td>
                    <td><input class="form-control" type="text" name="username" id="name" placeholder="user id anda" required/></td>
                </tr>
                <tr>
                    <td><label>Kata Sandi</label></td>
                    <td>:</td>
                    <td><input class="form-control" type="password" name="password" id="password" placeholder="kata sandi anda" required/></td>
                </tr>
                <tr>
                    <td colspan="3" align="center"><input type="submit" class="btn btn-success" value="Masuk" name="submit"/></td>
                </tr>
            </table>
            <?php echo form_close(); ?>
        </div>
    </div>

<?php
}
?>
</body>