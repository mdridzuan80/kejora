<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MMachine extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function get_enable()
	{
		$sql = "select * from dbo.Machines where Enabled = 1";
		$rst = $this->db->query($sql);
		return $rst;
	}
}
?>
