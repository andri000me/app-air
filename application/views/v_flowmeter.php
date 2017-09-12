<?php
if(isset($_SESSION['session'])) {
    if($_SESSION['role'] == "wtp"){
        ?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload').on('click', function () {
                    var id_flowmeter = $('#id_flowmeter').val();
                    var nama_flowmeter = $('#nama_flowmeter').val();
                    var kondisi= $('#kondisi').val();
                    var pompa = $('#id_pompa').val();

                    var form_data = new FormData();
                    var base_url = '<?php echo base_url();?>';
                    var text_alert;
                    form_data.append('id_flowmeter',id_flowmeter);
                    form_data.append('nama_flowmeter',nama_flowmeter);
                    form_data.append('kondisi',kondisi);
                    form_data.append('id_pompa',pompa);
                    $.ajax({
                        url: base_url +'index.php/main/input_data_flowmeter', // point to server-side controller method
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
                            window.location = base_url+"main/view?id=flowmeter";
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
            <h3>Form Master Data Flow Meter</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="3"><p id="msg"></p></td>
                    </tr>
                    <tr>
                        <td><label>ID Flow Meter</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="id_flowmeter" id="id_flowmeter" required></td>
                    </tr>
                    <tr>
                        <td><label>Nama Flow Meter</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_flowmeter" id="nama_flowmeter" required></td>
                    </tr>
                    <tr>
                        <td><label>Kondisi</label></td>
                        <td>:</td>
                        <td>
                            <select class="form-control" name="kondisi" id="kondisi">
                                <option value="baik">Baik</option>
                                <option value="kurang_baik">Kurang Baik</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>ID Pompa</label></td>
                        <td>:</td>
                        <td>
                            <select class="form-control" name="id_pompa" id="id_pompa">
                                <?php foreach ($tenant as $row) {
                                    ?>
                                    <option value="<?php echo $row->id_master_pompa?>"><?php echo $row->id_pompa?> => <?php echo $row->nama_pompa?></option>
                                    <?php
                                }
                                ?>
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
                            <center>ID Flow Meter
                        </th>
                        <th>
                            <center>Nama Flow Meter
                        </th>
                        <th>
                            <center>Flow Meter Awal
                        </th>
                        <th>
                            <center>Flow Meter Akhir
                        </th>
                        <th>
                            <center>Kondisi
                        </th>
                        <th>
                            <center>ID Pompa
                        </th>
                        <th>
                            <center>Status
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
                            <center>Nama Flow Meter
                        </th>
                        <th>
                            <center>Flow Meter Awal
                        </th>
                        <th>
                            <center>Flow Meter Akhir
                        </th>
                        <th>
                            <center>Kondisi
                        </th>
                        <th>
                            <center>ID Pompa
                        </th>
                        <th>
                            <center>Status
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
                        "url": "<?php echo site_url('main/ajax_data_flowmeter')?>",
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
else{
    redirect('main');
}
