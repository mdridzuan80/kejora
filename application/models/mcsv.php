<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MCsv extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function getDataCSV($path)
	{
		$record = array();
		$file = fopen($path, 'r');
		while(! feof($file))
		{
			$record[]=fgetcsv($file);
		}
		return $record;
	}
}
?>
