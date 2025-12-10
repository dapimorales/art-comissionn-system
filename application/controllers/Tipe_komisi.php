<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipe_komisi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // --- BATASAN AKSES: Hanya untuk Admin ---
        if ($this->session->userdata('logged_in') != TRUE || $this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak. Hanya Admin/Artist yang dapat mengelola Data Master.');
            redirect('dashboard'); 
        }
        // --- END BATASAN AKSES ---

        $this->load->model('Tipe_komisi_model'); 
        $this->load->library('form_validation');
    }

    // Fungsi READ: Menampilkan semua data tipe komisi
    public function index() {
        $data['title'] = 'Data Master Tipe Komisi';
        $data['tipe_komisi'] = $this->Tipe_komisi_model->get_all_tipe();
        
        $this->load->view('layout/v_header', $data);
        $this->load->view('master/tipe_komisi/v_list', $data); 
        $this->load->view('layout/v_footer');
    }

    // Fungsi CREATE/UPDATE: Form Tambah/Edit
    public function form($id_tipe = null) {
        if ($id_tipe) {
            $data['title'] = 'Edit Tipe Komisi';
            $data['tipe'] = $this->Tipe_komisi_model->get_tipe_by_id($id_tipe);
            if (!$data['tipe']) {
                show_404();
            }
        } else {
            $data['title'] = 'Tambah Tipe Komisi Baru';
            $data['tipe'] = (object) array('nama_tipe' => '', 'deskripsi' => '', 'biaya_tambahan' => '');
        }

        $this->load->view('layout/v_header', $data);
        $this->load->view('master/tipe_komisi/v_form', $data);
        $this->load->view('layout/v_footer');
    }

    // Fungsi CREATE/UPDATE: Proses Simpan
    public function simpan() {
        // 1. Atur aturan validasi
        $this->form_validation->set_rules('nama_tipe', 'Nama Tipe', 'required|trim');
        $this->form_validation->set_rules('biaya_tambahan', 'Biaya Tambahan', 'required|numeric');
        
        $id_tipe = $this->input->post('id_tipe'); 

        if ($this->form_validation->run() == FALSE) {
            $this->form($id_tipe); 
        } else {
            $data = array(
                'nama_tipe'         => $this->input->post('nama_tipe'),
                'deskripsi'         => $this->input->post('deskripsi'),
                'biaya_tambahan'    => $this->input->post('biaya_tambahan')
            );

            if ($id_tipe) {
                // Proses Update
                $this->Tipe_komisi_model->update_tipe($id_tipe, $data);
                $this->session->set_flashdata('success', 'Data Tipe Komisi berhasil diperbarui.');
            } else {
                // Proses Insert
                $this->Tipe_komisi_model->insert_tipe($data);
                $this->session->set_flashdata('success', 'Data Tipe Komisi baru berhasil ditambahkan.');
            }
            redirect('tipe_komisi');
        }
    }

    // Fungsi DELETE
    public function hapus($id_tipe) {
        if ($this->Tipe_komisi_model->delete_tipe($id_tipe)) {
            $this->session->set_flashdata('success', 'Data Tipe Komisi berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }
        redirect('tipe_komisi');
    }
}