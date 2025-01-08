<?php

class Chart_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }


    public function chart_database()
    {
        return $this->db->get('chart')->result();
    }

    public function get_pie_chart_data()
    {
        return $this->db->select('asal_kampus_sekolah, jumlah')
            ->from('pie_chart')
            ->get()
            ->result_array();
    }
}
