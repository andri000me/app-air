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
    <br><br>
    <table border="0">
        <tr>
            <th align="left" style="width: 15%">ID Flow Meter</th>
            <td style="width: 2%">:</td>
            <td><?= $data_tagihan->id_flowmeter ?></td>
        </tr>
        <tr>
            <th align="left" style="width: 10%">Nama Ruko</th>
            <td style="width: 2%">:</td>
            <td><?= $data_tagihan->nama_pengguna_jasa ?></td>
        </tr>
        <tr>
            <th align="left" style="width: 10%">Alamat</th>
            <td style="width: 2%">:</td>
            <td><?= $data_tagihan->alamat ?></td>
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

        foreach($tagihan as $row) {
            if($i == 1 && $row->flowmeter_hari_ini != NULL){
                $ttl_awal = $row->flowmeter_hari_ini;
            }else{
                if($ttl_awal == 0){
                    $ttl_awal = $row->flowmeter_hari_ini;
                }
            }

            if($i == count($tagihan) && $row->flowmeter_hari_ini != NULL){
                $ttl_akhir = $row->flowmeter_hari_ini;
            }
            $i++;
        }

        $ton_total = $ttl_akhir - $ttl_awal;

        if($data_tagihan->diskon != NULL){
            $total = $ton_total * ($data_tagihan->tarif - ($data_tagihan->tarif * $data_tagihan->diskon/100));
        }else{
            $total = $ton_total * $data_tagihan->tarif;
        }

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
    <br><br><br><br><br><br>
    <table border="1">
        <tr>
            <th align="center" style="width: 3%">No</th>
            <td align="center">Jenis Pelayanan</td>
            <td align="center">Total Penggunaan</td>
            <td align="center">Tarif</td>
            <td align="center">Diskon</td>
            <td align="center">Total Pembayaran</td>
        </tr>
        <tr>
            <td align="center">1</td>
            <td align="center">Jasa Air Bersih</td>
            <td align="center"><?= $ton_total ?> m3</td>
            <td align="center">Rp. <?= $data_tagihan->tarif ?></td>
            <td align="center"><?= $data_tagihan->diskon ?>%</td>
            <td align="center">Rp. <?= $total ?></td>
        </tr>
    </table>
    <br><br><br>
    <table border="0">
        <tr>
            <td style="width: 80%" align="right" colspan="5">&nbsp;</td>
            <td align="center">Balikpapan, <?= date("d M Y",time())?></td>
        </tr>
        <tr>
            <td style="width: 80%" align="right" colspan="5">&nbsp;</td>
            <td align="center">Asisten Manager Operasi</td>
        </tr>
    </table>
    <br><br><br><br><br><br><br><br>
    <table border="0">
        <tr>
            <td style="width: 80%" align="right" colspan="5">&nbsp;</td>
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
