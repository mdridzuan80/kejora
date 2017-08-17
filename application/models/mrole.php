<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MRole extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function getAll()
	{
		$query = $this->db->get('att_role');
		return $query;	
	}
	
	public function get_email_by_role($dept_id, $role)
	{
		$email = array();
		$sql = "SELECT
				dbo.USERINFO.street
				
				FROM
				dbo.att_users
				INNER JOIN dbo.USERINFO ON dbo.att_users.userid = dbo.USERINFO.USERID
				WHERE
				dbo.att_users.roleid = $role
				AND
				dbo.USERINFO.DEFAULTDEPTID = $dept_id
				";
		$rst = $this->db->query($sql);
		foreach($rst->result() as $row)
		{
			$email[] = $row->street;	
		}
		return $email;
	}
}

?>
