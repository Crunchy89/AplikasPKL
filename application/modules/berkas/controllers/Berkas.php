<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Berkas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('berkas_model', 'model');
    }
    public function index()
    {
        $this->load->view('index');
    }
    function getLists()
	{
		$data = array();
		$role = $this->model->getRows($_POST);

		$i = $_POST['start'];
		foreach ($role as $d) {
			
				$i++;
				$btn_edit = '<button type="button" class="btn btn-warning btn-xs edit" data-role="' . $d->role . '" data-id_role="' . $d->id_role . '"><i class="fa fa-fw fa-edit"></i> Edit</button>';
				$btn_hapus = '<button type="button" class="btn btn-danger btn-xs hapus"  data-id_role="' . $d->id_role . '"><i class="fa fa-fw fa-trash"></i> Hapus</button>';
				$data[] = array($i, $d->role, $btn_edit . ' ' . $btn_hapus);
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->model->countAll(),
			"recordsFiltered" => $this->model->countFiltered($_POST),
			"data" => $data,
		);
		echo json_encode($output);
	}
}
