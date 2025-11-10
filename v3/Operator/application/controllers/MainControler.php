<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainControler extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
	}
	public function index()
	{
		if($this->session->userdata('sess_operator'))
   		{			
   			$session_data = $this->session->userdata('sess_operator');
			   $data         = array('datasession' => $session_data );
			   
			$this->template->view('template/content','template/navigation',$data);
		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
	}

	public function logout()
 	{
   		$this->session->unset_userdata('sess_operator');
   		session_destroy();
   		redirect('VerifyLogin', 'refresh');
	 }
	 
	public function login()
	{
		$this->template->loginpage();
	}

	public function getTurunan(){
		$id = $_POST['id'];
		$datakegiatan = $this->Db_model->datakegiatan($id);
		echo json_encode($datakegiatan);
	}
}
