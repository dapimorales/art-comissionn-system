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
    public function index() {
        $data['title'] = 'Data Master Tahapan Proyek';
        $data['tahapan_proyek'] = $this->Tahapan_proyek_model->get_all_tahapan();
        
        $this->load->view('layout/v_header', $data);
        $this->load->view('master/tahapan_proyek/v_list', $data); 
        $this->load->view('layout/v_footer');
    }

    // Fungsi CREATE/UPDATE: Form Tambah/Edit
    public function form($id_tahapan = null) {
        if ($id_tahapan) {
            $data['title'] = 'Edit Tahapan Proyek';
            $data['tahapan'] = $this->Tahapan_proyek_model->get_tahapan_by_id($id_tahapan);
            if (!$data['tahapan']) { show_404(); }
        } else {
            $data['title'] = 'Tambah Tahapan Proyek Baru';
            // Default object untuk form kosong
            $data['tahapan'] = (object) array('nama_tahapan' => '', 'deskripsi' => '', 'urutan' => '');
        }

        $this->load->view('layout/v_header', $data);
        $this->load->view('master/tahapan_proyek/v_form', $data);
        $this->load->view('layout/v_footer');
    }

    // Fungsi CREATE/UPDATE: Proses Simpan
    public function simpan() {
        $this->form_validation->set_rules('nama_tahapan', 'Nama Tahapan', 'required|trim');
        $this->form_validation->set_rules('urutan', 'Urutan', 'required|numeric|is_unique[tahapan_proyek.urutan]'); // Urutan harus unik
        
        $id_tahapan = $this->input->post('id_tahapan');

        if ($this->form_validation->run() == FALSE) {
            $this->form($id_tahapan); 
        } else {
            $data = array(
                'nama_tahapan' => $this->input->post('nama_tahapan'),
                'deskripsi'    => $this->input->post('deskripsi'),
                'urutan'       => $this->input->post('urutan')
            );

            if ($id_tahapan) {
                // Proses Update
                $this->Tahapan_proyek_model->update_tahapan($id_tahapan, $data);
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
    public function hapus($id_tahapan) {
        if ($this->Tahapan_proyek_model->delete_tahapan($id_tahapan)) {
            $this->session->set_flashdata('success', 'Tahapan Proyek berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }
        redirect('tahapan_proyek');
    }
}