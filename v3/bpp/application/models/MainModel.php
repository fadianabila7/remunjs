<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MainModel extends CI_Model {
	

	public function getGolonganByIDDosen($data)
	{
		$sql = "SELECT rg.*, g.* from riwayat_golongan rg JOIN golongan g ON rg.id_golongan = g.id_golongan WHERE rg.id_dosen= '".$data['nip']."' ORDER BY rg.tmt desc";

		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getOperator($data)
	{
		if($data['prodi'] == 0)
		{			
				$sql = "SELECT o.*, p.nama as namaprodi, f.nama as namafakultas FROM operator o JOIN program_studi p ON o.id_program_studi = p.id_program_studi JOIN fakultas f ON p.id_fakultas = f.id_fakultas where p.id_fakultas = '".$data['fakultas']."'";			
		}
		else
		{
			$sql = "SELECT o.*, p.nama as namaprodi, f.nama as namafakultas FROM operator o JOIN program_studi p ON o.id_program_studi = p.id_program_studi JOIN fakultas f ON p.id_fakultas = f.id_fakultas where o.id_program_studi = '".$data['prodi']."'";
		}
		$res = $this->db->query($sql);
		return $res->result_array();
	}
		
	public function getDataProdi($data)
	{
		$sql = "SELECT p.*,j.id_jenjang_pendidikan,j.singkatan,j.nama as namajenjang FROM program_studi p INNER JOIN jenjang_pendidikan j ON p.id_jenjang_pendidikan=j.id_jenjang_pendidikan where p.id_fakultas='".$data."'";
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	public function getDataStatus()
	{
		$sql = "SELECT * FROM status_dosen";
		$res = $this->db->query($sql);
		return $res->result_array();
		
	}

	public function getDataFakultasByID($idfakultas)
	{
		$sql = "SELECT * FROM fakultas WHERE id_fakultas = '".$idfakultas."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	//---------------------------------------------------------------------------

	public function getTotalSKSPerBulan($data)
	{
		$sql = "SELECT sum(d.sks*k.bobot_sks) as total_sks FROM kegiatan_dosen d JOIN kegiatan k ON d.kode_kegiatan = k.kode_kegiatan WHERE d.id_dosen = '".$data['nip']."' AND MONTH(d.tanggal_kegiatan)='".$data['bulan']."' AND YEAR(d.tanggal_kegiatan)='".$data['tahun']."' GROUP by d.id_dosen";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getJabStrukturalPerBulanTahun($data)
	{
		$sql = "SELECT r.id_riwayat_jabatan_struktural, r.deskripsi, j.id_jabatan_struktural, j.nama,j.beban_wajib,j.kelebihan_maks  FROM riwayat_jabatan_struktural r JOIN jabatan_struktural j ON r.id_jabatan_struktural = j.id_jabatan_struktural WHERE r.tmt < DATE('".$data['tahun']."-".$data['bulan']."-05') AND r.id_dosen = '".$data['nip']."' ORDER BY r.tmt DESC LIMIT 1";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getJabFungsionalPerBulanTahun($data)
	{
		
		$sql = "SELECT r.id_riwayat_jabatan_fungsional, j.id_jabatan_fungsional, j.nama,j.tarif,j.tarif_non_pns  FROM riwayat_jabatan_fungsional r JOIN jabatan_fungsional j ON r.id_jabatan_fungsional = j.id_jabatan_fungsional WHERE r.tmt < DATE('".$data['tahun']."-".$data['bulan']."-05') AND r.id_dosen = '".$data['nip']."' ORDER BY r.tmt DESC LIMIT 1";

		$res = $this->db->query($sql);

		return $res->result_array();	
	}	
	
	public function getGolonganByTMT($data)
	{
		$sql = "SELECT r.id_riwayat_golongan, g.nama, g.pph FROM riwayat_golongan r JOIN golongan g ON r.id_golongan = g.id_golongan WHERE r.tmt < date('".$data['tahun']."-".$data['bulan']."-05') AND r.id_dosen = '".$data['nip']."' order by r.tmt DESC LIMIT 1 ";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getFungsionalByTMT($data)
	{
		$sql = "SELECT r.id_riwayat_jabatan_fungsional, r.id_jabatan_fungsional , f.grade, f.jobvalue, f.nama as namaf FROM riwayat_jabatan_fungsional r JOIN jabatan_fungsional f ON r.id_jabatan_fungsional = f.id_jabatan_fungsional WHERE r.id_dosen='".$data['nip']."' AND r.tmt < date('".$data['tahun']."-".$data['bulan']."-05') order by r.tmt DESC LIMIT 1";

		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getStrukturalByTMT($data)
	{
		$sql = "SELECT r.id_riwayat_jabatan_struktural, r.id_jabatan_struktural , f.grade, f.job_value, f.nama as namaf FROM riwayat_jabatan_struktural r JOIN jabatan_struktural f ON r.id_jabatan_struktural = f.id_jabatan_struktural WHERE r.id_dosen='".$data['nip']."' AND r.tmt < date('".$data['tahun']."-".$data['bulan']."-05') order by r.tmt DESC LIMIT 1";

		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getPendidikanByTMT($data)
	{
		$sql = "SELECT r.id_riwayat_pendidikan, p.singkatan , r.tmt FROM riwayat_pendidikan r JOIN jenjang_pendidikan p ON r.id_jenjang_pendidikan = p.id_jenjang_pendidikan WHERE r.id_dosen = '".$data['nip']."' AND r.tmt < date('".$data['tahun']."-".$data['bulan']."-05') ORDER BY r.tmt DESC LIMIT 1";
		$res = $this->db->query($sql);

		return $res->result_array();
	}
}