<?php
if($this->session->userdata('role') == 'wtp'){
    ?>

    <?php
} else{
    redirect('main');
}
?>