<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peserta_magang_model extends CI_Model
{
    public function get_data($table)
    {
        return $this->db->get($table);
    }

    public function insert_data($data, $table)
    {
        $this->db->insert($table, $data);
    }

    public function update_data($data, $table)
    {
        $this->db->where('id_peserta_magang', $data['id_peserta_magang']);
        $this->db->update($table, $data);
    }
    public function get_data_by_id($id_peserta_magang)
    {
        return $this->db->get_where('peserta_magang', array('id_peserta_magang' => $id_peserta_magang))->row();
    }

    public function get_peserta_magang_by_id($id_peserta_magang)
    {
        $this->db->where('id_peserta_magang', $id_peserta_magang);
        $query = $this->db->get('peserta_magang');
        return $query->row();
    }

    public function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}
