<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Chart_model $chart_model
 * @property CI_Form_validation $form_validation
 * @property CI_Db $db
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Upload $upload
 */

class User extends CI_Controller
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

    public function edit()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Edit Profil';

        $this->form_validation->set_rules('name', 'Nama lengkap', 'required|trim', [
            'required' => 'Nama lengkap wajib diisi!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // Cek jika ada gambar yang diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png|';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile/';
                $this->load->library('upload', $config);
            }

            if ($this->upload->do_upload('image')) {
                $old_image = $data['user']['image'];
                if ($old_image != 'default1.jpg') {
                    unlink(FCPATH . 'assets/img/profile/' . $old_image);
                }

                $new_image = $this->upload->data('file_name');
                $this->db->set('image', $new_image);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                redirect('profilsaya');
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profil anda telah diperbarui!</div>');
            redirect('profilsaya');
        }
    }

    public function ubahKataSandi()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Ubah Kata Sandi';

        $this->form_validation->set_rules('current_password', 'Kata sandi saat ini', 'required|trim', [
            'required' => 'Kata sandi saat ini wajib diisi!'
        ]);
        $this->form_validation->set_rules('new_password1', 'Kata sandi baru', 'required|trim|min_length[4]|matches[new_password2]', [
            'required' => 'Kata sandi baru wajib diisi!',
            'min_length' => 'Kata sandi baru minimal 4 karakter!',
            'matches' => 'Kata sandi baru tidak cocok dengan pengulangan kata sandi baru!'
        ]);
        $this->form_validation->set_rules('new_password2', 'Ulangi kata sandi baru', 'required|trim|min_length[4]|matches[new_password1]', [
            'required' => 'Ulangi kata sandi baru wajib diisi!',
            'min_length' => 'Kata sandi baru minimal 4 karakter!',
            'matches' => 'Pengulangan kata sandi baru tidak cocok dengan kata sandi baru!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('user/ubahkatasandi', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kata sandi saat ini salah!</div>');
                redirect('user/ubahkatasandi');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kata sandi baru tidak boleh sama dengan kata sandi saat ini!</div>');
                    redirect('user/ubahkatasandi');
                } else {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kata sandi Anda telah diperbarui!</div>');
                    redirect('user/ubahkatasandi');
                }
            }
        }
    }
}
