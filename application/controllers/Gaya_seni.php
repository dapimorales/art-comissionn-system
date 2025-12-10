<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaya_seni extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // --- BATASAN AKSES: Hanya untuk Admin ---
        if ($this->session->userdata('logged_in') != TRUE || $this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak. Hanya Admin/Artist yang dapat mengelola Data Master.');
            redirect('dashboard'); 
        }
        // --- END BATASAN AKSES ---

        $this->load->model('Gaya_seni_model'); 
        $this->load->library('form_validation'); // Untuk validasi input
    }

    // Fungsi READ: Menampilkan semua data gaya seni
    public function index() {
        $data['title'] = 'Data Master Gaya Seni';
        $data['gaya_seni'] = $this->Gaya_seni_model->get_all_gaya();
        
        $this->load->view('layout/v_header', $data);
        $this->load->view('master/gaya_seni/v_list', $data); // Tampilkan daftar
        $this->load->view('layout/v_footer');
    }

    // Fungsi CREATE/UPDATE: Form Tambah/Edit
    public function form($id_gaya = null) {
        if ($id_gaya) {
            $data['title'] = 'Edit Gaya Seni';
            $data['gaya'] = $this->Gaya_seni_model->get_gaya_by_id($id_gaya);
            if (!$data['gaya']) {
                show_404();
            }
        } else {
            $data['title'] = 'Tambah Gaya Seni Baru';
            $data['gaya'] = (object) array('nama_gaya' => '', 'deskripsi' => '', 'harga_dasar' => '');
        }

        $this->load->view('layout/v_header', $data);
        $this->load->view('master/gaya_seni/v_form', $data); // Tampilkan form
        $this->load->view('layout/v_footer');
    }

    // Fungsi CREATE/UPDATE: Proses Simpan
    public function simpan() {
        // 1. Atur aturan validasi
        $this->form_validation->set_rules('nama_gaya', 'Nama Gaya', 'required|trim');
        $this->form_validation->set_rules('harga_dasar', 'Harga Dasar', 'required|numeric');
        
        $id_gaya = $this->input->post('id_gaya'); // Hidden field untuk menentukan apakah ini Edit

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke form
            $this->form($id_gaya); 
        } else {
            $data = array(
                'nama_gaya'     => $this->input->post('nama_gaya'),
                'deskripsi'     => $this->input->post('deskripsi'),
                'harga_dasar'   => $this->input->post('harga_dasar')
            );

            if ($id_gaya) {
                // Proses Update
                $this->Gaya_seni_model->update_gaya($id_gaya, $data);
                $this->session->set_flashdata('success', 'Data Gaya Seni berhasil diperbarui.');
            } else {
                // Proses Insert (Tambah Baru)
                $this->Gaya_seni_model->insert_gaya($data);
                $this->session->set_flashdata('success', 'Data Gaya Seni baru berhasil ditambahkan.');
            }
            redirect('gaya_seni');
        }
    }

    // Fungsi DELETE
    public function hapus($id_gaya) {
        if ($this->Gaya_seni_model->delete_gaya($id_gaya)) {
            $this->session->set_flashdata('success', 'Data Gaya Seni berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }
        redirect('gaya_seni');
    }
}