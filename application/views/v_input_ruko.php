<script>
    $(function () {
        $("#nama_ruko").autocomplete({
            minLength:1,
            delay:0,
            source:'<?php echo site_url('main/get_pembeli_ruko'); ?>',
            select:function(event, ui){
                $('#id_flowmeter').val(ui.item.id_flowmeter);
                $('#id_flowmeter_hidden').val(ui.item.id_flowmeter);
                $('#alamat').val(ui.item.alamat);
                $('#no_telp').val(ui.item.no_telp);
                $('#pengguna').val(ui.item.pengguna);
            }
        });
    });
</script>
<body>
    <div class="container container-fluid">
        <div class="row col-sm-6">
            <h3>PT. Kaltim Kariangau Terminal</h3>
            <h3>Terminal Peti Kemas Balikpapan</h3>
            <h3>Aplikasi Pelayanan Jasa Air Bersih PT KKT</h3><br><br>
            <center><h4>Form Penginputan Harian Pelayanan Jasa Air Bersih Untuk Ruko</h4></center><br>
            <?php echo validation_errors(); ?>
            <form method="post" action="<?php echo base_url(). 'main/transaksi_ruko'; ?>">
                <table class="table table-striped">
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="nama_pembeli">Nama Ruko</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control" id="nama_ruko" name="nama_ruko" placeholder="Masukkan Nama Ruko"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="alamat_pembeli">ID Flow Meter</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" disabled class="form-control" id="id_flowmeter" name="id_flowmeter" />
                                <input type="hidden" class="form-control" id="id_flowmeter_hidden" name="id_flowmeter_hidden" />
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="alamat_pembeli">Alamat Ruko</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" disabled class="form-control" id="alamat" name="alamat" />
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="alamat_pembeli">No Telepon Ruko</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" disabled class="form-control" id="no_telp" name="no_telp" />
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
                                <label for="tanggal">Tanggal</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-group">
                                    <div class='input-group date' id='datepicker'>
                                        <input type='text' name="tanggal" id="tanggal" class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#datepicker').datepicker({
                                            todayBtn: "linked",
                                            clearBtn: true,
                                            autoclose: true,
                                            format: "yyyy-mm-dd"
                                        });
                                    });
                                </script>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="total_pengisian">Flow Meter Hari Ini</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="number" class="form-control" id="tonnase" name="tonnase" placeholder="Satuan (m3)"/>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="flow_awal">Penetapan Awal Bulan</label>
                            </td>
                            <td>:</td>
                            <td>
                                <label class="radio-inline"><input type="radio" name="flow_awal" value="1">Ya</label>
                                <label class="radio-inline active"><input type="radio" name="flow_awal" value="0" checked="">Tidak</label>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <input type="submit" class="form-control" id="input" name="Input" value="Submit" />
                            </td>
                        </div>
                    </tr>
                </table>
            </form>
        </div>
    </div>
  </body>
