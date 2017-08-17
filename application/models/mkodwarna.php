<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MKodWarna extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function do_save($medan)
	{
		$this->db->insert('dbo.att_xtra_userinfo', $medan);
	}

	public function do_update($user_id, $medan)
	{
		$this->db->where('kw_userid', $user_id);
		$this->db->update('dbo.att_xtra_userinfo', $medan);
	}

	public function do_insert_sejarah_warna($data)
	{
		if($data['kod_warna'] != 1)
			$this->db->insert('dbo.att_sejarah_warna', $data);
	}

	public function get_kod_warna_kad($user_id, $bulan, $tahun)
	{
		$sql = "select * from dbo.att_sejarah_warna
			where 1=1
			and userid = $user_id
			and bulan = $bulan
			and tahun = $tahun";
		$rst = $this->db->query($sql);
		return $rst;
	}
}
