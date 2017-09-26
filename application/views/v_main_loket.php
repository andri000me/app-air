<?php
if($this->session->userdata('role') == "admin" && $this->session->userdata('session') != NULL){
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
                            "<th><center>Waktu Permohonan</center></th>" +
                            "<th><center>Waktu Pelayanan</center></th>" +
                            "<th><center>Jenis</center></th>" +
                            "<th><center>Tarif (Rp.)</center></th>" +
                            "<th><center>Vol (Ton)</center></th>" +
                            "<th><center>Jumlah Bayar (Rp.)<center></th>" +
                            "<th><center>Aksi</center></th>" +
                            "</tr>" +
                            "</thead>" +
                            "<tbody>";
                        while (i < myArr.length) {
                            if(myArr[i]["color"] != null){
                                a +="<tr style='background-color:"+myArr[i]["color"]+"'>" +
                                    "<td align='center'>"+myArr[i]["no"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["nama"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tgl_transaksi"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tgl_permintaan"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["jenis"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tarif"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["total_pengisian"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["total_pembayaran"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["aksi"]+"</td>" +
                                    "</tr>";
                                i++;
                            } else {
                                a +="<tr>" +
                                    "<td align='center'>"+myArr[i]["no"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["nama"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tgl_transaksi"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tgl_permintaan"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["jenis"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["tarif"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["total_pengisian"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["total_pembayaran"]+"</td>" +
                                    "<td align='center'>"+myArr[i]["aksi"]+"</td>" +
                                    "</tr>";
                                i++;
                            }
                        }
                        a +="</tbody>" +
                            "<tfoot>" +
                            "<tr>" +
                            "<th><center>No</center></th>" +
                            "<th><center>Nama Perusahaan / Pemohon</center></th>" +
                            "<th><center>Waktu Permohonan</center></th>" +
                            "<th><center>Waktu Pelayanan</center></th>" +
                            "<th><center>Jenis</center></th>" +
                            "<th><center>Tarif (Rp.)</center></th>" +
                            "<th><center>Vol (Ton)</center></th>" +
                            "<th><center>Jumlah Bayar (Rp.)<center></th>" +
                            "<th><center>Aksi</center></th>" +
                            "</tr>" +
                            "</tfoot>";
                        document.getElementById("table").innerHTML= a;
                    }
                }
                xmlhttp.open("GET", "<?php echo base_url("main/tabel_pembayaran?id=darat")?>", true);
                xmlhttp.send();
            </script>
            <body>
            <div class="container container-fluid">
                <div class="row">
                    <center><h4>Daftar Permohonan Pelayanan Jasa Pengisian Air Bersih</h4></center><br>
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
                                window.location.replace('<?php echo base_url('main/view?id=main_loket');?>');
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('Gagal Mengupdate Data'+" "+textStatus+" "+errorThrown);
                            }
                        });
                    }
                }
            </script>
            <script>
                function cancel_kwitansi(id){
                    var url;
                    var id = id;
                    url = "<?php echo site_url('main/cancelKwitansi')?>";
                    if (confirm('Batalkan Kwitansi ?')) {
                        $.ajax({
                            url : url,
                            type: "POST",
                            data: {
                                id: id
                            },
                            success: function(data) {
                                alert('Kwitansi Sudah Dibatalkan');
                                window.location.replace('<?php echo base_url('main/view?id=main_loket');?>');
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