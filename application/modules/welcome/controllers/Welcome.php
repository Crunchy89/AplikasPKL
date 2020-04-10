<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller
{

	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function upload()
	{
		$hit = count($_FILES['files']['name']);
		if ($_FILES['files']['name']) {
			$config['upload_path']          = 'assets/file/';
			$config['allowed_types']        = 'pdf|doc|docx|xls|xlsx|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			for ($i = 0; $i < $hit; $i++) {
				$_FILES['file']['name'] = $_FILES['files']['name'][$i];
				$_FILES['file']['type'] = $_FILES['files']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['files']['error'][$i];
				$_FILES['file']['size'] = $_FILES['files']['size'][$i];
				if ($this->upload->do_upload('file')) {
					$data = [
						'file' => $this->upload->data('file_name')
					];
				} else {
					$data['file'] = "noimage.png";
				}

				$this->db->insert('file', $data);
			}
			redirect('welcome');
		}
		redirect('welcome');
	}
}
