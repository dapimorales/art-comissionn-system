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

   public function index() {
    $data['title'] = 'Laporan Transaksi Art Commission';
    
    // Ambil filter dari URL
    $tgl_awal = $this->input->get('tgl_awal');
    $tgl_akhir = $this->input->get('tgl_akhir');
    $status_filter = $this->input->get('status');

    // --- 1. DATA KHUSUS SELESAI (UNTUK TABEL ATAS) ---
    $this->db->select('komisi.*, users.nama as nama_klien, gaya_seni.nama_gaya, tipe_komisi.nama_tipe');
    $this->db->from('komisi');
    $this->db->join('users', 'komisi.id_klien = users.id_user');
    $this->db->join('gaya_seni', 'komisi.id_gaya = gaya_seni.id_gaya');
    $this->db->join('tipe_komisi', 'komisi.id_tipe = tipe_komisi.id_tipe');
    
    // KUNCI: Paksa hanya status Completed yang masuk ke sini agar tidak campur
    $this->db->where('komisi.status_komisi', 'Completed');

    if ($tgl_awal && $tgl_akhir) {
        $this->db->where('DATE(tanggal_request) >=', $tgl_awal);
        $this->db->where('DATE(tanggal_request) <=', $tgl_akhir);
    }
    
    $this->db->order_by('tanggal_request', 'DESC');
    // VARIABEL INI HARUS SAMA DENGAN DI VIEW
    $data['laporan_selesai'] = $this->db->get()->result();


    // --- 2. DATA KHUSUS ANTREAN (UNTUK TABEL BAWAH) ---
    $this->db->select('komisi.*, users.nama as nama_klien, gaya_seni.nama_gaya, tipe_komisi.nama_tipe');
    $this->db->from('komisi');
    $this->db->join('users', 'komisi.id_klien = users.id_user');
    $this->db->join('gaya_seni', 'komisi.id_gaya = gaya_seni.id_gaya');
    $this->db->join('tipe_komisi', 'komisi.id_tipe = tipe_komisi.id_tipe');
    
    // Logika Filter Status untuk Antrean
    if ($status_filter && $status_filter != 'Completed') {
        $this->db->where('komisi.status_komisi', $status_filter);
    } else {
        $this->db->where_in('komisi.status_komisi', ['Pending', 'In Progress']);
    }

    $this->db->order_by('tanggal_request', 'ASC');
    $data['laporan_antrean'] = $this->db->get()->result();


    // --- 3. HITUNG TOTAL PENDAPATAN ---
    if ($status_filter && $status_filter != 'Completed') {
        $data['total_pendapatan'] = 0;
    } else {
        $this->db->select_sum('total_harga');
        $this->db->where('status_komisi', 'Completed');
        if ($tgl_awal && $tgl_akhir) {
            $this->db->where('DATE(tanggal_request) >=', $tgl_awal);
            $this->db->where('DATE(tanggal_request) <=', $tgl_akhir);
        }
        $query = $this->db->get('komisi');
        $data['total_pendapatan'] = $query->row()->total_harga ?? 0;
    }

    $this->load->view('layout/v_header', $data);
    $this->load->view('laporan/v_index', $data); 
    $this->load->view('layout/v_footer');
}

    public function export_excel() {
        $this->index(); 
    }

    public function export_pdf() {
        $this->index();
    }
}