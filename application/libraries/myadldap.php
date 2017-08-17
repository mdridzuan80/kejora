<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Custom Library for adldap
Author : Md Ridzuan bin Mohammad Latiah
Created : 20-August-2011
*/
include_once("adLDAP/adLDAP.php");

class Myadldap
{
	private $_ad_accountSuffix;
	private $_ad_baseDN;
	private $_ad_host;
	private $_ad_adminUsername;
	private $_ad_adminPassword;
	private $_ad_cn;
	
	public function __construct()
	{
		$config =& get_config();
		
		$this->_ad_accountSuffix = $config['ad_accountSuffix'];
		$this->_ad_baseDN = $config['ad_baseDN'];
		$this->_ad_host = $config['ad_host'];
		$this->_ad_adminUsername = $config['ad_adminUsername'];
		$this->_ad_adminPassword = $config['ad_adminPassword'];		
	}
	
	public function ad_user_authenticate($username,$password)
	{
		try {
			$this->_ad_cn = new adLDAP(array('account_suffix'=>$this->_ad_accountSuffix,
										'base_dn'=>$this->_ad_baseDN,
										'domain_controllers'=>$this->_ad_host,
										'admin_username'=>$username,
										'admin_password'=>$password));
			//connect to ldap
			$this->_ad_cn->connect();
			$this->_ad_cn->close();
			return true;
			/* if($this->_ad_cn->authenticate($username,$password))
			{
				return TRUE;
			} */
				
			//close connection to ldap
		}
		catch (adLDAPException $e) {
			return false;  
		}	
	}
	
	public function ad_user_filter($user)
	{
		try {
			$this->_ad_cn = new adLDAP(array('account_suffix'=>$this->_ad_accountSuffix,
										'base_dn'=>$this->_ad_baseDN,
										'domain_controllers'=>$this->_ad_host,
										'admin_username'=>$this->_ad_adminUsername,
										'admin_password'=>$this->_ad_adminPassword));
			//connect to ldap
			$this->_ad_cn->connect();
			if($user)
			{
				$key = 	'*' . $user . '*';
			}
			else
			{
				$key = 	'*';
			}
			return $this->_ad_cn->user()->all_users(false,$key,true);
				
			//close connection to ldap
			$this->_ad_cn->close();
		}
		catch (adLDAPException $e) {
			echo $e;
			exit();   
		}	
	}
}
// END Todolog Class

/* End of file Todolog.php */
/* Location: ./application/libraries/todolog.php */
?>