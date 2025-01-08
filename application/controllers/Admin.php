<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Db $db
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 */

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('auth_helper'); // Load helper secara manual
        is_logged_in();
    }
    public function index()
    {
        check_user_role(1);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Dasbor';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dasbor', $data);
        $this->load->view('templates/footer');
    }
}
