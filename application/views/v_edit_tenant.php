<?php
if(isset($_SESSION['session'])) {
    if($_SESSION['role'] == "wtp") {
        ?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload_doku').on('click', function () {
                    var id = $('#id').val();
                    var nama_tenant = $('#nama_tenant').val();
                    var penanggung_jawab = $('#penanggung_jawab').val();
                    var alamat = $('#alamat').val();
                    var id_flowmeter = $('#id_flowmeter').val();
                    var form_data = new FormData();
                    var base_url = '<?= base_url();?>';
                    var text_alert;

                    form_data.append('id_tenant',id);
                    form_data.append('nama_tenant', nama_tenant);
                    form_data.append('penanggung_jawab',penanggung_jawab);
                    form_data.append('alamat',alamat);
                    form_data.append('id_flowmeter',id_flowmeter);
                    $.ajax({
                        url: base_url +'main/edit_tenant', // point to server-side controller method
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
                            window.location.replace(base_url+"main/view?id=tenant");
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
            <h3>Form Edit Data Tenant</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="2"><p id="msg"></p></td>
                        <td><input name="id" id="id" hidden value="<?= $id ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Nama Tenant</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_tenant" id="nama_tenant" required value="<?= $isi['nama_tenant'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Penanggung Jawab</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="penanggung_jawab" id="penanggung_jawab" required value="<?= $isi['penanggung_jawab'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Lokasi</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="alamat" id="alamat" required value="<?= $isi['alamat'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>ID FLow Meter</label></td>
                        <td>:</td>
                        <td>
                            <select class="form-control" name="id_flowmeter" id="id_flowmeter">
                                <?php foreach ($tenant as $row) {
                                    if($row->id_flowmeter == $isi['id_flowmeter']) {
                                        ?>
                                        <option selected value="<?= $row->id_flow ?>"><?= $row->id_flowmeter ?>
                                            => <?= $row->nama_flowmeter ?></option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value="<?= $row->id_flow ?>"><?= $row->id_flowmeter ?>
                                        => <?= $row->nama_flowmeter ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
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
    else if($_SESSION['role'] == "operasi"){
    ?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload_doku').on('click', function () {
                    var id = $('#id').val();
                    var nama_tenant = $('#nama_tenant').val();
                    var penanggung_jawab = $('#penanggung_jawab').val();
                    var alamat = $('#alamat').val();
                    var id_lumpsum = $('#id_lumpsum').val();
                    var form_data = new FormData();
                    var base_url = '<?= base_url();?>';
                    var text_alert;

                    form_data.append('id_tenant',id);
                    form_data.append('nama_tenant', nama_tenant);
                    form_data.append('penanggung_jawab',penanggung_jawab);
                    form_data.append('alamat',alamat);
                    form_data.append('id_lumpsum',id_lumpsum);
                    $.ajax({
                        url: base_url +'main/edit_tenant', // point to server-side controller method
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
                            window.location.replace(base_url+"main/view?id=tenant");
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
            <h3>Form Edit Data Tenant</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="2"><p id="msg"></p></td>
                        <td><input name="id" id="id" hidden value="<?= $id ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Nama Tenant</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_tenant" id="nama_tenant" required value="<?= $isi['nama_tenant'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Penanggung Jawab</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="penanggung_jawab" id="penanggung_jawab" required value="<?= $isi['penanggung_jawab'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Lokasi</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="alamat" id="alamat" required value="<?= $isi['alamat'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>ID Lumpsum</label></td>
                        <td>:</td>
                        <td>
                            <select class="form-control" name="id_lumpsum" id="id_lumpsum">
                                <?php foreach ($tenant as $row) {
                                    if($row->id_lumpsum == $isi['id_lumpsum']) {
                                        ?>
                                        <option selected value="<?= $row->id_lumpsum ?>"><?= $row->id_lumpsum ?>
                                            => <?= $row->no_perjanjian ?></option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value="<?= $row->id_lumpsum ?>"><?= $row->id_lumpsum ?>
                                            => <?= $row->no_perjanjian ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
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