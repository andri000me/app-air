<script type="text/javascript">
    $(document).ready(function (e) {
        $('#upload_doku').on('click', function () {
            var id = $('#id').val();
            var tipe_pengguna = $('#tipe_pengguna').val();
            var kawasan = $('#kawasan').val();
            var tarif= $('#tarif').val();
            var tipe = $('#tipe').val();
            var diskon = $('#diskon').val();
            var form_data = new FormData();
            var base_url = '<?= base_url();?>';
            var text_alert;

            form_data.append('id', id);
            form_data.append('tipe_pengguna',tipe_pengguna);
            form_data.append('kawasan',kawasan);
            form_data.append('tarif',tarif);
            form_data.append('tipe',tipe);
            form_data.append('diskon',diskon);
            $.ajax({
                url: base_url +'main/edit_tarif', // point to server-side controller method
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
                    window.location.replace(base_url+"main/tarif");
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
                        <td><label>Tipe Pengguna Jasa</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="tipe_pengguna" id="tipe_pengguna" required value="<?= $isi['tipe_pengguna_jasa']?>"></td>
                    </tr>
                    <tr>
                        <td><label>Kawasan</label></td>
                        <td>:</td>
                        <td>
                            <select name="kawasan" id="kawasan" class="form-control"
                                <?php
                                    if($isi['kawasan'] == "KIK"){
                                        print 'selected';
                                    } else if($isi['kawasan'] == "NON-KIK"){
                                        print 'selected';
                                    } else {
                                        print 'selected';
                                    }
                                ?>
                            >
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
                            <select name="tipe" id="tipe" class="form-control" <?php
                                if($isi['tipe'] == "laut"){
                                    print 'selected';
                                } else if ($isi['tipe'] == "laut"){
                                    print 'selected';
                                } else {
                                    print 'selected';
                                }
                            ?>>
                                <option value="laut">Laut</option>
                                <option value="darat">Darat</option>
                                <option value="">Non</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Tarif</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="tarif" id="tarif" required value="<?= $isi['tarif']?>"></td>
                    </tr>
                    <tr>
                        <td><label>Diskon</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="diskon" id="diskon" required value="<?= $isi['diskon']?>"></td>
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