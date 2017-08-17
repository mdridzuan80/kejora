<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MWbb extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function get_start_time($wbb_id, $user_id, $bulan, $tahun)
	{
		$this->db->where('NUM_RUNID', $wbb_id);
		$this->db->where('USERID', $user_id);
		$this->db->where('MONTH', $bulan);
		$this->db->where('YEAR', $tahun);
		$rst = $this->db->get('dbo.view_WBB');
		$row = $rst->row();
		return $row->STARTTIME;
	}

	public function get_start_shift_by_user($user_id, $bulan, $tahun)
	{
		$this->db->where('USERID', $user_id);
		$this->db->where('MONTH', $bulan);
		$this->db->where('YEAR', $tahun);
		$rst = $this->db->get('dbo.view_WBB');
		if($rst->num_rows())
		{
			$row = $rst->row();
			return $row->STARTTIME;
		}
		else
		{
			return false;
		}
	}

	public function get_start_shift_by_user_wbb($user_id, $tarikh)
	{
		$sql = "select * from pcrs.view_WBB_daily
				where USERID = $user_id
				and convert(varchar(10), STARTDATE, 120) <= '$tarikh'
				and convert(varchar(10), ENDDATE, 120) >= '$tarikh'";

		$rst = $this->db->query($sql);
		if($rst->num_rows())
		{
			$row = $rst->row();
			return array($row->STARTTIME, $row->NUM_RUNID, $row->ENDTIME);
		}
		else
		{
			return false;
		}
	}

	public function check_exist_wbb($user_id, $bulan, $tahun)
	{
		$this->db->where('USERID', $user_id);
		$this->db->where('MONTH', $bulan);
		$this->db->where('YEAR', $tahun);
		$rst = $this->db->get('dbo.view_WBB');
		return $rst;
	}

	public function get_staff_wbb($user_id, $bulan, $tahun)
	{
		$this->db->where('USERID', $user_id);
		$this->db->where('MONTH', $bulan);
		$this->db->where('YEAR', $tahun);

		$rst = $this->db->get('dbo.view_WBB');

		if($rst->num_rows() != 0)
		{
			$row = $rst->row();
			return $row->NAME;
		}
	}

	public function get_dict_wbb()
	{
		$rst = $this->db->get('dbo.NUM_RUN');
		return $rst;
	}

		public function check_exist_wbb_shift($user_id, $mula, $tamat)
	{
		$sql = "select * from pcrs.view_WBB_daily
				where USERID = $user_id
				and ((convert(varchar(10), STARTDATE,120) >= '$mula'
				and convert(varchar(10), STARTDATE,120) <= '$tamat')
				or (convert(varchar(10), ENDDATE,120) >= '$mula'
				and convert(varchar(10), ENDDATE,120) <= '$tamat'))";
		$rst = $this->db->query($sql);
		return $rst;
	}

	public function get_start_time_shift($wbb_id, $user_id, $mula, $tamat)
	{
		$sql = "select * from pcrs.view_WBB_daily
				where USERID = $user_id
				AND NUM_RUNID = $wbb_id
				and convert(varchar(10), STARTDATE,120) >= '$mula'
				and convert(varchar(10), ENDDATE,120) <= '$tamat'";

		$rst = $this->db->query($sql);
		$row = $rst->row();
		return $row->STARTTIME;
	}

	public function get_wbb_desc($id)
	{
		$sql = "select NAME from dbo.NUM_RUN
				where NUM_RUNID = $id";
		$rst = $this->db->query($sql);
		$row = $rst->row();
		return $row->NAME;
	}
}
