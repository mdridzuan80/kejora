<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notifikasi
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function sendSms($rcpt_to, $message)
	{
		$this->CI->config->load('sms');
		$url = $this->CI->config->item('sms_send_url');

		$param["username"] = $this->CI->config->item('sms_username');
		$param["password"] = sha1($this->CI->config->item('sms_password')); //sha1()
		$param["msgtype"] = $this->CI->config->item('sms_type');
		$param["message"] = $message;
		$param["to"] = $rcpt_to; // tel no
		$param["hashkey"] = sha1($param["username"] . $this->CI->config->item('sms_password') . $param["to"]); // sha1() username+password+to
		return $this->postToUrl($url, $param);
	}


	public function sendEmail($rcpt_to, $title, $message, $rcpt_cc = NULL, $rcpt_bcc = NULL, $attachment = NULL)
	{
		$this->CI->load->library('mailer');

		if(is_array($rcpt_to))
		{
			foreach($rcpt_to as $rcpt)
			{
				$this->CI->mailer->addAddress($rcpt);
			}
		}
		else
		{
			$this->CI->mailer->addAddress($rcpt_to);
		}

		if(is_array($rcpt_cc))
		{
			foreach($rcpt_cc as $rcpt)
			{
				$this->CI->mailer->addCC($rcpt);
			}
		}
		else
		{
			$this->CI->mailer->addCC($rcpt_cc);
		}

		if(is_array($rcpt_bcc))
		{
			foreach($rcpt_bcc as $rcpt)
			{
				$this->CI->mailer->addBCC($rcpt);
			}
		}
		else
		{
			$this->CI->mailer->addBCC($rcpt_bcc);
		}

		$this->CI->mailer->Subject = $title;
		$this->CI->mailer->msgHTML($message);

		if($attachment)
		{
			$this->CI->mailer->addAttachment($attachment);
		}

		if(!$this->CI->mailer->send()) {
			echo "Mailer Error: " . $this->CI->mailer->ErrorInfo;
		} else {
			echo "Message sent!";
		}
	}

    private function postToUrl($url, $data) {
       $fields = '';
       foreach($data as $key => $value) {
          $fields .= $key . '=' . $value . '&';
       }
       rtrim($fields, '&');

       $post = curl_init();

       curl_setopt($post, CURLOPT_URL, $url);
       curl_setopt($post, CURLOPT_POST, count($data));
       curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
       curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

       $result = curl_exec($post);

       curl_close($post);
       return $result;
    }
}
