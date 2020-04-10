<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendidikan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pendidikan_model', 'model');
    }
    public function index()
    {
        $this->load->view('index');
    }
    public function pendidikan($id)
    {
        $this->load->view('pendidikan');
    }
    public function getData($id = null)
    {
        $data = $this->model->getData($id);
        echo json_encode($data);
    }
    public function data($id = null)
    {
        $data = $this->model->data($id);
        echo json_encode($data);
    }
}
