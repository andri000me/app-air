<?php
if($this->session->userdata('role') == "loket" && $this->session->userdata('session') != NULL && $tipe == 'darat'){
?>
<div class="container container-fluid">
    <div class="row">
        <script type="text/javascript">
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    myArr = JSON.parse(this.responseText);

                    var i=0;
                    var a = "<thead>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>Nama Perusahaan / Pemohon</center></th>" +
                        "<th><center>Alamat</center></th>" +
                        "<th><center>Waktu Permohonan</center></th>" +
                        "<th><center>Waktu Pelayanan</center></th>" +
                        "<th><center>Vol (Ton)</center></th>" +
                        "<th><center>Waktu Mulai Pengantaran</center></th>" +
                        "<th><center>Waktu Selesai Pengantaran</center></th>" +
                        "<th><center>Aksi</center></th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>";
                    while (i < myArr.length) {
                        a +="<tr>" +
                            "<td align='center'>"+myArr[i]["no"]+"</td>" +
                            "<td align='center'>"+myArr[i]["nama"]+"</td>" +
                            "<td align='center'>"+myArr[i]["alamat"]+"</td>" +
                            "<td align='center'>"+myArr[i]["tgl_transaksi"]+"</td>" +
                            "<td align='center'>"+myArr[i]["tgl_permintaan"]+"</td>" +
                            "<td align='center'>"+myArr[i]["total_pengisian"]+"</td>" +
                            "<td align='center'>"+myArr[i]["waktu_mulai_pengantaran"]+"</td>" +
                            "<td align='center'>"+myArr[i]["waktu_selesai_pengantaran"]+"</td>" +
                            "<td align='center'>"+myArr[i]["aksi"]+"</td>" +
                            "</tr>";
                        i++;
                    }
                    a +="</tbody>" +
                        "<tfoot>" +
                        "<tr>" +
                        "<th><center>No</center></th>" +
                        "<th><center>Nama Pelanggan</center></th>" +
                        "<th><center>Alamat</center></th>" +
                        "<th><center>Waktu Permohonan</center></th>" +
                        "<th><center>Waktu Pelayanan</center></th>" +
                        "<th><center>Vol (Ton)</center></th>" +
                        "<th><center>Waktu Mulai Pengantaran</center></th>" +
                        "<th><center>Waktu Selesai Pengantaran</center></th>" +
                        "<th><center>Aksi</center></th>" +
                        "</tr>" +
                        "</tfoot>";
                    document.getElementById("table").innerHTML= a;
                }
            }
            xmlhttp.open("GET", "<?= base_url("main/tabel_monitoring?id=darat")?>", true);
            xmlhttp.send();
        </script>
        <body>
        <div class="container container-fluid">
            <div class="row">
                <br><br>
                <center><h4>Daftar Monitoring Pelayanan Jasa Pengisian Air Bersih</h4></center><br>
                <table class="table table-responsive table-bordered table-striped" id="table"></table>
            </div>
        </div>
        </body>
        <script>
            function batal(id){
                var url;
                var id = id;
                url = "<?php echo site_url('main/cancelTransaksiDarat')?>";
                if (confirm('Batalkan Transaksi ?')) {
                    $.ajax({
                        url : url,
                        type: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            alert('Transaksi Sudah Dibatalkan');
                            window.location.replace('<?= base_url('main/view?id=monitoring_darat');?>');
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Gagal Mengupdate Data'+" "+textStatus+" "+errorThrown);
                        }
                    });
                }
            }
        </script>
    </div>
</div>
<?php
}
else if($this->session->userdata('role') == "wtp" && $this->session->userdata('session') != NULL && $tipe == 'laut'){
    ?>
    <script type="text/javascript">
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                myArr = JSON.parse(this.responseText);
                var i = 0;
                var a = "<thead>" +
                    "<tr>" +
                    "<th><center>No</center></th>" +
                    "<th><center>ID VESSEL</center></th>" +
                    "<th><center>Voy No</center></th>" +
                    "<th><center>Nama VESSEL</center></th>" +
                    "<th><center>Nama Perusahaan</center></th>" +
                    "<th><center>Nama Pemohon</center></th>" +
                    "<th><center>Tanggal Transaksi</center></th>" +
                    "<th><center>Waktu Pelayanan</center></th>" +
                    "<th><center>Jumlah Permintaan</center></th>" +
                    "<th><center>Flow Meter Sebelum Pengisian<center></th>" +
                    "<th><center>Flow Meter Sesudah Pengisian<center></th>" +
                    "<th><center>Realisasi</center></th>"+
                    "<th><center>Aksi</center></th>";
                a += "</tr>" +
                    "</thead>" +
                    "<tbody>";
                while (i < myArr.length) {
                    a += "<tr>" +
                        "<td align='center'>" + myArr[i]["no"] + "</td>" +
                        "<td align='center'>" + myArr[i]["id_kapal"] + "</td>" +
                        "<td align='center'>" + myArr[i]["voy_no"] + "</td>" +
                        "<td align='center'>" + myArr[i]["nama_lct"] + "</td>" +
                        "<td align='center'>" + myArr[i]["nama_perusahaan"] + "</td>" +
                        "<td align='center'>" + myArr[i]["nama_pemohon"] + "</td>" +
                        "<td align='center'>" + myArr[i]["tgl_transaksi"] + "</td>" +
                        "<td align='center'>" + myArr[i]["waktu_pelayanan"] + "</td>" +
                        "<td align='center'>" + myArr[i]["total_permintaan"] + "</td>" +
                        "<td align='center'>" + myArr[i]["flow_sebelum"] + "</td>" +
                        "<td align='center'>" + myArr[i]["flow_sesudah"] + "</td>" +
                        "<td align='center'>" + myArr[i]["realisasi"] + "</td>"+
                        "<td align='center'>" + myArr[i]["aksi"] + "</td>";
                    a += "</tr>";
                    i++;
                }
                a += "</tbody>" +
                    "<tfoot>" +
                    "<tr>" +
                    "<th><center>No</center></th>" +
                    "<th><center>ID VESSEL</center></th>" +
                    "<th><center>Voy No</center></th>" +
                    "<th><center>Nama VESSEL</center></th>" +
                    "<th><center>Nama Perusahaan</center></th>" +
                    "<th><center>Nama Pemohon</center></th>" +
                    "<th><center>Tanggal Transaksi</center></th>" +
                    "<th><center>Waktu Pelayanan</center></th>" +
                    "<th><center>Jumlah Permintaan</center></th>" +
                    "<th><center>Flow Meter Sebelum Pengisian<center></th>" +
                    "<th><center>Flow Meter Sesudah Pengisian<center></th>" +
                    "<th><center>Realisasi</center></th>"+
                    "<th><center>Aksi</center></th>";
                a += "</tr>" +
                    "</tfoot>";
                document.getElementById("table").innerHTML = a;
            }
        }
        xmlhttp.open("GET", "<?= base_url("main/tabel_pembayaran?id=laut")?>", true);
        xmlhttp.send();
    </script>
    <body>
    <div class="container container-fluid">
        <div class="row">
            <center><h4>Status Permintaan Pelayanan Jasa Air Bersih Untuk Kapal</h4></center><br>
            <table class="table table-responsive table-bordered table-striped" id="table"></table>
        </div>
    </div>
    </body>
    <?php
}
else if($this->session->userdata('role') == "wtp" && $this->session->userdata('session') != NULL && $tipe == 'darat'){
    ?>
    <div class="container container-fluid">
        <div class="row">
            <script type="text/javascript">
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        myArr = JSON.parse(this.responseText);

                        var i=0;
                        var a = "<thead>" +
                            "<tr>" +
                            "<th><center>No</center></th>" +
                            "<th><center>Nama Perusahaan / Pemohon</center></th>" +
                            "<th><center>Alamat</center></th>" +
                            "<th><center>Waktu Permohonan</center></th>" +
                            "<th><center>Waktu Pelayanan</center></th>" +
                            "<th><center>Vol (Ton)</center></th>" +
                            "<th><center>Waktu Mulai Pengantaran</center></th>" +
                            "<th><center>Waktu Selesai Pengantaran</center></th>" +
                            "</tr>" +
                            "</thead>" +
                            "<tbody>";
                        while (i < myArr.length) {
                            a +="<tr>" +
                                "<td align='center'>"+myArr[i]["no"]+"</td>" +
                                "<td align='center'>"+myArr[i]["nama"]+"</td>" +
                                "<td align='center'>"+myArr[i]["alamat"]+"</td>" +
                                "<td align='center'>"+myArr[i]["tgl_transaksi"]+"</td>" +
                                "<td align='center'>"+myArr[i]["tgl_permintaan"]+"</td>" +
                                "<td align='center'>"+myArr[i]["total_pengisian"]+"</td>" +
                                "<td align='center'>"+myArr[i]["waktu_mulai_pengantaran"]+"</td>" +
                                "<td align='center'>"+myArr[i]["waktu_selesai_pengantaran"]+"</td>" +
                                "</tr>";
                            i++;
                        }
                        a +="</tbody>" +
                            "<tfoot>" +
                            "<tr>" +
                            "<th><center>No</center></th>" +
                            "<th><center>Nama Perusahaan / Pemohon</center></th>" +
                            "<th><center>Alamat</center></th>" +
                            "<th><center>Waktu Permohonan</center></th>" +
                            "<th><center>Waktu Pelayanan</center></th>" +
                            "<th><center>Vol (Ton)</center></th>" +
                            "<th><center>Waktu Mulai Pengantaran</center></th>" +
                            "<th><center>Waktu Selesai Pengantaran</center></th>" +
                            "</tr>" +
                            "</tfoot>";
                        document.getElementById("table").innerHTML= a;
                    }
                }
                xmlhttp.open("GET", "<?= base_url("main/tabel_monitoring?id=darat")?>", true);
                xmlhttp.send();
            </script>
            <body>
            <div class="container container-fluid">
                <div class="row">
                    <br><br>
                    <center><h4>Daftar Monitoring Pelayanan Jasa Pengisian Air Bersih</h4></center><br>
                    <table class="table table-responsive table-bordered table-striped" id="table"></table>
                </div>
            </div>
            </body>
            <script>
                function batal(id){
                    var url;
                    var id = id;
                    url = "<?php echo site_url('main/cancelTransaksiDarat')?>";
                    if (confirm('Batalkan Transaksi ?')) {
                        $.ajax({
                            url : url,
                            type: "POST",
                            data: {
                                id: id
                            },
                            success: function(data) {
                                alert('Transaksi Sudah Dibatalkan');
                                window.location.replace('<?= base_url('main');?>');
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('Gagal Mengupdate Data'+" "+textStatus+" "+errorThrown);
                            }
                        });
                    }
                }
            </script>
        </div>
    </div>
    <?php
}
else{
    $web = base_url('main');
    ?>
    <script>
        alert('Maaf Anda Tidak Mempunyai Hak Akses Ke Halaman Ini. Silahkan Login Terlebih Dahulu');
        window.location.replace('<?= $web?>');
    </script>
    <?php
}