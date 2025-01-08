<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Db $db
 * @property CI_Session $session
 * @property CI_Email $email
 */

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('phpmailer_lib'); // Load library PHPMailer
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->goToDefaultPage();

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Halaman Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // Validasi sukses
            $this->_login();
        }
    }


    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // Jika usernya ada
        if ($user) {
            // Jika usernya aktif
            if ($user['is_active'] == 1) {
                // Cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kata sandi salah!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email ini belum diaktifkan!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email belum terdaftar!</div>');
            redirect('auth');
        }
    }

    public function registration()
    {
        $this->goToDefaultPage();
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email ini sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Kata sandi tidak cocok!',
            'min_length' => 'Kata sandi terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]', [
            'matches' => 'Kata sandi tidak cocok!'
        ]);


        if ($this->form_validation->run() == false) {
            $data['title'] = 'Halaman Pendaftaran';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default1.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];

            // siapkan token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat! Akun Anda telah dibuat. Silakan aktivasi akun Anda.</div>');
            redirect('auth');
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' telah diaktifkan. Silakan login!</div>');
                    redirect('auth');
                } else {

                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);


                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Verifikasi akun gagal! Token kadaluarsa.</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Verifikasi akun gagal! Token salah.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Verifikasi akun gagal! Email salah.</div>');
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
    {
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load(); // Mengembalikan objek PHPMailer

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ratnaantika386@gmail.com';
            $mail->Password = 'swpf wnxp avvn aukc';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('ratnaantika386@gmail.com');
            $mail->addAddress($this->input->post('email'));

            if ($type == 'verify') {
                $mail->Subject = 'Verifikasi Akun';
                $mail->isHTML(true);
                $mail->Body = 'Klik tautan ini untuk memverifikasi akun Anda:
                    <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktivasi</a>';
            } else if ($type == 'forgot') {
                $mail->Subject = 'Atur Ulang Kata Sandi';
                $mail->isHTML(true);
                $mail->Body = 'Klik tautan ini untuk mengatur ulang kata sandi Anda:
                    <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Atur Ulang Kata Sandi</a>';
            }

            $mail->send();
        } catch (Exception $e) {
            echo "Pesan gagal dikirim. Error: {$mail->ErrorInfo}";
            die;
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda telah keluar!</div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function goToDefaultPage()
    {
        if ($this->session->userdata('role_id') == 1) {
            redirect('admin');
        } else if ($this->session->userdata('role_id') == 2) {
            redirect('user');
        } else {
            // Jika ada role_id yg lain maka tambahkan disini
        }
    }

    public function forgotPassword()
    {

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Email harus diisi!',
            'valid_email' => 'Email tidak valid!'
        ]);
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Lupa Kata Sandi';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes('32'));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time(),
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Silakan cek email Anda untuk mengatur ulang kata sandi Anda!</div>');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email belum terdaftar!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                // Cek apakah token masih berlaku (5 menit)
                if (time() - $user_token['date_created'] < 300) { // 300 detik = 5 menit
                    $this->session->set_userdata('reset_email', $email);
                    $this->changePassword(); // Panggil fungsi untuk mengubah password
                } else {
                    // Hapus token dan user jika token kadaluarsa
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Atur ulang kata sandi gagal! Token kadaluarsa.</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Atur ulang kata sandi gagal! Token salah.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Atur ulang kata sandi gagal! Email salah.</div>');
            redirect('auth');
        }
    }


    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[4]|matches[password2]', [
            'required' => 'Kata sandi harus diisi!',
            'min_length' => 'Kata sandi terlalu pendek!',
            'matches' => 'Kata sandi tidak cocok!',
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[4]|matches[password1]', [
            'required' => 'Ulangi kata sandi harus diisi!',
            'min_length' => 'Kata sandi terlalu pendek!',
            'matches' => 'Kata sandi tidak cocok!',
        ]);
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Ubah Kata Sandi';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kata sandi sudah berubah! Silakan login.</div>');
            redirect('auth');
        }
    }
}
