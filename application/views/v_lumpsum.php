<?php
if(isset($_SESSION['session'])) {
    if($_SESSION['role'] == "operasi" || $_SESSION['role'] == "admin"){
        ?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload').on('click', function () {
                    var no_perjanjian = $('#no_perjanjian').val();
                    var nama_perjanjian = $('#nama_perjanjian').val();
                    var waktu_kadaluarsa = $('#waktu_kadaluarsa').val();
                    var nominal = $('#nominal').val();
                    var tenant = $('#tenant').val();

                    var form_data = new FormData();
                    var base_url = '<?php echo base_url();?>';
                    var text_alert;
                    form_data.append('no_perjanjian',no_perjanjian);
                    form_data.append('nama_perjanjian',nama_perjanjian);
                    form_data.append('waktu_kadaluarsa',waktu_kadaluarsa);
                    form_data.append('nominal',nominal);
                    form_data.append('tenant',tenant);
                    $.ajax({
                        url: base_url +'index.php/main/input_data_lumpsum', // point to server-side controller method
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
                            window.location = base_url+"main/view?id=lumpsum";
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
            function showTenant(str) {
                if (str=="") {
                    document.getElementById("penanggung_jawab").innerHTML="";
                    document.getElementById("lokasi").innerHTML="";
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
                        document.getElementById("penanggung_jawab").value= data.penanggung_jawab;
                        document.getElementById("lokasi").value=data.lokasi;
                    }
                }
                xmlhttp.open("GET","<?php echo base_url('main/cari_tenant?id=')?>"+str,true);
                xmlhttp.send();
            }
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
                        <td><input class="form-control" type="text" name="no_perjanjian" id="no_perjanjian" required></td>
                    </tr>
                    <tr>
                        <td><label>Perihal</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_perjanjian" id="nama_perjanjian" required></td>
                    </tr>
                    <tr>
                        <td><label>Nama Tenant</label></td>
                        <td>:</td>
                        <td>
                            <select class="form-control" name="tenant" id="tenant" onchange="showTenant(this.value)">
                                <option value="">-----</option>
                                <?php
                                foreach ($lumpsum as $row){
                                ?>
                                    <option value="<?php echo $row->id_tenant?>"><?php echo $row->nama_tenant?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
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
                                        format: "yyyy-mm-dd",
                                        autoclose: true,
                                        todayHighlight: true
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Penanggung Jawab</label></td>
                        <td>:</td>
                        <td>
                            <input class="form-control" disabled type="text" name="penanggung_jawab" id="penanggung_jawab">
                        </td>
                    </tr>
                    <tr>
                        <td><label>Lokasi Tenant</label></td>
                        <td>:</td>
                        <td>
                            <input class="form-control" disabled type="text" name="lokasi" id="lokasi">
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
                            <center>No Perjanjian
                        </th>
                        <th>
                            <center>Perihal
                        </th>
                        <th>
                            <center>Waktu Kadaluarsa
                        </th>
                        <th>
                            <center>Nominal
                        </th>
                        <th>
                            <center>Nama Tenant
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
                            <center>No Perjanjian
                        </th>
                        <th>
                            <center>Perihal
                        </th>
                        <th>
                            <center>Waktu Kadaluarsa
                        </th>
                        <th>
                            <center>Nominal
                        </th>
                        <th>
                            <center>Nama Tenant
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
                        "url": "<?php echo site_url('main/ajax_data_lumpsum')?>",
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
