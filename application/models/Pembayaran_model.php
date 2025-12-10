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
    
    // ... (Fungsi untuk Admin: verifikasi, list transaksi)
}