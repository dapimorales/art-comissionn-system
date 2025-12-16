<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progress extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('logged_in') != TRUE) {
            redirect('auth/login');
        }

        $this->load->model('Progress_model');
        $this->load->model('Komisi_model');
        $this->load->model('Tahapan_proyek_model');
        $this->load->library('form_validation');
    }

    // =========================================
    // KLIEN & ADMIN - DETAIL PROGRES KOMISI
    // =========================================
    public function detail($id_komisi) {
        $komisi = $this->Komisi_model->get_komisi_detail_by_id($id_komisi);

        if (!$komisi) {
            show_404();
        }

        // Cek kepemilikan komisi (khusus klien)
        if (
            $this->session->userdata('role') == 'klien' &&
            $komisi->id_klien != $this->session->userdata('id_user')
        ) {
            $this->session->set_flashdata(
                'error',
                'Akses komisi ini ditolak.'
            );
            redirect('dashboard');
        }

        $data['title'] = 'Progres Komisi #' . $id_komisi;
        $data['komisi'] = $komisi;
        $data['riwayat_progress'] =
            $this->Progress_model->get_progress_by_komisi($id_komisi);
        $data['feedback_list'] =
            $this->Progress_model->get_feedback_by_komisi($id_komisi);
        $data['tahapan_proyek'] =
            $this->Tahapan_proyek_model->get_all_tahapan();

        $this->load->view('layout/v_header', $data);
        $this->load->view('transaksi/progress/v_detail', $data);
        $this->load->view('layout/v_footer');
    }

    // =========================================
    // ADMIN - UPDATE PROGRES & UPLOAD PREVIEW
    // =========================================
    public function update_progress() {
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }

        $id_komisi = $this->input->post('id_komisi');

        $this->form_validation->set_rules(
            'id_tahap',
            'Tahapan',
            'required|numeric'
        );
        $this->form_validation->set_rules(
            'catatan_artist',
            'Catatan Artist',
            'required'
        );

        // Konfigurasi upload
        $config['upload_path']   = FCPATH . 'assets/preview_progress/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 5000; // 5 MB
        $config['file_name']     =
            'progress-' . $id_komisi . '-' . time();

        $this->load->library('upload', $config);

        // Validasi form
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(
                'error',
                strip_tags(validation_errors())
            );
            redirect('progress/detail/' . $id_komisi);
            return;
        }

        // Upload file preview
        if (!$this->upload->do_upload('file_preview')) {
            $this->session->set_flashdata(
                'error',
                strip_tags($this->upload->display_errors())
            );
            redirect('progress/detail/' . $id_komisi);
            return;
        }

        $upload_data = $this->upload->data();

        $data = [
            'id_komisi'       => $id_komisi,
            'id_tahap'        => $this->input->post('id_tahap'),
            'catatan_artist'  => $this->input->post('catatan_artist'),
            'file_preview'    => $upload_data['file_name']
        ];

        if ($this->Progress_model->insert_progress($data)) {
            // Jika tahapan terakhir
            if ($this->input->post('is_final') == '1') {
                $this->Progress_model
                     ->update_status_komisi($id_komisi, 'Completed');
                $this->session->set_flashdata(
                    'success',
                    'Proyek telah ditandai SELESAI.'
                );
            } else {
                $this->session->set_flashdata(
                    'success',
                    'Progres pengerjaan berhasil diperbarui.'
                );
            }
        } else {
            $this->session->set_flashdata(
                'error',
                'Gagal menyimpan progres.'
            );
        }

        redirect('progress/detail/' . $id_komisi);
    }

    // =========================================
    // KLIEN - KIRIM FEEDBACK / REVISI
    // =========================================
    public function kirim_feedback() {
        if ($this->session->userdata('role') != 'klien') {
            redirect('dashboard');
        }

        $id_komisi = $this->input->post('id_komisi');

        $this->form_validation->set_rules(
            'catatan_klien',
            'Catatan Feedback',
            'required'
        );

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(
                'error',
                strip_tags(form_error('catatan_klien'))
            );
        } else {
            $data = [
                'id_komisi'     => $id_komisi,
                'catatan_klien' => $this->input->post('catatan_klien'),
                'status_revisi' => 'Diterima'
            ];

            if ($this->Progress_model->insert_feedback($data)) {
                $this->session->set_flashdata(
                    'success',
                    'Feedback berhasil dikirim ke Artist.'
                );
            } else {
                $this->session->set_flashdata(
                    'error',
                    'Gagal mengirim feedback.'
                );
            }
        }

        redirect('progress/detail/' . $id_komisi);
    }
}
