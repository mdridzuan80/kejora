<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Custom library for logging user activity
Author : Md Ridzuan bin Mohammad Latiah
Created : 20-August-2011
*/
class Todolog
{
	private $_todo_log_path;
	private $_todo_log_date_format = 'Y-m-d H:i:s';
	private $_todo_log_ext = '.log';
	private $_enabled = TRUE;

	public function __construct()
	{
		$config =& get_config();
		
		$this->_todo_log_path = ($config['todo_log_path'] != '') ? $config['todo_log_path'] : APPPATH.'logs/';

		if ( ! is_dir($this->_todo_log_path) OR ! is_really_writable($this->_todo_log_path))
		{
			$this->_enabled = FALSE;
		}

		if ($config['todo_log_date_format'] != '')
		{
			$this->_todo_log_date_format = $config['todo_log_date_format'];
		}
		
		if ($config['todo_log_ext'] != '')
		{
			$this->_todo_log_ext = $config['todo_log_ext'];
		}
		
	}

	public function write_log($msg)
	{
		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}

		$filepath = $this->_todo_log_path . 'todo-log-' . date('Y-m-d') . $this->_todo_log_ext;
		$message  = '';
		
		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
		{
			return FALSE;
		}
		
		$message .= date($this->_todo_log_date_format). ' --> '.$msg."\n";

		flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);

		@chmod($filepath, FILE_WRITE_MODE);
		return TRUE;
	}
}
// END Todolog Class

/* End of file Todolog.php */
/* Location: ./application/libraries/todolog.php */
?>