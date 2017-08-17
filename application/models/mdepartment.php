<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MDepartment extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
		
	public function getDepartments()
	{
		$query = $this->db->get_where('dbo.DEPARTMENTS',array('DEPTID'=>1));
		return $query;
	}
	
	public function getUnits($deptid)
	{
		$this->db->where('SUPDEPTID', $deptid); 
		if($this->session->userdata('role')==4 || $this->session->userdata('role')==5)
		{
			$this->db->where('DEPTID', $this->session->userdata('dept')); 
		}
		$this->db->order_by('DEPARTMENTS.DEPTNAME');
		$query = $this->db->get('dbo.DEPARTMENTS');
		return $query;
	}

	public function getUnitsPPP($deptid)
	{
		$this->db->where('SUPDEPTID', $deptid);
		if($this->session->userdata('role') != 1)
		{
			$this->db->where_in('DEPTID', $this->session->userdata('browse_dept')); 
		}
		$this->db->order_by('DEPARTMENTS.DEPTNAME');
		$query = $this->db->get('dbo.DEPARTMENTS');
		return $query;
	}
	
	public function get_parent_dept($dept_id)
	{
		if($dept_id != 0)
		{
			$sql = "select * from dbo.DEPARTMENTS where DEPTID=$dept_id";	
			$query = $this->db->query($sql);
			$row = $query->row();
			return $row->SUPDEPTID;
		}
		else
		{
			return 0;	
		}
	}
	
	public function get_sub_dept()
	{
		$sql = "select * from dbo.DEPARTMENTS where SUPDEPTID=1";	
		return $this->db->query($sql);
	}

	public function get_user_dept()
	{
		$sql = "select * from dbo.DEPARTMENTS
				where DEPTID in(select DISTINCT DEFAULTDEPTID from dbo.USERINFO)";	
		return $this->db->query($sql);
	}
	
	public function get_department_name($dept_id)
	{
		$this->db->where('DEPTID', $dept_id); 
		$this->db->order_by('DEPARTMENTS.DEPTNAME');
		$query = $this->db->get('dbo.DEPARTMENTS');
		$row = $query->row();
		return $row->DEPTNAME;
	}
	
	public function all()
	{
		$sql = "select * from dbo.DEPARTMENTS";
		$dept = $this->db->query($sql);
		return $dept;
	}
	
	public function recursive()
	{
		$sql = "select DEPTID, SUPDEPTID from dbo.DEPARTMENTS";
		$dept = $this->db->query($sql);
		return $dept;
	}
	
	public function check_exists_sub($dept_id)
	{
		$this->db->where('SUPDEPTID', $dept_id);
		$query = $this->db->get('dbo.DEPARTMENTS');
		if($query->num_rows()== 0)
		{
			return false;	
		}
		else
		{
			return true;
		}
	}
}
