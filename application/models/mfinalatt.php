<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MFinalAtt extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function getAll()
	{
		$query = $this->db->get('dbo.att_final_attendance');
		return $query;
	}

	public function get_ts_by_bulan_tahun($userid, $bulan, $tahun)
	{
		$this->db->where('rpt_userid', $userid);
		$this->db->where('MONTH(rpt_tarikh)', $bulan);
		$this->db->where('YEAR(rpt_tarikh)', $tahun);
		$this->db->order_by('rpt_tarikh');
		$query = $this->db->get('dbo.att_final_attendance');
		return $query;
	}

	public function get_rekod_punch_inout($medan, $tkh_terlibat) //medan: string, tkh_terlibat date (yyyy-mm-dd) return true/false
	{
		$sql = "select convert(varchar,rpt_check_in,120) as rpt_check_in, convert(varchar,rpt_check_out,120) as rpt_check_out from dbo.att_final_attendance
			where 1=1
			and convert(varchar(10), $medan, 120) = '$tkh_terlibat'
			and rpt_userid = " . $this->session->userdata('uid');
		$rst = $this->db->query($sql);
		$row = $rst->row_array();
		return $row[$medan];
	}
}

?>
