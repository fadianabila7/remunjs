<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class DashboardModel extends CI_Model {

	public function getKegiatanDosenJenisBulanTahun($data){
		
		// $sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' ORDER BY tanggal_kegiatan DESC";
		$this->db->select('kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan');
		$this->db->join('kegiatan k', 'kd.kode_kegiatan = k.kode_kegiatan');
		$this->db->join('jenis_kegiatan j', 'k.kode_jenis_kegiatan = j.kode_jenis_kegiatan');
		$this->db->where('kd.id_dosen', $data['nip']);
		$this->db->where('YEAR(tanggal_kegiatan)', $data['tahun']);
		$this->db->order_by('tanggal_kegiatan DESC');
		
		$this->db->from('kegiatan_dosen PARTITION (p'.$data['tahun'].') kd ');
		// if($data['partition']==true){
		// }else{
		// 	$this->db->from('kegiatan_dosen kd');
		// }

		if($data['bulan']!=0){
			$this->db->where('MONTH(tanggal_kegiatan)', $data['bulan']);
		}

		if($data['jenis']!=0){ // k.kode_jenis_kegiatan='".$data['jenis']."'
			$this->db->where('k.kode_jenis_kegiatan', $data['jenis']);
		}
			
		$res = $this->db->get();
		return $res->result_array();
	}

	public function getDosenFakultas(){
		$sql="SELECT fakultas.id_fakultas,fakultas.singkatan, COUNT(dosen.id_dosen) as total FROM `dosen` join program_studi on dosen.id_program_studi = program_studi.id_program_studi join fakultas on program_studi.id_fakultas = fakultas.id_fakultas GROUP BY fakultas.id_fakultas ORDER BY fakultas.id_fakultas ASC";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getDataFungsional($data){
		$sql= "SELECT jabatan_fungsional.id_jabatan_fungsional, jabatan_fungsional.nama, count(dosen.id_dosen) as total FROM riwayat_jabatan_fungsional join program_studi join jabatan_fungsional join dosen on dosen.id_program_studi = program_studi.id_program_studi and riwayat_jabatan_fungsional.id_dosen = dosen.id_dosen and riwayat_jabatan_fungsional.id_jabatan_fungsional = jabatan_fungsional.id_jabatan_fungsional WHERE program_studi.id_fakultas = '".$data."' and tmt in (select max(tmt) from riwayat_jabatan_fungsional join program_studi join jabatan_fungsional join dosen on dosen.id_program_studi = program_studi.id_program_studi and riwayat_jabatan_fungsional.id_dosen = dosen.id_dosen and riwayat_jabatan_fungsional.id_jabatan_fungsional WHERE program_studi.id_fakultas = '".$data."' group by riwayat_jabatan_fungsional.id_dosen) GROUP BY riwayat_jabatan_fungsional.id_jabatan_fungsional ORDER by riwayat_jabatan_fungsional.id_jabatan_fungsional DESC";
		$res = $this->db->query($sql);
		return $res->result();
	}

	public function getfakultas(){
		$sql="SELECT id_fakultas,singkatan from fakultas";
		$res = $this->db->query($sql);
		return $res->result();
	}

	public function getfungsional(){
		$sql="SELECT id_jabatan_fungsional as ijf, nama as nf from jabatan_fungsional";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getTotalSKSPerBulanBukanJ4($data){
		$sql = "SELECT ps.id_fakultas, sum(cast(replace(kd.sks*k.bobot_sks, ',', '.') as decimal(18,2))) as total_sks 
				FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan 
				JOIN dosen d ON d.id_dosen = kd.id_dosen 
				JOIN program_studi ps ON ps.id_program_studi = d.id_program_studi
				WHERE (MONTH(kd.tanggal_kegiatan)BETWEEN ".$data['between'].") AND YEAR(kd.tanggal_kegiatan)='".$data['tahun']."' AND k.kode_jenis_kegiatan<>'4'
				GROUP BY ps.id_fakultas";
		$res = $this->db->query($sql);
		return $res->result_array();
	}	

	public function getTotalSKSPerBulanJ4($data){
		$sql = "SELECT kd.sks,k.bobot_sks, kd.deskripsi,k.keg_bulanan
				FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan 
				JOIN dosen d ON d.id_dosen = kd.id_dosen
				JOIN program_studi ps ON ps.id_program_studi = d.id_program_studi
				WHERE MONTH(kd.tanggal_kegiatan)='".$data['bulan']."' AND YEAR(kd.tanggal_kegiatan)='".$data['tahun']."' AND kode_jenis_kegiatan='4' AND ps.id_fakultas='".$data['id_fakultas']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getStrukturalByTMT($data){
		$sql = "SELECT ps.id_fakultas,sum(js.bobot_sksr) as bobot_sksr from dosen JOIN program_studi ps ON ps.id_program_studi = dosen.id_program_studi
				JOIN riwayat_jabatan_struktural r ON r.id_dosen = dosen.id_dosen
				JOIN jabatan_struktural js ON r.id_jabatan_struktural = js.id_jabatan_struktural
				WHERE r.tmt < date('".$data['tahun']."-".$data['bulan']."-28')
				and ps.id_fakultas='".$data['id_fakultas']."'
				GROUP BY r.id_dosen order by r.tmt DESC, r.id_riwayat_jabatan_struktural DESC";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getTotalDosen(){
		$sql = "SELECT program_studi.id_fakultas, count(dosen.id_dosen) as total 
				FROM dosen JOIN program_studi ON program_studi.id_program_studi = dosen.id_program_studi
				GROUP BY program_studi.id_fakultas";

		$res = $this->db->query($sql);
		return $res->result_array();
	}
}