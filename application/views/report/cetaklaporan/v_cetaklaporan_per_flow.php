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
    <br>
    <h3>Flowmeter : <?php echo $id_flowmeter." => ".$sub_title; ?></h3>
    <table width="100%" style="page-break-after:auto;">
        <thead>
        <tr>
            <th align="center">No</th>
            <th align="center">Tanggal Pencatatan</th>
            <th align="center">Issued By</th>
            <th align="center">Nilai Flow </th>
        </tr>
        </thead>
        <tbody>
        <?php

        if($laporan != NULL){
            $no = 1;
            $ttl_akhir = 0;
            $ttl_awal = 0;
            $i = 1;

            foreach($laporan as $row) {
                $data_tagihan = $this->tenant->getFlow($tgl_awal, $tgl_akhir, $row->id_flow);
                
                if($row->status_perekaman == 1) {
                    ?>
                    <tr>
                        <td align="center"><?php echo $no ?></td>
                        <td align="center"><?php echo $row->waktu_perekaman ?></td>
                        <td align="center"><?php echo $row->issued_by ?></td>
                        <td align="center"><?php echo $row->flow_hari_ini ?></td>
                    </tr>
                    <?php
                    $no++;
                }
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
                }
            }

            $jumlah_pemakaian = $ttl_akhir - $ttl_awal;
            ?>
            <tr>
                <td colspan="3" align="center">Total Pemakaian</td>
                <td align="center"><?php echo $jumlah_pemakaian ?></td>
            </tr>
            <?php
        }

        ?>
        </tbody>
    </table>
    </body>
    </html>