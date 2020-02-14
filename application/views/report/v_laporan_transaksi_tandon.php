<body>
    <div class="container container-fluid">
        <h3>Laporan Pencatatan Flow Meter</h3><br>
        <div class="row col-sm-6">
            <div class="row col-sm-6">
                <table class="table">
                    <tr>
                        <td>
                            <label class="radio-inline"><input type="radio" name="pilihan" id="perTanggal" checked="checked" value="perTanggal">Per Tanggal</label>
                        </td>
                        <td>
                            <label class="radio-inline"><input type="radio" name="pilihan" id="perFlowmeter" value="perFlowmeter">Per Flow Meter</label>
                        </td>
                    </tr>
                </table>
            </div>
            <table class="table table-responsive table-condensed" id="tabel">
                <tr>
                    <td>
                        <span>Tanggal Pembuatan Laporan</span>
                    </td>
                    <td>:</td>
                    <td>
                        <div class="input-group date" id="datepicker">
                            <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
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
        </div>
        <div class="row col-sm-10">
            <div id="laporan"></div>
        </div>
    </div>
</body>

<script>
    //ambil data ketika form pencarian memiliki perubahan value
    $(window).on("load",function(){
        $('#cari').click(function(){
            search();
        });

        $('#clear').click(function () {
            $('#laporan').html('');
        });

        $('#datepicker').datepicker({
            clearBtn: true,
            autoclose: true,
            format: "yyyy-mm-dd"
        });

        $('input[type=radio][name=pilihan]').on("change", function(e) {
            e.preventDefault();
            var script = document.createElement('script');
            var php = '<?php echo site_url('tenant/get_nama_flow'); ?>';
            var text_date = document.createTextNode('' +
                '$(\'#datepicker\').datepicker({\n' +
                '    clearBtn: true,\n' +
                '    autoclose: true,\n' +
                '    format: "yyyy-mm-dd"\n' +
                '});' +
                '$(\'#cari\').click(function(){\n' +
                '    search();\n' +
                '});\n' +
                '\n' +
                '$(\'#cari_flow\').click(function(){\n' +
                '    search_flow();\n' +
                '});\n' +
                '\n' +
                '$(\'#clear\').click(function () {\n' +
                '    $(\'#laporan\').html(\'\');\n' +
                '});' +
                '$(\'#id_flow\').autocomplete({\n'+
                '     minLength:1,\n'+
                '     delay:0,\n'+
                '     source:"'+ php +'",\n'+
                '     select:function(event, ui){\n'+
                '         $(\'#id_flowmeter\').val(ui.item.id_flow);\n'+
                '         $(\'#nama_flow\').val(ui.item.nama_flow);\n'+
                '     }\n'+
                '});'
            );
            script.appendChild(text_date);
            if (this.value == 'perTanggal') {
                $("#laporan").html('');
                $("#tabel").html('' +
                    '<tr>' +
                    '   <td>' +
                    '       <span>Tanggal Pembuatan Laporan</span>' +
                    '   </td>' +
                    '   <td>:</td>' +
                    '   <td>' +
                    '       <div class="input-group date" id="datepicker">\n' +
                    '           <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />\n' +
                    '           <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>\n' +
                    '       </div>' +
                    '   </td>' +
                    '</tr>' +
                    '<tr>' +
                    '   <td>' +
                    '       <a class="btn btn-primary" id="cari" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>\n' +
                    '   </td>' +
                    '   <td>' +
                    '       <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>' +
                    '   </td>' +
                    '</tr>'
                );
            }
            else if (this.value == 'perFlowmeter') {
                $("#laporan").html('');
                $("#tabel").html('' +
                    '<tr>' +
                    '   <td>' +
                    '       <span>Tanggal Perekaman</span>' +
                    '   </td>' +
                    '   <td>:</td>' +
                    '   <td>' +
                    '       <div class="input-daterange input-group" id="datepicker">\n' +
                    '           <input type="text" class="input-sm form-control" name="tgl-awal" id="tgl-awal"/>\n' +
                    '           <span class="input-group-addon">to</span>\n' +
                    '           <input type="text" class="input-sm form-control" name="tgl-akhir" id="tgl-akhir" />' +
                    '       </div>' +
                    '   </td>' +
                    '</tr>' +
                    '<tr>' +
                    '   <td>' +
                    '       <span>ID Flow Meter</span>' +
                    '   </td>' +
                    '   <td>:</td>' +
                    '   <td>' +
                    '       <input type="text" class="form-control" id="id_flow" name="id_flow" placeholder="Masukkan ID Flow Meter"/>' +
                    '       <input type="hidden" class="form-control" id="id_flowmeter" name="id_flowmeter" />' +
                    '   </td>' +
                    '</tr>' +
                    '<tr>' +
                    '   <td>' +
                    '       <span>Nama Flow Meter</span>' +
                    '   </td>' +
                    '   <td>:</td>' +
                    '   <td>' +
                    '       <input type="text" disabled class="form-control" id="nama_flow"/>' +
                    '   </td>' +
                    '</tr>' +
                    '<tr>' +
                    '   <td>' +
                    '       <a class="btn btn-primary" id="cari_flow" href="javascript:void(0)">Tampilkan <i class="glyphicon glyphicon-search"></i></a>\n' +
                    '   </td>' +
                    '   <td>' +
                    '       <a class="btn btn-primary" id="clear" href="javascript:void(0)">Clear</a>' +
                    '   </td>' +
                    '</tr>'
                );
            }
            $("#tabel").append(script);
        });
    });

    function search_flow() {
        var tgl_awal = $('#tgl-awal').val();
        var tgl_akhir = $('#tgl-akhir').val();
        var id_flow = $('#id_flowmeter').val();
        var $new_tabel = $("<div id='tabel-laporan'></div>"),
            new_div = document.createElement("div"),
            existingdiv1 = document.getElementById("tabel");
        $.ajax({
            url: "<?php echo base_url('report/laporan_per_flow')?>",
            method: "POST",
            data: {
                id_flow : id_flow,
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir
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

    function search() {
        var tgl_awal = $('#tgl-awal').val();
        var tgl_akhir = $('#tgl-akhir').val();
        var $new_tabel = $("<div id='tabel-laporan'></div>"),
            new_div = document.createElement("div"),
            existingdiv1 = document.getElementById("tabel");
        $.ajax({
            url: "<?php echo base_url('report/laporan_flow')?>",
            method: "POST",
            data: {
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir
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