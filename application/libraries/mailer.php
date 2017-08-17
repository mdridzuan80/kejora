<?php
require_once("phpmailer/PHPMailerAutoload.php");

class Mailer extends PHPMailer
{
    public function __construct()
    {
        parent::__construct();
    }
}