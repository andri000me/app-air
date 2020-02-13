<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tenant extends MY_Controller{
    //fungsi untuk transaksi tenant
    public function get_tenant() {
        $nama = $this->input->get('term',TRUE); //variabel kunci yang di bawa dari input text id kode
        $tipe = "ruko";
        $query = $this->tenant->get_pembeli($tipe,$nama); //query model
        $pelanggan = array();

        if($query == TRUE){
            foreach ($query as $data) {
                $pelanggan[] = array(
                    'id_flow' => $data->id_flow,
                    'label' => $data->id_flowmeter."=>".$data->nama_flowmeter, //variabel array yg dibawa ke label ketikan kunci
                    'nama_flow' => $data->nama_flowmeter , //variabel yg dibawa ke id nama
                    'flow_akhir' => $data->flowmeter_akhir,
                );
            }
        }

        echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
    }

    public function get_pembeli_ruko() {
        $nama = $this->input->get('term',TRUE); //variabel kunci yang di bawa dari input text id kode
        $tipe = "ruko_tagihan";
        $query = $this->tenant->get_pembeli($tipe,$nama); //query model

        $pelanggan = array();
        foreach ($query as $data) {
            $pelanggan[] = array(
                'id_flow' => $data->id_flow,
                'id_tenant' => $data->id_tenant,
                'nama_flow' => $data->nama_flowmeter,
                'nama_tenant' => $data->nama_tenant,
                'label' => $data->id_flowmeter." => ".$data->nama_tenant, //variabel array yg dibawa ke label ketikan kunci
            );
        }

        echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
    }

    public function get_nama_flow() {
        $nama = $this->input->get('term',TRUE); //variabel kunci yang di bawa dari input text id kode
        $tipe = "ruko";
        $query = $this->tenant->get_pembeli($tipe,$nama); //query model

        if($query == TRUE){
            $pelanggan = array();
            foreach ($query as $data) {
                $pelanggan[] = array(
                    'id_flow' => $data->id_flow,
                    'nama_flow' => $data->nama_flowmeter,
                    'label' => $data->id_flowmeter." => ".$data->nama_flowmeter, //variabel array yg dibawa ke label ketikan kunci
                );
            }
        }

        echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
    }

    function check_equal_less($second_field,$first_field){
        if ($second_field <= $first_field) {
            $this->form_validation->set_message('check_equal_less', 'Flow Meter Tidak Boleh Kurang Dari Sebelumnya');
            return false;
        }
        else {
            return true;
        }
    }

    public function transaksi_tenant() {
        $this->_validate_catat_flow();
        $id_tenant = $this->input->post('id_tenant');
        $id_flow = $this->input->post('id_flow');
        $tanggal = $this->input->post('tanggal');
        $tonnase = $this->input->post('flow_hari_ini');
        
        $cekFlow = $this->tenant->cekFlowAwal($id_flow);

        if($cekFlow == TRUE){
            $data_flow = array(
                'id_flow' => $id_flow,
                'flowmeter_awal' => $tonnase,
            );
        }

        $data_transaksi = array(
            'id_flow' => $id_flow,
            'id_tenant' => $id_tenant,
            'waktu_perekaman' => $tanggal,
            'flow_hari_ini' => $tonnase,
            'issued_at' => date("Y-m-d H:i:s",time()),
            'issued_by' => $this->session->userdata('nama')
        );

        if($cekFlow == TRUE){
            $this->tenant->inputFlowAwal($data_flow);
            $result = $this->tenant->input_transaksi("ruko",$data_transaksi);
        } else{
            $result = $this->tenant->input_transaksi("ruko",$data_transaksi);
        }

        if($result == TRUE){
            echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
        }
        else{
            echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
        }        
    }

    public function transaksi_tandon() {
        $this->_validate_catat_tandon();
        $id_tenant = $this->input->post('id_tandon');
        $tanggal = $this->input->post('tanggal');
        $tonnase = $this->input->post('tonnase');

        $data_transaksi = array(
            'id_ref_tandon' => $id_tenant,
            'waktu_perekaman' => $tanggal,
            'total_pengisian' => $tonnase,
            'issued_at' => date("Y-m-d H:i:s",time()),
            'issued_by' => $this->session->userdata('nama')
        );

        $result = $this->tenant->input_transaksi("tandon",$data_transaksi);

        if($result == TRUE){
            echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
        }
        else{
            echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
        }        
    }

    private function _validate_catat_flow(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('id_flowmeter') == NULL)
        {
            $data['inputerror'][] = 'id_flowmeter';
            $data['error_string'][] = 'ID Flowmeter Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('tanggal') == NULL)
        {
            $data['inputerror'][] = 'tanggal';
            $data['error_string'][] = 'Tanggal Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flow_hari_ini') == NULL)
        {
            $data['inputerror'][] = 'flow_hari_ini';
            $data['error_string'][] = 'Nilai Flow Hari Ini Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flow_hari_ini') != NULL && ($this->input->post('flow_hari_ini') <= $this->input->post('flowmeter_akhir')))
        {
            $data['inputerror'][] = 'flow_hari_ini';
            $data['error_string'][] = 'Nilai Flow Hari Ini Tidak Boleh Lebih Kecil Dari Nilai Flow Terakhir';
            $data['status'] = FALSE;
        }

    }

    private function _validate_catat_tandon(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('id_tandon') == NULL)
        {
            $data['inputerror'][] = 'id_tandon';
            $data['error_string'][] = 'Nama Tandon Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('tanggal') == NULL)
        {
            $data['inputerror'][] = 'tanggal';
            $data['error_string'][] = 'Tanggal Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('tonnase') == NULL)
        {
            $data['inputerror'][] = 'flow_hari_ini';
            $data['error_string'][] = 'Nilai Pengisian Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

    }

    public function get_tandon() {
        $nama = $this->input->get('term',TRUE); //variabel kunci yang di bawa dari input text id kode
        $query = $this->tenant->get_tandon($nama); //query model
        $pelanggan = array();

        if($query == TRUE){
            foreach ($query as $data) {
                $pelanggan[] = array(
                    'id_tandon' => $data->id,
                    'label' => $data->nama_tandon, //variabel array yg dibawa ke label ketikan kunci
                    'nama_tandon' => $data->nama_tandon , //variabel yg dibawa ke id nama
                    'lokasi' => $data->lokasi,
                );
            }
        }

        echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
    }

    //fungsi untuk pencatatan sumur
    public function get_sumur() {
        $nama = $this->input->get('term',TRUE); //variabel kunci yang di bawa dari input text id kode
        $tipe = "sumur";
        $query = $this->tenant->get_pembeli($tipe,$nama); //query model
        $pelanggan = array();

        if($query == TRUE){
            foreach ($query as $data) {
                $pelanggan[] = array(
                    'id_sumur' => $data->id_master_sumur,
                    'label' => $data->id_flowmeter."=>".$data->nama_flowmeter, //variabel array yg dibawa ke label ketikan kunci
                    'nama_sumur' => $data->nama_sumur , //variabel yg dibawa ke id nama
                    'nama_pompa' => $data->nama_pompa,
                    'nama_flowmeter' => $data->nama_flowmeter,
                    'flowmeter_akhir' => $data->flowmeter_akhir,
                    'debit_air' => $data->debit_air,
                    'id_pompa' => $data->id_master_pompa,
                    'id_flowmeter' => $data->id_flow,
                );
            }
        }

        echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
    }

    public function transaksi_sumur() {
        $this->_validate_catat_sumur();
        $id_sumur = $this->input->post('id_master_sumur_awal');
        $id_flow = $this->input->post('id_flowmeter');

        $cuaca_awal = $this->input->post('cuaca_awal');
        $cuaca_akhir = $this->input->post('cuaca_akhir');
        $waktu_awal = $this->input->post('tanggal_awal');
        $waktu_akhir = $this->input->post('tanggal_akhir');
        $tonnase_awal = $this->input->post('flow_hari_ini_awal');
        $tonnase_akhir = $this->input->post('flow_hari_ini_akhir');
        $debit_awal= $this->input->post('debit_awal');
        $debit_akhir = $this->input->post('debit_akhir');

        $cekFlow = $this->tenant->cekFlowAwal($id_flow);

        if($cekFlow == TRUE){
            $data_flow = array(
                'id_flow' => $id_flow,
                'flowmeter_awal' => $tonnase_awal,
            );
        }

        $data_transaksi = array(
            'id_ref_flowmeter' => $id_flow,
            'cuaca_awal' => $cuaca_awal,
            'cuaca_akhir' => $cuaca_akhir,
            'waktu_rekam_awal' => $waktu_awal,
            'waktu_rekam_akhir' => $waktu_akhir,
            'flow_sumur_awal' => $tonnase_awal,
            'flow_sumur_akhir' => $tonnase_akhir,
            'debit_air_awal' => $debit_awal,
            'debit_air_akhir' => $debit_akhir,
            'waktu_perekaman' => date("Y-m-d H:i:s",time()),
            'issued_at' => date("Y-m-d H:i:s",time()),
            'issued_by' => $this->session->userdata('username')
        );

        if($cekFlow == TRUE){
            $this->tenant->inputFlowAwal($data_flow);
            $result = $this->tenant->input_transaksi("sumur",$data_transaksi);
        } else{
            $result = $this->tenant->input_transaksi("sumur",$data_transaksi);
        }

        if($result == TRUE){
            echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
        }
        else{
            echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
        }
    }

    private function _validate_catat_sumur(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('id_master_sumur_awal') == NULL)
        {
            $data['inputerror'][] = 'id_master_sumur_awal';
            $data['error_string'][] = 'ID Flowmeter Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('tanggal_awal') == NULL)
        {
            $data['inputerror'][] = 'tanggal_awal';
            $data['error_string'][] = 'Tanggal Awal Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flow_hari_ini_awal') == NULL)
        {
            $data['inputerror'][] = 'flow_hari_ini_awal';
            $data['error_string'][] = 'Nilai Flow Awal Hari Ini Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('tanggal_akhir') == NULL)
        {
            $data['inputerror'][] = 'tanggal_akhir';
            $data['error_string'][] = 'Tanggal Akhir Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flow_hari_ini_akhir') == NULL)
        {
            $data['inputerror'][] = 'flow_hari_ini_akhir';
            $data['error_string'][] = 'Nilai Flow Akhir Hari Ini Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('cuaca_awal') == NULL)
        {
            $data['inputerror'][] = 'cuaca_awal';
            $data['error_string'][] = 'Cuaca Awal Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('cuaca_akhir') == NULL)
        {
            $data['inputerror'][] = 'cuaca_akhir';
            $data['error_string'][] = 'Cuaca Akhir Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function tabel_tagihan_tenant(){
        if($this->session->userdata('role_name')== 'operasi' || $this->session->userdata('role_name')== 'wtp' || $this->session->userdata('role_name')== 'admin'){
            $result = $this->tenant->get_tabel_transaksi();
            $data = array();
            $no = 1;

            foreach ($result as $row){
                if($this->session->userdata('role_name')== 'admin'){
                    $aksi = '<span class=""><a class="btn btn-sm btn-primary glyphicon glyphicon-list-alt" title="Cetak Tagihan" target="_blank" href="'.base_url("tenant/cetakTagihan/".$row->id_transaksi."/".$row->id_flow."/".$row->tgl_awal."/"."$row->tgl_akhir").'"> </a></span>';
                    $aksi .= '&nbsp;<span class=""><a class="btn btn-sm btn-info glyphicon glyphicon-list-alt" title="Cetak Realisasi Pemakaian" target="_blank" href="'.base_url("tenant/cetakRealisasiPemakaian/".$row->id_transaksi."/".$row->id_flow."/".$row->tgl_awal."/"."$row->tgl_akhir").'"> </a></span>';
                    $aksi .= '&nbsp;<a class="btn btn-sm btn-danger glyphicon glyphicon-remove" title="Batal Invoice" href="javascript:void(0)" onclick="batal('."'".$row->id_transaksi."'".');"></a>';
                }else if($this->session->userdata('role_name') == 'operasi'){
                    $aksi = '<span class=""><a class="btn btn-sm btn-primary glyphicon glyphicon-list-alt" title="Cetak Tagihan" target="_blank" href="'.base_url("tenant/cetakTagihan/".$row->id_transaksi."/".$row->id_flow."/".$row->tgl_awal."/"."$row->tgl_akhir").'"> </a></span>';
                    $aksi .= '&nbsp;<a class="btn btn-sm btn-danger glyphicon glyphicon-remove" title="Batal Invoice" href="javascript:void(0)" onclick="batal('."'".$row->id_transaksi."'".');"></a>';
                }else if($this->session->userdata('role_name') == 'wtp'){
                    $aksi = '<span class=""><a class="btn btn-sm btn-info glyphicon glyphicon-list-alt" title="Cetak Realisasi Pemakaian" target="_blank" href="'.base_url("tenant/cetakRealisasiPemakaian/".$row->id_transaksi."/".$row->id_flow."/".$row->tgl_awal."/"."$row->tgl_akhir").'"> </a></span>';
                } 
                else{
                    $aksi = '<span class=""><a class="btn btn-sm btn-primary glyphicon glyphicon-list-alt" title="Realisasi Pembayaran" href="javascript:void(0)" onclick="realisasi('."'".$row->id_transaksi."'".');"> </a></span>';
                }

                if($row->no_perjanjian == NULL){
                    $row->no_perjanjian = "";
                }
                $tarif = '';

                if($row->diskon != NULL || $row->diskon != ''){
                    $tarif = $row->tarif - ($row->diskon * $row->tarif / 100);
                } else{
                    $tarif = $row->tarif;
                }

                $tgl_awal = date("d-M-Y",strtotime($row->tgl_awal));
                $tgl_akhir = date("d-M-Y",strtotime($row->tgl_akhir));

                if($row->soft_delete == 0 && $row->status_invoice == 1){
                    $data[] = array(
                        'no' => $no,
                        'no_invoice' => $row->no_invoice,
                        'id_flowmeter' => $row->id_flowmeter,
                        'nama_tenant' => $row->nama_tenant,
                        'periode' => $tgl_awal." s/d ".$tgl_akhir,
                        'waktu_transaksi' => $row->tgl_transaksi,
                        'lokasi' => $row->lokasi,
                        'no_telp' => $row->no_telp,
                        'tarif' => $tarif,
                        'no_perjanjian' => $row->no_perjanjian,
                        'total_pakai' => $row->total_pakai,
                        'total_bayar' => $this->Ribuan($row->total_bayar),
                        'aksi' => $aksi,
                    );
                    $no++;
                }
            }
        } else{
            $result = $this->tenant->get_tabel_transaksi();
            $data = array();
            $no = 1;

            foreach ($result as $row){
                $aksi = '<span class=""><a class="btn btn-primary glyphicon glyphicon-list-alt" title="Realisasi Pembayaran" href="javascript:void(0)" onclick="realisasi('."'".$row->id_transaksi."'".');"> </a></span>';

                if($row->soft_delete == 0 && $row->status_invoice == 1){
                    $data[] = array(
                        'no' => $no,
                        'no_invoice' => $row->no_invoice,
                        'nama_tenant' => $row->nama_tenant,
                        'waktu_transaksi' => $row->tgl_transaksi,
                        'lokasi' => $row->lokasi,
                        'no_telp' => $row->no_telp,
                        'total_pakai' => $row->total_pakai,
                        'total_bayar' => $this->Ribuan($row->total_bayar),
                        'aksi' => $aksi,
                    );
                    $no++;
                }
            }

        }

        echo json_encode($data);
    }

    public function cancelTransaksiRuko(){
        $data['tipe'] = "ruko";
        $data['id'] = $this->input->post('id');
        $this->tenant->cancelOrder($data);
    }

    public function realisasi_pembayaran_tenant(){
        $this->_validate_pembayaran_tenant();
        $data = array(
            'id_ref_transaksi' => $this->input->post('id-transaksi'),
            'no_nota' => $this->input->post('no_nota'),
            'no_faktur' => $this->input->post('no_faktur'),
            'tgl_pembayaran' => date('Y-m-d H:i:s', time()),
            'issued_at' => date("Y-m-d H:i:s",time()),
            'issued_by' => $this->session->userdata('nama')
        );
        $this->tenant->update_pembayaran_tenant($this->input->post('id-transaksi'), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function pembayaran_tenant($id) {
        $data = $this->tenant->get_by_id("tenant", $id);
        echo json_encode($data);
    }

    private function _validate_pembayaran_tenant() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('no_nota') == NULL)
        {
            $data['inputerror'][] = 'no_nota';
            $data['error_string'][] = 'Kolom No Nota Awal Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('no_faktur') == NULL)
        {
            $data['inputerror'][] = 'no_faktur';
            $data['error_string'][] = 'Kolom No Faktur Akhir Masih Kosong';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function cetakTagihan($id_transaksi,$id_flowmeter,$tgl_awal,$tgl_akhir){
        $row = $this->tenant->get_by_id("ruko",$id_flowmeter);
        $data['title'] = 'Tagihan Penggunaan Air Periode '.date('d-M-Y', strtotime($tgl_awal)).' s/d '.date('d-M-Y', strtotime($tgl_akhir)); //judul title

        if($row->id_ref_tenant != NULL){
            $data['tagihan'] = $this->tenant->getTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
            $data['data_tagihan'] = $this->tenant->getDataTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
            $data['detail_tagihan'] = $this->tenant->getDetailTagihan($id_flowmeter);
        } else{
            $data['tagihan'] = $this->tenant->getTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
            $data['data_tagihan'] = $this->tenant->getDataTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
            $data['detail_tagihan'] = $this->tenant->getDetailTagihan($id_flowmeter);
        }
        $this->load->view('tenant/v_cetaktagihan', $data);

        $paper_size  = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();

        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("tagihan.pdf", array('Attachment'=>0));
    }

    public function cetakRealisasiPemakaian($id_transaksi,$id_flowmeter,$tgl_awal,$tgl_akhir){
        $row = $this->tenant->get_by_id("ruko",$id_flowmeter);
        $data['title'] = 'Realisasi Penggunaan Air Periode '.date('d-M-Y', strtotime($tgl_awal)).' s/d '.date('d-M-Y', strtotime($tgl_akhir)); //judul title

        $data['tanggal'] = $this->indonesian_date("l, d F Y",time());
        $data['tgl'] = $this->indonesian_date("d F Y",time());
        if($row->id_ref_tenant != NULL){
            $data['tagihan'] = $this->tenant->getTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
            $data['data_tagihan'] = $this->tenant->getDataTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
            $data['detail_tagihan'] = $this->tenant->getDetailTagihan($id_flowmeter);
        } else{
            $data['tagihan'] = $this->tenant->getTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
            $data['data_tagihan'] = $this->tenant->getDataTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
            $data['detail_tagihan'] = $this->tenant->getDetailTagihan($id_flowmeter);
        }
        $this->load->view('tenant/v_realisasi_pemakaian_tenant', $data);

        $paper_size  = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();

        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("tagihan.pdf", array('Attachment'=>0));
    }

    public function tagihan_ruko() {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $id_flowmeter = $this->input->post('id');
        $no = 1;
        $data = $this->tenant->getTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
        $data_tagihan = $this->tenant->getDataTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
        $tabel = '';

        if($data_tagihan != NULL){
            if($data != NULL) {
                if ($data_tagihan->id_ref_tenant == NULL) {
                    $tabel = '
                    <div class="col-sm-7">
                    <table class="table table-responsive table-condensed table-striped">
                        <tr>
                            <td>Nama Tenant</td>
                            <td>:</td>
                            <td>' . $data_tagihan->nama_tenant . '</td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td>:</td>
                            <td>' . $data_tagihan->lokasi . '</td>
                        </tr>
                        <tr>
                            <td>No Telepon</td>
                            <td>:</td>
                            <td>' . $data_tagihan->no_telp . '</td>
                        </tr>
                        <tr>
                            <td>Penanggung Jawab</td>
                            <td>:</td>
                            <td>' . $data_tagihan->penanggung_jawab . '</td>
                        </tr>
                    </table></div>';
                    $tabel .= '
                <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <td>No</td>
                        <td>Tanggal Pencatatan</td>
                        <td>Flow Meter</td>
                    </thead>
                    ';
                        foreach ($data as $row) {
                            $tabel .= '
                    <tr>
                    <td>' . $no . '</td>
                    <td>' . $row->waktu_perekaman . '</td>
                    <td>' . $row->flow_hari_ini . '</td>
                    </tr>';
                        $no++;
                    }
                    $tabel .= '</table>';
    
                    $data = array(
                        'status' => 'success',
                        'tabel' => $tabel,
                        'url' => '<a class="btn btn-primary" target="_self" href=' . base_url('tenant/buatTagihan/') . $id_flowmeter . "/" . $tgl_awal . "/" . $tgl_akhir . '>Realisasi Pemakaian</a>'
                    );
                }
                else {
                    $tabel = '
                    <div class="col-sm-7">
                    <table class="table table-responsive table-condensed table-striped">
                        <tr>
                            <td>Nama Tenant</td>
                            <td>:</td>
                            <td>' . $data_tagihan->nama_tenant . '</td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td>:</td>
                            <td>' . $data_tagihan->lokasi . '</td>
                        </tr>
                        <tr>
                            <td>No Telepon</td>
                            <td>:</td>
                            <td>' . $data_tagihan->no_telp . '</td>
                        </tr>
                        <tr>
                            <td>Penanggung Jawab</td>
                            <td>:</td>
                            <td>' . $data_tagihan->penanggung_jawab . '</td>
                        </tr>
                    </table></div>';
                    $tabel .= '
                <table class="table table-responsive table-condensed table-striped">
                    <tr>
                        <td>No Perjanjian</td>
                        <td>:</td>
                        <td>' . $data_tagihan->no_perjanjian . '</td>
                    </tr>
                    <tr>    
                        <td>Perihal</td>
                        <td>:</td>
                        <td>' . $data_tagihan->perihal . '</td>
                    </tr>
                    <tr>    
                        <td>Waktu Kadaluarsa</td>
                        <td>:</td>
                        <td>' . $data_tagihan->waktu_kadaluarsa . '</td>
                    </tr>
                    <tr>    
                        <td>Nominal</td>
                        <td>:</td>
                        <td>Rp. ' . $this->Ribuan($data_tagihan->nominal) . '</td>
                    </tr>';
                    $tabel .= '</table>';
    
                    $data = array(
                        'status' => 'success',
                        'tabel' => $tabel,
                        'url' => '<a class="btn btn-primary" target="_self" href=' . base_url('tenant/buatTagihan/') . $id_flowmeter . "/" . $tgl_awal . "/" . $tgl_akhir . '>Realiasi Pemakaian</a>'
                    );
                }
            }else {
                $tabel = '
                    <div class="col-sm-7">
                    <table class="table table-responsive table-condensed table-striped">
                        <tr>
                            <td>Nama Tenant</td>
                            <td>:</td>
                            <td>' . $data_tagihan->nama_tenant . '</td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td>:</td>
                            <td>' . $data_tagihan->lokasi . '</td>
                        </tr>
                        <tr>
                            <td>No Telepon</td>
                            <td>:</td>
                            <td>' . $data_tagihan->no_telp . '</td>
                        </tr>
                        <tr>
                            <td>Penanggung Jawab</td>
                            <td>:</td>
                            <td>' . $data_tagihan->penanggung_jawab . '</td>
                        </tr>
                    </table></div>';
                $tabel .= '
                <table class="table table-responsive table-condensed table-striped">
                    <tr>
                        <td>No Perjanjian</td>
                        <td>:</td>
                        <td>' . $data_tagihan->no_perjanjian . '</td>
                    </tr>
                    <tr>    
                        <td>Perihal</td>
                        <td>:</td>
                        <td>' . $data_tagihan->perihal . '</td>
                    </tr>
                    <tr>    
                        <td>Waktu Kadaluarsa</td>
                        <td>:</td>
                        <td>' . $data_tagihan->waktu_kadaluarsa . '</td>
                    </tr>
                    <tr>    
                        <td>Nominal</td>
                        <td>:</td>
                        <td>Rp. ' . $this->Ribuan($data_tagihan->nominal) . '</td>
                    </tr>
                    ';
                $tabel .= '</table>';
    
                $data = array(
                    'status' => 'success',
                    'tabel' => $tabel,
                    'url' => '<a class="btn btn-primary" target="_self" href=' . base_url('tenant/buatTagihan/') . $id_flowmeter . "/" . $tgl_awal . "/" . $tgl_akhir . '>Realisasi Pemakaian</a>'
                );
            }
        }

        echo json_encode($data);
    }

    public function tagihan(){
        $id = $this->input->get('id');
        $data['data'] = $this->tenant->get_by_id("ruko",$id);
        $data['title'] = 'Tagihan Penggunaan';
        $this->load->template('tenant/v_tagihan_air_tenant',$data);
    }

    public function buatTagihan($id,$tgl_awal,$tgl_akhir){
        $total = 0;
        $ttl_awal = 0;
        $ttl_akhir = 0;
        $tarif = 0;
        $i = 1;
        
        $tagihan = $this->tenant->getTagihan($tgl_awal,$tgl_akhir,$id);
        $data_tagihan = $this->tenant->getDataTagihan($tgl_awal,$tgl_akhir,$id);
        $invoice = $this->data->get_no_invoice();
        $tgl_tahun = date("YYYY",time());
        $bulan = date("m",time());

        $data_tenant = $this->tenant->getDataTenant($id);
        $data_tarif = $this->master->getDataTarif($data_tenant->pengguna_jasa_id);

        if($invoice != NULL ){
            $tahun = substr($tgl_tahun, 2, 2);
            $no_tahun = sprintf("%02s",$tahun);
            $no = (int) $invoice;
            if($no < 99999){
                $no++;
            }
            else{
                $no = 1;
            }
            $no_invoice = $no_tahun.".".$bulan.".".sprintf("%02s", $id).".".sprintf("%03s", $no);
            $this->data->setNoInvoice($no);
        }
        else{
            $tahun = substr($tgl_tahun, 2, 2);
            $no_tahun = sprintf("%02s",$tahun);
            $no = 1;
            $no_invoice = $no_tahun.".".$bulan.".".sprintf("%02s", $id).".".sprintf("%03s", $no);
            $this->data->setNoInvoice($no);
        }

        if($tagihan != NULL) {
            foreach ($tagihan as $row) {
                if ($i == 1 && $row->flow_hari_ini != NULL) {
                    $ttl_awal = $row->flow_hari_ini;
                } else {
                    if ($ttl_awal == 0) {
                        $ttl_awal = $row->flow_hari_ini;
                    }
                }

                if ($i == count($tagihan) && $row->flow_hari_ini != NULL) {
                    $ttl_akhir = $row->flow_hari_ini;
                }
                $i++;
            }

            $ton_total = $ttl_akhir - $ttl_awal;
            $tarif = $data_tarif->tarif;
            $diskon = $data_tarif->diskon;
        }else{
            $ton_total = 0;
        }

        if($data_tagihan->diskon != NULL){
            $total = $ton_total * ($data_tagihan->tarif - ($data_tagihan->tarif * $data_tagihan->diskon/100));
        }
        else{
            $total = $ton_total * $data_tagihan->tarif;
        }

        if($data_tagihan->id_ref_tenant != NULL){
            $diskon = '';
            $date = date('Y-m-d');
            if($date <= $data_tagihan->waktu_kadaluarsa ){
                $total = $data_tagihan->nominal;
                $tarif = $total;
            }
        }

        if($total >= 249999 && $total < 999999){
            $materai = 3000;
            $total = $total + $materai;
        } else if($total >= 999999){
            $materai = 6000;
            $total = $total + $materai;
        } else {
            $materai = 0;
            $total = $total + $materai;
        }

        $data = array(
            'id' => $id,
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'total_pakai' => $ton_total,
            'tarif' => $tarif,
            'diskon' => $diskon,
            'total_bayar' => $total,
            'no_invoice' => $no_invoice,
            'issued_by' => $this->session->userdata('nama'),
            'issued_at' => date("Y-m-d H:i:s",time()),
        );

        $result = $this->tenant->tagihanTenant($data);

        if($result != NULL){
            $web = base_url('main/tenant/penagihan_air_tenant');
            echo "<script type='text/javascript'>
                    alert('Tagihan Berhasil Dibuat')
                    window.location.replace('$web')
                    </script>";
        }
    }

    public function updatePerekaman($tipe){
        //$tipe = $this->input->post('action');

        if($tipe == 'batal'){
            $result = $this->tenant->setPerekaman($tipe);

            if($result){	//jika data berhasil dihapus
                $message = array("status" => TRUE,"info" => "Pembatalan data sukses");
            }else{		//jika gagal menghapus data
                $message = array("status" => FALSE,"info" => "Pembatalan data gagal");
            }
        }
        else{
            $result = $this->tenant->setPerekaman($tipe);

            if($result){	//jika data berhasil dihapus
                $message = array("status" => TRUE,"info" => "Validasi data sukses");            
            }else{		//jika gagal menghapus data
                $message = array("status" => FALSE,"info" => "Validasi data gagal");
            }
        }

        echo json_encode($message);
    }

    public function updatePencatatan($tipe){
        //$tipe = $this->input->post('action');

        if($tipe == 'batal'){
            $result = $this->tenant->setPencatatan($tipe);

            if($result){	//jika data berhasil dihapus
                $message = array("status" => TRUE,"info" => "Pembatalan data sukses");
            }else{		//jika gagal menghapus data
                $message = array("status" => FALSE,"info" => "Pembatalan data gagal");
            }
        }
        else{
            $result = $this->tenant->setPencatatan($tipe);

            if($result){	//jika data berhasil dihapus
                $message = array("status" => TRUE,"info" => "Validasi data sukses");            
            }else{		//jika gagal menghapus data
                $message = array("status" => FALSE,"info" => "Validasi data gagal");
            }
        }

        echo json_encode($message);
    }

    public function updatePencatatanTandon($tipe){
        //$tipe = $this->input->post('action');

        if($tipe == 'batal'){
            $result = $this->tenant->setPencatatanTandon($tipe);

            if($result){	//jika data berhasil dihapus
                $message = array("status" => TRUE,"info" => "Pembatalan data sukses");
            }else{		//jika gagal menghapus data
                $message = array("status" => FALSE,"info" => "Pembatalan data gagal");
            }
        }
        else{
            $result = $this->tenant->setPencatatanTandon($tipe);

            if($result){	//jika data berhasil dihapus
                $message = array("status" => TRUE,"info" => "Validasi data sukses");            
            }else{		//jika gagal menghapus data
                $message = array("status" => FALSE,"info" => "Validasi data gagal");
            }
        }

        echo json_encode($message);
    }

    public function riwayat_catat_flow(){
        $data = array();
        $result = $this->tenant->riwayat_flow()->result();
        $recordFiltered = $this->tenant->riwayat_flow()->num_rows();
        $recordTotal = $this->tenant->riwayat_flow()->num_rows();
        $no = $_POST['start'];
        
        foreach ($result as $r){
            $no++;
            $row = array();
            $row[] = '<center>'.$no;
            $row[] = '<center>'.$r->id_flowmeter;
            $row[] = '<center>'.$r->nama_flowmeter;
            $row[] = '<center>'.$r->waktu_perekaman;
            $row[] = '<center>'.$r->flow_hari_ini;
            $row[] = '<center>'.$r->pembuat;
            $row[] = '<center><input class="checkbox" type="checkbox" name="cek[]" value="'.$r->id_transaksi.'"/>
            <input type="hidden" name="flow[]" value="'.$r->flow_hari_ini.'"/>
            <input type="hidden" name="id[]" value="'.$r->id_flow.'"/>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $recordTotal,
            "recordsFiltered" => $recordFiltered,
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function riwayat_catat_tandon(){
        $data = array();
        $result = $this->tenant->riwayat_tandon()->result();
        $recordFiltered = $this->tenant->riwayat_tandon()->num_rows();
        $recordTotal = $this->tenant->riwayat_tandon()->num_rows();
        $no = $_POST['start'];
        
        foreach ($result as $r){
            $no++;
            $row = array();
            $row[] = '<center>'.$no;
            $row[] = '<center>'.$r->nama_tandon;
            $row[] = '<center>'.$r->lokasi;
            $row[] = '<center>'.$r->waktu_perekaman;
            $row[] = '<center>'.$r->total_pengisian;
            $row[] = '<center>'.$r->issued_by;
            $row[] = '<center><input class="checkbox" type="checkbox" name="cek[]" value="'.$r->id_transaksi.'"/>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $recordTotal,
            "recordsFiltered" => $recordFiltered,
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function riwayat_catat_sumur(){
        $data = array();
        $result = $this->tenant->riwayat_sumur()->result();
        $recordFiltered = $this->tenant->riwayat_sumur()->num_rows();
        $recordTotal = $this->tenant->riwayat_sumur()->num_rows();
        $no = $_POST['start'];

        foreach ($result as $r){
            $no++;
            $row = array();
            $total_penggunaan = $r->flow_sumur_akhir - $r->flow_sumur_awal;

            $row[] = '<center>'.$no;
            $row[] = '<center>'.$r->id_sumur;
            $row[] = '<center>'.$r->nama_sumur;
            $row[] = '<center>'.$r->nama_pompa;
            $row[] = '<center>'.$r->nama_flowmeter;
            $row[] = '<center>'.$r->waktu_rekam_awal;
            $row[] = '<center>'.$r->cuaca_awal;
            $row[] = '<center>'.$r->debit_air_awal;
            $row[] = '<center>'.$r->flow_sumur_awal;
            $row[] = '<center>'.$r->waktu_rekam_akhir;
            $row[] = '<center>'.$r->cuaca_akhir;
            $row[] = '<center>'.$r->debit_air_akhir;
            $row[] = '<center>'.$r->flow_sumur_akhir;
            $row[] = '<center>'.$this->Koma($total_penggunaan);
            $row[] = '<center>'.$r->pembuat;
            $row[] = '<center><input class="checkbox" type="checkbox" name="cek[]" value="'.$r->id_pencatatan.'"/>
                    <input type="hidden" name="flow[]" value="'.$r->flow_sumur_akhir.'"/>
                    <input type="hidden" name="id[]" value="'.$r->id_flow.'"/>';
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $recordTotal,
            "recordsFiltered" => $recordFiltered,
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function populateSumur(){
        $data = $this->tenant->getIdFlowmeter();
        echo json_encode($data);
    }
}

?>