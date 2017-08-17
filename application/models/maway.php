<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MAway extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function do_mohon($fields)
	{	
		if($this->db->insert('dbo.att_away', $fields))
		{
			return $this->db->insert_id();	
		}
		else
		{
			return FALSE;
		}
	}
	
	public function getPermohonan()
	{
		$sql = "select b.aw_id, a.Badgenumber, a.Name, a.SSN, a.TITLE, convert(varchar, b.aw_chkout, 120) as aw_chkout, convert(varchar, b.aw_chkin, 120) as aw_chkin, b.aw_alasan
				from USERINFO a, att_away b
				where a.USERID=b.aw_userid";
		if($this->session->userdata('role')==4)
			$sql .= " and a.USERID = " . $this->session->userdata('uid');
		if($this->session->userdata('role')==2 or  $this->session->userdata('role')==3 or $this->session->userdata('role')==5)
			$sql .= " and a.DEFAULTDEPTID = " . $this->session->userdata('dept');
		$sql .= " order by 6 desc";
		
		$query = $this->db->query($sql);
		return $query;	
	}
			
	public function do_batal($id)
	{
		$this->db->where('aw_id', $id);
		return $this->db->update('dbo.att_away',array('aw_status'=>'B'));
	}
	
	public function chk_status($id)
	{
		$this->db->select('ts_status');
		$this->db->where('ts_id', $id);
		$query = $this->db->get('dbo.att_timeslip');
		if($query->num_rows()){
			$row = $query->row();
			return $row->ts_status;
		}else{
			return false;	
		}
	}
}
?>
