<?php
if(isset($_SESSION['session'])) {
    if($_SESSION['role'] == "operasi" && $tipe == "ruko") {
        ?>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#upload').on('click', function () {
            var id_flow = $('#id_flow').val();
            var nama = $('#nama_ruko').val();
            var alamat = $('#alamat').val();
            var no_telp = $('#no_telp').val();
            var form_data = new FormData();
            var base_url = '<?= base_url();?>';
            var text_alert;
            form_data.append('id_flow',id_flow);
            form_data.append('nama',nama);
            form_data.append('alamat',alamat);
            form_data.append('no_telp',no_telp);
            $.ajax({
                url: base_url +'index.php/main/input_data_ruko', // point to server-side controller method
                dataType: 'text', // what to expect back from the server
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    //$('#msg').html(response); // display success response from the server
                    text_alert = JSON.stringify(response);
                    window.alert(text_alert);
                    window.location = base_url+"main/master?id=ruko";
                },
                error: function (response) {
                    text_alert = JSON.stringify(response);
                    window.alert(text_alert);
                    $('#tahun').val('');
                }
            });
        });
    });
</script>
        <div class="container" data-role="main" class="ui-content">
            <h3>Form Master Data Ruko</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="3"><p id="msg"></p></td>
                    </tr>
                    <tr>
                        <td><label>ID Flow Meter</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="id_flow" id="id_flow" required></td>
                    </tr>
                    <tr>
                        <td><label>Nama Ruko</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_ruko" id="nama_ruko" required></td>
                    </tr>
                    <tr>
                        <td><label>Alamat</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="alamat" id="alamat" required></td>
                    </tr>
                    <tr>
                        <td><label>No Telepon</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="no_telp" id="no_telp" required></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <button class="btn btn-success" id="upload">Input</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="container">
            <div class="row col-md-12">
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="70%">
                    <thead>
                    <tr>
                        <th>
                            <center>No
                        </th>
                        <th>
                            <center>ID Flow Meter
                        </th>
                        <th>
                            <center>Nama Ruko
                        </th>
                        <th>
                            <center>Alamat
                        </th>
                        <th>
                            <center>No Telepon
                        </th>
                        <th>
                            <center>Aksi
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>
                            <center>No
                        </th>
                        <th>
                            <center>ID Flow Meter
                        </th>
                        <th>
                            <center>Nama Ruko
                        </th>
                        <th>
                            <center>Alamat
                        </th>
                        <th>
                            <center>No Telepon
                        </th>
                        <th>
                            <center>Aksi
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            function confirmDelete() {

            }
        </script>
        <script type="text/javascript">
            var table;

            $(document).ready(function() {
                //datatables
                table = $('#table').DataTable({

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo site_url('main/ajax_data_ruko')?>",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [ 0 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                    ],
                });
            });

        </script>
        <script>
            function delete_data_ruko(id)
            {
                if(confirm('Apakah Anda Yakin Untuk Menghapus Data Ini?'))
                {
                    // ajax delete data to database
                    $.ajax({
                        url : "<?php echo site_url('main/delete_data_ruko')?>/"+id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data)
                        {
                            //if success reload ajax table
                            alert("Data Berhasil Dihapus");
                            window.location = "<?= site_url()?>"+"main/master?id=ruko";
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Ketika Menghapus Data');
                        }
                    });

                }
            }
        </script>
        <?php
    }
    else if($_SESSION['role'] == "loket" && $tipe == "darat"){
?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload').on('click', function () {
                    var nama = $('#nama').val();
                    var alamat = $('#alamat').val();
                    var no_telp = $('#no_telp').val();
                    var pengguna_jasa = $('#pengguna').val();
                    var form_data = new FormData();
                    var base_url = '<?= base_url();?>';
                    var text_alert;
                    form_data.append('nama',nama);
                    form_data.append('alamat',alamat);
                    form_data.append('no_telp',no_telp);
                    form_data.append('pengguna_jasa',pengguna_jasa);
                    $.ajax({
                        url: base_url +'index.php/main/input_data_darat', // point to server-side controller method
                        dataType: 'text', // what to expect back from the server
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (response) {
                            //$('#msg').html(response); // display success response from the server
                            text_alert = JSON.stringify(response);
                            window.alert(text_alert);
                            window.location = base_url+"main/master?id=darat";
                        },
                        error: function (response) {
                            text_alert = JSON.stringify(response);
                            window.alert(text_alert);
                            $('#tahun').val('');
                        }
                    });
                });
            });
        </script>
        <div class="container" data-role="main" class="ui-content">
            <h3>Form Master Data Pengguna Jasa</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="3"><p id="msg"></p></td>
                    </tr>
                    <tr>
                        <td><label>Nama Pengguna Jasa</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama" id="nama" required></td>
                    </tr>
                    <tr>
                        <td><label>Alamat</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="alamat" id="alamat" required></td>
                    </tr>
                    <tr>
                        <td><label>No Telepon</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="no_telp" id="no_telp" required></td>
                    </tr>
                    <tr>
                        <td><label>Jenis Pengguna Jasa</label></td>
                        <td>:</td>
                        <td>
                            <select name="pengguna" id="pengguna" class="form-control">
                                <option></option>
                                <?php foreach($pengguna as $rowpengguna){?>
                                    <option value="<?=$rowpengguna->id_tarif?>"><?=$rowpengguna->tipe_pengguna_jasa?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <button class="btn btn-success" id="upload">Input</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="container">
            <div class="row col-md-12">
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="70%">
                    <thead>
                    <tr>
                        <th>
                            <center>No
                        </th>
                        <th>
                            <center>Nama Pembeli
                        </th>
                        <th>
                            <center>Alamat
                        </th>
                        <th>
                            <center>No Telepon
                        </th>
                        <th>
                            <center>Jenis Pengguna Jasa
                        </th>
                        <th>
                            <center>Aksi
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>
                            <center>No
                        </th>
                        <th>
                            <center>Nama Pembeli
                        </th>
                        <th>
                            <center>Alamat
                        </th>
                        <th>
                            <center>No Telepon
                        </th>
                        <th>
                            <center>Jenis Pengguna Jasa
                        </th>
                        <th>
                            <center>Aksi
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            function confirmDelete() {

            }
        </script>
        <script type="text/javascript">
            var table;

            $(document).ready(function() {
                //datatables
                table = $('#table').DataTable({

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo site_url('main/ajax_data_darat')?>",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [ 0 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                    ],
                });
            });

        </script>
        <script>
            function delete_data_darat(id)
            {
                if(confirm('Apakah Anda Yakin Untuk Menghapus Data Ini?'))
                {
                    // ajax delete data to database
                    $.ajax({
                        url : "<?php echo site_url('main/delete_data_darat')?>/"+id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data)
                        {
                            //if success reload ajax table
                            alert("Data Berhasil Dihapus");
                            window.location = "<?= site_url()?>"+"main/master?id=darat";
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Ketika Menghapus Data');
                        }
                    });

                }
            }
        </script>
<?php
    }
    else if($_SESSION['role'] == "perencanaan" && $tipe == "laut"){
?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload').on('click', function () {
                    var id_lct = $('#id_lct').val();
                    var nama = $('#nama_lct').val();
                    var pengguna_jasa = $('#pengguna').val();
                    var id_agent = $('#id_agent').val();
                    var form_data = new FormData();
                    var base_url = '<?= base_url();?>';
                    var text_alert;
                    form_data.append('id_lct',id_lct);
                    form_data.append('nama',nama);
                    form_data.append('pengguna_jasa',pengguna_jasa);
                    form_data.append('id_agent',id_agent);
                    $.ajax({
                        url: base_url +'index.php/main/input_data_laut', // point to server-side controller method
                        dataType: 'text', // what to expect back from the server
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (response) {
                            //$('#msg').html(response); // display success response from the server
                            text_alert = JSON.stringify(response);
                            window.alert(text_alert);
                            window.location = base_url+"main/master?id=laut";
                        },
                        error: function (response) {
                            text_alert = JSON.stringify(response);
                            window.alert(text_alert);
                            $('#tahun').val('');
                        }
                    });
                });
            });
        </script>
        <script>
            function showAgent(str) {
                if (str=="") {
                    document.getElementById("alamat").innerHTML="";
                    document.getElementById("no_telp").innerHTML="";
                    return;
                }
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function() {
                    if (this.readyState==4 && this.status==200) {
                        var data = JSON.parse(this.responseText);
                        document.getElementById("alamat").value= data.alamat;
                        document.getElementById("no_telp").value=data.no_telp;
                    }
                }
                xmlhttp.open("GET","<?= base_url('main/cari_agent?id=')?>"+str,true);
                xmlhttp.send();
            }
        </script>
        <style type="text/css">
            .topright {
                position: fixed;
                top: 65px;
                right: 25px;
                padding:3px 3px 3px 3px;
            }
        </style>
        <div class="container" data-role="main" class="ui-content">
            <h3>Form Master Data Vessel</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="3"><p id="msg"></p></td>
                    </tr>
                    <tr>
                        <td><label>Nama VESSEL</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_lct" id="nama_lct" required></td>
                    </tr>
                    <tr>
                        <td><label>ID VESSEL</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="id_lct" id="id_lct" required></td>
                    </tr>
                    <tr>
                        <td><label>Jenis Kapal</label></td>
                        <td>:</td>
                        <td>
                            <select name="pengguna" id="pengguna" class="form-control">
                                <option></option>
                                <?php foreach($pengguna as $rowpengguna){?>
                                    <option value="<?=$rowpengguna->id_tarif?>"><?=$rowpengguna->tipe_pengguna_jasa?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Nama Perusahaan</label></td>
                        <td>:</td>
                        <td>
                            <select name="id_agent" id="id_agent" onchange="showAgent(this.value)">
                                <?php
                                    foreach ($agent as $row){
                                        ?>
                                        <option value="<?= $row->id_agent?>"><?= $row->nama_perusahaan?></option>
                                    <?php
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Alamat</label></td>
                        <td>:</td>
                        <td><input disabled class="form-control" type="text" name="alamat" id="alamat"></td>
                    </tr>
                    <tr>
                        <td><label>No Telepon</label></td>
                        <td>:</td>
                        <td><input disabled class="form-control" type="text" name="no_telp" id="no_telp"></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <button class="btn btn-success" id="upload">Input</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="container">
            <div class="row col-md-12">
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="70%">
                    <thead>
                    <tr>
                        <th>
                            <center>No
                        </th>
                        <th>
                            <center>ID VESSEL
                        </th>
                        <th>
                            <center>Nama VESSEL
                        </th>
                        <th>
                            <center>Nama Perusahaan
                        </th>
                        <th>
                            <center>Jenis Kapal
                        </th>
                        <th>
                            <center>Alamat
                        </th>
                        <th>
                            <center>No Telepon
                        </th>
                        <th>
                            <center>Aksi
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>
                            <center>No
                        </th>
                        <th>
                            <center>ID VESSEL
                        </th>
                        <th>
                            <center>Nama VESSEL
                        </th>
                        <th>
                            <center>Nama Perusahaan
                        </th>
                        <th>
                            <center>Jenis Kapal
                        </th>
                        <th>
                            <center>Alamat
                        </th>
                        <th>
                            <center>No Telepon
                        </th>
                        <th>
                            <center>Aksi
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            var table;

            $(document).ready(function() {
                //datatables
                table = $('#table').DataTable({

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo site_url('main/ajax_data_laut')?>",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [ 0 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                    ],
                });
            });

        </script>
        <script>
            function delete_data_darat(id)
            {
                if(confirm('Apakah Anda Yakin Untuk Menghapus Data Ini?'))
                {
                    // ajax delete data to database
                    $.ajax({
                        url : "<?php echo site_url('main/delete_data_laut')?>/"+id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data)
                        {
                            //if success reload ajax table
                            alert("Data Berhasil Dihapus");
                            window.location = "<?= site_url()?>"+"main/master?id=laut";
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Ketika Menghapus Data');
                        }
                    });

                }
            }
        </script>
<?php
    }
    else if($_SESSION['role'] == "keuangan" && $tipe == "laut"){
        ?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload').on('click', function () {
                    var nama_perusahaan = $('#nama_perusahaan').val();
                    var alamat = $('#alamat').val();
                    var no_telp = $('#no_telp').val();
                    var npwp = $('#npwp').val();
                    var form_data = new FormData();
                    var base_url = '<?= base_url();?>';
                    var text_alert;
                    form_data.append('nama_perusahaan',nama_perusahaan);
                    form_data.append('alamat',alamat);
                    form_data.append('no_telp',no_telp);
                    form_data.append('npwp',npwp);
                    $.ajax({
                        url: base_url +'index.php/main/input_data_agent', // point to server-side controller method
                        dataType: 'text', // what to expect back from the server
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (response) {
                            //$('#msg').html(response); // display success response from the server
                            text_alert = JSON.stringify(response);
                            window.alert(text_alert);
                            window.location = base_url+"main/agent";
                        },
                        error: function (response) {
                            text_alert = JSON.stringify(response);
                            window.alert(text_alert);
                        }
                    });
                });
            });
        </script>
        <style type="text/css">
            .topright {
                position: fixed;
                top: 65px;
                right: 25px;
                padding:3px 3px 3px 3px;
            }
        </style>
        <div class="container" data-role="main" class="ui-content">
            <h3>Form Master Data Agent</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="3"><p id="msg"></p></td>
                    </tr>
                    <tr>
                        <td><label>Nama Perusahaan</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_perusahaan" id="nama_perusahaan" required></td>
                    </tr>
                    <tr>
                        <td><label>Alamat</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="alamat" id="alamat" required></td>
                    </tr>
                    <tr>
                        <td><label>No Telepon</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="no_telp" id="no_telp" required></td>
                    </tr>
                    <tr>
                        <td><label>NPWP</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="npwp" id="npwp" required></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <button class="btn btn-success" id="upload">Input</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="container">
            <div class="row col-md-12">
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="70%">
                    <thead>
                    <tr>
                        <th>
                            <center>No
                        </th>
                        <th>
                            <center>Nama Perusahaan
                        </th>
                        <th>
                            <center>Alamat
                        </th>
                        <th>
                            <center>No Telepon
                        </th>
                        <th>
                            <center>NPWP
                        </th>
                        <th>
                            <center>Aksi
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>
                            <center>No
                        </th>
                        <th>
                            <center>Nama Perusahaan
                        </th>
                        <th>
                            <center>Alamat
                        </th>
                        <th>
                            <center>No Telepon
                        </th>
                        <th>
                            <center>NPWP
                        </th>
                        <th>
                            <center>Aksi
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            var table;

            $(document).ready(function() {
                //datatables
                table = $('#table').DataTable({

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo site_url('main/ajax_data_agent')?>",
                        "type": "POST"
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [ 0 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                    ],
                });
            });

        </script>
        <script>
            function delete_data_darat(id)
            {
                if(confirm('Apakah Anda Yakin Untuk Menghapus Data Ini?'))
                {
                    // ajax delete data to database
                    $.ajax({
                        url : "<?php echo site_url('main/delete_data_agent')?>/"+id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data)
                        {
                            //if success reload ajax table
                            alert("Data Berhasil Dihapus");
                            window.location = "<?= site_url()?>"+"main/master?id=agent";
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Ketika Menghapus Data');
                        }
                    });

                }
            }
        </script>
<?php
    }
    else{
        redirect('main');
    }
}
?>