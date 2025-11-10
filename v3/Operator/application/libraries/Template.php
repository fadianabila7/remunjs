<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template{
	private $ci;
		
	public function __construct(){
		$this->ci =& get_instance();
	}
	
	public function view($content,$nav, $data=NULL){
		if(!$this->is_ajax()){
			$data = array('data' =>$data,);
			$template['navigation'] = $this->ci->load->view($nav, $data, TRUE);
			$template['content'] = $this->ci->load->view($content, $data, TRUE);
			$template['nav_header'] = $this->ci->load->view('template/nav_header', NULL, TRUE);
			$template['data'] = $data;
		
			$this->ci->load->view('template/index', $template);
		}else{
			//$this->ci->load->view($content, $data);
		}
	}
	public function loginpage()
	{
		$this->ci->load->view('template/login');
	}
	
	private function is_ajax(){
		return (
			$this->ci->input->server('HTTP_X_REQUESTED_WITH') &&
			($this->ci->input->server('HTTP_X_REQUESTED_WITH') ==
			'XMLHttpRequest'));
	}
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */