<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Metode_bayar_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'metode_bayar';
    }

    /**
     * READ: Mengambil semua data metode pembayaran
     */
    public function get_all_metode() {
        $this->db->order_by('id_bayar', 'DESC');
        return $this->db->get($this->table)->result();
    }

    /**
     * READ: Mengambil data berdasarkan ID
     */
    public function get_metode_by_id($id_bayar) {
        $this->db->where('id_bayar', $id_bayar);
        return $this->db->get($this->table, 1)->row();
    }

    /**
     * CREATE: Menyimpan data metode pembayaran baru
     */
    public function insert_metode($data) {
        return $this->db->insert($this->table, $data);
    }

    /**
     * UPDATE: Memperbarui data
     */
    public function update_metode($id_bayar, $data) {
        $this->db->where('id_bayar', $id_bayar);
        return $this->db->update($this->table, $data);
    }

    /**
     * DELETE: Menghapus data
     */
    public function delete_metode($id_bayar) {
        $this->db->where('id_bayar', $id_bayar);
        return $this->db->delete($this->table);
    }
}