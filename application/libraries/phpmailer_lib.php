<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailer_Lib
{
    public function __construct()
    {
        // Pastikan autoload Composer di-load
        require_once APPPATH . '../vendor/autoload.php';
    }

    public function load()
    {
        $mail = new PHPMailer(true);
        return $mail;
    }
}
