<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<section class="content-wrapper">
    <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        </section>
        <section class="content">
            <div class="box box-default">
                <div class="box-header">
                    <button class="btn btn-primary" onclick="add()"> <span>Tambah Data</span></button>
                    <button class="btn btn-info" onclick="refresh()"> <span>Refresh Halaman</span></button><br><br>   
                </div>
                <div class="box-body table-responsive">
                    <table id="tabel" class="table table-bordered table-striped table-hover js-basic-example dataTable nowrap cell-border" cellspacing="0" width="100%" role="grid" >
                        <thead>
                        <tr>
                            <th><center>No</th>
                            <th><center>Judul Menu</th>
                            <th><center>URL</th>
                            <th><center>Second URI</th>
                            <th><center>Status Aktif</th>
                            <th><center>Parent Menu</th>
                            <th><center>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th><center>No</th>
                            <th><center>Judul Menu</th>
                            <th><center>URL</th>
                            <th><center>Second URI</th>
                            <th><center>Status Aktif</th>
                            <th><center>Parent Menu</th>
                            <th><center>Aksi</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
    </div>
</section>

<!-- Bootstrap modal For Datatable-->
<div class="modal fade" id="md-form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Manajemen Menu</h3>
            </div>
            <div class="modal-body form">
                <div class="form-group">
                    <form id="frm-modal" action="#" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Judul Menu</label>
                                    <input hidden id="idm" name="idm">
                                    <input id="title" name="title" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">URL</label>
                                    <input id="url" name="url" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Parent Menu</label>
                                    <select id="parent_menu" name="parent_menu" class="form-control">
                                        <option value="">----</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label class="form-check-label">
                                            <input type="checkbox" value="1" id="status_aktif" name="status_aktif" checked/>
                                            Status Aktif                                        
                                        </label>
                                    </div>                                   
                                </div>
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

<script type="text/javascript">
    var table;
    var save_method; //for save method string

    function batal(){
        $('#frm-modal')[0].reset();
        $('#btnSave').text('Save'); //change button text
        $('#btnSave').attr('class','btn btn-primary'); //set button disable 
        $('#md-form').modal('hide');
    }

    function init_select(){
        //Unit Select Box
        let dropdown = $('#parent_menu');
        dropdown.empty();
        dropdown.append('<option value="0">---Menu Utama---</option>');
        dropdown.prop('selectedIndex', 0);
        const url = '<?php echo base_url('menu/getParentMenu/');?>';

        // Populate dropdown with list
        $.getJSON(url, function (data) {
            $.each(data, function (key, entry) {
                dropdown.append($('<option></option>').attr('value', entry.id).text(entry.title));
            })
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
        $('.modal-title').text('Tambah Data Menu'); // Set title to Bootstrap modal title
    }

    function edit(id){
        save_method = 'update';
        $('#frm-modal')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#btnSave').text('Update');
        $('.select2').select2({
        });

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('menu/ajax_edit/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {		
                $('#md-form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Data Menu'); // Set title to Bootstrap modal title

                $('#idm').val(data.id);
                $('#title').val(data.title);
                $('#url').val(data.url);
                $('#parent_menu').val(data.parent_id).change();

                if(data.is_active == 1)
                    $('#status_aktif').prop('checked',true);
                else
                    $('#status_aktif').prop('checked',false);
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function save(){    
        var url;

        if(save_method == 'add') {
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
        } else {
            $('#btnSave').text('Updating...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
        }
        
        url = "<?php echo site_url('menu/ajax_save');?>";
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
                    $('#btnSave').text('Save'); 
                    $('#btnSave').attr('disabled',false);
                }
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error adding data');
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }

    function reload_table() {
        table.ajax.reload(null,false);
        //init_select();
    }

    function refresh(){
        reload_table();
        init_select();
        $('#form-filter')[0].reset();
    }

    $(document).ready(function(){
        table = $('#tabel').DataTable({
            processing  : true, //Feature control the processing indicator.
            serverSide  : true, //Feature control DataTables' server-side processing mode.
            order       : [], //Initial no order.
            autowidth   : true,
            ordering    : true,
            // Load data for the table's content from an Ajax source
            ajax: {
                "url": "<?php echo site_url('menu/ajax_list')?>" ,
                "type": "POST",
            },
        });
        //$('#container').css( 'display', 'block' );
        //table.columns.adjust().draw();
        init_select();
    });

    function del(id) {
        swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: 'Anda Tidak Akan Bisa Merecover Kembali Data Yang Sudah Anda Hapus !',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((willDelete) => {
            if (willDelete.value) {
                $.ajax({
                    url : "<?php echo site_url('menu/delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        swal.fire('Terhapus','Data Anda Sudah Dihapus','success');
                        reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal.fire("Gagal","Data Anda Tidak Jadi Dihapus","error");
                    }
                });
            } else {
                swal.fire("Batal","Data Anda Tidak Jadi Dihapus","warning");
            }
        });
    }

    $('.modal').on('hidden.bs.modal', function () {
        reload_table();
    });
</script>