<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komisi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Cek login dan pastikan hanya Klien yang bisa memesan (kecuali fungsi admin/list)
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect('auth/login');
        }

        $this->load->model('Komisi_model'); 
        $this->load->model('Gaya_seni_model'); 
        $this->load->model('Tipe_komisi_model'); 
        $this->load->library('form_validation'); 
    }

    // Halaman list komisi (untuk Klien)
    public function index() {
        if ($this->session->userdata('role') != 'klien') {
            redirect('dashboard'); // Admin harusnya melihat di dashboard admin
        }
        
        $id_klien = $this->session->userdata('id_user');
        $data['title'] = 'Riwayat Pesanan Komisi Anda';
        $data['komisi_list'] = $this->Komisi_model->get_komisi_by_klien($id_klien);
        
        $this->load->view('layout/v_header', $data);
        $this->load->view('transaksi/komisi/v_klien_list', $data);
        $this->load->view('layout/v_footer');
    }

    // Tampilkan form pemesanan
    public function form() {
        // Batasi hanya untuk Klien
        if ($this->session->userdata('role') != 'klien') {
            $this->session->set_flashdata('error', 'Hanya Klien yang dapat membuat pesanan komisi.');
            redirect('dashboard');
        }
        
        $data['title'] = 'Form Pemesanan Komisi';
        $data['gaya_seni'] = $this->Gaya_seni_model->get_all_gaya(); // Ambil data master Gaya
        $data['tipe_komisi'] = $this->Tipe_komisi_model->get_all_tipe(); // Ambil data master Tipe
        
        $this->load->view('layout/v_header', $data);
        $this->load->view('transaksi/komisi/v_form', $data); 
        $this->load->view('layout/v_footer');
    }

    // Proses penyimpanan pesanan komisi
    public function proses_pesan() {
        // Validasi input
        $this->form_validation->set_rules('id_gaya', 'Gaya Seni', 'required|numeric');
        $this->form_validation->set_rules('id_tipe', 'Tipe Komisi', 'required|numeric');
        $this->form_validation->set_rules('deskripsi_request', 'Deskripsi Request', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->form(); // Kembali ke form jika gagal
        } else {
            $id_gaya = $this->input->post('id_gaya');
            $id_tipe = $this->input->post('id_tipe');
            
            // 1. Ambil Harga Komponen
            $harga_komponen = $this->Komisi_model->get_harga_komponen($id_gaya, $id_tipe);
            
            if (!$harga_komponen) {
                $this->session->set_flashdata('error', 'Gaya atau Tipe komisi tidak valid.');
                redirect('komisi/form');
                return;
            }
            
            $total_harga = $harga_komponen['harga_dasar'] + $harga_komponen['biaya_tambahan'];

            // 2. Siapkan Data Transaksi
            $data = array(
                'id_klien'          => $this->session->userdata('id_user'),
                'id_gaya'           => $id_gaya,
                'id_tipe'           => $id_tipe,
                'deskripsi_request' => $this->input->post('deskripsi_request'),
                'total_harga'       => $total_harga,
                'status_komisi'     => 'Pending' // Status awal
            );

            // 3. Simpan ke Database
            if ($this->Komisi_model->insert_komisi($data)) {
                $this->session->set_flashdata('success', 'Pesanan komisi berhasil dibuat! Silakan lakukan pembayaran.');
                redirect('komisi'); // Arahkan ke list komisi klien
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan pesanan.');
                redirect('komisi/form');
            }
        }
    }

    // application/controllers/Komisi.php

// ... (di dalam class Komisi extends CI_Controller)

    // Fungsi Admin: Menampilkan daftar komisi berdasarkan status (seperti di Dashboard)
    public function list_admin($status = null) {
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard'); 
        }

        $data['title'] = 'Daftar Komisi';
        
        // Filter berdasarkan status jika status diberikan (cth: /komisi/list_admin/In Progress)
        if ($status) {
            $data['komisi_list'] = $this->Komisi_model->get_all_komisi_by_status($status); // Perlu buat fungsi ini di Model
            $data['title'] = 'Daftar Komisi Status: ' . ucfirst($status);
        } else {
            $data['komisi_list'] = $this->Komisi_model->get_all_komisi(); // Ambil semua
        }

        $this->load->view('layout/v_header', $data);
        $this->load->view('transaksi/komisi/v_admin_list', $data); // Buat view ini
        $this->load->view('layout/v_footer');
    }
}