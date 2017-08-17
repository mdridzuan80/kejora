<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MKtgAway extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function getAll()
	{
		$query = $this->db->get('att_away_kategori');
		return $query;	
	}
}

?>
