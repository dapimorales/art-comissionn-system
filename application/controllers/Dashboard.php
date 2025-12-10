<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// application/controllers/Dashboard.php (Revisi fungsi index)

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cek login...
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect('auth/login');
        }
        $this->load->model('Komisi_model');
        $this->load->model('Pembayaran_model'); // Pastikan ini juga dimuat
    }

    public function index() {
        $role = $this->session->userdata('role');
        $data['user'] = $this->session->userdata();
        
        $this->load->view('layout/v_header', $data);

        if ($role == 'admin') {
            $data['title'] = 'Dashboard Admin/Artist';
            // Ambil data untuk Admin
            $data['komisi_stats'] = $this->Komisi_model->count_komisi_status();
            $data['transaksi_pending'] = $this->Pembayaran_model->count_pembayaran_pending(); // Anda perlu buat fungsi ini di Pembayaran_model
            $data['komisi_terbaru'] = $this->Komisi_model->get_all_komisi(5); // Ambil 5 komisi terbaru
            
            $this->load->view('dashboard/v_admin_dashboard', $data);

        } elseif ($role == 'klien') {
            $data['title'] = 'Dashboard Klien';
            $id_klien = $this->session->userdata('id_user');
            // Ambil data untuk Klien
            $data['komisi_stats'] = $this->Komisi_model->count_komisi_status_by_klien($id_klien);
            $data['komisi_list'] = $this->Komisi_model->get_komisi_by_klien($id_klien); // Daftar komisi klien
            
            $this->load->view('dashboard/v_klien_dashboard', $data);

        }
        $this->load->view('layout/v_footer');
    }
}