<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EmailController extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->sendVerificationEmail('jitendrakumar4565@gmail.com', '12345');
    }

    public function sendVerificationEmail($email, $otp) {
        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.gmail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = 'noreply.apssb@gmail.com';
        $config['smtp_pass'] = 'Jitu@2023';
        $config['smtp_crypto'] = 'tls';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";


        $this->email->initialize($config);

        $this->email->from('noreply.apssb@gmail.com', 'APSSB');
        $this->email->to($email);

        $this->email->subject('Verification Code');

        $message = "Dear User,<br><br>";
        $message .= "Thank you for registering on our website. To verify your account, please use the following verification code:<br><br>";
        $message .= "Verification Code: " . $otp . "<br><br>";
        $message .= "If you did not request this verification, please ignore this email.<br><br>";
        $message .= "Best regards,<br>";
        $message .= "Your Website Team";

        $this->email->message($message);

        if ($this->email->send()) {
            echo 'Verification email sent successfully.';
        } else {
            echo 'Failed to send verification email.';
            echo $this->email->print_debugger();
        }
    }

}
