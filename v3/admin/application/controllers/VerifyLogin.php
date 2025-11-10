<?php
class VerifyLogin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->model('User', '', TRUE);
	}

	function index()
	{
		//This method will have the credentials validation

		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'username', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required|callback_check_database');

		if ($this->form_validation->run() == FALSE) {


			$this->template->loginpage();
		} else {

			redirect('MainControler', 'refresh');
		}
	}

	function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');

		//query the database
		$result = $this->User->login($username, md5($password));

		if ($result && $result[0]->id_role == 2) {

			$sess_array = array();
			foreach ($result as $row) {

				$sess_array = array(
					'name' => $row->id_user,
					'idRole' => $row->id_role,
					'idFakultas' => $row->id_fakultas,
					'idAdmin' => $row->id_admin,
					'namaAdmin' => $row->nama,
					'namafakultas' => $row->namaf,

				);
				$this->session->set_userdata('sess_admin', $sess_array);
			}
			$this->save_login_log($username, $password, 'success');
			return TRUE;
		} else {
			$this->save_login_log($username, $password, 'error');
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}


	private function save_login_log($username, $password, $status)
	{
		$CI = &get_instance();
		$log_path = '../../logs/admin/login/log_' . date('Y-m-d') . '.log';
		$userAgent = $CI->input->user_agent();
		$timestamp  = date("Y-m-d H:i:s");
		$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

		$log_message = "[{$timestamp}] IP: {$ip} | User ID: [{$username}:{$password}] => {$status} | Agent: {$userAgent}\n";

		file_put_contents($log_path, $log_message, FILE_APPEND);
	}
}
