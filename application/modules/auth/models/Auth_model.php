<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function __construct()
    {
        $this->table = 'user';
        $this->id = 'id_user';
    }
    public function rules()
    {
        return [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Field %s tidak boleh kosong'
                ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'Field %s tidak boleh kosong'
                ]
            ]
        ];
    }
    public function login()
    {
        $user = htmlspecialchars($this->input->post('username'));
        $pass = htmlspecialchars($this->input->post('password'));
        $cek = $this->db->get_where($this->table, ['username' => $user])->row();
        if ($cek) {
            if (password_verify($pass, $cek->password)) {
                if ($cek->status_user == 1) {
                    $data = [
                        'user' => $cek->id_user,
                        'username' => $cek->username,
                        'role' => $cek->id_role,
                        'civitas' => $cek->id_civitas
                    ];
                    $this->session->set_userdata($data);
                    $this->db->set('tgl_mulai', date('Y-m-d H-i-s'));
                    $this->db->where($this->id, $cek->id_user);
                    $this->db->update($this->table);
                    $data = [
                        'status' => true,
                        'pesan' => 'Selamat Datang ' . $user,
                        'url' => site_url('admin')
                    ];
                } else {
                    $data = [
                        'status' => false,
                        'pesan' => "Akun nonaktif silahkan hubungi Admin"
                    ];
                }
            } else {
                $data = [
                    'status' => false,
                    'pesan' => "Username atau Password salah"
                ];
            }
        } else {
            $data = [
                'status' => false,
                'pesan' => "Akun tidak ditemukan"
            ];
        }
        return $data;
    }
    public function forgot()
    {
        $email = htmlspecialchars($this->input->post('email'));
        $pass = htmlspecialchars($this->input->post('password'));
        $token = $this->input->post('token');
        $user = $this->db->get_where('tb_civitas', ['email' => $email])->row();
        if ($user) {
            $cek = $this->db->get_where('tokens', ['token' => $token])->row();
            if ($cek) {
                if (time() - $cek->date_created < (60 * 60 * 24)) {
                    $data = [
                        'password' => password_hash($pass, PASSWORD_DEFAULT)
                    ];
                    $this->db->where($this->id, $user->id_civitas);
                    $this->db->update($this->table, $data);
                    $this->db->where('email', $email);
                    $this->db->delete('tokens');
                    $data = [
                        'status' => true,
                        'pesan' => 'Password Berhasil dirubah'
                    ];
                } else {
                    $data = [
                        'status' => false,
                        'pesan' => 'Token Expired'
                    ];
                }
            } else {
                $data = [
                    'status' => false,
                    'pesan' => 'Token salah'
                ];
            }
        } else {
            $data = [
                'status' => false,
                'pesan' => 'Email tidak di temukan'
            ];
        }

        return $data;
    }
    public function reset()
    {
        $email = htmlspecialchars($this->input->post('email'));
        $cek = $this->db->get_where('tb_civitas', ['email' => $email])->row();
        if ($cek) {
            $ada = $this->db->get_where('tokens', ['email' => $email])->row();
            if ($ada) {
                $token = base64_encode(random_bytes(32));
                $data = [
                    'token' => $token,
                    'date_created' => time()
                ];
                $this->db->where('email', $email);
                $this->db->update('tokens', $data);
                return $this->_sendEmail($token, $email);
            } else {
                $token = base64_encode(random_bytes(32));
                $data = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];
                $this->db->insert('tokens', $data);
                return $this->_sendEmail($token, $email);
            }
        } else {
            $data = [
                'status' => false,
                'pesan' => 'Email tidak ditemukan'
            ];
        }
        return $data;
    }
    private function _sendEmail($token, $email)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'your.email.aja@gmail.com',
            'smtp_pass' => 'Makannasi',
            'smtp_port' => 465,
            'mailType' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE,
        ];
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
        $this->email->set_header('Content-type', 'text/html');
        $this->email->from('your.email.aja@gmail.com', 'Admin');
        $this->email->to($email);
        $this->email->subject('Reset Password');
        $this->email->message('klik link untuk reset password : <a href="' . site_url() . '/auth/landing?email=' . $email . '&token=' . urlencode($token) . '">Reset Password</a>');
        if ($this->email->send()) {
            $data['status'] = true;
            $data['pesan'] = 'Token berhasil dikirim Silahkan cek Email';
            $data['url'] = site_url('auth');
            return $data;
        } else {
            $data['status'] = false;
            $data['pesan'] = 'Maaf terjadi kesalahan Silahkan mencoba kembali nanti';
            return $data;
        }
    }
}

