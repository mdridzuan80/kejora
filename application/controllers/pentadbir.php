<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pentadbir extends MY_Controller {

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
	
	public function pengguna()
	{
		$this->load->model('musers');
		$data['pengguna'] = $this->musers->getUsers();
		$tpl['main_content'] = $this->load->view('pentadbir/v_pengguna', $data, TRUE);
		$tpl['js_plugin'] = array('table', 'popup');
		$tpl['js_plugin_xtra'] = array($this->load->view('kakitangan/v_js_plugin_xtra', '', TRUE), $this->load->view('extrajs/v_js_pentadbir', '', TRUE));
		$this->load->view('tpl/v_main', $tpl);
	}
	
	public function pengguna_cipta()
	{
		$this->load->model('musers','users');
		$this->load->model('mdepartment','department');
		$this->load->model('mrole','role');
		$data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array('DEPTID','DEPTNAME'),TRUE);
		$data['role'] = pcrs_rst_to_option($this->role->getAll(), array('role_id','role_name'),TRUE);
		$data['users']=$this->users->getUsers();
		$data['js_plugin_xtra'] = array($this->load->view('extrajs/v_js_pentadbir', '', TRUE));
		$this->load->view('pentadbir/v_popup_create_user', $data);
	}

	public function cipta()
	{
		$this->load->model('musers','users');
		$this->load->model('mdepartment','department');
		$this->load->model('mrole','role');
		$data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array('DEPTID','DEPTNAME'),TRUE);
		$data['role'] = pcrs_rst_to_option($this->role->getAll(), array('role_id','role_name'),TRUE);
		$data['users']=$this->users->getUsers();
		$data['js_plugin_xtra'] = array($this->load->view('extrajs/v_js_pentadbir', '', TRUE));
		$this->load->view('pentadbir/v_popup_create_user', $data);
	}
	
	public function do_tambah_pengguna_internal()
	{
		$field['username'] = $this->input->post('txtAddUserInternal');
		$field['password'] = $this->input->post('txtAddUserInternalPassword');
		$field['domain'] = 'internal';
		$field['status'] = 'A';
		$field['userid'] = $this->input->post('comRptKakitangan');
		$field['roleid'] = $this->input->post('comPeranan');
		
		// load model
		$this->load->model('musers','users');
		$this->users->addUser($field);
	}
	
	public function do_tambah_pengguna_domain()
	{
		//print_r($_POST);
		$ad_user = $this->input->post('chkAdUser');
		list($username,$domain) = explode('@',$ad_user[0]);
		$field['username'] = $username;
		$field['domain'] = $domain;
		$field['status'] = 'A';
		$field['userid'] = $this->input->post('comRptKakitanganDomain');
		$field['roleid'] = $this->input->post('comPeranan');
		
		// load model
		$this->load->model('musers','users');
		$this->users->addUser($field);

	}
	
	public function do_ad_user()
	{
		$key = $this->input->post('key');
		$data['user_ad'] = $this->myadldap->ad_user_filter($key);
		$this->load->view('authenticated/dict/ajax_user_ad',$data);	
	}
	
	public function chk_ad_user()
	{
		$key = $this->input->post('key');
		$data['user_ad'] = $this->myadldap->ad_user_filter($key);
		$this->load->view('pentadbir/v_pengguna_ad',$data);	
	}
	
	public function pengguna_hapus()
	{
		$this->load->model('musers','users');
		$user_id = $this->input->post('user_id');
		$this->users->do_delete($user_id);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */