<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MCheckinout extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function simpan($data)
  {
    $this->db->insert('dbo.CHECKINOUT', $data);
  }

  public function check_exists($data)
  {
    $sql = "select * from dbo.checkinout
      where 1=1
      AND USERID = " . $data["USERID"] . "
      AND convert(varchar, CHECKTIME, 120) = '" . $data['CHECKTIME'] . "'";
    $rst = $this->db->query($sql);
    return $rst->num_rows();
  }
}
?>
