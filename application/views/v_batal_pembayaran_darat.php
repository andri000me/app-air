<?php
if($this->session->userdata('role') == "keuangan" && $this->session->userdata('session') != NULL){
?>
    <script type="text/javascript">
        //ambil data ketika form pencarian memiliki perubahan value

        function search() {
            var kwitansi = $('#no_kwitansi').val();
            if(kwitansi != ""){
                $.ajax({
                    url: "<?= base_url('main/cari_batal')?>",
                    method: "POST",
                    data: {kwitansi : kwitansi},
                    dataType: 'json',
                    beforeSend: function(e) {
                        if(e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                        document.getElementById("error").innerHTML = "";
                    },
                    success: function(response) {
                        if(response.status == "success"){
                            document.getElementById("error").innerHTML = "";
                            $("#nama_pembeli").val(response.nama);
                            $("#alamat_pembeli").val(response.alamat);
                            $("#no_telp").val(response.telepon);
                            $("#pengguna").val(response.pengguna);
                            $("#tanggal").val(response.tanggal);
                            $("#jam").val(response.jam);
                            $("#tonnase").val(response.tonnase);
                            $("#pembayaran").val(response.pembayaran);
                            document.getElementById("input").removeAttribute("disabled");
                            document.getElementById("error").innerHTML = "";
                        }else{
                            document.getElementById("input").setAttribute("disabled", "disabled");
                            $("#nama_pembeli").val('');
                            $("#alamat_pembeli").val('');
                            $("#no_telp").val('');
                            $("#pengguna").val('');
                            $("#tanggal").val('');
                            $("#jam").val('');
                            $("#tonnase").val('');
                            $("#pembayaran").val('');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
                        alert(xhr.responseText);
                    }
                });
            }else{
                document.getElementById("input").setAttribute("disabled", "disabled");
                document.getElementById("error").innerHTML = "";
            }
        }

    </script>
    <body>
    <div class="container container-fluid">
        <div class="row col-sm-6">
            <center><h4>Form Pembatalan Pembayaran Jasa Air Bersih</h4></center><br>
            <?php echo validation_errors(); ?>
            <form method="post" action="<?php echo base_url(). 'main/cancel_pembayaran_darat'; ?>">
                <div id="error"></div>
                <table class="table table-striped">
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="no_kwitansi">No Kwitansi</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control" id="no_kwitansi" name="no_kwitansi" placeholder="Masukkan No Kwitansi" oninput="search()"/>
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
                                <input disabled type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" />
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
                                <input disabled type="text" class="form-control" id="alamat_pembeli" name="alamat_pembeli" />
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
                                <input disabled type="text" class="form-control" id="no_telp" name="no_telp" />
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
                                <select disabled name="pengguna" id="pengguna" class="form-control">
                                    <option></option>
                                    <?php foreach($pengguna as $rowpengguna){?>
                                        <option value="<?=$rowpengguna->id_tarif?>"><?=$rowpengguna->tipe_pengguna_jasa?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="tanggal">Waktu Transaksi</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-group">
                                    <div class='input-group date' id='datepicker'>
                                        <input disabled type='text' name="tanggal" id="tanggal" class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="jam">Waktu Permintaan Pengantaran</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="input-group clockpicker">
                                    <input disabled type="text" class="form-control" name="jam" id="jam" >
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
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
                                <input disabled type="number" step=0.01 class="form-control" id="tonnase" name="tonnase" />
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="total_pengisian">Total Pembayaran</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input disabled type="number" step=0.01 class="form-control" id="pembayaran" name="pembayaran" />
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <input disabled type="submit" class="form-control btn btn-primary" id="input" name="Input" value="Batal Kwitansi" onclick="return confirm('Apakah Anda Yakin Ingin Membatalkan No Kwitansi ini ?');"/>
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
else
{
    $web = base_url('main');
    ?>
    <script>
        alert('Anda Tidak Memiliki Hak Akses Ke Halaman Ini. Silahkan Login Terlebih Dahulu');
        window.location.replace('<?= $web?>');
    </script>
<?php
}
?>
