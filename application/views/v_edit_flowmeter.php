<script type="text/javascript">
    $(document).ready(function (e) {
        $('#upload_doku').on('click', function () {
            var id = $('#id').val();
            var id_flowmeter = $('#id_flowmeter').val();
            var nama_flowmeter = $('#nama_flowmeter').val();
            var kondisi = $('#kondisi').val();
            var flowmeter_awal = $('#flowmeter_awal').val();
            var flowmeter_akhir = $('#flowmeter_akhir').val();
            var status_aktif = $('#status_aktif').val();

            var form_data = new FormData();
            var base_url = '<?= base_url();?>';
            var text_alert;

            form_data.append('id_flow',id);
            form_data.append('id_flowmeter',id_flowmeter);
            form_data.append('nama_flowmeter', nama_flowmeter);
            form_data.append('kondisi',kondisi);
            form_data.append('flowmeter_awal',flowmeter_awal);
            form_data.append('flowmeter_akhir',flowmeter_akhir);

            $.ajax({
                url: base_url +'main/edit_flowmeter', // point to server-side controller method
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
                    window.location.replace(base_url+"main/view?id=flowmeter");
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
            <h3>Form Edit Data Flow Meter</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="2"><p id="msg"></p></td>
                        <td><input name="id" id="id" hidden value="<?= $id ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>ID Flow Meter</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="id_flowmeter" id="id_flowmeter" required value="<?= $isi['id_flowmeter'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Nama Flow Meter</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_flowmeter" id="nama_flowmeter" required value="<?= $isi['nama_flowmeter'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Kondisi</label></td>
                        <td>:</td>
                        <td>
                            <select class="form-control" id="kondisi" name="kondisi">
                                <?php
                                if($isi['kondisi'] == "baik"){
                                    ?>
                                    <option selected value="baik">Baik</option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="baik">Baik</option>
                                    <?php
                                }
                                ?>
                                <?php
                                if($isi['kondisi'] == "kurang_baik"){
                                    ?>
                                    <option selected value="kurang_baik">Kurang Baik</option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="kurang_baik">Kurang Baik</option>
                                    <?php
                                }
                                ?>
                                <?php
                                if($isi['kondisi'] == "rusak"){
                                    ?>
                                    <option selected value="rusak">Rusak</option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="rusak">rusak</option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Status Aktif</label></td>
                        <td>:</td>
                        <td>
                            <select class="form-control" id="status_aktif" name="status_aktif">
                                <?php
                                if($isi['status_aktif'] == 1){
                                    ?>
                                    <option selected value="1">Aktif</option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="1">Aktif</option>
                                    <?php
                                }
                                ?>
                                <?php
                                if($isi['status_aktif'] == 0){
                                    ?>
                                    <option selected value="0">Tidak Aktif</option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="0">Tidak Aktif</option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Flow Meter Awal</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="flowmeter_awal" id="flowmeter_awal" required value="<?= $isi['flowmeter_awal'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Flow Meter Akhir</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="flowmeter_akhir" id="flowmeter_akhir" required value="<?= $isi['flowmeter_akhir'] ?>"></td>
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