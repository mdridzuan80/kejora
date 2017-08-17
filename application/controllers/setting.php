<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends MY_Controller {

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
		$tpl['main_content'] = $this->load->view('dashboard/v_home', '', TRUE);
		$this->load->view('tpl/v_main', $tpl);
	}

	public function ketua_bahagian()
	{
		$this->load->model('muserinfo','userinfo');

		$data['senKetuaBahagian'] = $this->userinfo->getKetuaBahagian();
		$tpl['main_content'] = $this->load->view('setting/v_ketua_bahagian', $data, TRUE);
		$this->load->view('tpl/v_main', $tpl);
	}

	public function ketua_bahagian_hapus()
	{
		$this->load->model('mpelulus');
		$pl_id = $this->input->post('pl_id');
		$this->mpelulus->do_hapus($pl_id);
		$this->todolog->write_log('Time: ' . standard_date('DATE_RFC822', time()) . ' Address: ' . $_SERVER["REMOTE_ADDR"] . ' User: ' . $this->session->userdata('userid') . ' Msg: Menghapuskan Setting Ketua Bahagian ' . $pl_id . ' Script: ' . $this->db->last_query());
	}

	public function cuti_umum()
	{	$this->load->model('mcuti', 'cuti');
		$data['cuti'] = $this->cuti->getAll(date('Y'));
		$tpl['js_plugin'] = array('timepicker');
		$tpl['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', TRUE));
		$tpl['main_content'] = $this->load->view('setting/v_cuti_umum', $data, TRUE);
		$this->load->view('tpl/v_main', $tpl);
	}

	public function cuti_umum_set()
	{
		if($this->input->post('txt_tkh_cuti')){
			$this->load->model('mcuti','cuti');
			$tkh_cuti = $this->input->post('txt_tkh_cuti');
			$perihal_cuti = $this->input->post('txt_perihal_cuti');
			$medan = array('cuti_mula'=>$tkh_cuti,
							'cuti_perihal'=>$perihal_cuti);
			$this->cuti->do_save($medan);
			$this->todolog->write_log('Time: ' . standard_date('DATE_RFC822', time()) . ' Address: ' . $_SERVER["REMOTE_ADDR"] . ' User: ' . $this->session->userdata('userid') . ' Msg: Menambah Setting Cuti Umum ' . ' Script: ' . $this->db->last_query());
		}else{
			$data['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', TRUE));
			$this->load->view('setting/v_popup_cuti_umum', $data);
		}
	}

	public function cuti_hapus()
	{
		$this->load->model('mcuti', 'cuti');
		$cuti_id = $this->input->post('cuti_id');
		$this->cuti->do_hapus($cuti_id);
		$this->todolog->write_log('Time: ' . standard_date('DATE_RFC822', time()) . ' Address: ' . $_SERVER["REMOTE_ADDR"] . ' User: ' . $this->session->userdata('userid') . ' Msg: Menghapuskan Setting Cuti Umum ' . ' Script: ' . $this->db->last_query());
	}

	public function pentadbir_bahagian()
	{
		$this->load->model('muserinfo','userinfo');

		$data['senPentadbirBahagian'] = $this->userinfo->getPentadbirBahagian();
		$tpl['main_content'] = $this->load->view('setting/v_pentadbir_bahagian', $data, TRUE);
		$this->load->view('tpl/v_main', $tpl);
	}

	public function pegawai_penilai()
	{
		$this->load->model('muserinfo','userinfo');

		$data['senPegawaiPenilai'] = $this->userinfo->getAllPPP();
		$tpl['main_content'] = $this->load->view('setting/v_pegawai_penilai', $data, TRUE);
		$this->load->view('tpl/v_main', $tpl);
	}

	public function system_variable()
	{
		$this->load->model('msys','sys');
		$data['params'] = $this->sys->get_all();
		$tpl['main_content'] = $this->load->view('setting/v_sys_var', $data, TRUE);
		$this->load->view('tpl/v_main', $tpl);
	}

	public function sys_var($kod)
	{
		if($this->input->post('txt_kod'))
		{
			$this->load->model('msys','sys');

			$fields["param_kod"] = $this->input->post('txt_kod');
			$fields["param_value"] = $this->input->post('txt_value');
			$this->sys->update($fields);
		}
		else
		{
			$this->load->model('msys','sys');
			$data['params'] = $this->sys->get_info($kod);
			$data['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', TRUE));
			$this->load->view('setting/v_popup_sys_var', $data);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
