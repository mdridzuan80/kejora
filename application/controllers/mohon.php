<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mohon extends MY_Controller {

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
		$tpl['main_content'] = $this->load->view('dashboard/v_default', '', TRUE);
		$this->load->view('tpl/v_main', $tpl);
	}

	public function keluar()
	{
		$this->load->model('mtimeslip', 'timeslip');
		$data['permohonan'] = $this->timeslip->getPermohonan();
		$data['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', TRUE));
		$tpl['main_content'] = $this->load->view('permohonan/v_timeslip_default', $data, TRUE);
		$tpl['js_plugin'] = array('timepicker');
		$this->load->view('tpl/v_main', $tpl);
	}

	public function timeslip()
	{
		$this->load->model('mtimeslip', 'timeslip');
		$data['permohonan'] = $this->timeslip->getPermohonan();
		$data['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', TRUE));
		$tpl['main_content'] = $this->load->view('permohonan/v_timeslip_default', $data, TRUE);
		$tpl['js_plugin'] = array('timepicker');
		$this->load->view('tpl/v_main', $tpl);
	}

	public function timeslip_mohon()
	{
		if(isset($_POST['comRptKakitangan'])){
			$fields['ts_userid'] = $this->input->post('comRptKakitangan');
			$fields['ts_jenis'] = $this->input->post('comJenis');
			$fields['ts_tkh_terlibat'] = date('Y-m-d',strtotime($this->input->post('txtTarikh')));
			$fields['ts_chkin'] = date('Y-m-d H:i',strtotime($this->input->post('txtTarikh') . ' ' . $this->input->post('txtFrom')));
			$fields['ts_chkout'] = date('Y-m-d H:i',strtotime($this->input->post('txtTarikh') . ' ' . $this->input->post('txtTo')));
			$fields['ts_alasan'] = $this->input->post('txtPerihalPermohonan');

			$this->load->model('mtimeslip','timeslip');
			$this->load->model('mpelulus','pelulus');
			$this->load->model('muserinfo','userinfo');

				$rst_pelulus = $this->userinfo->getPPP($this->input->post('comRptKakitangan'));

				if($rst_pelulus->num_rows)
				{
					$data['rst_info_pemohon'] = $this->userinfo->getUserInfo($this->input->post('comRptKakitangan'));
					if($data['rst_info_pemohon']->num_rows())
					{
						$info_pemohon = $data['rst_info_pemohon']->row();
						$pemohon = $info_pemohon->NAME;
						$data['name'] = $pemohon;
						$data['jenis'] = $fields['ts_jenis'];
						$data['check_in'] = $fields['ts_chkin'];
						$data['check_out'] = $fields['ts_chkout'];
						$data['alasan'] = $fields['ts_alasan'];
						$data['hari'] = $this->config->item('pcrs_hari');
						$title = '[PCRS] Memohon Kelulusan Permohonan Keluar oleh ' . $pemohon . ' pada ' . date('d-m-Y',strtotime($data['check_in']));
						$message = $this->load->view('permohonan/v_emel_notify', $data, TRUE);
						
						if($this->timeslip->do_mohon($fields))
						{	
							$this->load->library("notifikasi");
							$this->notifikasi->sendEmail($rst_pelulus->row()->Email, $title, $message); // emel dia...
							echo "Permohonan anda telah di hantar";
						}
						else
						{
							echo "Ralat! Permohonan tidak berjaya disimpan.";
						}
					}
				}
				else
				{
					echo "Ralat! Sila pastikan bahagian pemohon memiliki pelulus.";
				}
			
		}
		else
		{
			$this->load->model('mdepartment','department');

			$data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array('DEPTID','DEPTNAME'),TRUE);
			$data['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', TRUE));
			$this->load->view('permohonan/v_popup_timeslip_mohon', $data);
		}
	}

	public function timeslip_batal()
	{
		if($this->input->post('id')){
			$this->load->model('mtimeslip', 'timeslip');
			$timeslip_id = $this->input->post('id');
			if($this->timeslip->chk_status($timeslip_id) == 'M'){
				$cond = $this->timeslip->do_batal($timeslip_id);
				if($cond)
					echo 'TRUE';
				else
					echo 'FALSE';
			} else {
				echo 'FALSE';
			}
		}
	}

	public function away()
	{
		$this->load->model('maway', 'away');
		$data['permohonan'] = $this->away->getPermohonan();
		$data['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', TRUE));
		$tpl['main_content'] = $this->load->view('permohonan/v_away_default', $data, TRUE);
		$tpl['js_plugin'] = array('timepicker');
		$this->load->view('tpl/v_main', $tpl);
	}

	public function away_mohon()
	{
		if(isset($_POST['comRptKakitangan'])){
			$fields['aw_userid'] = $this->input->post('comRptKakitangan');
			$fields['aw_chkin'] = date('Y-m-d H:i',strtotime($this->input->post('txtTarikh') . ' ' . $this->input->post('txtFrom')));
			$fields['aw_chkout'] = date('Y-m-d H:i',strtotime($this->input->post('txtTarikh') . ' ' . $this->input->post('txtTo')));
			$fields['aw_alasan'] = $this->input->post('txtPerihalPermohonan');

			$this->load->model('maway','away');
			$this->load->model('mpelulus','pelulus');
			$this->load->model('muserinfo','userinfo');
			$permohonan_id = $this->away->do_mohon($fields);
			if($permohonan_id)
			{
				$rst_pelulus = $this->pelulus->get_pelulus($this->userinfo->getDefaultDepartment($this->input->post('comRptKakitangan')));
				if($rst_pelulus->num_rows())
				{
					foreach($rst_pelulus->result() as $pelulus)
					{
						if($pelulus->pl_role == 'Y')
						{
							$emel_to[] = $pelulus->street;
						}
						else
						{
							$emel_cc[] = $pelulus->street;
						}
					}

					//debug perporses
					$emel_to = array('mdridzuan@melaka.gov.my');
					$emel_cc = array();
					//debug perporses

					$data['rst_info_pemohon'] = $this->userinfo->getUserInfo($this->input->post('comRptKakitangan'));
					if($data['rst_info_pemohon']->num_rows())
					{
						$info_pemohon = $data['rst_info_pemohon']->row();
						$pemohon = $info_pemohon->Name;
						$data['permohonan_id'] = $permohonan_id;
						$data['check_in'] = $fields['aw_chkin'];
						$data['check_out'] = $fields['aw_chkout'];
						$data['alasan'] = $fields['aw_alasan'];
						$data['hari'] = $this->config->item('pcrs_hari');
						$title = '[PCRS] Catatan Away oleh ' . $pemohon . ' pada ' . date('d-m-Y',strtotime($data['check_in']));
						$message = $this->load->view('permohonan/v_emel_notify', $data, TRUE);
						$emel_bcc = array('mdridzuan@melaka.gov.my', 'ajib@melaka.gov.my');
						pcrs_send_email($emel_to, $title, $message, $emel_cc, $emel_bcc);
						//pcrs_send_email($emel_bcc, $title, $message);
					}
					echo "Catatan anda telah di simpan";
				}
				else
				{
					echo "Ralat! Sila pastikan bahagian pemohon memiliki pelulus.";
				}
			}
			else
			{
				echo "Ralat! Data tidak berjaya disimpan.";
			}
		}
		else
		{
			$this->load->model('mdepartment','department');
			$this->load->model('mktgaway','ktg_away');

			$data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array('DEPTID','DEPTNAME'),TRUE);
			$data['ktg_aways'] = pcrs_rst_to_option($this->ktg_away->getAll(), array('away_ktg_id','away_ktg_perihal'),TRUE);
			$data['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', TRUE));
			$this->load->view('permohonan/v_popup_away_mohon', $data);
		}
	}

	public function justifikasi()
	{
		$this->load->model('mdepartment', 'department');
        $data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array('DEPTID', 'DEPTNAME'), true);

        $tpl['js_plugin'] = array('timepicker');
        $tpl['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', true));

		$tpl['main_content'] = $this->load->view('permohonan/v_justifikasi_kehadiran', $data, TRUE);
		$this->load->view('tpl/v_main', $tpl);
	}

	public function justifikasi_mohon($tkh_terlibat)
	{
		if($this->input->post('hdd_rpt_id'))
		{
			$this->load->model('mjustifikasi');

			//jika checkbox(kursus).checked = true
			if($this->input->post('kursus'))
			{
				if($this->input->post('mula')==$this->input->post('akhir'))
				{
					if($this->input->post('sama'))
					{
						if($this->input->post('txtCatatanPunchIn'))
						{
							$field['justifikasi_rpt_id'] = 0;
							$field['justifikasi_tkh_terlibat'] = $tkh_terlibat;
							$field['justifikasi_alasan'] = (string) $this->input->post('txtCatatanPunchIn');
							$field['justifikasi_user_id'] = $this->session->userdata('uid');

							$this->load->model('mjustifikasi');
							$this->mjustifikasi->simpan($field);

							$this->_notifi_justifikasi($this->session->userdata('uid'), $tkh_terlibat, $field, $this->input->post('akhir'));
						}
						else
						{
								echo '0';
						}
					}
					else
					{
						if($this->input->post('txtCatatanPunchIn') && $this->input->post('txtCatatanPunchOut'))
						{
							$field['justifikasi_rpt_id'] = 0;
							$field['justifikasi_tkh_terlibat'] = $tkh_terlibat;
							$field['justifikasi_alasan'] = (string) $this->input->post('txtCatatanPunchIn');
							$field['justifikasi_alasan_2'] = (string) $this->input->post('txtCatatanPunchOut');
							$field['justifikasi_user_id'] = $this->session->userdata('uid');

							$this->load->model('mjustifikasi');
							$this->mjustifikasi->simpan($field);

							$this->_notifi_justifikasi($this->session->userdata('uid'), $tkh_terlibat, $field, $this->input->post('akhir'));
						}
						else
						{
							echo '0';
						}
					}
				}
				else
				{
					$semasa = strtotime($this->input->post('mula'));
					if($this->input->post('txtCatatan'))
					{
						do
						{
							$field['justifikasi_rpt_id'] = 0;
							$field['justifikasi_tkh_terlibat'] = date('Y-m-d',$semasa);
							$field['justifikasi_alasan'] = (string) $this->input->post('txtCatatan');
							$field['justifikasi_user_id'] = $this->session->userdata('uid');

							$this->load->model('mjustifikasi');
							$this->mjustifikasi->simpan($field);
							$semasa = strtotime('+1 day',$semasa);
						} while($semasa <= strtotime($this->input->post('akhir')));

						$this->_notifi_justifikasi($this->session->userdata('uid'), $tkh_terlibat, $field, $this->input->post('akhir'));
					}
					else
					{
						echo '0';
					}
				}
			}
			else //jika checkbox(kursus).checked = false
			{
				if($this->input->post('sama'))
				{
					if($this->input->post('txtCatatanPunchIn'))
					{
						$field['justifikasi_rpt_id'] = 0;
						$field['justifikasi_tkh_terlibat'] = $tkh_terlibat;
						$field['justifikasi_alasan'] = (string) $this->input->post('txtCatatanPunchIn');
						$field['justifikasi_user_id'] = $this->session->userdata('uid');

						$this->load->model('mjustifikasi');
						$this->mjustifikasi->simpan($field);

						$this->_notifi_justifikasi($this->session->userdata('uid'), $tkh_terlibat, $field);
					}
					else
					{
						echo '0';
					}
				}
				else
				{
					if($this->input->post('txtCatatanPunchIn') || $this->input->post('txtCatatanPunchOut'))
					{
						if(isset($_POST['txtCatatanPunchIn']) && isset($_POST['txtCatatanPunchIn'])!='' && isset($_POST['txtCatatanPunchOut']) && $_POST['txtCatatanPunchOut']!='' )
						{
							$field['justifikasi_rpt_id'] = 0;
							$field['justifikasi_tkh_terlibat'] = $tkh_terlibat;
							$field['justifikasi_alasan'] =  (string) $this->input->post('txtCatatanPunchIn');
							$field['justifikasi_alasan_2'] = (string) $this->input->post('txtCatatanPunchOut');
							$field['justifikasi_user_id'] = $this->session->userdata('uid');

							$this->load->model('mjustifikasi');
							$this->mjustifikasi->simpan($field);

							$this->_notifi_justifikasi($this->session->userdata('uid'), $tkh_terlibat, $field);
						}
						else
						{
							if($this->input->post('txtCatatanPunchIn') && $this->input->post('txtCatatanPunchIn')!='' && !isset($_POST['txtCatatanPunchOut']))
							{
								$field['justifikasi_rpt_id'] = 0;
								$field['justifikasi_tkh_terlibat'] = $tkh_terlibat;
								$field['justifikasi_alasan'] =  (string) $this->input->post('txtCatatanPunchIn');
								$field['justifikasi_user_id'] = $this->session->userdata('uid');

								$this->load->model('mjustifikasi');
								$this->mjustifikasi->simpan($field);

								$this->_notifi_justifikasi($this->session->userdata('uid'), $tkh_terlibat, $field);
							}
							else
							{
								if(isset($_POST['txtCatatanPunchOut']) && $this->input->post('txtCatatanPunchOut')!='')
								{
									$field['justifikasi_rpt_id'] = 0;
									$field['justifikasi_tkh_terlibat'] = $tkh_terlibat;
									$field['justifikasi_alasan_2'] =  (string) $this->input->post('txtCatatanPunchOut');
									$field['justifikasi_user_id'] = $this->session->userdata('uid');

									$this->load->model('mjustifikasi');
									$this->mjustifikasi->simpan($field);

									$this->_notifi_justifikasi($this->session->userdata('uid'), $tkh_terlibat, $field);
								}
								else
								{
									echo '0';
								}
							}
						}
					}
					else
					{
						echo '0';
					}
				}
			}
		}
		else
		{
			$this->load->model('mfinalatt');

			$shift = pcrs_wbb_starttime($this->session->userdata('uid'), $tkh_terlibat);

			$data['rpt_id'] = $tkh_terlibat;
			$data['js_plugin_xtra'] = array($this->load->view('permohonan/v_popup_jastifikasi_mohon_js', '', TRUE));
			$data['punch_in'] = $this->mfinalatt->get_rekod_punch_inout('rpt_check_in',$tkh_terlibat);
			$data['punch_out'] = $this->mfinalatt->get_rekod_punch_inout('rpt_check_out',$tkh_terlibat);
			$data["lewat"] = 0;
			$data["awal"] = 0;
			if($data['punch_in'])
			{
				$dateString = date("Y-m-d", strtotime($tkh_terlibat)) . " " . $shift[0];

				if(strtotime($data['punch_in']) > strtotime($dateString))
				{
					$data["lewat"] = 1;
				}
				$dateString = date("Y-m-d", strtotime($tkh_terlibat)) . " " . $shift[2];
				if(strtotime($data['punch_out']) < strtotime($dateString))
				{
					$data["awal"] = 1;
				}
			}
			$this->load->view('permohonan/v_popup_justifikasi_mohon', $data);
		}
	}

	private function _notifi_justifikasi($user_id, $tkh_terlibat, $field, $tkh_akhir = false)
	{
		$emel_to = array();
		$emel_cc = array();

		$this->load->model('mpelulus','pelulus');
		$this->load->model('muserinfo','userinfo');

		$rst_info_pemohon = $this->userinfo->getUserInfo($user_id);
		$info_pemohon = $rst_info_pemohon->row();

		if($tkh_akhir)
		{
			$title = '[PCRS] Permohonan Justifikasi Kehadiran oleh ' . $info_pemohon->NAME . ' pada ' . $tkh_terlibat . ' hingga ' . $tkh_akhir;
		}
		else {
			$title = '[PCRS] Permohonan Justifikasi Kehadiran oleh ' . $info_pemohon->NAME . ' pada ' . $tkh_terlibat;
		}

		$data['pemohon'] = $info_pemohon->NAME;
		$data['maklumat_permohonan'] = $field;
		$data['hari'] = $this->config->item('pcrs_hari');
		$data['tkh_mula'] = $tkh_terlibat;
		$data['tkh_akhir'] = $tkh_akhir;

		$message = $this->load->view('dashboard/v_emel_justifikasi_notify', $data, TRUE);

		$rst_pelulus = $this->userinfo->getPPP($user_id);

		foreach($rst_pelulus->result() as $pelulus)
		{
				$emel_to[] = $pelulus->Email;
		}

		if( ENVIRONMENT == 'production' )
		{
			$this->load->library("notifikasi");
			$this->notifikasi->sendEmail($emel_to, $title, $message); // emel dia...
		}
		else
		{
			$title .= ' (Devel)';
			$emel_bcc[] = 'mdridzuan@melaka.gov.my';
			$this->load->library("notifikasi");
			$this->notifikasi->sendEmail($emel_bcc, $title, $message); // emel dia...
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
