<?php 

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
    xmlhttp.open("GET", "<?php echo base_url("kapal/tabel_pembayaran/laut")?>", true);
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