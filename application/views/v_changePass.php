<?php

?>
<div class="row">
    <div class="container">
        <div class="col-md-6">
            <br />
            <h2>||&nbsp Ubah Password Anda &nbsp || </h2>
            <br>
            <br>
            <div class='error_msg'>
                <?php echo validation_errors(); ?>
            </div>
            <table class="table">
                <tr>
                    <th>Password Baru</th>
                    <td>:</td>
                    <td>
                        <input id="username" value="<?php echo $this->session->userdata('username') ?>" required hidden/>
                        <input id="pass_baru" type="password" class="form-control" required/>
                    </td>
                </tr>
                <tr>
                    <th>Konfirmasi Password Baru</th>
                    <td>:</td>
                    <td>
                        <input id="confirm_pass" type="password" class="form-control" required/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input id="submit" type="button" class="btn btn-primary" value="Submit"/>
                    </td><td></td><td></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#submit").click(function(){
            var username = $("#username").val();
            var pass_baru = $("#pass_baru").val();
            var confirm_pass = $("#confirm_pass").val();
            // Returns successful data submission message when the entered information is stored in database.

            console.log(status);
            var dataString = 'username='+ username + '&password='+ pass_baru;
            if(username==''||pass_baru==''||confirm_pass==''){
                alert("Please Fill All Fields");
            }
            else if(pass_baru != confirm_pass){
                alert("password baru anda tidak sama dengan konfirmasi password anda")
            }
            else{
                // AJAX Code To Submit Form.
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('admin/update_pass'); ?>",
                    data: dataString,
                    cache: false,
                    success: function(result){
                        alert("Sukses Mengupdate");
                        $("#pass_baru").val("");
                        $("#confirm_pass").val("");
                    }
                });
                console.log(status);
            }
        });
    });
</script>