<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Metode_bayar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // --- BATASAN AKSES: Hanya untuk Admin ---
        if ($this->session->userdata('logged_in') != TRUE || $this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak. Hanya Admin/Artist yang dapat mengelola Data Master.');
            redirect('dashboard'); 
        }
        // --- END BATASAN AKSES ---

        $this->load->model('Metode_bayar_model'); 
        $this->load->library('form_validation');
    }

    // Fungsi READ: Menampilkan semua data
    public function index() {
        $data['title'] = 'Data Master Metode Pembayaran';
        $data['metode_bayar'] = $this->Metode_bayar_model->get_all_metode();
        
        $this->load->view('layout/v_header', $data);
        $this->load->view('master/metode_bayar/v_list', $data); 
        $this->load->view('layout/v_footer');
    }

    // Fungsi CREATE/UPDATE: Form Tambah/Edit
    public function form($id_bayar = null) {
        if ($id_bayar) {
            $data['title'] = 'Edit Metode Pembayaran';
            $data['metode'] = $this->Metode_bayar_model->get_metode_by_id($id_bayar);
            if (!$data['metode']) { show_404(); }
        } else {
            $data['title'] = 'Tambah Metode Pembayaran Baru';
            $data['metode'] = (object) array('nama_metode' => '', 'atas_nama' => '', 'nomor_rekening' => '');
        }

        $this->load->view('layout/v_header', $data);
        $this->load->view('master/metode_bayar/v_form', $data);
        $this->load->view('layout/v_footer');
    }

    // Fungsi CREATE/UPDATE: Proses Simpan
    public function simpan() {
        $this->form_validation->set_rules('nama_metode', 'Nama Metode', 'required|trim');
        $this->form_validation->set_rules('atas_nama', 'Atas Nama', 'required|trim');
        $this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'required|trim');
        
        $id_bayar = $this->input->post('id_bayar');

        if ($this->form_validation->run() == FALSE) {
            $this->form($id_bayar); 
        } else {
            $data = array(
                'nama_metode'    => $this->input->post('nama_metode'),
                'atas_nama'      => $this->input->post('atas_nama'),
                'nomor_rekening' => $this->input->post('nomor_rekening')
            );

            if ($id_bayar) {
                $this->Metode_bayar_model->update_metode($id_bayar, $data);
                $this->session->set_flashdata('success', 'Metode Pembayaran berhasil diperbarui.');
            } else {
                $this->Metode_bayar_model->insert_metode($data);
                $this->session->set_flashdata('success', 'Metode Pembayaran baru berhasil ditambahkan.');
            }
            redirect('metode_bayar');
        }
    }

    // Fungsi DELETE
    public function hapus($id_bayar) {
        // ... (Logika hapus, sama seperti controller sebelumnya)
        if ($this->Metode_bayar_model->delete_metode($id_bayar)) {
            $this->session->set_flashdata('success', 'Metode Pembayaran berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }
        redirect('metode_bayar');
    }
}