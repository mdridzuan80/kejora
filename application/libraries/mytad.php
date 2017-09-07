<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Custom Library for TAD-PHP
https://github.com/cobisja/tad-php
Author : Md Ridzuan bin Mohammad Latiah
Created : 20-August-2011
*/

require 'tad/lib/TADFactory.php';
require 'tad/lib/TAD.php';
require 'tad/lib/TADResponse.php';
require 'tad/lib/Providers/TADSoap.php';
require 'tad/lib/Providers/TADZKLib.php';
require 'tad/lib/Exceptions/ConnectionError.php';
require 'tad/lib/Exceptions/FilterArgumentError.php';
require 'tad/lib/Exceptions/UnrecognizedArgument.php';
require 'tad/lib/Exceptions/UnrecognizedCommand.php';

use TADPHP\TADFactory;
use TADPHP\TAD;

class Mytad
{
	public function get_attendance_log($ip, $pin=false, $start=false, $end=false)
	{
		try{
			$tad_factory = new TADFactory(array('ip'=>$ip));
			$tad = $tad_factory->get_instance();

			if($pin)
			{
				$att_logs = $tad->get_att_log(array('pin'=>$pin));
			}
			else
			{
				$att_logs = $tad->get_att_log();
			}

			if( !$att_logs->is_empty_response() )
		  {
				if($start && $end)
				{
					$att_logs->filter_by_date(array('start' => $start, 'end' => $end));
				}
				else
				{
					if($start)
						$att_logs->filter_by_date(array('start' => $start,'end' => $start));
				}

				$array_att_logs = $att_logs->to_array();

				return $array_att_logs;
			}
			else
			{
				return "Message: No Record from $ip" ;
			}
		}
		//catch exception
		catch(Exception $e) {
		  return 'Message: ' . $e->getMessage();
		}
	}
}
?>
