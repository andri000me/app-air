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
            <th align="center">Nama Tandon</th>
            <th align="center">Lokasi</th>
            <th align="center">Waktu Perekaman</th>
            <th align="center">Issued By</th>
            <th align="center">Total Pengisian (m3)</th>
        </tr>
        </thead>
        <tbody>
        <?php

        if($laporan != NULL){
        $ton_total = 0;
        $ton = 0;
        $no = 1;

        foreach($laporan as $row) {
            $ton_total += $row->total_pengisian;
            $ton = number_format($row->total_pengisian,2);

                ?>
                <tr>
                    <td align="center"><?php echo $no ?></td>
                    <td align="center"><?php echo $row->nama_tandon ?></td>
                    <td align="center"><?php echo $row->lokasi ?></td>
                    <td align="center"><?php echo $row->waktu_perekaman ?></td>
                    <td align="center"><?php echo $row->issued_by ?></td>
                    <td align="center"><?php echo $ton ?></td>
                </tr>
                <?php
                $no++;
        }

        ?>

        <tr>
            <td align="center"colspan="5"><b>Total</b></td>
            <td align="center"><b><?php echo number_format($ton_total,2)?></b></td>
        </tr>
        </tbody>
        <?php
        }
        ?>
    </table>
    </body>
    </html>