<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelulusan extends MY_Controller {

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

	public function timeslip()
	{
		$this->load->model('mtimeslip', 'timeslip');

		if($this->input->server('REQUEST_METHOD') == "POST") {
			$mohon_id = $this->input->post('mohon_id');
			$flag = $this->input->post('flag');
			$this->timeslip->setKelulusan($mohon_id, $flag);
			$rst = $this->timeslip->get_maklumat($mohon_id);

			$row = $rst->row();
			$data['pemohon'] = $row;
			$data['hari'] = $this->config->item('pcrs_hari');
			//send mail kepada pemohon
			$this->load->model('muserinfo');
			$title = '[PCRS] Status Permohonan Keluar oleh ' . $row->Name . ' pada ' . date('d-m-Y',strtotime($row->ts_chkin));
			$message = $this->load->view('kelulusan/v_emel_notify', $data, TRUE);
			$email_pemohon = $this->muserinfo->get_mail_add($this->timeslip->get_user_id($mohon_id));

			$this->load->library("notifikasi");
			$this->notifikasi->sendEmail($email_pemohon, $title, $message);
		}
		else {
			$this->load->model('mpelulus', 'pelulus');
			$dept_priv = pcrs_rst_to_array($this->pelulus->getDeptId(), 'pl_deptid');
			$data['permohonan'] = $this->timeslip->getPermohonanKelulusan($this->session->userdata('dept'), $this->session->userdata('nokp'));
			$data['js_plugin_xtra'] = array($this->load->view('extrajs/v_js_kelulusan', '', TRUE));
			$tpl['main_content'] = $this->load->view('kelulusan/v_timeslip_default', $data, TRUE);
			$this->load->view('tpl/v_main', $tpl);
		}
	}

	public function timeslip_pulang()
	{
		$this->load->model('mtimeslip', 'timeslip');
		if(isset($_POST['mohon_id'])){
			$mohon_id = $this->input->post('mohon_id');
			$this->timeslip->setPengesahan($mohon_id);
		}else{
			$this->load->model('mpelulus', 'pelulus');
			$dept_priv = pcrs_rst_to_array($this->pelulus->getDeptId(), 'pl_deptid');
			$data['permohonan'] = $this->timeslip->get_permohonan_pengesahan($dept_priv);
			$data['js_plugin_xtra'] = array($this->load->view('extrajs/v_js_kelulusan', '', TRUE));
			$tpl['main_content'] = $this->load->view('kelulusan/v_timeslip_pulang', $data, TRUE);
			$this->load->view('tpl/v_main', $tpl);
		}
	}

	public function justifikasi()
	{
		if($this->input->server("REQUEST_METHOD") == "POST") {
			if($this->input->post('status'))
			{
				$this->load->model('mjustifikasi');
				
				$user_id = $this->input->post('userid');
				$tarikh = $this->input->post('tarikh');
				$status = $this->input->post('status');

				$this->mjustifikasi->do_update($user_id, $tarikh, $status);

				if($status == 'L')
				{
					$this->load->model('muserlewat');
					$this->muserlewat->do_update($user_id, $tarikh, array('INDICATOR'=>1));
				}

				$rst_pemohon = $this->mjustifikasi->get_maklumat_permohonan($user_id, $tarikh);
				$row = $rst_pemohon->row();
				$email_pemohon = $row->street;
				$data['pemohon'] = $row;
				$data['hari'] = $this->config->item('pcrs_hari');

				//send mail kepada pemohon
				$this->load->model('muserinfo');

				$title = '[PCRS] Status Permohonan Justifikasi Kehadiran oleh ' . $row->Name . ' pada ' . date('d-m-Y',strtotime($tarikh));
				$message = $this->load->view('kelulusan/v_emel_justifikasi_notify', $data, TRUE);

				if(ENVIRONMENT != 'development')
				{
					pcrs_send_email($email_pemohon, $title, $message, '', '');
				}
				else
				{
					pcrs_send_email('mdridzuan@melaka.gov.my', $title, $message, '', '');
				}
			}

			$this->load->model('mjustifikasi');
			$this->load->model('muserinfo');

			$segmen = $this->input->post('segmen');
			$dept_id = $this->input->post('deptid');
			$user_id = $this->input->post('comRptKakitangan');
			$bulan = $this->input->post('txtBulan');
			$tahun = $this->input->post('txtTahun');

			$data['sen_permohonan'] = $this->mjustifikasi->permohonan_under_ppp($user_id, $bulan, $tahun);
			$data['list_wbb_name'] = $this->muserinfo->get_list_wbb('n');
			$data['list_wbb_time'] = $this->muserinfo->get_list_wbb('t');

			$this->load->view('kelulusan/v_senarai_justifikasi', $data);
		}
		else {
			$this->load->model('muserinfo', 'ui');
			
			$data['sen_pyd'] = $this->ui->under_ppp($this->session->userdata("nokp"));
			$data["segmen"] = $this->uri->segment(1);
			$tpl['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', true));
			$tpl['main_content'] = $this->load->view('kelulusan/v_justifikasi', $data, TRUE);

			$this->load->view('tpl/v_main', $tpl);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
