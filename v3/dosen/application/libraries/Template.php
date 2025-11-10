<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template
{
	private $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
	}

	public function viewtable($data)
	{
		$this->ci->load->view('template/dosentabel', $data);
	}

	public function loginpage()
	{
		$this->ci->load->view('template/login');
	}
	public function view($content, $data = NULL, $datacontent = NULL)
	{
		if (!$this->is_ajax()) {
			if (in_array($data['menuextend'], array(138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 156, 157))) {
				$data['menuextend'] = $this->ci->load->view('template/wd1/nav_wd1', null, TRUE); //kajur
			} else if (in_array($data['menuextend'], array(119, 120, 121, 128, 129, 130, 303, 305))) {
				$data['menuextend'] = $this->ci->load->view('template/wd2/nav_wd2', null, TRUE); // wd2
			} elseif ($data['datasession']['idFakultas'] == 11) {
				$data['menuextend'] = ($data['menuextend'] >= 150 and $data['menuextend'] <= 155) ? $this->ci->load->view('template/wd1/nav_wd1', null, TRUE) : '';
			} else {
				$data['menuextend'] = '';
			}

			$template['navigation'] = $this->ci->load->view('template/navigation', $data, TRUE);
			$template['content'] = $this->ci->load->view($content, $datacontent, TRUE);
			$template['nav_header'] = $this->ci->load->view('template/nav_header', NULL, TRUE);
			$this->ci->load->view('template/index', $template);
		} else {
			//$this->ci->load->view($content, $data);
		}
	}

	private function is_ajax()
	{
		return ($this->ci->input->server('HTTP_X_REQUESTED_WITH') &&
			($this->ci->input->server('HTTP_X_REQUESTED_WITH') ==
				'XMLHttpRequest'));
	}
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */