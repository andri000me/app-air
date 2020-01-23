<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="container container-fluid">
        <?php
        if (isset($_SESSION['message_display'])) {
        $message = $_SESSION['message_display'];
        ?>
        <body onload='swal({title: "Berhasil!",
                text: "<?php echo $message?>",
                timer: 3000,
                type: "success",
                showConfirmButton: true });'>
        <?php
        unset($_SESSION['message_display']);
        }
        ?>
        <?php
        if(isset($_SESSION['error_message'])) {
        $error = $_SESSION['error_message'];
        ?>
        <body onload='swal({title: "Gagal!",
                text: "<?php echo $error?>",
                timer: 3000,
                type: "error",
                showConfirmButton: true });'>
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
                    <td colspan="3" align="center"><input type="submit" class="btn btn-success" value="Masuk" name="submit"/></td>
                </tr>
            </table>
            <?php echo form_close(); ?>
        </div>
    </div>