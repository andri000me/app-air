<?php
if(($this->session->userdata('role') == "perencanaan" ||$this->session->userdata('role') == "admin") && $this->session->userdata('session') != NULL) {
    ?>
    <script>
        $(function () {
            var id = $('#nama_lct').val();
            $("#nama_lct").autocomplete({
                minLength: 1,
                delay: 0,
                source: '<?php echo site_url('main/get_pembeli_laut/'); ?>' + id,
                select: function (event, ui) {
                    $('#id_pengguna').val(ui.item.id);
                    $('#id_kapal').val(ui.item.id_kapal);
                    $('#id_kapal1').val(ui.item.id_kapal);
                    $('#pengguna').val(ui.item.pengguna);
                    $('#tipe_kapal').val(ui.item.pengguna);
                    $('#nama_perusahaan').val(ui.item.nama_perusahaan);
                    $('#alamat').val(ui.item.alamat);
                    $('#no_telp').val(ui.item.no_telp);
                }
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
    <body>
    <div class="container container-fluid">
        <div class="row col-sm-6">
            <center><h4>Form Permintaan Pelayanan Jasa Air Bersih Untuk Kapal</h4></center>
            <br>
            <?php echo validation_errors(); ?>
            <form method="post" action="<?php echo base_url() . 'main/transaksi_laut'; ?>">
                <table class="table table-striped">
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="nama_vessel">Nama VESSEL</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control" id="nama_lct" name="nama_lct"
                                       placeholder="Masukkan Nama VESSEL"/>
                                <input type="hidden" class="form-control" id="id_pengguna" name="id_pengguna"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="id_vessel">ID VESSEL</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input disabled type="text" class="form-control" id="id_kapal" name="id_kapal"
                                       placeholder="Masukkan ID VESSEL"/>
                                <input type="hidden" class="form-control" id="id_kapal1" name="id_kapal1"
                                       placeholder="Masukkan ID VESSEL"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="nama_perusahaan">Nama Perusahaan</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input disabled type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"
                                       placeholder="Masukkan Nama Perusahaan"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="alamat_perusahaan">Alamat Perusahaan</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input disabled type="text" class="form-control" id="alamat" name="alamat"
                                       placeholder="Masukkan Alamat Perusahaan"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="no_telp_perusahaan">No Telp Perusahaan</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input disabled type="text" class="form-control" id="no_telp"
                                       name="no_telp" placeholder="Masukkan No Telp Perusahaan"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="pengguna_jasa">Jenis Kapal</label>
                            </td>
                            <td>:</td>
                            <td>
                                <select disabled name="pengguna" id="pengguna" class="form-control">
                                    <option></option>
                                    <?php foreach ($pengguna as $rowpengguna) { ?>
                                        <option value="<?php echo $rowpengguna->id_tarif ?>"><?php echo $rowpengguna->tipe_pengguna_jasa ?></option>
                                    <?php } ?>
                                </select>
                                <input type="hidden" name="tipe_kapal" id="tipe_kapal">
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="voy_no">Voy No</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control" id="voy_no" name="voy_no"
                                       placeholder="Masukkan Voy No"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="pemohon">Nama Pemohon</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control" id="nama_pemohon" name="nama_pemohon"
                                       placeholder="Masukkan Nama Pemohon"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="tanggal">Waktu Pelayanan</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker'>
                                        <input type='text' name="tanggal" id="tanggal" class="form-control"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker').datetimepicker({
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
                                <input type="number" class="form-control" id="tonnase" name="tonnase"
                                       placeholder="Satuan (Ton)"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <input type="submit" class="form-control btn btn-primary" id="input" name="Input" value="Submit"/>
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
        window.location.replace('<?php echo $web?>');
    </script>
    <?php
}
    ?>