<?php
if($this->session->userdata('role_name') == "operasi" && $this->session->userdata('session') != NULL){
    ?>
    <script type="text/javascript">
        function getData(){
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    myArr = JSON.parse(this.responseText);

                    var i=0;
                    var a = "<thead>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>ID Flow Meter</center></th>" +
                        "<th><center>Nama Ruko</center></th>" +
                        "<th><center>Alamat</center></th>" +
                        "<th><center>No Telepon</center></th>" +
                        "<th><center>Flow Meter Awal</center></th>" +
                        "<th><center>Flow Meter Terakhir</center></th>" +
                        "<th><center>Total Penggunaan<center></th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>";
                    while (i < myArr.length) {
                        a +="<tr>" +
                            "<td align='center'>"+myArr[i]["no"]+"</td>" +
                            "<td align='center'>"+myArr[i]["id_flowmeter"]+"</td>" +
                            "<td align='center'>"+myArr[i]["nama_pengguna_jasa"]+"</td>" +
                            "<td align='center'>"+myArr[i]["alamat"]+"</td>" +
                            "<td align='center'>"+myArr[i]["no_telp"]+"</td>" +
                            "<td align='center'>"+myArr[i]["flowmeter_awal"]+"</td>" +
                            "<td align='center'>"+myArr[i]["flowmeter_akhir"]+"</td>" +
                            "<td align='center'>"+myArr[i]["total_penggunaan"]+"</td>" +
                            "</tr>";
                        i++;
                    }
                    a +="</tbody>" +
                        "<tfoot>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>ID Flow Meter</center></th>" +
                        "<th><center>Nama Ruko</center></th>" +
                        "<th><center>Alamat</center></th>" +
                        "<th><center>No Telepon</center></th>" +
                        "<th><center>Flow Meter Awal</center></th>" +
                        "<th><center>Flow Meter Terakhir</center></th>" +
                        "<th><center>Total Penggunaan<center></th>" +
                        "</tr>" +
                        "</tfoot>";
                    document.getElementById("table").innerHTML= a;
                }
            }
            xmlhttp.open("GET", "<?php echo base_url("main/tabel_pembayaran?id=ruko")?>", true);
            xmlhttp.send();
        }

        setInterval(getData, 4000);
    </script>
    <body>
    <div class="container container-fluid">
        <div class="row">
            <h3>PT. Kaltim Kariangau Terminal</h3>
            <h3>Terminal Peti Kemas Balikpapan</h3>
            <h3>Aplikasi Pelayanan Jasa Air Bersih PT KKT</h3><br><br>
            <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                <div class="collapse navbar-collapse" >
                    <a class="nav-link btn btn-info" href="<?php echo base_url('main/master?id=ruko'); ?>">Master ID Flow Meter</a>
                    <a class="nav-link btn btn-info" href="<?php echo base_url('main/tagihan'); ?>">Cetak Tagihan</a>
                </div>
            </nav>
            <center><h4>Status Pembayaran Pelayanan Jasa Air Bersih Di Darat</h4></center><br>
            <table class="table table-responsive table-bordered table-striped" id="table"></table>
        </div>
    </div>
    </body>
    <?php
}
else if($this->session->userdata('role_name') == "wtp" && $this->session->userdata('session') != NULL){
    ?>
    <script type="text/javascript">
        function getData(){
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    myArr = JSON.parse(this.responseText);

                    var i = 0;
                    var a = "<thead>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>ID Flow Meter</center></th>" +
                        "<th><center>Nama Ruko</center></th>" +
                        "<th><center>Alamat</center></th>" +
                        "<th><center>No Telepon</center></th>" +
                        "<th><center>Flow Meter Awal</center></th>" +
                        "<th><center>Flow Meter Akhir</center></th>" +
                        "<th><center>Total Penggunaan<center></th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>";
                    while (i < myArr.length) {
                        a +="<tr>" +
                            "<td align='center'>"+myArr[i]["no"]+"</td>" +
                            "<td align='center'>"+myArr[i]["id_flowmeter"]+"</td>" +
                            "<td align='center'>"+myArr[i]["nama_pengguna_jasa"]+"</td>" +
                            "<td align='center'>"+myArr[i]["alamat"]+"</td>" +
                            "<td align='center'>"+myArr[i]["no_telp"]+"</td>" +
                            "<td align='center'>"+myArr[i]["flowmeter_awal"]+"</td>" +
                            "<td align='center'>"+myArr[i]["flowmeter_akhir"]+"</td>" +
                            "<td align='center'>"+myArr[i]["total_penggunaan"]+"</td>" +
                            "</tr>";
                        i++;
                    }
                    a +="</tbody>" +
                        "<tfoot>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>ID Flow Meter</center></th>" +
                        "<th><center>Nama Ruko</center></th>" +
                        "<th><center>Alamat</center></th>" +
                        "<th><center>No Telepon</center></th>" +
                        "<th><center>Flow Meter Awal</center></th>" +
                        "<th><center>Flow Meter Akhir</center></th>" +
                        "<th><center>Total Penggunaan<center></th>" +
                        "</tr>" +
                        "</tfoot>";
                    document.getElementById("table").innerHTML= a;
                }
            }
            xmlhttp.open("GET", "<?php echo base_url("main/tabel_pengantaran?id=ruko")?>", true);
            xmlhttp.send();
        }

        setInterval(getData, 4000);
    </script>
    <body>
    <div class="container container-fluid">
        <div class="row">
            <h3>PT. Kaltim Kariangau Terminal</h3>
            <h3>Terminal Peti Kemas Balikpapan</h3>
            <h3>Aplikasi Pelayanan Jasa Air Bersih PT KKT</h3><br><br>
            <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                <div class="collapse navbar-collapse" >
                    <a class="nav-link btn btn-info" href="<?php echo base_url('main/view?id=ruko'); ?>">Input Penggunaan Harian</a>
                </div>
            </nav>
            <center><h4>Status Pelayanan Jasa Air Bersih Untuk Ruko</h4></center><br>
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
                                    <input disabled name="tonnase" placeholder="No. Telp" class="form-control" type="text">
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
                    $('[name="id_realisasi"]').val(data.id_realisasi);
                    $('[name="tonnase"]').val(data.total_permintaan);
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
