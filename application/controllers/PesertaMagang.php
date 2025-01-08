<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Db $db
 * @property CI_Session $session
 * @property Peserta_magang_model $peserta_magang_model

 */

use Dompdf\Dompdf;
use Dompdf\Options;

class PesertaMagang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('auth_helper'); // Load helper secara manual
        $this->load->model('peserta_magang_model');
        $this->load->library('session');
        is_logged_in();
    }

    public function index()
    {
        check_user_role(1);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Peserta Magang (Admin)';
        $data['magang'] = $this->peserta_magang_model->get_data('peserta_magang')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/peserta_magang', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        check_user_role(1);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Tambah Peserta Magang';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('admin/tambah_peserta_magang');
        $this->load->view('templates/footer');
    }

    public function print()
    {
        check_user_role(1);
        $data['magang'] = $this->peserta_magang_model->get_data('peserta_magang')->result();
        $this->load->view('admin/print_peserta_magang', $data);
    }

    public function pdf()
    {
        check_user_role(1);
        // Buat instance baru Dompdf dan set opsi jika diperlukan
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true); // Mengaktifkan parser HTML5
        $dompdf = new Dompdf($options);

        // Ambil data peserta magang dari model
        $data['magang'] = $this->peserta_magang_model->get_data('peserta_magang')->result();

        // Load view data_peserta_magang dan simpan output HTML ke dalam variabel
        $html = $this->load->view('admin/data_peserta_magang', $data, true);

        // Atur ukuran kertas dan orientasi
        $dompdf->setPaper('A4', 'portrait'); // Pilih 'portrait' atau 'landscape'

        // Muat konten HTML ke dalam Dompdf
        $dompdf->loadHtml($html);

        // Render konten HTML menjadi PDF
        $dompdf->render();

        // Stream atau unduh file PDF
        $dompdf->stream('data_peserta_magang.pdf', array("Attachment" => 0)); // Attachment=0 untuk menampilkan di browser
    }

    public function tambah_aksi()
    {
        check_user_role(1);
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            // Mengambil data dari form
            $tanggal_mulai_input = $this->input->post('mulai');

            // Mengonversi tanggal dari dd/mm/yyyy ke yyyy-mm-dd
            $tanggal_mulai = date('Y-m-d', strtotime($tanggal_mulai_input));

            $tanggal_berakhir_input = $this->input->post('berakhir');

            // Mengonversi tanggal dari dd/mm/yyyy ke yyyy-mm-dd
            $tanggal_berakhir = date('Y-m-d', strtotime($tanggal_berakhir_input));

            $data = array(
                'nama' => $this->input->post('nama'),
                'nim' => $this->input->post('nim'),
                'asal_kampus_sekolah' => $this->input->post('asal_kampus_sekolah'),
                'fakultas' => $this->input->post('fakultas'),
                'prodi' => $this->input->post('prodi'),
                'mulai' => $tanggal_mulai,
                'berakhir' => $tanggal_berakhir,
                'surat_balasan_magang' => $this->input->post('surat_balasan_magang'),
            );

            $this->peserta_magang_model->insert_data($data, 'peserta_magang');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil ditambahkan! <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('pesertamagang');
        }
    }

    public function edit($id_peserta_magang)
    {
        check_user_role(1);
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $peserta_magang_lama = $this->peserta_magang_model->get_data_by_id($id_peserta_magang);

            $tanggal_mulai_input = $this->input->post('mulai');

            if (!empty($tanggal_mulai_input)) {
                $tanggal_mulai = date('Y-m-d', strtotime($tanggal_mulai_input));
            } else {
                $tanggal_mulai = $peserta_magang_lama->mulai;
            }

            $tanggal_berakhir_input = $this->input->post('berakhir');

            if (!empty($tanggal_berakhir_input)) {
                $tanggal_berakhir = date('Y-m-d', strtotime($tanggal_berakhir_input));
            } else {
                $tanggal_berakhir = $peserta_magang_lama->berakhir;
            }

            $data = array(
                'id_peserta_magang' => $id_peserta_magang,
                'nama' => $this->input->post('nama'),
                'nim' => $this->input->post('nim'),
                'asal_kampus_sekolah' => $this->input->post('asal_kampus_sekolah'),
                'fakultas' => $this->input->post('fakultas'),
                'prodi' => $this->input->post('prodi'),
                'mulai' => $tanggal_mulai,
                'berakhir' => $tanggal_berakhir,
                'surat_balasan_magang' => $this->input->post('surat_balasan_magang'),
            );

            $this->peserta_magang_model->update_data($data, 'peserta_magang');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data berhasil diubah! <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
                </button></div>');
            redirect('pesertamagang');
        }
    }

    public function _rules()
    {
        check_user_role(1);
        $this->form_validation->set_rules('nama', 'Nama', 'required', array(
            'required' => '%s harus diisi!!'
        ));
        $this->form_validation->set_rules('asal_kampus_sekolah', 'Asal Kampus/Sekolah', 'required', array(
            'required' => '%s harus diisi!!'
        ));
        $this->form_validation->set_rules('mulai', 'Mulai', 'required', array(
            'required' => '%s harus diisi!!'
        ));
        $this->form_validation->set_rules('berakhir', 'Berakhir', 'required', array(
            'required' => '%s harus diisi!!'
        ));
    }

    public function delete($id)
    {
        check_user_role(1);
        $where = array('id_peserta_magang' => $id);

        $this->peserta_magang_model->delete($where, 'peserta_magang');
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data berhasil dihapus! <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
                </button></div>');
        redirect('pesertamagang');
    }
}
