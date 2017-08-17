<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webservices extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	private $server;
	 
	public function __construct()
	{
		
		parent::__construct();
		/*if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != 'username' || $_SERVER['PHP_AUTH_PW'] != 'password') {
		  header('WWW-Authenticate: Basic realm="PCRS WEBSERVICES"');
		  header('HTTP/1.0 401 Unauthorized');
		  die('Access Denied');
		}*/
		
		$this->load->library('mynusoap');
		$namespace = base_url().'webservices/';
		$this->server = new soap_server(); 
		$this->server->configureWSDL("PCRS_WEBSERVICES");
		$this->server->wsdl->schemaTargetNamespace = $namespace;
		
		//register a function that works on server 
		$this->server->register("price", //name of function
							array("name"=>"xsd:string"), //input
							array("return"=>"xsd:integer") //output
						);
				
		//$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
		// create HTTP listener 
		//$this->server->service($HTTP_RAW_POST_DATA); 
	}
	
	public function index()
	{
		function price($name) 
		{ 
			$details = array("abc"=>100,"xyz"=>200);
			foreach($details as $n=>$p)
			{
				if($name == $n)
					$price = $p;
			}
			
			return $price;
		} 
		$this->server->service(file_get_contents("php://input")); // read raw data from request body
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */