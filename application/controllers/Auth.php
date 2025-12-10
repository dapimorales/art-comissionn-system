<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// application/controllers/Auth.php

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model Users_model
        $this->load->model('Users_model'); 
        
        // Library form_validation dimuat di awal
        $this->load->library('form_validation'); 
        
        // Memuat helper form (diperlukan untuk set_value(), meskipun lebih baik di autoload.php)
        $this->load->helper('form'); 
    }
    
    public function login() {
        // Tampilkan halaman login form
        $this->load->view('v_login'); 
    }

    public function proses_login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // 1. Cek User di Database
        $user = $this->Users_model->get_user_by_email($email);

        if ($user) {
            // 2. Verifikasi Password (asumsi password di-hash)
            if (password_verify($password, $user->password)) { 
                
                // 3. Buat Session Data
                $session_data = array(
                    'id_user'   => $user->id_user,
                    'nama'      => $user->nama,
                    'email'     => $user->email,
                    'role'      => $user->role,
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($session_data);

                // 4. Redirect ke Dashboard
                redirect('dashboard'); 

            } else {
                $this->session->set_flashdata('error', 'Email atau password salah.');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('error', 'Email tidak terdaftar.');
            redirect('auth/login');
        }
    }

    public function register() {
        // Tampilkan view form pendaftaran klien
        $this->load->view('v_register'); 
    }

    public function proses_register() {
        // 1. Atur aturan validasi
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            
            // JIKA VALIDASI GAGAL, KEMBALI KE FORM REGISTER
            $this->load->view('v_register'); // Tidak perlu load helper form lagi karena sudah di constructor/autoload
            
        } else {
            // --- LOGIKA PENYIMPANAN DATA (FIX) ---
            
            // 1. Hashing Password
            $password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            
            // 2. Siapkan Data
            $data = array(
                'nama'      => $this->input->post('nama'),
                'email'     => $this->input->post('email'),
                'password'  => $password_hash,
                'role'      => 'klien' // Role default untuk pendaftaran
            );

            // 3. Simpan ke database melalui model
            if ($this->Users_model->register_klien($data)) {
                
                // JIKA BERHASIL: Redirect ke login
                $this->session->set_flashdata('success', 'Pendaftaran berhasil! Silakan login.');
                redirect('auth/login'); 

            } else {
                
                // JIKA GAGAL: Redirect ke register dengan pesan error
                $this->session->set_flashdata('error', 'Gagal mendaftar. Terjadi kesalahan pada database (Mungkin kolom password terlalu pendek atau masalah server).');
                redirect('auth/register');
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}