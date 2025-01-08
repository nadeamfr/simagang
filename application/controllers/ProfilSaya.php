<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Db $db
 * @property CI_Session $session
 */

class ProfilSaya extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Profil Saya';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('user/profilsaya');
        $this->load->view('templates/footer');
    }
}
