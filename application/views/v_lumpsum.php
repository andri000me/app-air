<?php
if(isset($_SESSION['session'])) {
    if($_SESSION['role'] == "operasi"){
        ?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload').on('click', function () {
                    var nama_tenant = $('#nama_tenant').val();
                    var penanggung_jawab = $('#penanggung_jawab').val();
                    var alamat= $('#alamat').val();
                    var id_flowmeter = $('#id_flowmeter').val();
                    var form_data = new FormData();
                    var base_url = '<?= base_url();?>';
                    var text_alert;
                    form_data.append('nama_tenant',nama_tenant);
                    form_data.append('penanggung_jawab',penanggung_jawab);
                    form_data.append('alamat',alamat);
                    form_data.append('id_flowmeter',id_flowmeter);
                    $.ajax({
                        url: base_url +'index.php/main/input_data_tenant', // point to server-side controller method
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
                            window.location = base_url+"main/view?id=tenant";
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
            <h3>Form Master Data Lump Sum</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="3"><p id="msg"></p></td>
                    </tr>
                    <tr>
                        <td><label>No Perjanjian</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_tenant" id="nama_tenant" required></td>
                    </tr>
                    <tr>
                        <td><label>Nama Perjanjian</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="penanggung_jawab" id="penanggung_jawab" required></td>
                    </tr>
                    <tr>
                        <td><label>Waktu Kadaluarsa</label></td>
                        <td>:</td>
                        <td>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" name="waktu_kadaluarsa" id="waktu_kadaluarsa"/>
                                    <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(function () {
                                    $('#datetimepicker2').datepicker({
                                        locale: 'id',
                                        sideBySide:true,
                                        format:'YYYY-MM-DD HH:mm'
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Nominal</label></td>
                        <td>:</td>
                        <td>
                           <input class="form-control" type="text" name="nominal" id="nominal">
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
                            <center>Nama Tenant
                        </th>
                        <th>
                            <center>Penanggung Jawab
                        </th>
                        <th>
                            <center>Lokasi
                        </th>
                        <th>
                            <center>ID Flow Meter
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
                            <center>Nama Tenant
                        </th>
                        <th>
                            <center>Penanggung Jawab
                        </th>
                        <th>
                            <center>Lokasi
                        </th>
                        <th>
                            <center>ID Flow Meter
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
                        "url": "<?php echo site_url('main/ajax_data_tenant')?>",
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
}
