<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Civitas extends MY_Controller
{
	public function __construct()
	{
		if (!$this->session->userdata('role')) {
			redirect('auth');
		}
		parent::__construct();
		$this->load->model('civitas_model', 'model');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$this->load->view('index');
	}
	function getLists()
	{
		$data = array();
		$civitas = $this->model->getRows($_POST);

		$i = $_POST['start'];
		foreach ($civitas as $d) {
			$i++;
			$pendidikan="<button type='button' data-id_civitas='$d->id_civitas' class='btn btn-info pendidikan'><i class='fa fa-fw fa-graduation-cap'></i> Pendidikan</button>";
			$foto = "<img src='" . base_url() . "/assets/img/profile/$d->foto' alt='Foto' width='50px'>";
			$btn_edit = '<button type="button" data-nik="' . $d->nik . '" data-nama="' . $d->nm_lengkap . '" data-alamat="' . $d->alamat . '" data-tlp="' . $d->tlp . '" data-email="' . $d->email . '" data-website="' . $d->website . '" data-foto="' . $d->foto . '" data-civitas="' . $d->id_civitas . '" da class="btn btn-warning btn-xs edit"><i class="fa fa-fw fa-edit"></i> Edit</button>';
			$btn_hapus = "<button type='button' class='btn btn-danger btn-xs hapus'  data-civitas='$d->id_civitas'><i class='fa fa-fw fa-trash'></i> Hapus</button>";
			$data[] = array($i, $d->nik, $d->nm_lengkap, $d->alamat, $d->tlp, $d->email, $d->website, $foto,$pendidikan, $btn_edit . ' ' . $btn_hapus);
		}
		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' => $this->model->countAll(),
			'recordsFiltered' => $this->model->countFiltered($_POST),
			'data' => $data,
		);
		echo json_encode($output);
	}
	public function aksi()
	{
		if ($_POST['aksi'] == 'tambah') {
			$data = $this->model->tambah();
			echo json_encode($data);
		} else if ($_POST['aksi'] == 'edit') {
			$data = $this->model->edit();
			echo json_encode($data);
		} else if ($_POST['aksi'] == 'hapus') {
			$data = $this->model->hapus();
			echo json_encode($data);
		}
	}
}
