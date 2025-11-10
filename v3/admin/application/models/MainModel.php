<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MainModel extends CI_Model {

	public function getDataFakultasByID($idfakultas)
	{
		$sql = "SELECT * FROM fakultas WHERE id_fakultas = '".$idfakultas."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataFungsional()
	{
		$sql = "SELECT * FROM jabatan_fungsional";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataBank()
	{
		$sql = "SELECT * FROM bank";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataFakultas()
	{
		$sql = "SELECT * FROM fakultas";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataProdi($data)
	{
		if($data==0){
			$sql = "SELECT p.*,j.id_jenjang_pendidikan,j.singkatan,j.nama as namajenjang FROM program_studi p INNER JOIN jenjang_pendidikan j ON p.id_jenjang_pendidikan=j.id_jenjang_pendidikan";
		}else{
			$sql = "SELECT p.*,j.id_jenjang_pendidikan,j.singkatan,j.nama as namajenjang FROM program_studi p INNER JOIN jenjang_pendidikan j ON p.id_jenjang_pendidikan=j.id_jenjang_pendidikan where p.id_fakultas='".$data."'";
		}
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataStatus()
	{
		$sql = "SELECT * FROM status_dosen";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getRiwayat($data)
	{
		if($data['prodi'] == 0)
		{
			if($data['status'] == 0)
			{
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi, f.nama as namafakultas FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen JOIN fakultas f ON p.id_fakultas = f.id_fakultas where p.id_fakultas = '".$data['fakultas']."'";
			}
			else
			{
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi, f.nama as namafakultas FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen JOIN fakultas f ON p.id_fakultas = f.id_fakultas where p.id_fakultas = '".$data['fakultas']."' AND d.id_status_dosen='".$data['status']."'";
			}
		}
		else
		{
			if($data['status']==0)
			{
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi, f.nama as namafakultas FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen JOIN fakultas f ON p.id_fakultas = f.id_fakultas where d.id_program_studi='".$data['prodi']."'";
			}
			else
			{
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi, f.nama as namafakultas FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen JOIN fakultas f ON p.id_fakultas = f.id_fakultas where d.id_program_studi='".$data['prodi']."' AND d.id_status_dosen='".$data['status']."'";
			}
		}
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	//------------------------------------------------------------------------------------------

	public function getTotalSKSPerBulan($data)
	{
		$sql = "SELECT sum(d.sks*k.bobot_sks) as total_sks FROM kegiatan_dosen d JOIN kegiatan k ON d.kode_kegiatan = k.kode_kegiatan WHERE d.id_dosen = '".$data['nip']."' AND MONTH(d.tanggal_kegiatan)='".$data['bulan']."' AND YEAR(d.tanggal_kegiatan)='".$data['tahun']."' and  k.kode_jenis_kegiatan<>4 GROUP by d.id_dosen";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getTotalSKSPerBulanBukanJ4($data){
		$sql = "SELECT sum(d.sks*k.bobot_sks) as total_sks FROM kegiatan_dosen d JOIN kegiatan k ON d.kode_kegiatan = k.kode_kegiatan WHERE d.id_dosen = '".$data['nip']."' AND MONTH(d.tanggal_kegiatan)='".$data['bulan']."' AND YEAR(d.tanggal_kegiatan)='".$data['tahun']."' AND kode_jenis_kegiatan <> '4' GROUP by d.id_dosen";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getTotalSKSPerBulanJ4($data){
		$sql = "SELECT d.sks,k.bobot_sks,d.deskripsi,k.keg_bulanan FROM kegiatan_dosen d JOIN kegiatan k ON d.kode_kegiatan = k.kode_kegiatan WHERE d.id_dosen = '".$data['nip']."' AND MONTH(d.tanggal_kegiatan)='".$data['bulan']."' AND YEAR(d.tanggal_kegiatan)='".$data['tahun']."' AND kode_jenis_kegiatan = '4'";
		$res = $this->db->query($sql);

		return $res->result_array();
	}





	public function getJabStrukturalPerBulanTahun($data)
	{
		$sql = "SELECT r.id_riwayat_jabatan_struktural, r.deskripsi, j.*  FROM riwayat_jabatan_struktural r JOIN jabatan_struktural j ON r.id_jabatan_struktural = j.id_jabatan_struktural WHERE r.tmt < DATE('".$data['tahun']."-".$data['bulan']."-05') AND r.id_dosen = '".$data['nip']."' ORDER BY r.tmt DESC LIMIT 1";
		$res = $this->db->query($sql);

		return $res->result_array();
	}
	public function getJabFungsionalPerBulanTahun($data)
	{
		$sql = "SELECT r.id_riwayat_jabatan_fungsional, j.*  FROM riwayat_jabatan_fungsional r JOIN jabatan_fungsional j ON r.id_jabatan_fungsional = j.id_jabatan_fungsional WHERE r.tmt < DATE('".$data['tahun']."-".$data['bulan']."-05') AND r.id_dosen = '".$data['nip']."' ORDER BY r.tmt DESC LIMIT 1";
		$res = $this->db->query($sql);

		return $res->result_array();
	}
	
}