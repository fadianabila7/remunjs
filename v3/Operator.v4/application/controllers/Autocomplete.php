<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		 $this->load->model('db_model');
	}
	public function json_search_matakuliah()
    {
        $query  = $this->db_model->getMatakuliahALL();
       
        echo json_encode($query);
        
    }

    public function json_search_dosen()
    {
        $query  = $this->db_model->getDosenAll();
       
        echo json_encode($query);
    }
}
?>