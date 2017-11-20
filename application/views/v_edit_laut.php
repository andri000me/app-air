<script type="text/javascript">
    $(document).ready(function (e) {
        $('#upload_doku').on('click', function () {
            var id = $('#id').val();
            var id_lct = $('#id_lct').val();
            var nama = $('#nama_lct').val();
            var nama_perusahaan = $('#id_agent').val();
            var pengguna_jasa = $('#pengguna').val();
            var form_data = new FormData();
            var base_url = '<?php echo base_url();?>';
            var text_alert;

            form_data.append('id',id);
            form_data.append('id_lct',id_lct);
            form_data.append('nama',nama);
            form_data.append('nama_perusahaan',nama_perusahaan);
            form_data.append('pengguna_jasa',pengguna_jasa);
            $.ajax({
                url: base_url +'main/edit_laut', // point to server-side controller method
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
                    window.location.replace(base_url+"main/master?id=laut");
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
    function showAgent(str) {
        if (str=="") {
            document.getElementById("alamat").innerHTML="";
            document.getElementById("no_telp").innerHTML="";
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
                document.getElementById("alamat").value= data.alamat;
                document.getElementById("no_telp").value=data.no_telp;
            }
        }
        xmlhttp.open("GET","<?php echo base_url('main/cari_agent?id=')?>"+str,true);
        xmlhttp.send();
    }
</script>
<?php
if(isset($_SESSION['session'])) {
    if($_SESSION['role'] == "perencanaan" || $_SESSION['role'] == "admin") {
        ?>
        <div class="container" data-role="main" class="ui-content">
            <h3>Form Edit Master Data VESSEL</h3>
            <div class="row col-md-5">
                <table class="table">
                    <tr>
                        <td colspan="2"><p id="msg"></p></td>
                        <td><input name="id" id="id" hidden value="<?php echo $id ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Nama VESSEL</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="nama_lct" id="nama_lct"  value="<?php echo $isi['nama_vessel'] ?>" required ></td>
                    </tr>
                    <tr>
                        <td><label>ID VESSEL</label></td>
                        <td>:</td>
                        <td><input class="form-control" type="text" name="id_lct" id="id_lct" value="<?php echo $isi['id_vessel'] ?>" required></td>
                    </tr>
                    <tr>
                        <td><label>Nama Perusahaan</label></td>
                        <td>:</td>
                        <td>
                            <select name="id_agent" id="id_agent" onchange="showAgent(this.value)">
                                <?php
                                foreach ($agent as $row){
                                    if($row->id_agent == $isi['id_agent']){
                                    ?>
                                        <option selected value="<?php echo $row->id_agent?>"><?php echo $row->nama_agent?></option>
                                    <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $row->id_agent?>"><?php echo $row->nama_agent?></option>
                                    <?php
                                        }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Alamat</label></td>
                        <td>:</td>
                        <td><input disabled class="form-control" type="text" name="alamat" id="alamat" value="<?php echo $isi['alamat'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>No Telepon</label></td>
                        <td>:</td>
                        <td><input disabled class="form-control" type="text" name="no_telp" id="no_telp" value="<?php echo $isi['no_telp'] ?>"></td>
                    </tr>
                    <tr>
                        <td><label>Jenis Kapal</label></td>
                        <td>:</td>
                        <td>
                            <select name="pengguna" id="pengguna" class="form-control">
                                <?php foreach($pengguna as $rowpengguna){
                                    if($rowpengguna->id_tarif == $isi['pengguna']){
                                    ?>
                                    <option selected value="<?php echo$rowpengguna->id_tarif?>"><?php echo$rowpengguna->tipe_pengguna_jasa?></option>
                                <?php } else {?>
                                    <option value="<?php echo$rowpengguna->id_tarif?>"><?php echo$rowpengguna->tipe_pengguna_jasa?></option>
                                <?php }}?>
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