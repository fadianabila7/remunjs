<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class DosenModel extends CI_Model
{
	public function getDosen($data)
	{
		$this->db->select('d.*, p.nama as namaprodi, s.deskripsi');
		$this->db->from('dosen d');
		$this->db->join('status_dosen s', 'd.id_status_dosen = s.id_status_dosen', 'left');
		$this->db->join('program_studi p', 'd.id_program_studi = p.id_program_studi', 'left');

		if ($data['prodi'] == '0') {
			if ($data['fakultas'] != 0) {
				$this->db->where('p.id_fakultas', $data['fakultas']);
			}

			if ($data['status'] != 0) {
				$this->db->where('d.id_status_dosen', $data['status']);
			}
		} elseif ($data['prodi'] == 'blh') {
			$this->db->where('d.id_program_studi', 0);

			if ($data['status'] != 0) {
				$this->db->where('d.id_status_dosen', $data['status']);
			}
		} else {
			$this->db->where('d.id_program_studi', $data['prodi']);

			if ($data['status'] != 0) {
				$this->db->where('d.id_status_dosen', $data['status']);
			}
		}

		return $this->db->get()->result_array();
	}

	public function getDataDosen($data)
	{
		$sql = "SELECT d.*,p.nama as namaprodi, f.nama as namafakultas, s.deskripsi FROM dosen d left JOIN program_studi p ON d.id_program_studi = p.id_program_studi left JOIN fakultas f ON p.id_fakultas = f.id_fakultas JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen WHERE d.id_dosen = '" . $data['nip'] . "'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataDosenByFakultas($data)
	{
		$sql = "SELECT d.nama,d.id_dosen FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN fakultas f ON p.id_fakultas = f.id_fakultas WHERE f.id_fakultas='" . $data . "' ORDER by d.nama asc";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataDosenFakultasStatus($data)
	{
		if ($data['status'] == 0) {
			$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen where p.id_fakultas = '" . $data['fakultas'] . "'";
		} else {
			$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen where p.id_fakultas = '" . $data['fakultas'] . "' AND d.id_status_dosen='" . $data['status'] . "'";
		}
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataDosenAll()
	{
		$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function entryDataDosen($data)
	{

		$sql = "INSERT INTO dosen VALUES ('" . $data['nip'] . "','" . $data['prodi'] . "','" . $data['status'] . "','" . $data['nip'] . "','" . $data['nama'] . "','" . $data['norek'] . "', '" . $data['id_bank'] . "', '" . $data['notelepon'] . "','" . $data['email'] . "','" . $data['foto'] . "','" . $data['npwp'] . "')";
		$res = $this->db->query($sql);
		$sql2 = "INSERT INTO user VALUES('" . $data['nip'] . "','3','" . md5("123456") . "')";
		$res2 = $this->db->query($sql2);
		return $res + $res2;
	}

	public function resetPassDosen($data)
	{
		$sql = "UPDATE user SET password='" . md5('123456') . "' WHERE id_user = '" . $data['nip'] . "'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function updateDataDosenIndividu($data)
	{
		$sql = "UPDATE dosen SET id_dosen='" . $data['nip'] . "', id_program_studi='" . $data['prodi'] . "', id_status_dosen='" . $data['status'] . "', nip='" . $data['nip'] . "', nama='" . $data['nama'] . "', no_rekening='" . $data['norek'] . "', telepon='" . $data['notelepon'] . "', email='" . $data['email'] . "', foto='" . $data['foto'] . "',npwp='" . $data['npwp'] . "',id_bank='" . $data['id_bank'] . "' WHERE id_dosen='" . $data['keyedit'] . "'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function deleteDataDosenIndividu($data)
	{
		$sql = "DELETE FROM dosen WHERE id_dosen = '" . $data['idDosen'] . "'";
		$res = $this->db->query($sql);
		$sql = "DELETE FROM user WHERE id_user='" . $data['idDosen'] . "'";
		$res = $this->db->query($sql);
		$sql = "DELETE FROM riwayat_golongan where id_dosen = '" . $data['idDosen'] . "'";
		$res = $this->db->query($sql);
		$sql = "DELETE FROM riwayat_jabatan_fungsional where id_dosen = '" . $data['idDosen'] . "'";
		$res = $this->db->query($sql);
		$sql = "DELETE FROM riwayat_jabatan_struktural where id_dosen = '" . $data['idDosen'] . "'";
		$res = $this->db->query($sql);
		$sql = "DELETE FROM riwayat_pendidikan where id_dosen = '" . $data['idDosen'] . "'";
		$res = $this->db->query($sql);

		return $res;
	}

	public function keluarHomeBaseDosenIndividu($data)
	{
		$sql = "UPDATE dosen set id_program_studi = null where id_dosen = '" . $data['idDosen'] . "'";
		$res = $this->db->query($sql);

		return $res;
	}
}
