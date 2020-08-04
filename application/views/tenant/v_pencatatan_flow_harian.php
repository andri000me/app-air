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
            border-width: 3px;
        }

        .col-sm-6:not(:last-child) {
            border-right: 6px solid #ccc;
        }

        .ui-autocomplete-input, .ui-menu, .ui-menu-item {  z-index: 2006; }
    </style>

    <body>
        <div class="container" data-role="main" class="ui-content">
            <h3><center>Riwayat Pencatatan Flow Harian</h3><br>
            <div class="row col-md-5">
                <button class="btn btn-primary" onclick="add()"> <span>Tambah Data</span></button>
                <button class="btn btn-info" onclick="reload_table()"> <span>Refresh Halaman</span></button><br>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row col-md-5">
                <br>
                <button class="btn btn-success" onclick="validation('validasi')"> <span>Validasi</span></button>
                <button class="btn btn-danger" onclick="validation('batal')"> <span>Batal</span></button><br><br>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="table" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Flow Meter</th>
                            <th>Nama Flow Meter</th>
                            <th>Tanggal Perekaman</th>
                            <th>Flow Meter</th>
                            <th>Issued By</th>
                            <th><input type="checkbox" id="select_all" /></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>ID Flow Meter</th>
                            <th>Nama Flow Meter</th>
                            <th>Tanggal Perekaman</th>
                            <th>Flow Meter</th>
                            <th>Issued By</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
        </div>
    </body>

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
                                <table class="table table-striped" width="70%">
                                    <tr>
                                        <div class="form-group">
                                            <td>
                                                <label for="id_flowmeter">ID Flow Meter</label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" class="form-control" id="id_flowmeter" name="id_flowmeter" placeholder="Masukkan ID Flowmeter"/>
                                                <input type="hidden" class="form-control" id="id_flow" name="id_flow" />
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
                                                <label for="lokasi">Nilai Flow Terakhir</label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" disabled class="form-control" id="flowmeter_akhir" name="flowmeter_akhir" />
                                                <input type="hidden" class="form-control" id="flow_akhir" name="flow_akhir" />
                                            </td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="form-group">
                                            <td>
                                                <label for="tanggal">Waktu Pencatatan</label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date datepicker'>
                                                        <input type='text' name="tanggal" id="tanggal" class="form-control" />
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
                                                <label for="flow_hari_ini">Nilai Flow Hari Ini</label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" class="form-control" id="flow_hari_ini" step=".01" name="flow_hari_ini" placeholder="Satuan (m3)"/>
                                            </td>
                                        </div>
                                    </tr>
                                </table>
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

    <script>
        $(function () {
            $("#id_flowmeter").autocomplete({
                minLength:1,
                delay:0,
                source:'<?php echo site_url('tenant/get_tenant'); ?>',
                select:function(event, ui){
                    $('#id_flow').val(ui.item.id_flow);
                    $('#nama_flowmeter').val(ui.item.nama_flow);
                    $('#flow_akhir').val(ui.item.flow_akhir);
                    $('#flowmeter_akhir').val(ui.item.flow_akhir);
                }
            });
        });

        $(document).ready(function(){
             //datatables
            table = $('#table').DataTable({
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [[ 0, "desc" ]], //Initial no order.
                 //scrollY     : 300,
                scrollX     : true,
                //scrollCollapse: true,
                fixedColumns:   {
                    leftColumns: 2,
                    heightMatch: 'auto'
                },
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('tenant/riwayat_catat_flow')?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    {
                        "targets": [-1], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                ],
            });
            
            $('#select_all').on('click',function(){
                if(this.checked){
                    $('.checkbox').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('.checkbox').each(function(){
                        this.checked = false;
                    });
                }
            });
            
            $('.checkbox').on('click',function(){
                if($('.checkbox:checked').length == $('.checkbox').length){
                    $('#select_all').prop('checked',true);
                }else{
                    $('#select_all').prop('checked',false);
                }
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
                url = "<?php echo site_url('tenant/transaksi_tenant');?>"; 
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
                        $('#btnSave').text('Save'); //change button text
                        $('#btnSave').attr('disabled',false); //set button enable 
                        $('#md-form').modal('hide');
                    }
                    else{
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                        alert('Inputan Masih Ada Yang Kosong');
                        $('#btnSave').attr('disabled',false); //set button enable
                    }
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
            $('.modal-title').text('Tambah Data Realisasi Pencatatan Harian Flow Meter'); // Set title to Bootstrap modal title
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
                        url : "<?php echo site_url('tenant/updatePerekaman/')?>"+tipe,
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

        $(function () {
            $('.datepick').datepicker({
                clearBtn: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
            $('.datepicker').datetimepicker({
                locale: 'id',
                sideBySide:true,
                format:'YYYY-MM-DD HH:mm'
            });
        });
    </script>
    <?php
} else{
    redirect('main');
}
?>