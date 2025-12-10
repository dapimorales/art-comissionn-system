<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaya_seni_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'gaya_seni';
    }

    /**
     * READ: Mengambil semua data gaya seni
     */
    public function get_all_gaya() {
        // SELECT * FROM gaya_seni ORDER BY id_gaya DESC
        $this->db->order_by('id_gaya', 'DESC');
        return $this->db->get($this->table)->result(); // Mengembalikan array of objects
    }

    /**
     * READ: Mengambil data gaya seni berdasarkan ID
     */
    public function get_gaya_by_id($id_gaya) {
        // SELECT * FROM gaya_seni WHERE id_gaya = $id_gaya LIMIT 1
        $this->db->where('id_gaya', $id_gaya);
        return $this->db->get($this->table, 1)->row(); // Mengembalikan satu objek
    }

    /**
     * CREATE: Menyimpan data gaya seni baru
     */
    public function insert_gaya($data) {
        // INSERT INTO gaya_seni (...) VALUES (...)
        return $this->db->insert($this->table, $data);
    }

    /**
     * UPDATE: Memperbarui data gaya seni
     */
    public function update_gaya($id_gaya, $data) {
        // UPDATE gaya_seni SET ... WHERE id_gaya = $id_gaya
        $this->db->where('id_gaya', $id_gaya);
        return $this->db->update($this->table, $data);
    }

    /**
     * DELETE: Menghapus data gaya seni
     */
    public function delete_gaya($id_gaya) {
        // DELETE FROM gaya_seni WHERE id_gaya = $id_gaya
        $this->db->where('id_gaya', $id_gaya);
        return $this->db->delete($this->table);
    }

}