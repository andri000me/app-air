<?php
if(isset($_SESSION['session'])) {
    if($_SESSION['role'] == "operasi"){
?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload').on('click', function () {
                    var tipe_pengguna = $('#tipe_pengguna').val();
                    var kawasan = $('#kawasan').val();
                    var tarif= $('#tarif').val();
                    var tipe = $('#tipe').val();
                    var diskon = $('#diskon').val();
                    var form_data = new FormData();
                    var base_url = '<?= base_url();?>';
                    var text_alert;
                    form_data.append('tipe_pengguna',tipe_pengguna);
                    form_data.append('kawasan',kawasan);
                    form_data.append('tarif',tarif);
                    form_data.append('tipe',tipe);
                    form_data.append('diskon',diskon);
                    $.ajax({
                        url: base_url +'index.php/main/input_data_tarif', // point to server-side controller method
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
                            window.location = base_url+"main/tarif";
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
            <h3>Form Master Data Tarif</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="3"><p id="msg"></p></td>
                    </tr>
                    <tr>
                        <td><label>Tipe Pengguna Jasa</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="tipe_pengguna" id="tipe_pengguna" required></td>
                    </tr>
                    <tr>
                        <td><label>Kawasan</label></td>
                        <td>:</td>
                        <td>
                            <select name="kawasan" id="kawasan" class="form-control">
                                <option></option>
                                <option value="KIK">Kawasan Indrusti Kariangau</option>
                                <option value="NON-KIK">Kawasan Non Indrusti Kariangau</option>
                                <option value="">Non</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Tipe</label></td>
                        <td>:</td>
                        <td>
                            <select name="tipe" id="tipe" class="form-control">
                                <option></option>
                                <option value="laut">Laut</option>
                                <option value="darat">Darat</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Tarif</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="tarif" id="tarif" required></td>
                    </tr>
                    <tr>
                        <td><label>Diskon</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="diskon" id="diskon" required></td>
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
                            <center>Tipe Pengguna Jasa
                        </th>
                        <th>
                            <center>Kawasan
                        </th>
                        <th>
                            <center>Tipe
                        </th>
                        <th>
                            <center>Tarif
                        </th>
                        <th>
                            <center>Diskon
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
                            <center>Tipe Pengguna Jasa
                        </th>
                        <th>
                            <center>Kawasan
                        </th>
                        <th>
                            <center>Tipe
                        </th>
                        <th>
                            <center>Tarif
                        </th>
                        <th>
                            <center>Diskon
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
                        "url": "<?php echo site_url('main/ajax_data_tarif')?>",
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
            function delete_data_tarif(id)
            {
                if(confirm('Apakah Anda Yakin Untuk Menghapus Data Ini?'))
                {
                    // ajax delete data to database
                    $.ajax({
                        url : "<?php echo site_url('main/delete_data_tarif')?>/"+id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data)
                        {
                            //if success reload ajax table
                            alert("Data Berhasil Dihapus");
                            window.location = "<?= site_url()?>"+"main/tarif";
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
