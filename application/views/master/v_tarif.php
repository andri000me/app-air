<?php

?>
<!-- Bootstrap modal For Datatable-->
<div class="modal fade" id="md-form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Penyesuaian Tarif</h3>
            </div>
            <div class="modal-body form">
                <div class="form-group">
                    <form id="frm-modal" action="#" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Tipe Pengguna Jasa</label>
                                    <input hidden id="idm" name="idm">
                                    <input class="form-control" type="text" name="tipe_pengguna" id="tipe_pengguna" required>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Kawasan</label>
                                    <select name="kawasan" id="kawasan" class="form-control">
                                        <option value="KIK">Kawasan Indrusti Kariangau</option>
                                        <option value="NON-KIK">Kawasan Non Indrusti Kariangau</option>
                                        <option value="">Non</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Tipe</label>
                                    <select name="tipe" id="tipe" class="form-control">
                                        <option value="laut">Laut</option>
                                        <option value="darat">Darat</option>
                                        <option value="">Non</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Tarif</label>
                                    <input required id="tarif" name="tarif" class="form-control" type="text" required>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Diskon</label>
                                    <input class="form-control" type="text" name="diskon" id="diskon"> 
                                    <span class="help-block"></span>
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

<div class="container" data-role="main" class="ui-content">
    <h3>Master Data Tarif</h3>
    <div class="row col-md-5">
        <button class="btn btn-primary" onclick="add()"> <span>Tambah Data</span></button>
        <button class="btn btn-info" onclick="reload_table()"> <span>Refresh Halaman</span></button><br><br>   
    </div>
</div>

<div class="container">
    <div class="row col-md-12">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="70%">
            <thead>
            <tr>
                <th>
                    <center>No
                </th>
                <th>
                    <center>Tipe Pengguna Jasa
                </th>
                <th>
                    <center>Kawasan
                </th>
                <th>
                    <center>Tipe
                </th>
                <th>
                    <center>Tarif
                </th>
                <th>
                    <center>Diskon
                </th>
                <th>
                    <center>Aksi
                </th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <th>
                    <center>No
                </th>
                <th>
                    <center>Tipe Pengguna Jasa
                </th>
                <th>
                    <center>Kawasan
                </th>
                <th>
                    <center>Tipe
                </th>
                <th>
                    <center>Tarif
                </th>
                <th>
                    <center>Diskon
                </th>
                <th>
                    <center>Aksi
                </th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<script type="text/javascript">
    var table;

    $(document).ready(function() {
        //datatables
        table = $('#table').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('master/ajax_data_tarif')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [ 0 ], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function delete_data_tarif(id)
    {
        if(confirm('Apakah Anda Yakin Untuk Menghapus Data Ini?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('master/delete_data_tarif')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    alert("Data Berhasil Dihapus");
                    window.location = "<?php echo site_url()?>"+"main/tarif";
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error Ketika Menghapus Data');
                }
            });

        }
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
            url : "<?php echo site_url('master/editTarif/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {		
                $('#md-form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Data Tarif'); // Set title to Bootstrap modal title

                $('#idm').val(data.id_tarif);
                $('#tipe_pengguna').val(data.tipe_pengguna_jasa);
                $('#kawasan').val(data.kawasan).change();
                $('#tipe').val(data.tipe).change();
                $('#tarif').val(data.tarif).change();
                $('#diskon').val(data.diskon);
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
            url = "<?php echo site_url('master/input_data_tarif');?>"; 
        } else {
            $('#btnSave').text('Updating...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            url = "<?php echo site_url('master/edit_tarif');?>"; 
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
        $('.modal-title').text('Tambah Data Tarif'); // Set title to Bootstrap modal title
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
</script>