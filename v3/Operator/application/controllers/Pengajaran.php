<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajaran extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		date_default_timezone_set('Asia/Jakarta');
		if (!$this->session->userdata('sess_operator')) {
			redirect("VerifyLogin", 'refresh');
		}
	}


	public function index()
	{
		$session_data = $this->session->userdata('sess_operator');
		$data = array('datasession' => $session_data);
		$data['page'] = 'dashboard';
		$this->template->view('template/infoPengajaran', 'template/nav_pengajaran', $data);
	}


	public function EntryKegiatanDosen()
	{
		$session_data = $this->session->userdata('sess_operator');
		$currentYear = date('Y');
		$currentMonth = date('m');

		$semester = ($currentMonth <= 6) ? 2 : 1;

		$tahun = $currentYear;
		$dataDosen = $this->Db_model->get_Dosen_Mengajar($session_data['id_program_studi'], $tahun, $semester);
		$dataKelasKuliah = $this->Db_model->get_Kelas_Kuliah($session_data['id_program_studi'], $tahun, $semester);
		$namaJurusan = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$data = array('dataDosen' => $dataDosen, 'namaJurusan' => $namaJurusan, 'dataKelasKuliah' => $dataKelasKuliah, 'datasession' => $session_data);
		$data['page'] = 'mengajar';
		$this->template->view('template/dosen_pengajaran', 'template/nav_pengajaran', $data);
	}


	public function ViewDosenMengajar()
	{
		$session_data = $this->session->userdata('sess_operator');
		$id_dosen = $_GET['id_dosen'];
		$data['tahun'] = $_GET['tahun'];
		$semester = $_GET['semester'];

		if ($semester == 1) {
			$data['bulan_awal'] = 7;
			$data['bulan_akhir'] = 12;
		} else {
			$data['bulan_awal'] = 1;
			$data['bulan_akhir'] = 6;
			$data['tahun'] = $data['tahun'];
		}

		$data['id_dosen'] = $id_dosen;
		$data['id_prodi'] = $session_data['id_program_studi'];
		$datakirim = array();
		$dataMengajar = $this->Db_model->get_KegiatanDosen_Mengajar_ByIDDosen_Semester_Tahun($data);
		$hari = array(1 => "Minggu", 2 => "Senin", 3 => "Selasa", 4 => "Rabu", 5 => "Kamis", 6 => "Jum'at", 7 => "Sabtu");

		foreach ($dataMengajar as $dm) {
			$deskripsi = json_decode($dm['deskripsi'], true);

			if (isset($deskripsi['kelas'])) {
				$id_kk = (int)$deskripsi['kelas'];
				$dataKelasKuliah = $this->Db_model->get_Kelas_Kuliahbyid($id_kk);

				if ($dataKelasKuliah != null) {
					$makul = $dataKelasKuliah[0]['namamatakuliah'];
					$harikelas = $hari[$dataKelasKuliah[0]['hari']];
					$waktu = $dataKelasKuliah[0]['waktu_mulai'];
					$ruang = $dataKelasKuliah[0]['ruang'];
				} else {
					$makul = NULL;
					$harikelas = NULL;
					$waktu = NULL;
					$ruang = NULL;
				}
			} else {
				$makul = NULL;
				$harikelas = NULL;
				$waktu = NULL;
				$ruang = NULL;
			}

			$dataarray = array(
				'id_kegiatan_dosen' => $dm['id_kegiatan_dosen'],
				'operator' => $dm['id_user'],
				'tgl_entry' => $dm['tanggal_entry'],
				'tgl_kegiatan' => $dm['tanggal_kegiatan'],
				'makul' => $makul,
				'hari' => $harikelas,
				'waktu' => $waktu,
				'ruang' => $ruang,
			);
			array_push($datakirim, $dataarray);
		}
		echo json_encode($datakirim);
	}


	public function ViewDosenMengajarByIDKelasKuliah()
	{
		$session_data = $this->session->userdata('sess_operator');
		$id_kelas_kuliah = $_GET['idkk'];

		$datakirim = array();
		$dataMengajar = $this->Db_model->get_Kegiatan_Mengajar_By_ID_Kelas_Kuliah($id_kelas_kuliah);

		$hari = array(1 => "Minggu", 2 => "Senin", 3 => "Selasa", 4 => "Rabu", 5 => "Kamis", 6 => "Jum'at", 7 => "Sabtu");
		foreach ($dataMengajar as $dm) {
			$deskripsi = json_decode($dm['deskripsi'], true);

			if (isset($deskripsi['kelas'])) {
				$id_kk = (int)$deskripsi['kelas'];
				$dataKelasKuliah = $this->Db_model->get_Kelas_Kuliahbyid($id_kk);

				if ($dataKelasKuliah != null) {
					$makul = $dataKelasKuliah[0]['nama_matakuliah'];
					$harikelas = $hari[$dataKelasKuliah[0]['hari']];
					$waktu = $dataKelasKuliah[0]['waktu_mulai'];
					$ruang = $dataKelasKuliah[0]['ruang'];
				} else {
					$makul = NULL;
					$harikelas = NULL;
					$waktu = NULL;
					$ruang = NULL;
				}
			} else {
				$makul = NULL;
				$harikelas = NULL;
				$waktu = NULL;
				$ruang = NULL;
			}

			$dataarray = array(
				'id_kegiatan_dosen' => $dm['id_kegiatan_dosen'],
				'operator' => $dm['id_user'],
				'tgl_entry' => $dm['tanggal_entry'],
				'tgl_kegiatan' => $dm['tanggal_kegiatan'],
				'makul' => $makul,
				'hari' => $harikelas,
				'waktu' => $waktu,
				'ruang' => $ruang,
			);
			array_push($datakirim, $dataarray);
		}
		echo json_encode($datakirim);
	}

	public function DeleteKegiatanDosenMengajar()
	{
		$session_data      = $this->session->userdata('sess_operator');
		$id_kegiatan_dosen = $_POST['id_kegiatan_dosen'];
		$res               = $this->Db_model->delete_KegiatanDosen_Mengajar_ByIDKegiatan($id_kegiatan_dosen);
	}


	/*public function InsertKegiatanDosenMengajar()
	{
		if($this->session->userdata('sess_operator'))
		{
		 $session_data = $this->session->userdata('sess_operator');
		 $id_dosen = $_POST['id_dosen'];
         $id_kelaskuliah = $_POST['id_mk'];
         $tgl_kegiatan = $_POST['tgl_kegiatan'];
         $tanggal =  explode("/", $tgl_kegiatan);
		 $tgl_kegiatan = $tanggal[2]."-".$tanggal[0]."-".$tanggal[1];
         $id_operator = $session_data['name'];
         $deskripsi = $_POST['deskripsi'];

         $data = $this->db->query('select no_sk_kontrak, sks_pertemuan, jumlah_peserta, kode_kegiatan, id_program_studi from kelas_kuliah where id_dosen='.$id_dosen.' and id_kelas_kuliah='.$id_kelaskuliah);


		$dataArr = $data->result_array();
		foreach ($dataArr as $key) {

			$sks = $key['sks_pertemuan'];
			$no_sk_kontrak = $key['no_sk_kontrak'];
			$kode_kegiatan = $key['kode_kegiatan'];
			$id_prodi = $key['id_program_studi'];
		}
		$datadeskripsi = array(
			'kelas' => $id_kelaskuliah,
			'deskripsi' =>$deskripsi,

			);

         $tanggal = date("Y-m-d H:i:s");

         $data_insert = array(

				'tanggal_entry' => $tanggal,
				'id_user' => $id_operator,
				'id_dosen' => $id_dosen,
				'id_program_studi' => $id_prodi,
				'tanggal_kegiatan' => $tgl_kegiatan,
				'kode_kegiatan' => $kode_kegiatan,
				'sks' => $sks,
				'deskripsi' => json_encode($datadeskripsi),
				'no_sk_kontrak' =>$no_sk_kontrak,

			);

		try{
		$res = $this->db->insert('kegiatan_dosen',$data_insert);
		echo $res;
		}catch (Exception $e){
			echo "aa";
		}

		}
		else
		{
			redirect("VerifyLogin",'refresh');
		}


	}*/

	public function NewInsertKegiatanDosenMengajar()
	{
		$session_data = $this->session->userdata('sess_operator');

		$id_kelaskuliah = $_POST['id_kk'];
		$tgl_kegiatan = $_POST['tgl_kegiatan'];
		// $tanggal =  explode("/", $tgl_kegiatan);
		// $tgl_kegiatan = $tanggal[2]."-".$tanggal[0]."-".$tanggal[1];
		$deskripsi = str_replace(array("'", "\"", "&quot;"), " ", htmlspecialchars($_POST['deskripsi']));
		$data = $this->db->query('select * from kelas_kuliah where id_kelas_kuliah=' . $id_kelaskuliah);

		$dataArr = $data->result_array();
		foreach ($dataArr as $key) {
			$id_dosen = $key['id_dosen'];
			$id_prodi = $key['id_program_studi'];
			$kode_kegiatan = $key['kode_kegiatan'];
			$sks = $key['sks_pertemuan'];
			$no_sk_kontrak = $key['no_sk_kontrak'];
		}

		$datadeskripsi = array('kelas' => $id_kelaskuliah, 'deskripsi' => $deskripsi);
		date_default_timezone_get('Asia/Jakarta');
		$id_operator = $session_data['name'];
		$tanggal = date("Y-m-d H:i:s");

		$data_insert = array(
			'tanggal_entry' => $tanggal,
			'id_user' => $id_operator,
			'id_dosen' => $id_dosen,
			'id_program_studi' => $id_prodi,
			'tanggal_kegiatan' => $tgl_kegiatan,
			'kode_kegiatan' => $kode_kegiatan,
			'sks' => $sks,
			'deskripsi' => json_encode($datadeskripsi),
			'no_sk_kontrak' => $no_sk_kontrak,
		);

		try {
			$res = $this->db->insert('kegiatan_dosen', $data_insert);
			echo $res;
		} catch (Exception $e) {
			echo "aa";
		}
	}

	public function do_insertMembimbingTa()
	{
		date_default_timezone_get('Asia/Jakarta');
		$session_data  = $this->session->userdata('sess_operator');
		$input         = $this->input->post();
		$id_dosen      = $input['id_dosen'];
		$kode_kegiatan = $input['kode_kegiatan'];
		$tgl_kegiatan  = $input['tanggalKegiatan'];
		// $ptanggal      = explode("-", $tgl_kegiatan);
		$deskripsi     = str_replace(array("'", "\"", "&quot;"), " ", htmlspecialchars($input['deskripsi']));
		$deskripsi     = preg_replace("/\s+/", " ", $deskripsi);
		$no_sk_kontrak = $input['no_sk_kontrak'];
		$id_operator   = $session_data['name'];

		$tanggal       = date("Y-m-d H: i: s");
		$jml_bulan     = $input['jml_bulan'];
		$dUuid         = $this->db->query("select UUID_SHORT() as uuid")->result_array();

		// if (!$id_dosen == "" && !$deskripsi == "") {
		// 	for ($x = 0; $x < $jml_bulan; $x++) {
		// 		if (($ptanggal[1] + $x) > 12) {
		// 			$thn = $ptanggal[0] + 1;
		// 			$bln = ($ptanggal[1] + $x) - 12;
		// 		} else {
		// 			$bln = $ptanggal[1] + $x;
		// 			$thn = $ptanggal[0];
		// 		}
		// 		if ($ptanggal[2] >= 25) {
		// 			$ptanggal[2] = '25';
		// 		}
		// 		//$tgl_kegiatan = $ptanggal[2]."-".($ptanggal[0]+$x)."-".$ptanggal[1];

		// 		$dDeskripsi = array(
		// 			'nama' => $deskripsi,
		// 			'bln_ke' => ($x + 1),
		// 			'dari'	 => $jml_bulan,
		// 			'tgl_mulai' => $ptanggal[0] . "-" . $ptanggal[1] . "-" . $ptanggal[2],
		// 			'uuid_bimbing' => $dUuid[0]['uuid']
		// 		);

		// 		$tgl_kegiatan = $thn . "-" . $bln . "-" . $ptanggal[2];
		// 		$data_insert = array(
		// 			'tanggal_entry' => $tanggal,
		// 			'id_user' => $id_operator,
		// 			'id_dosen' => $id_dosen,
		// 			'tanggal_kegiatan' => $tgl_kegiatan,
		// 			'kode_kegiatan' => $kode_kegiatan,
		// 			'id_program_studi' => $session_data['id_program_studi'],
		// 			'sks' => 1,
		// 			'deskripsi' => json_encode($dDeskripsi),
		// 			'no_sk_kontrak' => $no_sk_kontrak,
		// 		);
		// 		//print_r($data_insert);exit;
		// 		$res = $this->db->insert('kegiatan_dosen', $data_insert);
		// 	}
		// 	echo ($res >= 1) ? "1" : "gagal";
		// } else {
		// 	echo "Pilih NIP & Nama dosen dan pastikan deskripsi terisi dengan baik.";
		// }

		$tgl_kegiatan_str = $input['tanggalKegiatan']; // Mengambil string tanggal dari input

		// Pastikan $id_dosen dan $deskripsi tidak kosong
		if (!empty($id_dosen) && !empty($deskripsi)) {
			// Inisialisasi objek DateTime dari tanggal input
			try {
				$date = new DateTime($tgl_kegiatan_str);
			} catch (\Exception $e) {
				// Handle error jika format tanggal tidak valid
				echo "Format tanggal kegiatan tidak valid.";
				return;
			}

			// Koreksi hari menjadi 25 jika lebih besar dari 25
			if ((int)$date->format('d') > 25) {
				$date->setDate((int)$date->format('Y'), (int)$date->format('m'), 25);
			}

			$all_insert_successful = true; // Flag untuk melacak keberhasilan semua insert

			for ($x = 0; $x < $jml_bulan; $x++) {
				// Klon objek DateTime agar tidak memodifikasi objek asli
				$currentDate = clone $date;
				$currentDate->modify("+$x months"); // Tambahkan bulan sebanyak iterasi

				// Format tanggal kegiatan untuk database
				$tanggal_kegiatan_formatted = $currentDate->format('Y-m-d');

				// Data deskripsi yang akan di-encode ke JSON
				$dDeskripsi = array(
					'nama'         => $deskripsi,
					'bln_ke'       => ($x + 1),
					'dari'         => $jml_bulan,
					'tgl_mulai'    => $date->format('Y-m-d'), // Tanggal mulai original
					'uuid_bimbing' => $dUuid[0]['uuid'] // Pastikan $dUuid sudah terdefinisi dan memiliki indeks 0
				);

				// Data untuk di-insert ke tabel kegiatan_dosen
				$data_insert = array(
					'tanggal_entry'    => $tanggal, // Asumsi $tanggal sudah didefinisikan (misal: date('Y-m-d'))
					'id_user'          => $id_operator, // Asumsi $id_operator sudah didefinisikan
					'id_dosen'         => $id_dosen,
					'tanggal_kegiatan' => $tanggal_kegiatan_formatted, // Tanggal kegiatan untuk iterasi saat ini
					'kode_kegiatan'    => $kode_kegiatan, // Asumsi $kode_kegiatan sudah didefinisikan
					'id_program_studi' => $session_data['id_program_studi'], // Asumsi $session_data sudah ada
					'sks'              => 1,
					'deskripsi'        => json_encode($dDeskripsi),
					'no_sk_kontrak'    => $no_sk_kontrak, // Asumsi $no_sk_kontrak sudah didefinisikan
				);

				// Lakukan insert ke database
				$res = $this->db->insert('kegiatan_dosen', $data_insert);

				// Periksa apakah insert gagal
				if (!$res) {
					$all_insert_successful = false; // Set flag ke false jika ada satu insert yang gagal
					// Opsional: Anda bisa log error database di sini
					log_message('error', 'Gagal insert data kegiatan dosen: ' . $this->db->error()['message']);
					break; // Hentikan loop jika ada yang gagal
				}
			}

			// Tampilkan pesan berdasarkan hasil semua insert
			if ($all_insert_successful) {
				echo "1"; // Semua insert berhasil
			} else {
				echo "gagal"; // Ada setidaknya satu insert yang gagal
			}
		} else {
			echo "ID Dosen atau Deskripsi tidak boleh kosong."; // Tambahkan pesan jika kondisi awal tidak terpenuhi
		}
	}


	public function do_ubahMembimbingTa()
	{
		$session_data = $this->session->userdata('sess_operator');
		$temp = $_POST['temp_id_kegiatan_dosen'];
		$jml_bulanUbah = $_POST['jml_bulanUbah'];
		$ptanggal = explode('-', $_POST['tgl_kegiatanubah']);
		$deskripsi = str_replace(array("'", "\"", "&quot;"), " ", htmlspecialchars($_POST['deskripsiubah']));

		$data['id_user'] = $session_data['name'];
		$data['id_dosen'] = $_POST['id_dosenubah'];
		$data['id_program_studi'] = $session_data['id_program_studi'];
		$data['kode_kegiatan'] = $_POST['kode_kegiatanubah'];
		$data['sks'] = 1;
		$data['no_sk_kontrak'] = $_POST['no_sk_kontrakubah'];

		date_default_timezone_get('Asia/Jakarta');
		$data['tanggal_entry'] = date("Y-m-d H:i:s");
		$dUuid = $this->db->query("select UUID_SHORT() as uuid")->result_array();

		try {
			// penghapusan awal
			$idx = explode('#', $temp);
			$session_data = $this->session->userdata('sess_operator');
			$dx = $this->Db_model->get_Membimbing_TaByKode($idx);
			$dy = $this->Db_model->get_where_membimbing($dx[0]);

			for ($ndy = 0; $ndy < count($dy); $ndy++) {
				$this->db->delete('kegiatan_dosen', array('id_kegiatan_dosen' => $dy[$ndy]['id_kegiatan_dosen']));
			}
			// end penghapusan awal

			// input ulang
			for ($x = 0; $x < $jml_bulanUbah; $x++) {

				if (($ptanggal[1] + $x) > 12) {
					$thn = $ptanggal[0] + 1;
					$bln = ($ptanggal[1] + $x) - 12;
				} else {
					$bln = $ptanggal[1] + $x;
					$thn = $ptanggal[0];
				}

				if ($ptanggal[2] >= 25) {
					$ptanggal[2] = '25';
				}
				$data['tanggal_kegiatan'] = $thn . "-" . $bln . "-" . $ptanggal[2];
				$data['deskripsi'] = json_encode(
					array(
						'nama' => $deskripsi,
						'bln_ke' => ($x + 1),
						'dari'	 => $jml_bulanUbah,
						'tgl_mulai' => $ptanggal[0] . "-" . $ptanggal[1] . "-" . $ptanggal[2],
						'uuid_bimbing' => $dUuid[0]['uuid'],
					)
				);

				$res = $this->db->insert('kegiatan_dosen', $data);
			}
			echo "1";
		} catch (Exception $e) {
			echo 0;
		}
	}


	public function do_ubahMembimbingPa()
	{
		$session_data = $this->session->userdata('sess_operator');
		$id_dosen = $_POST['id_dosenubah'];
		$temp_id_kegiatan_dosen = $_POST['temp_id_kegiatan_dosen'];
		$kode_kegiatan = $_POST['kode_kegiatanubah'];
		$tgl_kegiatan = $_POST['tgl_kegiatanubah'];
		$tanggal =  explode("/", $tgl_kegiatan);
		$tgl_kegiatan = $tanggal[2] . "-" . $tanggal[0] . "-" . $tanggal[1];
		$sks = $_POST['sksubah'];
		$deskripsi['deskripsi'] = str_replace(array("'", "\"", "&quot;"), " ", htmlspecialchars($_POST['deskripsiubah']));
		$no_sk_kontrak = $_POST['no_sk_kontrakubah'];
		$id_operator = $session_data['name'];
		date_default_timezone_get('Asia/Jakarta');
		$tanggal = date("Y-m-d H:i:s");

		$data_insert = array(
			'tanggal_entry' => $tanggal,
			'id_operator' => $id_operator,
			'id_dosen' => $id_dosen,
			'tanggal_kegiatan' => $tgl_kegiatan,
			'kode_kegiatan' => "37",
			'id_program_studi' => $session_data['id_program_studi'],
			'sks' => $sks,
			'deskripsi' => json_encode($deskripsi),
			'no_sk_kontrak' => $no_sk_kontrak,
			'tarif' => '0',
			'id_pembayaran' => '0',
		);

		try {

			$this->db->where('id_kegiatan_dosen', $temp_id_kegiatan_dosen);
			$this->db->update('kegiatan_dosen', $data_insert);
			//echo $this->db->_error_message();
			echo "1";
		} catch (Exception $e) {
			echo "aa";
		}
	}


	public function do_ubahMengujiTa()
	{
		$session_data = $this->session->userdata('sess_operator');
		$id_dosen = $_POST['id_dosenubah'];
		$temp_id_kegiatan_dosen = $_POST['temp_id_kegiatan_dosen'];
		$kode_kegiatan = $_POST['kode_kegiatanubah'];
		$tgl_kegiatan = $_POST['tgl_kegiatanubah'];

		$deskripsi['deskripsi'] = str_replace(array("'", "\"", "&quot;"), " ", htmlspecialchars($_POST['deskripsiubah']));
		$no_sk_kontrak = $_POST['no_sk_kontrakubah'];
		$id_operator = $session_data['name'];
		date_default_timezone_get('Asia/Jakarta');
		$tanggal = date("Y-m-d H:i:s");

		$data_insert = array(
			'tanggal_entry' => $tanggal,
			'id_user' => $id_operator,
			'id_dosen' => $id_dosen,
			'tanggal_kegiatan' => $tgl_kegiatan,
			'kode_kegiatan' => $kode_kegiatan,
			'id_program_studi' => $session_data['id_program_studi'],
			'deskripsi' => json_encode($deskripsi),
			'no_sk_kontrak' => $no_sk_kontrak,
		);

		try {

			$this->db->where('id_kegiatan_dosen', $temp_id_kegiatan_dosen);
			$this->db->update('kegiatan_dosen', $data_insert);
			//echo $this->db->_error_message();
			echo "1";
		} catch (Exception $e) {
			echo "aa";
		}
	}


	public function do_insertMembimbingPa()
	{

		if ($this->session->userdata('sess_operator')) {
			$session_data = $this->session->userdata('sess_operator');
			$id_dosen = $_POST['id_dosen'];
			$kode_kegiatan = '37';
			$tgl_kegiatan = $_POST['tgl_kegiatan'];
			// $tanggal =  explode("/", $tgl_kegiatan);
			// $tgl_kegiatan = $tanggal[2]."-".$tanggal[0]."-".$tanggal[1];
			// $sks = $_POST['sks'];
			$deskripsi['deskripsi'] = str_replace(array("'", "\"", "&quot;"), " ", htmlspecialchars($_POST['deskripsi']));
			$no_sk_kontrak = $_POST['no_sk_kontrak'];
			$id_operator = $session_data['name'];
			date_default_timezone_get('Asia/Jakarta');
			$tanggal = date("Y-m-d H:i:s");

			$data_insert = array(
				'tanggal_entry' => $tanggal,
				'id_user' => $id_operator,
				'id_dosen' => $id_dosen,
				'tanggal_kegiatan' => $tgl_kegiatan,
				'kode_kegiatan' => $kode_kegiatan,
				'id_program_studi' => $session_data['id_program_studi'],
				'sks' => 1,
				'deskripsi' => json_encode($deskripsi),
				'no_sk_kontrak' => $no_sk_kontrak,
			);

			try {
				$res = $this->db->insert('kegiatan_dosen', $data_insert);
				//echo $this->db->_error_message();
			} catch (Exception $e) {
				echo "aa";
			}

			if ($res >= 1) {
				echo "1";
				//redirect('pengajaran/EntryMataKuliah');
			} else {
				echo "gagal";
				//redirect('pengajaran/tambahmk');
			}
		} else {
			redirect("VerifyLogin", 'refresh');
		}
	}


	public function do_insertMengujiTa()
	{
		$session_data = $this->session->userdata('sess_operator');
		$id_dosen = $_POST['id_dosen'];
		$kode_kegiatan = $_POST['kode_kegiatan'];
		$tgl_kegiatan = $_POST['tgl_kegiatan'];

		$deskripsi['deskripsi'] = str_replace(array("'", "\"", "&quot;"), " ", htmlspecialchars($_POST['deskripsi']));
		$no_sk_kontrak = $_POST['no_sk_kontrak'];
		$id_operator = $session_data['name'];
		date_default_timezone_get('Asia/Jakarta');
		$tanggal = date("Y-m-d H:i:s");

		$data_insert = array(
			'tanggal_entry' => $tanggal,
			'id_user' => $id_operator,
			'id_dosen' => $id_dosen,
			'tanggal_kegiatan' => $tgl_kegiatan,
			'kode_kegiatan' => $kode_kegiatan,
			'id_program_studi' => $session_data['id_program_studi'],
			'sks' => 1,
			'deskripsi' => json_encode($deskripsi),
			'no_sk_kontrak' => $no_sk_kontrak,
		);

		try {
			$res = $this->db->insert('kegiatan_dosen', $data_insert);
			//echo $this->db->_error_message();
		} catch (Exception $e) {
			echo "aa";
		}

		echo ($res >= 1) ? "1" : "gagal";
	}


	public function EntryMataKuliah()
	{
		$session_data = $this->session->userdata('sess_operator');
		$dataMK = $this->Db_model->get_Mata_Kuliah($session_data['id_program_studi']);
		$dataMataKuliah = array();
		foreach ($dataMK as $key) {
			// $jumlahKelas = $this->Db_model->GetJumlahKelasMK($key['id_matakuliah']);
			// $jumlah_kelas = $jumlahKelas[0]['jumlah_kelas'];
			$temp = array(
				'id_matakuliah' => $key['id_matakuliah'],
				'id_program_studi' => $key['id_program_studi'],
				'kode' => $key['kode'],
				'nama' => $key['nama'],
				'sks' => $key['sks'],
				'tahun_kurikulum' => $key['tahun_kurikulum'],
				'status_aktif' => $key['status_aktif'],
				// 'jumlah_kelas' => $jumlah_kelas,
			);
			array_push($dataMataKuliah, $temp);
		}
		$namaJurusan = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$data =  array('dataMataKuliah' => $dataMataKuliah, 'namaJurusan' => $namaJurusan, 'datasession' => $session_data);
		$data['page'] = 'matakuliah';

		$this->template->view('template/EntryMataKuliah', 'template/nav_pengajaran', $data);
	}


	public function tambahmk()
	{
		$session_data = $this->session->userdata('sess_operator');
		$data = array('datasession' => $session_data);
		$this->template->view('template/tambahmk', 'template/nav_pengajaran', $data);
	}


	public function tambahkelaskuliah()
	{
		$session_data = $this->session->userdata('sess_operator');
		$dataKegiatan = $this->Db_model->get_Kegiatan_Mengajar();
		// print_r($dataKegiatan);
		$jenjangPendidikan = $this->Db_model->get_jenjang_pendidikan($session_data['id_program_studi']);
		$data =  array(
			'dataKegiatan' => $dataKegiatan,
			'jenjangPendidikan' => $jenjangPendidikan,
			'datasession' => $session_data
		);
		$this->template->view('template/tambahkelaskuliah', 'template/nav_pengajaran', $data);
	}

	public function EntryKelasKuliah()
	{
		$session_data = $this->session->userdata('sess_operator');
		$currentYear = date('Y');
		$currentMonth = date('m');

		$namaJurusan = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$data =  array('namaJurusan' => $namaJurusan, 'datasession' => $session_data);
		$data['page'] = 'kelaskuliah';
		$this->template->view('template/entryKelasKuliah', 'template/nav_pengajaran', $data);
	}

	public function get_Kelas_Kuliah_filter()
	{
		$session_data = $this->session->userdata('sess_operator');
		$tahun 		= $_POST['tahunajaran'];
		$semester 	= $_POST['semester'];
		$dataagregat = array();
		$dataKelasKuliah = $this->Db_model->get_Kelas_Kuliah($session_data['id_program_studi'], $tahun, $semester);
		foreach ($dataKelasKuliah as $row) {
			$agregat = $this->Db_model->get_Agregat_Kegiatan_Mengajar($row['id_kelaskuliah'], $row['id_dosen'], $row['id_program_studi'], $tahun);
			$jumlah_pertemuan = ($agregat != null) ? $agregat[0]['jumlah_pertemuan'] : 0;
			$dataarray = array(
				'id_kelas_kuliah' => $row['id_kelaskuliah'],
				'jumlah_pertemuan' => $jumlah_pertemuan,
			);
			array_push($dataagregat, $dataarray);
		}
		$datakirim = array('dataKelasKuliah' => $dataKelasKuliah, 'dataAgregat' => $dataagregat);
		echo json_encode($datakirim);
	}

	public function ubahmk($id_matkul)
	{
		$session_data = $this->session->userdata('sess_operator');
		$data = array();
		$dataMataKuliah = $this->Db_model->get_Mata_Kuliahbymatkul($session_data['id_program_studi'], $id_matkul);
		$namaJurusan = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$data =  array('dataMataKuliah' => $dataMataKuliah, 'namaJurusan' => $namaJurusan, 'datasession' => $session_data);
		$this->template->view('template/ubahmatakuliah', 'template/nav_pengajaran', $data);
	}

	public function ubahkelaskuliah($id_kelaskuliah)
	{

		$session_data = $this->session->userdata('sess_operator');
		$dataKegiatan = $this->Db_model->get_Kegiatan_Mengajar();
		$jenjangPendidikan = $this->Db_model->get_jenjang_pendidikan($session_data['id_program_studi']);

		$dataKelasKuliah = $this->Db_model->get_Kelas_Kuliahbyid($id_kelaskuliah);
		//print_r($dataKelasKuliah);
		$data =  array('dataKegiatan' => $dataKegiatan, 'dataKelasKuliah' => $dataKelasKuliah, 'datasession' => $session_data, 'jenjangPendidikan' => $jenjangPendidikan);
		$this->template->view('template/ubahkelaskuliah', 'template/nav_pengajaran', $data);
	}

	public function do_insertmatakuliah()
	{
		$session_data = $this->session->userdata('sess_operator');
		$id_program_studi = $session_data['id_program_studi'];
		$kode_matkul = $_POST['kode_matkul'];
		$namaMatkul = $_POST['namaMatkul'];
		$sks = $_POST['sks'];
		$tahunkurikulum = $_POST['tahunkurikulum'];
		$status = $_POST['status'];

		if (!empty($kode_matkul) && !empty($namaMatkul) && !empty($sks) && !empty($tahunkurikulum) && !empty($status)) {
			$data_insert = array(
				'id_program_studi' => $id_program_studi,
				'kode' => $kode_matkul,
				'nama' => $namaMatkul,
				'sks' => $sks,
				'tahun_kurikulum' => $tahunkurikulum,
				'status_aktif' => $status,
			);
			try {
				$res = $this->db->insert('matakuliah', $data_insert);
			} catch (Exception $e) {
				echo "aa";
			}
		}

		if ($res >= 1) {
			redirect('pengajaran/EntryMataKuliah');
		} else {
			redirect('pengajaran/tambahmk');
		}
	}

	public function GetMembimbingTa()
	{
		$session_data = $this->session->userdata('sess_operator');
		$dataMembimbing = $this->Db_model->get_Membimbing_Ta($session_data['id_program_studi']);
		echo json_encode($dataMembimbing);
	}

	public function GetMembimbingTaByKode()
	{
		if (!empty($_GET['idx'])) {
			$idx = explode('#', $_GET['idx']);
			$session_data = $this->session->userdata('sess_operator');
			$dx = $this->Db_model->get_Membimbing_TaByKode($idx);
			$dy = $this->Db_model->get_where_membimbing($dx[0]);
			for ($i = 0; $i < count($dy); $i++) {
				$deskripsi = json_decode($dy[$i]['deskripsi'], true);
				if ($deskripsi['bln_ke'] == 1) {
					$dz = $this->Db_model->get_Membimbing_Ta_ByID($dy[$i]['id_kegiatan_dosen']);
					echo json_encode($dz[0]);
					break;
				}
			}
		}
	}


	public function EntryMembimbingTa()
	{
		$session_data = $this->session->userdata('sess_operator');
		$dataMembimbing  = $this->Db_model->get_Membimbing_Ta($session_data['id_program_studi']);
		$namaJurusan     = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$dataKegiatan    = $this->Db_model->get_Kegiatan_MembimbingTa();
		$data            = array('namaJurusan' => $namaJurusan, 'dataKegiatan' => $dataKegiatan, 'datasession' => $session_data);
		$data['page']    = 'membimbing';
		$this->template->view('template/dosen_MembimbingTa', 'template/nav_pengajaran', $data);
	}

	public function GetDataMembimbing()
	{
		if (isset($_POST['tahun']) && isset($_POST['id_kegiatan'])) {
			$data['tahun'] = $_POST['tahun'];
			$data['id_kegiatan'] = $_POST['id_kegiatan'];
			$session_data = $this->session->userdata('sess_operator');
			$dataMembimbing = $this->Db_model->get_Membimbing_Ta($session_data['id_program_studi'], $data);
			echo json_encode($dataMembimbing);
		}
	}

	public function GetDataMengujiTA()
	{
		if (isset($_POST['tahun']) && isset($_POST['bulan'])) {
			$data['tahun']  = $_POST['tahun'];
			$data['bulan']  = $_POST['bulan'];
			$session_data   = $this->session->userdata('sess_operator');
			$dataMembimbing = $this->Db_model->get_Menguji_Ta($session_data['id_program_studi'], $data);
			echo json_encode($dataMembimbing);
		}
	}


	public function GetMengujiTa()
	{
		$session_data = $this->session->userdata('sess_operator');
		$data['tahun'] = $_POST['tahun'];
		$data['bulan'] = $_POST['bulan'];
		$dataMenguji = $this->Db_model->get_Menguji_Ta($session_data['id_program_studi'], $data);
		echo json_encode($dataMenguji);
	}

	public function GetMengujiTaUbah()
	{
		$dataMenguji = $this->Db_model->get_Menguji_Taubah($_POST['idx']);
		echo json_encode($dataMenguji);
	}


	public function EntryMengujiTa()
	{
		$session_data = $this->session->userdata('sess_operator');
		$dataDosen = $this->Db_model->get_Dosen($session_data['id_program_studi']);
		$namaJurusan = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$data['tahun'] = date('Y');
		$data['bulan'] = date('m');
		$dataMenguji = $this->Db_model->get_Menguji_Ta($session_data['id_program_studi'], $data);
		$jenjangPendidikan = $this->Db_model->get_jenjang_pendidikan($session_data['id_program_studi']);
		$dataKegiatan = $this->Db_model->get_Kegiatan_MengujiTa();
		$data =  array('dataDosen' => $dataDosen, 'namaJurusan' => $namaJurusan, 'jenjangPendidikan' => $jenjangPendidikan, 'dataKegiatan' => $dataKegiatan, 'datasession' => $session_data, 'dataMenguji' => $dataMenguji);
		$data['page'] = 'menguji';
		$this->template->view('template/dosen_MengujiTa', 'template/nav_pengajaran', $data);
	}


	public function GetLainya()
	{
		$session_data = $this->session->userdata('sess_operator');
		$dataMembimbing = $this->Db_model->get_Lainya($session_data['id_program_studi']);
		echo json_encode($dataMembimbing);
	}


	public function EntryLainya()
	{
		$session_data = $this->session->userdata('sess_operator');
		$dataDosen = $this->Db_model->get_Dosen($session_data['id_program_studi']);
		$dataMembimbing = $this->Db_model->get_Lainya($session_data['id_program_studi']);
		$namaJurusan = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$dataKegiatan = $this->Db_model->get_Kegiatan_Lainya();
		$data =  array('dataKegiatan' => $dataKegiatan, 'dataDosen' => $dataDosen, 'namaJurusan' => $namaJurusan, 'datasession' => $session_data, 'dataMembimbing' => $dataMembimbing);
		$data['page'] = 'membimbingpa';
		$this->template->view('template/dosen_MembimbingPa', 'template/nav_pengajaran', $data);
	}


	public function do_editmatakuliah($id_matkul)
	{
		$session_data = $this->session->userdata('sess_operator');
		$id_program_studi = $session_data['id_program_studi'];
		$kode_matkul = $_POST['kode_matkul'];
		$namaMatkul = $_POST['namaMatkul'];
		$sks = $_POST['sks'];
		$tahunkurikulum = $_POST['tahunkurikulum'];
		$status = $_POST['status'];

		if (!empty($kode_matkul) && !empty($namaMatkul) && !empty($sks) && !empty($tahunkurikulum) && !empty($status)) {
			$data_edit = array(
				'id_program_studi' => $id_program_studi,
				'kode' => $kode_matkul,
				'nama' => $namaMatkul,
				'sks' => $sks,
				'tahun_kurikulum' => $tahunkurikulum,
				'status_aktif' => $status,
			);
			try {
				$this->db->where('id_matakuliah', $id_matkul);
				$this->db->update('matakuliah', $data_edit);
			} catch (Exception $e) {
				echo "aa";
			}
		}
		redirect('pengajaran/EntryMataKuliah');
	}


	public function do_deletematakuliah($id_matkul)
	{
		$d = $this->Db_model->countMatkul($id_matkul);
		if ($d == 0) {
			try {
				$this->db->where('id_matakuliah', $id_matkul);
				$this->db->delete('matakuliah');
			} catch (Exception $e) {
				echo "aa";
			}
			redirect('pengajaran/EntryMataKuliah');
		} else {
			echo "<script>
					var result = confirm('Matakuliah yang dihapus mempunyai $d kelas.\\nData tidak dapat dihapus.');
					if (result) {
					    document.location.href = '" . base_url() . "index.php/pengajaran/EntryMataKuliah'
					}else{
					    document.location.href = '" . base_url() . "index.php/pengajaran/EntryMataKuliah'
					}
				</script>";
		}
	}


	public function do_deletekegiatandosenMembimbing($id_kegiatandosen)
	{
		try {
			$uuid = explode("-", $id_kegiatandosen);
			$this->db->query("delete from kegiatan_dosen where deskripsi like '%\"uuid_bimbing\":\"" . $uuid[1] . "\"%'");
		} catch (Exception $e) {
			echo "aa";
		}
		redirect('pengajaran/EntryMembimbingTa');
	}


	public function do_deletekegiatandosenMembimbingPa($id_kegiatandosen)
	{
		try {
			$this->db->where('id_kegiatan_dosen', $id_kegiatandosen);
			$this->db->delete('kegiatan_dosen');
		} catch (Exception $e) {
			echo "aa";
		}
		redirect('pengajaran/EntryMembimbingPa');
	}


	public function do_deletekegiatandosenMenguji($id_kegiatandosen)
	{
		try {
			$this->db->where('id_kegiatan_dosen', $id_kegiatandosen);
			$this->db->delete('kegiatan_dosen');
		} catch (Exception $e) {
			echo "aa";
		}
		redirect('pengajaran/EntryMengujiTa');
	}


	public function aturKelasKuliah()
	{
		$session_data = $this->session->userdata('sess_operator');
		$dataKelasKuliah = $this->Db_model->get_Kelas_Kuliah($session_data['id_program_studi'], "2016", "2");
		$dataMataKuliah = $this->Db_model->get_Mata_Kuliah($session_data['id_program_studi']);
		$namaJurusan = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$data =  array('dataKelasKuliah' => $dataKelasKuliah, 'namaJurusan' => $namaJurusan, 'dataMataKuliah' => $dataMataKuliah, 'datasession' => $session_data);
		$this->template->view('template/entryKelasKuliah', 'template/nav_pengajaran', $data);
	}


	public function get_namaMatakuliah($namamatakuliah)
	{
		$tabel = $this->Db_model->Get_matakuliahbynama($namamatakuliah);
		echo json_encode($tabel);
	}


	public function get_Dosen_Mengajar_filter()
	{
		$session_data = $this->session->userdata('sess_operator');
		$tahun 		= $_POST['tahunajaran'];
		$semester 	= $_POST['semester'];
		$dataDosen = $this->Db_model->get_Dosen_Mengajar($session_data['id_program_studi'], $tahun, $semester);
		$dataKelasKuliah = $this->Db_model->get_Kelas_Kuliah($session_data['id_program_studi'], $tahun, $semester);
		$tabel  = array('dataDosen' => $dataDosen, 'dataKelasKuliah' => $dataKelasKuliah);
		echo json_encode($tabel);
	}

	public function getKegiatanByInduk()
	{
		$data['induk'] = $_GET['kode'];
		$data['kode_kegiatan'] = $_GET['kode'];
		$datakirim = array();
		$datakegiatan = $this->Db_model->getKegiatanByKodeKegiatan($data);
		if ($datakegiatan[0]['bobot_sks'] == null) {
			$kegiatan = $this->Db_model->getKegiatanByKodeInduk($data);
			echo json_encode($kegiatan);
		} else {
			echo "1";
		}
	}

	public function do_insertkelaskuliah()
	{
		$session_data = $this->session->userdata('sess_operator');
		$id_program_studi = $session_data['id_program_studi'];
		$id_dosen = $_POST['id_dosen'];
		$id_matakuliah = $_POST['id_matakuliah'];
		$kode_kegiatan = $_POST['kegiatan_hidden'];
		$tahun_akademik = date('Y');
		$semester = $_POST['semester'];
		$no_sk_kontrak = $_POST['skkontrak'];
		$hari = $_POST['hari'];
		$waktu_mulai = $_POST['waktu_mulai'];
		$sks_pertemuan = $_POST['sks'];
		$ruang = $_POST['ruangan'];
		$jumlah_peserta = $_POST['jumlah_peserta'];
		$id_operator = $session_data['name'];

		$tanggal = date("Y-m-d H:i:s");
		$data_insert = array(
			'id_program_studi' => $id_program_studi,
			'id_operator' => $id_operator,
			'id_dosen' => $id_dosen,
			'id_matakuliah' => $id_matakuliah,
			'kode_kegiatan' => $kode_kegiatan,
			'tahun_akademik' => $tahun_akademik,
			'semester' => $semester,
			'no_sk_kontrak' => $no_sk_kontrak,
			'hari' => $hari,
			'waktu_mulai' => $waktu_mulai,
			'sks_pertemuan' => $sks_pertemuan,
			'ruang' => $ruang,
			'jumlah_peserta' => $jumlah_peserta,
		);

		try {
			$res = $this->db->insert('kelas_kuliah', $data_insert);
		} catch (Exception $e) {
			echo "aa";
		}

		if ($res >= 1) {
			redirect('pengajaran/EntryKelasKuliah');
		} else {
			redirect('pengajaran/tambahkelaskuliah');
		}
	}


	public function do_editkelaskuliah($id_kelaskuliah)
	{
		$session_data = $this->session->userdata('sess_operator');

		$id_program_studi = $session_data['id_program_studi'];
		$id_dosen = $_POST['id_dosen'];
		$kode_kegiatan = $_POST['kegiatan_hidden'];
		$id_matakuliah = $_POST['id_matakuliah'];
		$tahun_akademik = $_POST['tahunakademik'];
		$semester = $_POST['semester'];
		$no_sk_kontrak = $_POST['skkontrak'];
		$hari = $_POST['hari'];
		$waktu_mulai = $_POST['waktu_mulai'];
		$sks_pertemuan = $_POST['sks'];
		$ruang = $_POST['ruangan'];
		$jumlah_peserta = $_POST['jumlah_peserta'];
		$id_operator = $session_data['name'];
		date_default_timezone_get('Asia/Jakarta');
		$tanggal = date("Y-m-d H:i:s");

		$data_update = array(
			'id_kelaskuliah' => $id_kelaskuliah,
			'id_dosen' => $id_dosen,
			'kode_kegiatan' => $kode_kegiatan,
			'no_sk_kontrak' => $no_sk_kontrak,
			'sks' => $sks_pertemuan,
		);

		$UpdateKegiatanDosen = $this->Db_model->UpdateKegiatanDosenByKelasKuliah($data_update);

		$data_insert = array(
			'id_program_studi' => $id_program_studi,
			'id_operator' => $id_operator,
			'id_dosen' => $id_dosen,
			'id_matakuliah' => $id_matakuliah,
			'kode_kegiatan' => $kode_kegiatan,
			'tahun_akademik' => $tahun_akademik,
			'semester' => $semester,
			'no_sk_kontrak' => $no_sk_kontrak,
			'hari' => $hari,
			'waktu_mulai' => $waktu_mulai,
			'sks_pertemuan' => $sks_pertemuan,
			'ruang' => $ruang,
			'jumlah_peserta' => $jumlah_peserta,
		);

		try {
			$this->db->where('id_kelas_kuliah', $id_kelaskuliah);
			$this->db->update('kelas_kuliah', $data_insert);
			//echo $this->db->;_error_message();
		} catch (Exception $e) {
			echo "aa";
		}
		redirect('pengajaran/EntryKelasKuliah');
	}


	public function do_deletekelaskuliah($id_kelaskuliah)
	{
		try {
			$this->db->where('id_kelas_kuliah', $id_kelaskuliah);
			$this->db->delete('kelas_kuliah');
		} catch (Exception $e) {
			echo "aa";
		}
		redirect('pengajaran/EntryKelasKuliah');
	}

	public function json_search_matakuliah()
	{
		$session_data = $this->session->userdata('sess_operator');
		$id_program_studi = $session_data['id_program_studi'];
		$query  = $this->Db_model->get_Mata_Kuliah($id_program_studi);
		echo json_encode($query);
	}

	public function json_search_dosen()
	{
		$query = $this->Db_model->getDosenAll();
		echo json_encode($query);
	}
}
