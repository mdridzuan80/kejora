<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class MY_Controller extends CI_Controller
	{
		const HTTP_ERROR_CONFLICT = 409;
		
		public function __construct()
		{
			parent::__construct();
			$this->load->library('session');

			if(!$this->session->userdata('logged'))
				redirect('auth/login');
		}
	}
?>
