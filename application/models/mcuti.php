<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MCuti extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function getAll($tahun)
	{
		$this->db->select('cuti_id, convert(varchar, cuti_mula, 120) as cuti_mula, cuti_perihal');
		$this->db->from('PCRS.att_cuti');
		$this->db->where('YEAR(cuti_mula)=',$tahun);
		$this->db->order_by('cuti_mula', 'asc');
		$rst = $this->db->get();
		return $rst;	
	}
	
	public function do_save($medan)
	{
		$this->db->insert('PCRS.att_cuti', $medan);
	}
	
	public function do_hapus($cuti_id)
	{
		$this->db->delete('PCRS.att_cuti', array('cuti_id' => $cuti_id)); 	
	}
	
	public function get_by_bulan_tahun($bulan, $tahun)
	{
		$result = array();
		$this->db->select('cuti_id, convert(varchar, cuti_mula, 120) as cuti_mula, cuti_perihal');
		$this->db->from('PCRS.att_cuti');
		$this->db->where('MONTH(cuti_mula)=',$bulan);
		$this->db->where('YEAR(cuti_mula)=',$tahun);
		$this->db->order_by('cuti_mula', 'asc');
		$rst = $this->db->get();
		
		foreach($rst->result() as $row){
				$result[date('Y-m-d',strtotime($row->cuti_mula))] = $row->cuti_perihal; 
		}
		return $result;
	}
	
	public function check_cuti($hari, $bulan, $tahun)
	{
		$this->db->select('cuti_id, convert(varchar, cuti_mula, 120) as cuti_mula, cuti_perihal');
		$this->db->from('PCRS.att_cuti');
		$this->db->where('DAY(cuti_mula)=',$hari);
		$this->db->where('MONTH(cuti_mula)=',$bulan);
		$this->db->where('YEAR(cuti_mula)=',$tahun);
		$this->db->order_by('cuti_mula', 'asc');
		$rst = $this->db->get();
		return $rst->num_rows();
	}
	
	public function check_cuti_by_range_day($tkh1, $tkh2)
	{
		$this->db->select('cuti_id, convert(varchar(10), cuti_mula, 120) as cuti_mula, cuti_perihal');
		$this->db->from('PCRS.att_cuti');
		$this->db->where('convert(varchar(10), cuti_mula, 120)>=',$tkh1);
		$this->db->where('convert(varchar(10), cuti_mula, 120)<=',$tkh2);
		$this->db->order_by('cuti_mula', 'asc');
		$rst = $this->db->get();
		$result = array();
		
		foreach($rst->result() as $row){
			$result[date('Y-m-d',strtotime($row->cuti_mula))] = $row->cuti_perihal; 
		}
		return $result;
	}
}
