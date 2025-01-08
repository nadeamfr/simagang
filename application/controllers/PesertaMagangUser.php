<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Db $db
 * @property CI_Session $session
 * @property Peserta_magang_user_model $peserta_magang_user_model
 */

use Dompdf\Dompdf;
use Dompdf\Options;

class PesertaMagangUser extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('peserta_magang_user_model');
        is_logged_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Peserta Magang';
        $data['magang'] = $this->peserta_magang_user_model->get_data('peserta_magang')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('user/peserta_magang_user', $data);
        $this->load->view('templates/footer');
    }
}
