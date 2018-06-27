<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MJustifikasi extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function getAll()
	{
		$query = $this->db->get('pcrs.att_justifikasi_kehadiran');
		return $query;
	}

	public function do_update($user_id, $tarikh, $status)
	{
		$this->db->where('justifikasi_user_id', $user_id);
		$this->db->where('convert(varchar(10), justifikasi_tkh_terlibat, 120)=', $tarikh);
		$this->db->update('pcrs.att_justifikasi_kehadiran', array('justifikasi_status'=>$status,
													'justifikasi_verifikasi'=>$this->session->userdata('userid'),
													'justifikasi_tkh_verifikasi'=>date('Y-m-d H:i:s')));
	}

	public function chk_exists($field)
	{
		$this->db->where('justifikasi_user_id', $field['justifikasi_user_id']);
		$this->db->where('convert(varchar(10), justifikasi_tkh_terlibat, 120)=', $field['justifikasi_tkh_terlibat']);
		$query = $this->db->get('pcrs.att_justifikasi_kehadiran');
		return $query->num_rows();
	}

	public function do_update_hrmis($field)
	{
		$this->db->where('justifikasi_user_id', $field['justifikasi_user_id']);
		$this->db->where('convert(varchar(10), justifikasi_tkh_terlibat, 120)=', $field['justifikasi_tkh_terlibat']);
		$this->db->update('pcrs.att_justifikasi_kehadiran', $field);
	}

	public function simpan($fields)
	{
		$this->db->insert('pcrs.att_justifikasi_kehadiran', $fields);
	}

	public function mohon($fields)
	{
		return $this->db->insert('pcrs.att_justifikasi', $fields);
	}

	public function get_permohonan_justifikasi()
	{
		$sql = "select * from pcrs.view_permohonan_justifikasi
			WHERE ppp_ssn = ?
			AND j_status = 'M'";

		$rst = $this->db->query($sql, array($this->session->userdata('nokp')));
		return $rst;
	}

	public function get_permohonan_justifikasi_lulus()
	{
		$sql = "select * from pcrs.view_permohonan_justifikasi
			WHERE ppk_ssn = ?
			AND j_status = 'S'";

		$rst = $this->db->query($sql, array($this->session->userdata('nokp')));
		return $rst;
	}

	public function setVerifikasi($mohonid, $status)
	{
		$fields = array(
			$status,
			$this->session->userdata('userid'),
			date('Y-m-d H:i:s'),
			$mohonid,
		);

		if($status == 'S')
			$sql = "update pcrs.att_justifikasi set j_status = ?, j_sokong = ?, j_tkh_sokong = ? where j_id = ?";
		if($status == 'L')
			$sql = "update pcrs.att_justifikasi set j_status = ?, j_lulus = ?, j_tkh_lulus = ? where j_id = ?";
		$this->db->query($sql, $fields);
		echo $this->db->last_query();
	}

	public function get_permohonan_justifikasi2($dept_id, $user_id, $bulan, $tahun)
	{
		$sql = "SELECT
				dbo.USERINFO.NAME,
				dbo.att_final_attendance.rpt_id,
				convert(varchar(10), rpt_tarikh, 120) AS rpt_tarikh,
				convert(varchar, rpt_check_in, 120) AS rpt_check_in,
				convert(varchar, rpt_check_out, 120) AS rpt_check_out,
				pcrs.att_justifikasi_kehadiran.justifikasi_alasan,
				pcrs.att_justifikasi_kehadiran.justifikasi_alasan_2,
				pcrs.att_justifikasi_kehadiran.justikasi_masa,
				pcrs.att_justifikasi_kehadiran.justifikasi_status,
				pcrs.att_justifikasi_kehadiran.justifikasi_user_id
				FROM dbo.att_final_attendance
				LEFT JOIN pcrs.att_justifikasi_kehadiran ON convert(varchar(10), dbo.att_final_attendance.rpt_tarikh, 120)= convert(varchar(10),pcrs.att_justifikasi_kehadiran.justifikasi_tkh_terlibat, 120) AND dbo.att_final_attendance.rpt_userid = pcrs.att_justifikasi_kehadiran.justifikasi_user_id
				INNER JOIN dbo.USERINFO ON dbo.USERINFO.USERID = dbo.att_final_attendance.rpt_userid
				where 1 = 1";

				if($this->session->userdata('ppp'))
				{
					if($user_id != -1)
					{
							$sql .= " AND USERINFO.USERID = " . $user_id;
					}
					else if($this->session->userdata('role') == 2 || $this->session->userdata('role') == 4)
					{
						$sql .= " AND USERINFO.OPHONE = '" . $this->session->userdata('nokp') . "'";
						$sql .= " AND USERINFO.USERID <> " . $this->session->userdata('uid');
					}
					else
					{
						$sql .= " AND USERINFO.DEFAULTDEPTID = " . $dept_id;
					}
				}
				else
				{
					if($user_id != -1)
					{
							$sql .= " AND USERINFO.USERID = " . $user_id;
					}
					else
					{
						if($this->session->userdata('role') == 2 || $this->session->userdata('role') == 4)
						{
							$sql .= " AND USERINFO.USERID = " . $this->session->userdata('uid');
							$sql .= " AND USERINFO.USERID <> " . $this->session->userdata('uid');
						}
						else
						{
							$sql .= " AND USERINFO.DEFAULTDEPTID = " . $dept_id;
						}
					}
				}

		$sql .= " and rpt_flag = 'TS'
				and justifikasi_status = 'M'
				and MONTH(rpt_tarikh) = $bulan
				and YEAR(rpt_tarikh) = $tahun
				order by rpt_tarikh";

		$rst = $this->db->query($sql);
		return $rst;
	}

	public function permohonan_under_ppp($user_id, $bulan, $tahun)
	{
		$sql = "SELECT dbo.USERINFO.NAME, dbo.att_final_attendance.rpt_id, convert(varchar(10), rpt_tarikh, 120) AS rpt_tarikh,
		convert(varchar, rpt_check_in, 120) AS rpt_check_in, convert(varchar, rpt_check_out, 120) AS rpt_check_out,
		pcrs.att_justifikasi_kehadiran.justifikasi_alasan, pcrs.att_justifikasi_kehadiran.justifikasi_alasan_2,
		pcrs.att_justifikasi_kehadiran.justikasi_masa, pcrs.att_justifikasi_kehadiran.justifikasi_status,
		pcrs.att_justifikasi_kehadiran.justifikasi_user_id
		FROM dbo.att_final_attendance LEFT JOIN pcrs.att_justifikasi_kehadiran ON convert(varchar(10), dbo.att_final_attendance.rpt_tarikh, 120)= convert(varchar(10),pcrs.att_justifikasi_kehadiran.justifikasi_tkh_terlibat, 120)
		AND dbo.att_final_attendance.rpt_userid = pcrs.att_justifikasi_kehadiran.justifikasi_user_id INNER JOIN dbo.USERINFO ON dbo.USERINFO.USERID = dbo.att_final_attendance.rpt_userid
		WHERE 1 = 1";

		if( $this->session->userdata('role')!=1 ) {
			$sql .= " AND dbo.USERINFO.OPHONE = '" . $this->session->userdata("nokp") . "'";
		}

		if( $user_id != -1 ) {
			$sql .= " AND dbo.USERINFO.USERID = $user_id";
		}

		$sql .= " AND rpt_flag = 'TS'
				AND justifikasi_status = 'M'
				AND MONTH(rpt_tarikh) = ?
				AND YEAR(rpt_tarikh) = ?
				ORDER BY rpt_tarikh";

		$rst = $this->db->query($sql,array($bulan,$tahun));
		
		return $rst;
	}

	public function alert_bil_justifikasi($nokp_pelulus, $tahun, $bulan)
	{
		$sql = "SELECT dbo.USERINFO.NAME, dbo.att_final_attendance.rpt_id, convert(varchar(10), rpt_tarikh, 120) AS rpt_tarikh,
		convert(varchar, rpt_check_in, 120) AS rpt_check_in, convert(varchar, rpt_check_out, 120) AS rpt_check_out,
		pcrs.att_justifikasi_kehadiran.justifikasi_alasan, pcrs.att_justifikasi_kehadiran.justifikasi_alasan_2,
		pcrs.att_justifikasi_kehadiran.justikasi_masa, pcrs.att_justifikasi_kehadiran.justifikasi_status,
		pcrs.att_justifikasi_kehadiran.justifikasi_user_id
		FROM dbo.att_final_attendance LEFT JOIN pcrs.att_justifikasi_kehadiran ON convert(varchar(10), dbo.att_final_attendance.rpt_tarikh, 120)= convert(varchar(10),pcrs.att_justifikasi_kehadiran.justifikasi_tkh_terlibat, 120)
		AND dbo.att_final_attendance.rpt_userid = pcrs.att_justifikasi_kehadiran.justifikasi_user_id INNER JOIN dbo.USERINFO ON dbo.USERINFO.USERID = dbo.att_final_attendance.rpt_userid
		WHERE 1 = 1
		AND MONTH(dbo.att_final_attendance.rpt_tarikh) = ?
		AND YEAR(dbo.att_final_attendance.rpt_tarikh) = ?
		AND rpt_flag = 'TS'
		AND pcrs.att_justifikasi_kehadiran.justifikasi_status = 'M'";

		if( $this->session->userdata('role')!=1 ) {
			$sql .= " AND dbo.USERINFO.OPHONE = '" . $nokp_pelulus . "'";
		}

		return $this->db->query($sql,array($bulan, $tahun));
	}

	public function get_maklumat_permohonan($user_id, $tarikh)
	{
		$sql = "SELECT
				dbo.USERINFO.Name,
				dbo.USERINFO.street,
				dbo.att_final_attendance.rpt_id,
				convert(varchar(10), rpt_tarikh, 120) AS rpt_tarikh,
				convert(varchar, rpt_check_in, 120) AS rpt_check_in,
				convert(varchar, rpt_check_out, 120) AS rpt_check_out,
				pcrs.att_justifikasi_kehadiran.justifikasi_alasan,
				pcrs.att_justifikasi_kehadiran.justikasi_masa,
				pcrs.att_justifikasi_kehadiran.justifikasi_status,
				pcrs.att_justifikasi_kehadiran.justifikasi_user_id
				FROM dbo.att_final_attendance
				LEFT JOIN pcrs.att_justifikasi_kehadiran ON convert(varchar(10), dbo.att_final_attendance.rpt_tarikh, 120)= convert(varchar(10),pcrs.att_justifikasi_kehadiran.justifikasi_tkh_terlibat, 120) AND dbo.att_final_attendance.rpt_userid = pcrs.att_justifikasi_kehadiran.justifikasi_user_id
				INNER JOIN dbo.USERINFO ON dbo.USERINFO.USERID = dbo.att_final_attendance.rpt_userid
				where 1 = 1
				and rpt_userid = $user_id
				and convert(varchar(10), rpt_tarikh, 120) = '$tarikh'
				and rpt_flag = 'TS'
				order by rpt_tarikh";

		$rst = $this->db->query($sql);
		return $rst;
	}

	public function hapus($id)
	{
		$sql = "DELETE FROM pcrs.att_justifikasi_kehadiran WHERE justifikasi_id = ?";
		return $this->db->query($sql,array($id));
	}

	public function senJustifikasi($tahun, $bulan)
	{
		$sql = "select * from pcrs.att_justifikasi
			where j_userid = ?
			AND j_mula >= ?
			AND j_tamat <= ?";
		
		$tkhMula = $tahun.'-'.$bulan.'-'.'1';
		$tkhTamat = $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

		$justifikasi = $this->db->query($sql, array($this->session->userdata('uid'), $tkhMula, $tkhTamat));

		//echo $this->db->last_query();
		return $justifikasi;
	}
}

?>
