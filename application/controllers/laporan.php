<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan extends MY_Controller
{

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
        $tpl['main_content'] = $this->load->view('dashboard/v_default', '', true);
        $this->load->view('tpl/v_main', $tpl);
    }

    public function harian()
    {
        $this->load->model('mdepartment', 'department');
        $data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array
            ('DEPTID', 'DEPTNAME'), true);

        $tpl['js_plugin'] = array('timepicker');
        $tpl['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', true));
        $tpl['main_content'] = $this->load->view('laporan/v_laporan_harian', $data, true);
        $this->load->view('tpl/v_main', $tpl);
    }

    public function jana_harian($cetak=false)
    {
      // post data
      $deptid = $this->input->post('deptid', true);
      $staffid = $this->input->post('staffid', true);
      $mula = $this->input->post('mula', true);
      $akhir = $this->input->post('akhir', true);

      $this->load->model('mlaporan', 'laporan');
      $this->load->model('mcuti', 'cuti');
      $this->load->model('mdepartment', 'department');

  		if($cetak)
  		{
  			$data['cuti'] = $this->cuti->check_cuti_by_range_day($mula, $akhir);
  			$data["laporan"] = $this->laporan->rpt_kehadiran_harian($deptid, $staffid, $mula, $akhir);
        $data["bahagian"] = $this->department->get_department_name($dept_id);
  			$html = $this->load->view('laporan/v_jana_laporan_harian_cetak', $data, true);
  			$pdf_param = array('orientation' => 'P');
          	pcrs_render_pdf_download($pdf_param, $html);
  		}
  		else
  		{
  			$data['cuti'] = $this->cuti->check_cuti_by_range_day($mula, $akhir);
  			$data["laporan"] = $this->laporan->rpt_kehadiran_harian($deptid, $staffid, $mula, $akhir, $data['cuti']);
  			$this->load->view('laporan/v_jana_laporan_harian', $data);
  		}
    }

    public function bulanan()
    {
        $this->load->model('mdepartment', 'department');
        $data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array
            ('DEPTID', 'DEPTNAME'), true);

        $tpl['js_plugin'] = array('timepicker');
        $tpl['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', true));
        $tpl['main_content'] = $this->load->view('laporan/v_bulanan', $data, true);
        $this->load->view('tpl/v_main', $tpl);
    }

    public function jana_bulanan()
    {
        $this->load->library('myhtml2pdf');
        $bulan = $this->input->post("txtBulan");
        $tahun = $this->input->post("txtTahun");
        $bahagian = $this->input->post("cmdRptBahagian");
        $anggotas = $this->input->post("comRptKakitangan");

        $this->load->model('mlaporan', 'laporan');
        $this->load->model('muserinfo', 'userinfo');
        $this->load->model('mcuti', 'cuti');
		// tambah 31/3
		 $this->load->model('mjustifikasi', 'justifikasi');

        $html = '';
        $data['cuti'] = $this->cuti->get_by_bulan_tahun($bulan, $tahun);
        foreach ($anggotas as $anggota) {
            if(!$this->input->post("chkArkib"))
            {
                $data['info'] = $this->userinfo->getUserInfo($anggota);
            }
            else
            {
                $data['info'] = $this->userinfo->getUserInfoArkib($anggota);
            }
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
            $data['shift'] = $this->userinfo->getWBB(array(
                'USERID' => $anggota,
                'MONTH' => $bulan,
                'YEAR' => $tahun));
            $data['staff'] = $this->laporan->rpt_kehadiran($anggota, $bulan, $tahun);
            $html .= $this->load->view('laporan/v_tpl_rptbulanan', $data, true);
        }
        $pdf_param = array('orientation' => 'P');
        pcrs_render_pdf_download($pdf_param, $html);
    }

    public function arkib_bulanan()
    {
        $this->load->model('mdepartment', 'department');
        $data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array
            ('DEPTID', 'DEPTNAME'), true);

        $tpl['js_plugin'] = array('timepicker');
        $tpl['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', true));
        $tpl['main_content'] = $this->load->view('laporan/v_arkib_bulanan', $data, true);
        $this->load->view('tpl/v_main', $tpl);
    }

    public function jana_arkib_bulanan()
    {
        $this->load->library('myhtml2pdf');
        $bulan = $this->input->post("txtBulan");
        $tahun = $this->input->post("txtTahun");
        $bahagian = $this->input->post("cmdRptBahagian");
        $anggotas = $this->input->post("comRptKakitangan");

        $this->load->model('mlaporan', 'laporan');
        $this->load->model('muserinfo', 'userinfo');
        $this->load->model('mcuti', 'cuti');

        $html = '';
        $data['cuti'] = $this->cuti->get_by_bulan_tahun($bulan, $tahun);
        foreach ($anggotas as $anggota) {
            $data['info'] = $this->userinfo->getUserInfoArkib($anggota);
            $data['bulan'] = $bulan;
            $data['shift'] = $this->userinfo->getWBB(array(
                'USERID' => $anggota,
                'MONTH' => $bulan,
                'YEAR' => $tahun));
            $data['staff'] = $this->laporan->rpt_kehadiran($anggota, $bulan, $tahun);
            $html .= $this->load->view('laporan/v_tpl_arkib_rptbulanan', $data, true);
			//echo $html;
			//die();
        }

        $pdf_param = array('orientation' => 'P');
        pcrs_render_pdf_download($pdf_param, $html);
    }

    public function chart_hari()
    {
        $this->load->model('mlaporan');
        $tkh_mula = strtotime(date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d')))));
        $tkh_akhir = strtotime(date('Y-m-d'));
        $json = array();
        $i = 0;

        while ($tkh_mula <= $tkh_akhir) {
            $rst = $this->mlaporan->get_data_statistik_harian(date('Y-m-d', $tkh_mula));
            if ($rst->num_rows() != 0) {
                $stat = $rst->row();
                $json[$i]['tarikh'] = str_replace('.', '-', $stat->CHECKTIME);
                $json[$i]['jumlah'] = $stat->jumlah;
            } else {
                $json[$i]['tarikh'] = date('Y-m-d', $tkh_mula);
                $json[$i]['jumlah'] = 0;
            }
            $tkh_mula = strtotime('+1 day', $tkh_mula);
            $i++;
        }

        $data['json'] = $json;
        $this->load->view('laporan/v_data_json', $data);
    }

    public function tunjuk_sebab()
    {
        if ($this->input->post('txtBulan')) {
            $this->load->model('mlaporan');
            echo "Run!";
        } else {
            $this->load->model('mdepartment', 'department');
            $data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array
                ('DEPTID', 'DEPTNAME'), true);

            $tpl['js_plugin'] = array('timepicker');
            $tpl['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', true));
            $tpl['main_content'] = $this->load->view('laporan/v_jana_surat_tunjuk_sebab', $data, true);
            $this->load->view('tpl/v_main', $tpl);
        }
    }

    public function statistik()
    {
        $tpl['main_content'] = $this->load->view('laporan/v_statistik', '', true);
        $this->load->view('tpl/v_main', $tpl);
    }

	public function stat_01()
  {
    if ($this->input->post('txtBulan'))
		{
			$this->load->model('mlaporan');
			$data['bulan'] = $this->input->post('txtBulan');
			$data['tahun'] = $this->input->post('txtTahun');
      $data['dept'] = $this->input->post('deptid');
			$data['top_ten'] = $this->mlaporan->get_top_ten($this->input->post('txtBulan'), $this->input->post('txtTahun'), $this->input->post('deptid'));
			$html = $this->load->view('laporan/statistik/v_tpl_sen_stat_01', $data, true);
			//echo $rpt;
			$pdf_param = array('orientation' => 'P');
        	pcrs_render_pdf_download($pdf_param, $html, 'laporan_statistik.pdf');
		}
		else
		{
			$this->load->model('mdepartment', 'department');
			$data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array
				('DEPTID', 'DEPTNAME'), true);

			$tpl['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', true));
			$tpl['main_content'] = $this->load->view('laporan/statistik/v_stat_01', $data, true);
			$this->load->view('tpl/v_main', $tpl);
		}
  }

  public function stat_02()
  {
    if ($this->input->post('txtBulan'))
		{
			$this->load->model('mlaporan');
			$data['bulan'] = $this->input->post('txtBulan');
			$data['tahun'] = $this->input->post('txtTahun');
      if($this->input->post('deptid'))
      {
        $data['dept'] = $this->input->post('deptid');
      }
      else
      {
        $data['dept'] = 1;
      }

			$data['stat_x_punch_inout'] = $this->mlaporan->stat_x_punch_inout($this->input->post('txtBulan'), $this->input->post('txtTahun'), $data['dept']);
			$html = $this->load->view('laporan/statistik/v_tpl_sen_stat_02', $data, true);
			//echo $rpt;
			$pdf_param = array('orientation' => 'P');
        	pcrs_render_pdf_download($pdf_param, $html, 'laporan_statistik.pdf');
		}
		else
		{
			$this->load->model('mdepartment', 'department');
			$data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array
				('DEPTID', 'DEPTNAME'), true);

			$tpl['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', true));
			$tpl['main_content'] = $this->load->view('laporan/statistik/v_stat_02', $data, true);
			$this->load->view('tpl/v_main', $tpl);
		}
  }

  public function stat_03()
  {
    if ($this->input->post('txtBulan'))
    {
      $this->load->model('mlaporan');
      $data['bulan'] = $this->input->post('txtBulan');
      $data['tahun'] = $this->input->post('txtTahun');
      if($this->input->post('deptid'))
      {
        $data['dept'] = $this->input->post('deptid');
      }
      else
      {
        $data['dept'] = 1;
      }
      $data['sen_kod_warna'] = $this->mlaporan->sen_kod_warna($this->input->post('txtBulan'), $this->input->post('txtTahun'), $this->input->post('deptid'));
      $html = $this->load->view('laporan/v_tpl_sen_kod_warna', $data, true);
      $pdf_param = array('orientation' => 'P');
      pcrs_render_pdf_download($pdf_param, $html, 'laporan_kod_warna.pdf');
    }
    else
    {
      $this->load->model('mdepartment', 'department');
      $data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array
        ('DEPTID', 'DEPTNAME'), true);

      $tpl['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', true));
      $tpl['main_content'] = $this->load->view('laporan/v_kod_warna', $data, true);
      $this->load->view('tpl/v_main', $tpl);
    }
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
