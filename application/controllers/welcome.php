<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {

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
		$this->load->model('mlaporan');
		$this->load->model('muserinfo');
		$this->load->model('muserlewat');
		$this->load->model('mjustifikasi');
		$this->load->model('mtimeslip');

		if(	$this->session->userdata('role')==1 )
		{
			$data['top_ten'] = $this->mlaporan->get_top_ten(date('m'), date('Y'),1);
		}
		else {
			$data['top_ten'] = $this->mlaporan->get_top_ten(date('m'), date('Y'), $this->session->userdata('dept'));
		}

		if(	$this->session->userdata('role')==1 )
		{
			$data['stat_x_punch_inout'] = $this->mlaporan->stat_x_punch_inout(date('m'), date('Y'), 1);
		}
		else
		{
			$data['stat_x_punch_inout'] = $this->mlaporan->stat_x_punch_inout(date('m'), date('Y'), $this->session->userdata('dept'));
		}

		$data['years'] = $this->mlaporan->getTahunFromFinalAtt();
		$data['sen_lewat_hari'] = $this->muserlewat->get_hari_lewat(date('Y-m-d'));
		$data['bil_lewat'] = $this->muserlewat->jumlah_lewat($this->session->userdata('uid'), date('m'), date('Y'));
		$data['bil_kelulusan_justifikasi'] = $this->mjustifikasi->alert_bil_justifikasi($this->session->userdata("nokp"), date('Y'), date('m'));
		$data['bil_Kelulusan_timeslip'] = $this->mtimeslip->getPermohonanKelulusan($this->session->userdata('dept'), $this->session->userdata('nokp'));
		$tpl['js_plugin'] = array('morris', 'table', 'popup', 'timepicker');
		$tpl['js_plugin_xtra'] = array($this->load->view('dashboard/v_chart', '', TRUE), $this->load->view('kakitangan/v_js_plugin_xtra', '', TRUE), $this->load->view('dashboard/v_js_panel', '', TRUE));
		$tpl['main_content'] = $this->load->view('dashboard/v_default', $data, TRUE);
		$this->load->view('tpl/v_main', $tpl);
	}

	public function bil_lewat()
	{
		$user_id = $this->session->userdata('uid');
		$m = $this->input->post('comBulan');
		$y = $this->input->post('comTahun');

		$this->load->model('muserlewat');
		$tpl['rst_lewat'] = $this->muserlewat->jumlah_lewat($user_id, $m, $y);
		//print_r($rst_lewat);
		$this->load->view('dashboard/v_panel_bil_lewat', $tpl);
	}

	public function justifikasi_kehadiran()
	{
		$user_id = $this->session->userdata('uid');
		$m = $this->input->post('comBulan');
		$y = $this->input->post('comTahun');

		$this->load->model('mlaporan');
		$this->load->model('muserinfo');

		$tpl['rst_justifikasi'] = $this->mlaporan->get_kakitangan_layak_ts_info($user_id, $m, $y);
		$tpl['list_wbb_name'] = $this->muserinfo->get_list_wbb('n');
		$tpl['list_wbb_time'] = $this->muserinfo->get_list_wbb('t');
		$tpl['month'] = $m;
		$tpl['year'] = $y;
		$this->load->view('dashboard/v_panel_justifikasi', $tpl);
	}

	public function department()
	{
		$this->load->model('mdepartment');

		if($this->session->userdata('role')==1)
		{
			$id = $this->input->post('id') ? intval($this->input->post('id')) : 0;
		}
		else
		{
			$id = $this->input->post('id') ? intval($this->input->post('id')) : $this->session->userdata('parent');
		}

		$result = array();
		$rst = $this->mdepartment->getUnitsPPP($id);
		foreach($rst->result() as $row)
		{
			$node = array();
			$node['id'] = $row->DEPTID;
			$node['text'] = $row->DEPTNAME;
			$node['state'] = pcrs_has_child($row->DEPTID) ? 'closed' : 'open';
			array_push($result,$node);
		}
		echo json_encode($result);
	}

	public function sub_department()
	{
		if($this->input->post('cmdSubmit'))
		{
			print_r($this->input->post('deptid'));
		}
		else
		{
        	$tpl['main_content'] = $this->load->view('cron/v_default', '', true);
        	$this->load->view('tpl/v_main', $tpl);
		}
	}

	public function about()
	{
		$this->load->view('tpl/v_about');
	}

	public function hapus_justifikasi()
	{
		$this->load->model('mjustifikasi');
		
		if(!$this->mjustifikasi->hapus($this->input->post('justifikasi_id')))
		{
			return $this->output->set_status_header(404, 'Operasi hapus justifikasi ini tidak berjaya!');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
