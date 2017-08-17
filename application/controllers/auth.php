<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

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

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
	}

	public function index(){

	}

	public function login()
	{
		if($this->session->userdata('logged'))
		{
			redirect('', 'refresh');
		}
		else
		{
			if(isset($_POST['btnLogin']))
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('txtUsername', 'ID pengguna', 'required');
				$this->form_validation->set_rules('txtPassword', 'Katalaluan pengguna', 'required');
				$this->form_validation->set_rules('comDomain', 'Domain', 'required');
				if (!$this->form_validation->run())
				{
					$tpl['head_title']='PCRS Attendance System Administration';
					$tpl['error'] = '<b>RALAT!</b> Sila penuhkan tempat yang berwarna merah';
					$this->load->view('v_login',$tpl);
				}
				else
				{
					$this->load->model('musers','users');
					$this->load->model('mpelulus','pelulus');

					$username = $this->input->post('txtUsername');
					$password = $this->input->post('txtPassword');

					$domain = $this->input->post('comDomain',TRUE);
					if($domain == 'internal')
					{
						$this->load->model('muserinfo','userinfo');
						if($this->users->checkUser($username,$password,$domain,'A'))
						{
							$this->session->set_userdata('userid', $username);
							$this->session->set_userdata('logged', TRUE);

							if($username != 'administrator')
							{
								$ad_user_rec = $this->users->getUserAD($username, $domain, 'A');
								$ad_user = $ad_user_rec->row();
								$department = $this->userinfo->getDefaultDepartment($ad_user->userid);
								$nokp = $this->userinfo->getNoKP($ad_user->userid);

								$this->load->model('mdepartment');
								$parent_department = $this->mdepartment->get_parent_dept($department);
								$rst = $this->mdepartment->recursive();
								$arrs = array();
								foreach($rst->result_array() as $row)
								{
									$arrs[] = $row;
								}

								$browse_department = pcrs_flatten(pcrs_get_recursive_department($arrs, $department));
								$browse_department[] = $parent_department;
								$browse_department[] = $department;

								$this->session->set_userdata('uid', $ad_user->userid);
								$this->session->set_userdata('dept', $department);
								$this->session->set_userdata('browse_dept', $browse_department);
								$this->session->set_userdata('role', $ad_user->roleid);
								$this->session->set_userdata('pelulus', $this->pelulus->chkPriv($ad_user->userid));
								$this->session->set_userdata('ppp', $this->userinfo->statusPPP($nokp));
								$this->session->set_userdata('nokp', $nokp);
								$this->session->set_userdata('parent', $parent_department);

							}
							else
							{
								$this->session->set_userdata('uid', 557);
								$this->session->set_userdata('dept', 0);
								$this->session->set_userdata('role', 1);
							}

							$this->todolog->write_log('Time: ' . standard_date('DATE_RFC822', time()) . ' Address: ' . $_SERVER["REMOTE_ADDR"] . ' User: ' . $username . ' Msg: Successfully log-in');
							redirect('', 'refresh');
						}
						else
						{
							$tpl['head_title']='eMOHR Attendance System Administration';
							$tpl['error'] = '<b>RALAT!</b> - Kombinasi ID Pengguna dan Katalaluan tidak tepat. Sila cuba sekali lagi.';
							$this->load->view('v_login', $tpl);
						}
					}
					else
					{
						$this->load->model('muserinfo','userinfo');
						if($this->users->checkUserAD($username,$domain,'A'))
						{
							if($this->myadldap->ad_user_authenticate($username, $password))
							{
								$this->session->set_userdata('userid', $username);
								$this->session->set_userdata('logged', TRUE);
								$ad_user_rec = $this->users->getUserAD($username, $domain, 'A');
								$ad_user = $ad_user_rec->row();
								$department = $this->userinfo->getDefaultDepartment($ad_user->userid);
								$nokp = $this->userinfo->getNoKP($ad_user->userid);

								$this->load->model('mdepartment');
								$parent_department = $this->mdepartment->get_parent_dept($department);

								$rst = $this->mdepartment->recursive();
								$arrs = array();
								foreach($rst->result_array() as $row)
								{
									$arrs[] = $row;
								}

								$browse_department = pcrs_flatten(pcrs_get_recursive_department($arrs, $department));
								$browse_department[] = $this->mdepartment->get_parent_dept($parent_department);
								$browse_department[] = $parent_department;
								$browse_department[] = $department;

								$this->session->set_userdata('uid', $ad_user->userid);
								$this->session->set_userdata('dept', $department);
								$this->session->set_userdata('browse_dept', $browse_department);
								$this->session->set_userdata('role', $ad_user->roleid);
								$this->session->set_userdata('pelulus', $this->pelulus->chkPriv($ad_user->userid));
								$this->session->set_userdata('ppp', $this->userinfo->statusPPP($nokp));
								$this->session->set_userdata('nokp', $nokp);
								$this->session->set_userdata('parent', $parent_department);

								$this->todolog->write_log('Time: ' . standard_date('DATE_RFC822', time()) . ' Address: ' . $_SERVER["REMOTE_ADDR"] . ' User: ' . $username . ' Msg: Successfully log-in');
								redirect(base_url(), 'location');
							}
							else
							{
								$tpl['head_title']='PCRS Attendance System Administration';
								$tpl['error'] = '<b>RALAT!</b>Kombinasi ID Pengguna dan Katalaluan tidak tepat. Sila cuba sekali lagi.';
								$this->load->view('v_login',$tpl);
							}
						}
						else
						{
							$tpl['head_title']='PCRS Attendance System Administration';
							$tpl['error'] = '<b>RALAT!</b> Kombinasi ID Pengguna dan Katalaluan tidak dapat dikenal pasti. Sila cuba sekali lagi.';
							$this->load->view('v_login',$tpl);
						}
					}
				}
			}
			else
			{
				$tpl['head_title']='eMOHR Attendance System Administration';
				$this->load->view('v_login',$tpl);
			}
		}
	}

	public function logout()
	{
		$tmp_username = $this->session->userdata('userid');
		$this->session->sess_destroy();
		$this->todolog->write_log('Time: ' . standard_date('DATE_RFC822', time()) . ' Address: ' . $_SERVER["REMOTE_ADDR"] . ' User: ' . $tmp_username . ' Msg: Successfully log-out');
		redirect('', 'refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
