<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Pengaturcara: Md Ridzuan bin Mohammad Latiah
	create: 18-Ogos-2011
	
*/
class Import extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{	
		$tpl['main_content'] = $this->load->view('dashboard/v_home', '', TRUE);
		$this->load->view('tpl/v_main', $tpl);
	}

	public function csv()
	{	
		if(!isset($_POST['mysubmit']))
		{
			$this->load->model('mdepartment','department');
			$data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array('DEPTID','DEPTNAME'),TRUE);
			$tpl['main_content'] = $this->load->view('import/v_import', $data, TRUE);
			$this->load->view('tpl/v_main', $tpl);
		}
		else
		{
			$config['upload_path'] = 'assets/csv/';
			$config['allowed_types'] = 'csv';
			$config['max_size']	= '0';
			$config['remove_spaces'] = TRUE;
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload())
			{	
				$this->load->model('mdepartment','department');
			
				$data['head_title']='Sistem Maklumat Kehadiran Bersepadu';		
				$data['page']='authenticated/import/v_csv';
				$data['menu']='';
				//$data['users']=$this->users->getUsers();
				$data['departments'] = $this->_rst_to_option($this->department->getUnits(1), array('DEPTID','DEPTNAME'),TRUE);
				$data['error'] = array('error' => $this->upload->display_errors());
				$data['data']='';
				$this->load->view('authenticated/template', $data);
			}
			else
			{
				$this->load->model('mdepartment','department');
				$this->load->model('mcsv','csv');
				$this->load->model('muserinfo','userinfo');
			
				$data['head_title']='Sistem Maklumat Kehadiran Bersepadu';		
				$data['page']='authenticated/import/v_csv';
				$data['menu']='';
				//$data['users']=$this->users->getUsers();
				$data['departments'] = $this->_rst_to_option($this->department->getUnits(1), array('DEPTID','DEPTNAME'),TRUE);
				$data['data'] = array('upload_data' => $this->upload->data());
				$data['error'] = '';
				$csv_data=$this->csv->getDataCSV($data['data']['upload_data']['full_path']);
				
				foreach($csv_data as $data_user)
				{
					$field['Badgenumber'] = $data_user[0];
					$field['Name'] = iconv('','UTF-8',$data_user[1]);
					$field['TITLE'] = $data_user[2];
					$field['street'] = iconv('','UTF-8',$data_user[3]);
					$field['SSN'] = str_replace(array(" ","-"), "", $data_user[4]);
					$field['PAGER'] = str_replace(array(" ","-"), "", $data_user[5]);
					$field['OPHONE'] = str_replace(array(" ","-"), "", $data_user[8]);
					
					$this->userinfo->update($field);
					
					
					
					
					
					$wbb['USERID']=$this->userinfo->getUserID($field['Badgenumber']);
					
					if($data_user[6])
					{
						$dict_wbb['WB1'][4] = array(5,"2014-04-01","2014-04-30");
						$dict_wbb['WB2'][4] = array(6,"2014-04-01","2014-04-30");
						$dict_wbb['WB3'][4] = array(7,"2014-04-01","2014-04-30");
						
						$dict_wbb['WP1'][4] = array(5,"2014-04-01","2014-04-30");
						$dict_wbb['WP2'][4] = array(6,"2014-04-01","2014-04-30");
						$dict_wbb['WP3'][4] = array(7,"2014-04-01","2014-04-30");
					
						$data1["USERID"]=$wbb['USERID'];
						$data1["NUM_OF_RUN_ID"]=$dict_wbb[strtoupper(str_replace(array(" "), "", $data_user[6]))][4][0];
						$data1["STARTDATE"]=$dict_wbb[strtoupper(str_replace(array(" "), "", $data_user[6]))][4][1];
						$data1["ENDDATE"]=$dict_wbb[strtoupper(str_replace(array(" "), "", $data_user[6]))][4][2];
						if($this->userinfo->checkWBB($data1)==0)
						{
							$this->userinfo->insertWBB($data1);
						}
					}
					
					if($data_user[7])
					{
						$dict_wbb['WB1'][5] = array(5,"2014-05-01","2014-05-31");
						$dict_wbb['WB2'][5] = array(6,"2014-05-01","2014-05-31");
						$dict_wbb['WB3'][5] = array(7,"2014-05-01","2014-05-31");
						
						$dict_wbb['WP1'][5] = array(5,"2014-05-01","2014-05-31");
						$dict_wbb['WP2'][5] = array(6,"2014-05-01","2014-05-31");
						$dict_wbb['WP3'][5] = array(7,"2014-05-01","2014-05-31");
						
						$data2["USERID"]=$wbb['USERID'];
						$data2["NUM_OF_RUN_ID"]=$dict_wbb[strtoupper(str_replace(array(" "), "", $data_user[7]))][5][0];
						$data2["STARTDATE"]=$dict_wbb[strtoupper(str_replace(array(" "), "", $data_user[7]))][5][1];
						$data2["ENDDATE"]=$dict_wbb[strtoupper(str_replace(array(" "), "", $data_user[7]))][5][2];
						if($this->userinfo->checkWBB($data2)==0)
						{
							$this->userinfo->insertWBB($data2);
						}
					}
				}
				
				$this->load->view('authenticated/template', $data);
			}
		}
	}
}