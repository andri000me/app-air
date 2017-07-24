<script type="text/javascript">
    $(document).ready(function (e) {
        $('#upload_doku').on('click', function () {
            var id = $('#id').val();
            var nama = $('#nama_ruko').val();
            var alamat = $('#alamat').val();
            var no_telp = $('#no_telp').val();
            var form_data = new FormData();
            var base_url = '<?= base_url();?>';
            var text_alert;

            form_data.append('id', id);
            form_data.append('nama',nama);
            form_data.append('alamat',alamat);
            form_data.append('no_telp',no_telp);
            $.ajax({
                url: base_url +'main/edit_ruko', // point to server-side controller method
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
                    window.location.replace(base_url+"main/master?id=ruko");
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
<?php
if(isset($_SESSION['session'])) {
    if($_SESSION['role'] == "operasi") {
        ?>
        <div class="container" data-role="main" class="ui-content">
            <h3>Form Edit Master Tahun</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="2"><p id="msg"></p></td>
                        <td><input name="id" id="id" hidden value="<?= $id ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>ID Flow Meter</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="id_flow" id="id_flow" required value="<?= $isi['id_flowmeter'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Nama Ruko</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_ruko" id="nama_ruko" required value="<?= $isi['nama_ruko'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Alamat</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="alamat" id="alamat" required value="<?= $isi['alamat'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>No Telepon</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="no_telp" id="no_telp" required value="<?= $isi['no_telp'] ?>"></td>
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
}
?>