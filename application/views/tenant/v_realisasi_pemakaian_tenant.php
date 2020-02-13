<?php
if(($this->session->userdata('role_name') == "wtp" || $this->session->userdata('role_name') == "admin")){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo$title?></title>
        <style>
            table{
                border-collapse: collapse;
                width: 100%;
                margin: 0 auto;
            }
            .underline {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
    <img src="logo_kkt.png" width="100" height="50">
    <table border="0">
        <tr><td><center><strong style="font-style: Bold">PT KALTIM KARIANGAU TERMINAL</strong></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><center><b>FORM PENGISIAN AIR BERSIH DI TPK KARIANGAU</b></td></tr>
    </table>
    <br>
    <table border="0">
        <tr>
            <th align="left" style="width: 15%">Nama</th>
            <td style="width: 2%">:</td>
            <td><?php echo $data_tagihan->nama_tenant ?></td>
        </tr>
        <tr>
            <th align="left" style="width: 10%">Kota</th>
            <td style="width: 2%">:</td>
            <td>Balikpapan</td>
        </tr>
        <tr>
            <th align="left" style="width: 10%">Tanggal</th>
            <td style="width: 2%">:</td>
            <td><?php echo $tanggal ?></td>
        </tr>
    </table>
        <?php
        $no = 0;
        $total =0;
        $ton = 0;
        $ton_total=0;
        $ttl_akhir=0;
        $ttl_awal=0;
        $i=1;

        if($tagihan != NULL){
            foreach($tagihan as $row) {
                if($i == 1 && $row->flow_hari_ini != NULL){
                    $ttl_awal = $row->flow_hari_ini;
                }else{
                    if($ttl_awal == 0){
                        $ttl_awal = $row->flow_hari_ini;
                    }
                }

                if($i == count($tagihan) && $row->flow_hari_ini != NULL){
                    $ttl_akhir = $row->flow_hari_ini;
                }
                $i++;
                $tes = count($tagihan);
            }
        }

        $ton_total = $detail_tagihan->total_pakai;
        
        ?>
    <br>
    <table border="1">
        <tr>
            <td align="center">NO</td>
            <td align="center">JENIS PELAYANAN</td>
            <td align="center">SATUAN</td>
            <td align="center">METERAN AWAL BULAN</td>
            <td align="center">METERAN AKHIR BULAN</td>
            <td align="center">TOTAL PEMAKAIAN</td>
        </tr>
        <tr>
            <td align="center">1</td>
            <td align="center">PENGISIAN AIR BERSIH</td>
            <td align="center">TON</td>
            <td align="center"><?php echo $ttl_awal ?></td>
            <td align="center"><?php echo $ttl_akhir ?></td>
            <td align="center"><?php echo $ton_total?> m3</td>
        </tr>
    </table>
    <br><br>
    <table border="0">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center">Balikpapan, <?php echo $tgl ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center"><?php echo $data_tagihan->nama_tenant ?></td>
            <td>&nbsp;</td>
            <td align="center">KOORDINATOR PENGISIAN AIR BERSIH</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center">(..............................................)</td>
            <td style="width: 10%">&emsp;</td>
            <td align="center">(..............................................)</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table>
        <tr>
            <td>&nbsp;</td>
            <td align="center">PT. KALTIM KARIANGAU TERMINAL <br> ASMAN OPERASI PELAYANAN NON PETIKEMAS</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="center" class="underline">BERLY KARDIN SENAPATI</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    </body>
    </html>
    <?php
}
else{
    $web = base_url('main/tagihan');
    echo "<script type='text/javascript'>
                        alert('Data Yang Ingin Ditampilkan Tidak Ada ! Coba Lagi')
                        window.location.replace('$web')
            </script>";
}
?>
