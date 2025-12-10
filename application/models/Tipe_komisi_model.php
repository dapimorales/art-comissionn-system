<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipe_komisi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'tipe_komisi';
    }

    /**
     * READ: Mengambil semua data tipe komisi
     */
    public function get_all_tipe() {
        // SELECT * FROM tipe_komisi ORDER BY id_tipe DESC
        $this->db->order_by('id_tipe', 'DESC');
        return $this->db->get($this->table)->result();
    }

    /**
     * READ: Mengambil data tipe komisi berdasarkan ID
     */
    public function get_tipe_by_id($id_tipe) {
        // SELECT * FROM tipe_komisi WHERE id_tipe = $id_tipe LIMIT 1
        $this->db->where('id_tipe', $id_tipe);
        return $this->db->get($this->table, 1)->row();
    }

    /**
     * CREATE: Menyimpan data tipe komisi baru
     */
    public function insert_tipe($data) {
        // INSERT INTO tipe_komisi (...) VALUES (...)
        return $this->db->insert($this->table, $data);
    }

    /**
     * UPDATE: Memperbarui data tipe komisi
     */
    public function update_tipe($id_tipe, $data) {
        // UPDATE tipe_komisi SET ... WHERE id_tipe = $id_tipe
        $this->db->where('id_tipe', $id_tipe);
        return $this->db->update($this->table, $data);
    }

    /**
     * DELETE: Menghapus data tipe komisi
     */
    public function delete_tipe($id_tipe) {
        // DELETE FROM tipe_komisi WHERE id_tipe = $id_tipe
        $this->db->where('id_tipe', $id_tipe);
        return $this->db->delete($this->table);
    }

}