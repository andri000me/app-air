<script type="text/javascript">
    $(document).ready(function (e) {
        $('#upload_doku').on('click', function () {
            var id = $('#id').val();
            var id_sumur = $('#id_sumur').val();
            var nama_sumur = $('#nama_sumur').val();
            var lokasi = $('#lokasi').val();
            var form_data = new FormData();
            var base_url = '<?= base_url();?>';
            var text_alert;

            form_data.append('id',id)
            form_data.append('id_sumur',id_sumur);
            form_data.append('nama_sumur', nama_sumur);
            form_data.append('lokasi',lokasi);
            $.ajax({
                url: base_url +'main/edit_sumur', // point to server-side controller method
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
                    window.location.replace(base_url+"main/view?id=sumur");
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
    if($_SESSION['role'] == "wtp") {
        ?>
        <div class="container" data-role="main" class="ui-content">
            <h3>Form Edit Data Sumur</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="2"><p id="msg"></p></td>
                        <td><input name="id" id="id" hidden value="<?= $id ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>ID Sumur</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="id_sumur" id="id_sumur" required value="<?= $isi['id_sumur'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Nama Sumur</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_sumur" id="nama_sumur" required value="<?= $isi['nama_sumur'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Lokasi</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="lokasi" id="lokasi" required value="<?= $isi['lokasi'] ?>"></td>
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
} else{
    redirect('main');
}
?>