<?php
if(isset($_SESSION['session'])) {
    if($_SESSION['role'] == "operasi"){
    ?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload_doku').on('click', function () {
                    var id = $('#id').val();
                    var no_perjanjian = $('#no_perjanjian').val();
                    var nama_perjanjian = $('#nama_perjanjian').val();
                    var waktu_kadaluarsa = $('#waktu_kadaluarsa').val();
                    var nominal = $('#nominal').val();

                    var form_data = new FormData();
                    var base_url = '<?= base_url();?>';
                    var text_alert;

                    form_data.append('id_lumpsum',id);
                    form_data.append('no_perjanjian', no_perjanjian);
                    form_data.append('nama_perjanjian',nama_perjanjian);
                    form_data.append('waktu_kadaluarsa',waktu_kadaluarsa);
                    form_data.append('nominal',nominal);
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
        <div class="container" data-role="main" class="ui-content">
            <h3>Form Edit Data Lumpsum</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="2"><p id="msg"></p></td>
                        <td><input name="id" id="id" hidden value="<?= $id ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>No Perjanjian</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="no_perjanjian" id="no_perjanjian" required value="<?= $isi['no_perjanjian'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Nama Perjanjian</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_perjanjian" id="nama_perjanjian" required value="<?= $isi['nama_perjanjian'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Waktu Kadaluarsa</label></td>
                        <td>:</td>
                        <td>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" name="waktu_kadaluarsa" id="waktu_kadaluarsa" value="<?= $isi['waktu_kadaluarsa'] ?>"/>
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
                        <td><label>Nominal</label></td>
                        <td>:</td>
                        <td>
                            <input class="form-control" type="text" name="nominal" id="nominal" value="<?= $isi['nominal'] ?>">
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