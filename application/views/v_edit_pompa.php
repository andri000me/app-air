<script type="text/javascript">
    $(document).ready(function (e) {
        $('#upload_doku').on('click', function () {
            var id = $('#id').val();
            var id_pompa = $('#id_pompa').val();
            var nama_pompa = $('#nama_pompa').val();
            var kondisi = $('#kondisi').val();
            var id_sumur = $('#id_sumur').val();
            var status = $('#status_aktif').val();

            var form_data = new FormData();
            var base_url = '<?php echo base_url();?>';
            var text_alert;

            form_data.append('id',id)
            form_data.append('id_pompa',id_pompa);
            form_data.append('nama_pompa', nama_pompa);
            form_data.append('kondisi',kondisi);
            form_data.append('status',status);
            form_data.append('id_sumur',id_sumur);

            $.ajax({
                url: base_url +'main/edit_pompa', // point to server-side controller method
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
                    window.location.replace(base_url+"main/view?id=pompa");
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
            <h3>Form Edit Data Pompa</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="2"><p id="msg"></p></td>
                        <td><input name="id" id="id" hidden value="<?php echo $id ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>ID Pompa</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="id_pompa" id="id_pompa" required value="<?php echo $isi['id_pompa'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Nama Pompa</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_pompa" id="nama_pompa" required value="<?php echo $isi['nama_pompa'] ?>"></td>
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
                        <td><label>Kondisi</label></td>
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
                        <td><label>ID Sumur</label></td>
                        <td>:</td>
                        <td>
                            <input type="hidden" id="id_sum" name="id_sum" value="<?php echo $isi['id_sumur']?>"/>
                            <select class="form-control" name="id_sumur" id="id_sumur">
                                <?php foreach ($pompa as $row) {
                                    if($row->id_master_sumur == $isi['id_sumur']) {
                                        ?>
                                        <option selected value="<?php echo $row->id_master_sumur ?>"><?php echo $row->id_sumur ?>
                                            => <?php echo $row->nama_sumur ?></option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value="<?php echo $row->id_master_sumur ?>"><?php echo $row->id_sumur ?>
                                            => <?php echo $row->nama_sumur ?></option>
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
} else{
    redirect('main');
}
?>