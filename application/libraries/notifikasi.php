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


	public function sendEmail($rcpt_to, $title, $message, $rcpt_cc = array(), $rcpt_bcc = array(), $attachment = NULL)
	{
		$this->CI->load->library('mailer');
		$this->CI->mailer->clear(TRUE);
		$this->CI->mailer->from($this->CI->config->item('pcrs_email_from'), $this->CI->config->item('pcrs_email_name'));
		$this->CI->mailer->to($rcpt_to);
		if(count($rcpt_cc) != 0)
			$this->CI->mailer->cc($rcpt_cc);
		if(count($rcpt_bcc) != 0)
			$this->CI->mailer->bcc($rcpt_bcc);

		$this->CI->mailer->subject($title);
		$this->CI->mailer->message($message);
		if($attachment)
		{
			$this->CI->mailer->attach($attachment);
		}
		$this->CI->mailer->send();
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

    function pcrs_send_phpmailer($rcpt_to, $title, $message, $rcpt_cc = array(), $rcpt_bcc = array(), $attachment = NULL)
	{
		$CI =& get_instance();
		$CI->load->library('myphpmailer');

		//setting
		switch($CI->config->item('pcrs_email_protocol'))
		{
			case 'smtp':
				$CI->myphpmailer->isSMTP();
				break;
		}
		$CI->myphpmailer->SMTPDebug = $CI->config->item('pcrs_email_smtp_debug_level');
		$CI->myphpmailer->Host = $CI->config->item('pcrs_email_smtp_host');
		$CI->myphpmailer->SMTPAuth = $CI->config->item('pcrs_email_smtp_auth');
		$CI->myphpmailer->Username = $CI->config->item('pcrs_email_smtp_user');
		$CI->myphpmailer->Password = $CI->config->item('pcrs_email_smtp_pass');
		$CI->myphpmailer->SMTPSecure = $CI->config->item('pcrs_email_smtp_secure');
		$CI->myphpmailer->Port = $CI->config->item('pcrs_email_smtp_port');
		$CI->myphpmailer->isHTML($CI->config->item('pcrs_email_mailtype_html'));
		//End Setting

		$CI->myphpmailer->clearAllRecipients();
		$CI->myphpmailer->clearAttachments();

		$CI->myphpmailer->setFrom($CI->config->item('pcrs_email_from'), $CI->config->item('pcrs_email_name'));

		if(is_array($rcpt_to))
		{
			if(count($rcpt_to)!=0)
			{
				foreach($rcpt_to as $val)
				{
					$CI->myphpmailer->addAddress($val);
				}
			}
		}
		else
		{
			$CI->myphpmailer->addAddress($rcpt_to);
		}

		if(is_array($rcpt_cc))
		{
			if(count($rcpt_cc)!=0)
			{
				foreach($rcpt_cc as $val)
				{
					$CI->myphpmailer->addCC($val);
				}
			}
		}
		else
		{
			$CI->myphpmailer->addCC($rcpt_cc);
		}

		if(is_array($rcpt_bcc))
		{
			if(count($rcpt_bcc)!=0)
			{
				foreach($rcpt_bcc as $val)
				{
					$CI->myphpmailer->addBCC($val);
				}
			}
		}
		else
		{
			$CI->myphpmailer->addBCC($rcpt_bcc);
		}

		$CI->myphpmailer->Subject = $title;
		$CI->myphpmailer->Body = $message;

		if($attachment)
		{
			$CI->myphpmailer->addAttachment($attachment);
		}
		if($CI->myphpmailer->send())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
