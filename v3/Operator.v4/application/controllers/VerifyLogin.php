<?php
class VerifyLogin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		/* $this->load->library('template');
		$this->load->library('session');*/
		$this->load->model('user', '', TRUE);
	}

	function index()
	{
		$data['imgCaptcha'] = $this->fungsi->buat_Captcha();
		$this->template->loginpage($data);
	}

	function cek_login()
	{
		$this->form_validation->set_rules(
			'username',
			'Username',
			'required',
			array('required' => '{field} tidak boleh kosong !')
		);
		$this->form_validation->set_rules(
			'password',
			'Password',
			'required',
			array('required' => '{field} tidak boleh kosong !')
		);

		$this->form_validation->set_rules(
			'captcha',
			'Captcha',
			'trim|callback_check_captcha|required',
			array('required' => '{field} tidak boleh kosong !')
		);

		if ($this->form_validation->run() == FALSE) {
			$errors = validation_errors('<span class="error">', '</span><br />');
			echo json_encode(['error' => $errors]);
		} else {

			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$result   = $this->user->login($username, $password);

			if ($result && $result[0]->id_role == 1) {
				$sess_array = array();
				foreach ($result as $row) {
					$sess_array = array(
						'name' => $row->id_user,
						'idRole' => $row->id_role,
						'id_program_studi' => $row->id_program_studi,
						'id_operator' => $row->id_operator,
						'namaprodi' => $row->namaf,
						'role' => $row->namar,
						'idFakultas' => $row->id_fakultas,

						'namafakultas' => $row->namaf
					);
					$this->session->set_userdata('sess_operator', $sess_array);
				}
				echo json_encode(['success' => 'Successfully.']);
			} else {
				echo json_encode(['error' => 'Username atau Password tidak valid.']);
			}
		}
	}

	function check_database($password)
	{
		$username = $this->input->post('username');
		$result   = $this->user->login($username, md5($password));

		if ($result && $result[0]->id_role == 1) {

			$sess_array = array();
			foreach ($result as $row) {

				$sess_array = array(
					'name' => $row->id_user,
					'idRole' => $row->id_role,
					'id_program_studi' => $row->id_program_studi,
					'id_operator' => $row->id_operator,
					'namaprodi' => $row->namaf,
					'role' => $row->namar,
					'idFakultas' => $row->id_fakultas,

					'namafakultas' => $row->namaf
				);
				$this->session->set_userdata('sess_operator', $sess_array);
			}

			return TRUE;
		} else {
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}




	public function buat_Captcha()
	{
		$this->fungsi->buat_Captcha();
	}

	public function check_captcha()
	{
		if ($this->input->post('captcha') == $this->session->userdata('captchaCode')) {
			return true;
		} else {
			$this->form_validation->set_message('check_captcha', 'Isikan Captcha dengan benar');
			return false;
		}
	}

	public function reload()
	{
		$this->fungsi->refresh_Captcha();
	}
}
