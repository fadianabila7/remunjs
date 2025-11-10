<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KegiatanModel extends CI_Model {

	
	public function getKegiatanIndividuJenisBulanTahun($data){
		$currentYear = $data['tahun'];
		$currentMonth = $data['bulan'];
		$tempYear=0;
		$tempMonth=0;
		if($currentMonth==12){
			$tempYear = $currentYear+1;
			$tempMonth = 1;
		}else{
			$tempMonth = $currentMonth+1;
			$tempYear = $currentYear;
		}
		$sql = "SELECT kd.*, k.bobot_sks  FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE k.kode_jenis_kegiatan = ".$data['jenis_kegiatan']." AND kd.id_dosen='".$data['nip']."' AND kd.tanggal_kegiatan < date('".$tempYear."-".$tempMonth."-01') AND kd.tanggal_kegiatan >= date('".$currentYear."-".$currentMonth."-01')";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getKegiatanPenunjang()
	{
		$sql = "SELECT * from kegiatan k where k.kode_jenis_kegiatan = 4 AND k.induk=0";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function entryKegiatan($data)
	{
		$sql = "INSERT INTO kegiatan_dosen VALUES ('','".$data['tgl_entry']."','".$data['id_user']."','".$data['nip']."', '".$data['id_prodi']."', '".$data['tgl_keg']."', '".$data['kode_kegiatan']."', '".$data['sks']."', '".$data['deskripsi']."', '".$data['no_sk']."')";
		$res = $this->db->query($sql);

		return $res;
	}

	public function getSKBulanTahun($data)
	{
		if($data['bulan']==0)
		{
			$sql = "SELECT DISTINCT * FROM kegiatan_dosen kd where YEAR(kd.tanggal_kegiatan)='".$data['tahun']."' GROUP BY kd.no_sk_kontrak ORDER BY kd.tanggal_kegiatan";
		}
		else
		{
			$sql = "SELECT DISTINCT * FROM kegiatan_dosen kd where YEAR(kd.tanggal_kegiatan)='".$data['tahun']."' AND MONTH(kd.tanggal_kegiatan)='".$data['bulan']."' GROUP BY kd.no_sk_kontrak ORDER BY kd.tanggal_kegiatan";
		}

		$res = $this->db->query($sql);

		return $res->result_array();
	}
	public function getSKNoSK($data)
	{
		$sql = "SELECT * FROM kegiatan_dosen kd where no_sk_kontrak = '".$data['no_sk']."' ORDER BY kode_kegiatan";

		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getKegiatanByKodeKegiatan($data)
	{
		$sql = "SELECT * FROM kegiatan where kode_kegiatan = '".$data['kode_kegiatan']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function deleteKegiatanDosenBySK($data)
	{
		$sql = "DELETE FROM kegiatan_dosen WHERE no_sk_kontrak = '".$data['no_sk']."'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function getKegiatanByKodeInduk($data)
	{
		$sql = "SELECT * FROM kegiatan where induk = '".$data['induk']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function deleteKegiatanDosenByRiwayat($data)
	{
		$sql = "DELETE FROM kegiatan_dosen WHERE id_kegiatan_dosen = '".$data['riwayat']."'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function updateKegiatanDosenByRiwayat($data)
	{
		$sql = "UPDATE kegiatan_dosen SET tanggal_entry = '".$data['tgl_entry']."', id_user = '".$data['id_user']."', id_dosen='".$data['nip']."', tanggal_kegiatan='".$data['tgl_keg']."', kode_kegiatan = '".$data['kode_kegiatan']."', sks='".$data['sks']."', deskripsi='".$data['deskripsi']."', no_sk_kontrak = '".$data['no_sk']."' WHERE id_kegiatan_dosen = '".$data['riwayat']."'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function updateDeskripsiKegiatanDosenByRiwayat($data)
	{
		$sql = "UPDATE kegiatan_dosen SET deskripsi='".$data['deskripsi']	."' WHERE id_kegiatan_dosen='".$data['riwayat']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function getKegiatanDosenJenisBulanTahun($data){
		if($data['jenis']==0){
			if($data['bulan']!=0){
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.keg_bulanan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' ORDER BY tanggal_kegiatan DESC";
			}else{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.keg_bulanan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' ORDER BY tanggal_kegiatan DESC";
			}
		}else{
			if($data['bulan']!=0){
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.keg_bulanan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE
						k.kode_jenis_kegiatan='".$data['jenis']."' 
						AND kd.id_dosen='".$data['nip']."' 
						AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' 
						ORDER BY tanggal_kegiatan DESC";
			}else{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.keg_bulanan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE k.kode_jenis_kegiatan='".$data['jenis']."' AND kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' ORDER BY tanggal_kegiatan DESC";
			}
		}
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getKegiatanDosenJenisBulanTahunRange($data,$d){
		$sql = "SELECT j.*, sum(kd.sks*k.bobot_sks) as total 
				FROM kegiatan_dosen kd 
				JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan 
				JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan 
				WHERE k.kode_jenis_kegiatan = '$d' 
				AND kd.id_dosen = '$data[nip]' 
				AND YEAR(tanggal_kegiatan) = '$data[tahun]' AND 
				MONTH(tanggal_kegiatan) BETWEEN '$data[bulan]' AND '$data[endbulan]'
				GROUP BY k.kode_jenis_kegiatan
				ORDER BY j.kode_jenis_kegiatan ASC";
		
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function max_kegiatan($j){
		$sql = "SELECT *,(value_config*$j) as jumlah FROM `config` WHERE nama_config like 'max_bidang_%'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

}