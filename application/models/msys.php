<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MSys extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function get_all()
	{
		$sql = "select * from dbo.att_param";
		return $this->db->query($sql);
	}

	public function get_info($kod)
	{
		$sql = "select * from dbo.att_param
		where param_kod = '$kod'";
		$rst = $this->db->query($sql);
		$row = $rst->row();
		return $row;
	}

	public function get_param($kod)
	{
		$sql = "select * from dbo.att_param
		where param_kod = '$kod'";
		$rst = $this->db->query($sql);
		$row = $rst->row();
		return $row->param_value;
	}

	public function update($fields)
	{
		$this->db->where('param_kod', $fields['param_kod']);
		$this->db->update('dbo.att_param', $fields);
	}
}
?>
