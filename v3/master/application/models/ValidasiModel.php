<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ValidasiModel extends CI_Model
{

	public function submitValidasiTriDharma($data)
	{
		$sql = "INSERT INTO validasi_tridharma VALUES ('','" . $data['nip'] . "', '" . $data['bulan'] . "', '" . $data['tahun'] . "','" . $data['sks_bid_1'] . "','" . $data['sks_bid_2'] . "', '" . $data['sks_bid_3'] . "', '" . $data['sks_bid_4'] . "','" . $data['beban_wajib'] . "', '" . $data['kelebihan_maks'] . "', '" . $data['deskripsi'] . "', '" . $data['status'] . "')";
		$res = $this->db->query($sql);

		return $res;
	}

	public function getDataValidasiBulanTahunByIDDosen($data)
	{
		// $sql = "SELECT * FROM validasi_tridharma where bulan = '".$data['bulan']."' AND tahun = '".$data['tahun']."' AND id_dosen = '".$data['nip']."'";
		$this->db->select('*');
		$this->db->from('validasi_tridharma');
		$this->db->where('bulan', $data['bulan']);
		$this->db->where('tahun', $data['tahun']);
		$this->db->where('id_dosen', $data['nip']);
		$res = $this->db->get();
		return $res->result_array();
	}


	public function getKegiatanDosenJenisBulanTahun($data)
	{
		$this->db->select('kegiatan_dosen.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.keg_bulanan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan');
		$this->db->from('kegiatan_dosen PARTITION (p' . $data['tahun'] . ')');
		$this->db->join('kegiatan k', 'kegiatan_dosen.kode_kegiatan = k.kode_kegiatan');
		$this->db->join('jenis_kegiatan j', 'k.kode_jenis_kegiatan = j.kode_jenis_kegiatan');
		$this->db->where('kegiatan_dosen.id_dosen', $data['nip']);
		// $this->db->where('year(tanggal_kegiatan)', $data['tahun']);
		$this->db->order_by('tanggal_kegiatan DESC');

		if ($data['bulan'] != 0) {
			$this->db->where('MONTH(tanggal_kegiatan)', $data['bulan']);
		}

		if ($data['jenis'] != 0) {
			$this->db->where('k.kode_jenis_kegiatan', $data['jenis']);
		}

		$res = $this->db->get();
		return $res->result_array();
	}

	public function getDataValidasiBulansebelunya($data)
	{
		$bulan = $data['bulan'] - 1;
		$sql = "SELECT * FROM validasi_tridharma where bulan = '" . $bulan . "' AND tahun = '" . $data['tahun'] . "' AND id_dosen = '" . $data['nip'] . "'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
}
