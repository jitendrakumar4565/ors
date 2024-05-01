<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('AuthModel', 'authm', TRUE);
        $this->load->model('UserModel', 'user', TRUE);
        $this->load->model('RequiModel', 'requi', TRUE);
        include APPPATH . 'third_party/random_compat/lib/random.php';
    }

    function index() {
        $n = $this->uri->segment(4);
        if ($n == 'requisitions_documents') {
            die();
        }
        $sessArr = array(
            'usrid' => '',
            'mobile' => '',
            'email' => '',
            'htmlmsg' => '',
            'mobemailotp' => '',
            'mobotp' => '',
            'emailotp' => '',
            'resetPassword' => FALSE
        );
        $this->session->set_userdata($sessArr);
        $uid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($uid != "" && $role != "") {
            redirect('home');
        } else {
            $this->load->view('common/ors/1_header_script');
            $this->load->view('common/ors/2_top_header');
            $this->load->view('common/ors/3_logout_menu');
            $this->load->view('common/ors/4_img_slider');
            //$this->load->view('common/ors/4_inauguration');
            $this->load->view('common/ors/5_latest_news_scroll');
            //$this->load->view('common/ors/6_box_section');
            $this->load->view('common/ors/7_brand_logos');
            $this->load->view('common/ors/8_footer');
        }
    }

    function signIn() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('email_mobile', 'Email address or mobile number', 'trim|required', array('required' => 'Enter email address or mobile number'));
            $this->form_validation->set_rules('pwd', 'Password', 'trim|required', array('required' => 'Enter password'));
            $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|regex_match[/^[aA-zZ]+$/i]|max_length[6]|min_length[6]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('result' => FALSE, 'msg' => validation_errors()));
            } else {
                $uid = trim($this->security->xss_clean($this->input->post("email_mobile")));
                $pwd = trim($this->security->xss_clean($this->input->post("pwd")));
                $captcha = trim($this->security->xss_clean($this->input->post("captcha")));

                $sessCaptcha = $this->session->userdata('captchaCode');
                if (strtoupper($captcha) != strtoupper($sessCaptcha)) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "Invalid captcha"));
                } else {
                    $row = $this->authm->signInModel($uid, $pwd);
                    $usrid = "";
                    $role = "";
                    $isMobVerified = "N";
                    $isEmailVerified = "N";
                    $approvedFlag = "P";
                    $loginAccess = "Y";
                    $blockReason = "";
                    if ($row != NULL) {
                        $user_data = array(
                            'uid' => $row->user_id,
                            'fullname' => $row->full_name,
                            'role' => $row->user_lvl
                        );

                        $usrid = $row->user_id;
                        $role = $row->user_lvl;
                        $isEmailVerified = $row->is_email_verified;
                        $isMobVerified = $row->is_mob_verified;
                        $approvedFlag = $row->approved_flag;
                        $loginAccess = $row->login_access;
                        $blockReason = $row->block_reason;
                        $this->session->set_userdata('usrid', $usrid);
                        $this->session->set_userdata('screenlock', FALSE);
                        $this->session->set_userdata('oldDateTime', date('Y-m-d H:i:s'));
                        $mstSettings = $this->requi->selectSettingsModel('*', array('auto_id' => 1));
                        $this->session->set_userdata(array('newReqForm' => $mstSettings->requisition_form_flag));
                        $msg = "";
                        if (in_array($role, array('SA', 'AD'))) {
                            $this->session->set_userdata($user_data);
                            $this->session->set_userdata('new_session', date('Y-m-d h:i:s'));
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "Login success!"));
                        } else if ($isEmailVerified == "N" || $isMobVerified == "N") {
                            if ($isEmailVerified == "N") {
                                $msg .= "Email verification pending";
                            }
                            if ($isMobVerified == "N") {
                                $msg .= "<br/>Mobile verification pending";
                            }
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'isEmailVerified' => $isEmailVerified, 'isMobVerified' => $isMobVerified, 'msg' => $msg));
                        } else if ($isEmailVerified == "Y" && $isMobVerified == "Y" && $approvedFlag == "A" && $loginAccess == "Y") {
                            $this->session->set_userdata($user_data);
                            $this->session->set_userdata('new_session', date('Y-m-d h:i:s'));
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "Login success!"));
                        } else {
                            if ($loginAccess == "N" && $approvedFlag == "A") {
                                $msg = "Your login is temporary blocked. " . $blockReason;
                            } else if ($approvedFlag == "P") {
                                $msg = "Your registration is under process. Please wait for the approval!";
                            }
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'isEmailVerified' => $isEmailVerified, 'isMobVerified' => $isMobVerified, 'approvedFlag' => $approvedFlag, 'blockToLogin' => $loginAccess, 'blockReason' => $blockReason, 'msg' => $msg));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "Invalid email address/mobile number/password"));
                    }
                }
            }
        } else {
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function screenLock() {
        $userid = $this->session->userdata('uid');
        if ($userid == '') {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE));
        } else {
            $this->session->set_userdata('screenlock', TRUE);
            $curr_time = date('Y-m-d H:i:s');
            $this->session->set_userdata('oldDateTime', $curr_time);
            echo json_encode(array('status' => TRUE));
        }
    }

    function unLockScreen() {
        $this->form_validation->set_rules('user_pwd', 'Password', 'required', array('required' => 'Password is required'));
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => FALSE, 'msg' => validation_errors()));
        } else {
            $uid = $this->session->userdata('uid');
            $pwd = trim($this->security->xss_clean($this->input->post("user_pwd")));
            $row = $this->authm->unLockScreenModel($uid, $pwd);
            $role = "";
            $isMobVerified = "N";
            $isEmailVerified = "N";
            $approvedFlag = "P";
            $loginAccess = "Y";
            $blockReason = "";
            if ($row != NULL) {
                $isEmailVerified = $row->is_email_verified;
                $isMobVerified = $row->is_mob_verified;
                $approvedFlag = $row->approved_flag;
                $loginAccess = $row->login_access;
                $blockReason = $row->block_reason;
                $this->session->set_userdata('oldDateTime', date('Y-m-d H:i:s'));
                $msg = "";
                if (in_array($role, array('SA', 'AD'))) {
                    $this->session->set_userdata('new_session', date('Y-m-d h:i:s'));
                    $this->session->set_userdata('screenlock', FALSE);
                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "Login success!"));
                } else if ($isEmailVerified == "N" || $isMobVerified == "N") {
                    if ($isEmailVerified == "N") {
                        $msg .= "Email verification pending";
                    }
                    if ($isMobVerified == "N") {
                        $msg .= "<br/>Mobile verification pending";
                    }
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'isEmailVerified' => $isEmailVerified, 'isMobVerified' => $isMobVerified, 'msg' => $msg));
                } else if ($isEmailVerified == "Y" && $isMobVerified == "Y" && $approvedFlag == "A" && $loginAccess == "Y") {
                    $this->session->set_userdata('new_session', date('Y-m-d h:i:s'));
                    $this->session->set_userdata('screenlock', FALSE);
                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "Login success!"));
                } else {
                    if ($loginAccess == "N" && $approvedFlag == "A") {
                        $msg = "Your login is temporary blocked. " . $blockReason;
                    } else if ($approvedFlag == "P") {
                        $msg = "Your registration is under process. Please wait for the approval!";
                    }
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'isEmailVerified' => $isEmailVerified, 'isMobVerified' => $isMobVerified, 'approvedFlag' => $approvedFlag, 'blockToLogin' => $loginAccess, 'blockReason' => $blockReason, 'msg' => $msg));
                }
            } else {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "Invalid password"));
            }
        }
    }

}
