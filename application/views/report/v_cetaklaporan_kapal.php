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
    <h3 style="text-align: center"><?php echo $title?></h3>
    <br><br>
    <table width="100%" style="page-break-after:auto;">
        <thead>
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
        </thead>
        <tbody>
        <?php
        $total = 0;
        $ton = 0;
        $no = 0;
        $ton_realiasi =0;
        if($laporan != NULL){
            foreach($laporan as $row) {
                if ($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL) {
                    $no++;


                    if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                        $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;

                        if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                            $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                            if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                            } else{
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                            }
                        }
                        else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                            $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        }
                        else {
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        }
                    }
                    else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                        $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                        if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                            $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        } else {
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        }
                    }
                    else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                        $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                    }
                    else{
                        $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                    }

                    if ($row->diskon != NULL || $row->diskon != 0) {
                        $row->tarif -= $row->tarif * $row->diskon/100;
                        $total_pembayaran =  $row->tarif * $realisasi;
                    } else {
                        $total_pembayaran = $row->tarif * $realisasi;
                    }

                    if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                        $total_pembayaran += 3000;
                    } else if($total_pembayaran > 1000000){
                        $total_pembayaran += 6000;
                    } else{
                        $total_pembayaran += 0;
                    }

                    $total += $total_pembayaran;
                    $ton += $row->total_permintaan;
                    $ton_realiasi += $realisasi;
                    $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi));

                    if ($row->pengguna_jasa_id_tarif == 6) {
                        $row->pengguna_jasa_id_tarif = "Peti Kemas";
                    } else {
                        $row->pengguna_jasa_id_tarif = "Tongkang";
                    }

                    if ($total_pembayaran == '0')
                        return '';
                    elseif ($total_pembayaran < 100)
                        $total_pembayaran .= ',-';
                    else
                        $total_pembayaran = number_format($total_pembayaran, 0, '', '.') . ',-';

                    if ($row->tarif == '0')
                        return '';
                    elseif ($row->tarif < 100)
                        $row->tarif .= ',-';
                    else
                        $row->tarif = number_format($row->tarif, 0, '', '.') . ',-';
                    ?>
                    <tr>
                        <td align="center"><?php echo $no ?></td>
                        <td align="center"><?php echo $row->id_vessel ?></td>
                        <td align="center"><?php echo $row->nama_vessel ?></td>
                        <td align="center"><?php echo $row->voy_no ?></td>
                        <td align="center"><?php echo $row->pengguna_jasa_id_tarif ?></td>
                        <td align="center"><?php echo $row->nama_agent ?></td>
                        <td align="center"><?php echo $format_tgl ?></td>
                        <td align="center"><?php echo $row->total_permintaan ?></td>
                        <td align="center"><?php echo $realisasi ?></td>
                        <td align="center"><?php echo $total_pembayaran ?></td>
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
            <td align="center"><b><?php echo $ton?></b></td>
            <td align="center"><b><?php echo $ton_realiasi?></b></td>
            <td align="center"><b><?php echo $total?></b></td>
        </tr>
        </tbody>
    </table>
    </body>
    </html>