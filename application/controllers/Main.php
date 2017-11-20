<?php
date_default_timezone_set('Asia/Makassar');
  class Main extends CI_Controller {
      public function __construct() {
          parent::__construct();
          $this->load->model('data'); //load model data yang berada di folder model
          $this->load->helper(array('url','form')); //load helper
          $this->load->library(array('form_validation','session','fpdf','dompdf_gen','Excel/PHPExcel','pagination'));
      }

      public function index() {
          $data['title']='PT KKT APP-AIR';
          $this->load->template('v_main_bak',$data);
      }

      //fungsi untuk pergantian view
      public function view() {
          $page = $_GET['id'];

          if($page == "darat"){
              $data['title'] = "Transaksi Darat";
              $data['pengguna'] = $this->data->get_pengguna("darat",$page);
              $this->load->template('v_input_darat',$data);
          }
          else if($page == "main_loket"){
              $data['title'] = "Dafter Permohonan";
              $this->load->template('v_main_loket',$data);
          }
          else if($page == "main_keuangan"){
              $data['title'] = "Dafter Tagihan Air Kapal";
              $this->load->template('v_main_keuangan',$data);
          }
          else if($page == "main_wtp"){
              $data['title'] = "Dafter Status Pengisian Kapal";
              $this->load->template('v_main_wtp',$data);
          }
          else if($page == "main_operasi"){
              $data['title'] = "Dafter Status Tagihan Air Kapal";
              $this->load->template('v_main_operasi',$data);
          }
          else if($page == "main_perencanaan"){
              $data['title'] = "Dafter Status Pelayanan Air Kapal";
              $this->load->template('v_main_perencanaan',$data);
          }
          else if($page == "laut"){
              $data['title'] = "Transaksi Laut";
              $data['pengguna'] = $this->data->get_pengguna("laut",$page);
              $this->load->template('v_input_laut',$data);
          }
          else if($page == "transaksi_darat"){
              $data['title'] = "Laporan Transaksi Darat";
              $this->load->template('v_laporan_transaksi_darat',$data);
          }
          else if($page == "transaksi_laut"){
              $data['title'] = "Laporan Transaksi Laut";
              $this->load->template('v_laporan_transaksi_laut',$data);
          }
          else if($page == "transaksi_ruko"){
              $data['title'] = "Laporan Transaksi Ruko";
              $this->load->template('v_laporan_transaksi_ruko',$data);
          }
          else if($page == "validasi_pembayaran_darat"){
              $data['title'] = "Validasi Pembayaran Air Darat";
              $data['pengguna'] = $this->data->get_pengguna("darat","darat");
              $this->load->template('v_validasi_pembayaran_darat',$data);
          }
          else if($page == "cancel_pembayaran_darat"){
              $data['title'] = "Pembatalan Pembayaran Air Darat";
              $data['pengguna'] = $this->data->get_pengguna("darat","darat");
              $this->load->template('v_batal_pembayaran_darat',$data);
          }
          else if($page == "cetak_laporan_darat"){
              $data['title'] = 'Laporan Pendapatan Air Darat'; //judul title
              $data['tipe'] = "darat";
              $this->load->template('v_laporan',$data);
          }
          else if($page == "cetak_laporan_laut"){
              $data['title'] = 'Laporan Pendapatan Air Kapal'; //judul title
              $data['tipe'] = "laut";
              $this->load->template('v_laporan',$data);
          }
          else if($page == "cetak_laporan_ruko"){
              $data['title'] = 'Laporan Pendapatan Air Ruko'; //judul title
              $data['tipe'] = "ruko";
              $this->load->template('v_laporan',$data);
          }
          else if($page == "cetak_laporan_flow"){
              $data['title'] = 'Laporan Pencatatan Flow Meter'; //judul title
              $data['tipe'] = "flow";
              $this->load->template('v_laporan',$data);
          }
          else if($page == "cetak_laporan_sumur"){
              $data['title'] = 'Laporan Pencatatan Sumur'; //judul title
              $data['tipe'] = "sumur";
              $this->load->template('v_laporan',$data);
          }
          else if($page == "monitoring_darat"){
              $data['title'] = 'Monitoring Layanan Jasa Air Darat'; //judul title
              $data['tipe'] = 'darat';
              $this->load->template('v_monitoring',$data);
          }
          else if($page == "monitoring_kapal"){
              $data['title'] = 'Monitoring Layanan Jasa Air Kapal'; //judul title
              $data['tipe'] = 'laut';
              $this->load->template('v_monitoring',$data);
          }
          else if($page == "tenant"){
              $data['title'] = 'Master Tenant'; //judul title
              if($this->session->userdata('role') == 'admin'){
                  $data['tenant'] = $this->data->getFlowmeter();
                  $this->load->template('v_tenant',$data);
              } else{
                  $data['tenant'] = $this->data->getLumpsum();
                  $this->load->template('v_tenant',$data);
              }
          }
          else if($page == "transaksi_tenant"){
              $data['title'] = 'Pencatatan Harian Tenant'; //judul title
              $this->load->template('v_input_ruko',$data);
          }
          else if($page == "flowmeter"){
              $data['title'] = 'Master Flow Meter'; //judul title
              $data['tenant'] = $this->data->getPompa();
              $this->load->template('v_flowmeter',$data);
          }
          else if($page == "sumur"){
              $data['title'] = 'Master Sumur'; //judul title
              $this->load->template('v_sumur',$data);
          }
          else if($page == "pompa"){
              $data['title'] = 'Master Pompa'; //judul title
              $data['tenant'] = $this->data->getIDSumur();
              $this->load->template('v_pompa',$data);
          }
          else if($page == "lumpsum"){
              $data['title'] = 'Master Lumpsum'; //judul title
              $data['lumpsum'] = $this->data->getIDTenant();
              $this->load->template('v_lumpsum',$data);
          }
          else if($page == "tagihan"){
              $data['title'] = 'Penagihan Ruko'; //judul title
              $this->load->template('v_tagihan',$data);
          }
          else if($page == "daftar_tagihan"){
              $data['title'] = 'Daftar Penagihan Ruko'; //judul title
              $this->load->template('v_tabel_penagihan',$data);
          }
          else if($page == "realisasi_pembayaran_darat"){
              $data['title'] = 'Realisasi Pembayaran Darat'; //judul title
              $this->load->template('v_realisasi_pembayaran_darat',$data);
          }
          else if($page == "realisasi_pembayaran_tenant"){
              $data['title'] = 'Realisasi Pembayaran Tenant'; //judul title
              $this->load->template('v_realisasi_pembayaran_tenant',$data);
          }
          else if($page == "riwayat_pencatatan_flow"){
              $data['title'] = 'Riwayat Pencatatan Flow Meter'; //judul title
              $this->load->template('v_riwayat_catat_flow',$data);
          }
          else if($page == "catat_sumur"){
              $data['title'] = 'Pencatatan Harian Sumur'; //judul title
              $this->load->template('v_pencatatan_sumur',$data);
          }
          else if($page == "riwayat_pencatatan_sumur"){
              $data['title'] = 'Riwayat Pencatatan Sumur'; //judul title
              $this->load->template('v_riwayat_catat_sumur',$data);
          }
          else{
              redirect('main');
          }

      }

      //fungsi untuk transaksi darat
      public function get_pembeli_darat() {
          $nama = $this->input->post('nama_pembeli',TRUE); //variabel kunci yang di bawa dari input text id kode
          $tipe = "darat";
          $query = $this->data->get_pembeli($tipe,$nama); //query model

          if($query == TRUE){
              $pelanggan = array();
              foreach ($query as $data) {
                  $pelanggan[]     = array(
                      'label'   => $data->nama_pengguna_jasa, //variabel array yg dibawa ke label ketikan kunci
                      'id'      => $data->id_pengguna_jasa,
                      'nama'    => $data->nama_pengguna_jasa , //variabel yg dibawa ke id nama
                      'alamat'  => $data->alamat, //variabel yang dibawa ke id alamat
                      'no_telp' => $data->no_telp, //variabel yang dibawa ke id no telp
                      'pengguna'=> $data->pengguna_jasa_id_tarif, //variabel yang dibawa ke id pengguna jasa
                  );
              }
          }

          echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
      }

      function check_equal_more($second_field,$first_field){
          if (  $second_field >= $first_field) {
              $this->form_validation->set_message('check_equal_more', 'Permintaan Tidak Boleh Lebih Dari Deposit');
              return false;
          }
          else {
              return true;
          }
      }

      public function transaksi_darat() {
          $result = NULL;
          $id_pengguna = $this->input->post('id_pengguna');
          $nama_pengguna = $this->input->post('nama_pembeli');
          $alamat = $this->input->post('alamat_pembeli');
          $no_telp = $this->input->post('no_telp');
          $pengguna = $this->input->post('pengguna');
          $nama_pemohon = $this->input->post('nama_pemohon');
          $tanggal = $this->input->post('tgl_permintaan');
          $tonnase = $this->input->post('tonnase');
          $pelunasan = $this->input->post('pelunasan');
          $data_tarif = $this->data->getDataTarif($pengguna);

          $this->form_validation->set_rules('nama_pembeli', 'Nama Pembeli', 'required');
          $this->form_validation->set_rules('alamat_pembeli', 'Alamat', 'required');
          $this->form_validation->set_rules('no_telp', 'No Telepon', 'required');
          $this->form_validation->set_rules('pengguna', 'Jenis Pengguna Jasa', 'required');
          $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required');
          $this->form_validation->set_rules('tgl_permintaan', 'Tanggal Permintaan', 'required');
          $this->form_validation->set_rules('tonnase', 'Total Pengisian', 'required');

          $kwitansi = $this->data->get_no_kwitansi();
          $tgl_tahun = date("YYYY",time());

            if ($this->form_validation->run() == FALSE) {
                $data['title']='Aplikasi Pelayanan Jasa Air Bersih';
                $data['pengguna'] = $this->data->get_pengguna("darat","darat");
                $this->load->template('v_input_darat',$data);
            }
            else {
                $cek_result = $this->data->cek_pengguna('darat',$nama_pengguna);
                $result = FALSE;

                if($kwitansi != NULL ){
                    $tahun = substr($tgl_tahun, 2, 2);
                    $no_tahun = sprintf("%02s",$tahun);
                    $no = (int) $kwitansi;
                    if($no < 99999){
                        $no++;
                    }
                    else{
                        $no = 1;
                    }
                    $no_pengguna = $this->data->get_no_pengguna($id_pengguna);
                    $no_kwitansi = $no_tahun.sprintf("%02s", $no_pengguna).sprintf("%05s", $no);
                    $this->data->setNoKwitansi($no);
                }
                else{
                    $tahun = substr($tgl_tahun, 2, 2);
                    $no_tahun = sprintf("%02s",$tahun);
                    $no = 1;
                    $no_pengguna = $this->data->get_no_pengguna($id_pengguna);
                    $no_kwitansi = $no_tahun.sprintf("%02s", $no_pengguna).sprintf("%05s", $no);
                    $this->data->setNoKwitansi($no);
                }

                $data_pengguna = array(
                    'nama_pengguna_jasa' => $nama_pengguna,
                    'alamat' => $alamat,
                    'no_telp' => $no_telp,
                    'pengguna_jasa_id_tarif' => $pengguna,
                    'issued_at' => date("Y-m-d H:i:s",time()),
                    'issued_by' => $this->session->userdata('username')
                );

                if($cek_result == FALSE){
                    $this->data->input_pengguna("darat",$data_pengguna);
                }
                else{
                    if($pelunasan == "cash"){
                        $data_transaksi = array(
                            'pembeli_darat_id_pengguna_jasa' => $id_pengguna,
                            'nama_pemohon'=> $nama_pemohon,
                            'tgl_transaksi' => date('Y-m-d H:i:s',time()),
                            'tgl_perm_pengantaran' => date('Y-m-d H:i:s',strtotime($tanggal)),
                            'total_permintaan' => $tonnase,
                            'no_kwitansi' => $no_kwitansi,
                            'tarif' => $data_tarif->tarif,
                            'diskon' => $data_tarif->diskon,
                            'issued_at' => date("Y-m-d H:i:s",time()),
                            'issued_by' => $this->session->userdata('username')
                        );
                    }
                    else {
                        $status_invoice = 1;
                        $data_transaksi = array(
                            'pembeli_darat_id_pengguna_jasa' => $id_pengguna,
                            'nama_pemohon'=> $nama_pemohon,
                            'tgl_transaksi' => date('Y-m-d H:i:s',time()),
                            'tgl_perm_pengantaran' => date('Y-m-d H:i:s',strtotime($tanggal)),
                            'total_permintaan' => $tonnase,
                            'no_kwitansi' => $no_kwitansi,
                            'tarif' => $data_tarif->tarif,
                            'diskon' => $data_tarif->diskon,
                            'status_invoice' => $status_invoice,
                            'issued_at' => date("Y-m-d H:i:s",time()),
                            'issued_by' => $this->session->userdata('username')
                        );
                    }
                    $result = $this->data->input_transaksi("darat",$data_transaksi);
                }

                if($result == FALSE){
                    $id = $this->data->getIDPengguna($nama_pengguna);

                    if($kwitansi != NULL ){
                        $tahun = substr($tgl_tahun, 2, 2);
                        $no_tahun = sprintf("%02s",$tahun);
                        $no = (int) $kwitansi;
                        if($no < 99999){
                            $no++;
                        }
                        else{
                            $no = 1;
                        }
                        $no_pengguna = $this->data->get_no_pengguna($id->id_pengguna_jasa);
                        $no_kwitansi = $no_tahun.sprintf("%02s", $no_pengguna).sprintf("%05s", $no);
                        $this->data->setNoKwitansi($no);
                    }
                    else{
                        $tahun = substr($tgl_tahun, 2, 2);
                        $no_tahun = sprintf("%02s",$tahun);
                        $no = 1;
                        $no_pengguna = $this->data->get_no_pengguna($id->id_pengguna_jasa);
                        $no_kwitansi = $no_tahun.sprintf("%02s", $no_pengguna).sprintf("%05s", $no);
                        $this->data->setNoKwitansi($no);
                    }

                    if($pelunasan == "cash"){
                        $data_transaksi = array(
                            'pembeli_darat_id_pengguna_jasa' => $id_pengguna,
                            'nama_pemohon'=> $nama_pemohon,
                            'tgl_transaksi' => date('Y-m-d H:i:s',time()),
                            'tgl_perm_pengantaran' => date('Y-m-d H:i:s',strtotime($tanggal)),
                            'total_permintaan' => $tonnase,
                            'no_kwitansi' => $no_kwitansi,
                            'tarif' => $data_tarif->tarif,
                            'diskon' => $data_tarif->diskon,
                            'issued_at' => date("Y-m-d H:i:s",time()),
                            'issued_by' => $this->session->userdata('username')
                        );
                    }
                    else {
                        $status_invoice = 1;
                        $data_transaksi = array(
                            'pembeli_darat_id_pengguna_jasa' => $id_pengguna,
                            'nama_pemohon'=> $nama_pemohon,
                            'tgl_transaksi' => date('Y-m-d H:i:s',time()),
                            'tgl_perm_pengantaran' => date('Y-m-d H:i:s',strtotime($tanggal)),
                            'total_permintaan' => $tonnase,
                            'no_kwitansi' => $no_kwitansi,
                            'tarif' => $data_tarif->tarif,
                            'diskon' => $data_tarif->diskon,
                            'status_invoice' => $status_invoice,
                            'issued_at' => date("Y-m-d H:i:s",time()),
                            'issued_by' => $this->session->userdata('username')
                        );
                    }

                    $this->db->select('*');
                    $this->db->from('pembeli_darat');
                    $this->db->where('nama_pengguna_jasa',$nama_pengguna);
                    $query = $this->db->get();
                    $result = $query->row();
                    $data_transaksi['pembeli_darat_id_pengguna_jasa'] = $result->id_pengguna_jasa;
                    $this->data->input_transaksi("darat",$data_transaksi);
                }
            }

            if($result == TRUE){
                if($this->session->userdata('role') == 'admin')
                    $web = base_url('main/view?id=main_loket');
                else
                    $web = base_url('main');
                echo "<script type='text/javascript'>
                        alert('Permintaan Berhasil Di Input')
                        window.location.replace('$web')
                      </script>";
                //redirect('main/view?id=v_laporan_transaksi_darat');
            }else{
                $web = base_url('main/view?id=darat');
                echo "<script type='text/javascript'>
                        alert('Permintaan Gagal Di Input ! Coba Lagi')
                       
                      </script>";
                //redirect('main/view?id=v_input_darat');
            }
      }

      //fungsi untuk transaksi laut
      public function get_pembeli_laut() {
          $nama = $this->input->post('nama_lct',TRUE); //variabel kunci yang di bawa dari input text id kode
          $tipe = "laut";
          $query = $this->data->get_pembeli($tipe,$nama); //query model

          if($query == TRUE){
              $pelanggan = array();
              foreach ($query as $data) {
                  $pelanggan[]     = array(
                      'label' => $data->nama_vessel, //variabel array yg dibawa ke label ketikan kunci
                      'id' => $data->id_pengguna_jasa,
                      'id_kapal' => $data->id_vessel,
                      'nama_lct' => $data->nama_vessel , //variabel yg dibawa ke id nama
                      'pengguna' => $data->pengguna_jasa_id_tarif,
                      'nama_perusahaan' => $data->nama_agent,
                      'alamat' => $data->alamat,
                      'no_telp' => $data->no_telp
                  );
              }
          }

          echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
      }

      public function get_agent() {
          $nama = $this->input->post('nama_perusahaan',TRUE); //variabel kunci yang di bawa dari input text id kode
          $tipe = "agent";
          $query = $this->data->get_pembeli($tipe,$nama); //query model

          if($query == TRUE){
              $pelanggan = array();
              foreach ($query as $data) {
                  $pelanggan[]     = array(
                      'label' => $data->nama_agent, //variabel array yg dibawa ke label ketikan kunci
                      'id_agent' => $data->id_agent,
                      'nama_perusahaan' => $data->nama_agent,
                      'alamat' => $data->alamat, //variabel yang dibawa ke id alamat
                      'no_telp' => $data->no_telp, //variabel yang dibawa ke id no telp
                  );
              }
          }

          echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
      }

      public function transaksi_laut() {
          $id_pengguna = $this->input->post('id_pengguna');
          $voy_no = $this->input->post('voy_no');
          $nama_pemohon = $this->input->post('nama_pemohon');
          $tanggal = $this->input->post('tanggal');
          $tonnase = $this->input->post('tonnase');
          $tipe_kapal = $this->input->post('tipe_kapal');

          $data_pengguna = $this->data->getDataPembeliLaut($id_pengguna);
          $data_tarif = $this->data->getDataTarif($data_pengguna->pengguna_jasa_id_tarif);
          $result = FALSE;

          $this->form_validation->set_rules('nama_lct', 'Nama VESSEL', 'required');
          $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required');
          $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
          $this->form_validation->set_rules('tonnase', 'Total Pengisian', 'required');

          $data_transaksi = array(
              'pembeli_laut_id_pengguna_jasa' => $id_pengguna,
              'voy_no' => $voy_no,
              'nama_pemohon' => $nama_pemohon,
              'tgl_transaksi' => date("Y-m-d H:i:s",time()),
              'waktu_pelayanan' => $tanggal,
              'tipe_kapal' => $tipe_kapal,
              'total_permintaan' => $tonnase,
              'tarif' => $data_tarif->tarif,
              'diskon' => $data_tarif->diskon,
              'issued_at' => date("Y-m-d H:i:s",time()),
              'issued_by' => $this->session->userdata('nama')
          );

          if ($this->form_validation->run() == FALSE) {
              $data['title']='Aplikasi Pelayanan Jasa Air Bersih';
              $data['pengguna'] = $this->data->get_pengguna("laut","laut");
              $this->load->template('v_input_laut',$data);
          }
          else {
              $result = $this->data->input_transaksi("laut",$data_transaksi);
          }

          if($result == TRUE){
              $web = base_url('main');
              echo "<script type='text/javascript'>
                        alert('Permintaan Berhasil Di Input')
                        window.location.replace('$web')
                      </script>";
          }else{
              $web = base_url('main/view?id=laut');
              echo "<script type='text/javascript'>
                        alert('Permintaan Gagal Di Input ! Coba Lagi')
                        window.location.replace('$web')
                      </script>";
          }
      }

      //fungsi untuk transaksi tenant
      public function get_tenant() {
          $nama = $this->input->post('id_flowmeter',TRUE); //variabel kunci yang di bawa dari input text id kode
          $tipe = "ruko";
          $query = $this->data->get_pembeli($tipe,$nama); //query model

          if($query == TRUE){
              $pelanggan = array();
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
          $nama = $this->input->post('nama_tenant',TRUE); //variabel kunci yang di bawa dari input text id kode
          $tipe = "ruko_tagihan";
          $query = $this->data->get_pembeli($tipe,$nama); //query model

          if($query == TRUE){
              $pelanggan = array();
              foreach ($query as $data) {
                  $pelanggan[] = array(
                      'id_flow' => $data->id_flow,
                      'id_tenant' => $data->id_tenant,
                      'nama_flow' => $data->nama_flowmeter,
                      'nama_tenant' => $data->nama_tenant,
                      'label' => $data->id_flowmeter, //variabel array yg dibawa ke label ketikan kunci
                  );
              }
          }

          echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
      }

      public function get_nama_flow() {
          $nama = $this->input->post('nama_tenant',TRUE); //variabel kunci yang di bawa dari input text id kode
          $tipe = "ruko";
          $query = $this->data->get_pembeli($tipe,$nama); //query model

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

      public function transaksi_ruko() {
          $id_tenant = $this->input->post('id_tenant');
          $id_flow = $this->input->post('id_flow');
          $tanggal = $this->input->post('tanggal');
          $tonnase = $this->input->post('flow_hari_ini');
          $this->form_validation->set_rules('id_flowmeter', 'ID Flowmeter', 'required');
          $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
          $this->form_validation->set_rules('flow_hari_ini', 'Flow Meter Hari Ini', 'required|callback_check_equal_less['.$this->input->post('flowmeter_akhir').']');

          $cekFlow = $this->data->cekFlowAwal($id_flow);

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
              $data['title']='Aplikasi Pelayanan Jasa Air Bersih';
              $this->load->template('v_input_ruko',$data);
          }
          else {
              if($cekFlow == TRUE){
                  $this->data->inputFlowAwal($data_flow);
                  $result = $this->data->input_transaksi("ruko",$data_transaksi);
              } else{
                  $result = $this->data->input_transaksi("ruko",$data_transaksi);
              }

              if($result == TRUE){
                  $web = base_url('main/view?id=transaksi_tenant');
                  echo "<script type='text/javascript'>
                        alert('Permintaan Berhasil Di Input')
                        window.location.replace('$web')
                      </script>";
              }
              else{
                  $web = base_url('main/view?id=transaksi_tenant');
                  echo "<script type='text/javascript'>
                        alert('Permintaan Gagal Di Input ! Coba Lagi')
                        window.location.replace('$web')
                      </script>";
              }
          }
      }

      //fungsi untuk pencatatan sumur
      public function get_sumur() {
          $nama = $this->input->post('id_sumur',TRUE); //variabel kunci yang di bawa dari input text id kode
          $tipe = "sumur";
          $query = $this->data->get_pembeli($tipe,$nama); //query model

          if($query == TRUE){
              $pelanggan = array();
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

          $cekFlow = $this->data->cekFlowAwal($id_flow);

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
              $this->load->template('v_pencatatan_sumur',$data);
          }
          else {
              if($cekFlow == TRUE){
                  $this->data->inputFlowAwal($data_flow);
                  $result = $this->data->input_transaksi("sumur",$data_transaksi);
              } else{
                  $result = $this->data->input_transaksi("sumur",$data_transaksi);
              }

              if($result == TRUE){
                  $web = base_url('main/view?id=catat_sumur');
                  echo "<script type='text/javascript'>
                        alert('Permintaan Berhasil Di Input')
                        window.location.replace('$web')
                      </script>";
              }
              else{
                  $web = base_url('main/view?id=catat_sumur');
                  echo "<script type='text/javascript'>
                        alert('Permintaan Gagal Di Input ! Coba Lagi')
                        window.location.replace('$web')
                      </script>";
              }
          }
      }

      //untuk membuat tampilan tabel status pembayaran transaksi kapal,darat dan ruko
      public function tabel_pembayaran(){
          $tipe = $this->input->get('id');

          if($tipe == "darat"){
              $result = $this->data->get_tabel_transaksi($tipe);
              $data = array();
              $no = 1;

              foreach ($result as $row){
                  $color = '';
                  $aksi = "";
                  if($row->diskon != NULL || $row->diskon != 0){
                      $row->tarif -= $row->diskon/100 * $row->tarif;
                      $total_pembayaran = $row->tarif * $row->total_permintaan;
                  }else{
                      $total_pembayaran = $row->tarif * $row->total_permintaan;
                  }

                  if($this->session->userdata('role') == 'loket' || $this->session->userdata('role') == 'admin'){
                      $aksi = '<a class="btn btn-primary glyphicon glyphicon-list-alt" title="Cetak Form Permintaan" target="_blank" href="'.base_url("main/cetakFPermintaan?id=".$row->id_transaksi."").'"></a>&nbsp;';
                  }

                  if($row->batal_nota == 1){
                      $aksi .= '<span class=""><a class="btn btn-danger glyphicon glyphicon-remove" title="batal kwitansi" target="_blank" href="javascript:void(0)" onclick="cancel_kwitansi('."'".$row->id_transaksi."'".');"> </a></span>';
                      $color = '#ff0000';
                  } else if($row->waktu_mulai_pengantaran == NULL || $row->waktu_selesai_pengantaran == NULL){
                      $aksi .= '<span class=""><a class="btn btn-primary glyphicon glyphicon-list-alt" title="cetak kwitansi" target="_blank" href="'.base_url("main/cetakKwitansi?id=".$row->id_transaksi."").'"> </a></span>';
                      $aksi .= '&nbsp;<span class=""><a class="btn btn-danger glyphicon glyphicon-remove" title="batal transaksi" href="javascript:void(0)" onclick="batal('."'".$row->id_transaksi."'".');"></a></span>';
                  } else{
                      $aksi = "";
                  }

                  if($row->waktu_mulai_pengantaran == NULL){
                      $row->waktu_mulai_pengantaran = "";
                  }

                  if($row->waktu_selesai_pengantaran == NULL){
                      $row->waktu_selesai_pengantaran = "";
                  }

                  if($row->tgl_perm_pengantaran == NULL){
                      $row->tgl_perm_pengantaran = "";
                  }

                  if($row->status_pembayaran == 0 && $row->batal_kwitansi == 0 && $row->status_invoice == 0){
                      $data[] = array(
                          'no' => $no,
                          'nama' => $row->nama_pengguna_jasa." / ".$row->nama_pemohon,
                          'tgl_transaksi' => $row->tgl_transaksi,
                          'tgl_permintaan' => $row->tgl_perm_pengantaran,
                          'jenis' => $row->tipe_pengguna_jasa,
                          'tarif' => $this->Ribuan($row->tarif),
                          'total_pengisian' => $row->total_permintaan,
                          'total_pembayaran' => $this->Ribuan($total_pembayaran),
                          'waktu_mulai_pengantaran' => date("H:i:s", strtotime($row->waktu_mulai_pengantaran)),
                          'waktu_selesai_pengantaran' => date("H:i:s", strtotime($row->waktu_selesai_pengantaran)),
                          'aksi' => $aksi,
                          'color' => $color
                      );
                      $no++;
                  }

              }
          }
          else{
              $result = $this->data->get_tabel_transaksi($tipe);
              $data = array();
              $baris = array();
              $no = 1;
              $warna = "";

              if($result != NULL){
                  foreach ($result as $row){
                      $aksi = "";
                      $flow_sebelum = "";
                      $flow_sesudah = "";

                      $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                      if($row->voy_no == NULL){
                          $row->voy_no = "";
                      }

                      if(($this->session->userdata('role') == "operasi" || $this->session->userdata('role') == "admin") && $tipe == "laut_operasi") {
                          if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL){
                              $aksi = '<a class="btn btn-primary glyphicon glyphicon-list-alt" target="_blank" href="'.base_url("main/cetakPerhitungan?id=".$row->id_transaksi."").'" title="Cetak Perhitungan" onclick="reload()"></a>';
                          }
                          else{
                              $aksi = '';
                          }

                          if($row->status_print == 1){
                              $warna = "#7FFF00";
                          }
                          else{
                              $warna = "";
                          }
                      }
                      else if($this->session->userdata('role') == "keuangan") {
                          if ($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL) {
                              $aksi = '<a class="btn btn-sm btn-primary glyphicon glyphicon-list-alt" href="javascript:void(0)" title="Realisasi Piutang" onclick="realisasi(' . "'" . $row->id_transaksi . "'" . ')"></a>';
                          } else {
                              $aksi = '';
                          }
                      }
                      else if($this->session->userdata('role') == "wtp" || ($this->session->userdata('role') == "admin" && $tipe == "laut")){
                          if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL) {
                              $aksi = '<a class="btn btn-primary glyphicon glyphicon-list-alt" target="_blank" href="' . base_url("main/cetakPengisian?id=" . $row->id_transaksi . "") . '" title="Cetak Form Pengisian"></a>&nbsp;';
                          }
                          else{
                              $aksi = '';
                          }
                      }
                      else if($this->session->userdata('role') == "admin" && $tipe == "laut_keuangan_admin"){
                          if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL){
                              $aksi = '&nbsp;<a class="btn btn-sm btn-primary glyphicon glyphicon-list-alt" href="javascript:void(0)" title="Realisasi Piutang" onclick="realisasi(' . "'" . $row->id_transaksi . "'" . ')"></a>';
                          } else{
                              $aksi = '';
                          }
                      }
                      else if($this->session->userdata('role') == "perencanaan" || ($this->session->userdata('role') == "admin" && $tipe == "laut_perencanaan")){
                          if($row->flowmeter_awal == NULL && $row->flowmeter_akhir == NULL)
                              $aksi = '<a class="btn btn-sm btn-danger glyphicon glyphicon-trash" href="javascript:void(0)" title="Batal Transaksi" onclick="batal(' . "'" . $row->id_transaksi . "'" . ')"></a>';
                          else
                              $aksi = "";
                      }

                      if($row->flowmeter_awal == NULL || $row->flowmeter_awal == '0'){
                          $flowmeter_awal = "0";
                      }
                      else{
                          $flowmeter_awal = $row->flowmeter_awal;
                      }

                      if($row->flowmeter_akhir == NULL || $row->flowmeter_akhir == '0'){
                          $flowmeter_akhir = "0";
                      }
                      else{
                          $flowmeter_akhir = $row->flowmeter_akhir;
                      }

                      if($row->flowmeter_awal_2 == NULL || $row->flowmeter_awal_2 == '0'){
                          $flowmeter_awal_2 = "0";
                      }
                      else{
                          $flowmeter_awal_2 = $row->flowmeter_awal_2;
                      }

                      if($row->flowmeter_akhir_2 == NULL || $row->flowmeter_akhir_2 == '0'){
                          $flowmeter_akhir_2 = "0";
                      }
                      else{
                          $flowmeter_akhir_2 = $row->flowmeter_akhir_2;
                      }

                      if($row->flowmeter_awal_3 == NULL || $row->flowmeter_awal_3 == '0'){
                          $flowmeter_awal_3 = "0";
                      }
                      else{
                          $flowmeter_awal_3 = $row->flowmeter_awal_3;
                      }

                      if($row->flowmeter_akhir_3 == NULL || $row->flowmeter_akhir_3 == '0'){
                          $flowmeter_akhir_3 = "0";
                      }
                      else{
                          $flowmeter_akhir_3 = $row->flowmeter_akhir_3;
                      }

                      if($row->flowmeter_awal_4 == NULL || $row->flowmeter_awal_4 == '0'){
                          $flowmeter_awal_4 = "0";
                      }
                      else{
                          $flowmeter_awal_4 = $row->flowmeter_awal_4;
                      }

                      if($row->flowmeter_akhir_4 == NULL || $row->flowmeter_akhir_4 == '0'){
                          $flowmeter_akhir_4 = "0";
                      }
                      else{
                          $flowmeter_akhir_4 = $row->flowmeter_akhir_4;
                      }

                      if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                          $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;
                          $flow_sebelum = $flowmeter_awal_4;
                          $flow_sesudah = $flowmeter_akhir_4;

                          if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                              $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                              $flow_sebelum .= " , ".$flowmeter_awal_3;
                              $flow_sesudah .= " , ".$flowmeter_akhir_3;

                              if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                  $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                              } else{
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir;
                              }
                          }
                          else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                              $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                              $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                          }
                          else {
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum .= " , ".$flowmeter_awal;
                              $flow_sesudah .= " , ".$flowmeter_akhir;
                          }
                      }
                      else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                          $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                          $flow_sebelum = $flowmeter_awal_3;
                          $flow_sesudah = $flowmeter_akhir_3;

                          if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                              $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                              $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                          } else {
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum .= " , ".$flowmeter_awal;
                              $flow_sesudah .= " , ".$flowmeter_akhir;
                          }
                      }
                      else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                          $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                          $flow_sebelum = $flowmeter_awal_2." , ".$flowmeter_awal;
                          $flow_sesudah = $flowmeter_akhir_2." , ".$flowmeter_akhir;
                      }
                      else{
                          $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                          $flow_sebelum = $flowmeter_awal;
                          $flow_sesudah = $flowmeter_akhir;
                      }


                      if($row->diskon != NULL || $row->diskon != 0){
                          $total = ($row->tarif * $realisasi) - (($row->diskon / 100) * ($row->tarif * $realisasi));
                          $tarif = $row->tarif - ($row->tarif * ($row->diskon / 100));
                      }
                      else{
                          $tarif = $row->tarif;
                          $total = $row->tarif * $realisasi;
                      }


                      if($total >= 250000 && $total <= 1000000){
                          $materai = 3000;
                          $total_bayar = $total + $materai;
                          $total_bayar = $this->Ribuan($total_bayar);
                      }
                      else if($total > 1000000){
                          $materai = 6000;
                          $total_bayar = $total + $materai;
                          $total_bayar = $this->Ribuan($total_bayar);
                      }
                      else {
                          $materai = 0;
                          $total_bayar = $total + $materai;
                          $total_bayar = $this->Ribuan($total_bayar);
                      }

                      if($row->status_invoice == 1){
                          if($this->session->userdata('role') == "keuangan"){
                              if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL) {
                                  $data[] = array(
                                      'no' => $no,
                                      'id_kapal' => $row->id_vessel,
                                      'nama_lct' => $row->nama_vessel,
                                      'voy_no' => $row->voy_no,
                                      'nama_perusahaan' => $row->nama_agent,
                                      'nama_pemohon' => $row->nama_pemohon,
                                      'tgl_transaksi' => $format_tgl,
                                      'total_permintaan' => $row->total_permintaan . " Ton",
                                      'flow_sebelum' => $flow_sebelum,
                                      'flow_sesudah' => $flow_sesudah,
                                      'realisasi' => $realisasi." Ton",
                                      'tarif' => $this->Ribuan($tarif),
                                      'pembayaran' => $total_bayar,
                                      'aksi' => $aksi,
                                  );
                                  $aksi = "";
                                  $no++;
                              }
                          }
                          else{
                              $data[] = array(
                                  'no' => $no,
                                  'id_kapal' => $row->id_vessel,
                                  'nama_lct' => $row->nama_vessel,
                                  'voy_no' => $row->voy_no,
                                  'nama_perusahaan' => $row->nama_agent,
                                  'nama_pemohon' => $row->nama_pemohon,
                                  'tgl_transaksi' => $format_tgl,
                                  'waktu_pelayanan' => $row->waktu_pelayanan,
                                  'total_permintaan' => $row->total_permintaan . " Ton",
                                  'flow_sebelum' => $flow_sebelum,
                                  'flow_sesudah' => $flow_sesudah,
                                  'tarif' => $this->Ribuan($tarif),
                                  'pembayaran' => $total_bayar,
                                  'realisasi' => $realisasi." Ton",
                                  'aksi' => $aksi,
                                  'warna' => $warna,
                              );
                              $aksi = "";
                              $no++;
                          }
                      }
                  }
              }
          }
          echo json_encode($data);
      }

      public function tabel_tagihan(){
          $result = $this->data->get_tabel_transaksi("darat");
          $data = array();
          $no = 1;
          $color = '';

          foreach ($result as $row){
              if($row->diskon != NULL || $row->diskon != 0){
                  $row->tarif -= $row->diskon/100 * $row->tarif;
                  $total_pembayaran = $row->tarif * $row->total_permintaan;
              }else{
                  $total_pembayaran = $row->tarif * $row->total_permintaan;
              }

              $aksi = '<span class=""><a class="btn btn-primary glyphicon glyphicon-list-alt" title="realisasi pembayaran" onclick="realisasi('."'".$row->id_transaksi."'".');" target="_self" href="javascript:void(0)"> </a></span>';

              if($row->waktu_mulai_pengantaran == NULL){
                  $row->waktu_mulai_pengantaran = "";
              }

              if($row->waktu_selesai_pengantaran == NULL){
                  $row->waktu_selesai_pengantaran = "";
              }

              if($row->tgl_perm_pengantaran == NULL){
                  $row->tgl_perm_pengantaran = "";
              }

              if($row->status_delivery == 1 && $row->soft_delete == 0 && $row->batal_nota == 0 && $row->batal_kwitansi == 0 && $row->status_invoice == 1){
                  $data[] = array(
                      'no' => $no,
                      'nama_pelanggan' => $row->nama_pengguna_jasa." / ".$row->nama_pemohon,
                      'waktu_transaksi' => $row->tgl_transaksi,
                      'no_telp' => $row->no_telp,
                      'alamat' => $row->alamat,
                      'tarif' => $this->Ribuan($row->tarif),
                      'total_pengisian' => $row->total_permintaan,
                      'pembayaran' => $this->Ribuan($total_pembayaran),
                      'aksi' => $aksi,
                      'color' => $color
                  );
                  $no++;
              }
          }

          echo json_encode($data);
      }

      public function tabel_tagihan_tenant(){
          if($this->session->userdata('role')== 'operasi' || $this->session->userdata('role')== 'admin'){
              $result = $this->data->get_tabel_transaksi("ruko");
              $data = array();
              $no = 1;

              foreach ($result as $row){
                  if($this->session->userdata('role') == 'operasi' || $this->session->userdata('role')== 'admin' || $tipe == "ruko_admin"){
                      $aksi = '<span class=""><a class="btn btn-primary glyphicon glyphicon-list-alt" title="Cetak Tagihan" target="_blank" href="'.base_url("main/cetakTagihan?id=".$row->id_flow."&tgl_awal=".$row->tgl_awal."&tgl_akhir="."$row->tgl_akhir").'"> </a></span>';
                      $aksi .= '&nbsp;<a class="btn btn-danger glyphicon glyphicon-remove" title="Batal Invoice" href="javascript:void(0)" onclick="batal('."'".$row->id_transaksi."'".');"></a>';
                  } else{
                      $aksi = '<span class=""><a class="btn btn-primary glyphicon glyphicon-list-alt" title="Realisasi Pembayaran" href="javascript:void(0)" onclick="realisasi('."'".$row->id_transaksi."'".');"> </a></span>';
                  }

                  if($row->no_perjanjian == NULL){
                      $row->no_perjanjian = "";
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
                          'no_perjanjian' => $row->no_perjanjian,
                          'total_pakai' => $row->total_pakai,
                          'total_bayar' => $this->Ribuan($row->total_bayar),
                          'aksi' => $aksi,
                      );
                      $no++;
                  }
              }
          } else{
              $result = $this->data->get_tabel_transaksi("ruko");
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

      public function cancelTransaksiDarat(){
          $data['tipe'] = "darat";
          $data['id'] = $this->input->post('id');
          $this->data->cancelOrder($data);
      }

      public function cancelTransaksiRuko(){
          $data['tipe'] = "ruko";
          $data['id'] = $this->input->post('id');
          $this->data->cancelOrder($data);
      }

      public function cancelTransaksiLaut(){
          $data['tipe'] = "laut";
          $data['id'] = $this->input->post('id');
          $cancel_data = $this->data->cekPengisian($data['id']);

          if($cancel_data == TRUE ){
              $this->data->cancelOrder($data);
              $data = array(
                  'status' => 'sukses'
              );
          }
          else{
              $data = array(
                  'status' => 'gagal'
              );
          }

          echo json_encode($data);
      }

      public function validasi_pembayaran_darat(){
          $id = $this->input->post('no_kwitansi');
          $this->form_validation->set_rules('no_kwitansi', 'No Kwitansi', 'required');

          if ($this->form_validation->run() == FALSE) {
              $data['title']='Aplikasi Pelayanan Jasa Air Bersih';
              $this->load->template('v_validasi_pembayaran_darat',$data);
          }else{
              $validasi = $this->data->get_data_kwitansi($id);

              if($validasi == TRUE){
                  $this->db->set('status_pembayaran', 1);
                  $this->db->set('status_invoice', 0);
                  $this->db->set('last_modified',date("Y-m-d H:i:s",time()));
                  $this->db->set('modified_by',$this->session->userdata('username'));
                  $this->db->where('no_kwitansi', $id);
                  $query = $this->db->update('transaksi_darat');

                  if($query){
                      $web = base_url('main/view?id=validasi_pembayaran_darat');
                      echo "<script type='text/javascript'>
                        alert('No Kwitansi Berhasil Di Validasi')
                        window.location.replace('$web')
                      </script>";
                  }else{
                      $web = base_url('main/view?id=validasi_pembayaran_darat');
                      echo "<script type='text/javascript'>
                        alert('No Kwitansi Gagal Di Validasi ! Coba Lagi')
                        window.location.replace('$web')
                      </script>";
                  }
              }else{
                  $web = base_url('main/view?id=validasi_pembayaran_darat');
                  echo "<script type='text/javascript'>
                        alert('No Kwitansi Ini Sudah Di Validasi')
                        window.location.replace('$web')
                      </script>";
              }
          }
      }

      public function cancel_pembayaran_darat(){
          $data['tipe'] = "darat";
          $data['id'] = $this->input->post('no_kwitansi');
          $query = $this->data->cancelNota($data);

          if($query){
              $web = base_url('main/view?id=cancel_pembayaran_darat');
              echo "<script type='text/javascript'>
                        alert('No Kwitansi Berhasil Di Batalkan')
                        window.location.replace('$web')
                      </script>";
          }else{
              $web = base_url('main/view?id=cancel_pembayaran_darat');
              echo "<script type='text/javascript'>
                        alert('No Kwitansi Gagal Di Batalkan ! Coba Lagi')
                        window.location.replace('$web')
                      </script>";
          }
      }

      public function cancelKwitansi(){
          $data['tipe'] = "darat";
          $data['id'] = $this->input->post('id');
          $this->data->cancelKwitansi($data);
      }

      public function realisasi_pembayaran_laut(){
          $this->_validate_pembayaran_laut();
          $data = array(
              'id_ref_transaksi' => $this->input->post('id-transaksi'),
              'no_nota' => $this->input->post('no_nota'),
              'no_faktur' => $this->input->post('no_faktur'),
              'tgl_pembayaran' => date('Y-m-d H:i:s', time()),
              'issued_at' => date("Y-m-d H:i:s",time()),
              'issued_by' => $this->session->userdata('username')
          );
          $this->data->update_pembayaran($this->input->post('id-transaksi'), $data);
          echo json_encode(array("status" => TRUE));
      }

      public function realisasi_pembayaran_darat(){
          $this->_validate_pembayaran_darat();
          $data = array(
              'id_ref_transaksi' => $this->input->post('id-transaksi'),
              'no_nota' => $this->input->post('no_nota'),
              'no_faktur' => $this->input->post('no_faktur'),
              'tgl_pembayaran' => date('Y-m-d H:i:s', time()),
              'issued_at' => date("Y-m-d H:i:s",time()),
              'issued_by' => $this->session->userdata('nama')
          );
          $this->data->update_pembayaran_darat($this->input->post('id-transaksi'), $data);
          echo json_encode(array("status" => TRUE));
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
          $this->data->update_pembayaran_tenant($this->input->post('id-transaksi'), $data);
          echo json_encode(array("status" => TRUE));
      }

      public function cari(){
          $kwitansi = $this->input->post('kwitansi');
          $this->db->select('*');
          $this->db->from('transaksi_darat , pembeli_darat ,pengguna_jasa');
          $this->db->where('no_kwitansi =', $kwitansi);
          $this->db->where('pengguna_jasa_id_tarif !=', 1);
          $this->db->where('status_pembayaran =', 0);
          $this->db->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa');
          $this->db->where('pengguna_jasa_id_tarif = id_tarif');
          $query = $this->db->get();

          if($query->num_rows() > 0){
              $result = $query->row();

              if($result->diskon != NULL || $result->diskon != 0){
                  $total_pembayaran = ($result->tarif - ($result->tarif * $result->diskon/100)) * $result->total_permintaan;
              }else{
                  $total_pembayaran = $result->tarif * $result->total_permintaan;
              }
              $format_tgl = date('d-m-Y H:i', strtotime($result->tgl_transaksi ));
              $format_tgl_permintaan = date('d-m-Y H:i',strtotime($result->tgl_perm_pengantaran));

              $data = array(
                  'status' => 'success',
                  'nama' => $result->nama_pengguna_jasa,
                  'alamat' => $result->alamat,
                  'telepon' => $result->no_telp,
                  'pengguna' => $result->pengguna_jasa_id_tarif,
                  'tanggal' => $format_tgl,
                  'jam' => $format_tgl_permintaan,
                  'tonnase' => $result->total_permintaan,
                  'pembayaran' => $total_pembayaran
              );
          }else{
              $data = array(
                  'status' => 'failed'
              );
          }

          echo json_encode($data);
      }

      public function cari_batal(){
          $kwitansi = $this->input->post('kwitansi');
          $this->db->select('*');
          $this->db->from('transaksi_darat , pembeli_darat ,pengguna_jasa');
          $this->db->where('no_kwitansi =', $kwitansi);
          $this->db->where('pengguna_jasa_id_tarif !=', 1);
          $this->db->where('status_pembayaran =', 1);
          $this->db->where('status_delivery =', 0);
          $this->db->where('batal_nota =', 0);
          $this->db->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa');
          $this->db->where('pengguna_jasa_id_tarif = id_tarif');
          $query = $this->db->get();

          if($query->num_rows() > 0){
              $result = $query->row();

              if($result->diskon != NULL || $result->diskon != 0){
                  $total_pembayaran = ($result->tarif - ($result->tarif * $result->diskon/100)) * $result->total_permintaan;
              }else{
                  $total_pembayaran = $result->tarif * $result->total_permintaan;
              }
              $format_tgl = date('d-m-Y H:i', strtotime($result->tgl_transaksi ));
              $format_tgl_permintaan = date('d-m-Y H:i',strtotime($result->tgl_perm_pengantaran));

              $data = array(
                  'status' => 'success',
                  'nama' => $result->nama_pengguna_jasa,
                  'alamat' => $result->alamat,
                  'telepon' => $result->no_telp,
                  'pengguna' => $result->pengguna_jasa_id_tarif,
                  'tanggal' => $format_tgl,
                  'jam' => $format_tgl_permintaan,
                  'tonnase' => $result->total_permintaan,
                  'pembayaran' => $total_pembayaran
              );
          }else{
              $data = array(
                  'status' => 'failed'
              );
          }

          echo json_encode($data);
      }

      //tampilan monitoring
      public function tabel_monitoring(){
          $tipe = $this->input->get('id');

          if($tipe == "darat"){
              $result = $this->data->get_tabel_transaksi($tipe);
              $data = array();
              $no = 1;

              foreach ($result as $row){
                  $aksi = "";

                  if($row->waktu_mulai_pengantaran == NULL){
                      $row->waktu_mulai_pengantaran = "";
                  }
                  else{
                      $row->waktu_mulai_pengantaran = date("H:i:s", strtotime($row->waktu_mulai_pengantaran));
                  }

                  if($row->waktu_mulai_pengantaran == NULL || $row->waktu_selesai_pengantaran == NULL){
                      if($row->status_invoice == 1){
                          $aksi .= '<span class=""><a class="btn btn-primary glyphicon glyphicon-list-alt" title="Cetak Perhitungan" target="_blank" href="'.base_url("main/cetakPerhitunganPiutang?id=".$row->id_transaksi."").'"> </a>&nbsp;</span>';
                          $aksi .= '<a class="btn btn-primary glyphicon glyphicon-list-alt" title="Cetak Form Permintaan" target="_blank" href="'.base_url("main/cetakFPermintaan?id=".$row->id_transaksi."").'"></a>&nbsp;';
                          $aksi .= '<span class=""><a class="btn btn-danger glyphicon glyphicon-remove" title="Batal Transaksi" href="javascript:void(0)" onclick="batal('."'".$row->id_transaksi."'".');"></a></span>';
                      }
                  } else {
                      $aksi = "";
                  }

                  if($row->waktu_selesai_pengantaran == NULL){
                      $row->waktu_selesai_pengantaran = "";
                  }
                  else{
                      $row->waktu_selesai_pengantaran = date("H:i:s", strtotime($row->waktu_mulai_pengantaran));
                  }

                  if($row->tgl_perm_pengantaran == NULL){
                      $row->tgl_perm_pengantaran = "";
                  }

                  if($row->status_delivery == 0 && $row->batal_nota == 0 && $row->batal_kwitansi == 0){
                      $data[] = array(
                          'no' => $no,
                          'nama' => $row->nama_pengguna_jasa." / ".$row->nama_pemohon,
                          'alamat' => $row->alamat,
                          'tgl_transaksi' => $row->tgl_transaksi,
                          'tgl_permintaan' => $row->tgl_perm_pengantaran,
                          'total_pengisian' => $row->total_permintaan,
                          'waktu_mulai_pengantaran' => $row->waktu_mulai_pengantaran,
                          'waktu_selesai_pengantaran' => $row->waktu_selesai_pengantaran,
                          'aksi' => $aksi
                      );
                      $no++;
                  }
              }
          }
          else{
              $result = $this->data->get_tabel_transaksi($tipe);
              $data = array();
              $no = 1;

              foreach ($result as $row){
                  $aksi = "";
                  $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));
                  $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;

                  if($this->session->userdata('role') == "operasi") {
                      if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL){
                          $aksi = '<a class="btn btn-primary" target="_blank" href="'.base_url("main/cetakPerhitungan?id=".$row->id_transaksi."").'">Cetak Perhitungan</a><br><br>';
                      }
                  }else if($this->session->userdata('role') == "keuangan") {
                      if ($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL) {
                          $aksi = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Realisasi" onclick="realisasi(' . "'" . $row->id_transaksi . "'" . ')"> Realisasi <br/> Piutang</a>';
                      }
                  }else{
                      if($row->flowmeter_awal == NULL && $row->flowmeter_akhir == NULL)
                          $aksi = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Batal" onclick="batal(' . "'" . $row->id_transaksi . "'" . ')"> Batal <br/> Transaksi</a>';
                      else
                          $aksi = "";
                  }
                  if($row->diskon != NULL){
                      $tarif = $row->tarif - ($row->tarif * $row->diskon);
                  }
                  else{
                      $tarif = $row->tarif;
                  }

                  if($row->flowmeter_awal == NULL){
                      $flowmeter_awal = "0";
                  }else{
                      $flowmeter_awal = $row->flowmeter_awal;
                  }

                  if($row->flowmeter_akhir == NULL){
                      $flowmeter_akhir = "0";
                  }else{
                      $flowmeter_akhir = $row->flowmeter_akhir;
                  }

                  if($row->realisasi_transaksi_laut_id_realisasi == NULL){
                      if($this->session->userdata('role') == "keuangan"){
                          if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL) {
                              $data[] = array(
                                  'no' => $no,
                                  'id_kapal' => $row->id_vessel,
                                  'nama_lct' => $row->nama_vessel,
                                  'voy_no' => $row->voy_no,
                                  'nama_perusahaan' => $row->nama_agent,
                                  'nama_pemohon' => $row->nama_pemohon,
                                  'tgl_transaksi' => $format_tgl,
                                  'total_permintaan' => $row->total_permintaan . " Ton",
                                  'flow_sebelum' => $flowmeter_awal,
                                  'flow_sesudah' => $flowmeter_akhir,
                                  'realisasi' => $realisasi." Ton",
                                  'tarif' => $this->Ribuan($tarif),
                                  'pembayaran' => $this->Ribuan($tarif * ($flowmeter_akhir - $flowmeter_awal)),
                                  'aksi' => $aksi
                              );
                              $aksi = "";
                              $no++;
                          }
                      }
                      else{
                          $data[] = array(
                              'no' => $no,
                              'id_kapal' => $row->id_vessel,
                              'nama_lct' => $row->nama_vessel,
                              'voy_no' => $row->voy_no,
                              'nama_perusahaan' => $row->nama_agent,
                              'nama_pemohon' => $row->nama_pemohon,
                              'tgl_transaksi' => $format_tgl,
                              'total_permintaan' => $row->total_permintaan . " Ton",
                              'flow_sebelum' => $flowmeter_awal,
                              'flow_sesudah' => $flowmeter_akhir,
                              'realisasi' => $realisasi." Ton",
                              'aksi' => $aksi
                          );
                          $aksi = "";
                          $no++;
                      }
                  }
              }
          }

          echo json_encode($data);
      }

      //untuk membuat tampilan tabel status pengantaran transaksi darat dan realisasi pengisian air kapal
      public function tabel_pengantaran(){
          $tipe = $this->input->get('id');

          if($tipe == "darat"){
              $result = $this->data->get_tabel_transaksi($tipe);
              $data = array();
              $no = 1;

              foreach ($result as $row){
                  $aksi = "";

                  if($row->waktu_mulai_pengantaran == NULL){
                      $aksi = '&nbsp;<a class="btn btn-sm btn-info glyphicon glyphicon-road" href="javascript:void(0)" title="Pengantaran" onclick="pengantaran('."'".$row->id_transaksi."'".');"></a>';
                  }else if($row->waktu_selesai_pengantaran != NULL){
                      $aksi = "";
                  }else{
                      $aksi = '&nbsp;<a class="btn btn-sm btn-primary glyphicon glyphicon-ok" href="javascript:void(0)" title="Realisasi" onclick="realisasi('."'".$row->id_transaksi."'".')"></a>';
                  }
                  $format_tgl = date('d-m-Y H:i', strtotime($row->tgl_transaksi ));
                  $format_tgl_pengantaran = date('d-m-Y H:i', strtotime($row->tgl_perm_pengantaran ));

                  if($row->status_delivery == 1){
                      $status_pengantaran = "Sudah Diantar";
                  }else if($row->waktu_mulai_pengantaran != NULL){
                      $status_pengantaran = "Sedang Dalam Pengantaran";
                  }else{
                      $status_pengantaran = "Belum Diantar";
                  }

                  if(($row->status_pembayaran == 1 || $row->status_invoice == 1) && $row->status_delivery == 0 && $row->batal_nota == 0 && $row->batal_kwitansi == 0){
                      $data[] = array(
                          'no' => $no,
                          'nama' => $row->nama_pemohon,
                          'alamat' => $row->alamat,
                          'no_telp' => $row->no_telp,
                          'tanggal' => $format_tgl,
                          'tanggal_permintaan' => $format_tgl_pengantaran,
                          'total_pengisian' => $row->total_permintaan,
                          'status_pengantaran' => $status_pengantaran,
                          'aksi' => $aksi
                      );
                      $no++;
                  }
              }
          }
          else{
              $result = $this->data->get_tabel_transaksi($tipe);
              $data = array();
              $no = 1;
              foreach ($result as $row){
                  $aksi = "";
                  if($row->flowmeter_awal == NULL && $row->flowmeter_akhir == NULL){
                      $aksi = '<a class="btn btn-sm btn-primary glyphicon glyphicon-download-alt" href="javascript:void(0)" title="Realisasi Pengisian" onclick="realisasi('."'".$row->id_transaksi."'".')"></a>';
                      $status = "Belum Di Isi";
                  }else{
                      $aksi = "";
                      $status = "Sudah Di Isi";
                  }

                  if($row->voy_no == NULL){
                      $row->voy_no = "";
                  }

                  $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                  if($row->flowmeter_awal == NULL && $row->flowmeter_akhir == NULL){
                      $data[] = array(
                          'no' => $no,
                          'id_kapal' => $row->id_vessel,
                          'nama_lct' => $row->nama_vessel,
                          'voy_no' => $row->voy_no,
                          'nama_perusahaan' => $row->nama_agent,
                          'nama_pemohon' => $row->nama_pemohon,
                          'tgl_transaksi' => $format_tgl,
                          'total_permintaan' => $row->total_permintaan." Ton",
                          'flow_sebelum' => "0",
                          'flow_sesudah' => "0",
                          'status' => $status,
                          'aksi' => $aksi
                      );
                      $no++;
                  }
              }
          }

          echo json_encode($data);
      }

      public function ubah_status_pengantaran(){
          $data['id'] = $this->input->post('id_transaksi');
          $data['waktu'] = date("Y-m-d H:i:s",time());
          $data['user'] = $this->session->userdata('nama');

          $this->data->ubah_waktu_pengantaran($data);
          echo json_encode(array("status" => TRUE));
      }

      public function realisasi_pengantaran_darat($id) {
          $data = $this->data->get_by_id("darat", $id);
          echo json_encode($data);
      }

      public function realisasi_pengantaran_laut($id) {
          $data = $this->data->get_by_id("laut_realisasi", $id);
          echo json_encode($data);
      }

      public function pembayaran_darat($id) {
          $data = $this->data->get_by_id("darat", $id);
          echo json_encode($data);
      }

      public function pembayaran_tenant($id) {
          $data = $this->data->get_by_id("tenant", $id);
          echo json_encode($data);
      }

      public function update_realisasi_darat(){
          $this->_validate_realisasi_darat();
          $data = array(
              'realisasi_pengisian' => $this->input->post('realisasi'),
              'waktu_selesai_pengantaran' => date("Y-m-d H:i:s",time()),
              'pengantar' => $this->input->post('pengantar'),
              'status_delivery' => '1',
              'last_modified' => date("Y-m-d H:i:s",time()),
              'modified_by' => $this->session->userdata('username')
          );
          $this->data->update_realisasi('darat' ,array('id_transaksi' => $this->input->post('id-transaksi')), $data);
          echo json_encode(array("status" => TRUE));
      }

      public function update_realisasi_laut(){
          $this->_validate_realisasi_laut();

          $data = array(
              'flowmeter_awal' => $this->input->post('flowmeter_awal'),
              'flowmeter_akhir' => $this->input->post('flowmeter_akhir'),
              'flowmeter_awal_2' => $this->input->post('flowmeter_awal_2'),
              'flowmeter_akhir_2' => $this->input->post('flowmeter_akhir_2'),
              'flowmeter_awal_3' => $this->input->post('flowmeter_awal_3'),
              'flowmeter_akhir_3' => $this->input->post('flowmeter_akhir_3'),
              'flowmeter_awal_4' => $this->input->post('flowmeter_awal_4'),
              'flowmeter_akhir_4' => $this->input->post('flowmeter_akhir_4'),
              'pengisi' => $this->input->post('pengisi'),
              'last_modified' => date("Y-m-d H:i:s",time()),
              'modified_by' => $this->session->userdata('username')
          );
          $this->data->update_realisasi('laut' ,array('id_transaksi' => $this->input->post('id-transaksi')), $data);
          echo json_encode(array("status" => TRUE));
      }

      private function _validate_realisasi_darat() {
          $data = array();
          $data['error_string'] = array();
          $data['inputerror'] = array();
          $data['status'] = TRUE;

          if($this->input->post('realisasi') == NULL)
          {
              $data['inputerror'][] = 'realisasi';
              $data['error_string'][] = 'Kolom Realisasi Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('pengantar') == NULL)
          {
              $data['inputerror'][] = 'pengangar';
              $data['error_string'][] = 'Kolom Pengantar Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('realisasi') > $this->input->post('tonnase_air'))
          {
              $data['inputerror'][] = 'realisasi';
              $data['error_string'][] = 'Realisasi Pengisian Tidak Bisa Melebihi Yang Sudah Di Pesan';
              $data['status'] = FALSE;
          }

          if($data['status'] === FALSE)
          {
              echo json_encode($data);
              exit();
          }
      }

      private function _validate_realisasi_laut() {
          $data = array();
          $data['error_string'] = array();
          $data['inputerror'] = array();
          $data['status'] = TRUE;

          if($this->input->post('flowmeter_awal') == NULL)
          {
              $data['inputerror'][] = 'flowmeter_awal';
              $data['error_string'][] = 'Kolom Flow Meter Awal Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('flowmeter_akhir') == NULL)
          {
              $data['inputerror'][] = 'flowmeter_akhir';
              $data['error_string'][] = 'Kolom Flow Meter Akhir Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('flowmeter_awal_2') == NULL && $this->input->post('flowmeter_akhir_2') != NULL)
          {
              $data['inputerror'][] = 'flowmeter_awal_2';
              $data['error_string'][] = 'Kolom Flow Meter Awal 2 Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('flowmeter_akhir_2') == NULL && $this->input->post('flowmeter_awal_2') != NULL)
          {
              $data['inputerror'][] = 'flowmeter_akhir_2';
              $data['error_string'][] = 'Kolom Flow Meter Akhir 2 Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('flowmeter_awal_3') == NULL && $this->input->post('flowmeter_akhir_3') != NULL)
          {
              $data['inputerror'][] = 'flowmeter_awal_3';
              $data['error_string'][] = 'Kolom Flow Meter Awal 3 Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('flowmeter_akhir_3') == NULL && $this->input->post('flowmeter_awal_3') != NULL)
          {
              $data['inputerror'][] = 'flowmeter_akhir_3';
              $data['error_string'][] = 'Kolom Flow Meter Akhir 3 Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('flowmeter_awal_4') == NULL && $this->input->post('flowmeter_akhir_4') != NULL)
          {
              $data['inputerror'][] = 'flowmeter_awal_4';
              $data['error_string'][] = 'Kolom Flow Meter Awal 4 Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('flowmeter_akhir_4') == NULL && $this->input->post('flowmeter_awal_4') != NULL)
          {
              $data['inputerror'][] = 'flowmeter_akhir_4';
              $data['error_string'][] = 'Kolom Flow Meter Akhir 4 Masih Kosong';
              $data['status'] = FALSE;
          }

          if(($this->input->post('flowmeter_awal_2') != NULL && $this->input->post('flowmeter_akhir_2') != NULL) && ($this->input->post('flowmeter_awal_2') > $this->input->post('flowmeter_akhir_2')))
          {
              $data['inputerror'][] = 'flowmeter_awal_2';
              $data['error_string'][] = 'Kolom Flow Meter Awal 2 Tidak Boleh Melebihi Kolom Flow Meter Akhir 2';
              $data['status'] = FALSE;
          }

          if(($this->input->post('flowmeter_awal_3') != NULL && $this->input->post('flowmeter_akhir_3') != NULL) && ($this->input->post('flowmeter_awal_3') > $this->input->post('flowmeter_akhir_3')))
          {
              $data['inputerror'][] = 'flowmeter_awal_3';
              $data['error_string'][] = 'Kolom Flow Meter Awal 3 Tidak Boleh Melebihi Kolom Flow Meter Akhir 3';
              $data['status'] = FALSE;
          }

          if(($this->input->post('flowmeter_awal_4') != NULL && $this->input->post('flowmeter_akhir_4') != NULL) && ($this->input->post('flowmeter_awal_4') > $this->input->post('flowmeter_akhir_4')))
          {
              $data['inputerror'][] = 'flowmeter_awal_4';
              $data['error_string'][] = 'Kolom Flow Meter Awal 4 Tidak Boleh Melebihi Kolom Flow Meter Akhir 4';
              $data['status'] = FALSE;
          }

          if($this->input->post('pengisi') == NULL)
          {
              $data['inputerror'][] = 'pengisi';
              $data['error_string'][] = 'Kolom Pengisi Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('flowmeter_awal') > $this->input->post('flowmeter_akhir'))
          {
              $data['inputerror'][] = 'flowmeter_awal';
              $data['error_string'][] = 'Kolom Flow Meter Awal Tidak Boleh Melebihi Kolom Flow Meter Akhir';
              $data['status'] = FALSE;
          }

          if($data['status'] === FALSE)
          {
              echo json_encode($data);
              exit();
          }
      }

      private function _validate_pembayaran_laut() {
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

      private function _validate_pembayaran_darat() {
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

      //fungsi untuk membuat notifikasi
      public function cekNotifKapal(){
            $result = $this->data->notifKapal();
            echo json_encode($result);
      }

      public function cekNotifDarat(){
            $result = $this->data->notifDarat();
            echo json_encode($result);
      }

      public function cekNotifAntar(){
          $result = $this->data->notifAntar();
          echo json_encode($result);
      }

      public function cekNotifRealisasi(){
          $result = $this->data->notifRealisasi();
          echo json_encode($result);
      }

      public function cekNotifBayar(){
          $result = $this->data->notifBayar();
          echo json_encode($result);
      }

      public function cekNotifBayarDarat(){
          $result = $this->data->notifBayarDarat();
          echo json_encode($result);
      }

      public function cekNotifBayarRuko(){
          $result = $this->data->notifBayarRuko();
          echo json_encode($result);
      }

      //fungsi untuk pembuatan laporan dan penagihan
      public function laporan_darat() {
          $tgl_awal = $this->input->post('tgl_awal');
          $tgl_akhir = $this->input->post('tgl_akhir');

          $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"darat_keuangan");

          if($result != NULL){
              $total = 0;
              $ton = 0;
              $no = 1;

              $tabel = '<center><h4>Laporan Pendapatan Air Darat Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center">No</th>
                                <th align="center">No Kwitansi</th>
                                <th align="center">Nama Pengguna Jasa</th>
                                <th align="center">Alamat</th>
                                <th align="center">No Telepon</th>
                                <th align="center">Tanggal Transaksi</th>
                                <th align="center">Tarif</th>
                                <th align="center">Total Permintaan (Ton)</th>
                                <th align="center">Total Pembayaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';

              foreach($result as $row){
                  if($row->diskon != NULL || $row->diskon != 0){
                      $row->tarif -= $row->tarif * $row->diskon/100;
                      $total_pembayaran = $row->tarif * $row->total_permintaan ;
                  }
                  else{
                      $total_pembayaran = $row->tarif * $row->total_permintaan;
                  }

                  if($this->session->userdata('role') == 'keuangan'){
                      if($row->status_pembayaran == 1 && $row->status_invoice == 0) {
                          $total += $total_pembayaran;
                          $ton += $row->total_permintaan;
                          $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi));

                          $tabel .= '<tr>
                            <td align="center">' . $no . '</td>
                            <td align="center">' . $row->no_kwitansi . '</td>
                            <td align="center">' . $row->nama_pengguna_jasa . '</td>
                            <td align="center">' . $row->alamat . '</td>
                            <td align="center">' . $row->no_telp . '</td>
                            <td align="center">' . $format_tgl . '</td>
                            <td align="center">' . $this->Ribuan($row->tarif) . '</td>
                            <td align="center">' . $row->total_permintaan . '</td>
                            <td align="center">' . $this->Ribuan($total_pembayaran) . '</td>
                        </tr>
                        ';
                          $no++;
                      }
                  } else {
                      $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi));

                      if($row->batal_kwitansi == 0){
                          $ton += $row->total_permintaan;
                          $total += $total_pembayaran;

                          $tabel .= '<tr>
                            <td align="center">' . $no . '</td>
                            <td align="center">' . $row->no_kwitansi . '</td>
                            <td align="center">' . $row->nama_pengguna_jasa . '</td>
                            <td align="center">' . $row->alamat . '</td>
                            <td align="center">' . $row->no_telp . '</td>
                            <td align="center">' . $format_tgl . '</td>
                            <td align="center">' . $this->Ribuan($row->tarif) . '</td>
                            <td align="center">' . $row->total_permintaan . '</td>
                            <td align="center">' . $this->Ribuan($total_pembayaran) . '</td>
                        </tr>';
                          $no++;
                      } else{
                         $total_pembayaran = 'Kwitansi Batal';

                          $tabel .= '<tr style="background-color: #990000">
                            <td align="center">' . $no . '</td>
                            <td align="center">' . $row->no_kwitansi . '</td>
                            <td align="center">' . $row->nama_pengguna_jasa . '</td>
                            <td align="center">' . $row->alamat . '</td>
                            <td align="center">' . $row->no_telp . '</td>
                            <td align="center">' . $format_tgl . '</td>
                            <td align="center">' . $this->Ribuan($row->tarif) . '</td>
                            <td align="center">' . $row->total_permintaan . '</td>
                            <td align="center">' . $total_pembayaran . '</td>
                        </tr>';
                          $no++;
                      }
                  }
              }

              $tabel .= '<tr>
                            <td align="center" colspan="7"><b>Total</b></td>
                            <td align="center"><b>'.$ton.'</b></td>
                            <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=darat").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelDarat?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';

              $data = array(
                  'status' => 'success',
                  'tabel' => $tabel
              );
          }
          else{
              $data = array(
                  'status' => 'failed'
              );
          }

          echo json_encode($data);
      }

      public function laporanDarat(){
          $tgl_awal = $this->input->post('tgl_awal');
          $tgl_akhir = $this->input->post('tgl_akhir');

          $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"darat");

          if($this->session->userdata('role') == 'loket'){
              if($result != NULL){
                  $total = 0;
                  $ton = 0;
                  $no = 1;

                  $tabel = '<center><h4>Laporan Pendapatan Air Darat Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center">No</th>
                                <th align="center">Nama Pengguna Jasa</th>
                                <th align="center">Alamat</th>
                                <th align="center">Tanggal Transaksi</th>
                                <th align="center">Waktu Permintaan Pengantaran</th>
                                <th align="center">Waktu Mulai Pengantaran</th>
                                <th align="center">Waktu Selesai Pengantaran</th>
                                <th align="center">Lama Pengantaran</th>
                                <th align="center">Tarif (Rp.)</th>
                                <th align="center">Total Permintaan (Ton)</th>
                                <th align="center">Total Pembayaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';

                  foreach($result as $row){
                      $lama_pengantaran = 0;
                      $format_jam_awal = "";
                      $format_jam_akhir = "";

                      if($row->batal_kwitansi == 1){
                          $total_pembayaran = 0;
                      } else if($row->diskon != NULL || $row->diskon != 0){
                          $row->tarif -= $row->tarif * $row->diskon/100;
                          $total_pembayaran = $row->tarif * $row->total_permintaan ;
                      } else{
                          $total_pembayaran = $row->tarif * $row->total_permintaan;
                      }

                      if($row->waktu_mulai_pengantaran == NULL){
                          $format_jam_awal = "";
                      } else if($row->waktu_selesai_pengantaran == NULL){
                          $format_jam_akhir = "";
                      } else {
                          $format_jam_awal = date("d-m-y H:i:s",strtotime($row->waktu_mulai_pengantaran));
                          $format_jam_akhir = date("d-m-y H:i:s",strtotime($row->waktu_selesai_pengantaran));

                          $waktu_awal = mktime(date("H",strtotime($row->waktu_mulai_pengantaran)),date("i",strtotime($row->waktu_mulai_pengantaran)),date("s",strtotime($row->waktu_mulai_pengantaran)),date("m",strtotime($row->waktu_mulai_pengantaran)),date("d",strtotime($row->waktu_mulai_pengantaran)),date("y",strtotime($row->waktu_mulai_pengantaran)));
                          $waktu_akhir = mktime(date("H",strtotime($row->waktu_selesai_pengantaran)),date("i",strtotime($row->waktu_selesai_pengantaran)),date("s",strtotime($row->waktu_selesai_pengantaran)),date("m",strtotime($row->waktu_selesai_pengantaran)),date("d",strtotime($row->waktu_selesai_pengantaran)),date("y",strtotime($row->waktu_selesai_pengantaran)) );
                          $lama_pengantaran = round((($waktu_akhir - $waktu_awal) % 86400)/3600,2);
                      }

                      if($lama_pengantaran > 1){
                          $lama_pengantaran .= " Jam";
                      }else {
                          $lama_pengantaran = $lama_pengantaran * 60;
                          if ($lama_pengantaran > 1){
                              $lama_pengantaran .= " Menit";
                          }else {
                              $lama_pengantaran = $lama_pengantaran * 60;
                              $lama_pengantaran .= " Detik";
                          }
                      }
                      $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));
                      $format_tgl_pengantaran = date('d-m-Y H:i:s', strtotime($row->tgl_perm_pengantaran ));

                      $total += $total_pembayaran;

                      if($row->batal_kwitansi == 0){
                          $ton += $row->total_permintaan;

                          $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->nama_pengguna_jasa.'</td>
                            <td align="center">'.$row->alamat.'</td>
                            <td align="center">'.$format_tgl.'</td>
                            <td align="center">'.$format_tgl_pengantaran.'</td>
                            <td align="center">'.$format_jam_awal.'</td>
                            <td align="center">'.$format_jam_akhir.'</td>
                            <td align="center">'.$lama_pengantaran.'</td>
                            <td align="center">'.$this->Ribuan($row->tarif).'</td>
                            <td align="center">'.$row->total_permintaan.'</td>
                            <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                        </tr>
                        ';
                          $no++;
                      } else {
                          $total_pembayaran = "Kwitansi Di Batalkan";
                          $tabel .='<tr style="background-color: #990000">
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->nama_pengguna_jasa.'</td>
                            <td align="center">'.$row->alamat.'</td>
                            <td align="center">'.$format_tgl.'</td>
                            <td align="center">'.$format_tgl_pengantaran.'</td>
                            <td align="center">'.$format_jam_awal.'</td>
                            <td align="center">'.$format_jam_akhir.'</td>
                            <td align="center">'.$lama_pengantaran.'</td>
                            <td align="center">'.$this->Ribuan($row->tarif).'</td>
                            <td align="center">'.$row->total_permintaan.'</td>
                            <td align="center">'.$total_pembayaran.'</td>
                        </tr>
                        ';
                          $no++;
                      }
                  }

                  $tabel .= '<tr>
                            <td align="center" colspan="9"><b>Total</b></td>
                            <td align="center"><b>'.$ton.'</b></td>
                            <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=darat").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelDarat?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';

                  $data = array(
                      'status' => 'success',
                      'tabel' => $tabel
                  );
              }
              else{
                  $data = array(
                      'status' => 'failed'
                  );
              }
          }
          else{
              if($result != NULL){
                  $total = 0;
                  $ton = 0;
                  $no = 1;

                  $tabel = '<center><h4>Laporan Pendapatan Air Darat Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center">No</th>
                                <th align="center">Nama Pengguna Jasa</th>
                                <th align="center">Alamat</th>
                                <th align="center">Tanggal Transaksi</th>
                                <th align="center">Waktu Permintaan Pengantaran</th>
                                <th align="center">Waktu Mulai Pengantaran</th>
                                <th align="center">Waktu Selesai Pengantaran</th>
                                <th align="center">Lama Pengantaran</th>
                                <th align="center">Total Permintaan (Ton)</th>
                                <th align="center">Total Pembayaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';

                  foreach($result as $row){
                      $lama_pengantaran = 0;
                      $format_jam_awal = "";
                      $format_jam_akhir = "";

                      if($row->batal_kwitansi == 1){
                          $total_pembayaran = 0;
                      } else if($row->diskon != NULL || $row->diskon != 0){
                          $row->tarif -= $row->tarif * $row->diskon/100;
                          $total_pembayaran = $row->tarif * $row->total_permintaan ;
                      } else{
                          $total_pembayaran = $row->tarif * $row->total_permintaan;
                      }

                      if($row->waktu_mulai_pengantaran == NULL){
                          $format_jam_awal = "";
                      } else if($row->waktu_selesai_pengantaran == NULL){
                          $format_jam_akhir = "";
                      } else {
                          $format_jam_awal = date("d-m-y H:i:s",strtotime($row->waktu_mulai_pengantaran));
                          $format_jam_akhir = date("d-m-y H:i:s",strtotime($row->waktu_selesai_pengantaran));

                          $waktu_awal = mktime(date("H",strtotime($row->waktu_mulai_pengantaran)),date("i",strtotime($row->waktu_mulai_pengantaran)),date("s",strtotime($row->waktu_mulai_pengantaran)),date("m",strtotime($row->waktu_mulai_pengantaran)),date("d",strtotime($row->waktu_mulai_pengantaran)),date("y",strtotime($row->waktu_mulai_pengantaran)));
                          $waktu_akhir = mktime(date("H",strtotime($row->waktu_selesai_pengantaran)),date("i",strtotime($row->waktu_selesai_pengantaran)),date("s",strtotime($row->waktu_selesai_pengantaran)),date("m",strtotime($row->waktu_selesai_pengantaran)),date("d",strtotime($row->waktu_selesai_pengantaran)),date("y",strtotime($row->waktu_selesai_pengantaran)) );
                          $lama_pengantaran = round((($waktu_akhir - $waktu_awal) % 86400)/3600,2);
                      }

                      if($lama_pengantaran > 1){
                          $lama_pengantaran .= " Jam";
                      }else {
                          $lama_pengantaran = $lama_pengantaran * 60;
                          if ($lama_pengantaran > 1){
                              $lama_pengantaran .= " Menit";
                          }else {
                              $lama_pengantaran = $lama_pengantaran * 60;
                              $lama_pengantaran .= " Detik";
                          }
                      }

                      $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));
                      $format_tgl_pengantaran = date('d-m-Y H:i:s', strtotime($row->tgl_perm_pengantaran ));

                      $total += $total_pembayaran;

                      if($row->batal_kwitansi == 0){
                          $ton += $row->total_permintaan;

                          $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->nama_pengguna_jasa.'</td>
                            <td align="center">'.$row->alamat.'</td>
                            <td align="center">'.$format_tgl.'</td>
                            <td align="center">'.$format_tgl_pengantaran.'</td>
                            <td align="center">'.$format_jam_awal.'</td>
                            <td align="center">'.$format_jam_akhir.'</td>
                            <td align="center">'.$lama_pengantaran.'</td>
                            <td align="center">'.$row->total_permintaan.'</td>
                            <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                        </tr>
                        ';
                          $no++;
                      } else {
                          $total_pembayaran = "Kwitansi Di Batalkan";
                          $tabel .='<tr style="background-color: #990000">
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->nama_pengguna_jasa.'</td>
                            <td align="center">'.$row->alamat.'</td>
                            <td align="center">'.$format_tgl.'</td>
                            <td align="center">'.$format_tgl_pengantaran.'</td>
                            <td align="center">'.$format_jam_awal.'</td>
                            <td align="center">'.$format_jam_akhir.'</td>
                            <td align="center">'.$lama_pengantaran.'</td>
                            <td align="center">'.$row->total_permintaan.'</td>
                            <td align="center">'.$total_pembayaran.'</td>
                        </tr>
                        ';
                          $no++;
                      }
                  }

                  $tabel .= '<tr>
                            <td align="center" colspan="8"><b>Total</b></td>
                            <td align="center"><b>'.$ton.'</b></td>
                            <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=darat").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelDarat?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';

                  $data = array(
                      'status' => 'success',
                      'tabel' => $tabel
                  );
              }
              else{
                  $data = array(
                      'status' => 'failed'
                  );
              }
          }

          echo json_encode($data);
      }

      public function laporan_laut(){
          $tgl_awal = $this->input->post('tgl_awal');
          $tgl_akhir = $this->input->post('tgl_akhir');

          if($this->session->userdata('role') == 'keuangan')
              $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"laut");
          else
              $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"laut_operasi");


          if($result != NULL){
              $total = 0;
              $ton = 0;
              $no = 1;
              $ton_realiasi = 0;

              if($this->session->userdata('role') == 'keuangan'){
                  $tabel = '<center><h4>Laporan Pendapatan Air Kapal Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center">No</th>
                                <th align="center">No Nota</th>
                                <th align="center">No Faktur</th>
                                <th align="center">ID VESSEL</th>
                                <th align="center">Nama VESSEL</th>
                                <th align="center">Voy No</th>
                                <th align="center">Tipe Kapal</th>
                                <th align="center">Nama Perusahaan</th>
                                <th align="center">Tanggal Transaksi</th>
                                <th align="center">Tarif (Rp.)</th>
                                <th align="center">Total Permintaan (Ton)</th>
                                <th align="center">Realisasi Pengisian (Ton)</th>
                                <th align="center">Total Pembayaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';
              }
              else if($this->session->userdata('role') == 'operasi') {
                  $tabel = '<center><h4>Laporan Pendapatan Air Kapal Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center">No</th>
                                <th align="center">ID VESSEL</th>
                                <th align="center">Nama VESSEL</th>
                                <th align="center">Voy No</th>
                                <th align="center">Tipe Kapal</th>
                                <th align="center">Nama Perusahaan</th>
                                <th align="center">Tanggal Transaksi</th>
                                <th align="center">Tarif (Rp.)</th>
                                <th align="center">Total Permintaan (Ton)</th>
                                <th align="center">Realisasi Pengisian (Ton)</th>
                                <th align="center">Total Pembayaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';
              }
              else {
                  $tabel = '<center><h4>Laporan Pendapatan Air Kapal Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center">No</th>
                                <th align="center">ID VESSEL</th>
                                <th align="center">Nama VESSEL</th>
                                <th align="center">Voy No</th>
                                <th align="center">Tipe Kapal</th>
                                <th align="center">Nama Perusahaan</th>
                                <th align="center">Tanggal Transaksi</th>
                                <th align="center">Flow Meter Awal</th>
                                <th align="center">Flow Meter Akhir</th>
                                <th align="center">Total Permintaan (Ton)</th>
                                <th align="center">Realisasi Pengisian (Ton)</th>
                                <th align="center">Total Pembayaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';
              }

              foreach($result as $row){
                  if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL){
                      if($this->session->userdata('role') == 'keuangan'){
                          if($row->id_ref_transaksi != NULL){
                              if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                                  $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;

                                  if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                      $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                                      if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                          $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                      } else{
                                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                      }
                                  }
                                  else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                      $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  }
                                  else {
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  }
                              }
                              else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                  $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                                  if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                      $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  } else {
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  }
                              }
                              else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                  $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              }
                              else{
                                  $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                              }

                              if($row->diskon != NULL || $row->diskon != 0){
                                  $row->tarif -= $row->tarif * $row->diskon/100;
                                  $total_pembayaran = $row->tarif  * $realisasi;
                              }
                              else{
                                  $total_pembayaran = $row->tarif * $realisasi;
                              }

                              if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                                  $total_pembayaran += 3000;
                              } else if($total_pembayaran > 1000000){
                                  $total_pembayaran += 6000;
                              } else{
                                  $total_pembayaran += 0;
                              }

                              $total += $total_pembayaran;
                              $ton += $row->total_permintaan;
                              $ton_realiasi += $realisasi;
                              $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                              if($row->pengguna_jasa_id_tarif == 8){
                                  $row->pengguna_jasa_id_tarif = "Peti Kemas";
                              }else{
                                  $row->pengguna_jasa_id_tarif = "Tongkang";
                              }

                              $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->no_nota.'</td>
                            <td align="center">'.$row->no_faktur.'</td>
                            <td align="center">'.$row->id_vessel.'</td>
                            <td align="center">'.$row->nama_vessel.'</td>
                            <td align="center">'.$row->voy_no.'</td>
                            <td align="center">'.$row->pengguna_jasa_id_tarif.'</td>
                            <td align="center">'.$row->nama_agent.'</td>
                            <td align="center">'.$format_tgl.'</td>
                            <td align="center">'.$this->Ribuan($row->tarif).'</td>
                            <td align="center">'.$row->total_permintaan.'</td>
                            <td align="center">'.$realisasi.'</td>
                            <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                        </tr>
                        ';
                              $no++;
                          }
                      }
                      else if($this->session->userdata('role') == 'wtp' || $this->session->userdata('role') == 'perencanaan'){
                          if($row->flowmeter_awal == NULL || $row->flowmeter_awal == '0'){
                              $flowmeter_awal = "0";
                          }
                          else{
                              $flowmeter_awal = $row->flowmeter_awal;
                          }

                          if($row->flowmeter_akhir == NULL || $row->flowmeter_akhir == '0'){
                              $flowmeter_akhir = "0";
                          }
                          else{
                              $flowmeter_akhir = $row->flowmeter_akhir;
                          }

                          if($row->flowmeter_awal_2 == NULL || $row->flowmeter_awal_2 == '0'){
                              $flowmeter_awal_2 = "0";
                          }
                          else{
                              $flowmeter_awal_2 = $row->flowmeter_awal_2;
                          }

                          if($row->flowmeter_akhir_2 == NULL || $row->flowmeter_akhir_2 == '0'){
                              $flowmeter_akhir_2 = "0";
                          }
                          else{
                              $flowmeter_akhir_2 = $row->flowmeter_akhir_2;
                          }

                          if($row->flowmeter_awal_3 == NULL || $row->flowmeter_awal_3 == '0'){
                              $flowmeter_awal_3 = "0";
                          }
                          else{
                              $flowmeter_awal_3 = $row->flowmeter_awal_3;
                          }

                          if($row->flowmeter_akhir_3 == NULL || $row->flowmeter_akhir_3 == '0'){
                              $flowmeter_akhir_3 = "0";
                          }
                          else{
                              $flowmeter_akhir_3 = $row->flowmeter_akhir_3;
                          }

                          if($row->flowmeter_awal_4 == NULL || $row->flowmeter_awal_4 == '0'){
                              $flowmeter_awal_4 = "0";
                          }
                          else{
                              $flowmeter_awal_4 = $row->flowmeter_awal_4;
                          }

                          if($row->flowmeter_akhir_4 == NULL || $row->flowmeter_akhir_4 == '0'){
                              $flowmeter_akhir_4 = "0";
                          }
                          else{
                              $flowmeter_akhir_4 = $row->flowmeter_akhir_4;
                          }

                          if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                              $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;
                              $flow_sebelum = $flowmeter_awal_4;
                              $flow_sesudah = $flowmeter_akhir_4;

                              if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                  $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                                  $flow_sebelum .= " , ".$flowmeter_awal_3;
                                  $flow_sesudah .= " , ".$flowmeter_akhir_3;

                                  if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                      $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                      $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                      $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                                  } else{
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                      $flow_sebelum .= " , ".$flowmeter_awal;
                                      $flow_sesudah .= " , ".$flowmeter_akhir;
                                  }
                              }
                              else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                  $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                              }
                              else {
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir;
                              }
                          }
                          else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                              $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                              $flow_sebelum = $flowmeter_awal_3;
                              $flow_sesudah = $flowmeter_akhir_3;

                              if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                  $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                              } else {
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir;
                              }
                          }
                          else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                              $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum = $flowmeter_awal_2." , ".$flowmeter_awal;
                              $flow_sesudah = $flowmeter_akhir_2." , ".$flowmeter_akhir;
                          }
                          else{
                              $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum = $flowmeter_awal;
                              $flow_sesudah = $flowmeter_akhir;
                          }

                          if($row->diskon != NULL || $row->diskon != 0){
                              $row->tarif -= $row->tarif * $row->diskon/100;
                              $total_pembayaran = $row->tarif  * $realisasi;
                          }
                          else{
                              $total_pembayaran = $row->tarif * $realisasi;
                          }

                          if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                              $total_pembayaran += 3000;
                          } else if($total_pembayaran > 1000000){
                              $total_pembayaran += 6000;
                          } else{
                              $total_pembayaran += 0;
                          }

                          $total += $total_pembayaran;
                          $ton += $row->total_permintaan;
                          $ton_realiasi += $realisasi;
                          $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                          if($row->tipe_kapal == 8){
                              $row->tipe_kapal = "Peti Kemas";
                          }else{
                              $row->tipe_kapal = "Tongkang";
                          }

                          $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->id_vessel.'</td>
                            <td align="center">'.$row->nama_vessel.'</td>
                            <td align="center">'.$row->voy_no.'</td>
                            <td align="center">'.$row->tipe_kapal.'</td>
                            <td align="center">'.$row->nama_agent.'</td>
                            <td align="center">'.$format_tgl.'</td>
                            <td align="center">'.$flow_sebelum.'</td>
                            <td align="center">'.$flow_sesudah.'</td>
                            <td align="center">'.$row->total_permintaan.'</td>
                            <td align="center">'.$realisasi.'</td>
                            <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                        </tr>
                        ';
                          $no++;
                      }
                      else {
                          if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                              $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;

                              if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                  $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                                  if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                      $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  } else{
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  }
                              }
                              else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                  $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              }
                              else {
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              }
                          }
                          else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                              $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                              if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                  $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              } else {
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              }
                          }
                          else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                              $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                          }
                          else{
                              $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                          }

                          if($row->diskon != NULL || $row->diskon != 0){
                              $row->tarif -= $row->tarif * $row->diskon/100;
                              $total_pembayaran = $row->tarif * $realisasi;
                          }
                          else{
                              $total_pembayaran = $row->tarif * $realisasi;
                          }

                          if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                              $total_pembayaran += 3000;
                          } else if($total_pembayaran > 1000000){
                              $total_pembayaran += 6000;
                          } else{
                              $total_pembayaran += 0;
                          }

                          $total += $total_pembayaran;
                          $ton += $row->total_permintaan;
                          $ton_realiasi += $realisasi;
                          $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                          if($row->pengguna_jasa_id_tarif == 8){
                              $row->pengguna_jasa_id_tarif = "Peti Kemas";
                          }else{
                              $row->pengguna_jasa_id_tarif = "Tongkang";
                          }

                          $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->id_vessel.'</td>
                            <td align="center">'.$row->nama_vessel.'</td>
                            <td align="center">'.$row->voy_no.'</td>
                            <td align="center">'.$row->pengguna_jasa_id_tarif.'</td>
                            <td align="center">'.$row->nama_agent.'</td>
                            <td align="center">'.$format_tgl.'</td>
                            <td align="center">'.$this->Ribuan($row->tarif).'</td>
                            <td align="center">'.$row->total_permintaan.'</td>
                            <td align="center">'.$realisasi.'</td>
                            <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                        </tr>
                        ';
                          $no++;
                      }
                  }
              }

              if($this->session->userdata('role') == 'keuangan' ){
                  $tabel .= '<tr>
                            <td align="center" colspan="10"><b>Total</b></td>
                            <td align="center"><b>'.$ton.'</b></td>
                            <td align="center"><b>'.$ton_realiasi.'</b></td>
                            <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=laut").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelLaut?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';
              }
              else if($this->session->userdata('role') == 'operasi'){
                  $tabel .= '<tr>
                            <td align="center" colspan="8"><b>Total</b></td>
                            <td align="center"><b>'.$ton.'</b></td>
                            <td align="center"><b>'.$ton_realiasi.'</b></td>
                            <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=laut").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelLaut?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';
              }
              else {
                  $tabel .= '<tr>
                            <td align="center" colspan="9"><b>Total</b></td>
                            <td align="center"><b>'.$ton.'</b></td>
                            <td align="center"><b>'.$ton_realiasi.'</b></td>
                            <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=laut").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelLaut?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';
              }

              $data = array(
                  'status' => 'success',
                  'tabel' => $tabel
              );
          }
          else{
              $data = array(
                  'status' => 'failed'
              );
          }

          echo json_encode($data);
      }

      public function laporanLaut(){
          $tgl_awal = $this->input->post('tgl_awal');
          $tgl_akhir = $this->input->post('tgl_akhir');

          $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"laut_operasi");

          if($result != NULL){
              $total = 0;
              $ton = 0;
              $no = 1;
              $ton_realiasi = 0;

              if($this->session->userdata('role') == 'keuangan'){
                  $tabel = '<center><h4>Laporan Pendapatan Air Kapal Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center">No</th>
                                <th align="center">No Nota</th>
                                <th align="center">No Faktur</th>
                                <th align="center">ID VESSEL</th>
                                <th align="center">Nama VESSEL</th>
                                <th align="center">Voy No</th>
                                <th align="center">Tipe Kapal</th>
                                <th align="center">Nama Perusahaan</th>
                                <th align="center">Tanggal Transaksi</th>
                                <th align="center">Tarif (Rp.)</th>
                                <th align="center">Total Permintaan (Ton)</th>
                                <th align="center">Realisasi Pengisian (Ton)</th>
                                <th align="center">Total Pembayaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';
              }
              else if($this->session->userdata('role') == 'operasi') {
                  $tabel = '<center><h4>Laporan Pendapatan Air Kapal Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center">No</th>
                                <th align="center">ID VESSEL</th>
                                <th align="center">Nama VESSEL</th>
                                <th align="center">Voy No</th>
                                <th align="center">Tipe Kapal</th>
                                <th align="center">Nama Perusahaan</th>
                                <th align="center">Tanggal Transaksi</th>
                                <th align="center">Tarif (Rp.)</th>
                                <th align="center">Total Permintaan (Ton)</th>
                                <th align="center">Realisasi Pengisian (Ton)</th>
                                <th align="center">Total Pembayaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';
              }
              else {
                  $tabel = '<center><h4>Laporan Pendapatan Air Kapal Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center">No</th>
                                <th align="center">ID VESSEL</th>
                                <th align="center">Nama VESSEL</th>
                                <th align="center">Voy No</th>
                                <th align="center">Tipe Kapal</th>
                                <th align="center">Nama Perusahaan</th>
                                <th align="center">Tanggal Transaksi</th>
                                <th align="center">Flow Meter Awal</th>
                                <th align="center">Flow Meter Akhir</th>
                                <th align="center">Total Permintaan (Ton)</th>
                                <th align="center">Realisasi Pengisian (Ton)</th>
                                <th align="center">Total Pembayaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';
              }

              foreach($result as $row){
                  if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL){
                      if($this->session->userdata('role') == 'keuangan'){
                          if($row->realisasi_transaksi_laut_id_realisasi != NULL){
                              if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                                  $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;

                                  if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                      $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                                      if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                          $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                      } else{
                                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                      }
                                  }
                                  else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                      $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  }
                                  else {
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  }
                              }
                              else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                  $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                                  if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                      $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  } else {
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  }
                              }
                              else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                  $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              }
                              else{
                                  $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                              }

                              if($row->diskon != NULL || $row->diskon != 0){
                                  $row->tarif -= $row->tarif * $row->diskon/100;
                                  $total_pembayaran = $row->tarif  * $realisasi;
                              }
                              else{
                                  $total_pembayaran = $row->tarif * $realisasi;
                              }

                              if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                                  $total_pembayaran += 3000;
                              } else if($total_pembayaran > 1000000){
                                  $total_pembayaran += 6000;
                              } else{
                                  $total_pembayaran += 0;
                              }

                              $total += $total_pembayaran;
                              $ton += $row->total_permintaan;
                              $ton_realiasi += $realisasi;
                              $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                              if($row->pengguna_jasa_id_tarif == 6){
                                  $row->pengguna_jasa_id_tarif = "Peti Kemas";
                              }else{
                                  $row->pengguna_jasa_id_tarif = "Tongkang";
                              }

                              $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->no_nota.'</td>
                            <td align="center">'.$row->no_faktur.'</td>
                            <td align="center">'.$row->id_vessel.'</td>
                            <td align="center">'.$row->nama_vessel.'</td>
                            <td align="center">'.$row->voy_no.'</td>
                            <td align="center">'.$row->pengguna_jasa_id_tarif.'</td>
                            <td align="center">'.$row->nama_agent.'</td>
                            <td align="center">'.$format_tgl.'</td>
                            <td align="center">'.$this->Ribuan($row->tarif).'</td>
                            <td align="center">'.$row->total_permintaan.'</td>
                            <td align="center">'.$realisasi.'</td>
                            <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                        </tr>
                        ';
                              $no++;
                          }
                      }
                      else if($this->session->userdata('role') == 'wtp' || $this->session->userdata('role') == 'perencanaan' || $this->session->userdata('role') == 'admin'){
                          if($row->flowmeter_awal == NULL || $row->flowmeter_awal == '0'){
                              $flowmeter_awal = "0";
                          }
                          else{
                              $flowmeter_awal = $row->flowmeter_awal;
                          }

                          if($row->flowmeter_akhir == NULL || $row->flowmeter_akhir == '0'){
                              $flowmeter_akhir = "0";
                          }
                          else{
                              $flowmeter_akhir = $row->flowmeter_akhir;
                          }

                          if($row->flowmeter_awal_2 == NULL || $row->flowmeter_awal_2 == '0'){
                              $flowmeter_awal_2 = "0";
                          }
                          else{
                              $flowmeter_awal_2 = $row->flowmeter_awal_2;
                          }

                          if($row->flowmeter_akhir_2 == NULL || $row->flowmeter_akhir_2 == '0'){
                              $flowmeter_akhir_2 = "0";
                          }
                          else{
                              $flowmeter_akhir_2 = $row->flowmeter_akhir_2;
                          }

                          if($row->flowmeter_awal_3 == NULL || $row->flowmeter_awal_3 == '0'){
                              $flowmeter_awal_3 = "0";
                          }
                          else{
                              $flowmeter_awal_3 = $row->flowmeter_awal_3;
                          }

                          if($row->flowmeter_akhir_3 == NULL || $row->flowmeter_akhir_3 == '0'){
                              $flowmeter_akhir_3 = "0";
                          }
                          else{
                              $flowmeter_akhir_3 = $row->flowmeter_akhir_3;
                          }

                          if($row->flowmeter_awal_4 == NULL || $row->flowmeter_awal_4 == '0'){
                              $flowmeter_awal_4 = "0";
                          }
                          else{
                              $flowmeter_awal_4 = $row->flowmeter_awal_4;
                          }

                          if($row->flowmeter_akhir_4 == NULL || $row->flowmeter_akhir_4 == '0'){
                              $flowmeter_akhir_4 = "0";
                          }
                          else{
                              $flowmeter_akhir_4 = $row->flowmeter_akhir_4;
                          }

                          if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                              $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;
                              $flow_sebelum = $flowmeter_awal_4;
                              $flow_sesudah = $flowmeter_akhir_4;

                              if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                  $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                                  $flow_sebelum .= " , ".$flowmeter_awal_3;
                                  $flow_sesudah .= " , ".$flowmeter_akhir_3;

                                  if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                      $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                      $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                      $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                                  } else{
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                      $flow_sebelum .= " , ".$flowmeter_awal;
                                      $flow_sesudah .= " , ".$flowmeter_akhir;
                                  }
                              }
                              else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                  $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                              }
                              else {
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir;
                              }
                          }
                          else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                              $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                              $flow_sebelum = $flowmeter_awal_3;
                              $flow_sesudah = $flowmeter_akhir_3;

                              if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                  $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                              } else {
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir;
                              }
                          }
                          else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                              $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum = $flowmeter_awal_2." , ".$flowmeter_awal;
                              $flow_sesudah = $flowmeter_akhir_2." , ".$flowmeter_akhir;
                          }
                          else{
                              $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum = $flowmeter_awal;
                              $flow_sesudah = $flowmeter_akhir;
                          }

                          if($row->diskon != NULL || $row->diskon != 0){
                              $row->tarif -= $row->tarif * $row->diskon/100;
                              $total_pembayaran = $row->tarif  * $realisasi;
                          }
                          else{
                              $total_pembayaran = $row->tarif * $realisasi;
                          }

                          if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                              $total_pembayaran += 3000;
                          } else if($total_pembayaran > 1000000){
                              $total_pembayaran += 6000;
                          } else{
                              $total_pembayaran += 0;
                          }

                          $total += $total_pembayaran;
                          $ton += $row->total_permintaan;
                          $ton_realiasi += $realisasi;
                          $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                          if($row->tipe_kapal == 8){
                              $row->tipe_kapal = "Peti Kemas";
                          }else{
                              $row->tipe_kapal = "Tongkang";
                          }

                          $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->id_vessel.'</td>
                            <td align="center">'.$row->nama_vessel.'</td>
                            <td align="center">'.$row->voy_no.'</td>
                            <td align="center">'.$row->tipe_kapal.'</td>
                            <td align="center">'.$row->nama_agent.'</td>
                            <td align="center">'.$format_tgl.'</td>
                            <td align="center">'.$flow_sebelum.'</td>
                            <td align="center">'.$flow_sesudah.'</td>
                            <td align="center">'.$row->total_permintaan.'</td>
                            <td align="center">'.$realisasi.'</td>
                            <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                        </tr>
                        ';
                          $no++;
                      }
                      else {
                          if($row->flowmeter_awal == NULL || $row->flowmeter_awal == '0'){
                              $flowmeter_awal = "0";
                          }
                          else{
                              $flowmeter_awal = $row->flowmeter_awal;
                          }

                          if($row->flowmeter_akhir == NULL || $row->flowmeter_akhir == '0'){
                              $flowmeter_akhir = "0";
                          }
                          else{
                              $flowmeter_akhir = $row->flowmeter_akhir;
                          }

                          if($row->flowmeter_awal_2 == NULL || $row->flowmeter_awal_2 == '0'){
                              $flowmeter_awal_2 = "0";
                          }
                          else{
                              $flowmeter_awal_2 = $row->flowmeter_awal_2;
                          }

                          if($row->flowmeter_akhir_2 == NULL || $row->flowmeter_akhir_2 == '0'){
                              $flowmeter_akhir_2 = "0";
                          }
                          else{
                              $flowmeter_akhir_2 = $row->flowmeter_akhir_2;
                          }

                          if($row->flowmeter_awal_3 == NULL || $row->flowmeter_awal_3 == '0'){
                              $flowmeter_awal_3 = "0";
                          }
                          else{
                              $flowmeter_awal_3 = $row->flowmeter_awal_3;
                          }

                          if($row->flowmeter_akhir_3 == NULL || $row->flowmeter_akhir_3 == '0'){
                              $flowmeter_akhir_3 = "0";
                          }
                          else{
                              $flowmeter_akhir_3 = $row->flowmeter_akhir_3;
                          }

                          if($row->flowmeter_awal_4 == NULL || $row->flowmeter_awal_4 == '0'){
                              $flowmeter_awal_4 = "0";
                          }
                          else{
                              $flowmeter_awal_4 = $row->flowmeter_awal_4;
                          }

                          if($row->flowmeter_akhir_4 == NULL || $row->flowmeter_akhir_4 == '0'){
                              $flowmeter_akhir_4 = "0";
                          }
                          else{
                              $flowmeter_akhir_4 = $row->flowmeter_akhir_4;
                          }

                          if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                              $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;
                              $flow_sebelum = $flowmeter_awal_4;
                              $flow_sesudah = $flowmeter_akhir_4;

                              if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                  $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                                  $flow_sebelum .= " , ".$flowmeter_awal_3;
                                  $flow_sesudah .= " , ".$flowmeter_akhir_3;

                                  if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                      $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                      $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                      $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                                  } else{
                                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                      $flow_sebelum .= " , ".$flowmeter_awal;
                                      $flow_sesudah .= " , ".$flowmeter_akhir;
                                  }
                              }
                              else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                  $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                              }
                              else {
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir;
                              }
                          }
                          else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                              $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                              $flow_sebelum = $flowmeter_awal_3;
                              $flow_sesudah = $flowmeter_akhir_3;

                              if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                  $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                              } else {
                                  $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                  $flow_sebelum .= " , ".$flowmeter_awal;
                                  $flow_sesudah .= " , ".$flowmeter_akhir;
                              }
                          }
                          else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                              $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum = $flowmeter_awal_2." , ".$flowmeter_awal;
                              $flow_sesudah = $flowmeter_akhir_2." , ".$flowmeter_akhir;
                          }
                          else{
                              $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum = $flowmeter_awal;
                              $flow_sesudah = $flowmeter_akhir;
                          }

                          if($row->diskon != NULL || $row->diskon != 0){
                              $row->tarif -= $row->tarif * $row->diskon/100;
                              $total_pembayaran = $row->tarif * $realisasi;
                          }
                          else{
                              $total_pembayaran = $row->tarif * $realisasi;
                          }

                          if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                              $total_pembayaran += 3000;
                          } else if($total_pembayaran > 1000000){
                              $total_pembayaran += 6000;
                          } else{
                              $total_pembayaran += 0;
                          }

                          $total += $total_pembayaran;
                          $ton += $row->total_permintaan;
                          $ton_realiasi += $realisasi;
                          $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                          if($row->pengguna_jasa_id_tarif == 8){
                              $row->pengguna_jasa_id_tarif = "Peti Kemas";
                          }else{
                              $row->pengguna_jasa_id_tarif = "Tongkang";
                          }

                          $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->id_vessel.'</td>
                            <td align="center">'.$row->nama_vessel.'</td>
                            <td align="center">'.$row->voy_no.'</td>
                            <td align="center">'.$row->pengguna_jasa_id_tarif.'</td>
                            <td align="center">'.$row->nama_agent.'</td>
                            <td align="center">'.$format_tgl.'</td>
                            <td align="center">'.$this->Ribuan($row->tarif).'</td>
                            <td align="center">'.$row->total_permintaan.'</td>
                            <td align="center">'.$realisasi.'</td>
                            <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                        </tr>
                        ';
                          $no++;
                      }
                  }
              }

              if($this->session->userdata('role') == 'keuangan' ){
                  $tabel .= '<tr>
                            <td align="center" colspan="10"><b>Total</b></td>
                            <td align="center"><b>'.$ton.'</b></td>
                            <td align="center"><b>'.$ton_realiasi.'</b></td>
                            <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=laut").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelLaut?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';
              }
              else if($this->session->userdata('role') == 'operasi'){
                  $tabel .= '<tr>
                            <td align="center" colspan="8"><b>Total</b></td>
                            <td align="center"><b>'.$ton.'</b></td>
                            <td align="center"><b>'.$ton_realiasi.'</b></td>
                            <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=laut_operasi").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelLaut?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';
              }
              else {
                  $tabel .= '<tr>
                            <td align="center" colspan="9"><b>Total</b></td>
                            <td align="center"><b>'.$ton.'</b></td>
                            <td align="center"><b>'.$ton_realiasi.'</b></td>
                            <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=laut_operasi").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelLaut?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';
              }

              $data = array(
                  'status' => 'success',
                  'tabel' => $tabel
              );
          }
          else{
              $data = array(
                  'status' => 'failed'
              );
          }

          echo json_encode($data);
      }

      public function laporan_ruko() {
          $tgl_awal = $this->input->post('tgl_awal');
          $tgl_akhir = $this->input->post('tgl_akhir');

          $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"ruko");

          if($result != NULL){
              $total_pembayaran =0;
              $ton_total = 0;
              $ton = 0;
              $no = 1;
              $no_perjanjian='';

              $tabel = '<center><h4>Laporan Pendapatan Air Ruko Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center">No</th>
                                <th align="center">ID Flow Meter</th>
                                <th align="center">Nama Tenant</th>
                                <th align="center">No Perjanjian</th>
                                <th align="center">Tarif</th>
                                <th align="center">Diskon</th>
                                <th align="center">Pemakaian Awal</th>
                                <th align="center">Pemakaian Akhir</th>
                                <th align="center">Total Penggunaan</th>
                                <th align="center">Total Pembayaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';

              foreach($result as $row){
                  $data_tagihan = $this->data->getTagihan($tgl_awal,$tgl_akhir,$row->id_flow);

                  $ttl_akhir = 0;
                  $ttl_awal = 0;
                  $i = 1;
                  $diskon = '';

                  if($data_tagihan != NULL) {
                      foreach ($data_tagihan as $data) {
                          if ($data->id_ref_flowmeter == $row->id_flow) {
                              if ($i == 1 && $data->flow_hari_ini != NULL) {
                                  $ttl_awal = $data->flow_hari_ini;
                              } else {
                                  if ($ttl_awal == 0) {
                                      $ttl_awal = $data->flow_hari_ini;
                                  }
                              }
                              if ($i == count($data_tagihan) && $data->flow_hari_ini != NULL) {
                                  $ttl_akhir = $data->flow_hari_ini;
                              }
                              $i++;
                          } else {
                              $i = 1;
                          }
                      }

                      $ton_koma = $ttl_akhir - $ttl_awal;
                      $ton_total += $ton_koma;
                      $ton = $this->Koma($ton_koma);
                      $diskon = $row->diskon;
                      $tarif = $row->tarif;
                  } else{
                      $ton = 0;
                      $no_perjanjian = $row->no_perjanjian;
                      $diskon = '';
                      $tarif = $row->nominal;
                  }
                      if($row->id_ref_tenant == NULL){
                          if($row->diskon != NULL){
                              $pembayaran = ($row->tarif - ($row->tarif * $row->diskon/100)) * $ton;
                          }
                          else{
                              $pembayaran = $row->tarif * $ton;
                          }
                      } else {
                          $date_now = strtotime(date('Y-m-d',time() ));
                          $date_kadaluarsa = strtotime($row->waktu_kadaluarsa);
                          if($date_now < $date_kadaluarsa || $date_now == $date_kadaluarsa)
                              $pembayaran = $row->nominal;
                          else
                              $pembayaran = 0;
                      }

                      $total_pembayaran += $pembayaran;

                      $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->id_flowmeter.'</td>
                            <td align="center">'.$row->nama_tenant.'</td>
                            <td align="center">'.$no_perjanjian.'</td>
                            <td align="center">'.$this->Ribuan($tarif).'</td>
                            <td align="center">'.$diskon.'</td>
                            <td align="center">'.$ttl_awal.'</td>
                            <td align="center">'.$ttl_akhir.'</td>
                            <td align="center">'.$ton.'</td>
                            <td align="center">'.$this->Ribuan($pembayaran).'</td>
                        </tr>
                        ';
                      $no++;

              }

              $tabel .= '<tr>
                            <td align="center" colspan="8"><b>Total</b></td>
                            <td align="center"><b>'.$this->Koma($ton_total).'</b></td>
                            <td align="center"><b>'.$this->Ribuan($total_pembayaran).'</b></td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=ruko").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelRuko?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';

              $data = array(
                  'status' => 'success',
                  'tabel' => $tabel
              );
          }
          else{
              $data = array(
                  'status' => 'failed'
              );
          }

          echo json_encode($data);
      }

      public function laporan_ruko_keuangan() {
          $tgl_awal = $this->input->post('tgl_awal');
          $tgl_akhir = $this->input->post('tgl_akhir');

          $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"ruko_keuangan");

          if($result != NULL){
              $total_pembayaran =0;
              $ton_total = 0;
              $no = 1;

              $tabel = '<center><h4>Laporan Pendapatan Air Ruko Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center">No</th>
                                <th align="center">No Invoice</th>
                                <th align="center">No Nota</th>
                                <th align="center">No Faktur</th>
                                <th align="center">Nama Tenant</th>
                                <th align="center">No Perjanjian</th>
                                <th align="center">Alamat</th>
                                <th align="center">No. Telepon</th>
                                <th align="center">Total Penggunaan</th>
                                <th align="center">Total Pembayaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';

              foreach($result as $row){
                  $data_tagihan = $this->data->getTagihan($tgl_awal,$tgl_akhir,$row->id_flow);

                  $ttl_akhir = 0;
                  $ttl_awal = 0;
                  $no_perjanjian = '';
                  $i = 1;

                  if($data_tagihan != NULL) {
                      foreach ($data_tagihan as $data) {
                          if ($data->id_ref_flowmeter == $row->id_flow) {
                              if ($i == 1 && $data->flow_hari_ini != NULL) {
                                  $ttl_awal = $data->flow_hari_ini;
                              } else {
                                  if ($ttl_awal == 0) {
                                      $ttl_awal = $data->flow_hari_ini;
                                  }
                              }
                              if ($i == count($data_tagihan) && $data->flow_hari_ini != NULL) {
                                  $ttl_akhir = $data->flow_hari_ini;
                              }
                              $i++;
                          } else {
                              $i = 1;
                          }
                      }

                      $ton_koma = $ttl_akhir - $ttl_awal;
                      $ton_total += $ton_koma;
                      $ton = $this->Koma($ton_koma);
                  } else{
                      $ton = 0;
                      $no_perjanjian = $row->no_perjanjian;
                  }

                      if($row->id_ref_tenant == NULL){
                          if($row->diskon != NULL){
                              $pembayaran = ($row->tarif - ($row->tarif * $row->diskon/100)) * $ton;
                          }
                          else{
                              $pembayaran = $row->tarif * $ton;
                          }
                      } else {
                          $date_now = strtotime(date('Y-m-d',time() ));
                          $date_kadaluarsa = strtotime($row->waktu_kadaluarsa);
                          if($date_now < $date_kadaluarsa || $date_now == $date_kadaluarsa)
                              $pembayaran = $row->nominal;
                          else
                              $pembayaran = 0;
                      }

                      $total_pembayaran += $pembayaran;

                      $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->no_invoice.'</td>
                            <td align="center">'.$row->no_nota.'</td>
                            <td align="center">'.$row->no_faktur.'</td>
                            <td align="center">'.$row->nama_tenant.'</td>
                            <td align="center">'.$no_perjanjian.'</td>
                            <td align="center">'.$row->lokasi.'</td>
                            <td align="center">'.$row->no_telp.'</td>
                            <td align="center">'.$ton.'</td>
                            <td align="center">'.$this->Ribuan($pembayaran).'</td>
                        </tr>
                        ';
                      $no++;

              }

              $tabel .= '<tr>
                            <td align="center" colspan="8"><b>Total</b></td>
                            <td align="center"><b>'.$this->Koma($ton_total).'</b></td>
                            <td align="center"><b>'.$this->Ribuan($total_pembayaran).'</b></td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=ruko_keuangan").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelRuko?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';

              $data = array(
                  'status' => 'success',
                  'tabel' => $tabel
              );
          }
          else{
              $data = array(
                  'status' => 'failed'
              );
          }

          echo json_encode($data);
      }

      public function laporan_flow() {
          $tgl_awal = $this->input->post('tgl_akhir');
          $tgl_akhir = $this->input->post('tgl_akhir');
          $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"flow");

          if($result != NULL){
              $ton_total = 0;
              $no = 1;
              $tabel = '<center><h4>Laporan Pencatatan Flow Meter Per Tanggal '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center"><center>No</th>
                                <th align="center"><center>ID Flow Meter</th>
                                <th align="center"><center>Nama Flow Meter</th>
                                <th align="center"><center>Nilai Flow</th>
                                <th align="center"><center>Issued By</th>
                            </tr>
                        </thead>
                        <tbody>';

              foreach($result as $row){
                  $data_tagihan = $this->data->getFlow($tgl_awal,$tgl_akhir,$row->id_flow);
                  $ttl_akhir = 0;
                  $ttl_awal = 0;
                  $i = 1;
                  $status_rekam = 0;
                  if($data_tagihan != NULL){
                      foreach($data_tagihan as $data) {
                          if($data->id_ref_flowmeter == $row->id_flow){
                              if($i == 1 && $data->flow_hari_ini != NULL){
                                  $ttl_awal = $data->flow_hari_ini;
                              }
                              else{
                                  if($ttl_awal == 0){
                                      $ttl_awal = $data->flow_hari_ini;
                                  }
                              }
                              if($i == count($data_tagihan) && $data->flow_hari_ini != NULL){
                                  $ttl_akhir = $data->flow_hari_ini;
                              }
                              $i++;
                              $status_rekam = $data->status_perekaman;
                              $issuer = $data->issued_by;
                          }else{
                              $i=1;
                              $status_rekam = 0;
                          }
                      }

                      if($status_rekam == 1){
                          $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->id_flowmeter.'</td>
                            <td align="center">'.$row->nama_flowmeter.'</td>
                            <td align="center">'.$ttl_akhir.'</td>
                            <td align="center">'.$issuer.'</td>
                        </tr>
                        ';
                          $no++;
                      }
                  }
              }

              $tabel .= '
                    </tbody>
                    </table>
                    <!---
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=flow").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelFlow?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>
                     --->
                    ';

              $data = array(
                  'status' => 'success',
                  'tabel' => $tabel
              );
          }
          else{
              $data = array(
                  'status' => 'failed'
              );
          }

          echo json_encode($data);
      }

      public function laporan_per_flow() {
          $tgl_awal = $this->input->post('tgl_awal');
          $tgl_akhir = $this->input->post('tgl_akhir');
          $id_flow = $this->input->post('id_flow');

          $no = 1;
          $data = $this->data->getFlow($tgl_awal,$tgl_akhir,$id_flow);
          $data_flow = $this->data->getDataFlowmeter($tgl_awal,$tgl_akhir,$id_flow);
          $tabel = '';

          if($data != NULL){
                  $tabel = '
                    <div class="col-sm-7">
                    <table class="table table-responsive table-condensed table-striped">
                        <tr>
                            <td>ID Flow Meter</td>
                            <td>:</td>
                            <td>'.$data_flow->id_flowmeter.'</td>
                        </tr>
                        <tr>
                            <td>Nama Flow Meter</td>
                            <td>:</td>
                            <td>'.$data_flow->nama_flowmeter.'</td>
                        </tr>
                    </table>
                    </div>';
                  $tabel .='
                    <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <td>No</td>
                            <td>Tanggal Pencatatan</td>
                            <td>Nilai Flow</td>
                            <td>Issuer</td>
                        </thead>
                ';
                  foreach ($data as $row){
                      $tabel .= '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$row->waktu_perekaman.'</td>
                            <td>'.$row->flow_hari_ini.'</td>
                            <td>'.$row->issued_by.'</td>
                        </tr>';
                      $no++;
                  }
                  $tabel .= '</table>';


              $data = array(
                  'status' => 'success',
                  'tabel' => $tabel,
                  'url' => '<a class="btn btn-primary" target="_self" href='.base_url('main/buatTagihan?id=').$id_flow."&tgl_awal=".$tgl_awal."&tgl_akhir=".$tgl_akhir.'>Buat Tagihan</a>'
              );
          }
          else{
              $data = array(
                  'status' => 'fail',
                  'message' => 'Data Tidak Ada'
              );
          }
          echo json_encode($data);
      }

      public function laporan_sumur() {
          $tgl_awal = $this->input->post('tgl_awal');
          $tgl_akhir = $this->input->post('tgl_akhir');
          $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"sumur");

          if($result != NULL){
              $ton_total = 0;
              $no = 1;
              $tabel = '<center><h4>Laporan Pencatatan Sumur Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr>
                                <th align="center"><center>No</th>
                                <th align="center"><center>ID Sumur</th>
                                <th align="center"><center>Nama Sumur</th>
                                <th align="center"><center>Nama Pompa</th>
                                <th align="center"><center>Nama Flow Meter</th>
                                <th align="center"><center>Start Running</th>
                                <th align="center"><center>Cuaca</th>
                                <th align="center"><center>Debit Air (L/Detik)</th>
                                <th align="center"><center>Nilai Flow (m3)</th>
                                <th align="center"><center>Finish Running</th>
                                <th align="center"><center>Cuaca</th>
                                <th align="center"><center>Debit Air (L/Detik)</th>
                                <th align="center"><center>Nilai Flow Akhir (m3)</th>
                                <th align="center"><center>Pemakaian (m3)</th>
                                <th align="center"><center>Issued By</th>
                            </tr>
                        </thead>
                        <tbody>';

              foreach($result as $row){
                  $ttl_akhir = 0;
                  $ttl_awal = 0;

                  $ttl_akhir = $row->flow_sumur_akhir;
                  $ttl_awal = $row->flow_sumur_awal;

                  $ton_koma = $ttl_akhir - $ttl_awal;
                  $ton_total += $ton_koma;
                  $ton = $this->Koma($ton_koma);

                  $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->id_sumur.'</td>
                            <td align="center">'.$row->nama_sumur.'</td>
                            <td align="center">'.$row->nama_pompa.'</td>
                            <td align="center">'.$row->nama_flowmeter.'</td>
                            <td align="center">'.$row->waktu_rekam_awal.'</td>
                            <td align="center">'.$row->cuaca_awal.'</td>
                            <td align="center">'.$row->debit_air_awal.'</td>
                            <td align="center">'.$row->flow_sumur_awal.'</td>
                            <td align="center">'.$row->waktu_rekam_akhir.'</td>
                            <td align="center">'.$row->cuaca_akhir.'</td>
                            <td align="center">'.$row->debit_air_akhir.'</td>
                            <td align="center">'.$row->flow_sumur_akhir.'</td>
                            <td align="center">'.$ton.'</td>
                            <td align="center">'.$row->issued_by.'</td>
                        </tr>
                        ';
                  $no++;

              }

              $tabel .= '<tr>
                            <td align="center" colspan="13"><b>Total</b></td>
                            <td align="center"><b>'.$this->Koma($ton_total).'</b></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/cetakLaporan?id=".$tgl_awal."&id2=".$tgl_akhir."&tipe=sumur").'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("main/excelSumur?id=".$tgl_awal."&id2=".$tgl_akhir).'>Cetak Excel</a>';

              $data = array(
                  'status' => 'success',
                  'tabel' => $tabel
              );
          }
          else{
              $data = array(
                  'status' => 'failed'
              );
          }

          echo json_encode($data);
      }

      public function cetakLaporan(){
          $tgl_awal = $this->input->get('id');
          $tgl_akhir = $this->input->get('id2');
          $tipe = $this->input->get("tipe");
          ini_set('memory_limit', '256M');
          if($tipe == "darat"){
              $data['title'] = 'Laporan Transaksi Air Darat Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
              $data['laporan'] = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang

              $this->load->view('v_cetaklaporan', $data);

              $paper_size  = 'A4'; //paper size
              $orientation = 'landscape'; //tipe format kertas
              $html = $this->output->get_output();

              $this->dompdf->set_paper($paper_size, $orientation);
              //Convert to PDF
              $this->dompdf->load_html($html);
              $this->dompdf->render();
              $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
          }
          else if($tipe == "laut"){
              $data['title'] = 'Laporan Transaksi Air Kapal Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
              $data['laporan'] = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang

              $this->load->view('v_cetaklaporan', $data);

              $paper_size  = 'A4'; //paper size
              $orientation = 'landscape'; //tipe format kertas
              $html = $this->output->get_output();

              $this->dompdf->set_paper($paper_size, $orientation);
              //Convert to PDF
              $this->dompdf->load_html($html);
              $this->dompdf->render();
              $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
          }
          else if($tipe == "laut_operasi"){
              $data['title'] = 'Laporan Transaksi Air Kapal Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
              $data['laporan'] = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang

              $this->load->view('v_cetaklaporan', $data);

              $paper_size  = 'A4'; //paper size
              $orientation = 'landscape'; //tipe format kertas
              $html = $this->output->get_output();

              $this->dompdf->set_paper($paper_size, $orientation);
              //Convert to PDF
              $this->dompdf->load_html($html);
              $this->dompdf->render();
              $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
          }
          else if($tipe == "flow"){
              $data['title'] = 'Laporan Pencatatan Flow Meter Per Tanggal '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
              $data['laporan'] = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang
              $data['tgl_awal'] = $tgl_awal;
              $data['tgl_akhir'] = $tgl_akhir;
              $this->load->view('v_cetaklaporan', $data);

              $paper_size  = 'A4'; //paper size
              $orientation = 'landscape'; //tipe format kertas
              $html = $this->output->get_output();

              $this->dompdf->set_paper($paper_size, $orientation);
              //Convert to PDF
              $this->dompdf->load_html($html);
              $this->dompdf->render();
              $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
          }
          else if($tipe == "sumur"){
              $data['title'] = 'Laporan Pencatatan Sumur Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
              $data['laporan'] = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang
              $data['tgl_awal'] = $tgl_awal;
              $data['tgl_akhir'] = $tgl_akhir;
              $this->load->view('v_cetaklaporan', $data);

              $paper_size  = 'A4'; //paper size
              $orientation = 'landscape'; //tipe format kertas
              $html = $this->output->get_output();

              $this->dompdf->set_paper($paper_size, $orientation);
              //Convert to PDF
              $this->dompdf->load_html($html);
              $this->dompdf->render();
              $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
          }
          else if($tipe == "ruko_keuangan"){
              $data['title'] = 'Laporan Transaksi Air Ruko Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
              $data['laporan'] = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang
              $data['tgl_awal'] = $tgl_awal;
              $data['tgl_akhir'] = $tgl_akhir;
              $this->load->view('v_cetaklaporan', $data);

              $paper_size  = 'A4'; //paper size
              $orientation = 'landscape'; //tipe format kertas
              $html = $this->output->get_output();

              $this->dompdf->set_paper($paper_size, $orientation);
              //Convert to PDF
              $this->dompdf->load_html($html);
              $this->dompdf->render();
              $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
          }
          else{
              $data['title'] = 'Laporan Transaksi Air Ruko Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
              $data['laporan'] = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang
              $data['tgl_awal'] = $tgl_awal;
              $data['tgl_akhir'] = $tgl_akhir;
              $this->load->view('v_cetaklaporan', $data);

              $paper_size  = 'A4'; //paper size
              $orientation = 'landscape'; //tipe format kertas
              $html = $this->output->get_output();

              $this->dompdf->set_paper($paper_size, $orientation);
              //Convert to PDF
              $this->dompdf->load_html($html);
              $this->dompdf->render();
              $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
          }
      }

      public function cetakTagihan(){
          $tgl_awal = $this->input->get('tgl_awal');
          $tgl_akhir = $this->input->get('tgl_akhir');
          $id_flowmeter = $this->input->get('id');
          $row = $this->data->get_by_id("ruko",$id_flowmeter);
          $data['title'] = 'Tagihan Penggunaan Air Periode '.date('d-M-Y', strtotime($tgl_awal)).' s/d '.date('d-M-Y', strtotime($tgl_akhir)); //judul title

          if($row->id_ref_tenant != NULL){
              $data['tagihan'] = $this->data->getTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
              $data['data_tagihan'] = $this->data->getDataTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
              $data['detail_tagihan'] = $this->data->getDetailTagihan($id_flowmeter);
          } else{
              $data['tagihan'] = $this->data->getTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
              $data['data_tagihan'] = $this->data->getDataTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
              $data['detail_tagihan'] = $this->data->getDetailTagihan($id_flowmeter);
          }
          $this->load->view('v_cetaktagihan', $data);

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
          $data = $this->data->getTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
          $data_tagihan = $this->data->getDataTagihan($tgl_awal,$tgl_akhir,$id_flowmeter);
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
                      'url' => '<a class="btn btn-primary" target="_self" href=' . base_url('main/buatTagihan?id=') . $id_flowmeter . "&tgl_awal=" . $tgl_awal . "&tgl_akhir=" . $tgl_akhir . '>Buat Tagihan</a>'
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
                      'url' => '<a class="btn btn-primary" target="_self" href=' . base_url('main/buatTagihan?id=') . $id_flowmeter . "&tgl_awal=" . $tgl_awal . "&tgl_akhir=" . $tgl_akhir . '>Buat Tagihan</a>'
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
                  'url' => '<a class="btn btn-primary" target="_self" href=' . base_url('main/buatTagihan?id=') . $id_flowmeter . "&tgl_awal=" . $tgl_awal . "&tgl_akhir=" . $tgl_akhir . '>Buat Tagihan</a>'
              );
          }

          echo json_encode($data);
      }

      public function tagihan(){
          $id = $this->input->get('id');
          $data['data'] = $this->data->get_by_id("ruko",$id);
          $data['title'] = 'Tagihan Penggunaan';
          $this->load->template('v_tagihan',$data);
      }

      public function buatTagihan(){
          $total = 0;
          $ttl_awal = 0;
          $ttl_akhir = 0;
          $tarif = 0;
          $i = 1;
          $id = $this->input->get('id');
          $tgl_awal = $this->input->get('tgl_awal');
          $tgl_akhir = $this->input->get('tgl_akhir');
          $tagihan = $this->data->getTagihan($tgl_awal,$tgl_akhir,$id);
          $data_tagihan = $this->data->getDataTagihan($tgl_awal,$tgl_akhir,$id);
          $invoice = $this->data->get_no_invoice();
          $tgl_tahun = date("YYYY",time());
          $bulan = date("m",time());

          $data_tenant = $this->data->getDataTenant($id);
          $data_tarif = $this->data->getDataTarif($data_tenant->pengguna_jasa_id);


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
              $total = $data_tagihan->nominal;
              $tarif = $total;
              $diskon = '';
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

          $result = $this->data->tagihanTenant($data);

          if($result != NULL){
              $web = base_url('main/view?id=tagihan');
              echo "<script type='text/javascript'>
                        alert('Tagihan Berhasil Dibuat')
                        window.location.replace('$web')
                      </script>";
          }
      }

      public function updatePerekaman(){
          $tipe = $this->input->post('action');

          if($tipe == 'batal'){
              $result = $this->data->setPerekaman($tipe);

              if($result){	//jika data berhasil dihapus
                  echo '<script language="javascript">alert("Berhasil Membatalkan Data"); document.location="'.base_url("main/view?id=riwayat_pencatatan_flow").'";</script>';
              }else{		//jika gagal menghapus data
                  echo '<script language="javascript">alert("Gagal Membatalkan Data"); document.location="'.base_url("main/view?id=riwayat_pencatatan_flow").'";</script>';
              }
          }
          else{
              $result = $this->data->setPerekaman($tipe);

              if($result){	//jika data berhasil dihapus
                  echo '<script language="javascript">alert("Berhasil Memvalidasi Data"); document.location="'.base_url("main/view?id=riwayat_pencatatan_flow").'";</script>';
              }else{		//jika gagal menghapus data
                  echo '<script language="javascript">alert("Gagal Memvalidasi Data"); document.location="'.base_url("main/view?id=riwayat_pencatatan_flow").'";</script>';
              }
          }
      }

      public function updatePencatatan(){
          $tipe = $this->input->post('action');

          if($tipe == 'batal'){
              $result = $this->data->setPencatatan($tipe);

              if($result){	//jika data berhasil dihapus
                  echo '<script language="javascript">alert("Berhasil Membatalkan Data"); document.location="'.base_url("main/view?id=riwayat_pencatatan_sumur").'";</script>';
              }else{		//jika gagal menghapus data
                  echo '<script language="javascript">alert("Gagal Membatalkan Data"); document.location="'.base_url("main/view?id=riwayat_pencatatan_sumur").'";</script>';
              }
          }
          else{
              $result = $this->data->setPencatatan($tipe);

              if($result){	//jika data berhasil dihapus
                  echo '<script language="javascript">alert("Berhasil Memvalidasi Data"); document.location="'.base_url("main/view?id=riwayat_pencatatan_sumur").'";</script>';
              }else{		//jika gagal menghapus data
                  echo '<script language="javascript">alert("Gagal Memvalidasi Data"); document.location="'.base_url("main/view?id=riwayat_pencatatan_sumur").'";</script>';
              }
          }
      }

      public function riwayat_catat_flow(){
          $tgl_awal = $this->input->post('tgl_awal');
          $tgl_akhir = $this->input->post('tgl_akhir');

          $result = $this->data->riwayat_flow($tgl_awal,$tgl_akhir);

          if($result != NULL){
              $no = 1;
              $tabel = '
                    <h4>Riwayat Pencatatan Harian Periode '.date('d-m-Y',strtotime($tgl_awal)).' s/d '.date('d-m-Y',strtotime($tgl_akhir)).' </h4>
                    <form action="'.base_url('main/updatePerekaman').'" method="post">
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
                        <tbody>
              ';

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

      public function riwayat_catat_sumur(){
          $tgl_awal = $this->input->post('tgl_awal');
          $tgl_akhir = $this->input->post('tgl_akhir');

          $result = $this->data->riwayat_sumur($tgl_awal,$tgl_akhir);

          if($result != NULL){
              $no = 1;
              $tabel = '
                    <h4>Riwayat Pencatatan Harian Periode '.date('d-m-Y',strtotime($tgl_awal)).' s/d '.date('d-m-Y',strtotime($tgl_akhir)).' </h4>
                    <form action="'.base_url('main/updatePencatatan').'" method="post">
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
                        <tbody>
              ';

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

      function cetakKwitansi(){
          $id = $this->input->get('id');
          define('FPDF_FONTPATH',$this->config->item('fonts_path'));
          $query = $this->data->cetakkwitansi("darat",$id);

          $tanggal = $this->indonesian_date('d M Y', '','');
          $tgl_permintaan = $this->indonesian_date('l, d M Y', $query->tgl_perm_pengantaran,'');

          if($query->diskon != NULL || $query->diskon != 0){
              $tarif = $this->Ribuan($query->tarif - ($query->diskon / 100 * $query->tarif));
              $total = $this->Ribuan(($query->tarif - ($query->diskon / 100 * $query->tarif)) * $query->total_permintaan);
              $terbilang = $this->terbilang(($query->tarif - ($query->diskon / 100 * $query->tarif)) * $query->total_permintaan);
          }else{
              $tarif = $this->Ribuan($query->tarif);
              $total = $this->Ribuan($query->tarif * $query->total_permintaan);
              $terbilang = $this->terbilang($query->tarif * $query->total_permintaan);
          }

          $hasil = array(
              'nama_pelanggan' => $query->nama_pengguna_jasa,
              'nama_pemohon' => $query->nama_pemohon,
              'alamat' => $query->alamat,
              'tanggal' => $tanggal,
              'tgl_perm' => $tgl_permintaan,
              'total_pengisian' => $query->total_permintaan,
              'tarif' => $tarif,
              'total' => $total,
              'loket' => $this->session->userdata('nama'),
              'kwitansi' => $query->no_kwitansi,
              'terbilang' => $terbilang." Rupiah"
          );
          $data['hasil'] = $hasil;
          $this->load->view('v_kwitansi', $data);
      }

      function cetakPerhitunganPiutang(){
          $id = $this->input->get('id');
          define('FPDF_FONTPATH',$this->config->item('fonts_path'));
          $query = $this->data->cetakkwitansi("darat",$id);

          $tanggal = $this->indonesian_date('l, d M Y', '','');
          $tgl_permintaan = date("d M Y", strtotime($query->tgl_perm_pengantaran));

          if($query->diskon != NULL || $query->diskon != 0){
              $tarif = $this->Ribuan($query->tarif - ($query->diskon / 100 * $query->tarif));
              $total = $this->Ribuan(($query->tarif - ($query->diskon / 100 * $query->tarif)) * $query->total_permintaan);
              $terbilang = $this->terbilang(($query->tarif - ($query->diskon / 100 * $query->tarif)) * $query->total_permintaan);
          }else{
              $tarif = $this->Ribuan($query->tarif);
              $total = $this->Ribuan($query->tarif * $query->total_permintaan);
              $terbilang = $this->terbilang($query->tarif * $query->total_permintaan);
          }


          $hasil = array(
              'nama_pelanggan' => $query->nama_pengguna_jasa,
              'nama_pemohon' => $query->nama_pemohon,
              'alamat' => $query->alamat,
              'tanggal' => $tanggal,
              'tgl_perm' => $tgl_permintaan,
              'total_pengisian' => $query->total_permintaan,
              'tarif' => $tarif,
              'total' => $total,
              'loket' => $this->session->userdata('nama'),
              'terbilang' => $terbilang." Rupiah"
          );
          $data['hasil'] = $hasil;
          $this->load->view('v_perhitungan_piutang', $data);
      }

      function cetakPerhitungan(){
          $id = $this->input->get('id');
          define('FPDF_FONTPATH',$this->config->item('fonts_path'));
          $query = $this->data->cetakkwitansi("laut",$id);

          $tanggal = $this->indonesian_date('d M Y', '','');

          if( ($query->flowmeter_akhir_4 != NULL && $query->flowmeter_awal_4 != NULL) || ($query->flowmeter_akhir_4 != 0 && $query->flowmeter_awal_4 != 0) ){
              $realisasi = $query->flowmeter_akhir_4 - $query->flowmeter_awal_4;
              if( ($query->flowmeter_akhir_3 != NULL && $query->flowmeter_awal_3 != NULL) || ($query->flowmeter_akhir_3 != 0 && $query->flowmeter_awal_3 != 0) ){
                  $realisasi += $query->flowmeter_akhir_3 - $query->flowmeter_awal_3;

                  if( ($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL) || ($query->flowmeter_akhir_2 != 0 && $query->flowmeter_awal_2 != 0) ){
                      $realisasi += $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
                      $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
                  } else{
                      $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
                  }
              }
              else if( ($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL) || ($query->flowmeter_akhir_2 != 0 && $query->flowmeter_awal_2 != 0) ){
                  $realisasi += $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
                  $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
              }
              else {
                  $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
              }
          }
          else if( ($query->flowmeter_akhir_3 != NULL && $query->flowmeter_awal_3 != NULL) || ($query->flowmeter_akhir_3 != 0 && $query->flowmeter_awal_3 != 0) ){
              $realisasi = $query->flowmeter_akhir_3 - $query->flowmeter_awal_3;
              if( ($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL) || ($query->flowmeter_akhir_2 != 0 && $query->flowmeter_awal_2 != 0) ){
                  $realisasi += $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
                  $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
              }
              else {
                  $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
              }
          }
          else if( ($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL) || ($query->flowmeter_akhir_2 != 0 && $query->flowmeter_awal_2 != 0) ){
              $realisasi = $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
              $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
          }
          else{
              $realisasi = $query->flowmeter_akhir - $query->flowmeter_awal;
          }

          if($query->diskon != NULL){
              $tarif = $query->tarif;
              $total = ($query->tarif * $realisasi) - (($query->diskon / 100) * ($query->tarif * $realisasi));
          }else{
              $tarif = $query->tarif;
              $total = $query->tarif * $realisasi;
          }

          if($total >= 250000 && $total <= 1000000){
              $materai = 3000;
              $total_bayar = $total + $materai;
              $terbilang = $this->terbilang($total_bayar);
              $total = $this->Ribuan($total);
              $total_bayar = $this->Ribuan($total_bayar);
              $materai = $this->Ribuan($materai);
          } else if($total > 1000000){
              $materai = 6000;
              $total_bayar = $total + $materai;
              $terbilang = $this->terbilang($total_bayar);
              $total = $this->Ribuan($total);
              $total_bayar = $this->Ribuan($total_bayar);
              $materai = $this->Ribuan($materai);
          } else {
              $materai = 0;
              $total_bayar = $total + $materai;
              $terbilang = $this->terbilang($total_bayar);
              $total = $this->Ribuan($total);
              $total_bayar = $this->Ribuan($total_bayar);
              $materai = $this->Ribuan($materai);
          }

          if($this->session->userdata('role') == 'operasi'){
              $this->data->updatePrint($id);
          }

          $hasil = array(
              'id_lct' => $query->id_vessel,
              'nama_kapal' => $query->nama_vessel,
              'voy_no' => $query->voy_no,
              'pelayaran' => $query->nama_agent,
              'realisasi' => $realisasi,
              'tarif' => $tarif,
              'diskon' => $query->diskon,
              'total' => $total,
              'materai' => $materai,
              'tgl_transaksi' => $this->indonesian_date('l, d M Y', $query->tgl_transaksi,''),
              'tanggal' => $tanggal,
              'nama_pemohon' => $query->nama_pemohon,
              'total_bayar' => $total_bayar,
              'terbilang' => $terbilang
          );
          $data['hasil'] = $hasil;
          $this->load->view('v_perhitungan', $data);
      }

      function cetakPengisian(){
          $id = $this->input->get('id');
          define('FPDF_FONTPATH',$this->config->item('fonts_path'));
          $query = $this->data->cetakkwitansi("laut",$id);

          $tanggal = $this->indonesian_date('d M Y', '','');
          $tgl_transaksi = $this->indonesian_date('l, d M Y', $query->tgl_transaksi,'');

          if($query->flowmeter_akhir_4 != NULL && $query->flowmeter_awal_4 != NULL){
              $realisasi = $query->flowmeter_akhir_4 - $query->flowmeter_awal_4;
              if($query->flowmeter_akhir_3 != NULL && $query->flowmeter_awal_3 != NULL){
                  $realisasi += $query->flowmeter_akhir_3 - $query->flowmeter_awal_3;
                  if($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL){
                      $realisasi += $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
                  }
              }
              $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
          } else if($query->flowmeter_akhir_3 != NULL && $query->flowmeter_awal_3 != NULL){
              $realisasi = $query->flowmeter_akhir_3 - $query->flowmeter_awal_3;
              if($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL){
                  $realisasi += $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
              }
              $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
          } else if($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL){
              $realisasi = $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
              $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
          } else{
              $realisasi = $query->flowmeter_akhir - $query->flowmeter_awal;
          }

          $hasil = array(
              'nama_perusahaan' => $query->nama_agent,
              'kapal' => $query->nama_vessel,
              'voy_no' => $query->voy_no,
              'tgl_transaksi' => $tgl_transaksi,
              'total_permintaan' => $query->total_permintaan,
              'flowmeter_sebelum' => $query->flowmeter_awal,
              'flowmeter_sesudah' => $query->flowmeter_akhir,
              'flowmeter_sebelum_2' => $query->flowmeter_awal_2,
              'flowmeter_sesudah_2' => $query->flowmeter_akhir_2,
              'flowmeter_sebelum_3' => $query->flowmeter_awal_3,
              'flowmeter_sesudah_3' => $query->flowmeter_akhir_3,
              'flowmeter_sebelum_4' => $query->flowmeter_awal_4,
              'flowmeter_sesudah_4' => $query->flowmeter_akhir_4,
              'realisasi' => $realisasi,
              'tanggal' => $tanggal
          );
          $data['hasil'] = $hasil;
          $this->load->view('v_pengisian', $data);
      }

      function cetakPengisianKapal(){
          $id = $this->input->get('id');
          define('FPDF_FONTPATH',$this->config->item('fonts_path'));
          $query = $this->data->cetakkwitansi("laut",$id);

          $tanggal = date('d M Y', time());
          $tgl_transaksi = date('D, d M Y', strtotime($query->tgl_transaksi));
          $realisasi = $query->flowmeter_akhir - $query->flowmeter_awal;

          $hasil = array(
              'nama_perusahaan' => $query->nama_agent,
              'kapal' => $query->nama_vessel,
              'voy_no' => $query->voy_no,
              'tgl_transaksi' => $tgl_transaksi,
              'total_permintaan' => $query->total_permintaan,
              'flowmeter_sebelum' => $query->flowmeter_awal,
              'flowmeter_sesudah' => $query->flowmeter_akhir,
              'realisasi' => $realisasi,
              'tanggal' => $tanggal
          );
          $data['hasil'] = $hasil;
          $this->load->view('v_pengisian_kapal', $data);
      }

      function cetakFPermintaan(){
          $id = $this->input->get('id');
          define('FPDF_FONTPATH',$this->config->item('fonts_path'));
          $query = $this->data->cetakkwitansi("darat",$id);
          $tanggal = date('d M Y', strtotime($query->tgl_transaksi ));
          $jam = date('H.i',strtotime($query->tgl_transaksi));

          $hasil = array(
              'nama_pelanggan' => $query->nama_pengguna_jasa,
              'nama_pemohon' => $query->nama_pemohon,
              'alamat' => $query->alamat,
              'tanggal' => $tanggal,
              'total_pengisian' => $query->total_permintaan,
              'jam' => $jam,
              'no_telp' => $query->no_telp
          );
          $data['hasil'] = $hasil;
          $this->load->view('v_form_permintaan', $data);
      }

      function Koma($angka){
          return number_format($angka,2);
      }

      function Ribuan($angka){
          if($angka == '0')
              return '';
          elseif($angka < 100)
              return $angka.',-';
          else
              return number_format($angka,0,'','.').',-';
      }

      function konversi($x){

          $x = abs($x);
          $angka = array ("","Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
          $temp = "";

          if($x < 12){
              $temp = " ".$angka[$x];
          }else if($x<20){
              $temp = $this->konversi($x - 10)." Belas";
          }else if ($x<100){
              $temp = $this->konversi($x/10)." Puluh". $this->konversi($x%10);
          }else if($x<200){
              $temp = " Seratus".$this->konversi($x-100);
          }else if($x<1000){
              $temp = $this->konversi($x/100)." Ratus".$this->konversi($x%100);
          }else if($x<2000){
              $temp = " Seribu".$this->konversi($x-1000);
          }else if($x<1000000){
              $temp = $this->konversi($x/1000)." Ribu".$this->konversi($x%1000);
          }else if($x<1000000000){
              $temp = $this->konversi($x/1000000)." Juta".$this->konversi($x%1000000);
          }else if($x<1000000000000){
              $temp = $this->konversi($x/1000000000)." Milyar".$this->konversi($x%1000000000);
          }

          return $temp;
      }

      function tkoma($x){
          $str = stristr($x,",");
          $ex = explode(',',$x);

          if(($ex[0]/10) >= 1){
              $a = abs($ex[0]);
          }
          $string = array("Nol", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan","Sepuluh", "Sebelas");
          $temp = "";

          $a2 = $ex[0]/10;
          $pjg = strlen($str);
          $i =1;


          if($a>=1 && $a< 12){
              $temp .= " ".$string[$a];
          }else if($a>12 && $a < 20){
              $temp .= $this->konversi($a - 10)." Belas";
          }else if ($a>20 && $a<100){
              $temp .= $this->konversi($a / 10)." Puluh". $this->konversi($a % 10);
          }else{
              if($a2<1){

                  while ($i<$pjg){
                      $char = substr($str,$i,1);
                      $i++;
                      $temp .= " ".$string[$char];
                  }
              }
          }
          return $temp;
      }

      function terbilang($x){
          if($x<0){
              $hasil = "Minus ".trim($this->konversi(x));
          }else{
              $poin = trim($this->tkoma($x));
              $hasil = trim($this->konversi($x));
          }

          if($poin){
              $hasil = $hasil." Koma ".$poin;
          }else{
              $hasil = $hasil;
          }
          return $hasil;
      }

      function indonesian_date ($date_format = 'D, j-M-Y',$timestamp = '', $suffix = 'WITA') {
          if (trim ($timestamp) == '')
          {
              $timestamp = time ();
          }
          elseif (!ctype_digit ($timestamp))
          {
              $timestamp = strtotime ($timestamp);
          }
          # remove S (st,nd,rd,th) there are no such things in indonesia :p
          $date_format = preg_replace ("/S/", "", $date_format);
          $pattern = array (
              '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
              '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
              '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
              '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
              '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
              '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
              '/April/','/June/','/July/','/August/','/September/','/October/',
              '/November/','/December/',
          );
          $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
              'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
              'Jan ','Feb ','Mar ','Apr ','Mei ','Jun ','Jul ','Ags ','Sep ','Okt ','Nov ','Des ',
              'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
              'Oktober','November','Desember',
          );
          $date = date ($date_format, $timestamp);
          $date = preg_replace ($pattern, $replace, $date);
          $date = "{$date} {$suffix}";

          return $date;
      }

      public function excelDarat()
      {
          if($this->session->userdata('role') == 'keuangan'){
              $tgl_awal = $this->input->get('id');
              $tgl_akhir = $this->input->get('id2');

              $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"darat");

              // Create new PHPExcel object
              $object = new PHPExcel();
              $style = array(
                  'alignment' => array(
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                  )
              );
              $styleArray = array(
                  'borders' => array(
                      'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                      )
                  )
              );
              $font = array(
                  'font'  => array(
                      'bold'  => true,
                      'size'  => 12,
                      'name'  => 'Times New Roman'
                  )
              );

              $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($styleArray);
              $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($font);
              $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
              $object->getActiveSheet()->getStyle('A7:J7')->getAlignment()->setWrapText(true);

              // Set properties
              $object->getProperties()->setCreator($this->session->userdata('nama'))
                  ->setLastModifiedBy($this->session->userdata('nama'))
                  ->setCategory("Approve by ");
              // Add some data
              $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
              $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
              $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);

              $object->getActiveSheet()->mergeCells('A1:J1');
              $object->getActiveSheet()->mergeCells('A2:J2');
              $object->getActiveSheet()->mergeCells('A3:J3');
              $object->getActiveSheet()->mergeCells('A4:J4');
              $object->getActiveSheet()->mergeCells('A5:J5');

              $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
              $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

              $object->setActiveSheetIndex(0)
                  ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('nama'))
                  ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                  ->setCellValue('A4', 'Terminal Peti Kemas')
                  ->setCellValue('A5', 'Laporan Transaksi Air Darat Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                  ->setCellValue('A7', 'No')
                  ->setCellValue('B7', 'No Kwitansi')
                  ->setCellValue('C7', 'Nama Pengguna Jasa')
                  ->setCellValue('D7', 'Nama Pemohon')
                  ->setCellValue('E7', 'Alamat')
                  ->setCellValue('F7', 'No Telepon')
                  ->setCellValue('G7', 'Tanggal Transaksi')
                  ->setCellValue('H7', 'Tarif (Rp.)')
                  ->setCellValue('I7', 'Total Permintaan (Ton)')
                  ->setCellValue('J7', 'Total Pembayaran (Rp.)')
              ;
              $no=0;
              //add data
              $counter=8;
              $total = 0;
              $ton = 0;
              $ex = $object->setActiveSheetIndex(0);
              foreach($result as $row){
                  if($row->status_pembayaran == 1 && $row->status_invoice == 0){
                      $no++;
                      $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);
                      $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($styleArray);

                      if($row->diskon != NULL || $row->diskon != 0){
                          $row->tarif -= $row->tarif * $row->diskon/100;
                          $total_pembayaran = $row->tarif * $row->total_permintaan ;
                      }
                      else{
                          $total_pembayaran = $row->tarif * $row->total_permintaan;
                      }

                      $waktu_awal = mktime(date("H",strtotime($row->waktu_mulai_pengantaran)),date("i",strtotime($row->waktu_mulai_pengantaran)),date("s",strtotime($row->waktu_mulai_pengantaran)),date("m",strtotime($row->waktu_mulai_pengantaran)),date("d",strtotime($row->waktu_mulai_pengantaran)),date("y",strtotime($row->waktu_mulai_pengantaran)));
                      $waktu_akhir = mktime(date("H",strtotime($row->waktu_selesai_pengantaran)),date("i",strtotime($row->waktu_selesai_pengantaran)),date("s",strtotime($row->waktu_selesai_pengantaran)),date("m",strtotime($row->waktu_selesai_pengantaran)),date("d",strtotime($row->waktu_selesai_pengantaran)),date("y",strtotime($row->waktu_selesai_pengantaran)) );

                      $total += $total_pembayaran;
                      $ton += $row->total_permintaan;
                      $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));

                      $ex->setCellValue("A".$counter,"$no");
                      $ex->setCellValue("B".$counter,"$row->no_kwitansi");
                      $ex->setCellValue("C".$counter,"$row->nama_pengguna_jasa");
                      $ex->setCellValue("D".$counter,"$row->nama_pemohon");
                      $ex->setCellValue("E".$counter,"$row->alamat");
                      $ex->setCellValue("F".$counter,"$row->no_telp");
                      $ex->setCellValue("G".$counter,"$format_tgl");
                      $ex->setCellValue("H".$counter,"$row->tarif");
                      $ex->setCellValue("I".$counter,"$row->total_permintaan");
                      $ex->setCellValue("J".$counter,"$total_pembayaran");
                      $counter=$counter+1;
                  }
              }
              $object->getActiveSheet()->mergeCells('A'.$counter.':I'.$counter);
              $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($styleArray);
              $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);

              $ex->setCellValue("A".$counter,"Total");
              $ex->setCellValue("I".$counter,"$ton");
              $ex->setCellValue("J".$counter,"$total");
              // Rename sheet
              $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Darat');

              // Set active sheet index to the first sheet, so Excel opens this as the first sheet
              $object->setActiveSheetIndex(0);

              // Redirect output to a client’s web browser (Excel2007)
              header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Content-Disposition: attachment;filename="Laporan_Transaksi_Darat_periode_'.$_GET['id'].'_'.$_GET['id2'].'.xlsx"');
              header('Cache-Control: max-age=0');

              $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
              $objWriter->save('php://output');
          }
          else if($this->session->userdata('role') == 'operasi'){
              $tgl_awal = $this->input->get('id');
              $tgl_akhir = $this->input->get('id2');

              $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"darat");

              // Create new PHPExcel object
              $object = new PHPExcel();
              $style = array(
                  'alignment' => array(
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                  ),
                  'borders' => array(
                      'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                      )
                  )
              );
              $font = array(
                  'font'  => array(
                      'bold'  => true,
                      'size'  => 12,
                      'name'  => 'Times New Roman'
                  )
              );
              $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($font);
              $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
              $object->getActiveSheet()->getStyle('A7:J7')->getAlignment()->setWrapText(true);

              // Set properties
              $object->getProperties()->setCreator($this->session->userdata('nama'))
                  ->setLastModifiedBy($this->session->userdata('nama'))
                  ->setCategory("Approve by ");
              // Add some data
              $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
              $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
              $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);

              $object->getActiveSheet()->mergeCells('A1:J1');
              $object->getActiveSheet()->mergeCells('A2:J2');
              $object->getActiveSheet()->mergeCells('A3:J3');
              $object->getActiveSheet()->mergeCells('A4:J4');
              $object->getActiveSheet()->mergeCells('A5:J5');

              $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
              $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

              $object->setActiveSheetIndex(0)
                  ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('nama'))
                  ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                  ->setCellValue('A4', 'Terminal Peti Kemas')
                  ->setCellValue('A5', 'Laporan Transaksi Air Darat Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                  ->setCellValue('A7', 'No')
                  ->setCellValue('B7', 'No Kwitansi')
                  ->setCellValue('C7', 'Nama Pengguna Jasa')
                  ->setCellValue('D7', 'Nama Pemohon')
                  ->setCellValue('E7', 'Alamat')
                  ->setCellValue('F7', 'No Telepon')
                  ->setCellValue('G7', 'Tanggal Transaksi')
                  ->setCellValue('H7', 'Tarif (Rp.)')
                  ->setCellValue('I7', 'Total Permintaan (Ton)')
                  ->setCellValue('J7', 'Total Pembayaran (Rp.)')
              ;
              $no=0;
              //add data
              $counter=8;
              $total = 0;
              $ton = 0;
              $ex = $object->setActiveSheetIndex(0);
              foreach($result as $row){
                  $no++;

                  $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);

                  if($row->batal_kwitansi == 1){
                      $total_pembayaran = '';
                  }
                  else if($row->diskon != NULL || $row->diskon != 0){
                      $row->tarif -= $row->tarif * $row->diskon/100;
                      $total_pembayaran = $row->tarif * $row->total_permintaan ;
                  }
                  else{
                      $total_pembayaran = $row->tarif * $row->total_permintaan;
                  }

                  if($row->batal_kwitansi == 0){
                      $total += $total_pembayaran;
                      $ton += $row->total_permintaan;
                  }

                  $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));

                  $ex->setCellValue("A".$counter,"$no");
                  $ex->setCellValue("B".$counter,"$row->no_kwitansi");
                  $ex->setCellValue("C".$counter,"$row->nama_pengguna_jasa");
                  $ex->setCellValue("D".$counter,"$row->nama_pemohon");
                  $ex->setCellValue("E".$counter,"$row->alamat");
                  $ex->setCellValue("F".$counter,"$row->no_telp");
                  $ex->setCellValue("G".$counter,"$format_tgl");
                  $ex->setCellValue("H".$counter,"$row->tarif");
                  $ex->setCellValue("I".$counter,"$row->total_permintaan");
                  $ex->setCellValue("J".$counter,"$total_pembayaran");
                  $counter=$counter+1;

              }
              $object->getActiveSheet()->mergeCells('A'.$counter.':I'.$counter);
              $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);

              $ex->setCellValue("A".$counter,"Total");
              $ex->setCellValue("I".$counter,"$ton");
              $ex->setCellValue("J".$counter,"$total");
              // Rename sheet
              $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Darat');

              // Set active sheet index to the first sheet, so Excel opens this as the first sheet
              $object->setActiveSheetIndex(0);

              // Redirect output to a client’s web browser (Excel2007)
              header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Content-Disposition: attachment;filename="Laporan_Transaksi_Darat_periode_'.$_GET['id'].'_'.$_GET['id2'].'.xlsx"');
              header('Cache-Control: max-age=0');

              $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
              $objWriter->save('php://output');
          }
          else if($this->session->userdata('role') == 'loket'){
              $tgl_awal = $this->input->get('id');
              $tgl_akhir = $this->input->get('id2');

              $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"darat");

              // Create new PHPExcel object
              $object = new PHPExcel();
              $style = array(
                  'alignment' => array(
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                  ),
                  'borders' => array(
                      'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                      )
                  )
              );
              $font = array(
                  'font'  => array(
                      'bold'  => true,
                      'size'  => 12,
                      'name'  => 'Times New Roman'
                  )
              );
              $object->getActiveSheet()->getStyle("A7:M7")->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A7:M7")->applyFromArray($font);
              $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
              $object->getActiveSheet()->getStyle('A7:M7')->getAlignment()->setWrapText(true);

              // Set properties
              $object->getProperties()->setCreator($this->session->userdata('nama'))
                  ->setLastModifiedBy($this->session->userdata('nama'))
                  ->setCategory("Approve by ");
              // Add some data
              $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
              $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
              $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('L')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('M')->setWidth(20);

              $object->getActiveSheet()->mergeCells('A1:M1');
              $object->getActiveSheet()->mergeCells('A2:M2');
              $object->getActiveSheet()->mergeCells('A3:M3');
              $object->getActiveSheet()->mergeCells('A4:M4');
              $object->getActiveSheet()->mergeCells('A5:M5');

              $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
              $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

              $object->setActiveSheetIndex(0)
                  ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('nama'))
                  ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                  ->setCellValue('A4', 'Terminal Peti Kemas')
                  ->setCellValue('A5', 'Laporan Transaksi Air Darat Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                  ->setCellValue('A7', 'No')
                  ->setCellValue('B7', 'Nama Pengguna Jasa')
                  ->setCellValue('C7', 'Nama Pemohon')
                  ->setCellValue('D7', 'Alamat')
                  ->setCellValue('E7', 'No Telepon')
                  ->setCellValue('F7', 'Tanggal Transaksi')
                  ->setCellValue('G7', 'Tanggal Waktu Pengantaran')
                  ->setCellValue('H7', 'Waktu Mulai Pengantaran')
                  ->setCellValue('I7', 'Waktu Selesai Pengantaran')
                  ->setCellValue('J7', 'Lama Pengantaran (Jam)')
                  ->setCellValue('K7', 'Tarif (Rp.)')
                  ->setCellValue('L7', 'Total Permintaan (Ton)')
                  ->setCellValue('M7', 'Total Pembayaran (Rp.)')
              ;
              $no=0;
              //add data
              $counter=8;
              $total = 0;
              $ton = 0;
              $ex = $object->setActiveSheetIndex(0);
              foreach($result as $row){
                  $lama_pengantaran = "";
                  $no++;
                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("M".$counter)->applyFromArray($style);

                  if($row->diskon != NULL || $row->diskon != 0){
                      $row->tarif -= $row->tarif * $row->diskon/100;
                      $total_pembayaran = $row->tarif * $row->total_permintaan ;
                  }
                  else{
                      $total_pembayaran = $row->tarif * $row->total_permintaan;
                  }

                  $waktu_awal = mktime(date("H",strtotime($row->waktu_mulai_pengantaran)),date("i",strtotime($row->waktu_mulai_pengantaran)),date("s",strtotime($row->waktu_mulai_pengantaran)),date("m",strtotime($row->waktu_mulai_pengantaran)),date("d",strtotime($row->waktu_mulai_pengantaran)),date("y",strtotime($row->waktu_mulai_pengantaran)));
                  $waktu_akhir = mktime(date("H",strtotime($row->waktu_selesai_pengantaran)),date("i",strtotime($row->waktu_selesai_pengantaran)),date("s",strtotime($row->waktu_selesai_pengantaran)),date("m",strtotime($row->waktu_selesai_pengantaran)),date("d",strtotime($row->waktu_selesai_pengantaran)),date("y",strtotime($row->waktu_selesai_pengantaran)) );

                  if($row->waktu_mulai_pengantaran == NULL){
                      $format_jam_awal = " ";
                      $lama_pengantaran = " ";
                      if($row->waktu_selesai_pengantaran == NULL){
                          $format_jam_akhir = " ";
                      }
                  }
                  else if($row->waktu_selesai_pengantaran == NULL){
                      $format_jam_akhir = " ";
                      $lama_pengantaran = " ";
                  }
                  else{
                      $lama_pengantaran = round((($waktu_akhir - $waktu_awal) % 86400)/3600,2);
                      $format_jam_awal = date("d-m-y H:i:s",strtotime($row->waktu_mulai_pengantaran));
                      $format_jam_akhir = date("d-m-y H:i:s",strtotime($row->waktu_selesai_pengantaran));
                  }

                  if($lama_pengantaran > 1){
                      $lama_pengantaran .= " Jam";
                  }
                  else {
                      $lama_pengantaran = $lama_pengantaran * 60;
                      if ($lama_pengantaran > 1){
                          $lama_pengantaran .= " Menit";
                      }
                      else {
                          $lama_pengantaran = $lama_pengantaran * 60;
                          $lama_pengantaran .= " Detik";
                      }
                  }

                  if($row->batal_kwitansi == 0){
                      $total += $total_pembayaran;
                      $ton += $row->total_permintaan;
                  }

                  $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));
                  $format_tgl_pengantaran = date('d-m-Y H:i:s', strtotime($row->tgl_perm_pengantaran ));

                  $ex->setCellValue("A".$counter,"$no");
                  $ex->setCellValue("B".$counter,"$row->nama_pengguna_jasa");
                  $ex->setCellValue("C".$counter,"$row->nama_pemohon");
                  $ex->setCellValue("D".$counter,"$row->alamat");
                  $ex->setCellValue("E".$counter,"$row->no_telp");
                  $ex->setCellValue("F".$counter,"$format_tgl");
                  $ex->setCellValue("G".$counter,"$format_tgl_pengantaran");
                  $ex->setCellValue("H".$counter,"$format_jam_awal");
                  $ex->setCellValue("I".$counter,"$format_jam_akhir");
                  $ex->setCellValue("J".$counter,"$lama_pengantaran");
                  $ex->setCellValue("K".$counter,"$row->tarif");
                  $ex->setCellValue("L".$counter,"$row->total_permintaan");
                  $ex->setCellValue("M".$counter,"$total_pembayaran");
                  $counter=$counter+1;
              }
              $object->getActiveSheet()->mergeCells('A'.$counter.':K'.$counter);
              $object->getActiveSheet()->getStyle("A".$counter.":M".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("M".$counter)->applyFromArray($font);

              $ex->setCellValue("A".$counter,"Total");
              $ex->setCellValue("L".$counter,"$ton");
              $ex->setCellValue("M".$counter,"$total");
              // Rename sheet
              $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Darat');

              // Set active sheet index to the first sheet, so Excel opens this as the first sheet
              $object->setActiveSheetIndex(0);

              // Redirect output to a client’s web browser (Excel2007)
              header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Content-Disposition: attachment;filename="Laporan_Transaksi_Darat_periode_'.$_GET['id'].'_'.$_GET['id2'].'.xlsx"');
              header('Cache-Control: max-age=0');

              $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
              $objWriter->save('php://output');
          }
          else{
              $tgl_awal = $this->input->get('id');
              $tgl_akhir = $this->input->get('id2');

              $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"darat");

              // Create new PHPExcel object
              $object = new PHPExcel();
              $style = array(
                  'alignment' => array(
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                  ),
                  'borders' => array(
                      'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                      )
                  )
              );
              $font = array(
                  'font'  => array(
                      'bold'  => true,
                      'size'  => 12,
                      'name'  => 'Times New Roman'
                  )
              );
              $object->getActiveSheet()->getStyle("A7:L7")->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A7:L7")->applyFromArray($font);
              $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
              $object->getActiveSheet()->getStyle('A7:L7')->getAlignment()->setWrapText(true);

              // Set properties
              $object->getProperties()->setCreator($this->session->userdata('nama'))
                  ->setLastModifiedBy($this->session->userdata('nama'))
                  ->setCategory("Approve by ");
              // Add some data
              $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
              $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
              $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('L')->setWidth(20);

              $object->getActiveSheet()->mergeCells('A1:L1');
              $object->getActiveSheet()->mergeCells('A2:L2');
              $object->getActiveSheet()->mergeCells('A3:L3');
              $object->getActiveSheet()->mergeCells('A4:L4');
              $object->getActiveSheet()->mergeCells('A5:L5');

              $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
              $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

              $object->setActiveSheetIndex(0)
                  ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('nama'))
                  ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                  ->setCellValue('A4', 'Terminal Peti Kemas')
                  ->setCellValue('A5', 'Laporan Transaksi Air Darat Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                  ->setCellValue('A7', 'No')
                  ->setCellValue('B7', 'Nama Pengguna Jasa')
                  ->setCellValue('C7', 'Nama Pemohon')
                  ->setCellValue('D7', 'Alamat')
                  ->setCellValue('E7', 'No Telepon')
                  ->setCellValue('F7', 'Tanggal Transaksi')
                  ->setCellValue('G7', 'Tanggal Waktu Pengantaran')
                  ->setCellValue('H7', 'Waktu Mulai Pengantaran')
                  ->setCellValue('I7', 'Waktu Selesai Pengantaran')
                  ->setCellValue('J7', 'Lama Pengantaran (Jam)')
                  ->setCellValue('K7', 'Total Permintaan (Ton)')
                  ->setCellValue('L7', 'Total Pembayaran (Rp.)')
              ;
              $no=0;
              //add data
              $counter=8;
              $total = 0;
              $ton = 0;
              $ex = $object->setActiveSheetIndex(0);
              foreach($result as $row){
                  $lama_pengantaran = "";
                  $no++;
                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($style);

                  if($row->diskon != NULL || $row->diskon != 0){
                      $row->tarif -= $row->tarif * $row->diskon/100;
                      $total_pembayaran = $row->tarif * $row->total_permintaan ;
                  }
                  else{
                      $total_pembayaran = $row->tarif * $row->total_permintaan;
                  }

                  $waktu_awal = mktime(date("H",strtotime($row->waktu_mulai_pengantaran)),date("i",strtotime($row->waktu_mulai_pengantaran)),date("s",strtotime($row->waktu_mulai_pengantaran)),date("m",strtotime($row->waktu_mulai_pengantaran)),date("d",strtotime($row->waktu_mulai_pengantaran)),date("y",strtotime($row->waktu_mulai_pengantaran)));
                  $waktu_akhir = mktime(date("H",strtotime($row->waktu_selesai_pengantaran)),date("i",strtotime($row->waktu_selesai_pengantaran)),date("s",strtotime($row->waktu_selesai_pengantaran)),date("m",strtotime($row->waktu_selesai_pengantaran)),date("d",strtotime($row->waktu_selesai_pengantaran)),date("y",strtotime($row->waktu_selesai_pengantaran)) );

                  if($row->waktu_mulai_pengantaran == NULL){
                      $lama_pengantaran = " ";
                      $format_jam_awal = " ";
                      if($row->waktu_selesai_pengantaran == NULL){
                          $format_jam_akhir = " ";
                      }
                  } else if($row->waktu_selesai_pengantaran == NULL){
                      $format_jam_akhir = " ";
                      $lama_pengantaran = " ";
                  } else{
                      $lama_pengantaran = round((($waktu_akhir - $waktu_awal) % 86400)/3600,2);
                      $format_jam_awal = date("d-m-y H:i:s",strtotime($row->waktu_mulai_pengantaran));
                      $format_jam_akhir = date("d-m-y H:i:s",strtotime($row->waktu_selesai_pengantaran));
                  }

                  if($lama_pengantaran > 1){
                      $lama_pengantaran .= " Jam";
                  }
                  else {
                      $lama_pengantaran = $lama_pengantaran * 60;

                      if ($lama_pengantaran > 1){
                          $lama_pengantaran .= " Menit";
                      }
                      else {
                          $lama_pengantaran = $lama_pengantaran * 60;
                          $lama_pengantaran .= " Detik";
                      }
                  }

                  if($row->batal_kwitansi == 0){
                      $total += $total_pembayaran;
                      $ton += $row->total_permintaan;
                  }

                  $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));
                  $format_tgl_pengantaran = date('d-m-Y H:i:s', strtotime($row->tgl_perm_pengantaran ));

                  $ex->setCellValue("A".$counter,"$no");
                  $ex->setCellValue("B".$counter,"$row->nama_pengguna_jasa");
                  $ex->setCellValue("C".$counter,"$row->nama_pemohon");
                  $ex->setCellValue("D".$counter,"$row->alamat");
                  $ex->setCellValue("E".$counter,"$row->no_telp");
                  $ex->setCellValue("F".$counter,"$format_tgl");
                  $ex->setCellValue("G".$counter,"$format_tgl_pengantaran");
                  $ex->setCellValue("H".$counter,"$format_jam_awal");
                  $ex->setCellValue("I".$counter,"$format_jam_akhir");
                  $ex->setCellValue("J".$counter,"$lama_pengantaran");
                  $ex->setCellValue("K".$counter,"$row->total_permintaan");
                  $ex->setCellValue("L".$counter,"$total_pembayaran");
                  $counter=$counter+1;
              }
              $object->getActiveSheet()->mergeCells('A'.$counter.':J'.$counter);
              $object->getActiveSheet()->getStyle("A".$counter.":L".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($font);

              $ex->setCellValue("A".$counter,"Total");
              $ex->setCellValue("K".$counter,"$ton");
              $ex->setCellValue("L".$counter,"$total");
              // Rename sheet
              $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Darat');

              // Set active sheet index to the first sheet, so Excel opens this as the first sheet
              $object->setActiveSheetIndex(0);

              // Redirect output to a client’s web browser (Excel2007)
              header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Content-Disposition: attachment;filename="Laporan_Transaksi_Darat_periode_'.$_GET['id'].'_'.$_GET['id2'].'.xlsx"');
              header('Cache-Control: max-age=0');

              $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
              $objWriter->save('php://output');
          }

      }

      public function excelLaut()
      {
          $tgl_awal = $this->input->get('id');
          $tgl_akhir = $this->input->get('id2');

          // Create new PHPExcel object
          $object = new PHPExcel();
          $style = array(
              'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              ),
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
          $font = array(
              'font'  => array(
                  'bold'  => true,
                  'size'  => 12,
                  'name'  => 'Times New Roman'
              )
          );

          // Set properties
          $object->getProperties()->setCreator($this->session->userdata('nama'))
              ->setLastModifiedBy($this->session->userdata('nama'))
              ->setCategory("Approve by ");
          // Add some data
          if($this->session->userdata('role') == 'keuangan'){
              $object->getActiveSheet()->getStyle("A7:M7")->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A7:M7")->applyFromArray($font);
              $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
              $object->getActiveSheet()->getStyle('A7:M7')->getAlignment()->setWrapText(true);
              $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"laut");

              $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
              $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
              $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('G')->setWidth(30);
              $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('L')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('M')->setWidth(20);

              $object->getActiveSheet()->mergeCells('A1:M1');
              $object->getActiveSheet()->mergeCells('A2:M2');
              $object->getActiveSheet()->mergeCells('A3:M3');
              $object->getActiveSheet()->mergeCells('A4:M4');
              $object->getActiveSheet()->mergeCells('A5:M5');

              $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
              $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

              $object->setActiveSheetIndex(0)
                  ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('nama'))
                  ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                  ->setCellValue('A4', 'Terminal Peti Kemas')
                  ->setCellValue('A5', 'Laporan Transaksi Air Kapal Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                  ->setCellValue('A7', 'No')
                  ->setCellValue('B7', 'NO Nota')
                  ->setCellValue('C7', 'NO Faktur')
                  ->setCellValue('D7', 'ID Vessel')
                  ->setCellValue('E7', 'Nama Vessel')
                  ->setCellValue('F7', 'Voy No')
                  ->setCellValue('G7', 'Tipe Kapal')
                  ->setCellValue('H7', 'Nama Perusahaan')
                  ->setCellValue('I7', 'Tanggal Transaksi')
                  ->setCellValue('J7', 'Tarif (Rp.)')
                  ->setCellValue('K7', 'Total Permintaan (Ton)')
                  ->setCellValue('L7', 'Realisasi Pengisian (Ton)')
                  ->setCellValue('M7', 'Total Pembayaran (Rp.)')
              ;
              $no=0;
              //add data
              $counter=8;
              $total = 0;
              $ton = 0;
              $ton_realisasi = 0;
              $total_realisasi=0;
              $ex = $object->setActiveSheetIndex(0);
              foreach($result as $row){
                  $no++;
                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("M".$counter)->applyFromArray($style);


                  if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                      $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;

                      if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                          $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                          if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                              $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                          } else{
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                          }
                      }
                      else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                          $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                      }
                      else {
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                      }
                  }
                  else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                      $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                      if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                          $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                      } else {
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                      }
                  }
                  else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                      $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                      }
                  else{
                      $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                  }

                  if($row->diskon != NULL || $row->diskon != 0){
                      $row->tarif -= $row->tarif * $row->diskon/100;
                      $total_pembayaran = $row->tarif * $realisasi;
                  } else{
                      $total_pembayaran = $row->tarif * $realisasi;
                  }

                  if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                      $total_pembayaran += 3000;
                  } else if($total_pembayaran > 1000000){
                      $total_pembayaran += 6000;
                  } else{
                      $total_pembayaran += 0;
                  }

                  if($row->tipe_kapal == 8)
                      $row->tipe_kapal = "Peti Kemas";
                  else
                      $row->tipe_kapal = "Tongkang";

                  $total += $total_pembayaran;
                  $ton += $row->total_permintaan;
                  $ton_realisasi += $realisasi;
                  $total_realisasi += $realisasi;
                  $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));

                  $ex->setCellValue("A".$counter,"$no");
                  $ex->setCellValue("B".$counter,"$row->no_nota");
                  $ex->setCellValue("C".$counter,"$row->no_faktur");
                  $ex->setCellValue("D".$counter,"$row->id_vessel");
                  $ex->setCellValue("E".$counter,"$row->nama_vessel");
                  $ex->setCellValue("F".$counter,"$row->voy_no");
                  $ex->setCellValue("G".$counter,"$row->tipe_kapal");
                  $ex->setCellValue("H".$counter,"$row->nama_agent");
                  $ex->setCellValue("I".$counter,"$format_tgl");
                  $ex->setCellValue("J".$counter,"$row->tarif");
                  $ex->setCellValue("K".$counter,"$row->total_permintaan");
                  $ex->setCellValue("L".$counter,"$realisasi");
                  $ex->setCellValue("M".$counter,"$total_pembayaran");
                  $counter=$counter+1;
              }
              $object->getActiveSheet()->mergeCells('A'.$counter.':I'.$counter);
              $object->getActiveSheet()->getStyle("A".$counter.":M".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("M".$counter)->applyFromArray($font);

              $ex->setCellValue("A".$counter,"Total");
              $ex->setCellValue("K".$counter,"$ton");
              $ex->setCellValue("L".$counter,"$total_realisasi");
              $ex->setCellValue("M".$counter,"$total");
          }
          else if($this->session->userdata('role') == 'operasi'){
              $object->getActiveSheet()->getStyle("A7:K7")->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A7:K7")->applyFromArray($font);
              $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
              $object->getActiveSheet()->getStyle('A7:K7')->getAlignment()->setWrapText(true);

              $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"laut_operasi");

              $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
              $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
              $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('G')->setWidth(30);
              $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);

              $object->getActiveSheet()->mergeCells('A1:K1');
              $object->getActiveSheet()->mergeCells('A2:K2');
              $object->getActiveSheet()->mergeCells('A3:K3');
              $object->getActiveSheet()->mergeCells('A4:K4');
              $object->getActiveSheet()->mergeCells('A5:K5');

              $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
              $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

              $object->setActiveSheetIndex(0)
                  ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('nama'))
                  ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                  ->setCellValue('A4', 'Terminal Peti Kemas')
                  ->setCellValue('A5', 'Laporan Transaksi Air Kapal Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                  ->setCellValue('A7', 'No')
                  ->setCellValue('B7', 'ID Vessel')
                  ->setCellValue('C7', 'Nama Vessel')
                  ->setCellValue('D7', 'Voy No')
                  ->setCellValue('E7', 'Tipe Kapal')
                  ->setCellValue('F7', 'Nama Perusahaan')
                  ->setCellValue('G7', 'Tanggal Transaksi')
                  ->setCellValue('H7', 'Tarif (Rp.)')
                  ->setCellValue('I7', 'Total Permintaan (Ton)')
                  ->setCellValue('J7', 'Realisasi Pengisian (Ton)')
                  ->setCellValue('K7', 'Total Pembayaran (Rp.)')
              ;
              $no=0;
              //add data
              $counter=8;
              $total = 0;
              $ton = 0;
              $ton_realisasi = 0;
              $ex = $object->setActiveSheetIndex(0);
              foreach($result as $row){
                  $no++;
                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);


                  if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                      $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;

                      if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                          $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                          if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                              $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                          } else{
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                          }
                      }
                      else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                          $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                      }
                      else {
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                      }
                  }
                  else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                      $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                      if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                          $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                      } else {
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                      }
                  }
                  else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                      $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                  }
                  else{
                      $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                  }

                  if($row->diskon != NULL || $row->diskon != 0){
                      $row->tarif -= $row->tarif * $row->diskon/100;
                      $total_pembayaran = $row->tarif * $realisasi;
                  } else{
                      $total_pembayaran = $row->tarif * $realisasi;
                  }

                  if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                      $total_pembayaran += 3000;
                  } else if($total_pembayaran > 1000000){
                      $total_pembayaran += 6000;
                  } else{
                      $total_pembayaran += 0;
                  }

                  if($row->tipe_kapal == 8)
                      $row->tipe_kapal = "Peti Kemas";
                  else
                      $row->tipe_kapal = "Tongkang";

                  $total += $total_pembayaran;
                  $ton += $row->total_permintaan;
                  $ton_realisasi += $realisasi;
                  $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));

                  $ex->setCellValue("A".$counter,"$no");
                  $ex->setCellValue("B".$counter,"$row->id_vessel");
                  $ex->setCellValue("C".$counter,"$row->nama_vessel");
                  $ex->setCellValue("D".$counter,"$row->voy_no");
                  $ex->setCellValue("E".$counter,"$row->tipe_kapal");
                  $ex->setCellValue("F".$counter,"$row->nama_agent");
                  $ex->setCellValue("G".$counter,"$format_tgl");
                  $ex->setCellValue("H".$counter,"$row->tarif");
                  $ex->setCellValue("I".$counter,"$row->total_permintaan");
                  $ex->setCellValue("J".$counter,"$realisasi");
                  $ex->setCellValue("K".$counter,"$total_pembayaran");
                  $counter=$counter+1;
              }
              $object->getActiveSheet()->mergeCells('A'.$counter.':H'.$counter);
              $object->getActiveSheet()->getStyle("A".$counter.":K".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($font);

              $ex->setCellValue("A".$counter,"Total");
              $ex->setCellValue("I".$counter,"$ton");
              $ex->setCellValue("J".$counter,"$ton_realisasi");
              $ex->setCellValue("K".$counter,"$total");

          }
          else {
              $object->getActiveSheet()->getStyle("A7:L7")->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A7:L7")->applyFromArray($font);
              $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
              $object->getActiveSheet()->getStyle('A7:L7')->getAlignment()->setWrapText(true);

              $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"laut_operasi");

              $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
              $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
              $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('G')->setWidth(30);
              $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('L')->setWidth(20);

              $object->getActiveSheet()->mergeCells('A1:L1');
              $object->getActiveSheet()->mergeCells('A2:L2');
              $object->getActiveSheet()->mergeCells('A3:L3');
              $object->getActiveSheet()->mergeCells('A4:L4');
              $object->getActiveSheet()->mergeCells('A5:L5');

              $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
              $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

              $object->setActiveSheetIndex(0)
                  ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('nama'))
                  ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                  ->setCellValue('A4', 'Terminal Peti Kemas')
                  ->setCellValue('A5', 'Laporan Transaksi Air Kapal Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                  ->setCellValue('A7', 'No')
                  ->setCellValue('B7', 'ID Vessel')
                  ->setCellValue('C7', 'Nama Vessel')
                  ->setCellValue('D7', 'Voy No')
                  ->setCellValue('E7', 'Tipe Kapal')
                  ->setCellValue('F7', 'Nama Perusahaan')
                  ->setCellValue('G7', 'Tanggal Transaksi')
                  ->setCellValue('H7', 'Total Permintaan (Ton)')
                  ->setCellValue('I7', 'Flow Meter Awal')
                  ->setCellValue('J7', 'Flow Meter Akhir')
                  ->setCellValue('K7', 'Realisasi Pengisian (Ton)')
                  ->setCellValue('L7', 'Total Pembayaran (Rp.)')
              ;
              $no=0;
              //add data
              $counter=8;
              $total = 0;
              $ton = 0;
              $ton_realisasi = 0;
              $ex = $object->setActiveSheetIndex(0);
              foreach($result as $row){
                  $no++;
                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($style);

                  if($row->flowmeter_awal == NULL || $row->flowmeter_awal == '0'){
                      $flowmeter_awal = "0";
                  }
                  else{
                      $flowmeter_awal = $row->flowmeter_awal;
                  }

                  if($row->flowmeter_akhir == NULL || $row->flowmeter_akhir == '0'){
                      $flowmeter_akhir = "0";
                  }
                  else{
                      $flowmeter_akhir = $row->flowmeter_akhir;
                  }

                  if($row->flowmeter_awal_2 == NULL || $row->flowmeter_awal_2 == '0'){
                      $flowmeter_awal_2 = "0";
                  }
                  else{
                      $flowmeter_awal_2 = $row->flowmeter_awal_2;
                  }

                  if($row->flowmeter_akhir_2 == NULL || $row->flowmeter_akhir_2 == '0'){
                      $flowmeter_akhir_2 = "0";
                  }
                  else{
                      $flowmeter_akhir_2 = $row->flowmeter_akhir_2;
                  }

                  if($row->flowmeter_awal_3 == NULL || $row->flowmeter_awal_3 == '0'){
                      $flowmeter_awal_3 = "0";
                  }
                  else{
                      $flowmeter_awal_3 = $row->flowmeter_awal_3;
                  }

                  if($row->flowmeter_akhir_3 == NULL || $row->flowmeter_akhir_3 == '0'){
                      $flowmeter_akhir_3 = "0";
                  }
                  else{
                      $flowmeter_akhir_3 = $row->flowmeter_akhir_3;
                  }

                  if($row->flowmeter_awal_4 == NULL || $row->flowmeter_awal_4 == '0'){
                      $flowmeter_awal_4 = "0";
                  }
                  else{
                      $flowmeter_awal_4 = $row->flowmeter_awal_4;
                  }

                  if($row->flowmeter_akhir_4 == NULL || $row->flowmeter_akhir_4 == '0'){
                      $flowmeter_akhir_4 = "0";
                  }
                  else{
                      $flowmeter_akhir_4 = $row->flowmeter_akhir_4;
                  }

                  if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                      $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;
                      $flow_sebelum = $flowmeter_awal_4;
                      $flow_sesudah = $flowmeter_akhir_4;

                      if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                          $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                          $flow_sebelum .= " , ".$flowmeter_awal_3;
                          $flow_sesudah .= " , ".$flowmeter_akhir_3;

                          if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                              $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                              $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                          } else{
                              $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                              $flow_sebelum .= " , ".$flowmeter_awal;
                              $flow_sesudah .= " , ".$flowmeter_akhir;
                          }
                      }
                      else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                          $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                          $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                          $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                      }
                      else {
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                          $flow_sebelum .= " , ".$flowmeter_awal;
                          $flow_sesudah .= " , ".$flowmeter_akhir;
                      }
                  }
                  else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                      $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                      $flow_sebelum = $flowmeter_awal_3;
                      $flow_sesudah = $flowmeter_akhir_3;

                      if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                          $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                          $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                          $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                      } else {
                          $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                          $flow_sebelum .= " , ".$flowmeter_awal;
                          $flow_sesudah .= " , ".$flowmeter_akhir;
                      }
                  }
                  else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                      $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                      $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                      $flow_sebelum = $flowmeter_awal_2." , ".$flowmeter_awal;
                      $flow_sesudah = $flowmeter_akhir_2." , ".$flowmeter_akhir;
                  }
                  else{
                      $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                      $flow_sebelum = $flowmeter_awal;
                      $flow_sesudah = $flowmeter_akhir;
                  }

                  if($row->diskon != NULL || $row->diskon != 0){
                      $row->tarif -= $row->tarif * $row->diskon/100;
                      $total_pembayaran = $row->tarif * $realisasi;
                  } else{
                      $total_pembayaran = $row->tarif * $realisasi;
                  }

                  if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                      $total_pembayaran += 3000;
                  } else if($total_pembayaran > 1000000){
                      $total_pembayaran += 6000;
                  } else{
                      $total_pembayaran += 0;
                  }

                  if($row->tipe_kapal == 8)
                      $row->tipe_kapal = "Peti Kemas";
                  else
                      $row->tipe_kapal = "Tongkang";

                  $total += $total_pembayaran;
                  $ton += $row->total_permintaan;
                  $ton_realisasi += $realisasi;
                  $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));

                  $ex->setCellValue("A".$counter,"$no");
                  $ex->setCellValue("B".$counter,"$row->id_vessel");
                  $ex->setCellValue("C".$counter,"$row->nama_vessel");
                  $ex->setCellValue("D".$counter,"$row->voy_no");
                  $ex->setCellValue("E".$counter,"$row->tipe_kapal");
                  $ex->setCellValue("F".$counter,"$row->nama_agent");
                  $ex->setCellValue("G".$counter,"$format_tgl");
                  $ex->setCellValue("H".$counter,"$row->total_permintaan");
                  $ex->setCellValue("I".$counter,"$flow_sebelum");
                  $ex->setCellValue("J".$counter,"$flow_sesudah");
                  $ex->setCellValue("K".$counter,"$realisasi");
                  $ex->setCellValue("L".$counter,"$total_pembayaran");
                  $counter=$counter+1;
              }
              $object->getActiveSheet()->mergeCells('A'.$counter.':G'.$counter);
              $object->getActiveSheet()->getStyle("A".$counter.":L".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($font);

              $ex->setCellValue("A".$counter,"Total");
              $ex->setCellValue("H".$counter,"$ton");
              $ex->setCellValue("K".$counter,"$ton_realisasi");
              $ex->setCellValue("L".$counter,"$total");
          }
          // Rename sheet
          $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Kapal');

          // Set active sheet index to the first sheet, so Excel opens this as the first sheet
          $object->setActiveSheetIndex(0);

          // Redirect output to a client’s web browser (Excel2007)
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="Laporan_Transaksi_Kapal_periode_'.$_GET['id'].'_'.$_GET['id2'].'.xlsx"');
          header('Cache-Control: max-age=0');

          $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
          $objWriter->save('php://output');
      }

      public function excelRuko()
      {
          $tgl_awal = $this->input->get('id');
          $tgl_akhir = $this->input->get('id2');
          $ton = "";
          $total_penggunaan = "";

          // Create new PHPExcel object
          $object = new PHPExcel();
          $style = array(
              'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              ),
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
          $font = array(
              'font'  => array(
                  'bold'  => true,
                  'size'  => 12,
                  'name'  => 'Times New Roman'
              )
          );

          $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($style);
          $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($font);
          $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
          $object->getActiveSheet()->getStyle('A7:J7')->getAlignment()->setWrapText(true);

          // Set properties
          $object->getProperties()->setCreator($this->session->userdata('nama'))
              ->setLastModifiedBy($this->session->userdata('nama'))
              ->setCategory("Approve by ");
          // Add some data
          if($this->session->userdata('role') == "keuangan"){
              $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"ruko_keuangan");

              $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
              $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
              $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('G')->setWidth(30);
              $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);

              $object->getActiveSheet()->mergeCells('A1:J1');
              $object->getActiveSheet()->mergeCells('A2:J2');
              $object->getActiveSheet()->mergeCells('A3:J3');
              $object->getActiveSheet()->mergeCells('A4:J4');
              $object->getActiveSheet()->mergeCells('A5:J5');

              $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
              $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

              $object->setActiveSheetIndex(0)
                  ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('nama'))
                  ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                  ->setCellValue('A4', 'Terminal Peti Kemas')
                  ->setCellValue('A5', 'Laporan Transaksi Air Ruko Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                  ->setCellValue('A7', 'No')
                  ->setCellValue('B7', 'No Invoice')
                  ->setCellValue('C7', 'No Nota')
                  ->setCellValue('D7', 'No Faktur')
                  ->setCellValue('E7', 'Nama Tenant')
                  ->setCellValue('F7', 'No Perjanjian')
                  ->setCellValue('G7', 'Alamat')
                  ->setCellValue('H7', 'No Telepon')
                  ->setCellValue('I7', 'Total Penggunaan')
                  ->setCellValue('J7', 'Total Pembayaran (Rp.)')
              ;
              $no=0;
              //add data
              $counter=8;
              $ton_total = 0;
              $total_pembayaran =0;
              $ex = $object->setActiveSheetIndex(0);

              foreach($result as $row){
                  $no++;
                  $data_tagihan = $this->data->getTagihan($tgl_awal,$tgl_akhir,$row->id_flow);
                  $i = 1;
                  $no_perjanjian = '';
                  $ttl_awal = '';
                  $ttl_akhir = '';

                  $object->getActiveSheet()->getStyle("A".$counter.":I".$counter)->applyFromArray($style);

                  if($data_tagihan != NULL) {
                      foreach ($data_tagihan as $data) {
                          if($data->id_ref_flowmeter == $row->id_flow) {
                              if ($i == 1 && $data->flow_hari_ini != NULL) {
                                  $ttl_awal = $data->flow_hari_ini;
                              } else {
                                  if ($ttl_awal == 0) {
                                      $ttl_awal = $data->flow_hari_ini;
                                  }
                              }
                              if ($i == count($data_tagihan) && $data->flow_hari_ini != NULL) {
                                  $ttl_akhir = $data->flow_hari_ini;
                              }
                              $i++;
                          }
                          else {
                              $i = 1;
                          }
                      }

                      $ton_koma = $ttl_akhir - $ttl_awal;
                      $ton_total += $ton_koma;
                      $ton = $this->Koma($ton_koma);
                      $tarif = $row->tarif;
                      $diskon = $row->diskon;
                  } else{
                      $ton = 0;
                      $no_perjanjian = $row->no_perjanjian;
                      $tarif = $row->nominal;
                      $diskon = '';
                  }

                  if($row->id_ref_tenant == NULL){
                      if($row->diskon != NULL){
                          $pembayaran = ($row->tarif - ($row->tarif * $row->diskon/100)) * $ton_koma;
                      }
                      else{
                          $pembayaran = $row->tarif * $ton_koma;
                      }
                  }
                  else {
                      $date_now = strtotime(date('Y-m-d',time() ));
                      $date_kadaluarsa = strtotime($row->waktu_kadaluarsa);
                      if($date_now <= $date_kadaluarsa)
                          $pembayaran = $row->nominal;
                      else
                          $pembayaran = 0;
                  }

                  $total_pembayaran += $pembayaran;

                  $ex->setCellValue("A".$counter,"$no");
                  $ex->setCellValue("B".$counter,"$row->no_invoice");
                  $ex->setCellValue("C".$counter,"$row->no_nota");
                  $ex->setCellValue("D".$counter,"$row->no_faktur");
                  $ex->setCellValue("E".$counter,"$row->nama_tenant");
                  $ex->setCellValue("F".$counter,"$no_perjanjian");
                  $ex->setCellValue("G".$counter,"$row->lokasi");
                  $ex->setCellValue("H".$counter,"$row->no_telp");
                  $ex->setCellValue("I".$counter,"$ton");
                  $ex->setCellValue("J".$counter,"$pembayaran");

                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);

                  $counter=$counter+1;
              }
              $object->getActiveSheet()->mergeCells('A'.$counter.':H'.$counter);
              $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);

              $ex->setCellValue("A".$counter,"Total");
              $ex->setCellValue("I".$counter,"$ton_total");
              $ex->setCellValue("J".$counter,"$total_pembayaran");
          }
          else{
              $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"ruko");

              $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
              $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
              $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('G')->setWidth(30);
              $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
              $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);

              $object->getActiveSheet()->mergeCells('A1:J1');
              $object->getActiveSheet()->mergeCells('A2:J2');
              $object->getActiveSheet()->mergeCells('A3:J3');
              $object->getActiveSheet()->mergeCells('A4:J4');
              $object->getActiveSheet()->mergeCells('A5:J5');

              $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
              $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

              $object->setActiveSheetIndex(0)
                  ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('nama'))
                  ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                  ->setCellValue('A4', 'Terminal Peti Kemas')
                  ->setCellValue('A5', 'Laporan Transaksi Air Ruko Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                  ->setCellValue('A7', 'No')
                  ->setCellValue('B7', 'ID Tenant')
                  ->setCellValue('C7', 'Nama Tenant')
                  ->setCellValue('D7', 'No Perjanjian')
                  ->setCellValue('E7', 'Tarif')
                  ->setCellValue('F7', 'Diskon')
                  ->setCellValue('G7', 'Pemakaian Awal')
                  ->setCellValue('H7', 'Pemakaian Akhir')
                  ->setCellValue('I7', 'Total Penggunaan')
                  ->setCellValue('J7', 'Total Pembayaran (Rp.)')
              ;
              $no=0;
              //add data
              $counter=8;
              $ton_total = 0;
              $total_pembayaran =0;
              $ex = $object->setActiveSheetIndex(0);

              foreach($result as $row){
                  $no++;
                  $data_tagihan = $this->data->getTagihan($tgl_awal,$tgl_akhir,$row->id_flow);
                  $i = 1;
                  $no_perjanjian = '';
                  $ttl_awal = '';
                  $ttl_akhir = '';

                  $object->getActiveSheet()->getStyle("A".$counter.":I".$counter)->applyFromArray($style);
                  if($data_tagihan != NULL) {
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
                          }
                          else {
                              $i = 1;
                          }
                      }

                      $ton_koma = $ttl_akhir - $ttl_awal;
                      $ton_total += $ton_koma;
                      $ton = $this->Koma($ton_koma);
                      $tarif = $row->tarif;
                      $diskon = $row->diskon;
                  } else{
                      $ton = 0;
                      $no_perjanjian = $row->no_perjanjian;
                      $tarif = $row->nominal;
                      $diskon = '';
                  }

                  if($row->id_ref_tenant == NULL){
                      if($row->diskon != NULL){
                          $pembayaran = ($row->tarif - ($row->tarif * $row->diskon/100)) * $ton_koma;
                      }
                      else{
                          $pembayaran = $row->tarif * $ton_koma;
                      }
                  } else {
                      $date_now = strtotime(date('Y-m-d',time() ));
                      $date_kadaluarsa = strtotime($row->waktu_kadaluarsa);
                      if($date_now <= $date_kadaluarsa)
                          $pembayaran = $row->nominal;
                      else
                          $pembayaran = 0;
                  }

                  $total_pembayaran += $pembayaran;

                  $ex->setCellValue("A".$counter,"$no");
                  $ex->setCellValue("B".$counter,"$row->id_flowmeter");
                  $ex->setCellValue("C".$counter,"$row->nama_tenant");
                  $ex->setCellValue("D".$counter,"$no_perjanjian");
                  $ex->setCellValue("E".$counter,"$tarif");
                  $ex->setCellValue("F".$counter,"$diskon");
                  $ex->setCellValue("G".$counter,"$ttl_awal");
                  $ex->setCellValue("H".$counter,"$ttl_akhir");
                  $ex->setCellValue("I".$counter,"$ton");
                  $ex->setCellValue("J".$counter,"$pembayaran");

                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);

                  $counter=$counter+1;
              }
              $object->getActiveSheet()->mergeCells('A'.$counter.':H'.$counter);
              $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($font);
              $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);

              $ex->setCellValue("A".$counter,"Total");
              $ex->setCellValue("I".$counter,"$ton_total");
              $ex->setCellValue("J".$counter,"$total_pembayaran");
          }

          // Rename sheet
          $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Ruko');

          // Set active sheet index to the first sheet, so Excel opens this as the first sheet
          $object->setActiveSheetIndex(0);

          // Redirect output to a client’s web browser (Excel2007)
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="Laporan_Transaksi_Ruko_periode_'.$_GET['id'].'_'.$_GET['id2'].'.xlsx"');
          header('Cache-Control: max-age=0');

          $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
          $objWriter->save('php://output');
      }

      public function excelFlow()
      {
          $tgl_awal = $this->input->get('id');
          $tgl_akhir = $this->input->get('id2');

          // Create new PHPExcel object
          $object = new PHPExcel();
          $style = array(
              'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              ),
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
          $font = array(
              'font'  => array(
                  'bold'  => true,
                  'size'  => 12,
                  'name'  => 'Times New Roman'
              )
          );

          $object->getActiveSheet()->getStyle("A7:E7")->applyFromArray($style);
          $object->getActiveSheet()->getStyle("A7:E7")->applyFromArray($font);
          $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
          $object->getActiveSheet()->getStyle('A7:E7')->getAlignment()->setWrapText(true);

          // Set properties
          $object->getProperties()->setCreator($this->session->userdata('nama'))
              ->setLastModifiedBy($this->session->userdata('nama'))
              ->setCategory("Approve by ");
          // Add some data
          $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"flow");

          $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
          $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
          $object->getActiveSheet()->getColumnDimension('E')->setWidth(15);

          $object->getActiveSheet()->mergeCells('A1:E1');
          $object->getActiveSheet()->mergeCells('A2:E2');
          $object->getActiveSheet()->mergeCells('A3:E3');
          $object->getActiveSheet()->mergeCells('A4:E4');
          $object->getActiveSheet()->mergeCells('A5:E5');

          $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
          $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

          $object->setActiveSheetIndex(0)
              ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('nama'))
              ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
              ->setCellValue('A4', 'Terminal Peti Kemas')
              ->setCellValue('A5', 'Laporan Pencatatan Flow Meter Periode '.$tgl_awal.' s/d '.$tgl_akhir)
              ->setCellValue('A7', 'No')
              ->setCellValue('B7', 'ID Flow Meter')
              ->setCellValue('C7', 'Nama Flow Meter')
              ->setCellValue('D7', 'Nilai Flow')
              ->setCellValue('E7', 'Issued By')
          ;
          $no=0;
          //add data
          $counter=8;
          $ex = $object->setActiveSheetIndex(0);

          foreach($result as $row){
              $no++;
              $data_tagihan = $this->data->getFlow($tgl_awal,$tgl_akhir,$row->id_flow);
              $i = 1;
              $ttl_akhir=0;

              $object->getActiveSheet()->getStyle("A".$counter.":E".$counter)->applyFromArray($style);

              if($data_tagihan != NULL) {
                  foreach($data_tagihan as $data) {
                      if($data->id_ref_flowmeter == $row->id_flow){
                          if($i == 1 && $data->flow_hari_ini != NULL){
                              $ttl_akhir = $data->flow_hari_ini;
                          }else{
                              if($ttl_akhir == 0){
                                  $ttl_akhir = $data->flow_hari_ini;
                              }
                          }
                          if($i == count($data_tagihan) && $data->flow_hari_ini != NULL){
                              $ttl_akhir = $data->flow_hari_ini;
                          }
                          $i++;
                      }else{
                          $i=1;
                      }
                  }
              }

              $ex->setCellValue("A".$counter,"$no");
              $ex->setCellValue("B".$counter,"$row->id_flowmeter");
              $ex->setCellValue("C".$counter,"$row->nama_flowmeter");
              $ex->setCellValue("D".$counter,"$ttl_akhir");
              $ex->setCellValue("E".$counter,"$row->issued_by");

              $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
              $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
              $counter=$counter+1;
          }

          // Rename sheet
          $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Flow');

          // Set active sheet index to the first sheet, so Excel opens this as the first sheet
          $object->setActiveSheetIndex(0);

          // Redirect output to a client’s web browser (Excel2007)
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="Laporan_Transaksi_Flow_periode_'.$_GET['id'].'_'.$_GET['id2'].'.xlsx"');
          header('Cache-Control: max-age=0');

          $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
          $objWriter->save('php://output');
      }

      public function excelSumur()
      {
          $tgl_awal = $this->input->get('id');
          $tgl_akhir = $this->input->get('id2');

          // Create new PHPExcel object
          $object = new PHPExcel();
          $style = array(
              'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              ),
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
          $font = array(
              'font'  => array(
                  'bold'  => true,
                  'size'  => 12,
                  'name'  => 'Times New Roman'
              )
          );

          $object->getActiveSheet()->getStyle("A7:O7")->applyFromArray($style);
          $object->getActiveSheet()->getStyle("A7:O7")->applyFromArray($font);
          $object->getActiveSheet()->getStyle("A1:O5")->applyFromArray($font);
          $object->getActiveSheet()->getStyle('A7:O7')->getAlignment()->setWrapText(true);

          // Set properties
          $object->getProperties()->setCreator($this->session->userdata('nama'))
              ->setLastModifiedBy($this->session->userdata('nama'))
              ->setCategory("Approve by ");
          // Add some data
          $result = $this->data->getDataLaporan($tgl_awal,$tgl_akhir,"sumur");

          $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
          $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('L')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('M')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('N')->setWidth(20);
          $object->getActiveSheet()->getColumnDimension('O')->setWidth(20);

          $object->getActiveSheet()->mergeCells('A1:O1');
          $object->getActiveSheet()->mergeCells('A2:O2');
          $object->getActiveSheet()->mergeCells('A3:O3');
          $object->getActiveSheet()->mergeCells('A4:O4');
          $object->getActiveSheet()->mergeCells('A5:O5');

          $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
          $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

          $object->setActiveSheetIndex(0)
              ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('nama'))
              ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
              ->setCellValue('A4', 'Terminal Peti Kemas')
              ->setCellValue('A5', 'Laporan Pencatatan Sumur Periode '.$tgl_awal.' s/d '.$tgl_akhir)
              ->setCellValue('A7', 'No')
              ->setCellValue('B7', 'ID Sumur')
              ->setCellValue('C7', 'Nama Sumur')
              ->setCellValue('D7', 'Nama Pompa')
              ->setCellValue('E7', 'Nama Flow Meter')
              ->setCellValue('F7', 'Start Running')
              ->setCellValue('G7', 'Cuaca')
              ->setCellValue('H7', 'Debit Air (L/Detik)')
              ->setCellValue('I7', 'Nilai Flow (m3)')
              ->setCellValue('J7', 'Finish Running')
              ->setCellValue('K7', 'Cuaca')
              ->setCellValue('L7', 'Debit Air (L/Detik)')
              ->setCellValue('M7', 'Nilai Flow (m3)')
              ->setCellValue('N7', 'Pemakaian (m3)')
              ->setCellValue('O7', 'Issued By')
          ;
          $no=0;
          //add data
          $counter=8;
          $ton_total = 0;
          $ex = $object->setActiveSheetIndex(0);

          foreach($result as $row){
              $no++;

              $object->getActiveSheet()->getStyle("A".$counter.":N".$counter)->applyFromArray($style);

              $ttl_awal = $row->flow_sumur_awal;
              $ttl_akhir = $row->flow_sumur_akhir;

              $ton_koma = $ttl_akhir - $ttl_awal;
              $ton_total += $ton_koma;
              $ton = $this->Koma($ton_koma);

                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->id_sumur");
                $ex->setCellValue("C".$counter,"$row->nama_sumur");
                $ex->setCellValue("D".$counter,"$row->nama_pompa");
                $ex->setCellValue("E".$counter,"$row->nama_flowmeter");
                $ex->setCellValue("F".$counter,"$row->waktu_rekam_awal");
                $ex->setCellValue("G".$counter,"$row->cuaca_awal");
                $ex->setCellValue("H".$counter,"$row->debit_air_awal");
                $ex->setCellValue("I".$counter,"$row->flow_sumur_awal");
                $ex->setCellValue("J".$counter,"$row->waktu_rekam_akhir");
                $ex->setCellValue("K".$counter,"$row->cuaca_akhir");
                $ex->setCellValue("L".$counter,"$row->debit_air_akhir");
                $ex->setCellValue("M".$counter,"$row->flow_sumur_akhir");
                $ex->setCellValue("N".$counter,"$ton");
                  $ex->setCellValue("O".$counter,"$row->issued_by");

                  $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("M".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("N".$counter)->applyFromArray($style);
                  $object->getActiveSheet()->getStyle("O".$counter)->applyFromArray($style);
                $counter=$counter+1;

          }
          $object->getActiveSheet()->mergeCells('A'.$counter.':M'.$counter);
          $object->getActiveSheet()->getStyle("A".$counter.":O".$counter)->applyFromArray($style);

          $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
          $object->getActiveSheet()->getStyle("N".$counter)->applyFromArray($font);

          $ex->setCellValue("A".$counter,"Total");
          $ex->setCellValue("N".$counter,"$ton_total");

          // Rename sheet
          $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Sumur');

          // Set active sheet index to the first sheet, so Excel opens this as the first sheet
          $object->setActiveSheetIndex(0);

          // Redirect output to a client’s web browser (Excel2007)
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="Laporan_Transaksi_Sumur_periode_'.$_GET['id'].'_'.$_GET['id2'].'.xlsx"');
          header('Cache-Control: max-age=0');

          $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
          $objWriter->save('php://output');
      }

      //fungsi untuk modul master data
      public function master(){
          $tipe = $this->input->get('id');

          if($tipe == "darat"){
                $data['tipe'] = $tipe;
                $data['pengguna'] = $this->data->get_pengguna("darat","darat");
                $data['title'] = "Master Data Pembeli Darat";
                $this->load->template('v_master',$data);
          }
          else if($tipe == "ruko"){
              $data['tipe'] = $tipe;
              $data['title'] = "Master Data Tenant";
              $this->load->template('v_master',$data);
          }
          else if($tipe == "agent"){
              $data['tipe'] = $tipe;
              $data['title'] = "Master Data Agent";
              $this->load->template('v_master',$data);
          }
          else{
              $data['tipe'] = $tipe;
              $data['pengguna'] = $this->data->get_pengguna("laut","laut");
              $data['agent'] = $this->data->getAgent();
              $data['title'] = "Master Data Vessel";
              $this->load->template('v_master',$data);
          }
      }

      //fungsi untuk master data ruko
      public function delete_data_ruko($id){
          $this->data->delete_data("ruko",$id);
          echo json_encode(array("status" => TRUE));
      }

      public function ajax_data_ruko(){
          $list = $this->data->get_datatables_ruko();
          $data = array();
          $no = $_POST['start'];

          foreach ($list as $result) {
              $no++;
              $row = array();
              $row[] = "<center>".$no;
              $row[] = "<center>".$result->id_flowmeter;
              $row[] = "<center>".$result->nama_pengguna_jasa;
              $row[] = "<center>".$result->lokasi;
              $row[] = "<center>".$result->no_telp;
              $row[] = '<center><a class="btn btn-sm btn-primary" href="editRuko?id=' . $result->id_flowmeter . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                      <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Delete" onclick="delete_data_ruko('."'".$result->id_flowmeter."'".')"><i class="glyphicon glyphicon-pencil"></i> Delete</a>';

              $data[] = $row;
          }

          $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->data->count_all_ruko(),
              "recordsFiltered" => $this->data->count_filtered_ruko(),
              "data" => $data,
          );
          //output to json format
          echo json_encode($output);
      }

      public function input_data_ruko(){
          $id = $this->input->post('id_flow');
          $nama_ruko = $this->input->post('nama');
          $alamat = $this->input->post('alamat');
          $no_telp = $this->input->post('no_telp');

          if(isset($id) && $id != NULL){
              $data_insert = array(
                  'id_flowmeter'  => $id,
                  'issued_at' => date("Y-m-d",time()),
                  'issued_by' => $this->session->userdata('username')
              );
              $data_insert2 = array(
                  'nama_pengguna_jasa' => $nama_ruko,
                  'lokasi' => $alamat,
                  'no_telp' => $no_telp,
                  'master_flowmeter_id_flowmaster' => $id,
                  'pengguna_jasa_id_tarif' => "1",
                  'issued_at' => date("Y-m-d",time()),
                  'issued_by' => $this->session->userdata('username')
              );
              $query = $this->db->insert('master_flowmeter',$data_insert);
              $this->db->insert('pembeli_darat',$data_insert2);

              if($query){
                  $message = "Input Berhasil";
              }
              else{
                  $message = "Input Gagal";
              }
          }
          else{
              $message = "Inputan Masih Kosong...Harap Diisi";
          }
          echo $message;
      }

      public function editRuko(){
          $id = $_GET['id'];
          $data['id'] = $id;
          $data['title'] = 'Edit Data Ruko';
          $this->db->from('master_flowmeter,pembeli_darat');
          $this->db->where('id_flowmeter = master_flowmeter_id_flowmaster');
          $this->db->where('id_flowmeter',$id);
          $query = $this->db->get();
          $result = $query->row();
          $data['isi'] = array(
              'id_flowmeter' => $result->id_flowmeter,
              'nama_ruko' => $result->nama_pengguna_jasa,
              'alamat' => $result->alamat,
              'no_telp' => $result->no_telp
          );

          $this->load->template('v_edit_ruko',$data);
      }

      public function edit_ruko(){
          $id = $this->input->post('id');
          $nama = $this->input->post('nama');
          $alamat = $this->input->post('alamat');
          $no_telp = $this->input->post('no_telp');
          $data_edit = array(
              'id_flowmeter' => $id,
              'last_modified' => date("Y-m-d",time()),
              'modified_by' => $this->session->userdata('username')
          );
          $data_edit2 = array(
              'nama_pengguna_jasa' => $nama,
              'lokasi' => $alamat,
              'no_telp' => $no_telp,
              'last_modified' => date("Y-m-d",time()),
              'modified_by' => $this->session->userdata('username')
          );
          if($id != ""){
              $this->db->set($data_edit);
              $this->db->where('id_flowmeter', $id);
              $query = $this->db->update('master_flowmeter');

              $this->db->set($data_edit2);
              $this->db->where('master_flowmeter_id_flowmaster', $id);
              $this->db->update('pembeli_darat');

              if($query){
                  $message = "Edit Berhasil";
              }else{
                  $message = "Edit Gagal";
              }
          }
          else{
              $message = "Tolong Isi Kolom ID Flow Meter";
          }
          echo $message;
      }

      //fungsi untuk master data darat
      public function delete_data_darat($id){
          $this->data->delete_data("darat",$id);
          echo json_encode(array("status" => TRUE));
      }

      public function ajax_data_darat(){
          $list = $this->data->get_datatables_darat();
          $data = array();
          $no = $_POST['start'];

          foreach ($list as $result) {
              $no++;
              $row = array();
              $row[] = "<center>".$no;
              $row[] = "<center>".$result->nama_pengguna_jasa;
              $row[] = "<center>".$result->alamat;
              $row[] = "<center>".$result->no_telp;
              if($result->pengguna_jasa_id_tarif == "2"){
                  $result->pengguna_jasa_id_tarif = "Perorangan (KIK)";
              }else if($result->pengguna_jasa_id_tarif == "3"){
                  $result->pengguna_jasa_id_tarif = "Perorangan (NON - KIK)";
              }else if($result->pengguna_jasa_id_tarif == "4"){
                  $result->pengguna_jasa_id_tarif = "Perusahaan (KIK)";
              }else {
                  $result->pengguna_jasa_id_tarif = "Perusahaan (NON - KIK)";
              }
              $row[] = "<center>".$result->pengguna_jasa_id_tarif;
              $row[] = '<center><a class="btn btn-sm btn-primary" href="editDarat?id=' . $result->id_pengguna_jasa . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

              $data[] = $row;
          }

          $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->data->count_all_darat(),
              "recordsFiltered" => $this->data->count_filtered_darat(),
              "data" => $data,
          );
          //output to json format
          echo json_encode($output);
      }

      public function input_data_darat(){
          $nama = $this->input->post('nama');
          $alamat = $this->input->post('alamat');
          $no_telp = $this->input->post('no_telp');
          $pengguna = $this->input->post('pengguna_jasa');

          if(isset($nama) && $nama != NULL && $alamat != NULL && $no_telp != NULL && $pengguna != NULL){
              $data_insert = array(
                  'nama_pengguna_jasa' => $nama,
                  'alamat' => $alamat,
                  'no_telp' => $no_telp,
                  'pengguna_jasa_id_tarif' => $pengguna,
                  'issued_at' => date("Y-m-d H:i:s",time()),
                  'issued_by' => $this->session->userdata('username')
              );
              $query = $this->db->insert('pembeli_darat',$data_insert);

              if($query){
                  $message = "Input Berhasil";
              }
              else{
                  $message = "Input Gagal";
              }
          }
          else{
              $message = "Inputan Masih Kosong...Harap Diisi";
          }
          echo $message;
      }

      public function editDarat(){
          $id = $_GET['id'];
          $data['id'] = $id;
          $data['title'] = 'Edit Data Darat';
          $this->db->from('pembeli_darat');
          $this->db->where('id_pengguna_jasa',$id);
          $query = $this->db->get();
          $result = $query->row();
          $data['pengguna'] = $this->data->get_pengguna("darat","darat");
          if($data['pengguna'] == "2"){
              $data['nama_pengguna'] = "Perorangan (KIK)";
          }else if($data['pengguna'] == "3"){
              $data['nama_pengguna'] = "Perorangan (NON - KIK)";
          }else if($data['pengguna'] == "4"){
              $data['nama_pengguna'] = "Perusahaan (KIK)";
          }else {
              $data['nama_pengguna'] = "Perusahaan (NON - KIK)";
          }
          $data['isi'] = array(
              'id_pengguna' => $result->id_pengguna_jasa,
              'nama_pembeli' => $result->nama_pengguna_jasa,
              'alamat' => $result->alamat,
              'no_telp' => $result->no_telp,
              'pengguna' => $result->pengguna_jasa_id_tarif,
              'nama_pengguna' => $data['nama_pengguna'],
          );

          $this->load->template('v_edit_darat',$data);
      }

      public function edit_darat(){
          $id = $this->input->post('id');
          $nama = $this->input->post('nama');
          $alamat = $this->input->post('alamat');
          $no_telp = $this->input->post('no_telp');
          $pengguna = $this->input->post('pengguna');

          $data_edit = array(
              'nama_pengguna_jasa' => $nama,
              'alamat' => $alamat,
              'no_telp' => $no_telp,
              'pengguna_jasa_id_tarif' => $pengguna,
              'last_modified' => date("Y-m-d H:i:s",time()),
              'modified_by' => $this->session->userdata('username')
          );
          if($id != ""){
              $this->db->set($data_edit);
              $this->db->where('id_pengguna_jasa', $id);
              $query = $this->db->update('pembeli_darat');

              if($query){
                  $message = "Edit Berhasil";
              }else{
                  $message = "Edit Gagal";
              }
          }
          else{
              $message = "Tolong Isi Kolom Nama Pengguna Jasa";
          }
          echo $message;
      }

      //fungsi untuk master data laut
      public function delete_data_laut($id){
          $this->data->delete_data("laut",$id);
          echo json_encode(array("status" => TRUE));
      }

      public function ajax_data_laut(){
          $list = $this->data->get_datatables_laut();
          $data = array();
          $no = $_POST['start'];

          foreach ($list as $result) {
              $no++;
              $row = array();
              $row[] = "<center>".$no;
              $row[] = "<center>".$result->id_vessel;
              $row[] = "<center>".$result->nama_vessel;

              $data_agent = $this->data->getDataAgent($result->id_agent_master);

              $row[] = $data_agent->nama_agent;
              $row[] = $data_agent->alamat;
              $row[] = $data_agent->no_telp;

              $data_tarif = $this->data->getDataTarif($result->pengguna_jasa_id_tarif);

              $row[] = $data_tarif->tipe_pengguna_jasa;

              $row[] = '<center><a class="btn btn-sm btn-primary" href="editLaut?id=' . $result->id_pengguna_jasa . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

              $data[] = $row;
          }

          $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->data->count_all_laut(),
              "recordsFiltered" => $this->data->count_filtered_laut(),
              "data" => $data,
          );
          //output to json format
          echo json_encode($output);
      }

      public function input_data_laut(){
          $id_lct = $this->input->post('id_lct');
          $nama = $this->input->post('nama');
          $id_agent = $this->input->post('id_agent');
          $pengguna = $this->input->post('pengguna_jasa');

          if($nama != NULL && $id_agent != NULL && $pengguna != NULL){
              $data_insert = array(
                  'id_vessel' => $id_lct,
                  'nama_vessel' => $nama,
                  'id_agent_master' => $id_agent,
                  'pengguna_jasa_id_tarif' => $pengguna,
                  'issued_at' => date("Y-m-d H:i:s",time()),
                  'issued_by' => $this->session->userdata('username')
              );
              $query = $this->db->insert('pembeli_laut',$data_insert);

              if($query){
                  $message = "Input Berhasil";
              }
              else{
                  $message = "Input Gagal";
              }
          }
          else{
              $message = "Inputan Masih Kosong...Harap Diisi";
          }
          echo $message;
      }

      public function editLaut(){
          $id = $_GET['id'];
          $data['id'] = $id;
          $data['title'] = 'Edit Data Kapal';
          $this->db->from('pembeli_laut,master_agent');
          $this->db->where('id_agent = id_agent_master');
          $this->db->where('id_pengguna_jasa',$id);
          $query = $this->db->get();
          $result = $query->row();

          $data['pengguna'] = $this->data->get_pengguna("laut","laut");
          $data['agent'] = $this->data->getAgent();

          $data['isi'] = array(
              'id_vessel' => $result->id_vessel,
              'nama_vessel' => $result->nama_vessel,
              'id_agent' => $result->id_agent_master,
              'alamat' => $result->alamat,
              'no_telp' => $result->no_telp,
              'pengguna' => $result->pengguna_jasa_id_tarif,
          );

          $this->load->template('v_edit_laut',$data);
      }

      public function edit_laut(){
          $id = $this->input->post('id');
          $id_lct = $this->input->post('id_lct');
          $nama = $this->input->post('nama');
          $nama_perusahaan = $this->input->post('nama_perusahaan');
          $pengguna = $this->input->post('pengguna_jasa');
          $data_edit = array(
              'id_vessel' => $id_lct,
              'nama_vessel' => $nama,
              'id_agent_master' => $nama_perusahaan,
              'pengguna_jasa_id_tarif' => $pengguna,
              'last_modified' => date("Y-m-d H:i:s",time()),
              'modified_by' => $this->session->userdata('username')
          );
          if($id != ""){
              $this->db->set($data_edit);
              $this->db->where('id_pengguna_jasa', $id);
              $query = $this->db->update('pembeli_laut');

              if($query){
                  $message = "Edit Berhasil";
              }else{
                  $message = "Edit Gagal";
              }
          }
          else{
              $message = "Masih Ada Yang Harus Di Isi";
          }
          echo $message;
      }

      public function cari_agent(){
          $id = $this->input->get('id');
          $query = $this->db->from('master_agent')
                            ->where('id_agent',$id)
                            ->get();
          $result = $query->row();
          $data = array(
              'alamat' => $result->alamat,
              'no_telp' => $result->no_telp,
          );

          echo json_encode($data);
      }

      public function cari_tenant(){
          $id = $this->input->get('id');
          $query = $this->db->from('master_tenant')
              ->where('id_tenant',$id)
              ->get();
          $result = $query->row();
          $data = array(
              'penanggung_jawab' => $result->penanggung_jawab,
              'lokasi' => $result->lokasi,
          );

          echo json_encode($data);
      }

      //fungsi untuk master data tenant
      public function delete_data_tenant($id){
          $this->data->delete_data("tenant",$id);
          echo json_encode(array("status" => TRUE));
      }

      public function ajax_data_tenant(){
          if($this->session->userdata('role') == 'admin'){
              $list = $this->data->get_datatables_tenant();
              $data = array();
              $no = $_POST['start'];

              foreach ($list as $result) {
                  $no++;
                  $row = array();
                  $row[] = "<center>".$no;
                  $row[] = "<center>".$result->nama_tenant;
                  $row[] = "<center>".$result->penanggung_jawab;
                  $row[] = $result->lokasi;
                  $row[] = $result->no_telp;
                  if($result->status_aktif == 1)
                      $status = "Aktif";
                  else
                      $status = "Tidak Aktif";
                  $row[] = $status;
                  $data_flow = $this->data->getIdFlowmeter($result->id_ref_flowmeter);
                  $row[] = $data_flow->id_flowmeter;
                  $row[] = '<center><a class="btn btn-sm btn-primary" href="editTenant?id=' . $result->id_tenant . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

                  $data[] = $row;
              }

              $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->data->count_all_tenant(),
                  "recordsFiltered" => $this->data->count_filtered_tenant(),
                  "data" => $data,
              );
          }
          else{
              $list = $this->data->get_datatables_tenant();
              $data = array();
              $no = $_POST['start'];

              foreach ($list as $result) {
                  $no++;
                  $row = array();
                  $row[] = "<center>".$no;
                  $row[] = "<center>".$result->nama_tenant;
                  $row[] = "<center>".$result->penanggung_jawab;
                  $row[] = $result->lokasi;
                  $row[] = '<center><a class="btn btn-sm btn-primary" href="editTenant?id=' . $result->id_tenant . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

                  $data[] = $row;
              }

              $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->data->count_all_tenant(),
                  "recordsFiltered" => $this->data->count_filtered_tenant(),
                  "data" => $data,
              );
          }

          //output to json format
          echo json_encode($output);
      }

      public function input_data_tenant(){
          if($this->session->userdata('role') == 'admin'){
              $nama_tenant = $this->input->post('nama_tenant');
              $penanggung_jawab = $this->input->post('penanggung_jawab');
              $alamat = $this->input->post('alamat');
              $no_telp = $this->input->post('no_telp');
              $id_flowmeter = $this->input->post('id_flowmeter');

              if($nama_tenant != NULL && $penanggung_jawab != NULL && $alamat != NULL){
                  $data_insert = array(
                      'nama_tenant' => $nama_tenant,
                      'penanggung_jawab' => $penanggung_jawab,
                      'lokasi' => $alamat,
                      'no_telp' => $no_telp,
                      'id_ref_flowmeter' => $id_flowmeter,
                      'pengguna_jasa_id' => '1',
                      'issued_at' => date("Y-m-d H:i:s",time()),
                      'issued_by' => $this->session->userdata('nama')
                  );
                  $query = $this->db->insert('master_tenant',$data_insert);

                  if($query){
                      $message = "Input Berhasil";
                  }
                  else{
                      $message = $this->db->error();
                  }
              }
              else{
                  $message = "Inputan Masih Kosong...Harap Diisi";
              }
          }

          echo $message;
      }

      public function editTenant(){
          if($this->session->userdata('role') == 'admin'){
              $id = $_GET['id'];
              $data['id'] = $id;
              $data['title'] = 'Edit Data Tenant';
              $this->db->from('master_tenant');
              $this->db->where('id_tenant',$id);
              $query = $this->db->get();
              $result = $query->row();

              $data['tenant'] = $this->data->getFlowmeter();

              $data['isi'] = array(
                  'id_tenant' => $result->id_tenant,
                  'nama_tenant' => $result->nama_tenant,
                  'penanggung_jawab' => $result->penanggung_jawab,
                  'status_aktif' => $result->status_aktif_tenant,
                  'alamat' => $result->lokasi,
                  'no_telp' => $result->no_telp,
                  'id_flowmeter' => $result->id_ref_flowmeter,
              );
          }

          $this->load->template('v_edit_tenant',$data);
      }

      public function edit_tenant(){
          if($this->session->userdata('role') == 'admin'){
              $id = $this->input->post('id_tenant');
              $nama_tenant = $this->input->post('nama_tenant');
              $penanggung_jawab = $this->input->post('penanggung_jawab');
              $alamat = $this->input->post('alamat');
              $no_telp = $this->input->post('no_telp');
              $id_flowmeter = $this->input->post('id_flowmeter');

              $data_edit = array(
                  'nama_tenant' => $nama_tenant,
                  'penanggung_jawab' => $penanggung_jawab,
                  'lokasi' => $alamat,
                  'no_telp' => $no_telp,
                  'id_ref_flowmeter' => $id_flowmeter,
                  'modified_at' => date("Y-m-d H:i:s",time()),
                  'modified_by' => $this->session->userdata('nama')
              );

              if($id != ""){
                  $this->db->set($data_edit);
                  $this->db->where('id_tenant', $id);
                  $query = $this->db->update('master_tenant');

                  if($query){
                      $message = "Edit Berhasil";
                  }else{
                      $message = "Edit Gagal";
                  }
              }
              else{
                  $message = "Masih Ada Yang Harus Di Isi";
              }
          }

          echo $message;
      }

      //fungsi untuk master data lumpsum
      public function ajax_data_lumpsum(){
          $list = $this->data->get_datatables_lumpsum();
          $data = array();
          $no = $_POST['start'];

          foreach ($list as $result) {
              $date_now = strtotime(date('Y-m-d',time() ));
              $date_kadaluarsa = strtotime($result->waktu_kadaluarsa);

              $no++;
              $row = array();
              $row[] = "<center>".$no;
              $row[] = "<center>".$result->no_perjanjian;
              $row[] = "<center>".$result->perihal;
              $row[] = "<center>".$result->waktu_kadaluarsa;
              $row[] = "<center>Rp. ".$this->Ribuan($result->nominal);
              $nama = $this->data->getTenant($result->id_ref_tenant);
              $row[] = "<center>".$nama->nama_tenant;
              if($date_now < $date_kadaluarsa || $date_now == $date_kadaluarsa){
                  $row[] = '<center><a class="btn btn-sm btn-primary" href="editLumpsum?id=' . $result->id_lumpsum . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
              } else{
                  $row[] = '';
              }

              $data[] = $row;
          }

          $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->data->count_all_lumpsum(),
              "recordsFiltered" => $this->data->count_filtered_lumpsum(),
              "data" => $data,
          );


          //output to json format
          echo json_encode($output);
      }

      public function input_data_lumpsum(){
          $no_perjanjian = $this->input->post('no_perjanjian');
          $nama_perjanjian = $this->input->post('nama_perjanjian');
          $waktu_kadaluarsa = $this->input->post('waktu_kadaluarsa');
          $nominal = $this->input->post('nominal');
          $tenant = $this->input->post('tenant');

          if($no_perjanjian != NULL && $nama_perjanjian != NULL && $waktu_kadaluarsa != NULL && $nominal){
              $data_insert = array(
                  'no_perjanjian' => $no_perjanjian,
                  'perihal' => $nama_perjanjian,
                  'waktu_kadaluarsa' => $waktu_kadaluarsa,
                  'nominal' => $nominal,
                  'id_ref_tenant' => $tenant,
                  'issued_at' => date("Y-m-d H:i:s",time()),
                  'issued_by' => $this->session->userdata('nama')
              );
              $query = $this->db->insert('master_lumpsum',$data_insert);

              if($query){
                  $message = "Input Berhasil";
              }
              else{
                  $message = "Input Gagal";
              }
          }
          else{
              $message = "Inputan Masih Kosong...Harap Diisi";
          }

          echo $message;
      }

      public function editLumpsum(){
          $id = $_GET['id'];
          $data['id'] = $id;
          $data['title'] = 'Edit Data Lumpsum';
          $this->db->from('master_lumpsum');
          $this->db->where('id_lumpsum',$id);
          $query = $this->db->get();
          $result = $query->row();

          $data['lumpsum'] = $this->data->getIDTenant();
          $data['isi'] = array(
              'no_perjanjian' => $result->no_perjanjian,
              'perihal' => $result->perihal,
              'waktu_kadaluarsa' => $result->waktu_kadaluarsa,
              'nominal' => $result->nominal,
              'id_tenant' => $result->id_ref_tenant
          );

          $this->load->template('v_edit_lumpsum',$data);
      }

      public function edit_lumpsum(){
          $id = $this->input->post('id_lumpsum');
          $no_perjanjian = $this->input->post('no_perjanjian');
          $nama_perjanjian = $this->input->post('nama_perjanjian');
          $waktu_kadaluarsa = $this->input->post('waktu_kadaluarsa');
          $nominal = $this->input->post('nominal');
          $tenant = $this->input->post('id_tenant');

          $data_edit = array(
              'no_perjanjian' => $no_perjanjian,
              'perihal' => $nama_perjanjian,
              'waktu_kadaluarsa' => $waktu_kadaluarsa,
              'nominal' => $nominal,
              'id_ref_tenant' => $tenant,
              'modified_at' => date("Y-m-d H:i:s",time()),
              'modified_by' => $this->session->userdata('nama')
          );

          if($id != ""){
              $this->db->set($data_edit);
              $this->db->where('id_lumpsum', $id);
              $query = $this->db->update('master_lumpsum');

              if($query){
                  $message = "Edit Berhasil";
              }else{
                  $message = "Edit Gagal";
              }
          }
          else{
              $message = "Masih Ada Yang Harus Di Isi";
          }

          echo $message;
      }

      //fungsi untuk master data sumur
      public function ajax_data_sumur(){
          if($this->session->userdata('role') == 'admin'){
              $list = $this->data->get_datatables_sumur();
              $data = array();
              $no = $_POST['start'];

              foreach ($list as $result) {
                  $no++;
                  $row = array();
                  $row[] = "<center>".$no;
                  $row[] = "<center>".$result->id_sumur;
                  $row[] = "<center>".$result->nama_sumur;
                  $row[] = "<center>".$result->lokasi;
                  $row[] = "<center>".$result->debit_air;
                  $row[] = '<center><a class="btn btn-sm btn-primary" href="editSumur?id=' . $result->id_master_sumur . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

                  $data[] = $row;
              }

              $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->data->count_all_sumur(),
                  "recordsFiltered" => $this->data->count_filtered_sumur(),
                  "data" => $data,
              );
          }
          else{

          }

          //output to json format
          echo json_encode($output);
      }

      public function input_data_sumur(){
          if($this->session->userdata('role') == 'admin'){
              $id_sumur = $this->input->post('id_sumur');
              $nama_sumur = $this->input->post('nama_sumur');
              $lokasi = $this->input->post('lokasi');
              $debit = $this->input->post('debit_air');

              if($id_sumur != NULL && $nama_sumur != NULL && $lokasi != NULL){
                  $data_insert = array(
                      'id_sumur' => $id_sumur,
                      'nama_sumur' => $nama_sumur,
                      'lokasi' => $lokasi,
                      'debit_air' => $debit,
                      'issued_at' => date("Y-m-d H:i:s",time()),
                      'issued_by' => $this->session->userdata('nama')
                  );
                  $query = $this->db->insert('master_sumur',$data_insert);

                  if($query){
                      $message = "Input Berhasil";
                  }
                  else{
                      $message = "Input Gagal";
                  }
              }
              else{
                  $message = "Inputan Masih Kosong...Harap Diisi";
              }
          }

          echo $message;
      }

      public function editSumur(){
          $id = $_GET['id'];
          $data['id'] = $id;
          $data['title'] = 'Edit Data Sumur';
          $this->db->from('master_sumur');
          $this->db->where('id_master_sumur',$id);
          $query = $this->db->get();
          $result = $query->row();

          $data['isi'] = array(
              'id_sumur' => $result->id_sumur,
              'nama_sumur' => $result->nama_sumur,
              'lokasi' => $result->lokasi,
              'debit_air' => $result->debit_air,
          );

          $this->load->template('v_edit_sumur',$data);
      }

      public function edit_sumur(){
          $id = $this->input->post('id');
          $id_sumur = $this->input->post('id_sumur');
          $nama_sumur = $this->input->post('nama_sumur');
          $lokasi = $this->input->post('lokasi');
          $debit = $this->input->post('debit_air');

          $data_edit = array(
              'id_sumur' => $id_sumur,
              'nama_sumur' => $nama_sumur,
              'lokasi' => $lokasi,
              'debit_air' => $debit,
              'modified_at' => date("Y-m-d H:i:s",time()),
              'modified_by' => $this->session->userdata('nama')
          );

          if($id != ""){
              $this->db->set($data_edit);
              $this->db->where('id_master_sumur', $id);
              $query = $this->db->update('master_sumur');

              if($query){
                  $message = "Edit Berhasil";
              }else{
                  $message = "Edit Gagal";
              }
          }
          else{
              $message = "Masih Ada Yang Harus Di Isi";
          }

          echo $message;
      }

      //fungsi untuk master data pompa
      public function ajax_data_pompa(){
          if($this->session->userdata('role') == 'wtp' || $this->session->userdata('role') == 'admin'){
              $list = $this->data->get_datatables_pompa();
              $data = array();
              $no = $_POST['start'];

              foreach ($list as $result) {
                  $no++;
                  $row = array();
                  $row[] = "<center>".$no;
                  $row[] = "<center>".$result->id_pompa;
                  $row[] = "<center>".$result->nama_pompa;
                  if($result->kondisi == 'baik')
                      $kondisi = 'Baik';
                  else if($result->kondisi == 'kurang_baik')
                      $kondisi = "Kurang Baik";
                  else
                      $kondisi = "Rusak";

                  $row[] = "<center>".$kondisi;

                  if($result->status_aktif == 1)
                      $status = "Aktif";
                  else
                      $status = "Tidak Aktif";

                  $row[] = "<center>".$status;
                  $data_pompa = $this->data->getNamaSumur($result->id_ref_sumur);
                  $row[] = "<center>".$data_pompa->id_sumur;
                  $row[] = '<center><a class="btn btn-sm btn-primary" href="editPompa?id=' . $result->id_master_pompa . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

                  $data[] = $row;
              }

              $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->data->count_all_pompa(),
                  "recordsFiltered" => $this->data->count_filtered_pompa(),
                  "data" => $data,
              );
          }
          else{

          }

          //output to json format
          echo json_encode($output);
      }

      public function input_data_pompa(){
          if($this->session->userdata('role') == 'wtp' || $this->session->userdata('role') == 'admin'){
              $id_pompa = $this->input->post('id_pompa');
              $nama_pompa = $this->input->post('nama_pompa');
              $kondisi = $this->input->post('kondisi');
              $id_sumur = $this->input->post('id_sumur');

              if($id_pompa != NULL && $nama_pompa != NULL){
                  $data_insert = array(
                      'id_pompa' => $id_pompa,
                      'nama_pompa' => $nama_pompa,
                      'kondisi' => $kondisi,
                      'id_ref_sumur' => $id_sumur,
                      'issued_at' => date("Y-m-d H:i:s",time()),
                      'issued_by' => $this->session->userdata('nama')
                  );
                  $query = $this->db->insert('master_pompa',$data_insert);

                  if($query){
                      $message = "Input Berhasil";
                  }
                  else{
                      $message = "Input Gagal";
                  }
              }
              else{
                  $message = "Inputan Masih Kosong...Harap Diisi";
              }
          }

          echo $message;
      }

      public function editPompa(){
          $id = $_GET['id'];
          $data['id'] = $id;
          $data['title'] = 'Edit Data Pompa';
          $this->db->from('master_pompa');
          $this->db->where('id_master_pompa',$id);
          $query = $this->db->get();
          $result = $query->row();

          $data['pompa'] = $this->data->getIDSumur();

          $data['isi'] = array(
              'id_pompa' => $result->id_pompa,
              'nama_pompa' => $result->nama_pompa,
              'kondisi' => $result->kondisi,
              'status_aktif' => $result->status_aktif,
              'id_sumur' => $result->id_ref_sumur,
          );

          $this->load->template('v_edit_pompa',$data);
      }

      public function edit_pompa(){
          $id = $this->input->post('id');
          $id_pompa = $this->input->post('id_pompa');
          $nama_pompa = $this->input->post('nama_pompa');
          $kondisi = $this->input->post('kondisi');
          $id_sumur = $this->input->post('id_sumur');
          $status = $this->input->post('status');

          $data_edit = array(
              'id_pompa' => $id_pompa,
              'nama_pompa' => $nama_pompa,
              'kondisi' => $kondisi,
              'status_aktif' => $status,
              'id_ref_sumur' => $id_sumur,
              'modified_at' => date("Y-m-d H:i:s",time()),
              'modified_by' => $this->session->userdata('username')
          );

          if($id != ""){
              $this->db->set($data_edit);
              $this->db->where('id_master_pompa', $id);
              $query = $this->db->update('master_pompa');

              if($query){
                  $message = "Edit Berhasil";
              }else{
                  $message = "Edit Gagal";
              }
          }
          else{
              $message = "Masih Ada Yang Harus Di Isi";
          }

          echo $message;
      }

      //fungsi untuk master data flowmeter
      public function ajax_data_flowmeter(){
          if($this->session->userdata('role') == 'wtp' || $this->session->userdata('role') == 'admin'){
              $list = $this->data->get_datatables_flowmeter();
              $data = array();
              $no = $_POST['start'];

              foreach ($list as $result) {
                  $no++;
                  $row = array();
                  $row[] = "<center>".$no;
                  $row[] = "<center>".$result->id_flowmeter;
                  $row[] = "<center>".$result->nama_flowmeter;
                  $row[] = "<center>".$result->flowmeter_awal;
                  $row[] = "<center>".$result->flowmeter_akhir;
                  if($result->kondisi == 'baik')
                      $kondisi = "Baik";
                  else if($result->kondisi == 'kurang_baik')
                      $kondisi = "Kurang Baik";
                  else
                      $kondisi = "Rusak";
                  $row[] = $kondisi;

                  if($result->status_aktif == 1)
                      $status = 'Aktif';
                  else
                      $status = 'Tidak Aktif';
                  $flowmeter = $this->data->getNamaPompa($result->id_flow);
                  $row[] = "<center>".$flowmeter->id_pompa;
                  $row[] = $status;
                  $row[] = '<center><a class="btn btn-sm btn-primary" href="editFlowmeter?id=' . $result->id_flow . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

                  $data[] = $row;
              }

              $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->data->count_all_flowmeter(),
                  "recordsFiltered" => $this->data->count_filtered_flowmeter(),
                  "data" => $data,
              );
          }
          else{

          }

          //output to json format
          echo json_encode($output);
      }

      public function input_data_flowmeter(){
          if($this->session->userdata('role') == 'wtp' || $this->session->userdata('role') == 'admin'){
              $id_flowmeter = $this->input->post('id_flowmeter');
              $nama_flowmeter = $this->input->post('nama_flowmeter');
              $kondisi = $this->input->post('kondisi');
              $pompa = $this->input->post('id_pompa');

              if($id_flowmeter != NULL && $nama_flowmeter != NULL && $kondisi != NULL){
                  $data_insert = array(
                      'id_flowmeter' => $id_flowmeter,
                      'nama_flowmeter' => $nama_flowmeter,
                      'kondisi' => $kondisi,
                      'id_ref_pompa' => $pompa,
                      'issued_at' => date("Y-m-d H:i:s",time()),
                      'issued_by' => $this->session->userdata('username')
                  );
                  $query = $this->db->insert('master_flowmeter',$data_insert);

                  if($query){
                      $message = "Input Berhasil";
                  }
                  else{
                      $message = "Input Gagal";
                  }
              }
              else{
                  $message = "Inputan Masih Kosong...Harap Diisi";
              }
          }
          else{

          }

          echo $message;
      }

      public function editFlowmeter(){
          $id = $_GET['id'];
          $data['id'] = $id;
          $data['title'] = 'Edit Data Flow Meter';
          $this->db->from('master_flowmeter');
          $this->db->where('id_flow',$id);
          $query = $this->db->get();
          $result = $query->row();

          $data['kondisi'] = $this->data->getKondisi();
          $data['pompa'] = $this->data->getPompa();

          $data['isi'] = array(
              'id_flowmeter' => $result->id_flowmeter,
              'nama_flowmeter' => $result->nama_flowmeter,
              'status_aktif' => $result->status_aktif,
              'kondisi' => $result->kondisi,
              'id_pompa' => $result->id_ref_pompa,
              'flowmeter_awal' => $result->flowmeter_awal,
              'flowmeter_akhir' => $result->flowmeter_akhir,
          );

          $this->load->template('v_edit_flowmeter',$data);
      }

      public function edit_flowmeter(){
          $id = $this->input->post('id_flow');
          $id_flowmeter = $this->input->post('id_flowmeter');
          $nama_flowmeter = $this->input->post('nama_flowmeter');
          $kondisi = $this->input->post('kondisi');
          $status = $this->input->post('status_aktif');
          $flow_awal = $this->input->post('flowmeter_awal');
          $flow_akhir = $this->input->post('flowmeter_akhir');
          $pompa = $this->input->post('id_pompa');

          $data_edit = array(
              'id_flowmeter' => $id_flowmeter,
              'nama_flowmeter' => $nama_flowmeter,
              'status_aktif' => $status,
              'kondisi' => $kondisi,
              'flowmeter_awal' => $flow_awal,
              'flowmeter_akhir' => $flow_akhir,
              'id_ref_pompa' => $pompa,
              'last_modified' => date("Y-m-d H:i:s",time()),
              'modified_by' => $this->session->userdata('nama')
          );

          if($id != ""){
              $this->db->set($data_edit);
              $this->db->where('id_flow', $id);
              $query = $this->db->update('master_flowmeter');

              if($query){
                  $message = "Edit Berhasil";
              }else{
                  $message = "Edit Gagal";
              }
          }
          else{
              $message = "Masih Ada Yang Harus Di Isi";
          }

          echo $message;
      }

      //fungsi untuk master data tarif
      public function tarif(){
          $data['title'] = "Penyesuaian Tarif";
          $this->load->template('v_tarif',$data);
      }

      public function delete_data_tarif($id){
          $this->data->delete_data_tarif($id);
          echo json_encode(array("status" => TRUE));
      }

      public function ajax_data_tarif(){
          $list = $this->data->get_datatables_tarif();
          $data = array();
          $no = $_POST['start'];

          foreach ($list as $result) {
              $no++;
              $row = array();
              $row[] = "<center>".$no;
              $row[] = "<center>".$result->tipe_pengguna_jasa;
              $row[] = "<center>".$result->kawasan;
              $row[] = "<center>".$result->tipe;
              $row[] = "<center>".$result->tarif;
              $row[] = "<center>".$result->diskon;

              $row[] = '<center><a class="btn btn-sm btn-primary" href="editTarif?id=' . $result->id_tarif . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
              $data[] = $row;
          }

          $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->data->count_all_tarif(),
              "recordsFiltered" => $this->data->count_filtered_tarif(),
              "data" => $data,
          );
          //output to json format
          echo json_encode($output);
      }

      public function input_data_tarif(){
          $tipe_pengguna = $this->input->post('tipe_pengguna');
          $kawasan = $this->input->post('kawasan');
          $tarif = $this->input->post('tarif');
          $tipe = $this->input->post('tipe');
          $diskon = $this->input->post('diskon');

          if(isset($tipe_pengguna)  && $tarif != NULL && $tipe != NULL ){
              $data_insert = array(
                  'tipe_pengguna_jasa' => $tipe_pengguna,
                  'kawasan' => $kawasan,
                  'tipe' => $tipe,
                  'tarif' => $tarif,
                  'diskon' => $diskon,
                  'issued_at' => date("Y-m-d H:i:s",time()),
                  'issued_by' => $this->session->userdata('username')
              );
              $query = $this->db->insert('pengguna_jasa',$data_insert);

              if($query){
                  $message = "Input Berhasil";
              }
              else{
                  $message = "Input Gagal";
              }
          }
          else{
              $message = "Inputan Masih Kosong...Harap Diisi";
          }
          echo $message;
      }

      public function editTarif(){
          $id = $_GET['id'];
          $data['id'] = $id;
          $data['title'] = 'Edit Data Tarif';
          $this->db->from('pengguna_jasa');
          $this->db->where('id_tarif',$id);
          $query = $this->db->get();
          $result = $query->row();

          $data['isi'] = array(
              'tipe_pengguna_jasa' => $result->tipe_pengguna_jasa,
              'kawasan' => $result->kawasan,
              'tipe' => $result->tipe,
              'tarif' => $result->tarif,
              'diskon' => $result->diskon,
          );

          $this->load->template('v_edit_tarif',$data);
      }

      public function edit_tarif(){
          $id = $this->input->post('id');
          $tipe_pengguna = $this->input->post('tipe_pengguna');
          $kawasan = $this->input->post('kawasan');
          $tarif = $this->input->post('tarif');
          $tipe = $this->input->post('tipe');
          $diskon = $this->input->post('diskon');
          $data_edit = array(
              'tipe_pengguna_jasa' => $tipe_pengguna,
              'kawasan' => $kawasan,
              'tipe' => $tipe,
              'tarif' => $tarif,
              'diskon' => $diskon,
              'last_modified' => date("Y-m-d H:i:s",time()),
              'modified_by' => $this->session->userdata('username')
          );
          if($id != ""){
              $this->db->set($data_edit);
              $this->db->where('id_tarif', $id);
              $query = $this->db->update('pengguna_jasa');

              if($query){
                  $message = "Edit Berhasil";
              }else{
                  $message = "Edit Gagal";
              }
          }
          else{
              $message = "Tolong Isi Kolom Pengguna Jasa";
          }
          echo $message;
      }

      //fungsi untuk master data agent
      public function cariAgent(){
          $nama = $this->input->post('nama_perusahaan');
          $this->db->select('*');
          $this->db->from('master_agent');
          $this->db->where('nama_agent =', $nama);
          $query = $this->db->get();

          if($query->num_rows() > 0){
              $result = $query->row();

              $data = array(
                  'status' => 'success',
                  'id' => $result->id_agent,
                  'alamat' => $result->alamat,
                  'telepon' => $result->no_telp,
              );
          }else{
              $data = array(
                  'status' => 'failed'
              );
          }

          echo json_encode($data);
      }

      public function delete_data_agent($id){
          $this->data->delete_data_agent($id);
          echo json_encode(array("status" => TRUE));
      }

      public function ajax_data_agent(){
          $list = $this->data->get_datatables_agent();
          $data = array();
          $no = $_POST['start'];

          foreach ($list as $result) {
              $no++;
              $row = array();
              $row[] = "<center>".$no;
              $row[] = "<center>".$result->nama_agent;
              $row[] = "<center>".$result->alamat;
              $row[] = "<center>".$result->no_telp;
              $row[] = "<center>".$result->npwp;

              $row[] = '<center><a class="btn btn-sm btn-primary" href="editAgent?id=' . $result->id_agent . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                      ';

              $data[] = $row;
          }

          $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->data->count_all_agent(),
              "recordsFiltered" => $this->data->count_filtered_agent(),
              "data" => $data,
          );
          //output to json format
          echo json_encode($output);
      }

      public function input_data_agent(){
          $nama = $this->input->post('nama_perusahaan');
          $alamat = $this->input->post('alamat');
          $no_telp = $this->input->post('no_telp');
          $npwp = $this->input->post('npwp');

          if(isset($nama)  && $alamat != NULL && $npwp != NULL && $npwp != NULL){
              $data_insert = array(
                  'nama_agent' => $nama,
                  'alamat' => $alamat,
                  'no_telp' => $no_telp,
                  'npwp' => $npwp,
                  'issued_at' => date("Y-m-d H:i:s",time()),
                  'issued_by' => $this->session->userdata('username')
              );
              $query = $this->db->insert('master_agent',$data_insert);

              if($query){
                  $message = "Input Berhasil";
              }
              else{
                  $message = "Input Gagal";
              }
          }
          else{
              $message = "Inputan Masih Kosong...Harap Diisi";
          }
          echo $message;
      }

      public function editAgent(){
          $id = $_GET['id'];
          $data['id'] = $id;
          $data['title'] = 'Edit Data Tarif';
          $this->db->from('master_agent');
          $this->db->where('id_agent',$id);
          $query = $this->db->get();
          $result = $query->row();

          $data['isi'] = array(
              'id_agent' => $result->id_agent,
              'nama_agent' => $result->nama_agent,
              'alamat' => $result->alamat,
              'no_telp' => $result->no_telp,
              'npwp' => $result->npwp,
          );

          $this->load->template('v_edit_agent',$data);
      }

      public function edit_agent(){
          $id = $this->input->post('id');
          $nama = $this->input->post('nama_perusahaan');
          $alamat = $this->input->post('alamat');
          $no_telp = $this->input->post('no_telp');
          $npwp = $this->input->post('npwp');

          $data_edit = array(
              'nama_agent' => $nama,
              'alamat' => $alamat,
              'no_telp' => $no_telp,
              'npwp' => $npwp,
              'modified_at' => date("Y-m-d H:i:s",time()),
              'modified_by' => $this->session->userdata('username'),
          );

          if($id != ""){
              $this->db->set($data_edit);
              $this->db->where('id_agent', $id);
              $query = $this->db->update('master_agent');

              if($query){
                  $message = "Edit Berhasil";
              }else{
                  $message = "Edit Gagal";
              }
          }
          else{
              $message = "Tolong Isi Kolom Pengguna Jasa";
          }
          echo $message;
      }

      public function agent(){
          $data['title'] = "Master Agent";
          if($this->session->userdata('role') == 'admin'){
              $data['tipe'] = 'laut_admin';
          } else{
              $data['tipe'] = 'laut';
          }
          $this->load->template('v_master',$data);
      }

      //fungsi manajemen user
      function login(){
          $this->form_validation->set_rules('username', 'Username', 'trim|required');
          $this->form_validation->set_rules('password', 'Password', 'trim|required');

          if ($this->form_validation->run() == FALSE) {
              $this->data = array(
                  'title' => "PT KKT - APP AIR",
              );
              $this->load->template('v_main',$this->data);
          }
          else {
              $key = "PTKKT2406";
              $session = md5($this->input->post('username').$key.$this->input->post('password').$key);
              $user = $this->data->login($session);

              if ($user != NULL) {
                  $session  = $user->session;
                  $username = $user->username;
                  $role  = $user->role;
                  $password = $user->password;

                  $session_data = array(
                      'session' => $session,
                      'username' => $username,
                      'password' => $password,
                      'role' => $role,
                      'nama' => $user->nama
                  );

                  // Add user data in session
                  $this->session->set_userdata($session_data);
                  $waktu = date("Y-m-d H:i:s", time());

                  $data = array(
                      'username'   => $username,
                      'last_login'  => $waktu
                  );

                  $this->data->update_login($data);
                  $data = array(
                      'title' => "PT KKT - APP AIR",
                  );

                  $this->load->template('v_main',$data);
              }
              else {
                  $data = array(
                      'title' => "PT KKT - APP AIR",
                  );

                  $this->session->set_userdata('error_message','Username atau Password Anda Salah');
                  $this->load->template('v_main', $data);
              }
          }
      }

      function logout(){
          $sess_array = array(
              'session',
              'username',
              'password',
              'role',
              'nama'
          );
          $this->session->unset_userdata($sess_array);

          $data = array(
              'title' => "PT KKT - APP AIR"
          );
          $this->session->set_userdata('message_display','Anda Telah Berhasil Logout');
          $this->load->template('v_main', $data);
      }

      public function ajax_list() {
          $this->load->helper('url');

          $list = $this->data->get_datatables();
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $person) {
              $no++;
              $row = array();
              $row[] = '<input type="checkbox" class="data-check" value="'.$person->id_user.'">';
              $row[] = $person->username;
              $row[] = $person->nama;
              $row[] = $person->role;

              //add html for action
              $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id_user."'".')"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
  				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_user."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';

              $data[] = $row;
          }

          $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->data->count_all(),
              "recordsFiltered" => $this->data->count_filtered(),
              "data" => $data,
          );
          //output to json format
          echo json_encode($output);
      }

      public function ajax_edit($id) {
          $data = $this->data->get_data_by_id($id);
          echo json_encode($data);
      }

      public function ajax_add() {
          $this->_validate();
          $key     = "PTKKT2406";
          $session = md5($this->input->post('username').$key.$this->input->post('pass').$key);
          $data = array(
              'username' => $this->input->post('username'),
              'password' => $this->input->post('pass'),
              'nama' => $this->input->post('nama'),
              'role' => $this->input->post('role'),
              'session' => $session,
          );

          $insert = $this->data->save($data);

          echo json_encode(array("status" => TRUE));
      }

      public function ajax_update() {
          $this->_validate();
          $key     = "PTKKT2406";
          $session = md5($this->input->post('username').$key.$this->input->post('pass').$key);
          $data = array(
              'username' => $this->input->post('username'),
              'password' => $this->input->post('pass'),
              'nama' => $this->input->post('nama'),
              'role' => $this->input->post('role'),
              'session' => $session,
          );
          $waktu      = date("Y-m-d H:i:s", time());
          $data_waktu = array(
              'username'   => $this->input->post('username'),
              'last_updated'  => $waktu
          );
          $this->data->update_data($data_waktu);
          $this->data->update(array('id_user' => $this->input->post('id')), $data);
          echo json_encode(array("status" => TRUE));
      }

      public function ajax_delete($id) {
          $this->data->delete_by_id($id);
          echo json_encode(array("status" => TRUE));
      }

      public function ajax_bulk_delete() {
          $list_id = $this->input->post('id');
          foreach ($list_id as $id) {
              $this->data->delete_by_id($id);
          }
          echo json_encode(array("status" => TRUE));
      }

      private function _validate() {
          $data = array();
          $data['error_string'] = array();
          $data['inputerror'] = array();
          $data['status'] = TRUE;

          if($this->input->post('username') == NULL)
          {
              $data['inputerror'][] = 'username';
              $data['error_string'][] = 'Nama Akun Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('pass') == NULL)
          {
              $data['inputerror'][] = 'pass';
              $data['error_string'][] = 'Kata Sandi Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('role') == NULL)
          {
              $data['inputerror'][] = 'role';
              $data['error_string'][] = 'Hak Akses Masih Belum Dipilih';
              $data['status'] = FALSE;
          }

          if($this->input->post('confirm_pass') == NULL)
          {
              $data['inputerror'][] = 'confirm_pass';
              $data['error_string'][] = 'Konfirmasi Kata Sandi Masih Kosong';
              $data['status'] = FALSE;
          }

          if($this->input->post('pass') != $this->input->post('confirm_pass'))
          {
              $data['inputerror'][] = 'pass';
              $data['error_string'][] = 'Kata Sandi dan Konfirmasi Kata Sandi Tidak Sama';
              $data['status'] = FALSE;
          }

          if($data['status'] === FALSE)
          {
              echo json_encode($data);
              exit();
          }
      }

      public function update_pass(){
          $key     = "PTKKT2406";
          $session = md5($this->input->post('username').$key.$this->input->post('password').$key);
          $waktu = date("Y-m-d H:i:s", time());

          $data  = array(
              'username' => $this->input->post('username'),
              'password' => $this->input->post('password'),
              'session' => $session,
              'last_modified' => $waktu
          );
          $this->db->where('username', $data['username']);
          $update = $this->db->update('users', $data);

          if ($update) {
              return true;
          } else {
              return false;
          }
      }
  }

 ?>
