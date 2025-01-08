<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Chart_model $chart_model
 * @property CI_Db $db
 * @property CI_Session $session
 */

class Dasbor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Dasbor';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dasbor', $data);
        $this->load->view('templates/footer');
    }

    public function get_pie_chart_data()
    {
        $data = $this->chart_model->get_pie_chart_data();
        echo json_encode($data);
    }

    public function chart_data()
    {
        $data = $this->chart_model->chart_database();
        echo json_encode($data);
    }
}
