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
            <?php
                $no = 1;
                $total_realisasi_kapal = 0;
                $total_bayar_kapal = 0;
                $total_permintaan_darat = 0;
                $total_bayar_darat = 0;
                $total_pemakaian_tenant = 0;
                $total_bayar_tenant = 0;

                if($air_kapal != NULL){
            ?>
                    <thead>
                        <tr><th colspan="5">Produksi Air Kapal</th></tr>
                        <tr>
                            <th align="center"><center>No</th>
                            <th align="center"><center>Nama Agent</th>
                            <th align="center"><center>Nama Vessel</th>
                            <th align="center"><center>Total Realisasi (m3)</th>
                            <th align="center"><center>Jumlah Bayar (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
                    foreach($air_kapal as $row){
                        if($row->jumlah_bayar == '0')
                            $total_bayar_new = '';
                        elseif($row->jumlah_bayar < 100)
                            $total_bayar_new = $row->jumlah_bayar.',-';
                        else
                            $total_bayar_new = number_format($row->jumlah_bayar,0,'','.').',-';
            ?>
                        <tr>
                            <td align="center"><?= $no ?></td>
                            <td align="center"><?= $row->nama_agent?></td>
                            <td align="center"><?= $row->nama_vessel?></td>
                            <td align="center"><?= $row->total_realisasi?></td>
                            <td align="center"><?= $total_bayar_new?></td>
                        </tr>
                    <?php
                        $total_realisasi_kapal += $row->total_realisasi;
                        $total_bayar_kapal += $row->jumlah_bayar;
                        $no++;
                    }

                    if($total_bayar_kapal == '0')
                        $total_bayar_kapal_new = '';
                    elseif($total_bayar_kapal < 100)
                        $total_bayar_kapal_new = $total_bayar_kapal.',-';
                    else
                        $total_bayar_kapal_new = number_format($total_bayar_kapal,0,'','.').',-';
                    ?>

                        <tr>
                            <td align="center"colspan="3"><b>Total</b></td>
                            <td align="center"><b><?php echo $total_realisasi_kapal?></b></td>
                            <td align="center"><b><?php echo $total_bayar_kapal_new?></b></td>
                        </tr>
                    </tbody>
            <?php 
                }
                if($air_darat != NULL){
            ?>
                    <thead>
                        <tr><th colspan="5">Produksi Air Darat</th></tr>
                        <tr>
                            <th align="center"><center>No</th>
                            <th colspan="2" align="center"><center>Nama Pengguna Jasa</th>
                            <th align="center"><center>Total Permintaan (m3)</th>
                            <th align="center"><center>Jumlah Bayar (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
                    foreach($air_darat as $row){
                        if($row->jumlah_bayar == '0')
                            $total_bayar_new = '';
                        elseif($row->jumlah_bayar < 100)
                            $total_bayar_new = $row->jumlah_bayar.',-';
                        else
                            $total_bayar_new = number_format($row->jumlah_bayar,0,'','.').',-';
            ?>
                            <tr>
                                <td align="center"><?= $no ?></td>
                                <td colspan="2" align="center"><?= $row->nama_pengguna_jasa ?></td>
                                <td align="center"><?= $row->total_permintaan ?></td>
                                <td align="center"><?= $total_bayar_new ?></td>
                            </tr>
                        <?php
                            $total_permintaan_darat += $row->total_permintaan;
                            $total_bayar_darat += $row->jumlah_bayar;
                            $no++;
                    }
    
                        if($total_bayar_darat == '0')
                            $total_bayar_darat_new;
                        elseif($total_bayar_darat < 100)
                            $total_bayar_darat_new = $total_bayar_darat.',-';
                        else
                            $total_bayar_darat_new = number_format($total_bayar_darat,0,'','.').',-';
                        ?>

                        <tr>
                            <td align="center"colspan="3"><b>Total</b></td>
                            <td align="center"><b><?php echo $total_permintaan_darat?></b></td>
                            <td align="center"><b><?php echo $total_bayar_darat_new?></b></td>
                        </tr>
                    </tbody>
            <?php
                }
                if($air_tenant != NULL){
            ?>
                    <thead>
                        <tr><th colspan="5">Pemakaian Air Tenant</th></tr>
                        <tr>
                            <th align="center"><center>No</th>
                            <th align="center"><center>Nama Tenant</th>
                            <th align="center"><center>Nama ID Flowmeter</th>
                            <th align="center"><center>Total Pemakaian (m3)</th>
                            <th align="center"><center>Jumlah Bayar (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
                    foreach($air_tenant as $row){
                        if($row->total_bayar == '0')
                            $total_bayar_new = '';
                        elseif($row->total_bayar < 100)
                            $total_bayar_new = $row->total_bayar.',-';
                        else
                            $total_bayar_new = number_format($row->total_bayar,0,'','.').',-';
            ?>                        
                        <tr>
                            <td align="center"><?= $no ?></td>
                            <td align="center"><?= $row->nama_tenant ?></td>
                            <td align="center"><?= $row->id_flowmeter ?></td>
                            <td align="center"><?= $row->total_pakai ?></td>
                            <td align="center"><?= $total_bayar_new ?></td>
                        </tr>
            <?php
                        $total_pemakaian_tenant += $row->total_pakai;
                        $total_bayar_tenant += $row->total_bayar;
                        $no++;
                    }

                    if($total_bayar_tenant == '0')
                        $total_bayar_tenant_new = '';
                    elseif($total_bayar_tenant < 100)
                        $total_bayar_tenant_new = $total_bayar_tenant.',-';
                    else
                        $total_bayar_tenant_new = number_format($total_bayar_tenant,0,'','.').',-';
            ?>
                        <tr>
                            <td align="center" colspan="3"><b>Total</b></td>
                            <td align="center"><b><?= $total_pemakaian_tenant ?></b></td>
                            <td align="center"><b><?= $total_bayar_tenant_new ?></b></td>
                        </tr>
                    </tbody>
            <?php            
                }

                $total_bayar_keseluruhan = $total_bayar_kapal + $total_bayar_darat + $total_bayar_tenant;
                $total_produksi_air = $total_pemakaian_tenant + $total_permintaan_darat + $total_realisasi_kapal;

                if($total_bayar_keseluruhan == '0')
                        return '';
                elseif($total_bayar_keseluruhan < 100)
                    $total_bayar_keseluruhan.= ',-';
                else
                    $total_bayar_keseluruhan = number_format($total_bayar_keseluruhan,0,'','.').',-';
            ?>
            <tfoot>
                <tr>
                    <td align="center" colspan="3"><b>Total Keseluruhan</b></td>
                    <td align="center"><b><?= $total_produksi_air?></b></td>
                    <td align="center"><b><?= $total_bayar_keseluruhan?></b></td>
                </tr>
            </tfoot>    
        </table>
    </body>
</html>