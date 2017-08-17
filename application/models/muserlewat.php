<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Muserlewat extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function do_hapus($user_id, $month, $year)
	{
		$this->db->where('USERID', $user_id);
		$this->db->where('month(CHECKTIME)=', $month);
		$this->db->where('year(CHECKTIME)=', $year);
		$this->db->delete('dbo.USER_LATE_SMS');
	}

	public function get_checkinout($user_id, $bulan, $tahun)
	{
		$data = array($user_id, $bulan, $tahun);
		$sql = 'select count(USERID) as jumlah
				from dbo.CHECKINOUT
				where USERID = ? and month(CHECKTIME) = ? and year(CHECKTIME) = ?';
		$rst = $this->db->query($sql, $data);
		$row = $rst->row();
		return $row->jumlah;
	}

	public function do_save($medan)
	{
		$this->db->insert('dbo.USER_LATE_SMS', $medan);
	}

	public function jumlah_lewat($user_id, $bulan, $tahun)
	{
		$sql = "select *
				from dbo.view_LATE
				where 1=1
				and USERID = $user_id
				and MONTH = $bulan
				and YEAR = $tahun";
		return $this->db->query($sql);
	}

	public function do_update($user_id, $tarikh, $medan)
	{
		$this->db->where('USERID', $user_id);
		$this->db->where('convert(varchar(10), CHECKTIME, 120)=', $tarikh);
		$this->db->update('dbo.USER_LATE_SMS', $medan);
	}

	public function get_checkinout_shift($user_id, $mula, $tamat)
	{
		$sql = "select count(USERID) as jumlah
				from dbo.CHECKINOUT
				where USERID = $user_id
				and convert(varchar(10),CHECKTIME,120) >= '$mula'
				and convert(varchar(10),CHECKTIME,120) <= '$tamat' ";
		$rst = $this->db->query($sql);
		$row = $rst->row();
		return $row->jumlah;
	}

	public function do_hapus_daily($user_id, $mula, $tamat)
	{
		$sql = "delete from USER_LATE_SMS
				WHERE convert(varchar(10),CHECKTIME,120) >= '$mula'
				AND convert(varchar(10),CHECKTIME,120) <= '$tamat'
				AND USERID = $user_id";
		$this->db->query($sql);
	}

	public function get_user_lewat($user_id, $bulan, $tahun)
	{
		$sql = "SELECT COUNT(dbo.view_LATE.ID) AS lewat, dbo.view_LATE.NAME, dbo.view_LATE.DEPTNAME, dbo.view_LATE.TITLE
			FROM dbo.view_LATE
			WHERE 1 = 1
			AND dbo.view_LATE.USERID = " . $user_id . "
		 	AND dbo.view_LATE.MONTH = " . $bulan . "
			AND dbo.view_LATE.YEAR = " . $tahun . "
			GROUP BY dbo.view_LATE.NAME, dbo.view_LATE.DEPTNAME, dbo.view_LATE.TITLE";
		return $this->db->query($sql);
	}

	public function get_kod_warna($user_id, $bulan, $tahun)
	{
		$sql = "select * from dbo.att_sejarah_warna where userid = $user_id and bulan = $bulan and tahun = $tahun";
		$rst = $this->db->query($sql);
		return $rst;
	}
}
