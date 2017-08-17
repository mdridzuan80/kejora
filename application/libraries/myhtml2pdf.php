<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('html2pdf/Html2pdf.php');
class Myhtml2pdf extends HTML2PDF {

    public function __construct($param = array())
	{
		if(isset($param['orientation']))
			$orientation = $param['orientation'];
		else
			$orientation = 'P';
			
		if(isset($param['format']))
			$format = $param['format'];
		else
			$format = 'A4';
			
		if(isset($param['langue']))
			$langue = $param['langue'];
		else
			$langue = 'fr';
			
		if(isset($param['unicode']))
			$unicode = $param['unicode'];
		else
			$unicode = TRUE;
			
		if(isset($param['encoding']))
			$encoding = $param['encoding'];
		else
			$encoding = 'UTF-8';
		
		if(isset($param['marges']))
			$marges = $param['marges'];
		else
			$marges = array(5, 5, 5, 8);
			
		parent::__construct($orientation, $format, $langue, $unicode , $encoding, $marges);
	}
}