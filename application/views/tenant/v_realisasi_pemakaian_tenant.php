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
        </style>
    </head>
    <body>
    <table border="0">
        <tr>
            <td><h2>PT Kaltim Kariangau Terminal</h2><h2>Terminal Peti Kemas</h2></td>
            <td align="right"><h4>Tanggal Tagihan : <?php echo date("d M Y",time())?></h4></td>
        </tr>
    </table>
    <h3 style="text-align: center"><?php echo $title?></h3>
    <br>
    <table border="0">
        <tr><th align="left">Customer</th></tr>
        <tr>
            <th align="left" style="width: 15%">Nama</th>
            <td style="width: 2%">:</td>
            <td><?php echo $data_tagihan->nama_tenant ?></td>
        </tr>
        <tr>
            <th align="left" style="width: 10%">Lokasi</th>
            <td style="width: 2%">:</td>
            <td><?php echo $data_tagihan->lokasi ?></td>
        </tr>
        <tr>
            <th align="left" style="width: 10%">Kota</th>
            <td style="width: 2%">:</td>
            <td>Balikpapan</td>
        </tr>
        <tr>
            <th align="left" style="width: 10%">No Telepon</th>
            <td style="width: 2%">:</td>
            <td><?php echo $data_tagihan->no_telp ?></td>
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
        $total = $detail_tagihan->total_bayar;
        $tarif = '';

        if($total >= 250000 && $total <= 1000000){
            $materai = 3000;
            $total_bayar = $total + $materai;
            $total = number_format($total,0,'','.').',-';
            $total_bayar = number_format($total_bayar,0,'','.').',-';
            $materai = number_format($materai,0,'','.').',-';
        } else if($total > 1000000){
            $materai = 6000;
            $total_bayar = $total + $materai;
            $total = number_format($total,0,'','.').',-';
            $total_bayar = number_format($total_bayar,0,'','.').',-';
            $materai = number_format($materai,0,'','.').',-';
        } else {
            $materai = 0;
            $total_bayar = $total + $materai;
            $total = number_format($total,0,'','.').',-';
            $total_bayar = number_format($total_bayar,0,'','.').',-';
            $materai = number_format($materai,0,'','.').',-';
        }

        //$tarif = $data_tagihan->$tarif;        
        /*
        if($total == '0'){
            return '';
        }
        elseif($total < 100){
            $total.= ',-';
        }
        else{
            $total = number_format($total,0,'','.').',-';
        }
        */

        if($data_tagihan->tarif == '0'){
            return '';
        }
        elseif($data_tagihan->tarif < 100){
            $data_tagihan->tarif.= ',-';
        }
        else{
            $data_tagihan->tarif = number_format($data_tagihan->tarif,0,'','.').',-';
        }

        if($data_tagihan->diskon != NULL || $data_tagihan->diskon != '')
            $diskon = $data_tagihan->diskon." %";
        else
            $diskon = '';
        
        ?>
    <br>
    <table border="1">
        <tr>
            <td align="center">Jasa</td>
            <td align="center">Satuan</td>
            <td align="center">Flow Meter Awal</td>
            <td align="center">Flow Meter Akhir</td>
            <td align="center">Pemakaian</td>
        </tr>
        <tr>
            <td align="center">Pemakaian Air</td>
            <td align="center">Ton/m3</td>
            <td align="center"><?php echo $ttl_awal ?></td>
            <td align="center"><?php echo $ttl_akhir ?></td>
            <td align="center"><?php echo $ton_total?> m3</td>
        </tr>
    </table>
    <br><br>
    <table border="0">
        <tr>
            <td>&nbsp;</td>
            <td style="width: 22%" align="right" colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
            <td style="width: 40%" align="right" colspan="4">&nbsp;</td>
            <td align="center">Balikpapan, <?php echo date("d M Y",time())?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td style="width: 22%" align="right" colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
            <td style="width: 40%" align="right" colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center">PENANGGUNG JAWAB TENANT</td>
            <td style="width: 22%" align="right" colspan="4">&nbsp;</td>
            <td align="center">PETUGAS WTP</td>
            <td style="width: 40%" align="right" colspan="4">&nbsp;</td>
            <td align="center">ASMAN OPERASI PELAYANAN NON PETI KEMAS</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td style="width: 22%" align="right" colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
            <td style="width: 40%" align="right" colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td style="width: 22%" align="right" colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
            <td style="width: 40%" align="right" colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center">(..............................................)</td>
            <td style="width: 22%" align="right" colspan="4">&nbsp;</td>
            <td align="center">(..............................................)</td>
            <td style="width: 40%" align="right" colspan="4">&nbsp;</td>
            <td align="center">(..............................................)</td>
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
