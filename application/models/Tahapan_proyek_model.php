<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahapan_proyek_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'tahapan_proyek';
    }

    /**
     * READ: Mengambil semua data tahapan proyek
     */
    public function get_all_tahapan() {
        // SELECT * FROM tahapan_proyek ORDER BY urutan ASC
        $this->db->order_by('urutan', 'ASC'); 
        return $this->db->get($this->table)->result();
    }

    /**
     * READ: Mengambil data berdasarkan ID
     */
    // FIX: Menggunakan $id_tahap sebagai parameter
    public function get_tahapan_by_id($id_tahap) { 
        // FIX: Mengganti kolom 'id_tahapan' menjadi 'id_tahap'
        $this->db->where('id_tahap', $id_tahap); 
        return $this->db->get($this->table, 1)->row();
    }

    /**
     * CREATE: Menyimpan data tahapan proyek baru
     */
    public function insert_tahapan($data) {
        return $this->db->insert($this->table, $data);
    }

    /**
     * UPDATE: Memperbarui data
     */
    // FIX: Menggunakan $id_tahap sebagai parameter
    public function update_tahapan($id_tahap, $data) {
        // FIX: Mengganti kolom 'id_tahapan' menjadi 'id_tahap'
        $this->db->where('id_tahap', $id_tahap); 
        return $this->db->update($this->table, $data);
    }

    /**
     * DELETE: Menghapus data
     */
    // FIX: Menggunakan $id_tahap sebagai parameter
    public function delete_tahapan($id_tahap) {
        // FIX: Mengganti kolom 'id_tahapan' menjadi 'id_tahap'
        $this->db->where('id_tahap', $id_tahap); 
        return $this->db->delete($this->table);
    }
}