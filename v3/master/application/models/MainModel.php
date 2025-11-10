<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class MainModel extends CI_Model
{

	public function getDataFakultasByID($idfakultas)
	{
		$sql = "SELECT * FROM fakultas WHERE id_fakultas = '" . $idfakultas . "'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataProdi($data)
	{
		$sql = "SELECT p.*,j.id_jenjang_pendidikan,j.singkatan,j.nama as namajenjang FROM program_studi p INNER JOIN jenjang_pendidikan j ON p.id_jenjang_pendidikan=j.id_jenjang_pendidikan where p.id_fakultas='" . $data . "'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getDataStatus()
	{
		$sql = "SELECT * FROM status_dosen";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getDataFakultas()
	{
		$sql = "SELECT * FROM fakultas";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getRiwayat($data)
	{
		if ($data['prodi'] == 0) {
			if ($data['status'] == 0) {
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi, f.nama as namafakultas FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen JOIN fakultas f ON p.id_fakultas = f.id_fakultas where p.id_fakultas = '" . $data['fakultas'] . "'";
			} else {
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi, f.nama as namafakultas FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen JOIN fakultas f ON p.id_fakultas = f.id_fakultas where p.id_fakultas = '" . $data['fakultas'] . "' AND d.id_status_dosen='" . $data['status'] . "'";
			}
		} else {
			if ($data['status'] == 0) {
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi, f.nama as namafakultas FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen JOIN fakultas f ON p.id_fakultas = f.id_fakultas where d.id_program_studi='" . $data['prodi'] . "'";
			} else {
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi, f.nama as namafakultas FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen JOIN fakultas f ON p.id_fakultas = f.id_fakultas where d.id_program_studi='" . $data['prodi'] . "' AND d.id_status_dosen='" . $data['status'] . "'";
			}
		}
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	//------------------------------------------------------------------------------------------

	public function getTotalSKSPerBulan($data)
	{
		$sql = "SELECT sum(d.sks*k.bobot_sks) as total_sks FROM kegiatan_dosen d JOIN kegiatan k ON d.kode_kegiatan = k.kode_kegiatan WHERE d.id_dosen = '" . $data['nip'] . "' AND MONTH(d.tanggal_kegiatan)='" . $data['bulan'] . "' AND YEAR(d.tanggal_kegiatan)='" . $data['tahun'] . "' GROUP by d.id_dosen";
		$res = $this->db->query($sql);

		return $res->result_array();
	}


	// perubahan pemanggilan untuk kode jenis 4
	public function getTotalSKSPerBulanJenis4($data)
	{
		$sql = "SELECT sum(d.sks*k.bobot_sks) as total_sks FROM kegiatan_dosen d JOIN kegiatan k ON d.kode_kegiatan = k.kode_kegiatan WHERE d.id_dosen = '" . $data['nip'] . "' AND MONTH(d.tanggal_kegiatan)='" . $data['bulan'] . "' AND YEAR(d.tanggal_kegiatan)='" . $data['tahun'] . "' AND k.kode_jenis_kegiatan=4 GROUP by d.id_dosen";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getTotalSKSPerBulanBukanJenis4($data)
	{
		$sql = "SELECT sum(d.sks*k.bobot_sks) as total_sks FROM kegiatan_dosen d JOIN kegiatan k ON d.kode_kegiatan = k.kode_kegiatan WHERE d.id_dosen = '" . $data['nip'] . "' AND MONTH(d.tanggal_kegiatan)='" . $data['bulan'] . "' AND YEAR(d.tanggal_kegiatan)='" . $data['tahun'] . "' AND k.kode_jenis_kegiatan<>4 GROUP by d.id_dosen";
		$res = $this->db->query($sql);

		return $res->result_array();
	}





	public function getJabStrukturalPerBulanTahun($data)
	{
		$sql = "SELECT r.id_riwayat_jabatan_struktural, r.deskripsi, j.id_jabatan_struktural, j.nama, j.bobot_sksr  FROM riwayat_jabatan_struktural r JOIN jabatan_struktural j ON r.id_jabatan_struktural = j.id_jabatan_struktural WHERE r.tmt < DATE('" . $data['tahun'] . "-" . $data['bulan'] . "-05') AND r.id_dosen = '" . $data['nip'] . "' ORDER BY r.tmt DESC LIMIT 1";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getJabFungsionalPerBulanTahun($data)
	{

		$sql = "SELECT r.id_riwayat_jabatan_fungsional, j.id_jabatan_fungsional, j.nama, j.sksr_maks_gaji, j.sksr_maks_kinerja  FROM riwayat_jabatan_fungsional r JOIN jabatan_fungsional j ON r.id_jabatan_fungsional = j.id_jabatan_fungsional WHERE r.tmt < DATE('" . $data['tahun'] . "-" . $data['bulan'] . "-05') AND r.id_dosen = '" . $data['nip'] . "' ORDER BY r.tmt DESC LIMIT 1";

		$res = $this->db->query($sql);

		return $res->result_array();
	}


	public function validasiKegiatan($data)
	{
		// print_r($data);
		$this->db->select('kegiatan_dosen.sks, kegiatan_dosen.deskripsi, kegiatan_dosen.tanggal_kegiatan, kegiatan.bobot_sks, kegiatan.nama')
			->from('kegiatan_dosen')
			->join('kegiatan', 'kegiatan.kode_kegiatan = kegiatan_dosen.kode_kegiatan')
			->like('kegiatan_dosen.deskripsi', "Validasi di Bulan " . $data['bulan'])
			->where('year(kegiatan_dosen.tanggal_kegiatan)', $data['tahun'])
			->where('id_dosen', $data['nip']);
		if ($data['tipe'] == 1 || $data['tipe'] == 2 || $data['tipe'] == 3 || $data['tipe'] == 4 || $data['tipe'] == 5) {
			$this->db->where('kode_jenis_kegiatan', $data['tipe']);
		} else {
			$this->db->where('kode_jenis_kegiatan', '0');
		}

		$res = $this->db->get();
		return $res->result_array();
	}
}
