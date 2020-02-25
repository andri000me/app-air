<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="container container-fluid">
        <?php
        if (isset($_SESSION['message_display'])) {
        $message = $_SESSION['message_display'];
        ?>
        <body onload='Swal.fire({type: "success",title: "Berhasil",timer: 3000,text: "<?php echo $message?>",});'>
        <?php
        unset($_SESSION['message_display']);
        }
        ?>
        <?php
        if(isset($_SESSION['error_message'])) {
        $error = $_SESSION['error_message'];
        ?>
        <body onload='Swal.fire({type: "error",title: "Gagal",timer: 3000,text: "<?php echo $error?>",});'>
        <?php
        unset($_SESSION['error_message']);
        }
        ?>
        <div class="col-md-4">
            <?php echo form_open('admin/login'); ?>
            <div class='error_msg'>
                <?php echo validation_errors(); ?>
            </div>
            <table class="table">
                <tr>
                    <td><label>User ID</label></td>
                    <td>:</td>
                    <td><input class="form-control" type="text" name="username" id="name" placeholder="user id anda" required/></td>
                </tr>
                <tr>
                    <td><label>Kata Sandi</label></td>
                    <td>:</td>
                    <td><input class="form-control" type="password" name="password" id="password" placeholder="kata sandi anda" required/></td>
                </tr>
                <tr>
                    <td colspan="1" align="center"><a class="btn btn-info" href="https://forms.gle/yDcv8PGsAHuMj8LH9" target="_blank">Register</a></td>
                    <td colspan="2" align="center"><input type="submit" class="btn btn-success" value="Masuk" name="submit"/></td>
                </tr>
            </table>
            <?php echo form_close(); ?>
        </div>
        <!----
        <div class="col-md-12">
            <a href="<?php echo $attr['google_login_url']; ?>"><img id="google_signin" src="<?php echo base_url(); ?>assets/images/web/1x/btn_google_signin_dark_normal_web.png" width="15%" ></a></<a>
        </div>
        ---->
    
    </div>