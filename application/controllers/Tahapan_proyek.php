<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahapan_proyek extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // --- BATASAN AKSES: Hanya untuk Admin ---
        if ($this->session->userdata('logged_in') != TRUE || $this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak. Hanya Admin/Artist yang dapat mengelola Data Master.');
            redirect('dashboard'); 
        }
        // --- END BATASAN AKSES ---

        $this->load->model('Tahapan_proyek_model'); 
        $this->load->library('form_validation');
    }

    // Fungsi READ: Menampilkan semua data tahapan
    // application/controllers/Tahapan_proyek.php

// ... (di dalam class Tahapan_proyek)

    // Fungsi READ: Menampilkan semua data tahapan
    public function index() {
        $data['title'] = 'Data Master Tahapan Proyek';
        
        // FIX: Pastikan data yang dikembalikan adalah array, bukan object null
        $tahapan_data = $this->Tahapan_proyek_model->get_all_tahapan();
        
        // FIX BARU: Jika data tidak ditemukan (null), set sebagai array kosong.
        // Ini MENCEGAH WARNING PHP di view saat data kosong.
        if ($tahapan_data === NULL) {
             $data['tahapan_proyek'] = array();
        } else {
             $data['tahapan_proyek'] = $tahapan_data;
        }
        
        $this->load->view('layout/v_header', $data);
        $this->load->view('master/tahapan_proyek/v_list', $data); 
        $this->load->view('layout/v_footer');
    }

// ...
    // Fungsi CREATE/UPDATE: Form Tambah/Edit
    public function form($id_tahap = null) { // FIX: Menggunakan id_tahap
        if ($id_tahap) {
            $data['title'] = 'Edit Tahapan Proyek';
            $data['tahapan'] = $this->Tahapan_proyek_model->get_tahapan_by_id($id_tahap);
            if (!$data['tahapan']) { show_404(); }
        } else {
            $data['title'] = 'Tambah Tahapan Proyek Baru';
            $data['tahapan'] = (object) array('nama_tahapan' => '', 'deskripsi' => '', 'urutan' => '');
        }

        $this->load->view('layout/v_header', $data);
        $this->load->view('master/tahapan_proyek/v_form', $data);
        $this->load->view('layout/v_footer');
    }

    // Fungsi CREATE/UPDATE: Proses Simpan
    public function simpan() {
        $this->form_validation->set_rules('nama_tahapan', 'Nama Tahapan', 'required|trim');
        $this->form_validation->set_rules('urutan', 'Urutan', 'required|numeric'); 
        
        $id_tahap = $this->input->post('id_tahap'); // FIX: Mengambil id_tahap

        if ($this->form_validation->run() == FALSE) {
            $this->form($id_tahap); 
        } else {
            $data = array(
                'nama_tahapan' => $this->input->post('nama_tahapan'),
                'deskripsi'    => $this->input->post('deskripsi'),
                'urutan'       => $this->input->post('urutan')
            );

            if ($id_tahap) {
                // Proses Update
                $this->Tahapan_proyek_model->update_tahapan($id_tahap, $data);
                $this->session->set_flashdata('success', 'Tahapan Proyek berhasil diperbarui.');
            } else {
                // Proses Insert
                $this->Tahapan_proyek_model->insert_tahapan($data);
                $this->session->set_flashdata('success', 'Tahapan Proyek baru berhasil ditambahkan.');
            }
            redirect('tahapan_proyek');
        }
    }

    // Fungsi DELETE
    public function hapus($id_tahap) { // FIX: Menggunakan id_tahap
        if ($this->Tahapan_proyek_model->delete_tahapan($id_tahap)) {
            $this->session->set_flashdata('success', 'Tahapan Proyek berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }
        redirect('tahapan_proyek');
    }
}