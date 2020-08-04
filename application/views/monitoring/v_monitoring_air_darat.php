<body>
    <div class="container">
        <div class="row">
            <center><h4>Daftar Monitoring Pelayanan Jasa Pengisian Air Bersih</h4></center><br>
            <table class="table table-responsive table-bordered table-striped" id="table" width="100%"></table>
        </div>
    </div>
</body>

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
                "<th><center>Pembayaran</center></th>" +
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
                    "<td align='center'>"+myArr[i]["status_invoice"]+"</td>" +
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
                "<th><center>Pembayaran</center></th>" +
                "<th><center>Vol (Ton)</center></th>" +
                "<th><center>Waktu Mulai Pengantaran</center></th>" +
                "<th><center>Waktu Selesai Pengantaran</center></th>" +
                "</tr>" +
                "</tfoot>";
            document.getElementById("table").innerHTML= a;
        }
    }
    xmlhttp.open("GET", "<?php echo base_url("darat/tabel_monitoring")?>", true);
    xmlhttp.send();

    function batal(id){
        var url;
        var id = id;
        url = "<?php echo site_url('darat/cancelTransaksiDarat')?>";
        if (confirm('Batalkan Transaksi ?')) {
            $.ajax({
                url : url,
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    alert('Transaksi Sudah Dibatalkan');
                    window.location.replace('<?php echo base_url('main/monitoring/monitoring_air_darat');?>');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Gagal Mengupdate Data'+" "+textStatus+" "+errorThrown);
                }
            });
        }
    }
</script>