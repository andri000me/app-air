<?php
if($this->session->userdata('role_name') == 'wtp' || $this->session->userdata('role_name') == 'admin'){
    ?>
    <style>
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 6px;
        }
        .ui-autocomplete-input, .ui-menu, .ui-menu-item {  z-index: 2006; }
    </style>
    
    <script type="text/javascript">
        var table;

        $(function () {
            $("#id_sumur_awal").autocomplete({
                minLength:1,
                delay:0,
                source:'<?php echo site_url('tenant/get_sumur'); ?>',
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
                },
            });
        });

        $(document).ready(function(){
             //datatables
            table = $('#table').DataTable({
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                 //scrollY     : 300,
                scrollX     : true,
                //scrollCollapse: true,
                fixedColumns:   {
                    leftColumns: 2,
                    heightMatch: 'auto'
                },
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('tenant/riwayat_catat_sumur')?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    {
                        "targets": ['all'], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                ],
            });
            
            $("#cari").click(function(){
                search();
            });

            $("#clear").click(function () {
                $("#laporan").html('');
            });
        });

        function reload_table() {
            table.ajax.reload(null,false);
        }

        function save(){    
            var url;

            if(save_method == 'add') {
                $('#btnSave').text('Saving...'); //change button text
                $('#btnSave').attr('disabled',true); //set button disable
                url = "<?php echo site_url('tenant/transaksi_sumur');?>"; 
            } else {
                $('#btnSave').text('Updating...'); //change button text
                $('#btnSave').attr('disabled',true); //set button disable 
                url = "<?php echo site_url('master/edit_sumur');?>"; 
            }
            
            formData = new FormData($('#frm-modal')[0]);
            formData.append( 'save_method', save_method );

            // ajax adding data to database
            $.ajax({
                url : url,
                type: "POST",
                data: formData,
                async: false,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data){
                    //if success close modal and reload ajax table
                    if(data.status){
                        reload_table();
                        $('#frm-modal')[0].reset();
                    }
                    else{
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                        alert('Inputan Masih Ada Yang Kosong');
                        $('#btnSave').attr('disabled',false); //set button enable
                    }

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                    $('#md-form').modal('hide');
                },
                error: function (jqXHR, textStatus, errorThrown){
                    alert('Error adding data');
                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                }
            });
        }

        function add(){
            save_method = 'add';
            $('#frm-modal')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#btnSave').text('Save');
            $('.select2').select2({
            });
            $('#md-form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Tambah Data Pencatatan Sumur'); // Set title to Bootstrap modal title
        }

        function batal(){
            $('#frm-modal')[0].reset();
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('class','btn btn-primary'); //set button disable 
            $('#md-form').modal('hide');
        }

        $('.modal').on('hidden.bs.modal', function () {
            reload_table();
        });

        $(function () {
            $('.datepicker').datetimepicker({
                locale: 'id',
                sideBySide:true,
                format:'YYYY-MM-DD HH:mm'
            });

            $('.datepick').datepicker({
                clearBtn: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
        });
        
        function validation(tipe){
            swal.fire({
                title: 'Apakah Anda Yakin ?',
                text: 'Anda Akan Melakukan Validasi Data !',
                type: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((willConfirm) => {
                if (willConfirm.value) {
                    var flow = [];
                    var cek  = [];
                    var id   = [];
                    var temp_id = [];
                    var temp_flow = [];
                    var i = 0;  

                    $("input[name*='flow['").each(function(){
                        temp_flow.push($(this).val());
                    });

                    $("input[name*='id['").each(function(){
                        temp_id.push($(this).val());
                    });

                    $("input[name*='cek['").each(function(){
                        if($(this).is(":checked")){
                            console.log(i);
                            cek.push($(this).val());
                            var id_value = temp_id[i];
                            var flow_value = temp_flow[i];
                            id.push(id_value);
                            flow.push(flow_value);
                        }
                        i++;
                    });
                    
                    formData = {
                        id : id,
                        flow : flow,
                        cek : cek,
                    }

                    $.ajax({
                        url : "<?php echo site_url('tenant/updatePencatatan/')?>"+tipe,
                        type: "POST",
                        data : formData,
                        dataType: "JSON",
                        success: function(result)
                        {
                            swal.fire('Berhasil','Data Anda Sudah Diproses','success');
                            reload_table();
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            swal.fire("Gagal","Data Anda Tidak Jadi Diproses","error");
                        }
                    });
                } else {
                    swal.fire("Batal","Data Anda Tidak Jadi Diproses","warning");
                }
            });
        }
    </script>

    <!-- Bootstrap modal For Datatable-->
    <div class="modal fade" id="md-form" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Data</h3>
                </div>
                <div class="modal-body form">
                    <div class="form-group">
                        <form id="frm-modal" action="#" enctype="multipart/form-data">
                            <div class="row">
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
                                                        <div class='input-group date datepicker'>
                                                            <input type='text' name="tanggal_awal" id="tanggal_awal" class="form-control" />
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
                                                        <div class='input-group date datepicker' id='datepicker_akhir'>
                                                            <input type='text' name="tanggal_akhir" id="tanggal_akhir" class="form-control" />
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
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer bg-warning" >
                    <div class="row">
                        <div class="col-md-12">
                            <button onclick='save()' id='btnSave' type='button' class='btn btn-primary' >Save</button>
                            <button onclick='batal()' type='button' class='btn btn-danger' >Cancel</button>
                        </div>
                    </div>
                </div>				
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <!-- End Bootstrap modal -->

    <body>
        <div class="container-fluid" data-role="main" class="ui-content">
            <h3>Riwayat Pencatatan Sumur</h3>
            <br>
            <div class="row col-md-5">
                <button class="btn btn-primary" onclick="add()"> <span>Tambah Data</span></button>
                <button class="btn btn-info" onclick="reload_table()"> <span>Refresh Halaman</span></button><br>
            </div>
        </div>
        <hr>
        <div class="container-fluid">
            <br>
            <div class="row col-md-5">
                <button class="btn btn-success" onclick="validation('validasi')"> <span>Validasi</span></button>
                <button class="btn btn-danger" onclick="validation('batal')"> <span>Batal</span></button><br><br>
            </div>
            <div class="row col-md-12">
                <table id="table" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Sumur</th>
                            <th>Nama Sumur</th>
                            <th>Nama Pompa</th>
                            <th>Nama Flow Meter</th>
                            <th>Waktu Perekaman Awal</th>
                            <th>Cuaca</th>
                            <th>Debit Air</th>
                            <th>Nilai Flow Awal</th>
                            <th>Waktu Perekaman Akhir</th>
                            <th>Cuaca</th>
                            <th>Debit Air</th>
                            <th>Nilai Flow Akhir</th>
                            <th>Total Penggunaan</th>
                            <th>Issued By</th>
                            <th><center>Check Box</center></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>ID Sumur</th>
                            <th>Nama Sumur</th>
                            <th>Nama Pompa</th>
                            <th>Nama Flow Meter</th>
                            <th>Waktu Perekaman Awal</th>
                            <th>Cuaca</th>
                            <th>Debit Air</th>
                            <th>Nilai Flow Awal</th>
                            <th>Waktu Perekaman Akhir</th>
                            <th>Cuaca</th>
                            <th>Debit Air</th>
                            <th>Nilai Flow Akhir</th>
                            <th>Total Penggunaan</th>
                            <th>Issued By</th>
                            <th><center>Check Box</center></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </body>
    <?php
} else{
    redirect('main');
}
?>