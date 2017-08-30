<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class MUserinfo extends CI_Model {
		public function __construct() {
			parent::__construct();
		}

		public function record_count($filter)
		{
			if($filter['id'])
				$this->db->where('badgeNumber', $filter['id']);
			if($filter['nama'])
				$this->db->like('Name', $filter['nama']);
			if($filter['deptid'])
				$this->db->where('DEFAULTDEPTID', $filter['deptid']);
			if($this->session->userdata('role')==4 || $this->session->userdata('role')==5)
				$this->db->where('DEFAULTDEPTID', $this->session->userdata('dept'));
			if($this->session->userdata('role')==4)
				$this->db->where('USERID', $this->session->userdata('uid'));
			$query = $this->db->get("dbo.USERINFO");
			return $query->num_rows();
		}

		public function getAll($filter) {
			if($filter['id'])
				$this->db->where('BADGENUMBER', $filter['id']);
			if($filter['nama'])
				$this->db->like('NAME', $filter['nama']);
			if($filter['deptid'])
				$this->db->where('DEFAULTDEPTID', $filter['deptid']);

			if($this->session->userdata('role')==5)
				$this->db->where('DEFAULTDEPTID', $this->session->userdata('dept'));
			if($this->session->userdata('role')==2)
				$this->db->where_in('DEFAULTDEPTID', $this->session->userdata('browse_dept'));

			if($this->session->userdata('role')==4)
				$this->db->where('USERID', $this->session->userdata('uid'));

			$this->db->order_by('NAME');
			$query = $this->db->get('dbo.USERINFO');

			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
            	return $data;
			}
			return false;
		}

		public function getByUnitID($id) {
			if( $this->session->userdata('role')==4 )
			{
				if($this->input->post('segmen') != 'kelulusan')
					$this->db->where('USERID', $this->session->userdata('uid'));
			}
			if( $this->session->userdata('role')!=2 && $this->session->userdata('role')!=1 )
			{
				if($this->session->userdata('ppp'))
				{
					if($this->session->userdata('role')!=5)
					{
						$this->db->where('OPHONE', $this->getNoKP($this->session->userdata('uid')));
						if($this->input->post('segmen') != 'kelulusan')
							$this->db->or_where('USERID=', $this->session->userdata('uid'));
					}
				}
			}
			if($this->input->post('segmen') == 'kelulusan')
			{
				if( $this->session->userdata('role')!=2 && $this->session->userdata('role')!=1 )
					$this->db->where('USERID <>', $this->session->userdata('uid'));
			}
			$this->db->where('DEFAULTDEPTID',$id);
			$this->db->order_by('USERINFO.NAME');
			$query = $this->db->get('dbo.USERINFO');
			//echo $this->input->post('segmen');
			//echo $this->db->last_query();
			return $query;
		}

		public function getByUnitID_PPP($id) {
			if( $this->session->userdata('role')==4 )
			{
				$this->db->where('USERID', $this->session->userdata('uid'));
			}
			if( $this->session->userdata('role')!=2 && $this->session->userdata('role')!=1 && $this->session->userdata('role')!=5 )
			{
				if($this->session->userdata('ppp'))
				{
					$this->db->where('OPHONE', $this->getNoKP($this->session->userdata('uid')));
					$this->db->or_where('USERID=', $this->session->userdata('uid'));
				}
			}
			$this->db->where('DEFAULTDEPTID',$id);
			$this->db->order_by('USERINFO.NAME');
			$query = $this->db->get('dbo.USERINFO');
			echo $this->db->last_query();
			return $query;
		}

		public function getByUnitIDArkib($id) {
			$this->db->where('DEFAULTDEPTID',$id);
			if($this->session->userdata('role')==4)
			{
				$this->db->where('USERID', $this->session->userdata('uid'));
			}
			$this->db->order_by('Name');
			$query = $this->db->get('dbo.att_arkib_userinfo');
			return $query;
		}

		public function getByUnitIDPPP($id) {
			$this->db->where('DEFAULTDEPTID',$id);
			$this->db->order_by('USERINFO.Name');
			$query = $this->db->get('dbo.USERINFO');
			return $query;
		}

		public function getByMainDept($deptid)
		{
			$sql = "SELECT USERINFO.USERID, USERINFO.Name, a.DEPTID
					FROM (USERINFO INNER JOIN DEPARTMENTS ON USERINFO.DEFAULTDEPTID = DEPARTMENTS.DEPTID) INNER JOIN DEPARTMENTS AS a ON DEPARTMENTS.SUPDEPTID =a.DEPTID
					WHERE a.DEPTID = " . $deptid . " ORDER BY USERINFO.Name";
			$query = $this->db->query($sql);
			return $query;
		}

		public function getDefaultDepartment($userid)
		{
			$query = $this->db->get_where('dbo.USERINFO', array('USERID'=>$userid));
			$row = $query->row();
			return $row->DEFAULTDEPTID;
		}

		public function update($fields)
		{
			$this->db->where('Badgenumber', $fields['Badgenumber']);
			$this->db->update('dbo.USERINFO', $fields);
		}

		public function getUserID($badgeNumber)
		{
			$query = $this->db->get_where('dbo.USERINFO', array('Badgenumber' => $badgeNumber));
			$row = $query->row();
			return $row->USERID;
		}

		public function insertWBB($fields)
		{
			$this->db->insert('dbo.USER_OF_RUN', $fields);
		}

		public function checkWBB($fields)
		{
			$query = $this->db->get_where('dbo.USER_OF_RUN',array("USERID"=>$fields['USERID'], "NUM_OF_RUN_ID"=>$fields['NUM_OF_RUN_ID'], "STARTDATE"=>$fields['STARTDATE'], "ENDDATE"=>$fields['ENDDATE']));
			return $query->num_rows();
		}

		public function getWBB($fields)
		{
			$query = $this->db->get_where('dbo.view_WBB',array("USERID"=>$fields['USERID'], "MONTH"=>$fields['MONTH'], "YEAR"=>$fields['YEAR']));
			if($query->num_rows()!=0)
			{
				$row = $query->row();
				return $row->NAME;
			}
			else
			{
				return 'Tiada WBB';
			}
		}

		public function get_wbb_by_date($user_id, $tarikh)
		{
			$sql = "SELECT
					dbo.USER_OF_RUN.USERID,
					dbo.USER_OF_RUN.NUM_OF_RUN_ID,
					CONVERT(VARCHAR(10), dbo.USER_OF_RUN.STARTDATE, 120) as MULA,
					CONVERT(VARCHAR(10), dbo.USER_OF_RUN.ENDDATE, 120) as AKHIR
					FROM dbo.USER_OF_RUN
					WHERE dbo.USER_OF_RUN.USERID = $user_id
					AND CONVERT(VARCHAR(10), dbo.USER_OF_RUN.STARTDATE, 120) <= '$tarikh'
					AND CONVERT(VARCHAR(10), dbo.USER_OF_RUN.ENDDATE, 120) >= '$tarikh'
					";
			$query = $this->db->query($sql);
			if($query->num_rows()!=0)
			{
				$row = $query->row();
				return $row->NUM_OF_RUN_ID;
			}
			else
			{
				return '0';
			}
		}

		public function getWBB2($fields)
		{
			$query = $this->db->get_where('dbo.view_WBB',array("USERID"=>$fields['USERID'], "MONTH"=>$fields['MONTH'], "YEAR"=>$fields['YEAR']));
			if($query->num_rows()!=0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}

		public function get_list_wbb($cond) // get by n=name, t=time
		{
			$sql = "SELECT
					dbo.NUM_RUN.NUM_RUNID,
					dbo.NUM_RUN.NAME,
					CONVERT(VARCHAR(8), dbo.NUM_RUN_DEIL.STARTTIME, 108) AS MULA,
					CONVERT(VARCHAR(8), dbo.NUM_RUN_DEIL.ENDTIME, 108) AS AKHIR
					FROM
					dbo.NUM_RUN_DEIL
					INNER JOIN dbo.NUM_RUN ON dbo.NUM_RUN_DEIL.NUM_RUNID = dbo.NUM_RUN.NUM_RUNID
					WHERE dbo.NUM_RUN_DEIL.SDAYS = 1";

			$list[0] = '00:00:00';
			$query=$this->db->query($sql);

			foreach($query->result() as $row)
			{
				if($cond == 'n')
				{
					$list[$row->NUM_RUNID] = $row->NAME;
				}
				if($cond == 't')
				{
					$list[$row->NUM_RUNID] = $row->MULA;
				}
			}

			return $list;
		}

		public function getUserInfo($userid)
		{
			$sql = "select * from USERINFO a, DEPARTMENTS b where a.DEFAULTDEPTID=b.DEPTID and a.USERID=?";
			$query=$this->db->query($sql,  array('USERID' => $userid));
			return $query;

		}

		public function getUserInfoArkib($userid)
		{
			$sql = "select * from att_arkib_userinfo a, DEPARTMENTS b where a.DEFAULTDEPTID=b.DEPTID and a.USERID=?";
			$query=$this->db->query($sql,  array('USERID' => $userid));
			return $query;

		}

		public function updateInfo($fields, $key)
		{
			$this->db->where('USERID', $key);
			$this->db->update('dbo.USERINFO', $fields);
		}

		public function getAllWBB($userid, $tahun)
		{
			$sql = "select * from view_WBB where USERID=? and YEAR=? order by MONTH asc";
			$query=$this->db->query($sql,  array('USERID' => $userid, 'YEAR' => $tahun));
			return $query;
		}

		public function hapusWBB($data)
		{
			$sql = "delete from USER_OF_RUN
					where USERID = ? and MONTH(STARTDATE) = ? and YEAR(STARTDATE) = ?";
			$this->db->query($sql,array($data['userid'],$data['bulan'],$data['tahun']));
		}

		public function tambahWBB($data)
		{
			//print_r($data);
			$this->db->insert('USER_OF_RUN', $data);
		}

		public function getPPP($userid)
		{
			$sql = "SELECT
				USERINFO_1.USERID,
				USERINFO_1.NAME,
				USERINFO_1.SSN,
				USERINFO_1.Email
				FROM USERINFO INNER JOIN USERINFO AS USERINFO_1 ON USERINFO.OPHONE = USERINFO_1.SSN
				WHERE (((USERINFO.OPHONE)<>''))
				AND USERINFO.USERID=?";
			$query=$this->db->query($sql,  array('USERID' => $userid));
			return $query;
		}

		public function getNoKP($userid)
		{
			$query = $this->db->get_where('dbo.USERINFO', array('USERID' => $userid));
			$row = $query->row();
			return $row->SSN;
		}

		public function getAllUser()
		{
			$sql = "dbo.att_get_all_staff_sp";
			return $this->db->query($sql);
		}

		public function get_user_by_dept($dept_id)
		{
			$sql = 'select * from dbo.USERINFO where DEFAULTDEPTID =' . $dept_id;
			return $this->db->query($sql);
		}

		public function get_user_info($user_id)
		{
			$sql = 'select * from dbo.USERINFO where USERID =' . $user_id;
			return $this->db->query($sql);
		}

		public function do_hapus($user_id)
		{
			$this->db->delete('dbo.USERINFO', array('USERID' => $user_id));
		}

		public function do_arkib($data)
		{
			$this->db->insert('dbo.att_arkib_userinfo', $data);
		}

		public function get_tak_lengkap($bulan, $tahun)
		{
			$sql = "select x.USERID, x.Badgenumber, x.Name
					from(SELECT
					dbo.USERINFO.USERID,
					convert(int,dbo.USERINFO.Badgenumber) as Badgenumber,
					dbo.USERINFO.Name
					FROM
					dbo.USERINFO
					WHERE
					dbo.USERINFO.USERID NOT IN ((select USERID from view_WBB where month=$bulan and year = $tahun))";
			if($this->session->userdata('role')==4 || $this->session->userdata('role')==5)
				$sql .= " AND dbo.USERINFO.DEFAULTDEPTID = " . $this->session->userdata('dept');

			$sql .= " UNION
					SELECT
					dbo.USERINFO.USERID,
					convert(int,dbo.USERINFO.Badgenumber) as Badgenumber,
					dbo.USERINFO.Name
					FROM
					dbo.USERINFO
					WHERE
					(dbo.USERINFO.OPHONE IS NULL OR
					dbo.USERINFO.OPHONE = '')";
			if($this->session->userdata('role')==4 || $this->session->userdata('role')==5)
				$sql .= " AND dbo.USERINFO.DEFAULTDEPTID = " . $this->session->userdata('dept');

			/*$sql .= " UNION
					SELECT
					dbo.USERINFO.USERID,
					dbo.USERINFO.Badgenumber,
					dbo.USERINFO.Name
					FROM
					dbo.USERINFO
					WHERE
					dbo.USERINFO.USERID NOT IN ((select USERID from view_WBB where month=07 and year = 2014))";
			if($this->session->userdata('role')==4 || $this->session->userdata('role')==5)
				$sql .= " AND dbo.USERINFO.DEFAULTDEPTID = " . $this->session->userdata('dept');*/

			$sql .= " UNION
					SELECT
					dbo.USERINFO.USERID,
					dbo.USERINFO.Badgenumber,
					dbo.USERINFO.Name
					FROM
					dbo.USERINFO
					WHERE
					(dbo.USERINFO.OPHONE IS NULL OR
					dbo.USERINFO.OPHONE = '')";
			if($this->session->userdata('role')==4 || $this->session->userdata('role')==5)
				$sql .= " AND dbo.USERINFO.DEFAULTDEPTID = " . $this->session->userdata('dept');

			$sql .= " UNION
					SELECT
					dbo.USERINFO.USERID,
					convert(int,dbo.USERINFO.Badgenumber) AS Badgenumber,
					dbo.USERINFO.Name

					FROM
					dbo.USERINFO
					WHERE 1=1
					AND (dbo.USERINFO.SSN IS NULL OR
					dbo.USERINFO.SSN = '' OR
					dbo.USERINFO.Name IS NULL OR
					dbo.USERINFO.Name = '' OR
					dbo.USERINFO.TITLE = '' OR
					dbo.USERINFO.USERID IS NULL OR
					dbo.USERINFO.street = '' OR
					dbo.USERINFO.PAGER IS NULL OR
					dbo.USERINFO.PAGER = '')";
			if($this->session->userdata('role')==4 || $this->session->userdata('role')==5)
				$sql .= " AND dbo.USERINFO.DEFAULTDEPTID = " . $this->session->userdata('dept');

			$sql .= ")x
					order by x.Badgenumber";
			return $this->db->query($sql);
		}

		public function chk_profil_info($user_id)
		{
			$sql = "SELECT
					dbo.USERINFO.USERID,
					convert(int,dbo.USERINFO.BADGENUMBER) as BADGENUMBER,
					dbo.USERINFO.NAME
					FROM
					dbo.USERINFO
					WHERE
					dbo.USERINFO.USERID = $user_id
					AND (dbo.USERINFO.SSN IS NULL OR
					dbo.USERINFO.SSN = '' OR
					dbo.USERINFO.NAME IS NULL OR
					dbo.USERINFO.NAME = '' OR
					dbo.USERINFO.TITLE = '' OR
					dbo.USERINFO.USERID IS NULL OR
					dbo.USERINFO.STREET = '' OR
					dbo.USERINFO.PAGER IS NULL OR
					dbo.USERINFO.PAGER = '')";
			return $this->db->query($sql);
		}

		function get_kod_warna_kad($user_id)
		{
			$sql = "select b.kw_kod
					from dbo.USERINFO a, dbo.att_xtra_userinfo b
					where 1=1
					and a.USERID = b.kw_userid
					and a.USERID = $user_id
					";
			return $this->db->query($sql);
		}

		function get_arkib_kod_warna_kad($user_id)
		{
			$sql = "select b.kw_kod
					from dbo.att_arkib_userinfo a, dbo.att_xtra_userinfo b
					where 1=1
					and a.USERID = b.kw_userid
					and a.USERID = $user_id
					";
			return $this->db->query($sql);
		}

		public function get_layak_ts($id, $bulan, $tahun) {
			$this->db->where('DEFAULTDEPTID', $id);
			$this->db->where('rpt_bulan', $bulan);
			$this->db->where('rpt_tahun', $tahun);

			if($this->session->userdata('role')==4)
			{
				$this->db->where('rpt_userid', $this->session->userdata('uid'));
			}
			$this->db->order_by('Name');
			$query = $this->db->get('dbo.view_justifikasi_kehadiran');
			return $query;
		}

		public function get_mail_add($userid)
		{
			$query = $this->db->get_where('dbo.USERINFO', array('USERID' => $userid));
			$row = $query->row();
			return $row->street;
		}

		public function insert_xtra($data)
		{
			//print_r($data);
			$this->db->insert('dbo.att_xtra_userinfo', $data);
		}

		public function get_user_id_by_nokp($nokp)
		{
			$query = $this->db->get_where('dbo.USERINFO', array('SSN' => $nokp));
			if ($query->num_rows())
			{
				$row = $query->row();
				return $row->USERID;
			}
			else
			{
				return 0;
			}
		}

		public function getAllWBB_daily($userid, $tahun)
		{
			$sql = "select *, convert(varchar(10),STARTDATE,120) as mula, convert(varchar(10),ENDDATE,120) as tamat from pcrs.view_shift where USERID=? and YEAR(STARTDATE)=? order by STARTDATE asc";
			$query=$this->db->query($sql,  array('USERID' => $userid, 'YEAR' => $tahun));
			return $query;
		}

		public function hapusWBB_daily($data)
		{
			$sql = "delete from USER_OF_RUN
					where USERID = ? and convert(varchar(10),STARTDATE,120) = ? and convert(varchar(10),ENDDATE,120) = ?";
			$this->db->query($sql,array($data['userid'],$data['mula'],$data['akhir']));
		}

		public function statusPPP($nokp)
		{
			$sql = "select distinct OPHONE from dbo.USERINFO
				where OPHONE = '$nokp'";
			$rst = $this->db->query($sql);
			return $rst->num_rows();
		}

		public function getPentadbirBahagian($bahagian = 0)
		{
			$sql = "select a.NAME, a.SSN, b.DEPTNAME
				from dbo.USERINFO a, dbo.DEPARTMENTS b, dbo.att_users c
				where 1=1
				and a.DEFAULTDEPTID = b.deptid
				and a.USERID = c.userid
				and c.roleid = 5";

			if($bahagian)
				$sql .= " and a.DEFAULTDEPTID = $bahagian";

			$rst = $this->db->query($sql);
			return $rst;
		}

		public function getAllPPP($dept_id = 0)
		{
			$sql = "SELECT DISTINCT
				dbo.USERINFO.NAME,
				dbo.USERINFO.SSN,
				dbo.DEPARTMENTS.DEPTNAME
				FROM dbo.USERINFO
				INNER JOIN dbo.USERINFO AS a ON dbo.USERINFO.SSN = a.OPHONE
				INNER JOIN dbo.DEPARTMENTS ON dbo.DEPARTMENTS.DEPTID = dbo.USERINFO.DEFAULTDEPTID
				WHERE 1=1";

			if($dept_id)
				$sql .= " and dbo.USERINFO.DEFAULTDEPTID = $dept_id";
			$sql .= " order by 3,1";
			$rst = $this->db->query($sql);
			return $rst;
		}

		public function getKetuaBahagian($bahagian = 0)
		{
			$sql = "select a.NAME, a.SSN, b.DEPTNAME
				from dbo.USERINFO a, dbo.DEPARTMENTS b, dbo.att_users c
				where 1=1
				and a.DEFAULTDEPTID = b.deptid
				and a.USERID = c.userid
				and c.roleid = 2";

			if($bahagian)
				$sql .= " and a.DEFAULTDEPTID = $bahagian";

			$rst = $this->db->query($sql);
			return $rst;
		}

		public function get_all_staff()
		{
			$sql = "SELECT
				dbo.USERINFO.USERID,
				dbo.USERINFO.DEFAULTDEPTID
				FROM
				dbo.USERINFO
				WHERE 1=1
				AND DEFAULTDEPTID <> 1";
			$rst = $this->db->query($sql);
			return $rst;
		}
	}
