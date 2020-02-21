<?php
if(($this->session->userdata('role_name') == "operasi" || $this->session->userdata('role_name') == "wtp" || $this->session->userdata('role_name') == "admin")){
?>
    <script type="text/javascript">
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                myArr = JSON.parse(this.responseText);

                var i=0;
                var a = "<thead>" +
                    "<tr>" +
                    "<th><center>No</center></th>" +
                    "<th><center>ID Flow Meter</center></th>" +
                    "<th><center>Nama Tenant</center></th>" +
                    "<th><center>Periode Tagihan</center></th>" +
                    "<th><center>Lokasi</center></th>" +
                    "<th><center>No Perjanjian</center></th>" +
                    "<th><center>Total Pemakaian</center></th>" +
                    "<th><center>Aksi</center></th>" +
                    "</tr>" +
                    "</thead>" +
                    "<tbody>";
                while (i < myArr.length) {
                    a +="<tr>" +
                        "<td align='center'>"+myArr[i]["no"]+"</td>" +
                        "<td align='center'>"+myArr[i]["id_flowmeter"]+"</td>" +
                        "<td align='center'>"+myArr[i]["nama_tenant"]+"</td>" +
                        "<td align='center'>"+myArr[i]["periode"]+"</td>" +
                        "<td align='center'>"+myArr[i]["lokasi"]+"</td>" +
                        "<td align='center'>"+myArr[i]["no_perjanjian"]+"</td>" +
                        "<td align='center'>"+myArr[i]["total_pakai"]+"</td>" +
                        "<td align='center'>"+myArr[i]["aksi"]+"</td>" +
                        "</tr>";
                    i++;
                }
                a +="</tbody>" +
                    "<tfoot>" +
                    "<tr>" +
                    "<th><center>No</center></th>" +
                    "<th><center>ID Flow Meter</center></th>" +
                    "<th><center>Nama Tenant</center></th>" +
                    "<th><center>Periode Tagihan</center></th>" +
                    "<th><center>Lokasi</center></th>" +
                    "<th><center>No Perjanjian</center></th>" +
                    "<th><center>Total Pemakaian</center></th>" +
                    "<th><center>Aksi</center></th>" +
                    "</tr>" +
                    "</tfoot>";
                document.getElementById("table").innerHTML= a;
            }
        }
        xmlhttp.open("GET", "<?php echo base_url("tenant/tabel_realisasi_tenant")?>", true);
        xmlhttp.send();
    </script>
    <script>
        function batal(id){
            var url;
            var id = id;
            url = "<?php echo site_url('tenant/cancelRealisasiTenant')?>";
            if (confirm('Batalkan Transaksi ?')) {
                $.ajax({
                    url : url,
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        alert('Transaksi Sudah Dibatalkan');
                        window.location.replace('<?php echo base_url('main/tenant/daftar_realisasi_air_tenant');?>');
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Gagal Mengupdate Data'+" "+textStatus+" "+errorThrown);
                    }
                });
            }
        }
    </script>
    <body>
    <div class="container container-fluid">
        <div class="row">
            <center><h4>Daftar Tagihan Pelayanan Jasa Pengisian Air Bersih Untuk Tenant</h4></center><br>
            <table class="table table-responsive table-bordered table-striped" id="table"></table>
        </div>
    </div>
    </body>
<?php
}