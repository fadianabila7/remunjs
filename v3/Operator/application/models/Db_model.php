<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Db_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	/* public function getSkemaPengabdian()
     {
     	$data = $this->db->query('SELECT * from skema_pengabdian');
		return $data->result_array();
     }*/
	public function getSkemaPenelitian()
	{
		$data = $this->db->query('SELECT * from skema_penelitian');
		return $data->result_array();
	}

	public function delete_KegiatanDosen_Mengajar_ByIDKegiatan($id_kegiatan_dosen)
	{
		$sql = "DELETE FROM kegiatan_dosen where id_kegiatan_dosen = " . $id_kegiatan_dosen;
		$res = $this->db->query($sql);
		return $res;
	}

	public function deleteKegiatanDosenByid($data)
	{
		//$sql = "DELETE FROM kegiatan_dosen WHERE id_kegiatan_dosen = '".$data['id_kegiatan']."'";
		$sql = "DELETE FROM kegiatan_dosen WHERE no_sk_kontrak='" . $data['no_sk_kontrak'] . "' and id_user='" . $data['id_user'] . "' and tanggal_entry='" . $data['tanggal_entry'] . "' and kode_kegiatan='" . $data['kode_kegiatan'] . "'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function getPenelitianidKeg($data)
	{
		$sql = "SELECT * FROM kegiatan_dosen kd where id_kegiatan_dosen = '" . $data['id_kegiatan'] . "'";

		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getPenelitianbyNoSK($data)
	{
		$sql = "SELECT * FROM kegiatan_dosen kd where no_sk_kontrak = '" . $data['no_sk'] . "' ORDER BY kode_kegiatan";

		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function updatePenelitianDosenMandiri($data)
	{
		$sql = "UPDATE kegiatan_dosen SET tanggal_entry = '" . $data['tgl_entry'] . "', id_user = '" . $data['id_user'] . "', id_dosen='" . $data['nip'] . "', tanggal_kegiatan='" . $data['tgl_keg'] . "', kode_kegiatan = '" . $data['kode_kegiatan'] . "', sks='" . $data['sks'] . "', deskripsi='" . $data['deskripsi'] . "', no_sk_kontrak = '" . $data['no_sk'] . "' WHERE id_kegiatan_dosen = '" . $data['riwayat'] . "'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function updatePenelitianDosenDibiayai($data)
	{
		$sql = "UPDATE kegiatan_dosen SET tanggal_entry = '" . $data['tgl_entry'] . "', id_user = '" . $data['id_user'] . "', id_dosen='" . $data['nip'] . "', tanggal_kegiatan='" . $data['tgl_keg'] . "', kode_kegiatan = '" . $data['kode_kegiatan'] . "', sks='" . $data['sks'] . "', deskripsi='" . $data['deskripsi'] . "', no_sk_kontrak = '" . $data['no_sk'] . "' WHERE id_kegiatan_dosen = '" . $data['riwayat'] . "'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function deletePenelitianDosenMandiri($data)
	{
		$sql = "DELETE FROM kegiatan_dosen WHERE id_kegiatan_dosen = '" . $data['riwayat'] . "'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function getDataMandiri($data)
	{
		//whre nya blom dibuat
		if ($data['bulan'] == 0) {
			/*$sql = "SELECT DISTINCT kd.*, k.kode_jenis_kegiatan as kode_jenis_kegiatan FROM kegiatan_dosen kd join kegiatan k on kd.kode_kegiatan=k.kode_kegiatan where k.kode_jenis_kegiatan=2 AND YEAR(kd.tanggal_kegiatan)='".$data['tahun']."' GROUP BY kd.no_sk_kontrak ORDER BY kd.tanggal_kegiatan";*/
			$sql = "SELECT kd.*, k.kode_jenis_kegiatan as kode_jenis_kegiatan , d.nip,d.nama,
					(select k2.nama from kegiatan k2 where k2.kode_kegiatan = k.induk) as nama_induk 
					FROM kegiatan_dosen kd join kegiatan k 
					on kd.kode_kegiatan=k.kode_kegiatan join dosen d on kd.id_dosen=d.id_dosen 
					JOIN operator opr ON kd.id_user = opr.id_user
					JOIN program_studi pg on opr.id_program_studi=pg.id_program_studi
					where (k.kode_jenis_kegiatan=2 or k.kode_jenis_kegiatan=3) AND YEAR(kd.tanggal_kegiatan)='" . $data['tahun'] . "' 
					and kd.deskripsi like '%\"bln_ke\":1,%' 
					and pg.id_fakultas='" . $data['fakultas'] . "'
					and pg.id_program_studi='" . $data['jurusan'] . "'
					ORDER BY kd.tanggal_kegiatan";
		} else {
			/*$sql = "SELECT DISTINCT kd.*,k.kode_jenis_kegiatan as kode_jenis_kegiatan FROM kegiatan_dosen kd join kegiatan k on kd.id_kegiatan=k.kode_kegiatan where k.kode_jenis_kegiatan=2 AND YEAR(kd.tanggal_kegiatan)='".$data['tahun']."' AND MONTH(kd.tanggal_kegiatan)='".$data['bulan']."' GROUP BY kd.no_sk_kontrak ORDER BY kd.tanggal_kegiatan";*/
			$sql = "SELECT kd.*,k.kode_jenis_kegiatan as kode_jenis_kegiatan, d.nip,d.nama,
				(select k2.nama from kegiatan k2 where k2.kode_kegiatan = k.induk) as nama_induk 
				FROM kegiatan_dosen kd join kegiatan k on kd.kode_kegiatan=k.kode_kegiatan join dosen d on kd.id_dosen=d.id_dosen
				JOIN operator opr ON kd.id_user = opr.id_user
				JOIN program_studi pg on opr.id_program_studi=pg.id_program_studi
				where (k.kode_jenis_kegiatan=2 or k.kode_jenis_kegiatan=3) AND YEAR(kd.tanggal_kegiatan)='" . $data['tahun'] . "' 
				AND MONTH (kd.tanggal_kegiatan)='" . $data['bulan'] . "' 
				and pg.id_fakultas='" . $data['fakultas'] . "'
				and pg.id_program_studi='" . $data['jurusan'] . "'
				ORDER BY kd.tanggal_kegiatan";
		}

		$res = $this->db->query($sql);

		return $res->result_array();
	}
	public function getDataPengabdianBulanTahun($data)
	{
		//whre nya blom dibuat
		if ($data['bulan'] == 0) {
			$sql = "SELECT DISTINCT * FROM kegiatan_dosen kd join kegiatan k on kd.kode_kegiatan=k.kode_kegiatan where k.kode_jenis_kegiatan=3 AND YEAR(kd.tanggal_kegiatan)='" . $data['tahun'] . "' GROUP BY kd.no_sk_kontrak ORDER BY kd.tanggal_kegiatan";
		} else {
			$sql = "SELECT DISTINCT * FROM kegiatan_dosen kd join kegiatan k on kd.kode_kegiatan=k.kode_kegiatan where k.kode_jenis_kegiatan=3 AND YEAR(kd.tanggal_kegiatan)='" . $data['tahun'] . "' AND MONTH(kd.tanggal_kegiatan)='" . $data['bulan'] . "' GROUP BY kd.no_sk_kontrak ORDER BY kd.tanggal_kegiatan";
		}

		$res = $this->db->query($sql);

		return $res->result_array();
	}
	public function updateDeskripsiKegiatanDosenByRiwayat($data)
	{
		$sql = "UPDATE kegiatan_dosen SET deskripsi='" . $data['deskripsi']	. "' WHERE id_kegiatan_dosen='" . $data['riwayat'] . "'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function getSKNoSK($data)
	{
		$sql = "SELECT * FROM kegiatan_dosen kd where no_sk_kontrak = '" . $data['no_sk'] . "' ORDER BY kode_kegiatan";

		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getDataApbnBulanTahun($data)
	{
		//whre nya blom dibuat
		if ($data['bulan'] == 0) {
			$sql = "SELECT DISTINCT * FROM kegiatan_dosen kd where kd.kode_kegiatan in (207,208,209,210,213,214,216,217,219,220,222,223) AND YEAR(kd.tanggal_kegiatan)='" . $data['tahun'] . "' GROUP BY kd.no_sk_kontrak ORDER BY kd.tanggal_kegiatan";
		} else {
			$sql = "SELECT DISTINCT * FROM kegiatan_dosen kd where where kd.kode_kegiatan in (207,208,209,210,213,214,216,217,219,220,222,223) AND YEAR(kd.tanggal_kegiatan)='" . $data['tahun'] . "' AND MONTH(kd.tanggal_kegiatan)='" . $data['bulan'] . "' GROUP BY kd.no_sk_kontrak ORDER BY kd.tanggal_kegiatan";
		}

		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function entryKegiatan($data)
	{
		$sql = "INSERT INTO kegiatan_dosen VALUES ('','" . $data['tgl_entry'] . "','" . $data['id_user'] . "','" . $data['nip'] . "', '" . $data['id_prodi'] . "', '" . $data['tgl_keg'] . "', '" . $data['kode_kegiatan'] . "', '" . $data['sks'] . "', '" . $data['deskripsi'] . "', '" . $data['no_sk'] . "','" . $data['status'] . "')";
		$res = $this->db->query($sql);

		return $res;
	}
	public function getDataDosen($data)
	{
		$sql = "SELECT d.*,p.nama as namaprodi, f.nama as namafakultas, s.deskripsi 
				FROM dosen d 
				JOIN program_studi p ON d.id_program_studi = p.id_program_studi 
				JOIN fakultas f ON p.id_fakultas = f.id_fakultas 
				JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen 
				WHERE d.id_dosen = '" . $data['nip'] . "'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getKegiatanPenelitian()
	{
		$sql = 'select * from kegiatan where kode_jenis_kegiatan=2 AND induk=0 and kode_kegiatan < 73';
		$res = $this->db->query($sql);

		return $res->result_array();
	}

	public function getKegiatanPenelitianMandiri()
	{
		$sql = 'select * from kegiatan where kode_kegiatan=201 AND kode_jenis_kegiatan = 2 AND induk=0';
		$res = $this->db->query($sql);

		return $res->result_array();
	}
	public function getKegiatanPenelitianDibiayai()
	{
		$sql = 'select * from kegiatan where kode_kegiatan in (206,211) AND kode_jenis_kegiatan = 2 AND induk=0';
		$res = $this->db->query($sql);

		return $res->result_array();
	}
	public function getKegiatanPengabdian()
	{
		$sql = 'select * from kegiatan where kode_jenis_kegiatan = 3 AND induk=0';
		$res = $this->db->query($sql);

		return $res->result_array();
	}
	public function getDataDosenByFakultas($data)
	{
		if ($data == 10) {
			$sql = "SELECT d.nama,d.id_dosen FROM dosen d where d.id_status_dosen in (1,2)";
		} else {
			$sql = "SELECT d.nama,d.id_dosen FROM dosen d 
					JOIN program_studi p ON d.id_program_studi = p.id_program_studi 
					JOIN fakultas f ON p.id_fakultas = f.id_fakultas 
					WHERE f.id_fakultas='" . $data . "' 
					and  d.id_status_dosen in (1,2)
					ORDER by d.nama asc";
		}
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getKegiatanByKodeInduk($data)
	{
		$sql = "SELECT * FROM kegiatan where induk = '" . $data['induk'] . "'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getKegiatanByKodeKegiatan($data)
	{
		$sql = "SELECT k.*, (select k2.nama from kegiatan k2 where k2.kode_kegiatan = k.induk) as nama_induk 
				FROM kegiatan k where k.kode_kegiatan = '" . $data['kode_kegiatan'] . "'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function get_Dosen($id_programstudi)
	{
		$data = $this->db->query('select * from dosen where id_program_studi=' . $id_programstudi);
		return $data->result_array();
	}
	public function GetJumlahKelasMK($idmk)
	{
		$data = $this->db->query('select count(id_matakuliah) as jumlah_kelas from kelas_kuliah where id_matakuliah=' . $idmk);
		return $data->result_array();
	}
	public function get_Kegiatan_Mengajar()
	{
		// $data = $this->db->query('select * from kegiatan where kode_kegiatan in (1,2,3,4,5,6,7,8,9,10,11)');
		$data = $this->db->query('SELECT * FROM `kegiatan` WHERE `kode_jenis_kegiatan` = 1 and induk = 1 ORDER BY `kegiatan`.`kode_kegiatan` ASC');
		return $data->result_array();
	}

	public function get_uuid()
	{
		$q = $this->db->query("select UUID_SHORT() as uuid");
		return $q->result_array();
	}

	public function get_Membimbing_Ta($id_programstudi, $data = null)
	{
		/*$data = $this->db->query('select kegiatan_dosen.id_dosen as id_dosen, kegiatan_dosen.kode_kegiatan as kode_kegiatan, kegiatan.nama as namakegiatan, kegiatan_dosen.tanggal_kegiatan as tanggal, kegiatan_dosen.id_kegiatan_dosen as id_kegiatan_dosen , kegiatan_dosen.id_program_studi as id_prodi, dosen.nama as namaD, dosen.nip as nipD, kegiatan_dosen.deskripsi as deskripsi, kegiatan_dosen.sks as sks, kegiatan_dosen.no_sk_kontrak as no_sk_kontrak from kegiatan_dosen join dosen on kegiatan_dosen.id_dosen=dosen.id_dosen join kegiatan on kegiatan_dosen.kode_kegiatan=kegiatan.kode_kegiatan where kegiatan_dosen.id_program_studi='.$id_programstudi.' and kegiatan_dosen.kode_kegiatan in (16,18,19,20,21,22,23,24,26,27,28,29,30,31,32,33,34)');*/
		$this->db->select('
						kegiatan_dosen.id_dosen as id_dosen,
						kegiatan_dosen.kode_kegiatan as kode_kegiatan,
						kegiatan.nama as namakegiatan,
						kegiatan_dosen.tanggal_kegiatan as tanggal,
						kegiatan_dosen.id_kegiatan_dosen as id_kegiatan_dosen,
						kegiatan_dosen.id_program_studi as id_prodi,
						dosen.nama as namaD,
						dosen.nip as nipD,
						kegiatan_dosen.deskripsi as deskripsi,
						kegiatan_dosen.sks as sks,
						kegiatan_dosen.no_sk_kontrak as no_sk_kontrak,
						kegiatan_dosen.status as status_kegiatan');

		$this->db->from('kegiatan_dosen AS kegiatan_dosen');
		$this->db->join('dosen', 'kegiatan_dosen.id_dosen=dosen.id_dosen');
		$this->db->join('kegiatan', 'kegiatan_dosen.kode_kegiatan=kegiatan.kode_kegiatan');
		$this->db->where('kegiatan_dosen.id_program_studi', $id_programstudi);
		$this->db->where_in("kegiatan_dosen.kode_kegiatan", array(17, 18, 19, 20, 25, 26, 27, 28));
		$this->db->like("kegiatan_dosen.deskripsi", '"bln_ke":1,');
		if (!empty($data['tahun'])) {
			$this->db->where('YEAR(kegiatan_dosen.tanggal_kegiatan)', $data['tahun']);
		}
		if (!empty($data['id_kegiatan']) && $data['id_kegiatan'] > 0) {
			$this->db->where('kegiatan_dosen.kode_kegiatan', $data['id_kegiatan']);
		}
		$query = $this->db->get();
		return $query->result_array();
	}


	// ubah
	public function get_Membimbing_TaByKode($id)
	{
		$data = $this->db->query("select tanggal_entry, id_user, id_dosen, id_program_studi, kode_kegiatan, sks, no_sk_kontrak
				from kegiatan_dosen
				where kegiatan_dosen.id_kegiatan_dosen='" . $id[0] . "'");
		return $data->result_array();
	}

	public function get_where_membimbing($data)
	{
		return $this->db->get_where('kegiatan_dosen', $data)->result_array();
	}

	public function get_Membimbing_Ta_ByID($id)
	{
		$data = $this->db->query("select
				kegiatan_dosen.id_kegiatan_dosen,
				kegiatan_dosen.id_dosen as id_dosen,
				kegiatan_dosen.kode_kegiatan as kode_kegiatan,
				kegiatan.nama as namakegiatan,
				kegiatan_dosen.tanggal_kegiatan as tanggal,
				kegiatan_dosen.id_kegiatan_dosen as id_kegiatan_dosen,
				kegiatan_dosen.id_program_studi as id_prodi,
				dosen.nama as namaD,
				dosen.nip as nipD,
				kegiatan_dosen.deskripsi as deskripsi,
				kegiatan_dosen.sks as sks,
				kegiatan_dosen.no_sk_kontrak as no_sk_kontrak
				from kegiatan_dosen join dosen on kegiatan_dosen.id_dosen=dosen.id_dosen
				join kegiatan on kegiatan_dosen.kode_kegiatan=kegiatan.kode_kegiatan
				where kegiatan_dosen.id_kegiatan_dosen='" . $id . "'");
		return $data->result_array();
	}
	// end ubah


	public function get_Penelitian($id_programstudi)
	{
		$data = $this->db->query('select kegiatan_dosen.id_dosen as id_dosen, kegiatan_dosen.kode_kegiatan as kode_kegiatan, kegiatan.nama as namakegiatan, kegiatan_dosen.tanggal_kegiatan as tanggal, kegiatan_dosen.id_kegiatan_dosen as id_kegiatan_dosen , kegiatan_dosen.id_program_studi as id_prodi, dosen.nama as namaD, dosen.nip as nipD, kegiatan_dosen.deskripsi as deskripsi, kegiatan_dosen.sks as sks, kegiatan_dosen.no_sk_kontrak as no_sk_kontrak from kegiatan_dosen join dosen on kegiatan_dosen.id_dosen=dosen.id_dosen join kegiatan on kegiatan_dosen.kode_kegiatan=kegiatan.kode_kegiatan where kegiatan_dosen.id_program_studi=' . $id_programstudi . ' and (kegiatan_dosen.kode_kegiatan=72 or kegiatan_dosen.kode_kegiatan=73 or kegiatan_dosen.kode_kegiatan=74 or kegiatan_dosen.kode_kegiatan=75 or kegiatan_dosen.kode_kegiatan=76 or kegiatan_dosen.kode_kegiatan=77 or kegiatan_dosen.kode_kegiatan=78)');
		return $data->result_array();
	}

	public function get_Penunjang($id_programstudi)
	{
		$data = $this->db->query('select kegiatan_dosen.id_dosen as id_dosen, kegiatan_dosen.kode_kegiatan as kode_kegiatan, kegiatan.nama as namakegiatan, kegiatan_dosen.tanggal_kegiatan as tanggal, kegiatan_dosen.id_kegiatan_dosen as id_kegiatan_dosen , kegiatan_dosen.id_program_studi as id_prodi, dosen.nama as namaD, dosen.nip as nipD, kegiatan_dosen.deskripsi as deskripsi, kegiatan_dosen.sks as sks, kegiatan_dosen.no_sk_kontrak as no_sk_kontrak from kegiatan_dosen join dosen on kegiatan_dosen.id_dosen=dosen.id_dosen join kegiatan on kegiatan_dosen.kode_kegiatan=kegiatan.kode_kegiatan  where kegiatan_dosen.id_program_studi=' . $id_programstudi . ' and kegiatan.kode_jenis_kegiatan=4');
		return $data->result_array();
	}
	public function get_Pengabdian($id_programstudi)
	{
		$data = $this->db->query('select kegiatan_dosen.id_dosen as id_dosen, kegiatan_dosen.kode_kegiatan as kode_kegiatan, kegiatan_dosen.tanggal_kegiatan as tanggal, kegiatan_dosen.id_kegiatan_dosen as id_kegiatan_dosen , kegiatan_dosen.id_program_studi as id_prodi, dosen.nama as namaD, dosen.nip as nipD, kegiatan_dosen.deskripsi as deskripsi, kegiatan_dosen.sks as sks, kegiatan_dosen.no_sk_kontrak as no_sk_kontrak from kegiatan_dosen join dosen on kegiatan_dosen.id_dosen=dosen.id_dosen where kegiatan_dosen.id_program_studi=' . $id_programstudi . ' and kegiatan_dosen.kode_kegiatan=79');
		return $data->result_array();
	}

	public function get_Membimbing_Pa($id_programstudi)
	{
		$data = $this->db->query('select kegiatan_dosen.id_dosen as id_dosen, kegiatan_dosen.kode_kegiatan as kode_kegiatan, kegiatan.nama as namakegiatan, kegiatan_dosen.tanggal_kegiatan as tanggal, kegiatan_dosen.id_kegiatan_dosen as id_kegiatan_dosen , kegiatan_dosen.id_program_studi as id_prodi, dosen.nama as namaD, dosen.nip as nipD, kegiatan_dosen.deskripsi as deskripsi, kegiatan_dosen.sks as sks, kegiatan_dosen.no_sk_kontrak as no_sk_kontrak from kegiatan_dosen join dosen on kegiatan_dosen.id_dosen=dosen.id_dosen join kegiatan on kegiatan_dosen.kode_kegiatan=kegiatan.kode_kegiatan where kegiatan_dosen.id_program_studi=' . $id_programstudi . ' and kegiatan_dosen.kode_kegiatan in (13,14,15,16,48,49,51,52,53,54,56,57)');
		return $data->result_array();
	}

	public function get_Menguji_Ta($id_programstudi, $data = null)
	{
		// $data = $this->db->query('kegiatan_dosen.kode_kegiatan in (36,37,38,39,40,317,41,42,43,44,45,46,47,315,316)');
		$this->db->select('kegiatan_dosen.id_kegiatan_dosen as id_kegiatan_dosen, kegiatan_dosen.id_dosen as id_dosen, kegiatan_dosen.kode_kegiatan as kode_kegiatan, kegiatan.nama as namakegiatan, no_sk_kontrak, kegiatan_dosen.tanggal_kegiatan as tanggal, kegiatan_dosen.id_program_studi as id_prodi, dosen.nama as namaD, dosen.nip as nipD, kegiatan_dosen.deskripsi as deskripsi, kegiatan_dosen.sks as sks, kegiatan_dosen.no_sk_kontrak as no_sk_kontrak, kegiatan_dosen.status as status_kegiatan');
		$this->db->from('kegiatan_dosen');
		$this->db->join('dosen', 'kegiatan_dosen.id_dosen=dosen.id_dosen');
		$this->db->join('kegiatan', 'kegiatan_dosen.kode_kegiatan=kegiatan.kode_kegiatan');
		$this->db->where('kegiatan_dosen.id_program_studi', $id_programstudi);
		$this->db->where_in("kegiatan_dosen.kode_kegiatan", array(36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 315, 316, 317, 321));
		// $this->db->where("kegiatan.induk", '35');
		// $this->db->where("kegiatan.kategori", '3');
		if (!empty($data['tahun'])) {
			$this->db->where('YEAR(kegiatan_dosen.tanggal_kegiatan)', $data['tahun']);
		}
		if (!empty($data['bulan']) && $data['bulan'] > 0) {
			$this->db->where('month(kegiatan_dosen.tanggal_kegiatan)', $data['bulan']);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_Menguji_Taubah($id)
	{
		$data = $this->db->query("SELECT kegiatan_dosen.id_kegiatan_dosen as id_kegiatan_dosen, kegiatan_dosen.id_dosen as id_dosen, kegiatan_dosen.kode_kegiatan as kode_kegiatan, kegiatan.nama as namakegiatan, kegiatan_dosen.tanggal_kegiatan as tanggal, kegiatan_dosen.id_program_studi as id_prodi, dosen.nama as namaD, dosen.nip as nipD, kegiatan_dosen.deskripsi as deskripsi, kegiatan_dosen.sks as sks, kegiatan_dosen.no_sk_kontrak as no_sk_kontrak from kegiatan_dosen join dosen on kegiatan_dosen.id_dosen=dosen.id_dosen join kegiatan on kegiatan_dosen.kode_kegiatan=kegiatan.kode_kegiatan WHERE `id_kegiatan_dosen` ='" . $id . "'");
		return $data->result_array();
	}

	public function get_Kegiatan_MembimbingTa()
	{
		//$data = $this->db->query('select * from kegiatan where kode_kegiatan in (16,17,25,26,44)');
		$data = $this->db->query('select * from kegiatan where kode_kegiatan in (17,18,19,20,25,26,27,28)');
		return $data->result_array();
	}

	public function get_Kegiatan_MengujiTa()
	{

		//$data = $this->db->query('select * from kegiatan where kode_kegiatan=35');
		$data = $this->db->query('select * from kegiatan where kode_kegiatan in (36,37,38,39,40,317,41,42,43,47,315,316)');
		return $data->result_array();
	}
	public function get_Lainya($id_program_studi)
	{

		$data = $this->db->query('select kegiatan_dosen.id_kegiatan_dosen as id_kegiatan_dosen, kegiatan_dosen.kode_kegiatan as kode_kegiatan, kegiatan.nama as nama_kegiatan, kegiatan_dosen.id_dosen as id_dosen, dosen.nama as nama_dosen, kegiatan_dosen.tanggal_kegiatan as tanggal_kegiatan, kegiatan_dosen.kode_kegiatan as kode_kegiatan, kegiatan_dosen.sks as sks, kegiatan_dosen.deskripsi as deskripsi, kegiatan_dosen.no_sk_kontrak as no_sk_kontrak from kegiatan_dosen join dosen on kegiatan_dosen.id_dosen=dosen.id_dosen join kegiatan on kegiatan_dosen.kode_kegiatan=kegiatan.kode_kegiatan where kegiatan_dosen.kode_kegiatan in (13,14,15,45,46,48,49,51,52,53,54,55,56,57,321)');
		return $data->result_array();
	}

	public function get_Kegiatan_Lainya()
	{

		$data = $this->db->query('select * from kegiatan where kode_kegiatan in (12,13,15,44,47,50)');
		return $data->result_array();
	}

	public function get_jenjang_pendidikan($id_programstudi)
	{
		$data = $this->db->query('select id_jenjang_pendidikan from program_studi where id_program_studi=' . $id_programstudi);
		return $data->result_array();
	}

	public function getMatakuliahALL()
	{
		$query = $this->db->get('matakuliah');
		return $query->result();
	}

	public function getDosenAll()
	{
		$this->db->where_in('id_status_dosen', array('1', '2', '7'));
		$query = $this->db->get('dosen');
		return $query->result();
	}

	public function get_mk_diKelas_Kuliah($id_programstudi, $tahunakademik, $semester)
	{
		$data = $this->db->query('select * from kelas_kuliah where id_program_studi=' . $id_programstudi . ' and tahun_akademik=' . $tahunakademik . ' and semester=' . $semester);

		return $data->result_array();
	}

	public function get_Data_Kegiatan($kode_jenis_kegiatan)
	{
		$data = $this->db->query('select * from kegiatan where kode_jenis_kegiatan=' . $kode_jenis_kegiatan);
		return $data->result_array();
	}

	public function get_Kelas_Kuliah($id_programstudi, $tahunakademik, $semester)
	{
		$data = $this->db->query('select kelas_kuliah.kode_kegiatan as kode_kegiatan, matakuliah.nama as namamatakuliah, dosen.nama as namadosen, kelas_kuliah.id_kelas_kuliah as id_kelaskuliah, kelas_kuliah.id_program_studi, kelas_kuliah.id_dosen as id_dosen, kelas_kuliah.id_matakuliah as id_matakuliah, kelas_kuliah.tahun_akademik as tahunakademik, kelas_kuliah.semester as semester, kelas_kuliah.no_sk_kontrak as no_sk_kontrak, kelas_kuliah.hari as hari, kelas_kuliah.waktu_mulai as waktu_mulai,kelas_kuliah.sks_pertemuan as sks, kelas_kuliah.ruang as ruang, kelas_kuliah.jumlah_peserta as peserta from kelas_kuliah join matakuliah on kelas_kuliah.id_matakuliah=matakuliah.id_matakuliah join dosen on kelas_kuliah.id_dosen=dosen.id_dosen where kelas_kuliah.id_program_studi=' . $id_programstudi . ' and kelas_kuliah.tahun_akademik=' . $tahunakademik . ' and kelas_kuliah.semester=' . $semester);

		return $data->result_array();
	}

	public function get_Dosen_Mengajar($id_programstudi, $tahunakademik, $semester)
	{
		$data = $this->db->query('select distinct kelas_kuliah.id_dosen as id_dosen,dosen.nama as namadosen, dosen.nip as nip, kelas_kuliah.id_program_studi, kelas_kuliah.id_dosen from kelas_kuliah join matakuliah on kelas_kuliah.id_matakuliah=matakuliah.id_matakuliah join dosen on kelas_kuliah.id_dosen=dosen.id_dosen where kelas_kuliah.id_program_studi=' .
			$id_programstudi . ' and kelas_kuliah.tahun_akademik=' . $tahunakademik . ' and kelas_kuliah.semester=' . $semester);

		return $data->result_array();
	}

	public function get_Agregat_Kegiatan_Mengajar($id_kelas_kuliah, $dosen, $id_program_studi, $tahun = null)
	{
		$sql = "SELECT count(id_kegiatan_dosen) as jumlah_pertemuan
				FROM kegiatan_dosen
				where id_dosen = '" . $dosen . "'
				and id_program_studi = '" . $id_program_studi . "'
				and deskripsi like '%kelas\":\"" . $id_kelas_kuliah . "\"%' GROUP BY id_dosen";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function get_Kegiatan_Mengajar_By_ID_Kelas_Kuliah($id_kelas_kuliah)
	{
		//$sql = "SELECT * from kegiatan_dosen kd where kd.deskripsi like '%\"".$id_kelas_kuliah."\"%' ORDER BY kd.tanggal_entry";
		$sql = "SELECT * from kegiatan_dosen kd where kd.deskripsi like '%\"kelas\":\"" . $id_kelas_kuliah . "\",%' ORDER BY kd.tanggal_entry";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function UpdateKegiatanDosenByKelasKuliah($data)
	{
		$sql = "update kegiatan_dosen SET id_dosen='" . $data['id_dosen'] . "', kode_kegiatan='" . $data['kode_kegiatan'] . "', no_sk_kontrak='" . $data['no_sk_kontrak'] . "', sks='" . $data['sks'] . "' where deskripsi like '%kelas" . '":"' . $data['id_kelaskuliah'] . '",' . "%'";
		$res = $this->db->query($sql);

		return $res;
	}

	public function get_Kelas_Kuliahbyid($id_kelas_kuliah)
	{
		$data = $this->db->query('SELECT kelas_kuliah.kode_kegiatan as kode_kegiatan, 
										kegiatan.nama as nama_kegiatan, 
										matakuliah.nama as nama_matakuliah, 
										dosen.nama as namadosen, 
										kelas_kuliah.id_kelas_kuliah as id_kelaskuliah, 
										kelas_kuliah.id_matakuliah as id_matakuliah, 
										kelas_kuliah.id_dosen as id_dosen,
										kelas_kuliah.tahun_akademik as tahunakademik, 
										kelas_kuliah.semester as semester,
										kelas_kuliah.no_sk_kontrak as no_sk_kontrak, 
										kelas_kuliah.hari as hari, 
										kelas_kuliah.waktu_mulai as waktu_mulai,
										kelas_kuliah.sks_pertemuan as sks, 
										kelas_kuliah.ruang as ruang,
										kelas_kuliah.jumlah_peserta as peserta 
										from kelas_kuliah join matakuliah on kelas_kuliah.id_matakuliah=matakuliah.id_matakuliah 
										join dosen on kelas_kuliah.id_dosen=dosen.id_dosen 
										join kegiatan on kelas_kuliah.kode_kegiatan=kegiatan.kode_kegiatan 
										where kelas_kuliah.id_kelas_kuliah=' . $id_kelas_kuliah);

		return $data->result_array();
	}
	public function Get_matakuliahbynama($namamatakuliah)
	{
		$data = $this->db->query('select * from matakuliah where nama LIKE "%' . $namamatakuliah . '%"');
		return $data->result_array();
	}
	public function get_Mata_Kuliah($id_programstudi)
	{
		$data = $this->db->query('select * from matakuliah where id_program_studi=' . $id_programstudi);
		return $data->result_array();
	}
	public function get_Mata_Kuliahbymatkul($id_programstudi, $id_matkul)
	{
		$data = $this->db->query('select * from matakuliah where id_program_studi=' . $id_programstudi . ' and id_matakuliah=' . $id_matkul);
		return $data->result_array();
	}
	public function get_Nama_Prodi($id_programstudi)
	{
		$data = $this->db->query('select nama from program_studi where id_program_studi=' . $id_programstudi);
		return $data->result_array();
	}
	public function get_RiwayatGolongan($nip)
	{

		$data = $this->db->query('select * from riwayat_golongan where nip="' . $nip . '"');
		return $data->result_array();
	}

	public function get_RiwayatPendidikan($nip)
	{
		$data = $this->db->query('select * from pendidikan where nip="' . $nip . '"');
		return $data->result_array();
	}

	public function get_RiwayatJabatanFungsional($nip)
	{
		$data = $this->db->query('select * from jabatan_fungsional where nip="' . $nip . '"');
		return $data->result_array();
	}

	public function get_RiwayatJabatanStruktural($nip)
	{
		$data = $this->db->query('select * from jabatan_struktural where nip="' . $nip . '"');
		return $data->result_array();
	}

	public function InsertData($tabelName, $data)
	{
		$res = $this->db->insert($tabelName, $data);
		return $res;
	}

	public function UpdateData()
	{
	}

	public function DeleteData()
	{
	}

	public function countMatkul($data)
	{
		$res = $this->db->from("kelas_kuliah")->where('id_matakuliah', $data)->count_all_results();
		return $res;
	}

	public function datakegiatan($a)
	{
		$data = $this->db->query("SELECT * FROM `kegiatan` WHERE `kode_jenis_kegiatan` = '" . $a . "' and induk='0' order by kode_kegiatan ASC");
		return $data->result_array();
	}

	function partition($table, $tahun)
	{
		$tabel = ($tahun > 0) ? $table . " PARTITION (p" . $tahun . ")" : $table;
		return $tabel;
	}
}
