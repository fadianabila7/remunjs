<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TambahanModel extends CI_Model {

	
	public function getKegiatanIndividuJenisBulanTahun($data)
	{
		$currentYear = $data['tahun'];
		$currentMonth = $data['bulan'];
		$tempYear=0;
		$tempMonth=0;
		if($currentMonth==12)
		{
			$tempYear = $currentYear+1;
			$tempMonth = 1;
		}
		else
		{
			$tempMonth = $currentMonth+1;
			$tempYear = $currentYear;
		}
		$sql = "SELECT kd.*, k.bobot_sks  FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan WHERE k.kode_jenis_kegiatan = '".$data['jenis_kegiatan']."' AND kd.id_dosen='".$data['nip']."' AND kd.tanggal_kegiatan < date('".$tempYear."-".$tempMonth."-01') AND kd.tanggal_kegiatan >= date('".$currentYear."-".$currentMonth."-01')";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getTugasTambahan()
	{
		//$sql = "SELECT * from kegiatan k where k.kode_jenis_kegiatan = 4 AND k.induk=0";
		$sql = "SELECT * from kegiatan k where k.kode_jenis_kegiatan = 5 and k.kategori=6 and k.induk > 0 ";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function entryTambahan($data)
	{
		$sql = "INSERT INTO kegiatan_dosen VALUES ('','".$data['tgl_entry']."','".$data['id_user']."','".$data['nip']."', '".$data['id_prodi']."', '".$data['tgl_keg']."', '".$data['kode_kegiatan']."', '".$data['sks']."', '".$data['deskripsi']."', '".$data['no_sk']."','0')";
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
	public function getSKTambahanBulanTahun($data)
	{
		if($data['bulan']==0){

			$sql = "SELECT kd.no_sk_kontrak as no_kontrak, k.induk, k.satuan, kd.deskripsi as desk,  kd.tanggal_kegiatan 
					from kegiatan_dosen kd join kegiatan k on kd.kode_kegiatan=k.kode_kegiatan join admin adm on kd.id_user=adm.id_user
					where YEAR(kd.tanggal_kegiatan)='".$data['tahun']."' AND k.kode_jenis_kegiatan = '5' and adm.id_fakultas='".$data['fakultas']."'
					GROUP by kd.no_sk_kontrak ORDER BY kd.tanggal_kegiatan ASC";
		
		}else{

			$sql = "SELECT kd.no_sk_kontrak as no_kontrak, k.induk, k.satuan, kd.deskripsi as desk,  kd.tanggal_kegiatan 
					from kegiatan_dosen kd join kegiatan k on kd.kode_kegiatan=k.kode_kegiatan join admin adm on kd.id_user=adm.id_user
					where YEAR(kd.tanggal_kegiatan)='".$data['tahun']."' AND MONTH(kd.tanggal_kegiatan)='".$data['bulan']."' AND k.kode_jenis_kegiatan = '5' and adm.id_fakultas='".$data['fakultas']."'
					GROUP by kd.no_sk_kontrak ORDER BY kd.tanggal_kegiatan ASC";
		}

		$res = $this->db->query($sql);

		return $res->result_array();
	}
	public function getSKNoSK($data)
	{
		$sql = "SELECT * FROM kegiatan_dosen kd where no_sk_kontrak = '".$data['no_sk']."' ORDER BY tanggal_kegiatan ASC";

		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getTambahanByKodeKegiatan($data)
	{
		$sql = "SELECT * FROM kegiatan where kode_kegiatan = '".$data['kode_kegiatan']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function KegiatanDosenBySK($data)
	{
		//$sql = "DELETE FROM kegiatan_dosen WHERE no_sk_kontrak = '".$data['no_sk']."'";
		$sql = "DELETE FROM kegiatan_dosenxx WHERE deskripsixx like '%uuid_tambahan\":\"".$data['uuid']."\"%'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function getKegiatanByKodeInduk($data)
	{
		$sql = "SELECT * FROM kegiatan where induk = '".$data['induk']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function KegiatanDosenByRiwayat($data)
	{
		$sql = "DELETE FROM kegiatan_dosenxx WHERE id_kegiatan_dosen = '".$data['riwayat']."'";
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

	public function getKegiatanDosenJenisBulanTahun($data)
	{
		if($data['jenis']==0)
		{
			if($data['bulan']!=0)
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' ORDER BY tanggal_kegiatan DESC";
			}
			else
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' ORDER BY tanggal_kegiatan DESC";
			}
		}
		else
		{
			if($data['bulan']!=0)
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE k.kode_jenis_kegiatan='".$data['jenis']."' AND kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' ORDER BY tanggal_kegiatan DESC";
			}
			else
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE k.kode_jenis_kegiatan='".$data['jenis']."' AND kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' ORDER BY tanggal_kegiatan DESC";
			}
		}
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getKegiatanDosenJenisBulanTahunStatus($data)
	{
		if($data['jenis']==0)
		{
			if($data['bulan']!=0)
			{				
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' AND kd.status = '".$data['status']."' ORDER BY tanggal_kegiatan DESC";
			}
			else
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND kd.status = '".$data['status']."' ORDER BY tanggal_kegiatan DESC";
			}
		}
		else
		{
			if($data['bulan']!=0)
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE k.kode_jenis_kegiatan='".$data['jenis']."' AND kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' AND kd.status = '".$data['status']."' ORDER BY tanggal_kegiatan DESC";
			}
			else
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE k.kode_jenis_kegiatan='".$data['jenis']."' AND kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND kd.status = '".$data['status']."' ORDER BY tanggal_kegiatan DESC";
			}
		}
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getKegiatanDosenJenisBulanTahunFakultas($data)
	{
		if($data['jenis']==0)
		{
			if($data['bulan']!=0)
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan join program_studi ps on kd.id_program_studi = ps.id_program_studi WHERE YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' and ps.id_fakultas = '".$data['fakultas']."' ORDER BY tanggal_kegiatan DESC";
			}
			else
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan join program_studi ps on kd.id_program_studi = ps.id_program_studi WHERE YEAR(tanggal_kegiatan)='".$data['tahun']."' and ps.id_fakultas = '".$data['fakultas']."' ORDER BY tanggal_kegiatan DESC";
			}
		}
		else
		{
			if($data['bulan']!=0)
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan join program_studi ps on kd.id_program_studi = ps.id_program_studi WHERE YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' and ps.id_fakultas = '".$data['fakultas']."' and k.kode_jenis_kegiatan = '".$data['jenis']."' ORDER BY tanggal_kegiatan DESC";
			}
			else
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan join program_studi ps on kd.id_program_studi = ps.id_program_studi WHERE YEAR(tanggal_kegiatan)='".$data['tahun']."' and ps.id_fakultas = '".$data['fakultas']."' and k.kode_jenis_kegiatan = '".$data['jenis']."' ORDER BY tanggal_kegiatan DESC";
			}
		}
	}


	function getTanggal(){
	  
	  $sql = "SELECT * FROM kegiatan_dosen kd where tanggal_kegiatan = '0000-00-00' and deskripsi != '' and deskripsi != 'null'
	  AND deskripsi LIKE  '%{%'";
	  $res = $this->db->query($sql);
	  return $res->result_array();

   }

   function updateTanggal($data){
   	  $sql = "UPDATE kegiatan_dosen SET tanggal_kegiatan = '".$data['tanggal_kegiatan']."' WHERE id_kegiatan_dosen = '".$data['id_kegiatan_dosen']."'";
		$res = $this->db->query($sql);
		return $res;
   }


   function deskripsikosong(){
   	  $sql = "select id_kegiatan_dosen,deskripsi from kegiatan_dosen where deskripsi not like '{%'";
	  $res = $this->db->query($sql);
	  return $res->result_array();
   }

   function updatedeskripsi($data){
   	  $sql = "UPDATE kegiatan_dosen SET deskripsi = '".$data['deskripsi']."' WHERE id_kegiatan_dosen = '".$data['id_kegiatan_dosen']."'";
		$res = $this->db->query($sql);
		return $res;
   }

}