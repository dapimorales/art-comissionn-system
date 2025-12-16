<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Hanya yang sudah login yang bisa mengakses
        if ($this->session->userdata('logged_in') != TRUE) {
            redirect('auth/login');
        }

        $this->load->model('Pembayaran_model');
        $this->load->model('Metode_bayar_model');
        $this->load->model('Komisi_model');
        $this->load->library('form_validation');
    }

    // =========================
    // FORM PEMBAYARAN KLIEN
    // =========================
    public function form($id_komisi) {
        $komisi = $this->Komisi_model->get_komisi_by_klien(
            $this->session->userdata('id_user')
        );

        $detail_komisi = array_filter($komisi, function($k) use ($id_komisi) {
            return $k->id_komisi == $id_komisi;
        });
        $detail_komisi = reset($detail_komisi);

        if (!$detail_komisi || $detail_komisi->status_komisi != 'Pending') {
            $this->session->set_flashdata(
                'error',
                'Pesanan tidak ditemukan atau statusnya sudah tidak Pending.'
            );
            redirect('komisi');
        }

        $data['title'] = 'Konfirmasi Pembayaran Komisi #' . $id_komisi;
        $data['komisi'] = $detail_komisi;
        $data['metode_bayar'] = $this->Metode_bayar_model->get_all_metode();

        $this->load->view('layout/v_header', $data);
        $this->load->view('transaksi/pembayaran/v_form', $data);
        $this->load->view('layout/v_footer');
    }

    // =========================
    // PROSES KONFIRMASI KLIEN
    // =========================
    public function proses_konfirmasi() {
        $this->form_validation->set_rules(
            'id_metode_bayar',
            'Metode Pembayaran',
            'required'
        );

        $id_komisi = $this->input->post('id_komisi');

        if ($this->form_validation->run() == FALSE) {
            $this->form($id_komisi);
        } else {

            $data_pembayaran = [
                'id_komisi'         => $id_komisi,
                'id_metode_bayar'   => $this->input->post('id_metode_bayar'),
                'jumlah_bayar'      => $this->input->post('jumlah_bayar'),
                'tanggal_bayar'     => $this->input->post('tanggal_bayar'),
                'status_pembayaran' => 'Menunggu Verifikasi',
                'bukti_bayar'       => 'N/A'
            ];

            if ($this->Pembayaran_model
                ->insert_pembayaran($data_pembayaran, $id_komisi)) {

                $this->session->set_flashdata(
                    'success',
                    'Konfirmasi pembayaran berhasil. Menunggu verifikasi admin.'
                );
            } else {
                $this->session->set_flashdata(
                    'error',
                    'Gagal memproses pembayaran, coba lagi.'
                );
            }

            redirect('komisi');
        }
    }

    // =========================
    // ADMIN - LIST VERIFIKASI
    // =========================
    public function verifikasi_list() {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata(
                'error',
                'Akses Admin diperlukan.'
            );
            redirect('dashboard');
        }

        $data['title'] = 'Verifikasi Pembayaran Masuk';
        $data['pembayaran'] = $this->get_pembayaran_pending_for_admin();

        $this->load->view('layout/v_header', $data);
        $this->load->view('transaksi/pembayaran/v_admin_list', $data);
        $this->load->view('layout/v_footer');
    }

    // =========================
    // DATA PEMBAYARAN PENDING
    // =========================
    private function get_pembayaran_pending_for_admin() {
        $this->db->select(
            'tp.*, k.total_harga, k.id_klien,
             u.nama AS nama_klien,
             mb.nama_metode'
        );
        $this->db->from('transaksi_pembayaran tp');
        $this->db->join('komisi k', 'k.id_komisi = tp.id_komisi');
        $this->db->join('users u', 'u.id_user = k.id_klien');
        $this->db->join(
            'metode_bayar mb',
            'mb.id_metode = tp.id_metode_bayar'
        );
        $this->db->where('tp.status_pembayaran', 'Menunggu Verifikasi');
        $this->db->order_by('tp.tanggal_bayar', 'ASC');

        return $this->db->get()->result();
    }

    // =========================
    // ADMIN - PROSES VERIFIKASI
    // =========================
    public function proses_verifikasi($id_transaksi, $status) {
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }

        $transaksi = $this->db->get_where(
            'transaksi_pembayaran',
            ['id_transaksi' => $id_transaksi]
        )->row();

        if (!$transaksi) {
            $this->session->set_flashdata(
                'error',
                'Transaksi tidak ditemukan.'
            );
            redirect('pembayaran/verifikasi_list');
        }

        if ($status == 'Lunas') {
            $status_pembayaran = 'Lunas';
            $status_komisi = 'In Progress';
            $message = 'Pembayaran komisi #' .
                       $transaksi->id_komisi .
                       ' berhasil diverifikasi.';
        } elseif ($status == 'Gagal') {
            $status_pembayaran = 'Gagal';
            $status_komisi = 'Pending';
            $message = 'Pembayaran komisi #' .
                       $transaksi->id_komisi .
                       ' gagal diverifikasi.';
        } else {
            $this->session->set_flashdata(
                'error',
                'Status verifikasi tidak valid.'
            );
            redirect('pembayaran/verifikasi_list');
            return;
        }

        if ($this->update_status_transaksi(
            $id_transaksi,
            $status_pembayaran,
            $transaksi->id_komisi,
            $status_komisi
        )) {
            $this->session->set_flashdata('success', $message);
        } else {
            $this->session->set_flashdata(
                'error',
                'Gagal memperbarui status.'
            );
        }

        redirect('pembayaran/verifikasi_list');
    }

    // =========================
    // UPDATE STATUS TRANSAKSI
    // =========================
    private function update_status_transaksi(
        $id_transaksi,
        $status_pembayaran,
        $id_komisi,
        $status_komisi
    ) {
        $this->db->trans_start();

        $this->db->where('id_transaksi', $id_transaksi);
        $this->db->update(
            'transaksi_pembayaran',
            ['status_pembayaran' => $status_pembayaran]
        );

        $this->db->where('id_komisi', $id_komisi);
        $this->db->update(
            'komisi',
            ['status_komisi' => $status_komisi]
        );

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
