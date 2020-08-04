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
                $data_tagihan = $this->tenant->getFlow($tgl_awal, $tgl_akhir, $row->id_flow);
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