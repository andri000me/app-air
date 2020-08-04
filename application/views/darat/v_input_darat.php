<?php
if(($this->session->userdata('role_name') == "loket" || $this->session->userdata('role_name') == "admin")){
?>
<script>
    $(function () {
        var id = $('#nama_pembeli').val();
        $("#nama_pembeli").autocomplete({
            minLength:1,
            delay:0,
            source:'<?php echo site_url('darat/get_pembeli_darat/'); ?>' + id,
            select:function(event, ui){
                $('#id_pengguna').val(ui.item.id);
                $('#alamat_pembeli').val(ui.item.alamat);
                $('#nama_pemohon').val(ui.item.nama);
                $('#no_telp').val(ui.item.no_telp);
                $('#pengguna').val(ui.item.pengguna);
            }
        });
    });

    var table;

    $(document).ready(function() {
        $.ajax({
            url:'<?php echo site_url('master/populatePenggunaDarat')?>',
            type:'POST',
            dataType: 'json',
            success: function( json ) {
                $.each(json, function(i, value) {
                    $('#pengguna').append($('<option>').text(value.tipe_pengguna_jasa).attr('value', value.id_tarif));
                });
            }
        });
    });
</script>
<body>
    <div class="container container-fluid">
        <div class="row col-sm-6">
            <center><h4>Form Permintaan Pelayanan Jasa Air Bersih</h4></center><br>
            <?php echo validation_errors(); ?>
            <form method="post" action="<?php echo base_url(). 'darat/transaksi_darat'; ?>">
                <table class="table table-striped">
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="pelunasan">Pelunasan</label>
                            </td>
                            <td>:</td>
                            <td>
                                <select name="pelunasan" id="pelunasan" class="form-control">
                                    <option value="cash">Cash</option>
                                    <option value="piutang">Piutang</option>
                                </select>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="nama_pembeli">Nama Pembeli</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" placeholder="Masukkan Nama Pembeli"/>
                                <input type="hidden" class="form-control" id="id_pengguna" name="id_pengguna" />
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="alamat_pembeli">Alamat Pembeli</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control" id="alamat_pembeli" name="alamat_pembeli" placeholder="Masukkan Alamat Pembeli"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="alamat_pembeli">No Telepon</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan No Telepon"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="alamat_pembeli">Nama Pemohon</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control" id="nama_pemohon" name="nama_pemohon" placeholder="Masukkan Nama Pemohon"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="pengguna_jasa">Jenis Pengguna Jasa</label>
                            </td>
                            <td>:</td>
                            <td>
                                <select name="pengguna" id="pengguna" class="form-control">
                                    <option value="">----</option>
                                    <?php foreach($pengguna as $rowpengguna){?>
                                        <option value="<?php echo $rowpengguna->id_tarif?>"><?php echo $rowpengguna->tipe_pengguna_jasa?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="tanggal">Waktu Pengantaran</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input type='text' class="form-control" name="tgl_permintaan" id="tgl_permintaan"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker2').datetimepicker({
                                            locale: 'id',
                                            sideBySide:true,
                                            format:'YYYY-MM-DD HH:mm'
                                        });
                                    });
                                </script>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="total_pengisian">Total Permintaan Pengisian</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="number" step=0.01 class="form-control" id="tonnase" name="tonnase" placeholder="Satuan (Ton)"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <input type="submit" class="form-control btn btn-primary" id="input" name="Input" value="Submit" />
                            </td>
                        </div>
                    </tr>
                </table>
            </form>
        </div>
    </div>
  </body>
    <?php
}
else{
    $web = base_url('main');
    ?>
<script>
    alert('Anda Tidak Memiliki Hak Akses Ke Halaman Ini. Silahkan Login Terlebih Dahulu');
    window.location.replace('<?php echo $web;?>');
</script>
    <?php
}
    ?>
