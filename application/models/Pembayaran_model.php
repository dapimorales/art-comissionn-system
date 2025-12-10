<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'transaksi_pembayaran';
    }

    /**
     * CREATE: Menyimpan bukti pembayaran dan mengupdate status komisi
     */
    public function insert_pembayaran($data, $id_komisi) {
        // Mulai transaksi database
        $this->db->trans_start();
        
        // 1. Simpan data pembayaran ke transaksi_pembayaran
        $this->db->insert($this->table, $data);
        
        // 2. Update status komisi menjadi 'Menunggu Verifikasi'
        $this->db->where('id_komisi', $id_komisi);
        $this->db->update('komisi', ['status_komisi' => 'Menunggu Verifikasi']);
        
        // Selesai transaksi
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    /**
     * READ: Menghitung total pembayaran yang statusnya 'Menunggu' verifikasi
     * Digunakan untuk Dashboard Admin
     */
    public function count_pembayaran_pending() {
        // FIX: Mengganti kolom 'status_verifikasi' menjadi 'status_pembayaran' 
        //      dan nilai 'Menunggu' menjadi 'Menunggu Verifikasi'
        $this->db->where('status_pembayaran', 'Menunggu Verifikasi');
        return $this->db->from($this->table)->count_all_results();
    }
    
    // Anda mungkin juga perlu menambahkan fungsi get_pembayaran_pending_for_admin
    // di sini jika Anda memindahkannya dari controller Pembayaran.php

}