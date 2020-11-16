<?php ob_start();?>
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