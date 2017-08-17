<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MPelulus extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function getAll()
	{
		$this->db->select('a.pl_id, b.Name, c.DEPTNAME, d.DEPTNAME as pl_dept, a.pl_role');
		$this->db->from('dbo.att_pelulus a');
		$this->db->join('dbo.USERINFO b', 'a.pl_user_id = b.USERID');
		$this->db->join('dbo.DEPARTMENTS c', 'b.DEFAULTDEPTID = c.DEPTID');
		$this->db->join('dbo.DEPARTMENTS d', 'a.pl_deptid = d.DEPTID');
		if($this->session->userdata('role')==4 || $this->session->userdata('role')==5)
			$this->db->where('a.pl_deptid', $this->session->userdata('dept'));
		return $this->db->get();	
	}
	
	public function simpan($fields)
	{
		$this->db->insert('dbo.att_pelulus', $fields); 
	}
	
	public function chkPriv($uid)
	{
		$priv = false;
		$this->db->from('dbo.att_pelulus');
		$this->db->where('pl_user_id', $uid);
		$chk = $this->db->get();
		if($chk->num_rows() != 0){
			$priv = true;
		}
		return $priv;
	}
	
	public function getDeptId()
	{
		$this->db->select('pl_deptid');
		$this->db->from('dbo.att_pelulus');
		$this->db->where('pl_user_id', $this->session->userdata('uid'));
		return $this->db->get();
	}

	public function do_hapus($pl_id)
	{
		$this->db->delete('dbo.att_pelulus', array('pl_id' => $pl_id)); 	
	}
	
	public function get_pelulus($dept_id)
	{
		$this->db->select('a.pl_id, b.NAME, c.DEPTNAME, d.DEPTNAME as pl_dept, a.pl_role, b.Email');
		$this->db->from('dbo.att_pelulus a');
		$this->db->join('dbo.USERINFO b', 'a.pl_user_id = b.USERID');
		$this->db->join('dbo.DEPARTMENTS c', 'b.DEFAULTDEPTID = c.DEPTID');
		$this->db->join('dbo.DEPARTMENTS d', 'a.pl_deptid = d.DEPTID');
		$this->db->where('a.pl_deptid', $dept_id);
		return $this->db->get();	
	}
	
	public function get_pelulus_kj($dept_id)
	{
		$this->db->select('a.pl_id, b.Name, c.DEPTNAME, d.DEPTNAME as pl_dept, a.pl_role, b.street');
		$this->db->from('dbo.att_pelulus a');
		$this->db->join('dbo.USERINFO b', 'a.pl_user_id = b.USERID');
		$this->db->join('dbo.DEPARTMENTS c', 'b.DEFAULTDEPTID = c.DEPTID');
		$this->db->join('dbo.DEPARTMENTS d', 'a.pl_deptid = d.DEPTID');
		$this->db->where('a.pl_deptid', $dept_id);
		$this->db->where('a.pl_role', 'Y');
		$kj = $this->db->get();
		if($kj->num_rows() != 0)
		{
			$row = $kj->row();
			return $row->Name;
		}
		else
		{
			return '';
		}
	}
	
	public function chk_kj($uid)
	{
		$priv = false;
		$this->db->from('dbo.att_pelulus');
		$this->db->where('pl_user_id', $uid);
		$this->db->where('pl_role', 'Y');
		$chk = $this->db->get();
		if($chk->num_rows() != 0){
			$priv = true;
		}
		return $priv;
	}
}
