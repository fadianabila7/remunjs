<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_kegiatan_dosen($data){
        $this->db->select('*');
        $this->db->from('kegiatan_dosen');
        $this->db->order_by('id_kegiatan_dosen ASC');
        if($data['like']){
            $this->db->like($data['like']);
        }

        $res = $this->db->get();
        return $res->result_array();
    }
}