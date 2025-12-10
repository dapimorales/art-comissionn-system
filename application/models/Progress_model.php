<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progress_model extends CI_Model {

    // Menyimpan riwayat progres pengerjaan (oleh Admin/Artist)
    public function insert_progress($data) {
        // Data harus berisi: id_komisi, id_tahap, catatan_artist, file_preview
        return $this->db->insert('riwayat_progress', $data);
    }
    
    // Mengambil semua riwayat progres untuk komisi tertentu (untuk dilihat Klien & Admin)
    public function get_progress_by_komisi($id_komisi) {
        $this->db->select('rp.*, tp.nama_tahap');
        $this->db->from('riwayat_progress rp');
        $this->db->join('tahapan_proyek tp', 'tp.id_tahap = rp.id_tahap');
        $this->db->where('rp.id_komisi', $id_komisi);
        $this->db->order_by('rp.tanggal_update', 'DESC');
        return $this->db->get()->result();
    }

    // Mengupdate status komisi utama (digunakan saat progres selesai)
    public function update_status_komisi($id_komisi, $status) {
        $this->db->where('id_komisi', $id_komisi);
        return $this->db->update('komisi', ['status_komisi' => $status]);
    }

    // Menyimpan feedback/revisi dari Klien
    public function insert_feedback($data) {
        // Data harus berisi: id_komisi, catatan_klien
        return $this->db->insert('feedback_revisi', $data);
    }

    // Mengambil semua feedback untuk komisi tertentu
    public function get_feedback_by_komisi($id_komisi) {
        $this->db->where('id_komisi', $id_komisi);
        $this->db->order_by('tanggal_feedback', 'DESC');
        return $this->db->get('feedback_revisi')->result();
    }
}