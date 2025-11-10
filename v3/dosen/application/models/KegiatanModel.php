<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KegiatanModel extends CI_Model {

	public function getKegiatanDosenJenisBulanTahun($data){
		if(!isset($data['id_kegiatan']) || $data['id_kegiatan']==0){
			if($data['jenis']==0){
				if($data['bulan']!=0){
					$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.keg_bulanan, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' ORDER BY tanggal_kegiatan DESC";
				}else{
					$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.keg_bulanan, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' ORDER BY tanggal_kegiatan DESC";
				}
			}else{
				if($data['bulan']!=0){
					// validasi()
					$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.keg_bulanan, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE k.kode_jenis_kegiatan='".$data['jenis']."' AND kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND (MONTH(tanggal_kegiatan)='".$data['bulan']."' ". ((empty($data['nama_bulan']))? ' ': "or deskripsi like '%\"Validasi di Bulan ".$data['nama_bulan']."\"%'").") ORDER BY tanggal_kegiatan DESC";
				}else{
					$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.keg_bulanan, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE k.kode_jenis_kegiatan='".$data['jenis']."' AND kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' ORDER BY tanggal_kegiatan DESC";
				}
			}
		}else{
			if($data['jenis']==0){
				if($data['bulan']!=0){
					$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.keg_bulanan, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' and kategori='".$data['id_kegiatan']."' ORDER BY tanggal_kegiatan DESC";
				}else{
					$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.keg_bulanan, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' and kategori='".$data['id_kegiatan']."' ORDER BY tanggal_kegiatan DESC";
				}
			}else{
				if($data['bulan']!=0){
					$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.keg_bulanan, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE k.kode_jenis_kegiatan='".$data['jenis']."' AND kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' and kategori='".$data['id_kegiatan']."' ORDER BY tanggal_kegiatan DESC";
				}else{
					$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.keg_bulanan, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan WHERE k.kode_jenis_kegiatan='".$data['jenis']."' AND kd.id_dosen='".$data['nip']."' AND YEAR(tanggal_kegiatan)='".$data['tahun']."' and kategori='".$data['id_kegiatan']."' ORDER BY tanggal_kegiatan DESC";
				}
			}		
		}
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getKegiatanDosenJenisBulanTahunExt($data){
		$this->db->select('kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.keg_bulanan, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan');
		$this->db->from("kegiatan_dosen PARTITION (p".$data['tahun'].") as kd");
		$this->db->join('kegiatan k','kd.kode_kegiatan = k.kode_kegiatan');
		$this->db->join('jenis_kegiatan j','k.kode_jenis_kegiatan = j.kode_jenis_kegiatan ');
		$this->db->where('YEAR(tanggal_kegiatan)', $data['tahun']);

		if($data['bulan']!=0){	
			$this->db->where('MONTH(kd.tanggal_kegiatan)', $data['bulan']);
		}
		if($data['jenis']!=0){	
			$this->db->where('k.kode_jenis_kegiatan', $data['jenis']);
		}
		if(isset($data['id_kegiatan']) || $data['id_kegiatan']>0){
			$this->db->where('kategori', $data['id_kegiatan']);
		}

		$res = $this->db->get();
		return $res->result_array();
	}

	public function getKegiatanDosenJenisBulanTahunStatus($data)
	{
		$this->db->select('kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan');
		$this->db->from("kegiatan_dosen PARTITION (p".$data['tahun'].") as kd");
		$this->db->join('kegiatan k','kd.kode_kegiatan = k.kode_kegiatan');
		$this->db->join('jenis_kegiatan j','k.kode_jenis_kegiatan = j.kode_jenis_kegiatan ');
		$this->db->where('kd.id_dosen=',$data['nip']);
		$this->db->where('YEAR(kd.tanggal_kegiatan)', $data['tahun']);
		$this->db->where('kd.status', $data['status']);
		$this->db->order_by('tanggal_kegiatan DESC');
		if($data['bulan']!=0){	
			$this->db->where('MONTH(kd.tanggal_kegiatan)', $data['bulan']);
		}
		if($data['jenis']!=0){	
			$this->db->where('k.kode_jenis_kegiatan', $data['jenis']);
		}

		$res = $this->db->get();
		return $res->result_array();
	}

	public function getKegiatanDosenJenisBulanTahunFakultas($data)
	{
		if($data['jenis']==0)
		{
			if($data['bulan']!=0)
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan join program_studi ps on kd.id_program_studi = ps.id_program_studi WHERE YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' and ps.id_fakultas = '".$data['fakultas']."' ORDER BY tanggal_kegiatan DESC";
			}
			else
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan join program_studi ps on kd.id_program_studi = ps.id_program_studi WHERE YEAR(tanggal_kegiatan)='".$data['tahun']."' and ps.id_fakultas = '".$data['fakultas']."' ORDER BY tanggal_kegiatan DESC";
			}
		}
		else
		{
			if($data['bulan']!=0)
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan join program_studi ps on kd.id_program_studi = ps.id_program_studi WHERE YEAR(tanggal_kegiatan)='".$data['tahun']."' AND MONTH(tanggal_kegiatan)='".$data['bulan']."' and ps.id_fakultas = '".$data['fakultas']."' and k.kode_jenis_kegiatan = '".$data['jenis']."' ORDER BY tanggal_kegiatan DESC";
			}
			else
			{
				$sql = "SELECT kd.*, k.kode_jenis_kegiatan, k.bobot_sks, k.satuan, k.isian_deskripsi ,k.nama as namakegiatan, j.nama as namajeniskegiatan FROM kegiatan_dosen PARTITION (p".$data['tahun'].") kd JOIN kegiatan k ON kd.kode_kegiatan = k.kode_kegiatan JOIN jenis_kegiatan j ON k.kode_jenis_kegiatan = j.kode_jenis_kegiatan join program_studi ps on kd.id_program_studi = ps.id_program_studi WHERE YEAR(tanggal_kegiatan)='".$data['tahun']."' and ps.id_fakultas = '".$data['fakultas']."' and k.kode_jenis_kegiatan = '".$data['jenis']."' ORDER BY tanggal_kegiatan DESC";
			}
		}
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

	public function getKegiatanDosenByIDKegiatan($data)
	{
		$sql = "SELECT * FROM kegiatan_dosen where id_kegiatan_dosen = '".$data['id_keg_dosen']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function updateDeskripsiKegiatanDosenByIDKegiatan($data)
	{
		$sql = "UPDATE kegiatan_dosen SET deskripsi='".$data['deskripsi']."' WHERE id_kegiatan_dosen='".$data['id_keg_dosen']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function updateStatusKegiatanDosenByIDKegiatan($data)
	{
		$sql = "UPDATE kegiatan_dosen SET status='".$data['status']."' WHERE id_kegiatan_dosen='".$data['id_keg_dosen']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function getKegiatanByJenis($data)	
	{
		if($data['jenis']==0)
		{
			$sql = "SELECT * FROM kegiatan order by kode_kegiatan";
		}
		else
		{
			$sql = "SELECT * FROM kegiatan WHERE kode_jenis_kegiatan = '".$data['jenis']."'";
		}

		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getKelasKuliah($data)
	{
		$sql = "SELECT matakuliah.nama AS namamatakuliah,dosen.nama AS namadosen, kelas_kuliah.id_kelas_kuliah AS id_kelaskuliah, kelas_kuliah.id_program_studi,  kelas_kuliah.id_dosen AS id_dosen, kelas_kuliah.id_matakuliah AS id_matakuliah, kelas_kuliah.tahun_akademik AS tahunakademik, kelas_kuliah.semester AS semester, kelas_kuliah.no_sk_kontrak AS no_sk_kontrak, kelas_kuliah.hari AS hari, kelas_kuliah.waktu_mulai AS waktu_mulai, kelas_kuliah.sks_pertemuan AS sks, kelas_kuliah.ruang AS ruang, kelas_kuliah.jumlah_peserta AS peserta, (SELECT COUNT(*) FROM kegiatan_dosen WHERE kegiatan_dosen.deskripsi LIKE CONCAT('%\"kelas\":\"',kelas_kuliah.id_kelas_kuliah,'\"%') GROUP BY kegiatan_dosen.id_dosen) AS jumlah FROM kelas_kuliah  JOIN matakuliah ON kelas_kuliah.id_matakuliah = matakuliah.id_matakuliah JOIN dosen ON kelas_kuliah.id_dosen = dosen.id_dosen WHERE kelas_kuliah.id_dosen = '".$data['id_dosen']."' AND kelas_kuliah.tahun_akademik = ".$data['tahun']." AND kelas_kuliah.semester = ".$data['semester'];
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function get_Kelas_Kuliahbyid($id_kelas_kuliah)
	{
		$data = $this->db->query('select kelas_kuliah.kode_kegiatan as kode_kegiatan, kegiatan.nama as nama_kegiatan, matakuliah.nama as namamatakuliah, dosen.nama as namadosen, kelas_kuliah.id_kelas_kuliah as id_kelaskuliah, kelas_kuliah.id_matakuliah as id_matakuliah, kelas_kuliah.id_dosen as id_dosen, kelas_kuliah.tahun_akademik as tahunakademik, kelas_kuliah.semester as semester, kelas_kuliah.no_sk_kontrak as no_sk_kontrak, kelas_kuliah.hari as hari, kelas_kuliah.waktu_mulai as waktu_mulai,kelas_kuliah.sks_pertemuan as sks, kelas_kuliah.ruang as ruang, kelas_kuliah.jumlah_peserta as peserta from kelas_kuliah join matakuliah on kelas_kuliah.id_matakuliah=matakuliah.id_matakuliah join dosen on kelas_kuliah.id_dosen=dosen.id_dosen join kegiatan on kelas_kuliah.kode_kegiatan=kegiatan.kode_kegiatan where kelas_kuliah.id_kelas_kuliah='.$id_kelas_kuliah);
		
		return $data->result_array();
	}

	public function get_Kegiatan_Mengajar_By_ID_Kelas_Kuliah($id_kelas_kuliah){
		$sql = "SELECT * from kegiatan_dosen kd where kd.deskripsi like '%\"".$id_kelas_kuliah."\"%' ORDER BY kd.tanggal_entry";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function datakegiatan($a){
		$data = $this->db->query("SELECT * FROM `kegiatan` WHERE `kode_jenis_kegiatan` = '".$a."' and induk='0' order by kode_kegiatan ASC");
		return $data->result_array();
	}

	public function logupdate($data=null)
	{
		if(isset($data['select'])){
            $this->db->select($data['select']);
        }else{
            $this->db->select('*');
        }

        if(isset($data['filter'])){
            $this->db->where($data['filter']);
        }
        if(isset($data['order'])){
            $this->db->order_by($data['order']);
        }else{
            $this->db->order_by('id_login_log DESC');
		}
        if(isset($data['limit'])){
            $this->db->limit($data['limit']);
        }

        $this->db->from('log_update');
        
        $res = $this->db->get();
        return $res->result_array();
	}
}