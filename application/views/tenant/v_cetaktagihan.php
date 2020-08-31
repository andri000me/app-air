<?php
if(($this->session->userdata('role_name') == "operasi" || $this->session->userdata('role_name') == "admin")){
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
    <h3 style="text-align: center">No Invoice : <?php echo $detail_tagihan->no_invoice ?></h3>
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
            $total -= $materai;
            $total_bayar = $total + $materai;
            $total = number_format($total,0,'','.').',-';
            $total_bayar = number_format($total_bayar,0,'','.').',-';
            $materai = number_format($materai,0,'','.').',-';
        } else if($total > 1000000){
            $materai = 6000;
            $total -= $materai;
            $total_bayar = $total + $materai;
            $total = number_format($total,0,'','.').',-';
            $total_bayar = number_format($total_bayar,0,'','.').',-';
            $materai = number_format($materai,0,'','.').',-';
        } else {
            $materai = 0;
            $total -= $materai;
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

        if($diskon->diskon != NULL || $diskon->diskon != '')
            $diskon = $diskon->diskon." %";
        else
            $diskon = '';
        
        ?>
    <br>
    <table border="1">
        <?php
        $tanggal_sekarang = date('Y-m-d',time());
        if($data_tagihan->id_ref_tenant != NULL && $data_tagihan->waktu_kadaluarsa > $tanggal_sekarang){
            ?>
            <tr>
                <td align="center">Kegiatan</td>
                <td align="center">Satuan</td>
                <td align="center">Pemakaian</td>
                <td align="center">Tarif</td>
                <td align="center">Total</td>
            </tr>
            <tr>
                <td align="center">Pemakaian Air</td>
                <td align="center">Per Bulan</td>
                <td align="center">1</td>
                <td align="center"><?php echo $total ?></td>
                <td align="center"><?php echo $total ?></td>
            </tr>
            <tr>
                <td align="right" colspan="4">Sub Total</td>
                <td align="center"><?php echo $total ?></td>
            </tr>
            <tr>
                <td align="right" colspan="4">Total</td>
                <td align="center">Rp. <?php echo $total ?></td>
            </tr>
            <?php
        }
        else{
            ?>
            <tr>
                <td align="center">Pembayaran</td>
                <td align="center">Satuan</td>
                <td align="center">Flow Meter Awal</td>
                <td align="center">Flow Meter Akhir</td>
                <td align="center">Pemakaian</td>
                <td align="center">Tarif</td>
                <td align="center">Diskon</td>
                <td align="center">Total</td>
            </tr>
            <tr>
                <td align="center">Pemakaian Air</td>
                <td align="center">Ton/m3</td>
                <td align="center"><?php echo $ttl_awal ?></td>
                <td align="center"><?php echo $ttl_akhir ?></td>
                <td align="center"><?php echo $ton_total?> m3</td>
                <td align="center">Rp. <?php echo $data_tagihan->tarif?></td>
                <td align="center"><?php echo $diskon?></td>
                <td align="center">Rp. <?php echo $total ?></td>
            </tr>
            <tr>
                <td align="right" colspan="7">Sub Total</td>
                <td align="center">Rp. <?php echo $total ?></td>
            </tr>
            <tr>
                <td align="right" colspan="7">Materai</td>
                <td align="center">Rp. <?php echo $materai ?></td>
            </tr>
            <tr>
                <td align="right" colspan="7">Total</td>
                <td align="center">Rp. <?php echo $total_bayar ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <br>
    <table border="0">
        <tr>
            <td style="width: 80%" align="right" colspan="4"></td>
            <td align="center">Balikpapan, <?php echo date("d M Y",time())?></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td style="width: 80%" align="right" colspan="4"></td>
            <td align="center">ASMAN PERENCANAAN DAN PEMASARAN</td>
        </tr>
    </table>
    <br><br><br>
    <table border="0">
        <tr>
            <td style="width: 80%;height:-40%;" align="right" colspan="4"></td>
            <td align="center">(<u>BOGIE BRAMANTO</u>)</td>
        </tr>
    </uBOGIE>
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
