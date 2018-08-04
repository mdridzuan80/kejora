<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function event_info()
    {
        $event = array();

        if($this->input->post('jenis') == 1 || $this->input->post('jenis') == 2 || $this->input->post('jenis') == 3)
        {
            $this->load->model('mjustifikasi');
            $justifikasi = $this->mjustifikasi->justifikasi($this->input->post('id'));
            $justifikasi = $justifikasi->row();

            $event['kategori'] = ($this->config->item('pcrs_jenis_justifikasi')[$this->input->post('jenis')]);
            $event['mula'] = $justifikasi->j_mula;
            $event['tamat'] = $justifikasi->j_tamat;
            $event['keterangan'] = $justifikasi->j_alasan;
        }

        if($this->input->post('jenis') == 'CUTIUMUM')
        {
            $this->load->model('mcuti');
            $cuti = $this->mcuti->infoCuti($this->input->post('id'));
            $cuti = $cuti->row();

            $event['kategori'] = 'CUTI UMUM';
            $event['mula'] = $cuti->cuti_mula;
            $event['tamat'] = $cuti->cuti_mula;
            $event['keterangan'] = $cuti->cuti_perihal;
        }

        if ($this->input->post('jenis') == 'LEWAT')
        {
            $this->load->model('muserlewat');

            $lewat = $this->muserlewat->infoLewat($this->input->post('id'));
            $lewat = $lewat->row();
            $event['checkin'] = $lewat->CHECKTIME;
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($event));
    }
}