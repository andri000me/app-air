<?php
if(isset($_SESSION['session'])) {
    if($_SESSION['role'] == "operasi" || $_SESSION['role'] == "admin"){
    ?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload_doku').on('click', function () {
                    var id = $('#id').val();
                    var no_perjanjian = $('#no_perjanjian').val();
                    var nama_perjanjian = $('#nama_perjanjian').val();
                    var waktu_kadaluarsa = $('#waktu_kadaluarsa').val();
                    var nominal = $('#nominal').val();
                    var tenant = $('#tenant').val();

                    var form_data = new FormData();
                    var base_url = '<?php echo base_url();?>';
                    var text_alert;

                    form_data.append('id_lumpsum',id);
                    form_data.append('no_perjanjian', no_perjanjian);
                    form_data.append('nama_perjanjian',nama_perjanjian);
                    form_data.append('waktu_kadaluarsa',waktu_kadaluarsa);
                    form_data.append('nominal',nominal);
                    form_data.append('id_tenant',tenant);
                    $.ajax({
                        url: base_url +'main/edit_lumpsum', // point to server-side controller method
                        dataType: 'text', // what to expect back from the server
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (response) {
                            //$('#msg').html(response); // display success response from the server
                            text_alert = JSON.stringify(response);
                            alert(text_alert);
                            window.location.replace(base_url+"main/view?id=lumpsum");
                            //console.log(text_alert);
                        },
                        error: function (response) {
                            //$('#msg').html(response); // display error response from the server
                            text_alert = JSON.stringify(response);
                            alert(text_alert);
                            //console.log(text_alert);
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
            <h3>Form Edit Data Lumpsum</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="2"><p id="msg"></p></td>
                        <td><input name="id" id="id" hidden value="<?php echo $id ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>No Perjanjian</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="no_perjanjian" id="no_perjanjian" required value="<?php echo $isi['no_perjanjian'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Perihal</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_perjanjian" id="nama_perjanjian" required value="<?php echo $isi['perihal'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Nama Tenant</label></td>
                        <td>:</td>
                        <td>
                            <select class="form-control" name="tenant" id="tenant" onchange="showTenant(this.value)">
                                <?php
                                foreach ($lumpsum as $row) {
                                    if ($row->id_tenant == $isi['id_tenant']) {
                                        ?>
                                        <option selected value="<?php echo $row->id_tenant ?>"><?php echo $row->nama_tenant ?></option>
                                        <?php
                                    } else{
                                        ?>
                                        <option value="<?php echo $row->id_tenant ?>"><?php echo $row->nama_tenant ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
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
                            <input class="form-control" type="text" name="nominal" id="nominal" value="<?php echo $isi['nominal'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><label>Waktu Kadaluarsa</label></td>
                        <td>:</td>
                        <td>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" name="waktu_kadaluarsa" id="waktu_kadaluarsa" value="<?php echo $isi['waktu_kadaluarsa'] ?>"/>
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
                        <td colspan="3">
                            <button class="btn btn-success" id="upload_doku">Ubah</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <?php
    }
    else{
        redirect('main');
    }
}
else{
    redirect('main');
}
?>