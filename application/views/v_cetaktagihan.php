<?php
if($this->session->userdata('role') == "operasi" && $this->session->userdata('session') != NULL && $tagihan != NULL){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?=$title?></title>
        <style>
            table{
                border-collapse: collapse;
                width: 100%;
                margin: 0 auto;
            }
            table th{
                border:1px solid #000;
                padding: 3px;
                font-weight: bold;
                text-align: center;
            }
            table td{
                border:1px solid #000;
                padding: 3px;
                vertical-align: top;
            }
        </style>
    </head>
    <body>
    <table border="0">
        <tr>
            <td><h2>PT Kaltim Kariangau Terminal</h2><br><h2>Terminal Peti Kemas</h2><br></td>
            <td align="right"><h4>Tanggal Tagihan : <?= date("d M Y",time())?></h4></td>
        </tr>
    </table>
    <br><br><br><br><br><br><br>
    <h3 style="text-align: center"><?= $title?></h3>
    <h3 style="text-align: center">No Invoice : <?= $detail_tagihan->no_invoice ?></h3>
    <br><br>
    <table border="0">
        <tr><th align="left">Customer</th></tr>
        <tr>
            <th align="left" style="width: 15%">Nama</th>
            <td style="width: 2%">:</td>
            <td><?= $data_tagihan->nama_tenant ?></td>
        </tr>
        <tr>
            <th align="left" style="width: 10%">Alamat</th>
            <td style="width: 2%">:</td>
            <td><?= $data_tagihan->lokasi ?></td>
        </tr>
        <tr>
            <th align="left" style="width: 10%">Kota</th>
            <td style="width: 2%">:</td>
            <td>Balikpapan</td>
        </tr>
        <tr>
            <th align="left" style="width: 10%">No Telepon</th>
            <td style="width: 2%">:</td>
            <td><?= $data_tagihan->no_telp ?></td>
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
            foreach($tagihan as $data) {
                if($data_tagihan->id_ref_flowmeter == $data->id_flow){
                    if($i == 1 && $data->flow_hari_ini != NULL){
                        $ttl_awal = $data->flow_hari_ini;
                    }else{
                        if($ttl_awal == 0){
                            $ttl_awal = $data->flow_hari_ini;
                        }
                    }
                    if($i == count($data) && $data->flow_hari_ini != NULL){
                        $ttl_akhir = $data->flow_hari_ini;
                    }
                    $i++;
                }else{
                    $i=1;
                }
            }
        }

        $ton_total = $detail_tagihan->total_pakai;
        $total = $detail_tagihan->total_bayar;

        if($total == '0'){
            return '';
        }
        elseif($total < 100){
            $total.= ',-';
        }
        else{
            $total = number_format($total,0,'','.').',-';
        }

        if($data_tagihan->tarif == '0'){
            return '';
        }
        elseif($data_tagihan->tarif < 100){
            $data_tagihan->tarif.= ',-';
        }
        else{
            $data_tagihan->tarif = number_format($data_tagihan->tarif,0,'','.').',-';
        }
        ?>
    <br><br><br><br><br><br><br>
    <table border="1">
        <?php
        if($data_tagihan->id_ref_tenant == NULL){
            ?>
            <tr>
                <td align="center">Pembayaran</td>
                <td align="center">Satuan</td>
                <td align="center">Flow Meter Awal</td>
                <td align="center">Flow Meter Akhir</td>
                <td align="center">Pemakaian</td>
                <td align="center">Tarif</td>
                <td align="center">Total</td>
            </tr>
            <tr>
                <td align="center">Pemakaian Air</td>
                <td align="center">Ton/m3</td>
                <td align="center"><?= $ttl_awal?> m3</td>
                <td align="center"><?= $ttl_akhir ?> m3</td>
                <td align="center"><?=  $ton_total?> m3</td>
                <td align="center"><?= $data_tagihan->tarif?></td>
                <td align="center"><?= $total ?></td>
            </tr>
            <tr>
                <td align="right" colspan="5">Sub Total</td>
                <td align="center"><?= $total ?></td>
            </tr>
            <tr>
                <td align="right" colspan="5">Total</td>
                <td align="center">Rp. <?= $total ?></td>
            </tr>
            <?php
        }else{
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
                <td align="center"><?= $total ?></td>
                <td align="center"><?= $total ?></td>
            </tr>
            <tr>
                <td align="right" colspan="4">Sub Total</td>
                <td align="center"><?= $total ?></td>
            </tr>
            <tr>
                <td align="right" colspan="4">Total</td>
                <td align="center">Rp. <?= $total ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <br><br><br>
    <table border="0">
        <tr>
            <td style="width: 80%" align="right" colspan="4">&nbsp;</td>
            <td align="center">Balikpapan, <?= date("d M Y",time())?></td>
        </tr>
        <tr>
            <td style="width: 80%" align="right" colspan="4">&nbsp;</td>
            <td align="center">Asisten Manager Operasi</td>
        </tr>
    </table>
    <br><br><br><br><br><br>
    <table border="0">
        <tr>
            <td style="width: 80%" align="right" colspan="4">&nbsp;</td>
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
