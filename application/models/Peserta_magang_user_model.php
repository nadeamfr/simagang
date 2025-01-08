<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peserta_magang_user_model extends CI_Model
{
    public function get_data($table)
    {
        return $this->db->get($table);
    }
}
