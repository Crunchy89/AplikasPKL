<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendidikan_model extends CI_Model
{
    public function __construct()
    {
        $this->table = 'tb_pendidikan';
        $this->id = 'id_pendidikan';
    }
    public function getData($id)
    {
        $id_civitas = '';
        if ($id == null || $id == '') {
            $id_civitas = $this->session->userdata('civitas');
        } else if ($id != null || $id != '') {
            $id_civitas = $id;
        }
        $db = $this->db;
        return $db->query("SELECT * FROM tb_pendidikan RIGHT JOIN tb_civitas ON tb_pendidikan.id_civitas = tb_civitas.id_civitas WHERE tb_civitas.id_civitas = $id_civitas")->row();
    }
    public function data($id)
    {
        $id_civitas = '';
        if ($id == null || $id == '') {
            $id_civitas = $this->session->userdata('civitas');
        } else if ($id != null || $id != '') {
            $id_civitas = $id;
        }
        $cek = $this->db->get_where($this->table, ['id_civitas' => $id_civitas])->row();
        if (!$cek) {
            for ($i = 1; $i <= 3; $i++) {
                if (!empty($_FILES['ijasah_s' . $i . '']['name'])) {
                    $this->db->set('ijasah_s' . $i . '', $this->_uploadFile('ijasah_s' . $i . ''));
                }
            }
            $data = [
                'id_civitas' => $id_civitas,
                's1' => htmlspecialchars($_POST['s1']),
                's2' => htmlspecialchars($_POST['s2']),
                's3' => htmlspecialchars($_POST['s3'])
            ];
            $this->db->insert($this->table, $data);
            $result = [
                'status' => true,
                'pesan' => 'Data Berhasil Diperbaharui'
            ];
            return $result;
        } else {
            for ($i = 1; $i <= 3; $i++) {
                $nama = 'ijasah_s' . $i . '';
                if (!empty($_FILES[$nama]['name'])) {
                    $ijasah = $_POST['oldIjasah_s' . $i . ''];
                    if ($ijasah != null || $ijasah != '') {
                        unlink("assets/img/ijasah/$ijasah");
                    }
                    $this->db->set($nama, $this->_uploadFile($nama));
                }
            }
            $data = [
                's1' => htmlspecialchars($_POST['s1']),
                's2' => htmlspecialchars($_POST['s2']),
                's3' => htmlspecialchars($_POST['s3'])
            ];
            $this->db->where('id_civitas', $id_civitas);
            $this->db->update($this->table, $data);
            $result = [
                'status' => true,
                'pesan' => 'Data Berhasil Diperbaharui'
            ];
            return $result;
        }
    }
    private function _uploadFile($file)
    {
        $config['upload_path'] = 'assets/img/ijasah/';
        $config['allowed_types'] = 'pdf';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file)) {
            return $this->upload->data('file_name');
        } else {
            return '';
        }
    }
}
