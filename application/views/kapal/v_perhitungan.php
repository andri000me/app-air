<?php
if($hasil['status_kapal'] == 'internasional'){
    $this->fpdf->AddPage('L');
    $this->fpdf->SetFont('Arial', 'B', 14);
    $this->fpdf->Ln();
    $this->fpdf->Cell(0, 1, 'PT KALTIM KARIANGAU TERMINAL', 0, 1, 'L');
    $this->fpdf->SetFont('Arial', '', 12);
    $this->fpdf->Cell(280, 1, 'Tanggal Cetak : '.$hasil['tanggal'], 0, 1, 'R');
    $this->fpdf->SetFont('Arial', 'B', 14);
    $this->fpdf->Ln();
    $this->fpdf->Cell(0, 9, 'TERMINAL PETIKEMAS KARIANGAU', 0, 1, 'L');
    $this->fpdf->SetFont('Arial', 'B', 16);
    $this->fpdf->Ln();
    $this->fpdf->Cell(0, 7, 'PERHITUNGAN PENGISIAN AIR BERSIH', 0, 1, 'C');
    $this->fpdf->Ln();
    $this->fpdf->SetFont('Arial', '', 12);
    $this->fpdf->SetTextColor(0, 0, 0);
    $this->fpdf->Cell(40, 7, 'ID VESSEL', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['id_lct'], 0, 'L');
    $this->fpdf->Cell(40, 7, 'Pelayaran', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['pelayaran'], 0, 'L');
    $this->fpdf->Ln();
    $this->fpdf->Cell(40, 7, 'Nama VESSEL', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['nama_kapal'], 0, 'L');
    $this->fpdf->Cell(40, 7, 'Nama Pemohon', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['nama_pemohon'], 0, 'L');
    $this->fpdf->Ln();
    $this->fpdf->Cell(40, 7, 'Voy No', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['voy_no'], 0, 'L');
    $this->fpdf->Cell(40, 7, 'Tanggal Pengisian', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['tgl_transaksi'], 0, 'L');
    $this->fpdf->Ln();
    //$this->fpdf->Ln();
    //$this->fpdf->Ln();
    //$this->fpdf->Ln();
    $this->fpdf->Ln();
    $this->fpdf->Cell(60, 7, 'Produksi', 1,0, 'C');
    $this->fpdf->Cell(60, 7, 'Tarif', 1,0, 'C');
    $this->fpdf->Cell(60, 7, ' Diskon', 1,0, 'C');
    $this->fpdf->Cell(95, 7, ' Total', 1,0, 'C');
    $this->fpdf->Ln();
    $this->fpdf->Cell(60, 7, $hasil['realisasi'].' Ton', 1,0, 'C');
    $this->fpdf->Cell(60, 7, $hasil['simbol'].' '.$hasil['tarif_internasional'], 1,0, 'C');
    if($hasil['diskon'] != NULL)
        $this->fpdf->Cell(60, 7, $hasil['diskon'].' %', 1,0, 'C');
    else
        $this->fpdf->Cell(60, 7, '0 %', 1,0, 'C');
    $this->fpdf->Cell(95, 7, 'Rp. '.$hasil['total'], 1,0, 'C');
    $this->fpdf->Ln();
    $this->fpdf->Ln();
    $this->fpdf->Cell(193, 3, 'DASAR PENGENAAN PAJAK (DPP)   :',  0, 0, 'R');
    $this->fpdf->Cell(50, 3, 'Rp. '.$hasil['total'],  0, 0, 'R');
    $this->fpdf->Ln(8);
    $this->fpdf->Cell(193, 3, 'PPN (10%)   :',  0, 0, 'R');
    $this->fpdf->Cell(50, 3, '0,-',  0, 0, 'R');
    $this->fpdf->Ln(8);
    $this->fpdf->Cell(193, 3, 'MATERAI   :',  0, 0, 'R');
    if($hasil['materai'] != 0)
        $this->fpdf->Cell(50, 3, 'Rp. '.$hasil['materai'],  0, 0, 'R');
    else
        $this->fpdf->Cell(50, 3, '0,-',  0, 0, 'R');
    $this->fpdf->Ln(8);
    $this->fpdf->Cell(193, 3, 'JUMLAH DIBAYAR   :',  0, 0, 'R');
    $this->fpdf->Cell(50, 3, 'Rp. '.$hasil['total_bayar'],  0, 0, 'R');
    $this->fpdf->Ln(10);
    $this->fpdf->SetFont('Arial', '', 12);
    $this->fpdf->Cell(32, 7, 'TERBILANG :', 0,0, 'R');
    $this->fpdf->SetFont('Arial', 'I', 14);
    $this->fpdf->Cell(95, 7, $hasil['terbilang']." Rupiah",  0, 0, 'L');
    $this->fpdf->Ln(8);
    $this->fpdf->Ln(4);
    $this->fpdf->SetFont('Arial', '', 12);
    $this->fpdf->Cell(470, 3, 'BALIKPAPAN , '.$hasil['tanggal'], 0, 0, 'C');
    $this->fpdf->Ln();
    $this->fpdf->Ln(4);
    $this->fpdf->Cell(470, 3, 'ASMAN PERENCANAAN DAN PEMASARAN', 0, 0, 'C');
    $this->fpdf->Ln(25);
    $this->fpdf->Cell(470, 3, 'BOGIE BRAMANTO', 0, 0, 'C');
    $this->fpdf->Ln(1);
    $this->fpdf->Cell(470, 3, '(.....................................................)', 0, 0, 'C');
    $this->fpdf->Ln();
    $this->fpdf->Ln(10);
    $this->fpdf->SetFont('Arial', '', 10);
    $this->fpdf->Cell(80, 3, 'Dengan Nilai Tukar Kurs '.$hasil['simbol'].' 1 = Rp. '.$hasil['nilai_tukar'], 0, 0, 'C');
    $this->fpdf->Output("perhitungan-".$hasil['pelayaran'].".pdf","I");
}else{
    $this->fpdf->AddPage('L');
    $this->fpdf->SetFont('Arial', 'B', 14);
    $this->fpdf->Ln();
    $this->fpdf->Cell(0, 1, 'PT KALTIM KARIANGAU TERMINAL', 0, 1, 'L');
    $this->fpdf->SetFont('Arial', '', 12);
    $this->fpdf->Cell(280, 1, 'Tanggal Cetak : '.$hasil['tanggal'], 0, 1, 'R');
    $this->fpdf->SetFont('Arial', 'B', 14);
    $this->fpdf->Ln();
    $this->fpdf->Cell(0, 9, 'TERMINAL PETIKEMAS KARIANGAU', 0, 1, 'L');
    $this->fpdf->SetFont('Arial', 'B', 16);
    $this->fpdf->Ln();
    $this->fpdf->Cell(0, 7, 'PERHITUNGAN PENGISIAN AIR BERSIH', 0, 1, 'C');
    $this->fpdf->Ln();
    $this->fpdf->SetFont('Arial', '', 12);
    $this->fpdf->SetTextColor(0, 0, 0);
    $this->fpdf->Cell(40, 7, 'ID VESSEL', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['id_lct'], 0, 'L');
    $this->fpdf->Cell(40, 7, 'Pelayaran', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['pelayaran'], 0, 'L');
    $this->fpdf->Ln();
    $this->fpdf->Cell(40, 7, 'Nama VESSEL', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['nama_kapal'], 0, 'L');
    $this->fpdf->Cell(40, 7, 'Nama Pemohon', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['nama_pemohon'], 0, 'L');
    $this->fpdf->Ln();
    $this->fpdf->Cell(40, 7, 'Voy No', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['voy_no'], 0, 'L');
    $this->fpdf->Cell(40, 7, 'Tanggal Pengisian', 0, 'L');
    $this->fpdf->Cell(5, 7, ':', 0, 'L');
    $this->fpdf->Cell(90, 7, $hasil['tgl_transaksi'], 0, 'L');
    $this->fpdf->Ln();
    //$this->fpdf->Ln();
    //$this->fpdf->Ln();
    //$this->fpdf->Ln();
    $this->fpdf->Ln();
    $this->fpdf->Cell(60, 7, 'Produksi', 1,0, 'C');
    $this->fpdf->Cell(60, 7, 'Tarif', 1,0, 'C');
    $this->fpdf->Cell(60, 7, ' Diskon', 1,0, 'C');
    $this->fpdf->Cell(95, 7, ' Total', 1,0, 'C');
    $this->fpdf->Ln();
    $this->fpdf->Cell(60, 7, $hasil['realisasi'].' Ton', 1,0, 'C');
    $this->fpdf->Cell(60, 7, 'Rp. '.$hasil['tarif'], 1,0, 'C');
    if($hasil['diskon'] != NULL)
        $this->fpdf->Cell(60, 7, $hasil['diskon'].' %', 1,0, 'C');
    else
        $this->fpdf->Cell(60, 7, '0 %', 1,0, 'C');
    $this->fpdf->Cell(95, 7, 'Rp. '.$hasil['total'], 1,0, 'C');
    $this->fpdf->Ln();
    $this->fpdf->Ln();
    $this->fpdf->Cell(193, 3, 'DASAR PENGENAAN PAJAK (DPP)   :',  0, 0, 'R');
    $this->fpdf->Cell(50, 3, 'Rp. '.$hasil['total'],  0, 0, 'R');
    $this->fpdf->Ln(8);
    $this->fpdf->Cell(193, 3, 'PPN (10%)   :',  0, 0, 'R');
    $this->fpdf->Cell(50, 3, '0,-',  0, 0, 'R');
    $this->fpdf->Ln(8);
    $this->fpdf->Cell(193, 3, 'MATERAI   :',  0, 0, 'R');
    if($hasil['materai'] != 0)
        $this->fpdf->Cell(50, 3, 'Rp. '.$hasil['materai'],  0, 0, 'R');
    else
        $this->fpdf->Cell(50, 3, '0,-',  0, 0, 'R');
    $this->fpdf->Ln(8);
    $this->fpdf->Cell(193, 3, 'JUMLAH DIBAYAR   :',  0, 0, 'R');
    $this->fpdf->Cell(50, 3, 'Rp. '.$hasil['total_bayar'],  0, 0, 'R');
    $this->fpdf->Ln(10);
    $this->fpdf->SetFont('Arial', '', 12);
    $this->fpdf->Cell(32, 7, 'TERBILANG :', 0,0, 'R');
    $this->fpdf->SetFont('Arial', 'I', 14);
    $this->fpdf->Cell(95, 7, $hasil['terbilang']." Rupiah",  0, 0, 'L');
    $this->fpdf->Ln(8);
    $this->fpdf->Ln(4);
    $this->fpdf->SetFont('Arial', '', 12);
    $this->fpdf->Cell(470, 3, 'BALIKPAPAN , '.$hasil['tanggal'], 0, 0, 'C');
    $this->fpdf->Ln();
    $this->fpdf->Ln(4);
    $this->fpdf->Cell(470, 3, 'ASMAN PERENCANAAN DAN PEMASARAN', 0, 0, 'C');
    $this->fpdf->Ln(25);
    $this->fpdf->Cell(470, 3, 'BOGIE BRAMANTO', 0, 0, 'C');
    $this->fpdf->Ln(1);
    $this->fpdf->Cell(470, 3, '(.....................................................)', 0, 0, 'C');
    $this->fpdf->Output("perhitungan-".$hasil['pelayaran'].".pdf","I");

}
?>