<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {
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
		$data['bil_Kelulusan_timeslip'] = $this->mtimeslip->getPermohonanKelulusan(($this->session->userdata('dept')) ? $this->session->userdata('dept') : 0, $this->session->userdata('nokp'));
		$data['calendar'] = $this->kalendar(($this->uri->segment(2)?$this->uri->segment(2):date("Y")), ($this->uri->segment(3)?$this->uri->segment(3):date("m")));
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

	private function kalendar($tahun, $bulan)
	{
		$prefs = array(
			'start_day' => 'monday',
			'month_type' => 'long',
			'day_type' => 'long',
			'show_next_prev'  => TRUE,
            'next_prev_url'   => base_url('welcome'),
			'template' => '{table_open}<table class="calendar">{/table_open}
				 {heading_row_start}<tr class="navigation">{/heading_row_start}

				{heading_previous_cell}<th><a class="btn btn-default" href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
				{heading_title_cell}<th colspan="{colspan}"><h1>{heading}</h1></th>{/heading_title_cell}
				{heading_next_cell}<th><a class="btn btn-default" href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

				{heading_row_end}</tr>{/heading_row_end}

    			{week_day_cell}<th class="day_header">{week_day}</th>{/week_day_cell}
    			{cal_cell_content}<span class="day_listing">{day}</span>&nbsp;&bull; {content}&nbsp;{/cal_cell_content}
    			{cal_cell_content_today}<div class="today"><span class="day_listing">{day}</span>&bull; {content}</div>{/cal_cell_content_today}
    			{cal_cell_no_content}<span class="day_listing">{day}</span>&nbsp;{/cal_cell_no_content}
    			{cal_cell_no_content_today}<div class="today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content_today}',
		);
		$this->load->library('calendar', $prefs);

		$dataCal = array(
			3 => 'http://example.com/news/article/2006/03/',
			7 => 'http://example.com/news/article/2006/07/',
			13 => 'http://example.com/news/article/2006/13/',
			26 => 'http://example.com/news/article/2006/26/'
		);

		return $this->calendar->generate($tahun, $bulan, $dataCal);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
