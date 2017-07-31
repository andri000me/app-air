<?php
if($this->session->userdata('role') == "operasi" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "darat"){
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
    <h3 style="text-align: center"><?= $title?></h3>
    <br><br>
    <table>
        <tr>
            <th align="center" style="width: 2%">No</th>
            <th align="center" style="width: 20%">No Kwitansi</th>
            <th align="center" style="width: 20%">Nama Nama Pengguna Jasa</th>
            <th align="center">Alamat</th>
            <th align="center">No Telp</th>
            <th align="center">Tanggal Transaksi</th>
            <th align="center">Tarif</th>
            <th align="center">Total Permintaan (Ton)</th>
            <th align="center">Total Pembayaran (Rp.)</th>
        </tr>
        <?php
        $no=0;
        $total=0;
        $ton=0;
        foreach($laporan as $rbarang) {
                $no++;
                $format_tgl = date('d-m-Y', strtotime($rbarang->tgl_transaksi));

                if($rbarang->batal_kwitansi == 1){
                    $total_pembayaran = '';
                } else if ($rbarang->diskon != NULL || $rbarang->diskon != 0) {
                    $rbarang->tarif -= $rbarang->tarif * $rbarang->diskon / 100;
                    $total_pembayaran = $rbarang->tarif * $rbarang->total_permintaan;
                } else {
                    $total_pembayaran = $rbarang->tarif * $rbarang->total_permintaan;
                }

                if($rbarang->batal_kwitansi == 0){
                    $total += $total_pembayaran;
                    $ton += $rbarang->total_permintaan;
                }

                if ($total_pembayaran == '0')
                    return '';
                elseif ($total_pembayaran < 100)
                    $total_pembayaran .= ',-';
                else
                    $total_pembayaran = number_format($total_pembayaran, 0, '', '.') . ',-';

                if ($rbarang->tarif == '0')
                    return '';
                elseif ($rbarang->tarif < 100)
                    $rbarang->tarif .= ',-';
                else
                    $rbarang->tarif = number_format($rbarang->tarif, 0, '', '.') . ',-';
                ?>
                <tr>
                    <td align="center"><?php echo $no; ?></td>
                    <td align="center"><?php echo $rbarang->no_kwitansi; ?></td>
                    <td align="center"><?php echo $rbarang->nama_pengguna_jasa; ?></td>
                    <td align="center"><?php echo $rbarang->alamat; ?></td>
                    <td align="center"><?php echo $rbarang->no_telp; ?></td>
                    <td align="center"><?php echo $format_tgl; ?></td>
                    <td align="center"><?php echo $rbarang->tarif; ?></td>
                    <td align="center"><?php echo $rbarang->total_permintaan; ?></td>
                    <td align="center"><?php echo $total_pembayaran; ?></td>
                </tr>
                <?php
        }
        if($total == '0')
            return '';
        elseif($total < 100)
            $total.= ',-';
        else
            $total = number_format($total,0,'','.').',-';
        ?>

        <tr>
            <td align="center"colspan="7"><b>Total</b></td>
            <td align="center"><b><?= $ton?></b></td>
            <td align="center"><b><?= $total?></b></td>
        </tr>
    </table>
    </body>
    </html>
<?php
}
else if($this->session->userdata('role') == "operasi" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "laut_operasi" ){
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
    <h3 style="text-align: center"><?= $title?></h3>
    <br><br>
    <table>
        <tr>
            <th align="center">No</th>
            <th align="center">ID VESSEL</th>
            <th align="center">Nama VESSEL</th>
            <th align="center">Voy No</th>
            <th align="center">Tipe Kapal</th>
            <th align="center">Nama Perusahaan</th>
            <th align="center">Tanggal Transaksi</th>
            <th align="center">Tarif</th>
            <th align="center">Total Permintaan (Ton)</th>
            <th align="center">Realisasi Pengisian (Ton)</th>
            <th align="center">Total Pembayaran (Rp.)</th>
        </tr>
        <?php
        $total = 0;
        $ton = 0;
        $no = 0;
        $ton_realiasi =0;
        foreach($laporan as $rbarang) {
            if ($rbarang->flowmeter_awal != NULL && $rbarang->flowmeter_akhir != NULL) {
                $no++;
                $realisasi = $rbarang->flowmeter_akhir - $rbarang->flowmeter_awal;
                if ($rbarang->diskon != NULL || $rbarang->diskon != 0) {
                    $rbarang->tarif -= $rbarang->tarif * $rbarang->diskon/100;
                    $total_pembayaran =  $rbarang->tarif * $realisasi;
                } else {
                    $total_pembayaran = $rbarang->tarif * $realisasi;
                }

                $total += $total_pembayaran;
                $ton += $rbarang->total_permintaan;
                $ton_realiasi += $realisasi;
                $format_tgl = date('d-m-Y', strtotime($rbarang->tgl_transaksi));

                if ($rbarang->pengguna_jasa_id_tarif == 6) {
                    $rbarang->pengguna_jasa_id_tarif = "Peti Kemas";
                } else {
                    $rbarang->pengguna_jasa_id_tarif = "Tongkang";
                }

                if ($total_pembayaran == '0')
                    return '';
                elseif ($total_pembayaran < 100)
                    $total_pembayaran .= ',-';
                else
                    $total_pembayaran = number_format($total_pembayaran, 0, '', '.') . ',-';

                if ($rbarang->tarif == '0')
                    return '';
                elseif ($rbarang->tarif < 100)
                    $rbarang->tarif .= ',-';
                else
                    $rbarang->tarif = number_format($rbarang->tarif, 0, '', '.') . ',-';
                ?>
                <tr>
                    <td align="center"><?= $no ?></td>
                    <td align="center"><?= $rbarang->id_lct ?></td>
                    <td align="center"><?= $rbarang->nama_lct ?></td>
                    <td align="center"><?= $rbarang->voy_no ?></td>
                    <td align="center"><?= $rbarang->pengguna_jasa_id_tarif ?></td>
                    <td align="center"><?= $rbarang->nama_perusahaan ?></td>
                    <td align="center"><?= $format_tgl ?></td>
                    <td align="center"><?= $rbarang->tarif ?></td>
                    <td align="center"><?= $rbarang->total_permintaan ?></td>
                    <td align="center"><?= $realisasi ?></td>
                    <td align="center"><?= $total_pembayaran ?></td>
                </tr>
                <?php
                }
            }
        if($total == '0')
            return '';
        elseif($total < 100)
            $total.= ',-';
        else
            $total = number_format($total,0,'','.').',-';
        ?>

        <tr>
            <td align="center"colspan="8"><b>Total</b></td>
            <td align="center"><b><?= $ton?></b></td>
            <td align="center"><b><?= $ton_realiasi?></b></td>
            <td align="center"><b><?= $total?></b></td>
        </tr>
    </table>
    </body>
    </html>
<?php
}
else if($this->session->userdata('role') == "operasi" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "ruko"){
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
    <h3 style="text-align: center"><?= $title?></h3>
    <br><br>
    <table>
        <tr>
            <th align="center">No</th>
            <th align="center">ID FLow Meter</th>
            <th align="center">Nama Ruko</th>
            <th align="center">Total Penggunaan</th>
            <th align="center">Tarif</th>
            <th align="center">Diskon</th>
            <th align="center">Total Pembayaran (Rp. )</th>
        </tr>
        <?php
        $total = 0;
        $ton = 0;
        $no = 0;
        $ton_realiasi =0;
        foreach($laporan as $rbarang) {
                if ($rbarang->flowmeter_awal != NULL && $rbarang->flowmeter_akhir != NULL) {
                    $no++;
                    $realisasi = $rbarang->flowmeter_akhir - $rbarang->flowmeter_awal;
                    if ($rbarang->diskon != NULL || $rbarang->diskon != 0) {
                        $total_pembayaran = $rbarang->tarif * $rbarang->diskon * $realisasi;
                    } else {
                        $total_pembayaran = $rbarang->tarif * $realisasi;
                    }

                    $total += $total_pembayaran;
                    $ton += $rbarang->total_permintaan;
                    $ton_realiasi += $realisasi;
                    $format_tgl = date('d-m-Y', strtotime($rbarang->tgl_transaksi));

                    if ($rbarang->pengguna_jasa_id_tarif == 6) {
                        $rbarang->pengguna_jasa_id_tarif = "Peti Kemas";
                    } else {
                        $rbarang->pengguna_jasa_id_tarif = "Tongkang";
                    }

                    if ($total_pembayaran == '0')
                        return '';
                    elseif ($total_pembayaran < 100)
                        $total_pembayaran .= ',-';
                    else
                        $total_pembayaran = number_format($total_pembayaran, 0, '', '.') . ',-';

                    if ($rbarang->tarif == '0')
                        return '';
                    elseif ($rbarang->tarif < 100)
                        $rbarang->tarif .= ',-';
                    else
                        $rbarang->tarif = number_format($rbarang->tarif, 0, '', '.') . ',-';
                    ?>
                    <tr>
                        <td align="center"><?= $no ?></td>
                        <td align="center"><?= $rbarang->id_lct ?></td>
                        <td align="center"><?= $rbarang->nama_lct ?></td>
                        <td align="center"><?= $rbarang->voy_no ?></td>
                        <td align="center"><?= $rbarang->pengguna_jasa_id_tarif ?></td>
                        <td align="center"><?= $rbarang->nama_perusahaan ?></td>
                        <td align="center"><?= $format_tgl ?></td>
                        <td align="center"><?= $rbarang->total_permintaan ?></td>
                        <td align="center"><?= $realisasi ?></td>
                        <td align="center"><?= $total_pembayaran ?></td>
                    </tr>
                    <?php
                }
            }
        if($total == '0')
            return '';
        elseif($total < 100)
            $total.= ',-';
        else
            $total = number_format($total,0,'','.').',-';
        ?>

        <tr>
            <td align="center"colspan="7"><b>Total</b></td>
            <td align="center"><b><?= $ton?></b></td>
            <td align="center"><b><?= $ton_realiasi?></b></td>
            <td align="center"><b><?= $total?></b></td>
        </tr>
    </table>
    </body>
    </html>
<?php
}
else if($this->session->userdata('role') == "loket" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "darat"){
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
        }

        table th {
            border: 1px solid #000;
            padding: 3px;
            font-weight: bold;
            text-align: center;
        }

        table td {
            border: 1px solid #000;
            padding: 3px;
            vertical-align: top;
        }
    </style>
</head>
<body>
<h3 style="text-align: center"><?= $title ?></h3>
<br><br>
<table>
    <tr>
        <th align="center">No</th>
        <th align="center">Nama Pengguna Jasa</th>
        <th align="center">Tanggal Transaksi</th>
        <th align="center">Waktu Permintaan Pengantaran</th>
        <th align="center">Waktu Mulai Pengantaran</th>
        <th align="center">Waktu Selesai Pengantaran</th>
        <th align="center">Lama Pengantaran</th>
        <th align="center">Tarif (Rp.)</th>
        <th align="center">Total Permintaan (Ton)</th>
        <th align="center">Total Pembayaran (Rp.)</th>
    </tr>
    <?php
    $no = 0;
    $total = 0;
    $ton = 0;
    foreach ($laporan as $rbarang) {
            $no++;
            $format_jam_awal = "";
            $format_jam_akhir = "";

            if($rbarang->batal_kwitansi == 1){
                $total_pembayaran = '';
            } else if ($rbarang->diskon != NULL || $rbarang->diskon != 0) {
                $rbarang->tarif -= $rbarang->tarif * $rbarang->diskon / 100;
                $total_pembayaran = $rbarang->tarif * $rbarang->total_permintaan;
            } else {
                $total_pembayaran = $rbarang->tarif * $rbarang->total_permintaan;
            }

            $waktu_awal = mktime(date("H", strtotime($rbarang->waktu_mulai_pengantaran)), date("i", strtotime($rbarang->waktu_mulai_pengantaran)), date("s", strtotime($rbarang->waktu_mulai_pengantaran)), date("m", strtotime($rbarang->waktu_mulai_pengantaran)), date("d", strtotime($rbarang->waktu_mulai_pengantaran)), date("y", strtotime($rbarang->waktu_mulai_pengantaran)));
            $waktu_akhir = mktime(date("H", strtotime($rbarang->waktu_selesai_pengantaran)), date("i", strtotime($rbarang->waktu_selesai_pengantaran)), date("s", strtotime($rbarang->waktu_selesai_pengantaran)), date("m", strtotime($rbarang->waktu_selesai_pengantaran)), date("d", strtotime($rbarang->waktu_selesai_pengantaran)), date("y", strtotime($rbarang->waktu_selesai_pengantaran)));
            $lama_pengantaran = round((($waktu_akhir - $waktu_awal) % 86400) / 3600, 2);

            if ($lama_pengantaran > 0) {
                $lama_pengantaran .= " Jam";
            } else{
                $lama_pengantaran = "";
            }

            if($rbarang->batal_kwitansi == 0){
                $total += $total_pembayaran;
                $ton += $rbarang->total_permintaan;
            }

            $format_tgl = date('d-m-Y H:i:s', strtotime($rbarang->tgl_transaksi));
            $format_tgl_pengantaran = date('d-m-Y H:i:s', strtotime($rbarang->tgl_perm_pengantaran));

            if($rbarang->waktu_mulai_pengantaran == NULL){
                $format_jam_awal = "";
            } else {
                $format_jam_awal = date("d-m-y H:i:s", strtotime($rbarang->waktu_mulai_pengantaran));
            }

            if($rbarang->waktu_selesai_pengantaran == NULL){
                $format_jam_akhir = "";
            } else{
                $format_jam_akhir = date("d-m-y H:i:s", strtotime($rbarang->waktu_selesai_pengantaran));
            }

            if ($total_pembayaran == '0')
                return '';
            elseif ($total_pembayaran < 100)
                $total_pembayaran .= ',-';
            else
                $total_pembayaran = number_format($total_pembayaran, 0, '', '.') . ',-';

            if ($rbarang->tarif == '0')
                return '';
            elseif ($rbarang->tarif < 100)
                $rbarang->tarif .= ',-';
            else
                $rbarang->tarif = number_format($rbarang->tarif, 0, '', '.') . ',-';
        ?>
            <tr>
                <td align="center"><?php echo $no; ?></td>
                <td align="center"><?php echo $rbarang->nama_pengguna_jasa; ?></td>
                <td align="center"><?php echo $format_tgl; ?></td>
                <td align="center"><?php echo $format_tgl_pengantaran; ?></td>
                <td align="center"><?php echo $format_jam_awal; ?></td>
                <td align="center"><?php echo $format_jam_akhir; ?></td>
                <td align="center"><?php echo $lama_pengantaran; ?></td>
                <td align="center"><?php echo $rbarang->tarif; ?></td>
                <td align="center"><?php echo $rbarang->total_permintaan; ?></td>
                <td align="center"><?php echo $total_pembayaran; ?></td>
            </tr>
            <?php
        }

        if($total == '0')
            return '';
        elseif($total < 100)
            $total.= ',-';
        else
            $total = number_format($total,0,'','.').',-';
        ?>

        <tr>
            <td align="center"colspan="8"><b>Total</b></td>
            <td align="center"><b><?= $ton?></b></td>
            <td align="center"><b><?= $total?></b></td>
        </tr>
    </table>
    </body>
    </html>
    <?php
}
else if($this->session->userdata('role') == "keuangan" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "darat"){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?= $title ?></title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                margin: 0 auto;
            }

            table th {
                border: 1px solid #000;
                padding: 3px;
                font-weight: bold;
                text-align: center;
            }

            table td {
                border: 1px solid #000;
                padding: 3px;
                vertical-align: top;
            }
        </style>
    </head>
    <body>
    <h3 style="text-align: center"><?= $title ?></h3>
    <br><br>
    <table>
        <tr>
            <th align="center">No</th>
            <th align="center">No Kwitansi</th>
            <th align="center">Nama Pengguna Jasa</th>
            <th align="center">Alamat</th>
            <th align="center">No. Telepon</th>
            <th align="center">Tanggal Transaksi</th>
            <th align="center">Tarif (Rp.)</th>
            <th align="center">Total Permintaan (Ton)</th>
            <th align="center">Total Pembayaran (Rp.)</th>
        </tr>
        <?php
        $no = 0;
        $total = 0;
        $ton = 0;
        foreach ($laporan as $rbarang) {
            if ($rbarang->status_pembayaran == 1 && $rbarang->status_invoice == 0) {
                $no++;

                if ($rbarang->diskon != NULL ||$rbarang->diskon != 0) {
                    $rbarang->tarif -= $rbarang->tarif * $rbarang->diskon / 100;
                    $total_pembayaran = $rbarang->tarif * $rbarang->total_permintaan;
                } else {
                    $total_pembayaran = $rbarang->tarif * $rbarang->total_permintaan;
                }

                $total += $total_pembayaran;
                $ton += $rbarang->total_permintaan;
                $format_tgl = date('d-m-Y H:i:s', strtotime($rbarang->tgl_transaksi));

                if ($total_pembayaran == '0')
                    return '';
                elseif ($total_pembayaran < 100)
                    $total_pembayaran .= ',-';
                else
                    $total_pembayaran = number_format($total_pembayaran, 0, '', '.') . ',-';

                if ($rbarang->tarif == '0')
                    return '';
                elseif ($rbarang->tarif < 100)
                    $rbarang->tarif .= ',-';
                else
                    $rbarang->tarif = number_format($rbarang->tarif, 0, '', '.') . ',-';
                ?>
                <tr>
                    <td align="center"><?php echo $no; ?></td>
                    <td align="center"><?php echo $rbarang->no_kwitansi; ?></td>
                    <td align="center"><?php echo $rbarang->nama_pengguna_jasa; ?></td>
                    <td align="center"><?php echo $rbarang->alamat; ?></td>
                    <td align="center"><?php echo $rbarang->no_telp; ?></td>
                    <td align="center"><?php echo $format_tgl; ?></td>
                    <td align="center"><?php echo $rbarang->tarif; ?></td>
                    <td align="center"><?php echo $rbarang->total_permintaan; ?></td>
                    <td align="center"><?php echo $total_pembayaran; ?></td>
                </tr>
                <?php
            }
        }
        if($total == '0')
            return '';
        elseif($total < 100)
            $total.= ',-';
        else
            $total = number_format($total,0,'','.').',-';
        ?>

        <tr>
            <td align="center"colspan="7"><b>Total</b></td>
            <td align="center"><b><?= $ton?></b></td>
            <td align="center"><b><?= $total?></b></td>
        </tr>
    </table>
    </body>
    </html>
    <?php
}
else if($this->session->userdata('role') == "keuangan" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "laut" ){
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
    <h3 style="text-align: center"><?= $title?></h3>
    <br><br>
    <table>
        <tr>
            <th align="center">No</th>
            <th align="center">No Nota</th>
            <th align="center">No Faktur</th>
            <th align="center">ID VESSEL</th>
            <th align="center">Nama VESSEL</th>
            <th align="center">Voy No</th>
            <th align="center">Tipe Kapal</th>
            <th align="center">Nama Perusahaan</th>
            <th align="center">Tanggal Transaksi</th>
            <th align="center">Tarif</th>
            <th align="center">Total Permintaan (Ton)</th>
            <th align="center">Realisasi Pengisian (Ton)</th>
            <th align="center">Total Pembayaran (Rp.)</th>
        </tr>
        <?php
        $total = 0;
        $ton = 0;
        $no = 0;
        $ton_realiasi =0;
        foreach($laporan as $rbarang) {
            if ($rbarang->realisasi_transaksi_laut_id_realisasi != NULL) {
                $no++;
                $realisasi = $rbarang->flowmeter_akhir - $rbarang->flowmeter_awal;
                if ($rbarang->diskon != NULL || $rbarang->diskon != 0) {
                    $rbarang->tarif -= $rbarang->tarif * $rbarang->diskon/100;
                    $total_pembayaran =  $rbarang->tarif * $realisasi;
                } else {
                    $total_pembayaran = $rbarang->tarif * $realisasi;
                }

                $total += $total_pembayaran;
                $ton += $rbarang->total_permintaan;
                $ton_realiasi += $realisasi;
                $format_tgl = date('d-m-Y', strtotime($rbarang->tgl_transaksi));

                if ($rbarang->pengguna_jasa_id_tarif == 6) {
                    $rbarang->pengguna_jasa_id_tarif = "Peti Kemas";
                } else {
                    $rbarang->pengguna_jasa_id_tarif = "Tongkang";
                }

                if ($total_pembayaran == '0')
                    return '';
                elseif ($total_pembayaran < 100)
                    $total_pembayaran .= ',-';
                else
                    $total_pembayaran = number_format($total_pembayaran, 0, '', '.') . ',-';

                if ($rbarang->tarif == '0')
                    return '';
                elseif ($rbarang->tarif < 100)
                    $rbarang->tarif .= ',-';
                else
                    $rbarang->tarif = number_format($rbarang->tarif, 0, '', '.') . ',-';
                ?>
                <tr>
                    <td align="center"><?= $no ?></td>
                    <td align="center"><?= $rbarang->no_nota ?></td>
                    <td align="center"><?= $rbarang->no_faktur ?></td>
                    <td align="center"><?= $rbarang->id_lct ?></td>
                    <td align="center"><?= $rbarang->nama_lct ?></td>
                    <td align="center"><?= $rbarang->voy_no ?></td>
                    <td align="center"><?= $rbarang->pengguna_jasa_id_tarif ?></td>
                    <td align="center"><?= $rbarang->nama_perusahaan ?></td>
                    <td align="center"><?= $format_tgl ?></td>
                    <td align="center"><?= $rbarang->tarif ?></td>
                    <td align="center"><?= $rbarang->total_permintaan ?></td>
                    <td align="center"><?= $realisasi ?></td>
                    <td align="center"><?= $total_pembayaran ?></td>
                </tr>
                <?php
            }
        }
        if($total == '0')
            return '';
        elseif($total < 100)
            $total.= ',-';
        else
            $total = number_format($total,0,'','.').',-';
        ?>

        <tr>
            <td align="center"colspan="10"><b>Total</b></td>
            <td align="center"><b><?= $ton?></b></td>
            <td align="center"><b><?= $ton_realiasi?></b></td>
            <td align="center"><b><?= $total?></b></td>
        </tr>
    </table>
    </body>
    </html>
    <?php
}
else if($this->session->userdata('role') == "wtp" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "darat"){
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
    <h3 style="text-align: center"><?= $title?></h3>
    <br><br>
    <table>
        <tr>
            <th align="center">No</th>
            <th align="center">Nama Pengguna Jasa</th>
            <th align="center">Tanggal Transaksi</th>
            <th align="center">Waktu Permintaan Pengantaran</th>
            <th align="center">Waktu Mulai Pengantaran</th>
            <th align="center">Waktu Selesai Pengantaran</th>
            <th align="center">Lama Pengantaran</th>
            <th align="center">Tarif (Rp.)</th>
            <th align="center">Total Permintaan (Ton)</th>
            <th align="center">Total Pembayaran (Rp.)</th>
        </tr>
        <?php
        $no=0;
        $total=0;
        $ton=0;
        foreach($laporan as $rbarang) {
            $no++;
            $format_jam_awal = "";
            $format_jam_akhir = "";

            if($rbarang->batal_kwitansi == 1){
                $total_pembayaran = '';
            } else if ($rbarang->diskon != NULL || $rbarang->diskon != 0) {
                $rbarang->tarif -= $rbarang->tarif * $rbarang->diskon / 100;
                $total_pembayaran = $rbarang->tarif * $rbarang->total_permintaan;
            } else {
                $total_pembayaran = $rbarang->tarif * $rbarang->total_permintaan;
            }

            $waktu_awal = mktime(date("H", strtotime($rbarang->waktu_mulai_pengantaran)), date("i", strtotime($rbarang->waktu_mulai_pengantaran)), date("s", strtotime($rbarang->waktu_mulai_pengantaran)), date("m", strtotime($rbarang->waktu_mulai_pengantaran)), date("d", strtotime($rbarang->waktu_mulai_pengantaran)), date("y", strtotime($rbarang->waktu_mulai_pengantaran)));
            $waktu_akhir = mktime(date("H", strtotime($rbarang->waktu_selesai_pengantaran)), date("i", strtotime($rbarang->waktu_selesai_pengantaran)), date("s", strtotime($rbarang->waktu_selesai_pengantaran)), date("m", strtotime($rbarang->waktu_selesai_pengantaran)), date("d", strtotime($rbarang->waktu_selesai_pengantaran)), date("y", strtotime($rbarang->waktu_selesai_pengantaran)));
            $lama_pengantaran = round((($waktu_akhir - $waktu_awal) % 86400) / 3600, 2);

            if ($lama_pengantaran > 0) {
                $lama_pengantaran .= " Jam";
            } else{
                $lama_pengantaran = "";
            }

            if($rbarang->batal_kwitansi == 0){
                $total += $total_pembayaran;
                $ton += $rbarang->total_permintaan;
            }

            $format_tgl = date('d-m-Y H:i:s', strtotime($rbarang->tgl_transaksi));
            $format_tgl_pengantaran = date('d-m-Y H:i:s', strtotime($rbarang->tgl_perm_pengantaran));

            if($rbarang->waktu_mulai_pengantaran == NULL){
                $format_jam_awal = "";
            } else {
                $format_jam_awal = date("d-m-y H:i:s", strtotime($rbarang->waktu_mulai_pengantaran));
            }

            if($rbarang->waktu_selesai_pengantaran == NULL){
                $format_jam_akhir = "";
            } else{
                $format_jam_akhir = date("d-m-y H:i:s", strtotime($rbarang->waktu_selesai_pengantaran));
            }

            if ($total_pembayaran == '0')
                return '';
            elseif ($total_pembayaran < 100)
                $total_pembayaran .= ',-';
            else
                $total_pembayaran = number_format($total_pembayaran, 0, '', '.') . ',-';

            if ($rbarang->tarif == '0')
                return '';
            elseif ($rbarang->tarif < 100)
                $rbarang->tarif .= ',-';
            else
                $rbarang->tarif = number_format($rbarang->tarif, 0, '', '.') . ',-';
                ?>
                <tr>
                    <td align="center"><?php echo $no; ?></td>
                    <td align="center"><?php echo $rbarang->nama_pengguna_jasa; ?></td>
                    <td align="center"><?php echo $format_tgl; ?></td>
                    <td align="center"><?php echo $format_tgl_pengantaran; ?></td>
                    <td align="center"><?php echo $format_jam_awal; ?></td>
                    <td align="center"><?php echo $format_jam_akhir; ?></td>
                    <td align="center"><?php echo $lama_pengantaran; ?></td>
                    <td align="center"><?php echo $rbarang->tarif; ?></td>
                    <td align="center"><?php echo $rbarang->total_permintaan; ?></td>
                    <td align="center"><?php echo $total_pembayaran; ?></td>
                </tr>
                <?php
        }

        if($total == '0')
            return '';
        elseif($total < 100)
            $total.= ',-';
        else
            $total = number_format($total,0,'','.').',-';
        ?>

        <tr>
            <td align="center"colspan="8"><b>Total</b></td>
            <td align="center"><b><?= $ton?></b></td>
            <td align="center"><b><?= $total?></b></td>
        </tr>
    </table>
    </body>
    </html>
    <?php
}
else if($this->session->userdata('role') == "wtp" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "laut_operasi" ){
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
    <h3 style="text-align: center"><?= $title?></h3>
    <br><br>
    <table>
        <tr>
            <th align="center">No</th>
            <th align="center">ID LCT</th>
            <th align="center">Nama Kapal</th>
            <th align="center">Voy No</th>
            <th align="center">Tipe Kapal</th>
            <th align="center">Nama Perusahaan</th>
            <th align="center">Tanggal Transaksi</th>
            <th align="center">Total Permintaan (Ton)</th>
            <th align="center">Realisasi Pengisian (Ton)</th>
            <th align="center">Total Pembayaran (Rp.)</th>
        </tr>
        <?php
        $total = 0;
        $ton = 0;
        $no = 0;
        $ton_realiasi =0;
        if($laporan != NULL){
            foreach($laporan as $rbarang) {
                if ($rbarang->flowmeter_awal != NULL && $rbarang->flowmeter_akhir != NULL) {
                    $no++;
                    $realisasi = $rbarang->flowmeter_akhir - $rbarang->flowmeter_awal;
                    if ($rbarang->diskon != NULL || $rbarang->diskon != 0) {
                        $rbarang->tarif -= $rbarang->tarif * $rbarang->diskon/100;
                        $total_pembayaran =  $rbarang->tarif * $realisasi;
                    } else {
                        $total_pembayaran = $rbarang->tarif * $realisasi;
                    }

                    $total += $total_pembayaran;
                    $ton += $rbarang->total_permintaan;
                    $ton_realiasi += $realisasi;
                    $format_tgl = date('d-m-Y', strtotime($rbarang->tgl_transaksi));

                    if ($rbarang->pengguna_jasa_id_tarif == 6) {
                        $rbarang->pengguna_jasa_id_tarif = "Peti Kemas";
                    } else {
                        $rbarang->pengguna_jasa_id_tarif = "Tongkang";
                    }

                    if ($total_pembayaran == '0')
                        return '';
                    elseif ($total_pembayaran < 100)
                        $total_pembayaran .= ',-';
                    else
                        $total_pembayaran = number_format($total_pembayaran, 0, '', '.') . ',-';

                    if ($rbarang->tarif == '0')
                        return '';
                    elseif ($rbarang->tarif < 100)
                        $rbarang->tarif .= ',-';
                    else
                        $rbarang->tarif = number_format($rbarang->tarif, 0, '', '.') . ',-';
                    ?>
                    <tr>
                        <td align="center"><?= $no ?></td>
                        <td align="center"><?= $rbarang->id_lct ?></td>
                        <td align="center"><?= $rbarang->nama_lct ?></td>
                        <td align="center"><?= $rbarang->voy_no ?></td>
                        <td align="center"><?= $rbarang->pengguna_jasa_id_tarif ?></td>
                        <td align="center"><?= $rbarang->nama_perusahaan ?></td>
                        <td align="center"><?= $format_tgl ?></td>
                        <td align="center"><?= $rbarang->total_permintaan ?></td>
                        <td align="center"><?= $realisasi ?></td>
                        <td align="center"><?= $total_pembayaran ?></td>
                    </tr>
                    <?php
                }
            }

        }
        if($total == '0')
            return '';
        elseif($total < 100)
            $total.= ',-';
        else
            $total = number_format($total,0,'','.').',-';
        ?>

        <tr>
            <td align="center"colspan="7"><b>Total</b></td>
            <td align="center"><b><?= $ton?></b></td>
            <td align="center"><b><?= $ton_realiasi?></b></td>
            <td align="center"><b><?= $total?></b></td>
        </tr>
    </table>
    </body>
    </html>
    <?php
}
else if($this->session->userdata('role') == "wtp" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "ruko"){
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
    <h3 style="text-align: center"><?= $title?></h3>
    <br><br>
    <table>
        <tr>
            <th align="center">No</th>
            <th align="center">ID FLow Meter</th>
            <th align="center">Nama Tenant</th>
            <th align="center">Tarif</th>
            <th align="center">Diskon</th>
            <th align="center">Pemakaian Awal</th>
            <th align="center">Pemakaian Akhir</th>
            <th align="center">Total Penggunaan</th>
            <th align="center">Total Pembayaran (Rp. )</th>
        </tr>
        <?php
        $total_pembayaran =0;
        $ton_total = 0;
        $ton = 0;
        $no = 1;

        foreach($laporan as $row) {
            $data_tagihan = $this->data->getTagihan($tgl_awal, $tgl_akhir, $row->id_flow);

            $ttl_akhir = 0;
            $ttl_awal = 0;

            $i = 1;

            foreach ($data_tagihan as $data) {
                if ($data->flowmeter_tenant == $row->id_tenant) {
                    if ($i == 1 && $data->flow_hari_ini != NULL) {
                        $ttl_awal = $data->flow_hari_ini;
                    } else {
                        if ($ttl_awal == 0) {
                            $ttl_awal = $data->flow_hari_ini;
                        }
                    }
                    if ($i == count($data_tagihan) && $data->flow_hari_ini != NULL) {
                        $ttl_akhir = $data->flow_hari_ini;
                    }
                    $i++;
                } else {
                    $i = 1;
                }
            }

            $ton = $ttl_akhir - $ttl_awal;
            $ton_total += $ton;

            if ($data->id_master_lumpsum == 0) {
                if ($row->diskon != NULL) {
                    $pembayaran = ($row->tarif - ($row->tarif * $row->diskon / 100)) * $ton;
                } else {
                    $pembayaran = $row->tarif * $ton;
                }
            } else {
                $date_now = strtotime(date('Y-m-d', time()));
                $date_kadaluarsa = strtotime($row->waktu_kadaluarsa);
                if ($date_now <= $date_kadaluarsa)
                    $pembayaran = $row->nominal;
                else
                    $pembayaran = 0;
            }

            $total_pembayaran += $pembayaran;

            if ($row->tarif == '0')
                return '';
            else if ($row->tarif < 100)
                $row->tarif .= ',-';
            else
                $row->tarif = number_format($row->tarif, 0, '', '.') . ',-';

            if ($pembayaran == '0')
                return '';
            else if ($pembayaran < 100)
                $pembayaran .= ',-';
            else
                $pembayaran = number_format($pembayaran, 0, '', '.') . ',-';

            ?>
            <tr>
                <td align="center"><?=$no?></td>
                <td align="center"><?= $row->id_flowmeter ?></td>
                <td align="center"><?= $row->nama_tenant ?></td>
                <td align="center"><?= $row->tarif ?></td>
                <td align="center"><?= $row->diskon ?></td>
                <td align="center"><?= $ttl_awal ?></td>
                <td align="center"><?= $ttl_akhir ?></td>
                <td align="center"><?= $ton ?></td>
                <td align="center"><?= $pembayaran ?></td>
            </tr>
            <?php
            $no++;
        }

        if($total_pembayaran == '0')
            return '';
        else if($total_pembayaran < 100)
            $total_pembayaran.= ',-';
        else
            $total_pembayaran = number_format($total_pembayaran,0,'','.').',-';
        ?>

        <tr>
            <td align="center"colspan="7"><b>Total</b></td>
            <td align="center"><b><?= $ton_total?></b></td>
            <td align="center"><b><?= $total_pembayaran?></b></td>
        </tr>
    </table>
    </body>
    </html>
    <?php
}
else if($this->session->userdata('role') == "perencanaan" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "laut_operasi" ){
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
    <h3 style="text-align: center"><?= $title?></h3>
    <br><br>
    <table>
        <tr>
            <th align="center">No</th>
            <th align="center">ID VESSEL</th>
            <th align="center">Nama VESSEL</th>
            <th align="center">Voy No</th>
            <th align="center">Tipe Kapal</th>
            <th align="center">Nama Perusahaan</th>
            <th align="center">Tanggal Transaksi</th>
            <th align="center">Total Permintaan (Ton)</th>
            <th align="center">Realisasi Pengisian (Ton)</th>
            <th align="center">Total Pembayaran (Rp.)</th>
        </tr>
        <?php
        $total = 0;
        $ton = 0;
        $no = 0;
        $ton_realiasi =0;
        if($laporan != NULL){
            foreach($laporan as $rbarang) {
                if ($rbarang->flowmeter_awal != NULL && $rbarang->flowmeter_akhir != NULL) {
                    $no++;
                    $realisasi = $rbarang->flowmeter_akhir - $rbarang->flowmeter_awal;
                    if ($rbarang->diskon != NULL || $rbarang->diskon != 0) {
                        $rbarang->tarif -= $rbarang->tarif * $rbarang->diskon/100;
                        $total_pembayaran =  $rbarang->tarif * $realisasi;
                    } else {
                        $total_pembayaran = $rbarang->tarif * $realisasi;
                    }

                    $total += $total_pembayaran;
                    $ton += $rbarang->total_permintaan;
                    $ton_realiasi += $realisasi;
                    $format_tgl = date('d-m-Y', strtotime($rbarang->tgl_transaksi));

                    if ($rbarang->pengguna_jasa_id_tarif == 6) {
                        $rbarang->pengguna_jasa_id_tarif = "Peti Kemas";
                    } else {
                        $rbarang->pengguna_jasa_id_tarif = "Tongkang";
                    }

                    if ($total_pembayaran == '0')
                        return '';
                    elseif ($total_pembayaran < 100)
                        $total_pembayaran .= ',-';
                    else
                        $total_pembayaran = number_format($total_pembayaran, 0, '', '.') . ',-';

                    if ($rbarang->tarif == '0')
                        return '';
                    elseif ($rbarang->tarif < 100)
                        $rbarang->tarif .= ',-';
                    else
                        $rbarang->tarif = number_format($rbarang->tarif, 0, '', '.') . ',-';
                    ?>
                    <tr>
                        <td align="center"><?= $no ?></td>
                        <td align="center"><?= $rbarang->id_lct ?></td>
                        <td align="center"><?= $rbarang->nama_lct ?></td>
                        <td align="center"><?= $rbarang->voy_no ?></td>
                        <td align="center"><?= $rbarang->pengguna_jasa_id_tarif ?></td>
                        <td align="center"><?= $rbarang->nama_perusahaan ?></td>
                        <td align="center"><?= $format_tgl ?></td>
                        <td align="center"><?= $rbarang->total_permintaan ?></td>
                        <td align="center"><?= $realisasi ?></td>
                        <td align="center"><?= $total_pembayaran ?></td>
                    </tr>
                    <?php
                }
            }

        }
        if($total == '0')
            return '';
        elseif($total < 100)
            $total.= ',-';
        else
            $total = number_format($total,0,'','.').',-';
        ?>

        <tr>
            <td align="center"colspan="7"><b>Total</b></td>
            <td align="center"><b><?= $ton?></b></td>
            <td align="center"><b><?= $ton_realiasi?></b></td>
            <td align="center"><b><?= $total?></b></td>
        </tr>
    </table>
    </body>
    </html>
    <?php
}
else{
    redirect('main');
}
?>
