<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MTimeslip extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function do_mohon($fields)
	{	
		if($this->db->insert('PCRS.att_timeslip', $fields))
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
		$sql = "select b.ts_id, a.Badgenumber, a.Name, a.SSN, a.TITLE, convert(varchar, b.ts_chkout, 120) as ts_chkout, convert(varchar, b.ts_chkin, 120) as ts_chkin, b.ts_status, b.ts_validatename, convert(varchar, b.ts_validate, 120) as ts_validate, b.ts_pengesah, convert(varchar, b.ts_date, 120) as ts_date  
				from USERINFO a, PCRS.att_timeslip b
				where a.USERID=b.ts_userid
				and b.ts_status <> 'B'";
		if($this->session->userdata('role')==4)
			$sql .= " and a.USERID = " . $this->session->userdata('uid');
		if($this->session->userdata('role')==2 or  $this->session->userdata('role')==3 or $this->session->userdata('role')==5)
			$sql .= " and a.DEFAULTDEPTID = " . $this->session->userdata('dept');
		$sql .= " order by 6 desc";
		
		$query = $this->db->query($sql);
		return $query;	
	}
	
	public function getPermohonanKelulusan($dept_id = array())
	{
		$this->db->select('b.ts_id, a.Badgenumber, a.Name, a.SSN, a.TITLE, convert(varchar, b.ts_chkout, 120) as ts_chkout, convert(varchar, b.ts_chkin, 120) as ts_chkin, b.ts_status, b.ts_alasan');
		$this->db->from('USERINFO a');
		$this->db->join('PCRS.att_timeslip b', 'a.USERID=b.ts_userid');
		$this->db->where('b.ts_status','M');
		if($this->session->userdata('role')==2 or  $this->session->userdata('role')==3 or $this->session->userdata('role')==5 or $this->session->userdata('role')==4)
			$this->db->where('a.DEFAULTDEPTID',$this->session->userdata('dept'));
		if($this->session->userdata('pelulus') == true)
			$this->db->where_in('a.DEFAULTDEPTID',$dept_id);
		$this->db->where('a.USERID <>', $this->session->userdata('uid'));
		$this->db->order_by('6','desc');
		
		$query = $this->db->get();
//dd($this->db->last_query());
		return $query;	
	}

	public function get_permohonan_pengesahan($dept_id = array())
	{
		$this->db->select('b.ts_id, a.Badgenumber, a.Name, a.SSN, a.TITLE, convert(varchar, b.ts_chkout, 120) as ts_chkout, convert(varchar, b.ts_chkin, 120) as ts_chkin, b.ts_status, b.ts_alasan');
		$this->db->from('USERINFO a');
		$this->db->join('PCRS.att_timeslip b', 'a.USERID=b.ts_userid');
		$this->db->where('b.ts_status','L');
		$this->db->where('b.ts_PENGESAH',NULL);
		if($this->session->userdata('role')==2 or  $this->session->userdata('role')==3 or $this->session->userdata('role')==5)
			$this->db->where('a.DEFAULTDEPTID',$this->session->userdata('dept'));
		if($this->session->userdata('pelulus') == true)
			$this->db->where_in('a.DEFAULTDEPTID',$dept_id);
		$this->db->where('a.USERID <>', $this->session->userdata('uid'));
		$this->db->order_by('6','desc');
		
		$query = $this->db->get();
		return $query;	
	}
	
	public function setKelulusan($mohon_id, $flag)
	{
		$this->db->where('ts_id', $mohon_id);
		$this->db->update('PCRS.att_timeslip', array('ts_status'=>$flag,
													'ts_validateuserid'=>$this->session->userdata('uid'),
													'ts_validatename'=>$this->session->userdata('userid'),
													'ts_validate'=>date('Y-m-d H:i:s'))); 	
	}
	
	public function setPengesahan($mohon_id)
	{
		$this->db->where('ts_id', $mohon_id);
		$this->db->update('PCRS.att_timeslip', array('ts_pengesah'=>$this->session->userdata('userid'),
													'ts_date'=>date('Y-m-d H:i:s'))); 	
	}
	
	public function do_batal($id)
	{
		$this->db->where('ts_id', $id);
		return $this->db->update('PCRS.att_timeslip',array('ts_status'=>'B',
														'ts_validateuserid'=>$this->session->userdata('uid'),
														'ts_validatename'=>$this->session->userdata('userid'),
														'ts_validate'=>date('Y-m-d H:i:s')));
	}
	
	public function chk_status($id)
	{
		$this->db->select('ts_status');
		$this->db->where('ts_id', $id);
		$query = $this->db->get('PCRS.att_timeslip');
		if($query->num_rows()){
			$row = $query->row();
			return $row->ts_status;
		}else{
			return false;	
		}
	}
	
	public function get_user_id($mohon_id)
	{
		$query = $this->db->get_where('PCRS.att_timeslip', array('ts_id' => $mohon_id));
		$row = $query->row();
		return $row->ts_userid;
	}
	
	public function get_maklumat($mohon_id)
	{
		$sql = "SELECT
				dbo.USERINFO.Name,
				pcrs.att_timeslip.ts_id,
				pcrs.att_timeslip.ts_alasan,
				pcrs.att_timeslip.ts_chkout,
				pcrs.att_timeslip.ts_chkin,
				pcrs.att_timeslip.ts_status,
				pcrs.att_timeslip.ts_validateuserid,
				pcrs.att_timeslip.ts_validatename,
				pcrs.att_timeslip.ts_validate,
				pcrs.att_timeslip.ts_pengesah,
				pcrs.att_timeslip.ts_date
				FROM
				pcrs.att_timeslip
				INNER JOIN dbo.USERINFO ON pcrs.att_timeslip.ts_userid = dbo.USERINFO.USERID
				WHERE PCRS.att_timeslip.ts_id=" . $mohon_id;
		$query = $this->db->query($sql);
		
		return $query;
	}

}
?>
