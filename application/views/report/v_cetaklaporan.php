<?php
if($this->session->userdata('role') == "operasi" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "darat"){
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
                page-break-after:auto;
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
    <table>
        <thead>
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
        </thead>
        <tbody>
        <?php
        $no=0;
        $total=0;
        $ton=0;
        foreach($laporan as $row) {
                $no++;
                $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi));

                if($row->batal_kwitansi == 1){
                    $total_pembayaran = '';
                } else if ($row->diskon != NULL || $row->diskon != 0) {
                    $row->tarif -= $row->tarif * $row->diskon / 100;
                    $total_pembayaran = $row->tarif * $row->total_permintaan;
                } else {
                    $total_pembayaran = $row->tarif * $row->total_permintaan;
                }

                if($row->batal_kwitansi == 0){
                    $total += $total_pembayaran;
                    $ton += $row->total_permintaan;
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
                    <td align="center"><?php echo $no; ?></td>
                    <td align="center"><?php echo $row->no_kwitansi; ?></td>
                    <td align="center"><?php echo $row->nama_pengguna_jasa; ?></td>
                    <td align="center"><?php echo $row->alamat; ?></td>
                    <td align="center"><?php echo $row->no_telp; ?></td>
                    <td align="center"><?php echo $format_tgl; ?></td>
                    <td align="center"><?php echo $row->tarif; ?></td>
                    <td align="center"><?php echo $row->total_permintaan; ?></td>
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
            <td align="center"><b><?php echo $ton?></b></td>
            <td align="center"><b><?php echo $total?></b></td>
        </tr>
        </tbody>
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
        <title><?php echo$title?></title>
        <style>
            table{
                border-collapse: collapse;
                width: 100%;
                margin: 0 auto;
                page-break-after:auto;
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
    <table>
        <thead>
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
        </thead>
        <tbody>
        <?php
        $total = 0;
        $ton = 0;
        $no = 0;
        $ton_realiasi =0;
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
                    <td align="center"><?php echo $row->tarif ?></td>
                    <td align="center"><?php echo $row->total_permintaan ?></td>
                    <td align="center"><?php echo $realisasi ?></td>
                    <td align="center"><?php echo $total_pembayaran ?></td>
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
            <td align="center"><b><?php echo $ton?></b></td>
            <td align="center"><b><?php echo $ton_realiasi?></b></td>
            <td align="center"><b><?php echo $total?></b></td>
        </tr>
        </tbody>
    </table>
    </body>
    </html>
<?php
}
else if(($this->session->userdata('role') == "operasi" || $this->session->userdata('role') == "admin")&& $this->session->userdata('session') != NULL && $this->input->get('tipe') == "ruko"){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo $title ?></title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                margin: 0 auto;
                page-break-after:auto;
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
    <h3 style="text-align: center"><?php echo $title ?></h3>
    <br><br>
    <table>
        <thead>
        <tr>
            <th align="center">No</th>
            <th align="center">ID FLow Meter</th>
            <th align="center">Nama Tenant</th>
            <th align="center">No Perjanjian</th>
            <th align="center">Tarif</th>
            <th align="center">Diskon</th>
            <th align="center">Flow Meter Awal</th>
            <th align="center">Flow Meter Akhir</th>
            <th align="center">Total Penggunaan</th>
            <th align="center">Total Pembayaran (Rp. )</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        $no = 0;
        $ton_total = 0;

        if($laporan != NULL) {
            foreach ($laporan as $row) {
                $no++;
                $data_tagihan = $this->data->getTagihan($tgl_awal, $tgl_akhir, $row->id_flow);
                $pembayaran = 0;
                $ttl_akhir = 0;
                $ttl_awal = 0;
                $ton = 0;
                $no_perjanjian = '';
                $diskon = '';

                $i = 1;

                if ($data_tagihan != NULL) {
                    foreach ($data_tagihan as $data) {
                        if ($data->id_ref_flowmeter == $row->id_flow) {
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

                    $ton_koma = $ttl_akhir - $ttl_awal;
                    $ton = number_format($ton_koma, 2);
                    $ton_total += $ton;
                    $diskon = $row->diskon;
                    $tarif = $row->tarif;
                } else {
                    $ton = 0;
                    $no_perjanjian = $row->no_perjanjian;
                    $diskon = '';
                    $tarif = $row->nominal;
                }
                if ($row->id_ref_tenant == NULL) {
                    if ($row->diskon != NULL) {
                        $pembayaran = ($row->tarif - ($row->tarif * $row->diskon / 100)) * $ton;
                    } else {
                        $pembayaran = $row->tarif * $ton;
                    }
                } else {
                    $date_now = strtotime(date('Y-m-d', time()));
                    $date_kadaluarsa = strtotime($row->waktu_kadaluarsa);

                    if ($date_now < $date_kadaluarsa || $date_now == $date_kadaluarsa)
                        $pembayaran = $row->nominal;
                    else
                        $pembayaran = 0;
                }

                $total += $pembayaran;

                if ($pembayaran == '0')
                    return '';
                else if ($pembayaran < 100)
                    $pembayaran .= ',-';
                else
                    $pembayaran = number_format($pembayaran, 0, '', '.') . ',-';

                if ($tarif == '0')
                    return '';
                else if ($tarif < 100)
                    $tarif .= ',-';
                else
                    $tarif = number_format($tarif, 0, '', '.') . ',-';
                ?>
                <tr>
                    <td align="center"><?php echo $no ?></td>
                    <td align="center"><?php echo $row->id_flowmeter ?></td>
                    <td align="center"><?php echo $row->nama_tenant ?></td>
                    <td align="center"><?php echo $no_perjanjian ?></td>
                    <td align="center"><?php echo $tarif ?></td>
                    <td align="center"><?php echo $diskon ?></td>
                    <td align="center"><?php echo $ttl_awal ?></td>
                    <td align="center"><?php echo $ttl_akhir ?></td>
                    <td align="center"><?php echo $ton ?></td>
                    <td align="center"><?php echo $pembayaran ?></td>
                </tr>
                <?php

            }
        }

        if ($total == '0')
            return '';
        else if ($total < 100)
            $total .= ',-';
        else
            $total = number_format($total, 0, '', '.') . ',-';

        ?>
        <tr>
            <td align="center" colspan="8"><b>Total</b></td>
            <td align="center"><b><?php echo number_format($ton_total,2)?></b></td>
            <td align="center"><b><?php echo $total?></b></td>
        </tr>
        </tbody>
    </table>
    </body>
    </html>
<?php
}
else if($this->session->userdata('role') == "loket" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "darat"){
?>

    <?php
}
else if($this->session->userdata('role') == "keuangan" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "darat"){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo $title ?></title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                margin: 0 auto;
                page-break-after:auto;
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
    <h3 style="text-align: center"><?php echo $title ?></h3>
    <br><br>
    <table>
        <thead>
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
        </thead>
        <tbody>
        <?php
        $no = 0;
        $total = 0;
        $ton = 0;
        foreach ($laporan as $row) {
            if ($row->status_pembayaran == 1 && $row->status_invoice == 0) {
                $no++;

                if ($row->diskon != NULL ||$row->diskon != 0) {
                    $row->tarif -= $row->tarif * $row->diskon / 100;
                    $total_pembayaran = $row->tarif * $row->total_permintaan;
                } else {
                    $total_pembayaran = $row->tarif * $row->total_permintaan;
                }

                $total += $total_pembayaran;
                $ton += $row->total_permintaan;
                $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi));

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
                    <td align="center"><?php echo $no; ?></td>
                    <td align="center"><?php echo $row->no_kwitansi; ?></td>
                    <td align="center"><?php echo $row->nama_pengguna_jasa; ?></td>
                    <td align="center"><?php echo $row->alamat; ?></td>
                    <td align="center"><?php echo $row->no_telp; ?></td>
                    <td align="center"><?php echo $format_tgl; ?></td>
                    <td align="center"><?php echo $row->tarif; ?></td>
                    <td align="center"><?php echo $row->total_permintaan; ?></td>
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
            <td align="center"><b><?php echo $ton?></b></td>
            <td align="center"><b><?php echo $total?></b></td>
        </tr>
        </tbody>
    </table>
    </body>
    </html>
    <?php
}
else if(($this->session->userdata('role') == "keuangan" || $this->session->userdata('role') == "admin") && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "laut" ){
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
                page-break-after:auto;
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
    <table>
        <thead>
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
        </thead>
        <tbody>
        <?php
        $total = 0;
        $ton = 0;
        $no = 0;
        $ton_realiasi =0;
        foreach($laporan as $row) {
            if ($row->status_invoice != 1) {
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
                    <td align="center"><?php echo $row->no_nota ?></td>
                    <td align="center"><?php echo $row->no_faktur ?></td>
                    <td align="center"><?php echo $row->id_vessel ?></td>
                    <td align="center"><?php echo $row->nama_vessel ?></td>
                    <td align="center"><?php echo $row->voy_no ?></td>
                    <td align="center"><?php echo $row->pengguna_jasa_id_tarif ?></td>
                    <td align="center"><?php echo $row->nama_agent ?></td>
                    <td align="center"><?php echo $format_tgl ?></td>
                    <td align="center"><?php echo $row->tarif ?></td>
                    <td align="center"><?php echo $row->total_permintaan ?></td>
                    <td align="center"><?php echo $realisasi ?></td>
                    <td align="center"><?php echo $total_pembayaran ?></td>
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
            <td align="center"><b><?php echo $ton?></b></td>
            <td align="center"><b><?php echo $ton_realiasi?></b></td>
            <td align="center"><b><?php echo $total?></b></td>
        </tr>
        </tbody>
    </table>
    </body>
    </html>
    <?php
}
else if(($this->session->userdata('role') == "keuangan" || $this->session->userdata('role') == "admin") && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "ruko_keuangan"){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo $title ?></title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                margin: 0 auto;
                page-break-after:auto;
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
        <h3 style="text-align: center"><?php echo $title ?></h3>
        <br><br>
    <table>
        <thead>
        <tr>
            <th align="center">No</th>
            <th align="center">No Invoice</th>
            <th align="center">No Nota</th>
            <th align="center">No Faktur</th>
            <th align="center">Nama Tenant</th>
            <th align="center">No Perjanjian</th>
            <th align="center">Alamat</th>
            <th align="center">No. Telepon</th>
            <th align="center">Total Penggunaan</th>
            <th align="center">Total Pembayaran (Rp.)</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        $no = 0;
        $ton_total = 0;

        if($laporan != NULL) {
            foreach ($laporan as $row) {
                $no++;
                $data_tagihan = $this->data->getTagihan($tgl_awal, $tgl_akhir, $row->id_flow);
                $pembayaran = 0;
                $ttl_akhir = 0;
                $ttl_awal = 0;
                $ton = 0;
                $no_perjanjian = '';

                $i = 1;

                if ($data_tagihan != NULL) {
                    foreach ($data_tagihan as $data) {
                        if ($data->id_ref_flowmeter == $row->id_flow) {
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

                    $ton_koma = $ttl_akhir - $ttl_awal;
                    $ton_total += $ton_koma;
                    $ton = number_format($ton_koma, 2);
                } else {
                    $ton = 0;
                    $no_perjanjian = $row->no_perjanjian;
                }
                if ($row->id_ref_tenant == NULL) {
                    if ($row->diskon != NULL) {
                        $pembayaran = ($row->tarif - ($row->tarif * $row->diskon / 100)) * $ton;
                    } else {
                        $pembayaran = $row->tarif * $ton;
                    }
                } else {
                    $date_now = strtotime(date('Y-m-d', time()));
                    $date_kadaluarsa = strtotime($row->waktu_kadaluarsa);

                    if ($date_now < $date_kadaluarsa || $date_now == $date_kadaluarsa)
                        $pembayaran = $row->nominal;
                    else
                        $pembayaran = 0;
                }

                $total += $pembayaran;

                if ($pembayaran == '0')
                    return '';
                else if ($pembayaran < 100)
                    $pembayaran .= ',-';
                else
                    $pembayaran = number_format($pembayaran, 0, '', '.') . ',-';

                if ($row->tarif == '0')
                    return '';
                else if ($row->tarif < 100)
                    $row->tarif .= ',-';
                else
                    $row->tarif = number_format($row->tarif, 0, '', '.') . ',-';
                ?>
                <tr>
                    <td align="center"><?php echo $no ?></td>
                    <td align="center"><?php echo $row->no_invoice ?></td>
                    <td align="center"><?php echo $row->no_nota ?></td>
                    <td align="center"><?php echo $row->no_faktur ?></td>
                    <td align="center"><?php echo $row->nama_tenant ?></td>
                    <td align="center"><?php echo $no_perjanjian ?></td>
                    <td align="center"><?php echo $row->lokasi ?></td>
                    <td align="center"><?php echo $row->no_telp ?></td>
                    <td align="center"><?php echo $ton ?></td>
                    <td align="center"><?php echo $pembayaran ?></td>
                </tr>
                <?php
            }
        }

        if ($total == '0')
            return '';
        else if ($total < 100)
            $total .= ',-';
        else
            $total = number_format($total, 0, '', '.') . ',-';

        ?>
        <tr>
            <td align="center" colspan="7"><b>Total</b></td>
            <td align="center"><b><?php echo number_format($ton_total,2)?></b></td>
            <td align="center"><b><?php echo $total?></b></td>
        </tr>
        </tbody>
    </table>
    </body>
    </html>
    <?php
}
else if(($this->session->userdata('role') == "wtp" || $this->session->userdata('role') == "admin") && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "darat"){
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
                page-break-after:auto;
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
    <table>
        <thead>
        <tr>
            <th align="center">No</th>
            <th align="center">Nama Pengguna Jasa</th>
            <th align="center">Tanggal Transaksi</th>
            <th align="center">Waktu Permintaan Pengantaran</th>
            <th align="center">Waktu Mulai Pengantaran</th>
            <th align="center">Waktu Selesai Pengantaran</th>
            <th align="center">Lama Pengantaran</th>
            <th align="center">Total Permintaan (Ton)</th>
            <th align="center">Total Pembayaran (Rp.)</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $no=0;
        $total=0;
        $ton=0;
        foreach($laporan as $row) {
            $no++;
            $format_jam_awal = "";
            $format_jam_akhir = "";

            if($row->batal_kwitansi == 1){
                $total_pembayaran = '';
            } else if ($row->diskon != NULL || $row->diskon != 0) {
                $row->tarif -= $row->tarif * $row->diskon / 100;
                $total_pembayaran = $row->tarif * $row->total_permintaan;
            } else {
                $total_pembayaran = $row->tarif * $row->total_permintaan;
            }

            $waktu_awal = mktime(date("H", strtotime($row->waktu_mulai_pengantaran)), date("i", strtotime($row->waktu_mulai_pengantaran)), date("s", strtotime($row->waktu_mulai_pengantaran)), date("m", strtotime($row->waktu_mulai_pengantaran)), date("d", strtotime($row->waktu_mulai_pengantaran)), date("y", strtotime($row->waktu_mulai_pengantaran)));
            $waktu_akhir = mktime(date("H", strtotime($row->waktu_selesai_pengantaran)), date("i", strtotime($row->waktu_selesai_pengantaran)), date("s", strtotime($row->waktu_selesai_pengantaran)), date("m", strtotime($row->waktu_selesai_pengantaran)), date("d", strtotime($row->waktu_selesai_pengantaran)), date("y", strtotime($row->waktu_selesai_pengantaran)));
            $lama_pengantaran = round((($waktu_akhir - $waktu_awal) % 86400) / 3600, 2);

            if($lama_pengantaran > 1){
                $lama_pengantaran .= " Jam";
            }else {
                $lama_pengantaran = $lama_pengantaran * 60;
                if ($lama_pengantaran > 1){
                    $lama_pengantaran .= " Menit";
                }else {
                    $lama_pengantaran = $lama_pengantaran * 60;
                    $lama_pengantaran .= " Detik";
                }
            }

            if($row->batal_kwitansi == 0){
                $total += $total_pembayaran;
                $ton += $row->total_permintaan;
            }

            $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi));
            $format_tgl_pengantaran = date('d-m-Y H:i:s', strtotime($row->tgl_perm_pengantaran));

            if($row->waktu_mulai_pengantaran == NULL){
                $format_jam_awal = "";
            } else {
                $format_jam_awal = date("d-m-y H:i:s", strtotime($row->waktu_mulai_pengantaran));
            }

            if($row->waktu_selesai_pengantaran == NULL){
                $format_jam_akhir = "";
            } else{
                $format_jam_akhir = date("d-m-y H:i:s", strtotime($row->waktu_selesai_pengantaran));
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
                    <td align="center"><?php echo $no; ?></td>
                    <td align="center"><?php echo $row->nama_pengguna_jasa; ?></td>
                    <td align="center"><?php echo $format_tgl; ?></td>
                    <td align="center"><?php echo $format_tgl_pengantaran; ?></td>
                    <td align="center"><?php echo $format_jam_awal; ?></td>
                    <td align="center"><?php echo $format_jam_akhir; ?></td>
                    <td align="center"><?php echo $lama_pengantaran; ?></td>
                    <td align="center"><?php echo $row->total_permintaan; ?></td>
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
            <td align="center"><b><?php echo $ton?></b></td>
            <td align="center"><b><?php echo $total?></b></td>
        </tr>
        </tbody>
    </table>
    </body>
    </html>
    <?php
}
else if(($this->session->userdata('role') == "wtp" || $this->session->userdata('role') == "admin") && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "laut_operasi" ){
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
                page-break-after:auto;
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
    <table>
        <thead>
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
    <?php
}
else if(($this->session->userdata('role') == "wtp" || $this->session->userdata('role') == "admin") && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "sumur"){
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
            <th align="center">ID Sumur</th>
            <th align="center">Nama Sumur</th>
            <th align="center">Nama Pompa</th>
            <th align="center">Nama Flow Meter</th>
            <th align="center">Start Running</th>
            <th align="center">Cuaca</th>
            <th align="center">Debit Air (L/Detik)</th>
            <th align="center">Nilai Flow (m3)</th>
            <th align="center">Finish Running</th>
            <th align="center">Cuaca</th>
            <th align="center">Debit Air (L/Detik)</th>
            <th align="center">Nilai Flow (m3)</th>
            <th align="center">Pemakaian (m3)</th>
            <th align="center">Issued By</th>
        </tr>
        </thead>
        <tbody>
        <?php

        if($laporan != NULL){
        $ton_total = 0;
        $ton = 0;
        $no = 1;

        foreach($laporan as $row) {
            $ttl_akhir = 0;
            $ttl_awal = 0;

            $ttl_akhir = $row->flow_sumur_akhir;
            $ttl_awal = $row->flow_sumur_awal;

            $ton_koma = $ttl_akhir - $ttl_awal;
            $ton_total += $ton_koma;
            $ton = number_format($ton_koma,2);

                ?>
                <tr>
                    <td align="center"><?php echo $no ?></td>
                    <td align="center"><?php echo $row->id_sumur ?></td>
                    <td align="center"><?php echo $row->nama_sumur ?></td>
                    <td align="center"><?php echo $row->nama_pompa ?></td>
                    <td align="center"><?php echo $row->nama_flowmeter ?></td>
                    <td align="center"><?php echo $row->waktu_rekam_awal ?></td>
                    <td align="center"><?php echo $row->cuaca_awal ?></td>
                    <td align="center"><?php echo $row->debit_air_awal ?></td>
                    <td align="center"><?php echo $row->flow_sumur_awal ?></td>
                    <td align="center"><?php echo $row->waktu_rekam_akhir ?></td>
                    <td align="center"><?php echo $row->cuaca_akhir ?></td>
                    <td align="center"><?php echo $row->debit_air_akhir ?></td>
                    <td align="center"><?php echo $row->flow_sumur_akhir ?></td>
                    <td align="center"><?php echo $ton ?></td>
                    <td align="center"><?php echo $row->issued_by ?></td>
                </tr>
                <?php
                $no++;
        }

        ?>

        <tr>
            <td align="center"colspan="13"><b>Total</b></td>
            <td align="center"><b><?php echo number_format($ton_total,2)?></b></td>
            <td align="center"><b>&nbsp;</b></td>
        </tr>
        </tbody>
        <?php
        }
        ?>
    </table>
    </body>
    </html>
    <?php
}
else if(($this->session->userdata('role') == "wtp" || $this->session->userdata('role') == "admin") && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "flow"){
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
                page-break-after:auto;
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
            <th align="center">ID Flow Meter</th>
            <th align="center">Nama Flow Meter</th>
            <th align="center">Nilai Flow </th>
            <th align="center">Issued By</th>
        </tr>
        </thead>
        <tbody>
        <?php

        if($laporan != NULL){
            $ton_total = 0;
            $ton = 0;
            $no = 1;

            foreach($laporan as $row) {
                $data_tagihan = $this->data->getFlow($tgl_awal, $tgl_akhir, $row->id_flow);
                $ttl_akhir = 0;
                $ttl_awal = 0;
                $i = 1;
                $status_rekam = 0;

                if($data_tagihan != NULL){
                    foreach ($data_tagihan as $data) {
                        if ($data->id_ref_flowmeter == $row->id_flow) {
                            if ($i == 1 && $data->flow_hari_ini != NULL) {
                                $ttl_awal = $data->flow_hari_ini;
                            }
                            else {
                                if ($ttl_awal == 0) {
                                    $ttl_awal = $data->flow_hari_ini;
                                }
                            }
                            if ($i == count($data_tagihan) && $data->flow_hari_ini != NULL) {
                                $ttl_akhir = $data->flow_hari_ini;
                            }
                            $i++;
                            $status_rekam = $data->status_perekaman;
                            $issuer = $data->issued_by;
                        }
                        else {
                            $i = 1;
                            $status_rekam = 0;
                        }
                    }

                    if($status_rekam == 1) {
                        ?>
                        <tr>
                            <td align="center"><?php echo $no ?></td>
                            <td align="center"><?php echo $row->id_flowmeter ?></td>
                            <td align="center"><?php echo $row->nama_flowmeter ?></td>
                            <td align="center"><?php echo $ttl_akhir ?></td>
                            <td align="center"><?php echo $issuer ?></td>
                        </tr>
                        <?php
                        $no++;
                    }
                }
            }
        }

        ?>
        </tbody>
    </table>
    </body>
    </html>
    <?php
}
else if($this->session->userdata('role') == "perencanaan" && $this->session->userdata('session') != NULL && $this->input->get('tipe') == "laut_operasi") {
    ?>
    
    <?php
}
else{
    redirect('main');
}
?>
