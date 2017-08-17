<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kakitangan extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if(isset($_POST['btnFilter'])){
		}else{
			$this->session->set_userdata('id', FALSE);
			$this->session->set_userdata('nama', FALSE);
			$this->session->set_userdata('deptid', FALSE);
		}
		$this->load->model('muserinfo','userinfo');
		$this->load->model('mdepartment','department');

		//$data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array('DEPTID','DEPTNAME'),TRUE);
		$filter['id'] = $this->session->userdata('id');
		$filter['nama'] = $this->session->userdata('nama');
		$filter['deptid'] = $this->session->userdata('deptid');

		$data['staff'] = $this->userinfo->getAll($filter);
		$data["links"] = $this->pagination->create_links();

		$tpl['main_content'] = $this->load->view('kakitangan/v_senarai', $data, TRUE);
		$tpl['js_plugin'] = array('table');
		$tpl['js_plugin_xtra'] = array($this->load->view('kakitangan/v_js_plugin_xtra', '', TRUE));
		$this->load->view('tpl/v_main', $tpl);
	}

	public function profile($userid){
		$this->load->model('muserinfo','userinfo');
		$this->load->model('mdepartment','department');

		if(!isset($_POST['hddUserId'])){
			$data['userinfo'] = $this->userinfo->getUserInfo($userid);
			$data['head_title'] = 'Profil - Sistem Maklumat Kehadiran Bersepadu';
			//$data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array('DEPTID','DEPTNAME'),TRUE);
			$data['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', true));
			$this->load->view("kakitangan/v_profile", $data);
		}else{
			$this->load->library('form_validation');
			if ($this->form_validation->run('profile') == FALSE){
				echo 0;
			}else{
				$primary = $this->input->post('hddUserId');
				$fields = array('Name' => $this->input->post('txtNama'),
								'SSN' => $this->input->post('txtNoKP'),
								'TITLE' => $this->input->post('txtJawatan'),
								'Email' => $this->input->post('txtEmel'),
								'PAGER' => $this->input->post('txtTelefon'),
								'DEFAULTDEPTID' => $this->input->post('comBahagian')
								);
				$this->userinfo->updateInfo($fields, $primary);
				echo 1;
			}
		}
	}

	public function wbb($userid)
	{
		$this->load->model('muserinfo','userinfo');
		$this->load->model('mwbb','wbb');

		$data['userinfo'] = $this->userinfo->getUserInfo($userid);
		$data['head_title'] = 'Profil WBB - Sistem Maklumat Kehadiran Bersepadu';
		$data['tahun'] = array(date('Y')=>date('Y'),date('Y')+1=>date('Y')+1);
		$data['userid'] = $userid;
		$data['dict_wbb'] = $this->wbb->get_dict_wbb();
		$this->load->view("kakitangan/v_wbb", $data);
	}

	public function rekod_wbb()
	{
		$this->load->model('muserinfo','userinfo');

		$userid = $this->input->post('userid');
		$tahun = $this->input->post('tahun');

		$data['rekod'] = $this->userinfo->getAllWBB($userid, $tahun);
		$data['userid'] = $userid;
		$this->load->view("kakitangan/v_senarai_wbb", $data);
	}

	public function rekod_wbb_daily()
	{
		$this->load->model('muserinfo','userinfo');

		$userid = $this->input->post('userid');
		$tahun = $this->input->post('tahun');

		$data['rekod'] = $this->userinfo->getAllWBB_daily($userid, $tahun);
		$data['userid'] = $userid;
		$this->load->view("kakitangan/v_senarai_wbb_daily", $data);
	}

	public function jana_bulan()
	{
		$vars['tahun'] = $this->input->post('tahun');
		$this->load->view('kakitangan/v_bulan', $vars);
	}

	public function hapus_wbb($userid)
	{
		$this->load->model('muserinfo','userinfo');
		$this->load->model('muserlewat','userlewat');

		$data['userid'] = $userid;
		$data['bulan'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');

		$this->userinfo->hapusWBB($data);
		$this->userlewat->do_hapus($data['userid'], $data['bulan'], $data['tahun']);
		$this->todolog->write_log('Time: ' . standard_date('DATE_RFC822', time()) . ' Address: ' . $_SERVER["REMOTE_ADDR"] . ' User: ' . $this->session->userdata('userid') . ' Msg: Hapus WBB Untuk Kakitangan ' . $userid . ' untuk bulan '. $data['bulan'] . $this->input->post('tahun'));
	}

	public function simpan_wbb($userid)
	{
		$this->load->model('muserinfo','userinfo');
		$this->load->model('muserlewat');
		$this->load->model('mlaporan');
		$this->load->model('mwbb');
		$this->load->model('mcuti', 'cuti');

		foreach($this->input->post('comBulan') as $val)
		{
			$rst_wbb = $this->mwbb->check_exist_wbb($userid, $val, $this->input->post('comTahun'));
			if($rst_wbb->num_rows() == 0)
			{
				$data['USERID'] = $userid;
				$data['NUM_OF_RUN_ID'] =$this->input->post('comWbb');
				$data['STARTDATE'] = date('Y-m-d',mktime('0','0','0',$val,1,$this->input->post('comTahun')));
				$data['ENDDATE'] =  date('Y-m-d',mktime('0','0','0',$val,cal_days_in_month(CAL_GREGORIAN, $val, $this->input->post('comTahun')),$this->input->post('comTahun')));
				$this->userinfo->tambahWBB($data);

				//re-generate lewat untuk bulan yang telah wujud rekod
				if($this->muserlewat->get_checkinout($data['USERID'], $val, $this->input->post('comTahun'))!=0)
				{
					$tkh = $data['STARTDATE'];
					do{
						if(strtotime($tkh) < strtotime(date('Y-m-d')))
						{
							$shift = $this->mwbb->get_start_shift_by_user_wbb($data['USERID'], date('Y-m-d', strtotime($tkh)));
							if(date('N', strtotime($tkh))!=6 && date('N', strtotime($tkh))!=7)
							{
								$cuti = $this->cuti->get_by_bulan_tahun(date('m', strtotime($tkh)), date('Y', strtotime($tkh)));
								$start_time = $tkh . ' ' . $shift[0];
								$check_time = $this->mlaporan->rpt_kehadiran_in($data['USERID'], $tkh);
								if($check_time)
								{
									if(strtotime($check_time) >= strtotime('+1 minutes', strtotime($start_time)))
									{
										$lewat['USERID'] = $data['USERID'];
										$lewat['CHECKTIME'] = date('Y-m-d H:i:s', strtotime($check_time));
										$lewat['SEND_SMS'] = 1;
										$lewat['NUM_RUNID'] = $data['NUM_OF_RUN_ID'];
										$this->muserlewat->do_save($lewat);
									}
								}
							}
							//re gen finale attendance
							$this->mlaporan->gen_update_final_attendance($data['USERID'], $tkh, $shift, $cuti);
						}
						$tkh = date('Y-m-d', strtotime('+1 day', strtotime($tkh)));
					} while ($tkh != $data['ENDDATE']);
				}

				$this->todolog->write_log('Time: ' . standard_date('DATE_RFC822', time()) . ' Address: ' . $_SERVER["REMOTE_ADDR"] . ' User: ' . $this->session->userdata('userid') . ' Msg: Mengubah Suai WBB Untuk Kakitangan ' . $userid . ' untuk bulan '. $val . $this->input->post('comTahun'));
				echo "Maklumat telah berjaya disimpan!";
			}
			else
			{
				echo "Maaf! Maklumat Telah Wujud.";
			}
		}
	}

	public function simpan_wbb_shift($userid)
	{
		$this->load->model('muserinfo','userinfo');
		$this->load->model('muserlewat');
		$this->load->model('mlaporan');
		$this->load->model('mwbb');
		$this->load->model('mcuti', 'cuti');

		if($this->input->post('mula') && $this->input->post('akhir'))
		{
			$rst_wbb = $this->mwbb->check_exist_wbb_shift($userid, $this->input->post('mula'), $this->input->post('akhir'));
			if($rst_wbb->num_rows() == 0)
			{
				$data['USERID'] = $userid;
				$data['NUM_OF_RUN_ID'] =$this->input->post('comWbb');
				$data['STARTDATE'] = date('Y-m-d',strtotime($this->input->post('mula')));
				$data['ENDDATE'] =  date('Y-m-d',strtotime($this->input->post('akhir')));
				$this->userinfo->tambahWBB($data);

				//re-generate lewat untuk bulan yang telah wujud rekod
				if($this->muserlewat->get_checkinout_shift($data['USERID'], $this->input->post('mula'), $this->input->post('akhir'))!=0)
				{
					$tkh = $data['STARTDATE'];
					do{
						if(strtotime($tkh) < strtotime(date('Y-m-d')))
						{
							if(date('N', strtotime($tkh))!=6 && date('N', strtotime($tkh))!=7)
							{
								$cuti = $this->cuti->get_by_bulan_tahun(date('m', strtotime($tkh)), date('Y', strtotime($tkh)));
								$shift = $this->mwbb->get_start_shift_by_user_wbb($data['USERID'], date('Y-m-d', strtotime($tkh)));
								$start_time = $tkh . ' ' . $shift[0];

								$check_time = $this->mlaporan->rpt_kehadiran_in($data['USERID'], $tkh);
								if($check_time)
								{
									if(strtotime($check_time) >= strtotime('+0 minutes', strtotime($start_time)))
									{
										$lewat['USERID'] = $data['USERID'];
										$lewat['CHECKTIME'] = date('Y-m-d H:i:s', strtotime($check_time));
										$lewat['SEND_SMS'] = 1;
										$lewat['NUM_RUNID'] = $data['NUM_OF_RUN_ID'];
										$this->muserlewat->do_save($lewat);
									}
								}

								//re gen finale attendance
								$this->mlaporan->gen_update_final_attendance($data['USERID'], $tkh, $shift, $cuti);
							}
						}
						$tkh = date('Y-m-d', strtotime('+1 day', strtotime($tkh)));
					} while ($tkh != $data['ENDDATE']);
				}

				$this->todolog->write_log('Time: ' . standard_date('DATE_RFC822', time()) . ' Address: ' . $_SERVER["REMOTE_ADDR"] . ' User: ' . $this->session->userdata('userid') . ' Msg: Mengubah Suai WBB Untuk Kakitangan ' . $userid . ' bertarikh '. $this->input->post('mula') . " hingga " . $this->input->post('tamat'));
				echo "Maklumat Shift telah berjaya disimpan!";
			}
			else
			{
				echo "Maaf! Maklumat Telah Wujud.";
			}
		}
		else
		{
			$data['USERID'] = $userid;
			$data['NUM_OF_RUN_ID'] =$this->input->post('comWbb');
			$data['STARTDATE'] = date('Y-m-d',strtotime($this->input->post('from')));
			$data['ENDDATE'] =  date('Y-m-d',strtotime($this->input->post('to')));
			$rst_wbb = $this->mwbb->check_exist_wbb($userid, $val, $this->input->post('comTahun'));
		}
	}

	public function ppp($userid)
	{
		$this->load->model('muserinfo','userinfo');
		$this->load->model('mdepartment','department');

		$data['departments'] = pcrs_rst_to_option($this->department->getUnitsPPP(1), array('DEPTID','DEPTNAME'),TRUE);
		$data['ppp'] = $this->userinfo->getPPP($userid);
		$data['userid'] = $userid;
		$data['js_plugin_xtra'] = array($this->load->view('kakitangan/v_js_plugin_ppp', '', true));
		$this->load->view("kakitangan/v_ppp", $data);
	}

	public function warna_kad($userid)
	{


		if(!$this->input->post('comKodWarna'))
		{
			$this->load->model('muserinfo','userinfo');
			$data['warna'] = $this->userinfo->get_kod_warna_kad($userid);
			$data['userid'] = $userid;
			$this->load->view("kakitangan/v_kod_warna_kad", $data);
		}
		else
		{
			$this->load->model('mkodwarna','kod_warna');
			$field['kw_kod'] = $this->input->post('comKodWarna');
			$this->kod_warna->do_update($userid, $field);
		}
	}

	public function arkib($userid){

		$this->load->model('muserinfo','userinfo');
		$this->load->model('mdepartment','department');

		if(!$this->input->post('hddUserId')){
			$data['userinfo'] = $this->userinfo->getUserInfo($userid);
			$data['head_title'] = 'Profil - Sistem Maklumat Kehadiran Bersepadu';
			$data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array('DEPTID','DEPTNAME'),TRUE);
			$this->load->view("kakitangan/v_arkib", $data);
		}
		else
		{
			$this->db->trans_start();
			$rst = $this->userinfo->get_user_info($userid);
			$row = $rst->row_array();
			$this->userinfo->do_arkib($row);
			$this->userinfo->do_hapus($userid);
			$this->db->trans_complete();
			echo 1;
		}
	}


	public function bahagian()
	{
		$this->load->model('muserinfo', 'userinfo');
		$vars['pilihan'] = pcrs_rst_to_option($this->userinfo->getByUnitIDPPP($this->input->post('id', TRUE)), array('USERID','NAME'), TRUE);
		$this->load->view('tpl/option', $vars);
	}

	public function bahagian_user()
	{
		$this->load->model('muserinfo', 'userinfo');
		$vars['pilihan'] = pcrs_rst_to_option($this->userinfo->getByUnitID($this->input->post('id', TRUE)), array('USERID','NAME'), TRUE);
		$this->load->view('tpl/option', $vars);
	}

	public function bahagian_user_ppp()
	{
		$this->load->model('muserinfo', 'userinfo');
		$vars['pilihan'] = pcrs_rst_to_option($this->userinfo->getByUnitID_PPP($this->input->post('id', TRUE)), array('USERID','NAME'), TRUE);
		$this->load->view('tpl/option', $vars);
	}

	public function bahagian_user_arkib()
	{
		$this->load->model('muserinfo', 'userinfo');
		$vars['pilihan'] = pcrs_rst_to_option($this->userinfo->getByUnitIDArkib($this->input->post('id', TRUE)), array('USERID','NAME'), TRUE);
		$this->load->view('tpl/option', $vars);
	}

	public function layak_ts()
	{
		$this->load->model('muserinfo', 'userinfo');
		$vars['pilihan'] = pcrs_rst_to_option($this->userinfo->get_layak_ts($this->input->post('id', TRUE), $this->input->post('bulan', TRUE), $this->input->post('tahun', TRUE)), array('rpt_userid','Name'), TRUE);
		$this->load->view('tpl/option', $vars);
	}

	public function simpan_ppp($userid)
	{
		$this->load->model('muserinfo','userinfo');
		$PPPuserID = $this->input->post('comRptKakitangan');
		$fields = array('OPHONE' => $this->userinfo->getNoKP($PPPuserID));
		$this->userinfo->updateInfo($fields, $userid);
		echo "Maklumat telah berjaya disimpan";
	}

	public function hapus_wbb_daily($userid)
	{
		$this->load->model('muserinfo','userinfo');
		$this->load->model('muserlewat','userlewat');

		$data['userid'] = $userid;
		$data['mula'] = $this->input->post('mula');
		$data['akhir'] = $this->input->post('akhir');

		$this->userinfo->hapusWBB_daily($data);
		$this->userlewat->do_hapus_daily($data['userid'], $data['mula'], $data['akhir']);
		$this->todolog->write_log('Time: ' . standard_date('DATE_RFC822', time()) . ' Address: ' . $_SERVER["REMOTE_ADDR"] . ' User: ' . $this->session->userdata('userid') . ' Msg: Hapus WBB Untuk Kakitangan ' . $userid . ' bertarikh '. $data['mula'] . " hingga " . $data['akhir']);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
