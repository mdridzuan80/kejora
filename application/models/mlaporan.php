<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MLaporan extends CI_Model {

	const STATUS_SMS_UNSEND = 0;
	const STATUS_SMS_SEND = 1;

	public function __construct() {
		parent::__construct();
	}

	public function rpt_user_info($bahagian="", $nama="")
	{
		$sql = "SELECT * FROM view_WBB a, USER_INFO b
				WHERE 1=1
				AND a.USERID = b.USERID
				AND DEFAULTDEPTID = " . $bahagian;
	}

	public function rpt_kehadiran_in($userid, $masa)
	{
		$sqlin = "SELECT USERID, Name, SSN, convert(varchar, Min(CHECKTIME), 120) AS checkin
				FROM view_rpt_kehadiran
				GROUP BY USERID, Name, SSN, DAY, MONTH, YEAR
				HAVING Min(CHECKTIME) >= '" . date('Y-m-d', strtotime($masa)) . "' AND Min(CHECKTIME) <= '" . date('Y-m-d', strtotime('+1 day',strtotime($masa))) . "'
				AND Min(CHECKTIME) > '" . $masa . " 4:00 AM'
				AND Min(CHECKTIME) < '" . $masa . " 1:00 PM'
				AND USERID = " . $userid . "
				ORDER BY Name, USERID, Min(CHECKTIME)";
		$rst = $this->db->query($sqlin);

		if($rst->num_rows())
		{
			$row = $rst->row_array();
			$checkin = $row['checkin'];
		}
		else
		{
			$checkin = "";
		}
		return $checkin;
	}

	public function rpt_kehadiran_in_first($userid, $masa)
	{
		$sqlin = "SELECT USERID, Name, SSN, convert(varchar, Min(CHECKTIME), 120) AS checkin
				FROM dbo.view_rpt_kehadiran
				WHERE 1=1
				AND CHECKTIME >= '" . date('Y-m-d', strtotime($masa)) . " 4:00 AM' AND CHECKTIME < '" . date('Y-m-d', strtotime('+1 day',strtotime($masa))) . " 4:00 AM'
				AND USERID = $userid
				GROUP BY USERID, Name, SSN";
		$rst = $this->db->query($sqlin);

		if($rst->num_rows())
		{
			$row = $rst->row_array();
			$checkin = $row['checkin'];
		}
		else
		{
			$checkin = "";
		}
		return $checkin;
	}

	public function rpt_kehadiran_out($userid, $masa)
	{
		$sqlout = "SELECT USERID, Name, SSN, convert(varchar, Max(CHECKTIME), 120) AS checkout
				FROM view_rpt_kehadiran
				GROUP BY USERID, Name, SSN, DAY, MONTH, YEAR
				HAVING Max(CHECKTIME) >= '" . date('Y-m-d', strtotime($masa)) . "' AND Max(CHECKTIME) <= '" . date('Y-m-d', strtotime('+1 day',strtotime($masa))) . "'
				AND Max(CHECKTIME) >= '" . $masa . " 1:00 PM'
				AND USERID = " . $userid . "
				ORDER BY Name, USERID, Max(CHECKTIME);";
		$rst = $this->db->query($sqlout);

		if($rst->num_rows())
		{
			$row = $rst->row_array();
			$checkout = $row['checkout'];
		}
		else
		{
			$checkout = "";
		}
		return $checkout;
	}

	public function rpt_kehadiran_out_last($userid, $masa)
	{
		$sqlout = "SELECT USERID, Name, SSN, convert(varchar, Max(CHECKTIME), 120) AS checkout
				FROM dbo.view_rpt_kehadiran
				WHERE 1=1
				AND CHECKTIME >= '" . date('Y-m-d', strtotime($masa)) . " 4:00 AM' AND CHECKTIME < '" . date('Y-m-d', strtotime('+1 day',strtotime($masa))) . " 4:00 AM'
				AND USERID = $userid
				GROUP BY USERID, Name, SSN";

		$rst = $this->db->query($sqlout);

		if($rst->num_rows())
		{
			$row = $rst->row_array();
			$checkout = $row['checkout'];
		}
		else
		{
			$checkout = "";
		}
		return $checkout;
	}

	public function rpt_kehadiran_out_over_midnight($userid, $masa)
	{
		$sqlout = "SELECT USERID, Name, SSN, convert(varchar, Max(CHECKTIME), 120) AS checkout
				FROM view_rpt_kehadiran
				GROUP BY USERID, Name, SSN, DAY, MONTH, YEAR
				HAVING Max(CHECKTIME) >= '" . date('Y-m-d', strtotime('+1 day',strtotime($masa))) . "' AND Max(CHECKTIME) <= '" . date('Y-m-d', strtotime('+2 day',strtotime($masa))) . "'
				AND Max(CHECKTIME) < '" . date('Y-m-d', strtotime('+1 day',strtotime($masa))) . " 4:00 AM'
				AND USERID = " . $userid . "
				ORDER BY Name, USERID, Max(CHECKTIME);";
		$rst = $this->db->query($sqlout);

		if($rst->num_rows())
		{
			$row = $rst->row_array();
			$checkout = $row['checkout'];
		}
		else
		{
			$checkout = "";
		}
		return $checkout;
	}

	public function rpt_kehadiran($userid, $bulan, $tahun)
	{
		$data = array($userid, $bulan, $tahun);
		$sql = 'dbo.att_rpt_final_attendance_sp ?, ?, ?';
		$rst = $this->db->query($sql, $data);

		$i=0;
		if($rst->num_rows != 0)
		{
			foreach($rst->result() as $row)
			{
				$staff[$userid][$i]['tarikh'] = date('Y-m-d', strtotime($row->rpt_tarikh));
				$staff[$userid][$i]['chkin'] = ($row->rpt_check_in)?date('Y-m-d g:i:s a', strtotime($row->rpt_check_in)):NULL;
				$staff[$userid][$i]['chkout'] = ($row->rpt_check_out)?date('Y-m-d g:i:s a', strtotime($row->rpt_check_out)):NULL;
				$staff[$userid][$i]['nota'] = $this->nota_justifikasi($userid, date('Y-m-d', strtotime($row->rpt_tarikh)));
				$staff[$userid][$i]['wbb'] = $row->rpt_wbb_id;
				$i++;
			}
			return $staff;
		}
		else
		{
			return FALSE;
		}
	}

	public function gen_final_attendance($userid, $tkh)
	{
		$data = array($userid, $tkh, ($this->rpt_kehadiran_in($userid, $tkh))?$this->rpt_kehadiran_in($userid, $tkh):NULL, ($this->rpt_kehadiran_out($userid, $tkh))?$this->rpt_kehadiran_out($userid, $tkh):NULL);

		$sql = 'EXEC dbo.att_final_attendance_sp ?, ?, ?, ?';
		$this->db->query($sql, $data);
	}

	public function gen_update_final_attendance($userid, $tkh, $shift, $cuti)
	{
		$rpt_userid = $userid;
		$rpt_tarikh = $tkh;
		$rpt_tarikh_2 = date('Y-m-d', strtotime('+1 day', strtotime($tkh)));

		//jika hari cuti, sabtu dan ahad
		//dapatkan rekod first-in, last-out
		if((isset($cuti[date('Y-m-d', strtotime($tkh))])) || (date("N", strtotime($tkh)) == 5) || (date("N", strtotime($tkh)) == 6))
		{
			$rpt_check_in = ($this->rpt_kehadiran_in_first($userid, $tkh))?$this->rpt_kehadiran_in_first($userid, $tkh):NULL;
			$rpt_check_out = ($this->rpt_kehadiran_out_last($userid, $tkh))?$this->rpt_kehadiran_out_last($userid, $tkh):NULL;
		}
		else
		{
			$rpt_check_in = ($this->rpt_kehadiran_in($userid, $tkh))?$this->rpt_kehadiran_in($userid, $tkh):NULL;
			$rpt_check_out = ($this->rpt_kehadiran_out($userid, $tkh))?$this->rpt_kehadiran_out($userid, $tkh):NULL;
		}

		if($rpt_check_out == NULL)
		{
			$rpt_check_out = ($this->rpt_kehadiran_out_over_midnight($userid, $tkh))?$this->rpt_kehadiran_out_over_midnight($userid, $tkh):NULL;
		}

		$rpt_flag = 'C';
		$cuti_ahad = false;

		if(!isset($cuti[date('Y-m-d', strtotime($tkh))]))
		{
			if((date("N", strtotime($tkh)) != 5) && (date("N", strtotime($tkh)) != 6))
			{
				if($shift != false)
				{
					if(!$rpt_check_in || !$rpt_check_out || (strtotime($rpt_check_in) > strtotime($tkh . ' ' . $shift[0])) || (strtotime($rpt_check_out) < strtotime($tkh . ' ' . $shift[2])))
					{
						if(date("N", strtotime($tkh)) == 4 && strtotime($rpt_check_out) > strtotime("-90 minutes",strtotime($tkh . ' ' . $shift[2])))
						{
							$rpt_flag = 'C';
						}
						else
						{
							$rpt_flag = 'TS';
						}
					}
					$wbb = $shift[1];
				}
				else
				{
					$wbb = 0;
				}
			}
			else
			{
				$wbb = $shift[1];
			}
		}

		$data = array($rpt_userid, $rpt_tarikh, $rpt_tarikh_2);
		$exists = "select * from dbo.att_final_attendance
				WHERE rpt_userid = ?
				AND convert(varchar, rpt_tarikh, 120) >= ?
				AND convert(varchar, rpt_tarikh, 120) < ?";
		$rst_exists = $this->db->query($exists, $data);

		if($rst_exists->num_rows() == 0)
		{
			if($shift != false)
			{
				$wbb = $shift[1];
			}
			else
			{
				$wbb = 0;
			}
			$data = array($rpt_userid, $rpt_tarikh, $rpt_check_in, $rpt_check_out, $rpt_flag, $wbb);
			$sql = 'dbo.att_final_attendance_sp_copy ?, ?, ?, ?, ?, ?';
			$this->db->query($sql, $data);
		}
		else
		{
			if($shift != false)
			{
				$wbb = $shift[1];
			}
			else
			{
				$wbb = 0;
			}
			$data = array($rpt_check_in, $rpt_check_out, $rpt_flag, $wbb, $rpt_userid, $rpt_tarikh, $rpt_tarikh_2);
			$sql="UPDATE dbo.att_final_attendance set rpt_check_in = ?, rpt_check_out = ?, rpt_flag = ?, rpt_wbb_id = ?
					WHERE rpt_userid = ?
					AND convert(varchar, rpt_tarikh, 120) >= ?
					AND convert(varchar, rpt_tarikh, 120) < ?";
			$this->db->query($sql, $data);
		}
	}

	public function rpt_kehadiran_harian($bahagian='',$userid='',$mula='',$akhir='', $cuti)
	{
		// staff
		$staff=array();
		$step = "+1 day";
		$dates = array();
		$current = strtotime($mula);
		$last = strtotime($akhir);
		$i=0;

		 while( $current <= $last ) {
			$dates = date('Y-m-d', $current);

			$sql_user = "SELECT dbo.USERINFO.USERID, dbo.USERINFO.NAME, dbo.DEPARTMENTS.DEPTNAME
						FROM
						dbo.USERINFO, dbo.DEPARTMENTS
						WHERE 1=1
						AND dbo.USERINFO.DEFAULTDEPTID = dbo.DEPARTMENTS.DEPTID
						AND dbo.USERINFO.DEFAULTDEPTID = $bahagian";

			if($this->session->userdata('ppp'))
			{
				if($userid != -1)
				{
						$sql_user .= " AND USERINFO.USERID = " . $userid;
				}
				else if($this->session->userdata('role') == 4)
				{
					$sql_user .= " AND (USERINFO.USERID = " . $this->session->userdata('uid') . " OR USERINFO.OPHONE = '" . $this->session->userdata('nokp') . "')";
				}
			}
			else
			{
				if($userid != -1)
				{
						$sql_user .= " AND USERINFO.USERID = " . $userid;
				}
				else
				{
					if($this->session->userdata('role') == 4)
					{
						$sql_user .= " AND USERINFO.USERID = " . $this->session->userdata('uid');
					}
				}
			}
			$sql_user .= " ORDER BY dbo.USERINFO.NAME";
			$rst_user = $this->db->query($sql_user);
			foreach($rst_user->result_array() as $row_user)
			{
				$userid = $row_user['USERID'];
				$staff[$userid][$i]['name'] = $row_user['NAME'];
				$staff[$userid][$i]['bahagian'] = $row_user['DEPTNAME'];
				$shift = pcrs_wbb_starttime($userid, date('Y-m-d', $current));
				$staff[$userid][$i]['wbb'] = (isset($shift[1]))?pcrs_wbb_desc($shift[1]): "<span style=\"color: red;\">WP?</span>";
				$staff[$userid][$i]['tarikh'] = date('Y-m-d', $current);

				if((isset($cuti[date('Y-m-d', strtotime(date('Y-m-d', $current)))])) || (date("N", strtotime(date('Y-m-d', $current))) == 6) || (date("N", strtotime(date('Y-m-d', $current))) == 7))
				{
					$staff[$userid][$i]['chkin'] = ($this->rpt_kehadiran_in_first($userid, date('Y-m-d', $current)))?$this->rpt_kehadiran_in_first($userid, date('Y-m-d', $current)):NULL;
					$staff[$userid][$i]['chkout'] = ($this->rpt_kehadiran_out_last($userid, date('Y-m-d', $current)))?$this->rpt_kehadiran_out_last($userid, date('Y-m-d', $current)):NULL;
				}
				else
				{
					$staff[$userid][$i]['chkin'] = $this->rpt_kehadiran_in($userid, date('Y-m-d', $current));
					$staff[$userid][$i]['chkout'] = $this->rpt_kehadiran_out($userid, date('Y-m-d', $current));
				}
				if($staff[$userid][$i]['chkout']=="")
				{
					$staff[$userid][$i]['chkout'] = $this->rpt_kehadiran_out_over_midnight($userid, date('Y-m-d', $current));
				}
				$staff[$userid][$i]['nota'] = $this->nota_justifikasi($userid, date('Y-m-d', $current));
			}
			$current = strtotime($step, $current);
			$i++;
		}
		//print_r($staff);
		return $staff;
	}

	public function get_data_statistik_harian($tkh_mula)
	{
		$sql = "SELECT count(a.ID) as jumlah, convert(varchar, a.CHECKTIME,102) as CHECKTIME
				FROM USER_LATE_SMS a, USERINFO b
				WHERE 1=1
				AND a.USERID = b.USERID
				AND a.CHECKTIME >= '" . date('Y-m-d', strtotime($tkh_mula)) . "'
				AND a.CHECKTIME <= '" . date('Y-m-d', strtotime('+1 day',strtotime($tkh_mula))) . "'
				AND a.INDICATOR IS null";
		if($this->session->userdata('role') != 1)
			$sql .= " and b.DEFAULTDEPTID = " . $this->session->userdata('dept');
		$sql .= " GROUP BY convert(varchar, a.CHECKTIME,102)";

		return $this->db->query($sql);
	}

	public function get_top_ten($bulan, $tahun, $dept_id)
	{
		$sql = "SELECT COUNT(dbo.view_LATE.ID) AS lewat, dbo.view_LATE.USERID, dbo.view_LATE.NAME, dbo.view_LATE.DEPTNAME, dbo.view_LATE.TITLE, dbo.view_LATE.MONTH, dbo.view_LATE.YEAR
				FROM dbo.view_LATE
				WHERE 1 = 1 ";
		if($dept_id != 1)
			$sql .= " and dbo.view_LATE.DEFAULTDEPTID = " . $dept_id;
		$sql .= " AND dbo.view_LATE.MONTH = " . $bulan . "
				AND dbo.view_LATE.YEAR = " . $tahun . "

				GROUP BY dbo.view_LATE.USERID,dbo.view_LATE.NAME, dbo.view_LATE.DEPTNAME, dbo.view_LATE.TITLE, dbo.view_LATE.MONTH, dbo.view_LATE.YEAR
				HAVING COUNT(dbo.view_LATE.ID) >= 3
				ORDER BY lewat DESC, dbo.view_LATE.NAME ASC";
		return $this->db->query($sql);
	}

	/*public function get_staff_kehadiran_harian($dept_id, $day, $month, $year)
	{
		$sql = "select * from view_userinfo_wbb
				where DEFAULTDEPTID = $dept_id
				and MONTH=$month
				and YEAR=$year
				order by Nama";
		return $this->db->query($sql);
	}*/

	public function get_staff_kehadiran_harian($dept_id, $day, $month, $year)
	{
		$str_date = $year . "-" . $month . "-" . $day;
		$sql = "select * from pcrs.view_WBB_daily_
				where DEFAULTDEPTID = $dept_id
				and (convert(varchar(10), STARTDATE,120) <= '$str_date'
				and convert(varchar(10), ENDDATE,120) >= '$str_date')
				ORDER BY Nama";
		return $this->db->query($sql);
	}

	public function get_staff_kehadiran_harian_user($user_id, $day, $month, $year)
	{
		$sql = "select * from view_userinfo_wbb
				where USERID = $user_id
				and MONTH=$month
				and YEAR=$year
				order by Nama";
		return $this->db->query($sql);
	}

	public function get_rcpt_laporan_harian($dept_id)
	{
		$sql = "SELECT dbo.USERINFO.NAME, dbo.USERINFO.Email, dbo.DEPARTMENTS.DEPTNAME
			FROM dbo.att_users
			INNER JOIN dbo.USERINFO ON dbo.USERINFO.USERID = dbo.att_users.userid
			INNER JOIN dbo.DEPARTMENTS ON dbo.USERINFO.DEFAULTDEPTID = dbo.DEPARTMENTS.DEPTID
			WHERE 1 = 1
			AND dbo.att_users.roleid IN (2)
			AND dbo.USERINFO.DEFAULTDEPTID = $dept_id
			ORDER BY dbo.USERINFO.DEFAULTDEPTID ASC, dbo.USERINFO.NAME ASC";
		return $this->db->query($sql);
	}

	public function get_staff_late($user_id, $bulan, $tahun)
	{
		$sql = "SELECT Count(view_LATE.USERID) AS LATE_COUNT, view_LATE.Name, view_LATE.SSN, view_LATE.TITLE, view_LATE.NUM_RUNID, view_LATE.Email as mail, USERINFO.PAGER AS TEL_PEG_SATU, USERINFO.Email AS MEL_PEG_SATU, USERINFO.CITY AS SS_SATU, USERINFO_1.PAGER AS TEL_PEG_DUA, USERINFO_1.Email AS MEL_PEG_DUA, USERINFO_1.CITY AS SS_DUA, view_LATE.USERID
			FROM (view_LATE INNER JOIN USERINFO ON view_LATE.OPHONE = USERINFO.SSN) LEFT JOIN USERINFO AS USERINFO_1 ON USERINFO.OPHONE = USERINFO_1.SSN
			GROUP BY view_LATE.Name, view_LATE.SSN, view_LATE.TITLE, view_LATE.NUM_RUNID, view_LATE.Email, USERINFO.PAGER, USERINFO.Email, USERINFO.CITY, USERINFO_1.PAGER, USERINFO_1.Email, USERINFO_1.CITY, view_LATE.MONTH, view_LATE.YEAR, view_LATE.USERID
			HAVING (((view_LATE.MONTH)= ?) AND ((view_LATE.YEAR)=?) AND ((view_LATE.USERID)=?))
			ORDER BY view_LATE.Name";
		return $this->db->query($sql, array($bulan,$tahun,$user_id));
	}

	public function get_staff_late_by_dept($dept_id, $bulan, $tahun)
	{
		$sql = "SELECT Count(view_LATE.USERID) AS LATE_COUNT, view_LATE.Name, view_LATE.SSN, view_LATE.TITLE, view_LATE.NUM_RUNID, view_LATE.street as mail, USERINFO.PAGER AS TEL_PEG_SATU, USERINFO.street AS MEL_PEG_SATU, USERINFO.CITY AS SS_SATU, USERINFO_1.PAGER AS TEL_PEG_DUA, USERINFO_1.street AS MEL_PEG_DUA, USERINFO_1.CITY AS SS_DUA, view_LATE.USERID
			FROM (view_LATE INNER JOIN USERINFO ON view_LATE.OPHONE = USERINFO.SSN) LEFT JOIN USERINFO AS USERINFO_1 ON USERINFO.OPHONE = USERINFO_1.SSN
			GROUP BY view_LATE.Name, view_LATE.SSN, view_LATE.TITLE, view_LATE.NUM_RUNID, view_LATE.street, USERINFO.PAGER, USERINFO.street, USERINFO.CITY, USERINFO_1.PAGER, USERINFO_1.street, USERINFO_1.CITY, view_LATE.MONTH, view_LATE.YEAR, view_LATE.USERID
			HAVING (((view_LATE.MONTH)=$bulan) AND ((view_LATE.YEAR)=$tahun) AND ((view_LATE.USERID)=$user_id))
			ORDER BY view_LATE.Name";
		return $this->db->query($sql);
	}

	public function get_lewat($tkh)
	{
		$sql = "SELECT ID, USERID, convert(varchar, CHECKTIME, 120) as CHECKTIME, SEND_SMS, NUM_RUNID
			FROM dbo.USER_LATE_SMS
			WHERE 1=1
			AND convert(varchar(10), CHECKTIME, 120) = ?
			AND SEND_SMS = ?";
		$query = $this->db->query($sql, array($tkh, self::STATUS_SMS_UNSEND));
		return $query;
	}

	public function do_update_lewat($id)
	{
		$sql = "UPDATE dbo.USER_LATE_SMS SET SEND_SMS = ? WHERE ID = ?";
		return $this->db->query($sql,array(self::STATUS_SMS_SEND, $id));
	}

	public function get_user_gen_tunjuk_sebab($bulan, $tahun)
	{
		$sql = "select USERID
				from dbo.USERINFO
				where 1=1
				and NOT IN ((select sc_user_id from dbo.att_show_course where sc_month = $bulan and sc_year = $tahun))";
		return $this->db->query($sql);
	}

	public function get_kakitangan_layak_ts($bulan, $tahun, $depart)
	{
		$sql = "select * from view_layak_ts
				where rpt_bulan = $bulan
				and rpt_tahun = $tahun
				and DEFAULTDEPTID = $depart";
		return $this->db->query($sql);
	}

	public function get_kakitangan_layak_ts_info($user_id, $bulan, $tahun)
	{
		$sql = "SELECT
				dbo.att_final_attendance.rpt_id,
				convert(varchar(10), rpt_tarikh, 120) AS rpt_tarikh,
				convert(varchar, rpt_check_in, 120) AS rpt_check_in,
				convert(varchar, rpt_check_out, 120) AS rpt_check_out,
				convert(varchar, pcrs.att_justifikasi_kehadiran.justikasi_masa, 120) AS justikasi_masa,
				convert(varchar, pcrs.att_justifikasi_kehadiran.justifikasi_tkh_verifikasi, 120) AS justifikasi_tkh_verifikasi,
				pcrs.att_justifikasi_kehadiran.justifikasi_alasan,
				pcrs.att_justifikasi_kehadiran.justifikasi_alasan_2,
				pcrs.att_justifikasi_kehadiran.justifikasi_status,
				pcrs.att_justifikasi_kehadiran.justifikasi_verifikasi
				FROM dbo.att_final_attendance
				LEFT JOIN pcrs.att_justifikasi_kehadiran ON convert(varchar(10), dbo.att_final_attendance.rpt_tarikh, 120)= convert(varchar(10),pcrs.att_justifikasi_kehadiran.justifikasi_tkh_terlibat, 120) AND dbo.att_final_attendance.rpt_userid = pcrs.att_justifikasi_kehadiran.justifikasi_user_id
				where rpt_userid = $user_id
				and rpt_flag = 'TS'
				and MONTH(rpt_tarikh) = $bulan
				and YEAR(rpt_tarikh) = $tahun
				order by rpt_tarikh";
		return $this->db->query($sql);
	}

	public function get_kakitangan_layak_lewat_ts_info($user_id, $bulan, $tahun)
	{
		$sql = "SELECT
				convert(varchar(10), CHECKTIME, 120) as rpt_tarikh, convert(varchar, CHECKTIME, 120) as rpt_check_in
				FROM
				dbo.USER_LATE_SMS
				where USERID = $user_id
				and MONTH(CHECKTIME) = $bulan
				and YEAR(CHECKTIME) = $tahun
				order by CHECKTIME";
		return $this->db->query($sql);
	}

	public function get_staff_lewat_ts($bulan, $tahun)
	{
		$sql = "SELECT Count(view_LATE.USERID) AS LATE_COUNT, view_LATE.Name, view_LATE.SSN, view_LATE.TITLE, view_LATE.NUM_RUNID, view_LATE.street as email, view_LATE.DEFAULTDEPTID, view_LATE.DEPTNAME, USERINFO.PAGER AS TEL_PEG_SATU, USERINFO.street AS MEL_PEG_SATU, USERINFO.CITY AS SS_SATU, USERINFO_1.PAGER AS TEL_PEG_DUA, USERINFO_1.street AS MEL_PEG_DUA, USERINFO_1.CITY AS SS_DUA, view_LATE.USERID
			FROM (view_LATE INNER JOIN USERINFO ON view_LATE.OPHONE = USERINFO.SSN) LEFT JOIN USERINFO AS USERINFO_1 ON USERINFO.OPHONE = USERINFO_1.SSN
			GROUP BY view_LATE.Name, view_LATE.SSN, view_LATE.TITLE, view_LATE.NUM_RUNID, view_LATE.street, view_LATE.DEFAULTDEPTID, view_LATE.DEPTNAME, USERINFO.PAGER, USERINFO.street, USERINFO.CITY, USERINFO_1.PAGER, USERINFO_1.street, USERINFO_1.CITY, view_LATE.MONTH, view_LATE.YEAR, view_LATE.USERID
			HAVING (((view_LATE.MONTH)=$bulan) AND ((view_LATE.YEAR)=$tahun) AND (Count(view_LATE.USERID)>=3))
			ORDER BY view_LATE.Name";
		return $this->db->query($sql);
	}

	public function get_staff_lewat_ts_by_dept($dept_id, $bulan, $tahun)
	{
		$sql = "SELECT Count(view_LATE.USERID) AS LATE_COUNT, view_LATE.Name, view_LATE.SSN, view_LATE.TITLE, view_LATE.NUM_RUNID, view_LATE.street as email, view_LATE.DEFAULTDEPTID, view_LATE.DEPTNAME, USERINFO.PAGER AS TEL_PEG_SATU, USERINFO.street AS MEL_PEG_SATU, USERINFO.CITY AS SS_SATU, USERINFO_1.PAGER AS TEL_PEG_DUA, USERINFO_1.street AS MEL_PEG_DUA, USERINFO_1.CITY AS SS_DUA, view_LATE.USERID
			FROM (view_LATE INNER JOIN USERINFO ON view_LATE.OPHONE = USERINFO.SSN) LEFT JOIN USERINFO AS USERINFO_1 ON USERINFO.OPHONE = USERINFO_1.SSN
			GROUP BY view_LATE.Name, view_LATE.SSN, view_LATE.TITLE, view_LATE.NUM_RUNID, view_LATE.street, view_LATE.DEFAULTDEPTID, view_LATE.DEPTNAME, USERINFO.PAGER, USERINFO.street, USERINFO.CITY, USERINFO_1.PAGER, USERINFO_1.street, USERINFO_1.CITY, view_LATE.MONTH, view_LATE.YEAR, view_LATE.USERID
			HAVING (((view_LATE.MONTH)=$bulan) AND ((view_LATE.YEAR)=$tahun) AND (Count(view_LATE.USERID)>=3) AND ((view_LATE.DEFAULTDEPTID)=$dept_id))
			ORDER BY view_LATE.Name";
		return $this->db->query($sql);
	}

	public function nota_justifikasi($user_id, $tarikh)
	{
		$sql = "SELECT * FROM pcrs.view_nota_justifikasi
				WHERE 1=1
				AND justifikasi_status = 'L'
				AND justifikasi_user_id = $user_id
				AND justifikasi_tkh_terlibat = '$tarikh'";
		return $this->db->query($sql);
	}

	public function stat_x_punch_inout($bulan, $tahun, $dept_id)
	{
		$sql = "SELECT
			pcrs.view_x_punch_core.rpt_userid,
			dbo.USERINFO.DEFAULTDEPTID,
			dbo.USERINFO.NAME,
			dbo.USERINFO.SSN,
			dbo.DEPARTMENTS.DEPTNAME,
			month(rpt_tarikh) AS bulan,
			year(rpt_tarikh) AS tahun,
			Sum(pcrs.view_x_punch_core.bil_x_punch_in) AS jum_x_punch_in,
			Sum(pcrs.view_x_punch_core.bil_x_punch_out) AS jum_x_punch_out

			FROM
			pcrs.view_x_punch_core
			INNER JOIN dbo.USERINFO ON pcrs.view_x_punch_core.rpt_userid = dbo.USERINFO.USERID
			INNER JOIN dbo.DEPARTMENTS ON dbo.USERINFO.DEFAULTDEPTID = dbo.DEPARTMENTS.DEPTID
			WHERE 1=1
			AND month(rpt_tarikh) = $bulan
			AND year(rpt_tarikh) = $tahun";
						if($dept_id != -1 && $dept_id != 1)
							$sql .= " AND dbo.USERINFO.DEFAULTDEPTID = $dept_id";
					$sql .= " GROUP BY pcrs.view_x_punch_core.rpt_userid,
			month(rpt_tarikh),
			year(rpt_tarikh),
			dbo.USERINFO.DEFAULTDEPTID,
			dbo.DEPARTMENTS.DEPTNAME,
			dbo.USERINFO.NAME,
			dbo.USERINFO.SSN";
		return $this->db->query($sql);
	}

	public function sen_kod_warna($bulan, $tahun, $dept_id)
	{
		$sql = "SELECT dbo.att_sejarah_warna.userid, dbo.USERINFO.DEFAULTDEPTID, dbo.USERINFO.NAME, dbo.USERINFO.SSN, dbo.DEPARTMENTS.DEPTNAME, dbo.att_sejarah_warna.bulan, dbo.att_sejarah_warna.tahun, dbo.att_sejarah_warna.kod_warna
			FROM dbo.att_sejarah_warna
			INNER JOIN dbo.USERINFO ON dbo.USERINFO.USERID = dbo.att_sejarah_warna.userid
			INNER JOIN dbo.DEPARTMENTS ON dbo.USERINFO.DEFAULTDEPTID = dbo.DEPARTMENTS.DEPTID
			WHERE 1=1
			AND dbo.att_sejarah_warna.bulan = $bulan
			AND dbo.att_sejarah_warna.tahun = $tahun";
			if($dept_id != -1 && $dept_id != 1)
				$sql .= " AND dbo.USERINFO.DEFAULTDEPTID = $dept_id";
		$sql .= " ORDER BY
			dbo.USERINFO.NAME ASC";
		return $this->db->query($sql);
	}

	public function getTahunFromFinalAtt()
	{
		$sql = "SELECT DISTINCT YEAR(rpt_tarikh) as tahun FROM dbo.att_final_attendance ORDER BY 1";
		return $this->db->query($sql)->result();
	}

	public function rpt_kehadiran_out_list($userid, $masa, $end)
	{
		$sqlout = "SELECT USERID, Name, SSN, convert(varchar, CHECKTIME, 120) AS checkout
				FROM dbo.view_rpt_kehadiran
				WHERE 1=1
				AND CHECKTIME >= '" . date('Y-m-d', strtotime($masa)) . " " . $end . "' AND CHECKTIME < '" . date('Y-m-d', strtotime('+1 day',strtotime($masa))) . " 4:00 AM'
				AND USERID = $userid
				AND convert(varbinary, CHECKTYPE) <> convert(varbinary, '1')
				AND convert(varbinary, CHECKTYPE) <> convert(varbinary, 'i')
				ORDER BY 4";

		return $this->db->query($sqlout);
	}
}
