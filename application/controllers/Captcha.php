<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function refresh() {
        // Captcha configuration
        $config = array(
            'img_path' => FCPATH . 'captcha_images/',
            'img_url' => base_url() . 'captcha_images/',
            'font_path' => FCPATH . 'assets/font/monofont.ttf',
            'img_width' => '130',
            'img_height' => 38,
            'word_length' => 6,
            'font_size' => 18,
            'pool' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'expiration' => 0,
            'colors' => array(
                'background' => array(0, 139, 139),
                'border' => array(255, 255, 255),
                'text' => array(255, 255, 255),
                'grid' => array(0, 0, 0)
            )
        );
        $captcha = create_captcha($config);
        $this->session->set_userdata('captchaCode', $captcha['word']);
        // Display captcha image
        echo $captcha['image'];
    }

}
