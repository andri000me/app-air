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

        if($query == TRUE){
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
        $id_tenant = $this->input->post('id_tenant');
        $id_flow = $this->input->post('id_flow');
        $tanggal = $this->input->post('tanggal');
        $tonnase = $this->input->post('flow_hari_ini');
        $this->form_validation->set_rules('id_flowmeter', 'ID Flowmeter', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('flow_hari_ini', 'Flow Meter Hari Ini', 'required|callback_check_equal_less['.$this->input->post('flowmeter_akhir').']');

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

        if ($this->form_validation->run() == FALSE) {
            $data['title']='APASIH KKT';
            $this->load->template('tenant/v_pencatatan_flow_harian',$data);
        }
        else {
            if($cekFlow == TRUE){
                $this->tenant->inputFlowAwal($data_flow);
                $result = $this->tenant->input_transaksi("ruko",$data_transaksi);
            } else{
                $result = $this->tenant->input_transaksi("ruko",$data_transaksi);
            }

            if($result == TRUE){
                $web = base_url('main/tenant/pencatatan_flow_harian');
                echo "<script type='text/javascript'>
                    alert('Permintaan Berhasil Di Input')
                    window.location.replace('$web')
                    </script>";
            }
            else{
                $web = base_url('main/tenant/pencatatan_flow_harian');
                echo "<script type='text/javascript'>
                    alert('Permintaan Gagal Di Input ! Coba Lagi')
                    window.location.replace('$web')
                    </script>";
            }
        }
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

        $this->form_validation->set_rules('id_master_sumur_awal', 'Nama Sumur', 'required');
        $this->form_validation->set_rules('tanggal_awal', 'Tanggal', 'required');
        $this->form_validation->set_rules('flow_hari_ini_awal', 'Flow Meter Awal', 'required');
        $this->form_validation->set_rules('tanggal_akhir', 'Tanggal', 'required');
        $this->form_validation->set_rules('flow_hari_ini_akhir', 'Flow Meter Akhir', 'required');
        $this->form_validation->set_rules('cuaca_awal', 'Kondisi Cuaca', 'required');
        $this->form_validation->set_rules('cuaca_akhir', 'Kondisi Cuaca', 'required');

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

        if ($this->form_validation->run() == FALSE) {
            $data['title']='Aplikasi Pelayanan Jasa Air Bersih';
            $this->load->template('tenant/v_pencatatan_sumur_harian',$data);
        }
        else {
            if($cekFlow == TRUE){
                $this->tenant->inputFlowAwal($data_flow);
                $result = $this->tenant->input_transaksi("sumur",$data_transaksi);
            } else{
                $result = $this->tenant->input_transaksi("sumur",$data_transaksi);
            }

            if($result == TRUE){
                $web = base_url('main/tenant/pencatatan_sumur_harian');
                echo "<script type='text/javascript'>
                    alert('Permintaan Berhasil Di Input')
                    window.location.replace('$web')
                    </script>";
            }
            else{
                $web = base_url('main/tenant/pencatatan_sumur_harian');
                echo "<script type='text/javascript'>
                    alert('Permintaan Gagal Di Input ! Coba Lagi')
                    window.location.replace('$web')
                    </script>";
            }
        }
    }

    public function tabel_tagihan_tenant(){
        if($this->session->userdata('role_name')== 'operasi' || $this->session->userdata('role_name')== 'admin'){
            $result = $this->tenant->get_tabel_transaksi();
            $data = array();
            $no = 1;

            foreach ($result as $row){
                if($this->session->userdata('role_name') == 'operasi' || $this->session->userdata('role_name')== 'admin' || $tipe == "ruko_admin"){
                    $aksi = '<span class=""><a class="btn btn-primary glyphicon glyphicon-list-alt" title="Cetak Tagihan" target="_blank" href="'.base_url("tenant/cetakTagihan/".$row->id_transaksi."/".$row->id_flow."/".$row->tgl_awal."/"."$row->tgl_akhir").'"> </a></span>';
                    $aksi .= '<br><br><a class="btn btn-danger glyphicon glyphicon-remove" title="Batal Invoice" href="javascript:void(0)" onclick="batal('."'".$row->id_transaksi."'".');"></a>';
                } else{
                    $aksi = '<span class=""><a class="btn btn-primary glyphicon glyphicon-list-alt" title="Realisasi Pembayaran" href="javascript:void(0)" onclick="realisasi('."'".$row->id_transaksi."'".');"> </a></span>';
                }

                if($row->no_perjanjian == NULL){
                    $row->no_perjanjian = "";
                }
                $tarif = '';

                if($row->diskon != NULL || $row->diskon != ''){
                    $tarif = $row->$tarif - ($row->tarif * $row->diskon / 100);
                } else{
                    $tarif = $row->$tarif;
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

    public function tagihan_ruko() {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $id_flowmeter = $this->input->post('id');
        $no = 1;
        $data = $this->tenant->getTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
        $data_tagihan = $this->tenant->getDataTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
        $tabel = '';

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
                    'url' => '<a class="btn btn-primary" target="_self" href=' . base_url('tenant/buatTagihan/') . $id_flowmeter . "/" . $tgl_awal . "/" . $tgl_akhir . '>Buat Tagihan</a>'
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
                </tr>
              ';
                $tabel .= '</table>';

                $data = array(
                    'status' => 'success',
                    'tabel' => $tabel,
                    'url' => '<a class="btn btn-primary" target="_self" href=' . base_url('tenant/buatTagihan/') . $id_flowmeter . "/" . $tgl_awal . "/" . $tgl_akhir . '>Buat Tagihan</a>'
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
                'url' => '<a class="btn btn-primary" target="_self" href=' . base_url('tenant/buatTagihan/') . $id_flowmeter . "/" . $tgl_awal . "/" . $tgl_akhir . '>Buat Tagihan</a>'
            );
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

    public function updatePerekaman(){
        $tipe = $this->input->post('action');

        if($tipe == 'batal'){
            $result = $this->tenant->setPerekaman($tipe);

            if($result){	//jika data berhasil dihapus
                echo '<script language="javascript">alert("Berhasil Membatalkan Data"); document.location="'.base_url("main/tenant/riwayat_catat_flow").'";</script>';
            }else{		//jika gagal menghapus data
                echo '<script language="javascript">alert("Gagal Membatalkan Data"); document.location="'.base_url("main/tenant/riwayat_catat_flow").'";</script>';
            }
        }
        else{
            $result = $this->tenant->setPerekaman($tipe);

            if($result){	//jika data berhasil dihapus
                echo '<script language="javascript">alert("Berhasil Memvalidasi Data"); document.location="'.base_url("main/tenant/riwayat_catat_flow").'";</script>';
            }else{		//jika gagal menghapus data
                echo '<script language="javascript">alert("Gagal Memvalidasi Data"); document.location="'.base_url("main/tenant/riwayat_catat_flow").'";</script>';
            }
        }
    }

    public function updatePencatatan(){
        $tipe = $this->input->post('action');

        if($tipe == 'batal'){
            $result = $this->tenant->setPencatatan($tipe);

            if($result){	//jika data berhasil dihapus
                echo '<script language="javascript">alert("Berhasil Membatalkan Data"); document.location="'.base_url("main/tenant/riwayat_catat_sumur").'";</script>';
            }else{		//jika gagal menghapus data
                echo '<script language="javascript">alert("Gagal Membatalkan Data"); document.location="'.base_url("main/tenant/riwayat_catat_sumur").'";</script>';
            }
        }
        else{
            $result = $this->tenant->setPencatatan($tipe);

            if($result){	//jika data berhasil dihapus
                echo '<script language="javascript">alert("Berhasil Memvalidasi Data"); document.location="'.base_url("main/tenant/riwayat_catat_sumur").'";</script>';
            }else{		//jika gagal menghapus data
                echo '<script language="javascript">alert("Gagal Memvalidasi Data"); document.location="'.base_url("main/tenant/riwayat_catat_sumur").'";</script>';
            }
        }
    }

    public function riwayat_catat_flow(){
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $result = $this->tenant->riwayat_flow($tgl_awal,$tgl_akhir);

        if($result != NULL){
            $no = 1;
            $tabel = '
                <h4>Riwayat Pencatatan Harian Periode '.date('d-m-Y',strtotime($tgl_awal)).' s/d '.date('d-m-Y',strtotime($tgl_akhir)).' </h4>
                <form action="'.base_url('tenant/updatePerekaman').'" method="post">
                <table class="table table-responsive table-condensed table-striped" id="myTable">
                    <thead>
                        <tr>
                            <td>
                                <select class="form-control" name="action">
                                    <option value="valid">Validasi</option>
                                    <option value="batal">Batal</option>
                                </select>
                            </td>
                            <td><input class="btn btn-info" type="submit" value="Eksekusi"></td>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>ID Flow Meter</th>
                            <th>Nama Flow Meter</th>
                            <th>Tanggal Perekaman</th>
                            <th>Flow Meter</th>
                            <th>Issued By</th>
                            <th><center>Check Box</center></th>
                        </tr>      
                    </thead>
                    <tbody>';

            foreach ($result as $row){
                $tabel .= '
                    <tr>
                        <td>'.$no.'</td>
                        <td>'.$row->id_flowmeter.'</td>
                        <td>'.$row->nama_flowmeter.'</td>
                        <td>'.$row->waktu_perekaman.'</td>
                        <td>'.$row->flow_hari_ini.'</td>
                        <td>'.$row->pembuat.'</td>
                        <td align="center">
                            <input type="checkbox" name="cek[]" value="'.$row->id_transaksi.'"/>
                            <input type="hidden" name="flow[]" value="'.$row->flow_hari_ini.'"/>
                            <input type="hidden" name="id[]" value="'.$row->id_flow.'"/>
                        </td>
                    </tr>
                ';
                $no++;
            }

            $tabel .= '
                        </tbody>
                    </table>
                    </form>';

            $data = array(
                'status' => 'success',
                'tabel' => $tabel,
            );
        } else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function riwayat_catat_sumur(){
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $result = $this->tenant->riwayat_sumur($tgl_awal,$tgl_akhir);

        if($result != NULL){
            $no = 1;
            $tabel = '
                <h4>Riwayat Pencatatan Harian Periode '.date('d-m-Y',strtotime($tgl_awal)).' s/d '.date('d-m-Y',strtotime($tgl_akhir)).' </h4>
                <form action="'.base_url('tenant/updatePencatatan').'" method="post">
                <table class="table table-responsive table-condensed table-striped" id="myTable">
                    <thead>
                        <tr>
                            <td colspan="3">
                                <select class="form-control" name="action">
                                    <option value="valid">Validasi</option>
                                    <option value="batal">Batal</option>
                                </select>
                            </td>
                            <td><input class="btn btn-info" type="submit" value="Eksekusi"></td>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>ID Sumur</th>
                            <th>Nama Sumur</th>
                            <th>Nama Pompa</th>
                            <th>Nama Flow Meter</th>
                            <th>Waktu Perekaman Awal</th>
                            <th>Cuaca</th>
                            <th>Debit Air</th>
                            <th>Nilai Flow Awal</th>
                            <th>Waktu Perekaman Akhir</th>
                            <th>Cuaca</th>
                            <th>Debit Air</th>
                            <th>Nilai Flow Akhir</th>
                            <th>Total Penggunaan</th>
                            <th>Issued By</th>
                            <th><center>Check Box</center></th>
                        </tr>      
                    </thead>
                    <tbody>';

            foreach ($result as $row){
                $total_penggunaan = $row->flow_sumur_akhir - $row->flow_sumur_awal;
                $tabel .= '
                    <tr>
                        <td>'.$no.'</td>
                        <td>'.$row->id_sumur.'</td>
                        <td>'.$row->nama_sumur.'</td>
                        <td>'.$row->nama_pompa.'</td>
                        <td>'.$row->nama_flowmeter.'</td>
                        <td>'.$row->waktu_rekam_awal.'</td>
                        <td>'.$row->cuaca_awal.'</td>
                        <td>'.$row->debit_air_awal.'</td>
                        <td>'.$row->flow_sumur_awal.'</td>
                        <td>'.$row->waktu_rekam_akhir.'</td>
                        <td>'.$row->cuaca_akhir.'</td>
                        <td>'.$row->debit_air_akhir.'</td>
                        <td>'.$row->flow_sumur_akhir.'</td>
                        <td>'.$this->Koma($total_penggunaan).'</td>
                        <td>'.$row->pembuat.'</td>
                        <td align="center">
                            <input type="checkbox" name="cek[]" value="'.$row->id_pencatatan.'"/>
                            <input type="hidden" name="flow[]" value="'.$row->flow_sumur_akhir.'"/>
                            <input type="hidden" name="id[]" value="'.$row->id_flow.'"/>
                        </td>
                    </tr>
                    ';
                $no++;
            }

            $tabel .= '
                        </tbody>
                    </table>
                    </form>
                ';

            $data = array(
                'status' => 'success',
                'tabel' => $tabel,
            );
        } else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }
}

?>