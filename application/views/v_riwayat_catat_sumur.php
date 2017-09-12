<?php
if($this->session->userdata('role') == 'wtp'){
    ?>
    <script>
        //ambil data ketika form pencarian memiliki perubahan value
        $(document).ready(function(){
            $("#cari").click(function(){
                search();
            });
            $("#clear").click(function () {
                $("#laporan").html('');
            });
        });

        function search() {
            var tgl_awal = $('#tgl-awal').val();
            var tgl_akhir = $('#tgl-akhir').val();
            var $new_tabel = $("<div id='tabel-laporan'></div>"),
                new_div = document.createElement("div"),
                existingdiv1 = document.getElementById("tabel");
            $.ajax({
                url: "<?php echo base_url('main/riwayat_catat_sumur')?>",
                method: "POST",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir,
                },
                dataType: 'json',
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function (response) {
                    if (response.status == "success") {
                        $("#laporan").html(response.tabel);
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
        <h3>Riwayat Pencatatan Sumur</h3><br><br>
        <div class="row col-sm-6">
            <table class="table table-responsive table-condensed">
                <tr>
                    <td>
                        <span>Waktu Perekaman</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datepicker').datepicker({
                                    clearBtn: true,
                                    autoclose: true,
                                    format: "yyyy-mm-dd"
                                });
                            });
                        </script>
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
        </div>
        <div class="row col-sm-12">
            <div id="laporan"></div>
        </div>
    </div>
    <?php
} else{
    redirect('main');
}
?>