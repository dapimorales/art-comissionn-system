<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Hanya yang sudah login yang bisa mengakses
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect('auth/login');
        }

        $this->load->model('Pembayaran_model'); 
        $this->load->model('Metode_bayar_model'); 
        $this->load->model('Komisi_model');
        $this->load->library('form_validation');
    }

    // Tampilkan form pembayaran
    public function form($id_komisi) {
        $komisi = $this->Komisi_model->get_komisi_by_klien($this->session->userdata('id_user')); 
        
        // Cari detail komisi dari list yang diambil (untuk memastikan komisi milik klien ini)
        $detail_komisi = array_filter($komisi, function($k) use ($id_komisi) {
            return $k->id_komisi == $id_komisi;
        });
        $detail_komisi = reset($detail_komisi);

        if (!$detail_komisi || $detail_komisi->status_komisi != 'Pending') {
             $this->session->set_flashdata('error', 'Pesanan tidak ditemukan atau statusnya sudah tidak Pending.');
             redirect('komisi');
        }

        $data['title'] = 'Konfirmasi Pembayaran Komisi #' . $id_komisi;
        $data['komisi'] = $detail_komisi;
        $data['metode_bayar'] = $this->Metode_bayar_model->get_all_metode();
        
        $this->load->view('layout/v_header', $data);
        $this->load->view('transaksi/pembayaran/v_form', $data);
        $this->load->view('layout/v_footer');
    }
    
    // Proses upload bukti bayar
    public function proses_konfirmasi() {
        $id_komisi = $this->input->post('id_komisi');
        
        $this->form_validation->set_rules('id_metode_bayar', 'Metode Bayar', 'required|numeric');
        $this->form_validation->set_rules('tanggal_bayar', 'Tanggal Bayar', 'required');
        
        // Konfigurasi Upload Gambar Bukti Bayar
        $config['upload_path']   = './assets/bukti_bayar/'; // Pastikan folder ini ada
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048; // 2MB
        $config['file_name']     = 'bukti-' . $id_komisi . '-' . time();

        $this->load->library('upload', $config);

        if ($this->form_validation->run() == FALSE || !$this->upload->do_upload('bukti_bayar')) {
            // Jika validasi form gagal atau upload gagal
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', strip_tags($error));
            $this->form($id_komisi);
        } else {
            $upload_data = $this->upload->data();
            
            $data = array(
                'id_komisi'         => $id_komisi,
                'id_metode_bayar'   => $this->input->post('id_metode_bayar'),
                'tanggal_bayar'     => $this->input->post('tanggal_bayar'),
                'jumlah_bayar'      => $this->input->post('jumlah_bayar'), // Asumsi dari hidden field di form
                'bukti_transfer'    => $upload_data['file_name'],
                'status_verifikasi' => 'Menunggu' // Status awal
            );

            if ($this->Pembayaran_model->insert_pembayaran($data, $id_komisi)) {
                $this->session->set_flashdata('success', 'Konfirmasi pembayaran berhasil diunggah. Menunggu verifikasi dari Admin/Artist.');
                redirect('komisi');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data pembayaran ke database.');
                redirect('pembayaran/form/' . $id_komisi);
            }
        }
    }
    // Tambahkan fungsi-fungsi ini di dalam class Pembayaran extends CI_Controller

    // Fungsi Admin: Menampilkan daftar pembayaran yang perlu diverifikasi
    public function verifikasi_list() {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses Admin diperlukan.');
            redirect('dashboard');
        }
        
        $data['title'] = 'Verifikasi Pembayaran Masuk';
        // Ambil data pembayaran yang statusnya 'Menunggu' dan gabungkan dengan detail komisi dan klien.
        $data['pembayaran'] = $this->get_pembayaran_pending_for_admin();
        
        $this->load->view('layout/v_header', $data);
        $this->load->view('transaksi/pembayaran/v_admin_list', $data); 
        $this->load->view('layout/v_footer');
    }

    // Fungsi Helper: Mengambil data pembayaran pending dengan JOIN (bisa dipindahkan ke Pembayaran_model)
    private function get_pembayaran_pending_for_admin() {
        $this->db->select('tp.*, k.total_harga, k.id_klien, u.nama as nama_klien, mb.nama_metode');
        $this->db->from('transaksi_pembayaran tp');
        $this->db->join('komisi k', 'k.id_komisi = tp.id_komisi');
        $this->db->join('users u', 'u.id_user = k.id_klien');
        $this->db->join('metode_bayar mb', 'mb.id_bayar = tp.id_metode_bayar');
        $this->db->where('tp.status_verifikasi', 'Menunggu');
        $this->db->order_by('tp.tanggal_bayar', 'ASC');
        return $this->db->get()->result();
    }

    // Fungsi Admin: Proses verifikasi (mengubah status)
    public function proses_verifikasi($id_transaksi, $status) {
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }
        
        // Ambil data transaksi
        $transaksi = $this->db->get_where('transaksi_pembayaran', ['id_transaksi' => $id_transaksi])->row();
        
        if (!$transaksi) {
            $this->session->set_flashdata('error', 'Transaksi tidak ditemukan.');
            redirect('pembayaran/verifikasi_list');
        }

        if ($status == 'Lunas') {
            // Jika pembayaran Lunas/Diterima
            $new_status_verifikasi = 'Lunas';
            $new_status_komisi = 'In Progress'; // Langsung pindah ke status pengerjaan
            $message = 'Pembayaran komisi #' . $transaksi->id_komisi . ' berhasil diverifikasi dan pesanan dimulai.';
        } else if ($status == 'Gagal') {
            // Jika pembayaran Gagal/Ditolak
            $new_status_verifikasi = 'Gagal';
            $new_status_komisi = 'Pending'; // Kembali ke status pending (klien harus bayar ulang)
            $message = 'Verifikasi pembayaran komisi #' . $transaksi->id_komisi . ' gagal. Klien perlu mengunggah bukti baru.';
        } else {
            $this->session->set_flashdata('error', 'Status verifikasi tidak valid.');
            redirect('pembayaran/verifikasi_list');
            return;
        }

        // Lakukan update
        if ($this->update_status_transaksi($id_transaksi, $new_status_verifikasi, $transaksi->id_komisi, $new_status_komisi)) {
            $this->session->set_flashdata('success', $message);
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui status di database.');
        }

        redirect('pembayaran/verifikasi_list');
    }
    
    // Fungsi yang menangani update di model/db
    private function update_status_transaksi($id_transaksi, $status_verifikasi, $id_komisi, $status_komisi) {
        $this->db->trans_start();
        
        // 1. Update status transaksi pembayaran
        $this->db->where('id_transaksi', $id_transaksi);
        $this->db->update('transaksi_pembayaran', ['status_verifikasi' => $status_verifikasi]);
        
        // 2. Update status komisi utama
        $this->db->where('id_komisi', $id_komisi);
        $this->db->update('komisi', ['status_komisi' => $status_komisi]);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}