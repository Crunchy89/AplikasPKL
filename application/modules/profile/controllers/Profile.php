<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('profile_model', 'model');
    }
    public function index()
    {
        $this->load->view('index');
    }
    public function getData(){
        $data=$this->model->getData();
        echo json_encode($data);
    }
}
