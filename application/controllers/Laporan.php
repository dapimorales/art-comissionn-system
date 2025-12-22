<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Proteksi: Hanya Admin yang bisa akses
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak!');
            redirect('dashboard');
        }
        $this->load->model('Komisi_model');
    }

    // Tampilan Laporan Utama
    public function index() {
        $data['title'] = 'Laporan Transaksi Art Commission';
        
        // 1. Ambil semua data komisi
        $data['laporan'] = $this->Komisi_model->get_all_komisi();
        
        // 2. Hitung Total Pendapatan (Hanya yang statusnya Completed)
        $this->db->select_sum('total_harga');
        $this->db->where('status_komisi', 'Completed');
        $query = $this->db->get('komisi');
        $result = $query->row();
        $data['total_pendapatan'] = $result->total_harga ?? 0;

        // 3. Load View dengan folder yang disederhanakan
        $this->load->view('layout/v_header', $data);
        $this->load->view('laporan/v_index', $data); // Folder views/laporan/v_index.php
        $this->load->view('layout/v_footer');
    }

    // Fitur Export Excel (Tanpa Library Berat)
    // Fungsi ini hanya sebagai trigger jika diperlukan redirect, 
    // karena ekspor sebenarnya sudah kita tangani via JavaScript di View agar cepat.
    public function export_excel() {
        $this->index(); 
    }

    // Fitur Export PDF 
    // Kita gunakan window.print() di browser via View agar tampilan 
    // identik dengan apa yang Anda lihat di layar (What You See Is What You Get).
    public function export_pdf() {
        $this->index();
    }
}