<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
$config['useragent'] = 'PCRS email notification utility\'s';
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$config["smtp_debug_level"] = 2;
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mail.kejora.gov.my';
$config['smtp_require_auth'] = TRUE;
$config['smtp_user'] = 'pcrs';
$config['smtp_pass'] = "Malay\$ia";
$config['smtp_port'] = 587;
$config['mailtype'] = 'html';
