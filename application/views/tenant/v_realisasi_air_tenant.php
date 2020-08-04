<?php
if($this->session->userdata('role_name') == 'wtp' || $this->session->userdata('role_name') == "admin"){
?>
    <body>
    <script>
        $(function () {
            $("#id_flow").autocomplete({
                minLength:1,
                delay:0,
                source:'<?php echo site_url('tenant/get_pembeli_ruko'); ?>',
                select:function(event, ui){
                    $('#id_flowmeter').val(ui.item.id_flow);
                    $('#nama_tenant').val(ui.item.nama_tenant);
                }
            });
        });

        $(function () {
            $('#datepicker').datepicker({
                clearBtn: true,
                autoclose: true,
                format: "yyyy-mm-dd",
                todayHighlight : true,
                todayBtn: true,
            });
        });
        //ambil data ketika form pencarian memiliki perubahan value
        $(document).ready(function(){
            $("#cari").click(function(){
                search();
            });
            $("#clear").click(function () {
                $("#laporan").html('');
                $("#tabel").html('');
            })
        });

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var id = $('#id_flowmeter').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?php echo base_url('tenant/realisasiTenant')?>",
                method: "POST",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir,
                    id: id
                },
                dataType: 'json',
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    if (response.status == "success") {
                        $('#tabel').html(response.tabel);
                        $("#laporan").html(response.url);
                    } else {
                        alert('Data Tidak Ditemukan');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
    <div class="container container-fluid">
        <h3>Realisasi Pemakaian Air Untuk Tenant</h3><br><br>
        <div class="row col-sm-6">
            <table class="table table-responsive table-condensed">
                <tr>
                    <td>
                        <span>ID Flow Meter</span>
                    </td>
                    <td>:</td>
                    <td>
                        <input type="text" class="form-control" id="id_flow" name="id_flow" placeholder="Masukkan ID Flow Meter"/>
                        <input type="hidden" class="form-control" id="id_flowmeter" name="id_flowmeter" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Nama Tenant</span>
                    </td>
                    <td>:</td>
                    <td>
                        <input type="text" disabled class="form-control" id="nama_tenant"/>
                        <input type="hidden" class="form-control" id="id_flowmeter" name="id_flowmeter" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Tanggal Realisasi Pemakaian Air Tenant</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>
                    </td>
                </tr>
            </table>
            <div id="tabel"></div>
            <div id="laporan"></div>
        </div>
    </div>
    </body>
<?php
} else{
    redirect('main');
}
?>
