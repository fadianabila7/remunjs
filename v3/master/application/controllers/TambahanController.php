<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TambahanController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->model('OperatorModel');
		$this->load->model('TambahanModel');

		if($this->session->userdata('sess_master')){			
   			$session_data = $this->session->userdata('sess_master');
   			if($session_data['name']!="root"){
   				redirect("MainControler",'refresh');
   			}
		}else{
			redirect("VerifyLogin",'refresh');
		}
	}


	function index(){
		redirect('', 'refresh');
	}


	function Jurusan(){
   		$session_data = $this->session->userdata('sess_master');
		$data['page'] = 'admin';
		$datafakultas = $this->TambahanModel->getDataFakultas();

		$data = array('datasession' => $session_data, 'fakultas' => $datafakultas );		
		$this->template->view('template/jurusan',$data);

	}


	public function getDaftarJurusan(){
		$data['fakultas'] = $_GET['fakultas'];
   		$datakegiatan = $this->TambahanModel->getProdiByFakultas($data);
   		echo json_encode($datakegiatan);
	}

	public function tambahJurusan(){
		$fakultas = $_POST['fakultas'];
        $namajurusan = $_POST['namajurusan'];
        $singkatan = $_POST['singkatan'];
        
        $data_insert = array(
			'id_jurusan' => '',
			'id_fakultas' => $fakultas,
			'nama' => $namajurusan,
			'singkatan' => $singkatan,
		);

		if(!empty($fakultas) || !empty($namajurusan) || !empty($singkatan)){
            $res = $this->db->insert('jurusan', $data_insert);
		}

        if ($res >= 1) {
            echo "1";
        } else {
            echo "gagal";
        }
	}


	/* Menu Perbaikan */
		public function Perbaikan(){
	   		$session_data = $this->session->userdata('sess_master');
			$data['page'] = 'admin';
			$datafakultas = $this->TambahanModel->getDataFakultas();

			$data = array('datasession' => $session_data, 'fakultas' => $datafakultas );
			$this->template->view('template/perbaikan',$data);
		}

		public function getallsksr16(){
			$data['fakultas'] = $_POST['data'];
			$sksr = $this->perulangan($data);
			echo json_encode($sksr);
		}

		public function perulangan($data){
			$dosen = $this->TambahanModel->dosenFakultas($data);
			$i=0;
			foreach ($dosen as $data){
				$sksr[$i] = $this->TambahanModel->sksr16($data);
				$b7 = $this->TambahanModel->sksr1($data,"7");
				$b8 = $this->TambahanModel->sksr1($data,"8");
				$b9 = $this->TambahanModel->sksr1($data,"9");
				$b6 = $this->TambahanModel->sksr1($data,"6");
				$b10 = $this->TambahanModel->sksr1($data,"10");
				$b11 = $this->TambahanModel->sksr1($data,"11");
				$b12 = $this->TambahanModel->sksr1($data,"12");
				array_push($sksr[$i],$b7,$b8,$b9,$b6,$data->kali,$b10,$b11,$b12,$data->nama);
				$i++;
			}
			return $sksr;
		}
	/* END Menu Perbaikan */
}
