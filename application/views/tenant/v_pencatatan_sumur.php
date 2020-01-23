<?php
if($this->session->userdata('role') == 'wtp' || $this->session->userdata('role') == 'admin'){
    ?>
    <script>
        $(function () {
            $("#id_sumur_awal").autocomplete({
                minLength:1,
                delay:0,
                source:'<?php echo site_url('main/get_sumur'); ?>',
                select:function(event, ui){
                    $('#id_master_sumur_awal').val(ui.item.id_sumur);
                    $('#nama_sumur').val(ui.item.nama_sumur);
                    $('#nama_pompa').val(ui.item.nama_pompa);
                    $('#id_pompa').val(ui.item.id_pompa);
                    $('#id_flowmeter').val(ui.item.id_flowmeter);
                    $('#nama_flowmeter').val(ui.item.nama_flowmeter);
                    $('#id_sumur_akhir').val(ui.item.label);
                    $('#nama_sumur_akhir').val(ui.item.nama_sumur);
                    $('#nama_pompa_akhir').val(ui.item.nama_pompa);
                    $('#id_pompa_akhir').val(ui.item.id_pompa);
                    $('#id_flowmeter_akhir').val(ui.item.id_flowmeter);
                    $('#nama_flowmeter_akhir').val(ui.item.nama_flowmeter);
                    $('#flow_hari_ini_awal').val(ui.item.flowmeter_akhir);
                    $('#debit_awal_disable').val(ui.item.debit_air);
                    $('#debit_awal').val(ui.item.debit_air);
                    $('#debit_akhir_disable').val(ui.item.debit_air);
                    $('#debit_akhir').val(ui.item.debit_air);
                }
            });
        });
    </script>
    <body>
    <div class="container container-fluid">
        <div class="row">
            <center><h3 class="header">Form Pencatatan Harian Sumur</h3></center><br>
            <?php echo validation_errors(); ?>
            <form method="post" action="<?php echo base_url(). 'main/transaksi_sumur'; ?>">
                <div class="col-xs-6">
                    <table class="table table-striped">
                        <tr>
                            <div class="form-group">
                                <td colspan="3">
                                    <label for="id_flowmeter"><h4 class="sub-header">Status Pencatatan Awal</h4></label>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="id_flowmeter">ID Flow Meter</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" class="form-control" id="id_sumur_awal" name="id_sumur_awal" placeholder="Masukkan ID Flow Meter"/>
                                    <input type="hidden" class="form-control" id="id_master_sumur_awal" name="id_master_sumur_awal" />
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="lokasi">Nama Sumur</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" disabled class="form-control" id="nama_sumur" name="nama_sumur" />
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="lokasi">Nama Pompa</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" disabled class="form-control" id="nama_pompa" name="nama_pompa" />
                                    <input type="hidden" class="form-control" id="id_master_sumur" name="id_master_sumur" />
                                    <input type="hidden" class="form-control" id="id_pompa" name="id_pompa" />
                                    <input type="hidden" class="form-control" id="id_flowmeter" name="id_flowmeter" />
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="lokasi">Nama Flow Meter</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" disabled class="form-control" id="nama_flowmeter" name="nama_flowmeter" />
                                    <input type="hidden" class="form-control" id="id_master_sumur" name="id_master_sumur" />
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="flow_akhir">Cuaca</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <select class="form-control" id="cuaca_awal" name="cuaca_awal">
                                        <option value="cerah">Cerah</option>
                                        <option value="berawan">Berawan</option>
                                        <option value="hujan">Hujan</option>
                                    </select>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="tanggal">Waktu Perekaman</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <div class="form-group">
                                        <div class='input-group date' id='datepicker'>
                                            <input type='text' name="tanggal_awal" id="tanggal_awal" class="form-control" />
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(function () {
                                            $('#datepicker').datetimepicker({
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
                                    <label for="flow_hari_ini">Flow Meter Awal</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="number" class="form-control" step=".01" id="flow_hari_ini_awal" name="flow_hari_ini_awal" placeholder="Satuan (m3)"/>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="debit_awal">Debit Awal</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="number" disabled class="form-control" step=".01" id="debit_awal_disable" name="debit_awal_disable" placeholder="Satuan (L/Detik)"/>
                                    <input type="hidden" class="form-control" step=".01" id="debit_awal" name="debit_awal" placeholder="Satuan (L/Detik)"/>
                                </td>
                            </div>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-6">
                    <table class="table table-striped">
                        <tr>
                            <div class="form-group">
                                <td colspan="3">
                                    <label for="id_flowmeter"><h4 class="sub-header">Status Pencatatan Akhir</h4></label>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="id_flowmeter">ID Flow Meter</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" disabled class="form-control" id="id_sumur_akhir" name="id_sumur_akhir" placeholder="Masukkan ID Flow Meter"/>
                                    <input type="hidden" class="form-control" id="id_master_sumur_akhir" name="id_master_sumur_akhir" />
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="lokasi">Nama Sumur</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" disabled class="form-control" id="nama_sumur_akhir" name="nama_sumur_akhir" />
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="lokasi">Nama Pompa</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" disabled class="form-control" id="nama_pompa_akhir" name="nama_pompa_akhir" />
                                    <input type="hidden" class="form-control" id="id_master_sumur" name="id_master_sumur" />
                                    <input type="hidden" class="form-control" id="id_pompa_akhir" name="id_pompa_akhir" />
                                    <input type="hidden" class="form-control" id="id_flowmeter_akhir" name="id_flowmeter_akhir" />
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="lokasi">Nama Flow Meter</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" disabled class="form-control" id="nama_flowmeter_akhir" name="nama_flowmeter_akhir" />
                                    <input type="hidden" class="form-control" id="id_master_sumur" name="id_master_sumur" />
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="flow_akhir">Cuaca</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <select class="form-control" id="cuaca_akhir" name="cuaca_akhir">
                                        <option value="cerah">Cerah</option>
                                        <option value="berawan">Berawan</option>
                                        <option value="hujan">Hujan</option>
                                    </select>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="tanggal">Waktu Perekaman</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <div class="form-group">
                                        <div class='input-group date' id='datepicker_akhir'>
                                            <input type='text' name="tanggal_akhir" id="tanggal_akhir" class="form-control" />
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(function () {
                                            $('#datepicker_akhir').datetimepicker({
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
                                    <label for="flow_hari_ini">Flow Meter Akhir</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="number" class="form-control" id="flow_hari_ini_akhir" step=".01" name="flow_hari_ini_akhir" placeholder="Satuan (m3)"/>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td>
                                    <label for="debit_akhir">Debit Akhir</label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="number" disabled class="form-control" step=".01" id="debit_akhir_disable" name="debit_akhir_disable" placeholder="Satuan (L/Detik)"/>
                                    <input type="hidden" class="form-control" step=".01" id="debit_akhir" name="debit_akhir" placeholder="Satuan (L/Detik)"/>
                                </td>
                            </div>
                        </tr>
                    </table>
                </div>
                <table class="table table-responsive">
                    <tr class="col-md-4">
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
} else{
    redirect('main');
}
?>