<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MHrmis extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function get_cuti_file($bu, $tarikh_semasa)
	{
		$this->load->library('myxml');

		$wsdl = "https://perkongsiandata.eghrmis.gov.my/wsintegrasi/dataservice.asmx?WSDL";

		// Or 'soap_version' => SOAP_1_1 if your using SOAP 1.1
		$options = array(
			'uri' => "https://perkongsiandata.eghrmis.gov.my/wsintegrasi/dataservice.asmx",
			'soap_version' => SOAP_1_2,
			'trace' => 1);

		$client = new SoapClient($wsdl, $options);

		$this->_AddWSSUsernameToken($client, $this->config->item('pcrs_hrmis_username'), $this->config->item('pcrs_hrmis_password'));

		try
		{
				$param['tarikh'] = $tarikh_semasa;
				$param['buorgchart'] = $bu;
    		$result = $client->GetDataLeaveFileByDate($param);
				$array = $this->myxml->to_array(str_replace('>', '>',
												str_replace('<', '<',
													str_replace('&', '&',
														$client->__getLastResponse()))));
				return $array;
		}
		catch(Exception $e)
		{
			die($e);
		}
	}

	private function _AddWSSUsernameToken($client, $username, $password)
	{
		$wssNamespace = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";

		$username = new SoapVar($username,
								XSD_STRING,
								null, null,
								'Username',
								$wssNamespace);

		$password = new SoapVar($password,
								XSD_STRING,
								null, null,
								'Password',
								$wssNamespace);

		$usernameToken = new SoapVar(array($username, $password),
										SOAP_ENC_OBJECT,
										null, null, 'UsernameToken',
										$wssNamespace);

		$usernameToken = new SoapVar(array($usernameToken),
								SOAP_ENC_OBJECT,
								null, null, null,
								$wssNamespace);

		$wssUsernameTokenHeader = new SoapHeader($wssNamespace, 'Security', $usernameToken);

		$client->__setSoapHeaders($wssUsernameTokenHeader);
	}

	public function hrmis_cuti($fields)
	{
		if($this->db->insert('PCRS.att_hrmis', $fields))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function chk_cuti($user_id, $tarikh)
	{
		$sql = "SELECT * FROM pcrs.att_hrmis
				WHERE 1=1
				AND hr_userid = $user_id
				AND convert(varchar(10), hr_tkh_tamat, 120) >= '" . $tarikh . "'
				AND convert(varchar(10), hr_tkh_mula, 120) <= '" . $tarikh . "'";
		$query = $this->db->query($sql);
		return $query;
	}
}
