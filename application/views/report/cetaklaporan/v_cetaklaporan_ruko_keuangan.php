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