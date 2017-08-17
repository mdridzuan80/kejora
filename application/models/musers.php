<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MUsers extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function checkUser($username,$password,$domain,$status) {
		$query = $this->db->get_where('att_users', array('username'=>$username,'password'=>$password,'domain'=>$domain,'status'=>$status));
		return $query->num_rows();
	}
	
	public function getUsers()
	{
		$query = $this->db->get('att_users');
		return $query;
	}
	
	public function checkUserAD($username,$domain,$status)
	{
		$query = $this->db->get_where('att_users', array('username'=>$username,'domain'=>$domain,'status'=>$status));
		return $query->num_rows();
	}
	
	public function addUser($data)
	{
		return $this->db->insert('att_users', $data); 
	}
	
	public function getUserAD($username,$domain,$status)
	{
		$query = $this->db->get_where('att_users', array('username'=>$username,'domain'=>$domain,'status'=>$status));
		return $query;
	}
	
	public function do_delete($user_id)
	{
		$this->db->delete('dbo.att_users', array('id' => $user_id));	
	}
}

?>
