<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config = array(
				'profile' => array(
					array(
						'field' => 'txtNama',
						'label' => 'Nama',
						'rules' => 'required'
					),
					array(
						'field' => 'txtNoKP',
						'label' => 'No KP',
						'rules' => 'required'
					),
					array(
						'field' => 'txtJawatan',
						'label' => 'Jawatan',
						'rules' => 'required'
					),
					array(
						'field' => 'comBahagian',
						'label' => 'Bahagian',
						'rules' => 'required'
					),
					array(
						'field' => 'txtEmel',
						'label' => 'Emel',
						'rules' => 'required'
					),
					array(
						'field' => 'txtTelefon',
						'label' => 'Telefon',
						'rules' => 'required'
					)
				),
			'justifikasi'=>array(
					array(
						'field' => 'txtCatatan',
						'label' => 'Catatan',
						'rules' => 'required'
					)
				)
			);
