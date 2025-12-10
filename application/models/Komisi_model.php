<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komisi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'komisi';
    }

    /**
     * CREATE: Menyimpan data permintaan komisi baru
     */
    public function insert_komisi($data) {
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * READ: Mengambil daftar komisi milik klien tertentu
     * Digunakan di Dashboard Klien
     */
    public function get_komisi_by_klien($id_klien) {
        // Gabungkan data komisi dengan nama Gaya dan Tipe
        $this->db->select('k.*, gs.nama_gaya, tk.nama_tipe');
        $this->db->from('komisi k');
        $this->db->join('gaya_seni gs', 'gs.id_gaya = k.id_gaya');
        $this->db->join('tipe_komisi tk', 'tk.id_tipe = k.id_tipe');
        $this->db->where('k.id_klien', $id_klien);
        $this->db->order_by('k.tanggal_request', 'DESC');
        return $this->db->get()->result();
    }
    
    /**
     * READ: Mengambil semua komisi untuk Admin
     */
    public function get_all_komisi() {
        // Gabungkan data komisi dengan nama Klien, Gaya, dan Tipe
        $this->db->select('k.*, u.nama as nama_klien, gs.nama_gaya, tk.nama_tipe');
        $this->db->from('komisi k');
        $this->db->join('users u', 'u.id_user = k.id_klien');
        $this->db->join('gaya_seni gs', 'gs.id_gaya = k.id_gaya');
        $this->db->join('tipe_komisi tk', 'tk.id_tipe = k.id_tipe');
        $this->db->order_by('k.tanggal_request', 'DESC');
        return $this->db->get()->result();
    }
    
    // Fungsi untuk mendapatkan data gaya dan tipe untuk kalkulasi
    public function get_harga_komponen($id_gaya, $id_tipe) {
        $gaya = $this->db->get_where('gaya_seni', ['id_gaya' => $id_gaya])->row();
        $tipe = $this->db->get_where('tipe_komisi', ['id_tipe' => $id_tipe])->row();
        
        if ($gaya && $tipe) {
            return [
                'harga_dasar' => $gaya->harga_dasar,
                'biaya_tambahan' => $tipe->biaya_tambahan
            ];
        }
        return null;
    }

    // application/models/Komisi_model.php

// ... (fungsi lainnya)

/**
 * Statistik Komisi berdasarkan status (Untuk Admin)
 */
    public function count_komisi_status() {
        return $this->db->select('status_komisi, COUNT(*) as total')
                        ->group_by('status_komisi')
                        ->get($this->table)
                        ->result();
    }

    /**
     * Statistik Komisi milik klien tertentu (Untuk Klien)
     */
    public function count_komisi_status_by_klien($id_klien) {
        return $this->db->select('status_komisi, COUNT(*) as total')
                        ->where('id_klien', $id_klien)
                        ->group_by('status_komisi')
                        ->get($this->table)
                        ->result();
    }

        // application/models/Komisi_model.php

    // ... (di dalam class Komisi_model extends CI_Model)

    // Fungsi untuk mendapatkan semua komisi berdasarkan status
    public function get_all_komisi_by_status($status) {
        $this->db->select('k.*, u.nama as nama_klien, gs.nama_gaya, tk.nama_tipe');
        $this->db->from('komisi k');
        $this->db->join('users u', 'u.id_user = k.id_klien');
        $this->db->join('gaya_seni gs', 'gs.id_gaya = k.id_gaya');
        $this->db->join('tipe_komisi tk', 'tk.id_tipe = k.id_tipe');
        $this->db->where('k.status_komisi', $status);
        $this->db->order_by('k.tanggal_request', 'DESC');
        return $this->db->get()->result();
    }

    // Fungsi untuk menghitung pembayaran pending (untuk Dashboard Admin)
    public function count_pembayaran_pending() {
        return $this->db->where('status_verifikasi', 'Menunggu')
                        ->from('transaksi_pembayaran')
                        ->count_all_results();
    }

    // Fungsi untuk detail komisi dengan join (Diperlukan di Progress/detail)
    public function get_komisi_detail_by_id($id_komisi) {
        $this->db->select('k.*, u.nama as nama_klien, gs.nama_gaya, tk.nama_tipe');
        $this->db->from('komisi k');
        $this->db->join('users u', 'u.id_user = k.id_klien');
        $this->db->join('gaya_seni gs', 'gs.id_gaya = k.id_gaya');
        $this->db->join('tipe_komisi tk', 'tk.id_tipe = k.id_tipe');
        $this->db->where('k.id_komisi', $id_komisi);
        return $this->db->get()->row();
    }
    // Anda bisa tambahkan get_komisi_detail_by_id() di sini jika diperlukan
}