<?php
if($this->session->userdata('role') == "loket" || $this->session->userdata('role') == "keuangan" && $this->session->userdata('session') != NULL){
?>

<?php
}
else if($this->session->userdata('role') == "wtp" && $this->session->userdata('session') != NULL){
?>


<?php
}
else {
    $web = base_url('main');
    ?>
    <script>
        alert('Maaf Anda Tidak Mempunyai Hak Akses Ke Halaman Ini. Silahkan Login Terlebih Dahulu');
        window.location.replace('<?= $web?>');
    </script>
<?php
}
?>
