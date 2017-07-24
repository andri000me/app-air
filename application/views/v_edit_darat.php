<script type="text/javascript">
    $(document).ready(function (e) {
        $('#upload_doku').on('click', function () {
            var id = $('#id').val();
            var nama = $('#nama_pembeli').val();
            var alamat = $('#alamat').val();
            var no_telp = $('#no_telp').val();
            var pengguna = $('#pengguna').val();
            var form_data = new FormData();
            var base_url = '<?= base_url();?>';
            var text_alert;

            form_data.append('id', id);
            form_data.append('nama',nama);
            form_data.append('alamat',alamat);
            form_data.append('no_telp',no_telp);
            form_data.append('pengguna',pengguna);
            $.ajax({
                url: base_url +'main/edit_darat', // point to server-side controller method
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
                    window.location.replace(base_url+"main/master?id=darat");
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
    if($_SESSION['role'] == "loket") {
        ?>
        <div class="container" data-role="main" class="ui-content">
            <script>
                var myVar = setInterval(showNotifAntar, 3000);

                function showNotifAntar() {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            if(xmlhttp.responseText != "0")
                                document.getElementById("notifAntar").innerHTML = "<a class='btn btn-danger' href='<?= base_url("main/view?id=monitoring_darat")?>'><span class='glyphicon glyphicon-refresh'> Antar : " + xmlhttp.responseText + "</a>";
                        }
                    };
                    xmlhttp.open("GET", "<?php echo base_url('main/cekNotifAntar') ?>" , true);
                    xmlhttp.send();
                }
            </script>
            <div class="topright" align="right">
                <span id="notifAntar" ></span>
            </div>
            <h3>Form Edit Master Pengguna Jasa</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="2"><p id="msg"></p></td>
                        <td><input name="id" id="id" hidden value="<?= $id ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Nama Pengguna Jasa</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_pembeli" id="nama_pembeli" required value="<?= $isi['nama_pembeli'] ?>"></td>
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
                        <td><label>Jenis Pengguna Jasa</label></td>
                        <td>:</td>
                        <td>
                            <select name="pengguna" id="pengguna" class="form-control">
                                <?php foreach($pengguna as $rowpengguna){
                                    if($isi['pengguna'] == $rowpengguna->id_tarif) {
                                    ?>
                                    <option selected value="<?=$rowpengguna->id_tarif?>"><?=$rowpengguna->tipe_pengguna_jasa?></option>
                                <?php }else { ?>
                                    <option value="<?=$rowpengguna->id_tarif?>"><?=$rowpengguna->tipe_pengguna_jasa?></option>
                                <?php }} ?>
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
}
?>