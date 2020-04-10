<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile_model extends CI_Model
{
    public function getData()
    {
        $id_civitas = $this->session->userdata('civitas');
        return $this->db->get_where('tb_civitas', ['id_civitas' => $id_civitas])->row();
    }
}
