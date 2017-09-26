<?php
if(isset($_SESSION['session'])) {
    if($_SESSION['role'] == "admin"){
        ?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload').on('click', function () {
                    var id_sumur = $('#id_sumur').val();
                    var nama_sumur = $('#nama_sumur').val();
                    var lokasi= $('#lokasi').val();
                    var debit_air = $('#debit_air').val();

                    var form_data = new FormData();
                    var base_url = '<?php echo base_url();?>';
                    var text_alert;
                    form_data.append('id_sumur',id_sumur);
                    form_data.append('nama_sumur',nama_sumur);
                    form_data.append('lokasi',lokasi);
                    form_data.append('debit_air',debit_air);
                    $.ajax({
                        url: base_url +'index.php/main/input_data_sumur', // point to server-side controller method
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
                            window.location = base_url+"main/view?id=sumur";
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
            <h3>Form Master Data Sumur</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="3"><p id="msg"></p></td>
                    </tr>
                    <tr>
                        <td><label>ID Sumur</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="id_sumur" id="id_sumur" required></td>
                    </tr>
                    <tr>
                        <td><label>Nama Sumur</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_sumur" id="nama_sumur" required></td>
                    </tr>
                    <tr>
                        <td><label>Lokasi</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="lokasi" id="lokasi" required></td>
                    </tr>
                    <tr>
                        <td><label>Debit Air (L/Detik)</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="debit_air" id="debit_air" required></td>
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
                            <center>ID Sumur
                        </th>
                        <th>
                            <center>Nama Sumur
                        </th>
                        <th>
                            <center>Lokasi
                        </th>
                        <th>
                            <center>Debit Air (L/Detik)
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
                            <center>ID Sumur
                        </th>
                        <th>
                            <center>Nama Sumur
                        </th>
                        <th>
                            <center>Lokasi
                        </th>
                        <th>
                            <center>Debit Air (L/Detik)
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
                        "url": "<?php echo site_url('main/ajax_data_sumur')?>",
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
        <?php
    }
    else{
        redirect('main');
    }
} else{
    redirect('main');
}
