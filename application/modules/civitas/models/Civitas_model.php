<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Civitas_model extends CI_Model
{
    function __construct()
    {
        $this->table = 'tb_civitas';
        $this->id = 'id_civitas';
        $this->column_order = array(null, 'nik', 'nm_lengkap', 'alamat', 'tlp', 'email', 'website', null, null, null);
        $this->column_search = array('nik', 'nm_lengkap', 'alamat', 'tlp', 'email', 'website');
        $this->order = array('id_civitas' => 'asc');
    }

    public function getRows($postData)
    {
        $this->_get_datatables_query($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countAll()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function countFiltered($postData)
    {
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_datatables_query($postData)
    {

        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($postData['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function tambah()
    {
        $nik = htmlspecialchars($_POST['nik']);
        $cek = $this->db->get_where($this->table, ['nik' => $nik])->row();
        if ($cek) {
            $data = [
                'status' => false,
                'pesan' => "Civitas sudah terdaftar"
            ];
        } else {
            $insert = [
                'nik' => htmlspecialchars($_POST['nik']),
                'nm_lengkap' => htmlspecialchars($_POST['nama']),
                'alamat' => htmlspecialchars($_POST['alamat']),
                'tlp' => htmlspecialchars($_POST['no_hp']),
                'email' => htmlspecialchars($_POST['email']),
                'website' => htmlspecialchars($_POST['web']),
                'foto' => $this->_uploadImage()
            ];
            $this->db->insert($this->table, $insert);
            $civitas = $this->db->insert_id();
            $user = [
                'username' => htmlspecialchars($_POST['username']),
                'password' => password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT),
                'status_user' => 1,
                'id_civitas' => $civitas,
                'id_role' => 2,
                'tgl_mulai' => date('Y-m-d H-i-s'),
                'tgl_akhir' => date('Y-m-d H-i-s')
            ];
            $this->db->insert('user', $user);
            $data = [
                'status' => true,
                'pesan' => "Civitas Berhasil Ditambah"
            ];
        }
        return $data;
    }
    public function edit()
    {
        $gambar_lama = $this->input->post('gambarLama');
        if (!empty($_FILES['gambar']['name'])) {
            $upload = $this->_uploadImage();
            $this->db->set('foto', $upload);
            if ($gambar_lama != "noimage.png") {
                unlink("assets/img/profile/" . $gambar_lama . "");
            }
        }
        $insert = [
            'nik' => htmlspecialchars($_POST['nik']),
            'nm_lengkap' => htmlspecialchars($_POST['nama']),
            'alamat' => htmlspecialchars($_POST['alamat']),
            'tlp' => htmlspecialchars($_POST['no_hp']),
            'email' => htmlspecialchars($_POST['email']),
            'website' => htmlspecialchars($_POST['web']),
        ];
        $this->db->where($this->id, $_POST['id']);
        $this->db->update($this->table, $insert);
        $data = [
            'status' => true,
            'pesan' => "Data berhasil diubah"
        ];
        return $data;
    }
    public function hapus()
    {
        $id = htmlspecialchars($_POST['id']);
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join('tb_pendidikan', "$this->table.id_civitas = tb_pendidikan.id_civitas", 'right');
        $this->db->where("$this->table.$this->id", $id);
        $file = $this->db->get()->row();
        for ($i = 1; $i <= 3; $i++) {
            $ijasah = 'ijasah_s' . $i . '';
            if ($file->$ijasah != null || $file->$ijasah != '') {
                unlink("assets/img/ijasah/" . $file->$ijasah . "");
            }
        }
        $gambar = $this->db->get_where($this->table, [$this->id => $id])->row();
        if ($gambar->foto != "noimage.png") {
            unlink("assets/img/profile/" . $gambar->foto . "");
        }
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
        $data = [
            'status' => true,
            'pesan' => "Data berhasil dihapus"
        ];
        return $data;
    }
    private function _uploadImage()
    {
        $config['upload_path']          = './assets/img/profile/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('gambar')) {
            return $this->upload->data('file_name');
        } else {
            return 'noimage.png';
        }
    }
}
