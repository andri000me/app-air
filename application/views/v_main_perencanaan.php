<?php
if($this->session->userdata('role') == "admin") {
    ?>
    <script type="text/javascript">
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                myArr = JSON.parse(this.responseText);
                var role = 'perencanaan';
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
                    "<th><center>Jumlah Permintaan</center></th>" +
                    "<th><center>Flow Meter Sebelum Pengisian<center></th>" +
                    "<th><center>Flow Meter Sesudah Pengisian<center></th>" +
                    "<th><center>Realisasi</center></th>";
                a += "<th><center>Aksi</center></th>";
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
                        "<td align='center'>" + myArr[i]["total_permintaan"] + "</td>" +
                        "<td align='center'>" + myArr[i]["flow_sebelum"] + "</td>" +
                        "<td align='center'>" + myArr[i]["flow_sesudah"] + "</td>" +
                        "<td align='center'>" + myArr[i]["realisasi"] + "</td>";
                    if (myArr[i]["aksi"] != null) {
                        a += "<td align='center'>" + myArr[i]["aksi"] + "</td>";
                    }
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
                    "<th><center>Jumlah Permintaan</center></th>" +
                    "<th><center>Flow Meter Sebelum Pengisian<center></th>" +
                    "<th><center>Flow Meter Sesudah Pengisian<center></th>" +
                    "<th><center>Realisasi</center></th>";
                a += "<th><center>Aksi</center></th>";
                a += "</tr>" +
                    "</tfoot>";
                document.getElementById("table").innerHTML = a;
            }
        }
        xmlhttp.open("GET", "<?php echo base_url("main/tabel_pembayaran?id=laut_perencanaan")?>", true);
        xmlhttp.send();
    </script>
    <script>
        function batal(id) {
            var url;
            var id = id;
            url = "<?php echo site_url('main/cancelTransaksiLaut')?>";
            if (confirm('Batalkan Transaksi ?')) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "sukses") {
                            alert('Transaksi Sudah Dibatalkan');
                            window.location.replace('<?php echo base_url('main');?>');
                        } else {
                            alert('Transaksi Gagal Dibatalkan....Kemungkinan Pengisian Kapal Sudah Dilakukan');
                            window.location.replace('<?php echo base_url('main');?>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Gagal Mengupdate Data' + " " + textStatus + " " + errorThrown);
                    }
                });
            }
        }
    </script>
    <body>
    <div class="container container-fluid">
        <div class="row">
            <center><h4>Status Permintaan Pelayanan Jasa Air Bersih Untuk Kapal</h4></center>
            <br>
            <table class="table table-responsive table-bordered table-striped" id="table"></table>
        </div>
    </div>
    </body>
    <?php
}
?>