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