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
            <th align="center"><center>No</th>
            <th align="center"><center>Nama Tenant</th>
            <th align="center"><center>Nama Flow Meter</th>
            <th align="center"><center>Lokasi</th>
            <th align="center"><center>Tanggal Awal Realisasi</th>
            <th align="center"><center>Tanggal Akhir Realisasi</th>
            <th align="center"><center>Flow Awal</th>
            <th align="center"><center>Flow Akhir</th>
            <th align="center"><center>Issued By</th>
            <th align="center"><center>Total Pengisian (m3)</th>
        </tr>
        </thead>
        <tbody>
        <?php

        if($laporan != NULL){
        $ton_total = 0;
        $ton = 0;
        $no = 1;

        foreach($laporan as $row) {
            $ttl_awal = $row->flow_awal;
            $ttl_akhir = $row->flow_akhir;
            $ton = $ttl_akhir - $ttl_awal;
            $ton_total += $ton;

                ?>
                <tr>
                    <td align="center"><?= $no ?></td>
                    <td align="center"><?= $row->nama_tenant ?></td>
                    <td align="center"><?= $row->nama_flowmeter ?></td>
                    <td align="center"><?= $row->lokasi ?></td>
                    <td align="center"><?=$row->tgl_awal?></td>
                    <td align="center"><?=$row->tgl_akhir?></td>
                    <td align="center"><?=$ttl_awal?></td>
                    <td align="center"><?=$ttl_akhir?></td>
                    <td align="center"><?=$row->issued_by?></td>
                    <td align="center"><?=number_format($ton,2)?></td>
                </tr>
                <?php
                $no++;
        }

        ?>

        <tr>
            <td align="center"colspan="9"><b>Total</b></td>
            <td align="center"><b><?php echo number_format($ton_total,2)?></b></td>
        </tr>
        </tbody>
        <?php
        }
        ?>
    </table>
    </body>
    </html>