<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends MY_Controller
{

	public function __construct()
	{
		if (!$this->session->userdata('role')) {
			redirect('auth');
		}
		parent::__construct();
		$this->load->model('admin_model', 'model');
	}

	public function index()
	{
		$id_civitas = $this->session->userdata('civitas');
		$data = [
			'title' => "Admin Page",
			'profile' => $this->db->get_where('tb_civitas', ['id_civitas' => $id_civitas])->row()
		];
		admin('index', $data);
	}
	public function dashboard()
	{
		$this->load->view('index');
	}
	public function menu()
	{
		$data = $this->model->menu();
		echo json_encode($data);
	}
	public function logout()
	{
		$this->db->set('tgl_akhir', date('Y-m-d H-i-s'));
		$this->db->where('id_user', $this->session->userdata('user'));
		$this->db->update('user');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('role');
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('civitas');
		$this->session->sess_destroy();
		redirect('auth');
	}
}
