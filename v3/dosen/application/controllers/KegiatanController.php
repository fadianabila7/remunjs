<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KegiatanController extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->model('OperatorModel');
		$this->load->model('KegiatanModel');		
		$this->load->model('DosenModel');
		$this->load->library('excel');
		if(!$this->session->userdata('sess_dosen')){
			redirect('VerifyLogin','refresh');
		}
	}

	public function RiwayatKegiatan($jenis){
		$session_data = $this->session->userdata('sess_dosen');
		$data = array('datasession' => $session_data );
		$datakirim = array();
		$dataarray = array('jenis'=>$jenis);
		//array_push($datakirim, $dataarray);
		$row['nip'] = $session_data['idDosen'];
		$datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
		$data['menuextend'] = @$datajabatan[0]['id_jabatan_struktural'];
		
		$this->template->view('template/riwayatkegiatan',$data,$dataarray);
	}

	public function RekapKegiatan(){
		$session_data = $this->session->userdata('sess_dosen');
		$data = array('datasession' => $session_data );

		$session_data = $this->session->userdata('sess_dosen');
		$row['nip'] = $session_data['idDosen'];
		$datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
		$data['menuextend'] = @$datajabatan[0]['id_jabatan_struktural'];
		$this->template->view('template/rekapkegiatan',$data,NULL);
	}

	public function DaftarKegiatan(){
		$session_data = $this->session->userdata('sess_dosen');
		$data = array('datasession' => $session_data );
		$row['nip'] = $session_data['idDosen'];
		$datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
		$data['menuextend'] = @$datajabatan[0]['id_jabatan_struktural'];

		$this->template->view('template/daftarkegiatan',$data,NULL);
	}

	public function getDaftarKegiatan()
	{

		$session_data = $this->session->userdata('sess_dosen');
		$data['jenis'] = $_GET['jenis'];
		$datakegiatan = $this->KegiatanModel->getKegiatanByJenis($data);
		echo json_encode($datakegiatan);
	}

	public function updateNilaiPenunjang()
	{
		$session_data = $this->session->userdata('sess_dosen');
					
		$jumlah = count($_POST['nip']);
		for($i=0;$i<$jumlah;$i++)
		{
			$data['id_keg_dosen'] = $_POST['id_keg_dosen'][$i];
			$datakegiatan = $this->KegiatanModel->getKegiatanDosenByIDKegiatan($data);
			$deskripsiold = json_decode($datakegiatan[0]['deskripsi'],true);
			$deskripsinew = array(
				'judul' => $deskripsiold['judul'],
				'tgl_sk' => $deskripsiold['tgl_sk'],
				'nilai' => $_POST['nilai'][$i],
				'posisi' => $deskripsiold['posisi'],
				);
			$data['deskripsi'] = json_encode($deskripsinew);

			$res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByIDKegiatan($data);
		}
	}

	public function getDataKegiatanByNoSK()
	{
		$data['no_sk'] = $_GET['no_sk'];
		
		$datakegiatan = $this->KegiatanModel->getSKNoSK($data);
		$deskripsi = array();
		$datakirim = array();
		foreach($datakegiatan as $row)
		{
			$data['nip'] = $row['id_dosen'];
			$datadosen = $this->DosenModel->getDataDosen($data);
			$data['kode_kegiatan'] = $row['kode_kegiatan'];
			$kegiatan = $this->KegiatanModel->getKegiatanByKodeKegiatan($data);
			$deskripsi = json_decode($row['deskripsi'],true);

			$dataarray = array(
				'nama_dosen' => $datadosen[0]['nama'],
				'nip' => $row['id_dosen'],
				'kode_keg' => $row['kode_kegiatan'],
				'nama_keg' => $kegiatan[0]['nama'],
				'judul_keg' => $deskripsi['judul'],
				'no_sk' => $data['no_sk'],
				'tgl_sk' => $deskripsi['tgl_sk'],
				'tgl_keg' => $row['tanggal_kegiatan'],
				'nilai' => $deskripsi['nilai'],
				'id_keg_dosen' => $row['id_kegiatan_dosen'],
				);

			array_push($datakirim, $dataarray);
		}

		echo json_encode($datakirim);

	}

	public function getKegiatanDosenJenisBulanTahun(){
		$data['bulan'] = $_POST['bulan'];
		$data['tahun'] = $_POST['tahun'];
		$data['jenis'] = $_POST['jenis'];
		$data['id_kegiatan'] = $_POST['id_kegiatan'];
		$session_data = $this->session->userdata('sess_dosen');
		$data['nip'] = $session_data['idDosen'];
		$datakirim = array();
		
		$res = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);

		foreach($res as $row){
			$namakegiatan = array();
			$kode['kode_kegiatan'] = $row['kode_kegiatan'];
			
			while ($kode['kode_kegiatan']!=0){
				$datakegiatan = $this->KegiatanModel->getKegiatanByKodeKegiatan($kode);
				$kode['kode_kegiatan'] = $datakegiatan[0]['induk'];
				array_push($namakegiatan, $datakegiatan[0]['nama']);
			}

			$jlh_nama_keg = count($namakegiatan);
			$jlh_nama_keg = $jlh_nama_keg - 1;
			$nama_keg_string = "";
			
			for($i=$jlh_nama_keg;$i>=0;$i--){
				$nama_keg_string = $nama_keg_string.$namakegiatan[$i]."#";
			}

			$deskripsi = json_decode($row['deskripsi'],true);
			switch ($data['jenis']) {
				case '1':
					$descstring = '';
					$jKeg = $row['sks'];
					break;
				case '2':
					$descstring = $deskripsi['judul_penelitian'];
					$jKeg = 1;
					break;
				case '4':
					$descstring = $deskripsi['judul'];
					$jKeg = ($deskripsi['keg_perbln']=='0') ? $deskripsi['dari'] : '1';
					$jKeg += $row['bobot_sks']*$jKeg;
					break;
				default:
					$descstring = $deskripsi['judul'];
					$jKeg = 1;
					break;
			}
			$posisi = "";
			$perubahan=json_decode($row['deskripsi'], true);
			$pathberkas = "";
			$dataarray = array(
				'id_user' => $row['id_user'],
				'tanggal_kegiatan' => $row['tanggal_kegiatan'],
				'kode_kegiatan' => $row['kode_kegiatan'],
				'bobot_sks' => $row['bobot_sks'],
				//'sks' => $row['sks'],
				'sks' => $jKeg,  
				'deskripsi' => $descstring,
				'deskripsi2' => $perubahan,
				// 'deskripsi2' => @$perubahan['deskripsi'],
				'posisi' => $posisi,
				'no_sk_kontrak' => $row['no_sk_kontrak'],
				'nama_keg' => $nama_keg_string,
				'path_berkas' => $pathberkas,
				);
			array_push($datakirim, $dataarray);
		}
		echo json_encode($datakirim);
	}

	public function getDataRekapKegiatanBulanTahun() {
	    $session_data = $this->session->userdata('sess_dosen');
	    $data['nip'] = $session_data['idDosen'];
	    $maksbulan = $_GET['bulan'];
	    $data['tahun'] = $_GET['tahun'];
	    $totalsksarr = array();
	    $datakirim = array();
	    $grandtotalsks = 0;
	    $grandtotalsksgaji = 0;
	    $grandtotalskskinerja = 0;
	    $grandtotalskssisa = 0;

	    for ($i = 1; $i <= $maksbulan; $i++) {
	        $data['bulan'] = $i;

			$totalsks = $this->MainModel->getTotalSKSPerBulanBukanJ4($data);
			$totalsks2 = $this->MainModel->getTotalSKSPerBulanJ4($data);
			$skssementara = 0;
	        $sisasksbayar = 0;
	        $lebihsksbayar = 0;

	        $datastruktural = $this->StrukturalModel->getStrukturalByTMT($data);
	        $datafungsional = $this->FungsionalModel->getFungsionalByTMT($data);

	        if ($datafungsional != null) {
	            $sksr_kinerja = $datafungsional[0]['sksr_maks_kinerja'];
	            $sksr_gaji = $datafungsional[0]['sksr_maks_gaji'];
	        } else {
	            $sksr_kinerja = 0;
	            $sksr_gaji = 0;
	        }
	        //if(isset($datastruktural))
	        if(count($datastruktural) > 0) {
	            $sksr_tugas_tambahan = $datastruktural[0]['bobot_sksr'];
	            $namastruktural = $datastruktural[0]['nama'];
	        }else{
	            $sksr_tugas_tambahan = 0;
	            $namastruktural = '';
	        }


	        if (count($totalsks) > 0 || count($totalsks2) > 0) {
	            foreach($totalsks2 as $dataloop) {
	                $d = json_decode($dataloop['deskripsi'], true);
	                // $jKeg = ($dataloop['keg_bulanan'] == '0') ? $d['dari'] : '1';
	                $jKeg = ($dataloop['keg_bulanan'] == '0') ? ((!isset($d['dari']))? '1':$d['dari']) : '1';
	                $skssementara += $dataloop['bobot_sks'] * $jKeg;
	            }

	            $total_sks = @$totalsks[0]['total_sks'] + @$skssementara + $sksr_tugas_tambahan;
	        } else {
	            $total_sks = $sksr_tugas_tambahan;
	        }

	        $sks_remun = $total_sks;

	        if ($sks_remun >= $sksr_gaji) {
	            $sks_gaji = $sksr_gaji;
	            $sks_remun = $sks_remun - $sks_gaji;
	        } else {
	            $sks_gaji = $sks_remun;
	            $sks_remun = $sks_remun - $sks_gaji;
	        }
	        if ($sks_remun >= $sksr_kinerja) {
	            $sks_kinerja = $sksr_kinerja;
	            $sks_remun = $sks_remun - $sks_kinerja;
	        } else {
	            $sks_kinerja = $sks_remun;
	            $sks_remun = $sks_remun - $sks_kinerja;
	        }

	        $grandtotalsks += $total_sks;
	        $grandtotalsksgaji += $sks_gaji;
	        $grandtotalskskinerja += $sks_kinerja;
	        $grandtotalskssisa += $sks_remun;

	        $dataarray = array(
	            'bulan' => $i,
	            'struktural' => $namastruktural,
	            'totalsks' => number_format($total_sks, 2, ',', '.'),
	            'sksgaji' => number_format($sks_gaji, 2, ',', '.'),
	            'skskinerja' => number_format($sks_kinerja, 2, ',', '.'),
	            'sisasks' => number_format($sks_remun, 2, ',', '.'),
	            'skstt' => number_format($sksr_tugas_tambahan, 2, ',', '.'),
	        );

	        //$totalsksarr += [ $i => $totalsks ];
	        array_push($datakirim, $dataarray);

	    }

	    $dataarray = array(
	        'bulan' => 0,
	        'struktural' => 'Total SKS',
	        'totalsks' => number_format($grandtotalsks, 2, ',', '.'),
	        'sksgaji' => number_format($grandtotalsksgaji, 2, ',', '.'),
	        'skskinerja' => number_format($grandtotalskskinerja, 2, ',', '.'),
	        'sisasks' => number_format($grandtotalskssisa, 2, ',', '.'),
	        'skstt' => number_format(0, 2, ',', '.'),
	    );
	    array_push($datakirim, $dataarray);


	    echo json_encode($datakirim);
	}

	public function ExportRiwayatKegiatan(){
		$data['bulan'] = $_POST['bulan'];
		$data['tahun'] = $_POST['tahun'];
		$data['jenis'] = $_POST['jenis'];
		$session_data = $this->session->userdata('sess_dosen');
		$data['nip'] = $session_data['idDosen'];
		$dataExcel = array();
		
		$result = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
		foreach($result as $res)
		{	
			$data['operator'] = $res['id_user'];
			if($data['jenis'] == '4' || $data['jenis'] == '5'){
				$dataoperator = $this->OperatorModel->getDataAdmin($data);
				$operator = $dataoperator[0]['nama'];
				$prodi = $dataoperator[0]['namafakultas'];
			}else{
				$dataoperator = $this->OperatorModel->getDataOperator($data);
				$operator = $dataoperator[0]['nama'];
				$prodi = $dataoperator[0]['namaprodi'].'('.$dataoperator[0]['singkatan'].')';
			}

			$dataarray = array(
					'id_operator' => $data['operator'],
					'operator' => $operator,
					'prodi' => $prodi,
					'tglkegiatan' => $res['tanggal_kegiatan'],
					'kodekegiatan' => $res['kode_kegiatan'],
					'namakegiatan' => $res['namakegiatan'],
					'bobotsks' => $res['bobot_sks'],
					'sks' => $res['sks'],
					'jumlah' => $res['sks']*$res['bobot_sks'],
					'deskripsi' => $res['deskripsi'],
					'skkontrak' => $res['no_sk_kontrak'],
					'tglentry' => $res['tanggal_entry']
				);

			array_push($dataExcel, $dataarray);

		}

		$nama_bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle($data['nip']);

		$this->setDataExportKegiatanToExcel($objPHPExcel, $dataExcel);

		$filename="rekap_kegiatan_dosen_".$nama_bulan[$data['bulan']]."_".$data['tahun']."_".$session_data['name'].".xlsx";
		/*header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0');*/

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
		
		$path = "assets/files/".$data['tahun'];

	    if(!is_dir($path)) //create the folder if it's not already exists
	    {
	      mkdir($path,0755,TRUE);
	    }
		$urlsave = $path.'/'.$filename;
		$objWriter->save($urlsave);
		echo $urlsave;
	}


	public function setDataExportKegiatanToExcel($objPHPExcel, $dataExcel){
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A1','DAFTAR KEGIATAN DOSEN');

		$objPHPExcel->getActiveSheet()
		    ->getStyle('A1')
		    ->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()
		    ->getStyle('A1')
		    ->getFont()->setSize(16);

		$rowCount = 4; 

		$objPHPExcel->getActiveSheet()
		    ->getStyle("A".$rowCount.":K".$rowCount)
		    ->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()
		    ->getStyle("A".$rowCount.":K".$rowCount)
		    ->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'OPERATOR');
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,"UNIT KERJA/\nPROGRAM STUDI");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'TANGGAL KEGIATAN');
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'NAMA KEGIATAN');
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,'BOBOT SKS');
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,'SKS');
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,'JUMLAH');
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,'DESKRIPSI');
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,'NO SK/KONTRAK');
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,'TANGGAL ENTRY');

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(80);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);

		$obets=0;
		$total_sks=0;
		foreach($dataExcel as $data){
			$rowCount++;
			if($data['id_operator']==null){
				$id_operator = "null";
				$nama_operator="null";
				$nama_prodi = "null";
				$nama_jenjang="null";
			}
			else{
				$id_operator = $data['id_operator'];
				
				$nama_operator=$data['operator'];
				if($data['prodi']==null){
					$nama_prodi = "null";
					
									}
				else{
					$nama_prodi = $data['prodi'];
					
				}
				
			}
			$obets++;
		
			

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $obets);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $nama_operator);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $nama_prodi);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $data['tglkegiatan']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $data['kodekegiatan'].":".$data['namakegiatan']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $data['bobotsks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $data['sks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $data['jumlah']);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $data['deskripsi']);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $data['skkontrak']);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $data['tglentry']);

		}
		$rowCount2=3;
		for($idx='A';$idx<='K';$idx++){
			if($idx=='E'||$idx=='I'||$idx=='J'){
				$objPHPExcel->getActiveSheet()
			    ->getStyle($idx.$rowCount2.":".$idx.$objPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			}
			else{
				$objPHPExcel->getActiveSheet()
			    ->getStyle($idx.$rowCount2.":".$idx.$objPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}

		}
		for($idx='F';$idx<='H';$idx++){
			$objPHPExcel->getActiveSheet()
			    ->getStyle($idx.$rowCount2.":".$idx.$objPHPExcel->getActiveSheet()->getHighestRow())
			    ->getNumberFormat()
				->setFormatCode('0.00');

		}

		//$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount2.':V'.$rowCount)->getAlignment()->setWrapText(true); 
		$objPHPExcel->getActiveSheet()->getStyle('E'.$rowCount2.':E'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$rowCount2.':I'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);

		$objPHPExcel->getActiveSheet()->getStyle('A4:K'.$rowCount)->applyFromArray($styleArray);
		unset($styleArray);
	}

	public function KelasKuliah(){
		$session_data = $this->session->userdata('sess_dosen');
		$data = array('datasession' => $session_data );
		$data['page'] = 'kelas';
		$row['nip'] = $session_data['idDosen'];
		$datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
		$data['menuextend'] = @$datajabatan[0]['id_jabatan_struktural'];
	
		$this->template->view('template/kelaskuliah',$data);

	}

	public function getKelasKuliah(){
		$session_data = $this->session->userdata('sess_dosen');
		$data = array('datasession' => $session_data );
		$row['id_dosen'] = $session_data['idDosen'];
		$row['tahun'] = $_GET['tahun'];
		$row['semester'] = $_GET['semester'];

		$res = $this->KegiatanModel->getKelasKuliah($row);
		echo json_encode($res);
	}


	public function getDetailKelasKuliah(){
   		$session_data = $this->session->userdata('sess_dosen');
   		$id_kelas_kuliah = $_GET['idkk'];
   		
   		$datakirim = array();
   		$dataMengajar = $this->KegiatanModel->get_Kegiatan_Mengajar_By_ID_Kelas_Kuliah($id_kelas_kuliah);

   		$hari = array(1=>"Minggu", 2=>"Senin", 3=>"Selasa", 4=>"Rabu", 5=>"Kamis", 6=>"Jum'at", 7=>"Sabtu");
   		foreach($dataMengajar as $dm)
   		{
   			$deskripsi = json_decode($dm['deskripsi'],true);
   			if(isset($deskripsi['kelas']))
   			{
   				$id_kk = (int)$deskripsi['kelas'];
   				
   				$dataKelasKuliah = $this->KegiatanModel->get_Kelas_Kuliahbyid($id_kk);
   				if($dataKelasKuliah!=null)
   				{
	   				$makul = $dataKelasKuliah[0]['namamatakuliah'];
	   				$harikelas = $hari[$dataKelasKuliah[0]['hari']];
	   				$waktu = $dataKelasKuliah[0]['waktu_mulai'];
	   				$ruang = $dataKelasKuliah[0]['ruang'];
	   			}
	   			else
	   			{
	   				$makul = NULL;
	   				$harikelas = NULL;
	   				$waktu = NULL;
	   				$ruang = NULL;
	   			}
   			}
   			else
   			{
   				$makul = NULL;
   				$harikelas = NULL;
   				$waktu = NULL;
   				$ruang = NULL;
   			}
   			
   			$dataarray = array(
   				'id_kegiatan_dosen'=>$dm['id_kegiatan_dosen'],
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

	public function getTurunan(){
		$id = $_POST['id'];
		$datakegiatan = $this->KegiatanModel->datakegiatan($id);
		echo json_encode($datakegiatan);
	}

	public function update(){
		$session_data       = $this->session->userdata('sess_dosen');
		$data               = array('datasession' => $session_data );
		$data['menuextend'] = $this->menuextend($session_data);
		$data['logupdate']  = json_encode($this->KegiatanModel->logupdate());

		$this->template->view('template/log-update',$data,NULL);
	}

	function menuextend($session_data){
		$datajabatan = $this->StrukturalModel->getStrukturalByIDDosen(array('nip' => $session_data['idDosen']));
		return @$datajabatan[0]['id_jabatan_struktural'];

	}
}