<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Db $db
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Menu $menu
 * @property Menu_model $Menu_model
 */

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('auth_helper'); // Load helper secara manual
        $this->load->model('Menu_model');
        is_logged_in();
    }

    public function index()
    {
        check_user_role(1);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Manajemen Menu';

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required', [
            'required' => 'Nama menu wajib diisi!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu baru ditambahkan</div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        check_user_role(1);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Manajemen Submenu';

        $this->load->model('Menu_model', 'menu');
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required', [
            'required' => 'Nama submenu wajib diisi!'
        ]);
        $this->form_validation->set_rules('menu_id', 'Menu', 'required', [
            'required' => 'Menu wajib dipilih!'
        ]);
        $this->form_validation->set_rules('url', 'Url', 'required', [
            'required' => 'Submenu url wajib diisi!'
        ]);
        $this->form_validation->set_rules('icon', 'Ikon', 'required', [
            'required' => 'Submenu ikon wajib diisi!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu baru ditambahkan</div>');
            redirect('menu/submenu');
        }
    }

    public function edit()
    {
        check_user_role(1);
        $this->load->model('Menu_model');

        $this->form_validation->set_rules('menu', 'Menu', 'required|trim', [
            'required' => 'Nama menu wajib diisi!'
        ]);

        $id = $this->input->post('id');
        $menu = $this->input->post('menu');

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, tampilkan kembali halaman dengan pesan error
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['title'] = 'Manajemen Menu';
            $data['menu'] = $this->db->get('user_menu')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika validasi berhasil, lakukan update data
            $data = [
                'menu' => htmlspecialchars($menu, true)
            ];

            if ($this->Menu_model->editMenu($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu berhasil diubah!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengubah menu!</div>');
            }

            redirect('menu');
        }
    }

    public function delete($id)
    {
        check_user_role(1);
        $this->load->model('Menu_model');
        if ($this->Menu_model->deleteMenu($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu berhasil dihapus!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menghapus menu!</div>');
        }
        redirect('menu');
    }

    public function editsubmenu()
    {
        check_user_role(1);
        $this->form_validation->set_rules('title', 'Title', 'required', ['required' => 'Nama submenu wajib diisi!']);
        $this->form_validation->set_rules('menu_id', 'Menu', 'required', ['required' => 'Menu wajib dipilih!']);
        $this->form_validation->set_rules('url', 'URL', 'required', ['required' => 'URL wajib diisi!']);
        $this->form_validation->set_rules('icon', 'Icon', 'required', ['required' => 'Ikon wajib diisi!']);

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', validation_errors('<div class="alert alert-danger">', '</div>'));
            redirect('menu/submenu');
        } else {
            $id = $this->input->post('id');
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ];

            $this->load->model('Menu_model');
            if ($this->Menu_model->editSubmenu($id, $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu berhasil diperbarui!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal memperbarui submenu!</div>');
            }
            redirect('menu/submenu');
        }
    }


    public function deletesubmenu($id)
    {
        check_user_role(1);
        $this->load->model('Menu_model');
        if ($this->Menu_model->deleteSubmenu($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu berhasil dihapus!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menghapus submenu!</div>');
        }
        redirect('menu/submenu');
    }
}
