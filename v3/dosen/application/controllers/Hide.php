<?php
class Hide extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->library('template');
   $this->load->library('session');
   $this->load->model('User','',TRUE);
 }
 
 function index()
 {
   //This method will have the credentials validation
   
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('username', 'username', 'trim|required');
   $this->form_validation->set_rules('password', 'password', 'trim|required|callback_check_database');
 
	if($this->form_validation->run() == FALSE){
		$this->load->view('template/loginhide');
	}else{
		redirect('MainControler', 'refresh');
	}
 
 }
 
 function check_database($password)
 {
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('username');
    
   //query the database
   $result = $this->User->login($username, md5($password));
 
   if($result && $result[0]->id_role==3)
   {

     $sess_array = array();
     foreach($result as $row)
     {       
        
       $sess_array = array(
        'user' => $row->id_user,
        'name' => $row->nama,
        'idRole' => $row->id_role,
         'idFakultas' => $row->id_fakultas,
         'idDosen' => $row->id_dosen,
         'namafakultas' => $row->namaf,
         'namaprodi' => $row->namap
       );
       $this->session->set_userdata('sess_dosen', $sess_array);
     }
     return TRUE;
   }
   else
   {
     $this->form_validation->set_message('check_database', 'Invalid username or password');
     return false;
   }
 }
}
?>