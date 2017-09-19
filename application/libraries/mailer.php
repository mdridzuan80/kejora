<?php
require_once("phpmailer/PHPMailerAutoload.php");

class Mailer extends PHPMailer
{
    public function __construct()
    {
        parent::__construct();
        $CI =& get_instance();
        $CI->config->load('email');

		$this->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$this->SMTPDebug = $CI->config->item("smtp_debug_level");
		//Ask for HTML-friendly debug output
		$this->Debugoutput = 'html';
		//Set the hostname of the mail server
		$this->Host = $CI->config->item('smtp_host');
		//Set the SMTP port number - likely to be 25, 465 or 587
		$this->Port = $CI->config->item('smtp_port');
		//Whether to use SMTP authentication
		$this->SMTPAuth = $CI->config->item("smtp_require_auth");
		//Username to use for SMTP authentication
		$this->Username = $CI->config->item('smtp_user');
		//Password to use for SMTP authentication
		$this->Password = $CI->config->item('smtp_pass');
        //$CI->mailer->clear(TRUE);
        $this->setFrom($CI->config->item('pcrs_email_from'), $CI->config->item('pcrs_email_name'));
        $this->isHTML(true);

    }


}
