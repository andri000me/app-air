<?php
if($this->session->userdata('role') == 'wtp'){
    ?>
    <script>
        $(function () {
            $("#id_flowmeter").autocomplete({
                minLength:1,
                delay:0,
                source:'<?php echo site_url('main/get_tenant'); ?>',
                select:function(event, ui){
                    $('#id_flow').val(ui.item.id_flow);
                    $('#nama_flowmeter').val(ui.item.nama_flow);
                    $('#flow_akhir').val(ui.item.flow_akhir);
                    $('#flowmeter_akhir').val(ui.item.flow_akhir);
                }
            });
        });
    </script>
    <body>
    <div class="container container-fluid">
        <div class="row col-sm-6">
            <center><h4>Form Pencatatan Harian Pelayanan Jasa Air Bersih Untuk Flow Meter</h4></center><br>
            <?php echo validation_errors(); ?>
            <form method="post" action="<?php echo base_url(). 'main/transaksi_ruko'; ?>">
                <table class="table table-striped">
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="id_flowmeter">ID Flow Meter</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control" id="id_flowmeter" name="id_flowmeter" placeholder="Masukkan ID Flowmeter"/>
                                <input type="hidden" class="form-control" id="id_flow" name="id_flow" />
                                <input type="hidden" class="form-control" id="id_tenant" name="id_tenant" />
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
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td>
                                <label for="flow_akhir">Flow Akhir</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" disabled class="form-control" id="flow_akhir" name="flow_akhir" />
                                <input type="hidden" class="form-control" id="flowmeter_akhir" name="flowmeter_akhir" />
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
                                        <input type='text' name="tanggal" id="tanggal" class="form-control" />
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
                                <label for="flow_hari_ini">Flow Meter Hari Ini</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="number" class="form-control" id="flow_hari_ini" name="flow_hari_ini" placeholder="Satuan (m3)"/>
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
} else{
    redirect('main');
}
?>