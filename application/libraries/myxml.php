<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Custom Library for xmltoarray and reverse
Author : Md Ridzuan bin Mohammad Latiah
Created : 01-06-2015
*/

class Myxml
{
	public function __construct(){
		require_once("xmltoarray/xmltoarray.php");
	}
	
	public function to_array($xml_str)
	{
		$array = XML2Array::createArray($xml_str);
		return $array;
	}
}