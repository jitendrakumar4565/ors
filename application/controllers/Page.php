<?php

class Page extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('DesignationModel', 'designation', TRUE);
        $this->load->model('DepartmentModel', 'department', TRUE);
    }

    function index() {
        $sessArr = array('uid' => '', 'role' => '', 'usrid' => '', 'fullname' => '', 'mobile' => '', 'email' => '',
            'htmlmsg' => '', 'mobemailotp' => '', 'mobotp' => '', 'emailotp' => '', 'resetPassword' => FALSE
        );

        $pageName = trim($this->security->xss_clean($this->input->get("name")));
        if ($pageName != "") {
            if ($pageName == "home") {
                $this->session->set_userdata($sessArr);
                $this->home();
            } else if ($pageName == "login") {
                $this->session->set_userdata($sessArr);
                $this->login();
            } else if ($pageName == "register") {
                $this->session->set_userdata($sessArr);
                $this->register();
            } else if ($pageName == "contact") {
                $this->session->set_userdata($sessArr);
                $this->contact();
            } else if ($pageName == "forgotPassword") {
                $this->session->set_userdata($sessArr);
                $this->forgotPassword();
            } else if ($pageName == "resetPassword") {
                $this->resetPassword();
            } else if ($pageName == "init") {
                $this->init();
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }

    function home() {
        $this->load->view('common/ors/1_header_script');
        $this->load->view('common/ors/2_top_header');
        $this->load->view('common/ors/3_logout_menu');
        $this->load->view('common/ors/4_img_slider');
        $this->load->view('common/ors/5_latest_news_scroll');
        //$this->load->view('common/ors/6_box_section');
        $this->load->view('common/ors/7_brand_logos');
        $this->load->view('common/ors/8_footer');
    }

    function login() {
        $data['token'] = getCSRFToken();
        $this->load->view('common/ors/1_header_script');
        $this->load->view('common/ors/2_top_header');
        $this->load->view('common/ors/3_logout_menu');
        $this->load->view('common/ors/5_latest_news_scroll');
        $this->load->view('common/ors/login_page', $data);
        $this->load->view('common/ors/8_footer');
    }

    function register() {
        $data['token'] = getCSRFToken();
        $this->load->view('common/ors/1_header_script');
        $this->load->view('common/ors/2_top_header');
        $this->load->view('common/ors/3_logout_menu');
        $this->load->view('common/ors/5_latest_news_scroll');
        $data['deptList'] = $this->department->selectDetailsModel('auto_id,dept_name', array());
        $data['desigList'] = $this->designation->selectDetailsModel('auto_id,desig_name', array());
        $this->load->view('common/ors/register_member', $data);
        $this->load->view('common/ors/8_footer');
    }

    function forgotPassword() {
        $data['token'] = getCSRFToken();
        $this->load->view('common/ors/1_header_script');
        $this->load->view('common/ors/2_top_header');
        $this->load->view('common/ors/3_logout_menu');
        $this->load->view('common/ors/5_latest_news_scroll');
        $this->load->view('common/ors/forgot_password', $data);
        $this->load->view('common/ors/8_footer');
    }

    function resetPassword() {
        $resetPassword = $this->session->userdata('resetPassword');
        if ($resetPassword) {
            $data['token'] = getCSRFToken();
            $this->load->view('common/ors/1_header_script');
            $this->load->view('common/ors/2_top_header');
            $this->load->view('common/ors/3_logout_menu');
            $this->load->view('common/ors/5_latest_news_scroll');
            $this->load->view('common/ors/reset_password', $data);
            $this->load->view('common/ors/8_footer');
        } else {
            redirect(base_url());
        }
    }

    function contact() {
        $data['token'] = getCSRFToken();
        $this->load->view('common/ors/1_header_script');
        $this->load->view('common/ors/2_top_header');
        $this->load->view('common/ors/3_logout_menu');
        $this->load->view('common/ors/5_latest_news_scroll');
        $this->load->view('common/ors/contact_address', $data);
        $this->load->view('common/ors/8_footer');
    }

    function init() {
        $this->load->view('common/ors/1_header_script');
        $this->load->view('common/ors/2_top_header');
        $this->load->view('common/ors/3_logout_menu');
        $this->load->view('common/ors/4_inauguration');
        $this->load->view('common/ors/5_latest_news_scroll');
        $this->load->view('common/ors/7_brand_logos');
        $this->load->view('common/ors/8_footer');
    }

}
