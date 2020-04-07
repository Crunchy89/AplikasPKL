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
                $data = [
                    'id_user' => $cek->id_user,
                    'username' => $cek->username,
                    'id_role' => $cek->id_role
                ];
                $this->session->set_userdata($data);
                return $data['status'] = site_url('admin');
            }
            return $data['status'] = 'Username Atau Password salah';
        }
        return $data['status'] = 'Akun Tidak Ditemukan';
    }
    public function forgot()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $cek = $this->db->get_where('token', ['email' => $email, 'token' => $token])->row();
        if ($cek) {
            $data = [
                'password' => $this->input->post('password')
            ];
            $this->db->where('email', $cek->email);
            $this->db->update($this->table, $data);
        }
        
    }
    public function reset()
    {
        $email = htmlspecialchars($this->input->post('email'));
        $cek = $this->db->get_where($this->table, ['email' => $email])->row();
        if ($cek) {
            $token = base64_encode(random_bytes(32));
            $data = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];
            $this->db->insert('token', $data);
            $this->_sendEmail($token, $email);
        }
        return $data['status'] = 'Email Tidak Ditemukan';
    }
    private function _sendEmail($token, $email)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'rocker.hunt@gmail.com',
            'smtp_pass' => 'basong666',
            'smtp_port' => 465,
            'mailType' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('rocker.hunt@gmail.com', 'Reset Password');
        $this->email->to($email);
        $this->email->subject('Reset Password');
        $this->email->message("Klik link untuk reset password : <a href='" . site_url() . "auth/forgot?email=$email&token=$token'>Reset Password</a>");
        if ($this->email->send()) {
            return $data['status'] = 'Token berhasil dikirim Silahkan cek Email';
        } else {
            return $data['status'] = $this->email->print_debugger();
        }
    }
}
