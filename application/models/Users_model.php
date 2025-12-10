<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    // Konstruktor
    public function __construct() {
        parent::__construct();
        // Nama tabel users
        $this->table = 'users'; 
    }

    /**
     * Fungsi untuk mengambil data pengguna berdasarkan email
     * Digunakan pada proses login untuk verifikasi
     */
    public function get_user_by_email($email) {
        // Melakukan SELECT * FROM users WHERE email = $email LIMIT 1
        $this->db->where('email', $email);
        $query = $this->db->get($this->table, 1);
        return $query->row(); // Mengembalikan satu baris objek
    }

    /**
     * Fungsi untuk mendaftarkan user baru (Klien)
     */
    public function register_klien($data) {
        // Data harus sudah berisi: nama, email, password (sudah di-hash), dan role='klien'
        // Melakukan INSERT INTO users (...) VALUES (...)
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * Fungsi untuk mendapatkan data user berdasarkan ID
     * Berguna di dashboard atau profil user
     */
    public function get_user_by_id($id_user) {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get($this->table, 1);
        return $query->row();
    }

    // Anda bisa menambahkan fungsi CRUD user lainnya di sini
}