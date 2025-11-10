<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class DashboardModel extends CI_Model {
	
	public function count($a,$data){
		if($a=='dosen'){
			$sql = "SELECT COUNT(id_dosen) as total FROM dosen JOIN program_studi on dosen.id_program_studi = program_studi.id_program_studi 
					WHERE program_studi.id_fakultas = '".$data."'";
		}

		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function dosenProdi($data){
		$sql = "SELECT program_studi.nama, COUNT(dosen.id_dosen) as total FROM dosen join program_studi 
				on dosen.id_program_studi = program_studi.id_program_studi 
				WHERE program_studi.id_fakultas = '".$data."' GROUP by program_studi.nama";
		$res = $this->db->query($sql);
		return $res->result();
	}

	public function getFungsional($data){
		$sql= "SELECT dosen.id_dosen,jabatan_fungsional.nama, count(dosen.id_dosen) as total,max(riwayat_jabatan_fungsional.tmt) as tmtx FROM riwayat_jabatan_fungsional join program_studi join jabatan_fungsional join dosen on dosen.id_program_studi = program_studi.id_program_studi and riwayat_jabatan_fungsional.id_dosen = dosen.id_dosen and riwayat_jabatan_fungsional.id_jabatan_fungsional = jabatan_fungsional.id_jabatan_fungsional WHERE program_studi.id_fakultas = '".$data."' and tmt in (select max(tmt) from riwayat_jabatan_fungsional join program_studi join jabatan_fungsional join dosen on dosen.id_program_studi = program_studi.id_program_studi and riwayat_jabatan_fungsional.id_dosen = dosen.id_dosen and riwayat_jabatan_fungsional.id_jabatan_fungsional WHERE program_studi.id_fakultas = '".$data."' group by riwayat_jabatan_fungsional.id_dosen) GROUP BY riwayat_jabatan_fungsional.id_jabatan_fungsional ORDER by riwayat_jabatan_fungsional.id_jabatan_fungsional DESC";
		$res = $this->db->query($sql);
		return $res->result();
	}


	public function getStruktural($data){
		$sql = "SELECT dosen.id_dosen,jabatan_struktural.nama, count(dosen.id_dosen) as total,max(riwayat_jabatan_struktural.tmt) as tmtx FROM riwayat_jabatan_struktural join program_studi join jabatan_struktural join dosen on dosen.id_program_studi = program_studi.id_program_studi and riwayat_jabatan_struktural.id_dosen = dosen.id_dosen and riwayat_jabatan_struktural.id_jabatan_struktural = jabatan_struktural.id_jabatan_struktural WHERE program_studi.id_fakultas = '".$data."' and tmt in (select max(tmt) from riwayat_jabatan_struktural join program_studi join jabatan_struktural join dosen on dosen.id_program_studi = program_studi.id_program_studi and riwayat_jabatan_struktural.id_dosen = dosen.id_dosen and riwayat_jabatan_struktural.id_jabatan_struktural WHERE program_studi.id_fakultas = '".$data."' group by riwayat_jabatan_struktural.id_dosen) GROUP BY riwayat_jabatan_struktural.id_jabatan_struktural ORDER by riwayat_jabatan_struktural.id_jabatan_struktural DESC";
		$res = $this->db->query($sql);
		return $res->result();
	}

	public function getTotalSKPenunjang($data){
		$sql = "SELECT DISTINCT kegiatan_dosen.`no_sk_kontrak` as no_kontrak, kegiatan_dosen.`deskripsi`as desk, 
					kegiatan.`induk`, kegiatan.`satuan`, kegiatan_dosen.`tanggal_kegiatan`, kegiatan_dosen.`tanggal_entry`
					FROM kegiatan_dosen
					JOIN kegiatan ON kegiatan.`kode_kegiatan`=kegiatan_dosen.`kode_kegiatan`
					JOIN admin ON admin.`id_user` = kegiatan_dosen.`id_user`
					WHERE admin.`id_fakultas` = ".$data['fakultas']."
					AND YEAR(kegiatan_dosen.`tanggal_kegiatan`)= ".$data['tahun']."
					AND kegiatan.`kode_jenis_kegiatan`=4 
					group by kegiatan_dosen.no_sk_kontrak, kegiatan_dosen.tanggal_entry";
		$query = $this->db->query($sql);
        return $query->num_rows();
    }
}
