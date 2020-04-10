<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model', 'model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		auth('index');
	}
	public function login()
	{
		$this->load->view('login');
	}
	public function forgot()
	{
		$this->load->view('forgot');
	}
	public function landing()
	{
		$this->load->view('landing');
	}
	public function reset()
	{
		$data = $this->model->forgot();
		echo json_encode($data);
	}
	public function aksi()
	{
		$model = $this->model;
		$form = $this->form_validation;
		$aksi = $this->input->post('aksi');
		if ($aksi == 'login') {
			$form->set_rules($model->rules());
			if ($form->run()) {
				$data = $model->login();
				echo json_encode($data);
			} else {
				if (form_error('username')) {
					$data['username'] = form_error('username');
				}
				if (form_error('password')) {
					$data['password'] = form_error('password');
				}
				echo json_encode($data);
			}
		} else if ($aksi == 'reset') {
			$data = $model->reset();
			echo json_encode($data);
		}
	}
}
