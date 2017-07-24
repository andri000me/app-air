<div>
    <button class="btn btn-info" data-toggle="collapse" data-target="#data" class="accordion-toggle">Ubah Password</button>
</div>
<div class="hiddenRow">
    <div class="accordion-body collapse" id="data">
        <div class="col-md-6" id="display">
            <h2>||&nbsp Ubah Password Anda &nbsp || </h2>
            <br>
            <br>
            <div class='error_msg'>
                <?php echo validation_errors(); ?>
            </div>
            <table class="table">
                <tr>
                    <th>Password Lama</th>
                    <td>:</td>
                    <td>
                        <input id="pass_lama" type="password" class="form-control" required/>
                        <input id="pass" value="<?= $this->session->userdata('password') ?>" required hidden/>
                        <input id="username" value="<?= $this->session->userdata('username') ?>" required hidden/>
                    </td>
                </tr>
                <tr>
                    <th>Password Baru</th>
                    <td>:</td>
                    <td>
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
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#submit").click(function(){
            var username = $("#username").val();
            var pass = $("#pass").val();
            var pass_lama = $("#pass_lama").val();
            var pass_baru = $("#pass_baru").val();
            var confirm_pass = $("#confirm_pass").val();
            // Returns successful data submission message when the entered information is stored in database.

            console.log(status);
            var dataString = 'username='+ username + '&password='+ pass_baru;
            if(username==''||pass_baru==''||pass_lama==''||confirm_pass==''){
                alert("Please Fill All Fields");
            }
            else if(pass_lama != pass){
                alert("password lama anda salah");
            }
            else if(pass_baru != confirm_pass){
                alert("password baru anda tidak sama dengan konfirmasi password anda")
            }
            else{
                // AJAX Code To Submit Form.
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('main/update_pass'); ?>",
                    data: dataString,
                    cache: false,
                    success: function(result){
                        alert("Sukses Mengupdate Password");
                        $("#pass").val(pass_baru);
                        $("#pass_lama").val("");
                        $("#pass_baru").val("");
                        $("#confirm_pass").val("");
                    }
                });
                console.log(status);
            }
        });
    });
</script>