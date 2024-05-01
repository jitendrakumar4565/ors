<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('DesignationModel', 'designation', TRUE);
        $this->load->model('OrganisationModel', 'organisation', TRUE);
        $this->load->model('DepartmentModel', 'department', TRUE);
        $this->load->model('UserModel', 'user', TRUE);
        $this->load->model('AuthModel', 'authm', TRUE);
        $this->load->model('RequiModel', 'requi', TRUE);
    }

    function index() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['mainmenu'] = "";
        $data['submenu'] = "user";
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            $data['deptList'] = $this->department->selectDetailsModel('auto_id,dept_name', array());
            $data['desigList'] = $this->designation->selectDetailsModel('auto_id,desig_name', array());
            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $data['csrf'] = random_strings();
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/list_users');
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function registerUser() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('email_id', 'Email address', 'callback_emailcheck|trim|strip_tags');
            $this->form_validation->set_rules('mobile_no', 'Mobile number', 'trim|required|regex_match[/^[6-9]{1}[0-9]{9}$/]');
            $this->form_validation->set_rules('full_name', 'Full name', 'trim|required|regex_match[/^[a-zA-Z][a-zA-Z\s]+$/i]|max_length[65]');
            $this->form_validation->set_rules('desig', 'Designation', 'trim|required|integer|min_length[1]|max_length[3]|regex_match[/^\d+$/]');
            $this->form_validation->set_rules('pwd', 'Password', 'trim|required');
            $this->form_validation->set_rules('cnf_pwd', 'Confirm Password', 'trim|required|matches[pwd]');
            $this->form_validation->set_rules('dept_id', 'Department', 'trim|required|integer|min_length[1]|max_length[11]|regex_match[/^\d+$/]');
            $this->form_validation->set_rules('org_id[]', 'Organisation', 'trim|required|integer|min_length[1]|max_length[11]|regex_match[/^\d+$/]');

            $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|regex_match[/^[A-Za-z]{6}$/]|max_length[6]|min_length[6]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $email_id = trim($this->security->xss_clean($this->input->post("email_id")));
                $mobile_no = trim($this->security->xss_clean($this->input->post("mobile_no")));
                $full_name = trim($this->security->xss_clean($this->input->post("full_name")));
                $desig = trim($this->security->xss_clean($this->input->post("desig")));
                $pwd = trim($this->security->xss_clean($this->input->post("pwd")));
                $dept_id = trim($this->security->xss_clean($this->input->post("dept_id")));
                $captcha = trim($this->security->xss_clean($this->input->post("captcha")));
                //check captcha
                $sessCaptcha = $this->session->userdata('captchaCode');
                if (strtoupper($captcha) != strtoupper($sessCaptcha)) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "Invalid captcha"));
                } else {
                    if (isset($_POST['org_id'])) {
                        $orgIds = $_POST['org_id'];
                        if (count($orgIds) > 0) {
                            $this->db->trans_start();
                            //check for mobile exists
                            $dbMob = "";
                            $dbEmail = "";
                            $mob_email_err = "";
                            $usrResp = $this->user->selectORDetailsModel('email_id,mobile_no', array('email_id' => $email_id, 'mobile_no' => $mobile_no));
                            if ($usrResp != NULL) {
                                foreach ($usrResp as $uRow) {
                                    $dbMob = $uRow->mobile_no;
                                    $dbEmail = $uRow->email_id;
                                }
                                if (($dbEmail != "" && ($dbEmail == $email_id)) && ($dbMob != "" && ($dbMob == $mobile_no))) {
                                    $mob_email_err .= "Email address and mobile number already exist";
                                } else if ($dbEmail != "" && ($dbEmail == $email_id)) {
                                    $mob_email_err .= "Email address already exist";
                                } else if ($dbMob != "" && ($dbMob == $mobile_no)) {
                                    $mob_email_err .= "Mobile number already exist";
                                }
                                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $mob_email_err));
                            } else {
                                //insert data into database
                                $usrDataArr = array(
                                    'user_lvl' => 'UR',
                                    'email_id' => $email_id,
                                    'mobile_no' => $mobile_no,
                                    'full_name' => ucwords($full_name),
                                    'desig' => $desig,
                                    'pwd' => $pwd,
                                    'dept_id' => $dept_id,
                                    'is_mob_verified' => 'N',
                                    'is_email_verified' => 'N',
                                    'approved_flag' => 'P',
                                    'login_access' => 'N',
                                    'registered_datetime' => date('Y-m-d H:i:s'),
                                    'registered_from_ip' => $this->input->ip_address(),
                                );
                                $rtnId = $this->user->saveUserDetails($usrDataArr);
                                if ($rtnId != "") {
                                    $orgIdArr = NULL;
                                    foreach ($orgIds as $id) {
                                        $orgIdArr[] = array(
                                            'user_id' => $rtnId,
                                            'org_id' => $id,
                                            'status_flag' => 'PN',
                                            'entry_datetime' => date('Y-m-d H:i:s')
                                        );
                                    }
                                    $this->user->saveUserMappedOrgModel($orgIdArr);
                                    $mobOtp = sprintf("%04d", rand(0001, 9999));
                                    $emailOtp = sprintf("%04d", rand(0001, 9999));
                                    $sessArr = array(
                                        'usrid' => $rtnId,
                                        'mobotp' => $mobOtp,
                                        'emailotp' => $emailOtp
                                    );
                                    $this->session->set_userdata($sessArr);
                                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'mobotp' => $mobOtp, 'emailotp' => $emailOtp, 'msg' => 'Registration successfully'));
                                } else {
                                    $this->db->trans_rollback();
                                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Something went wrong. Please try again'));
                                }
                            }
                            $this->db->trans_complete();
                            if ($this->db->trans_status() === FALSE) {
                                $this->db->trans_rollback();
                                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Something went wrong. Please try again'));
                            } else {
                                $this->db->trans_commit();
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "Select atleast one of organisation/office"));
                        }
                    }
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function resendOtp() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('type', 'Type', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $sessUid = $this->session->userdata('usrid');
                $resetPassword = $this->session->userdata('resetPassword');
                $type = trim($this->security->xss_clean($this->input->post("type")));
                if ($sessUid != "") {
                    if ($type == "email") {
                        $emailOtp = sprintf("%04d", rand(0001, 9999));
                        $this->session->set_userdata('emailotp', $emailOtp);
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'emailotp' => $emailOtp, 'mobotp' => '', 'msg' => 'OTP sent successfully!'));
                    } else if ($type == "mobile") {
                        $mobOtp = sprintf("%04d", rand(0001, 9999));
                        $this->session->set_userdata('mobotp', $mobOtp);
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'mobotp' => $mobOtp, 'emailotp' => '', 'msg' => 'OTP sent successfully!'));
                    } else if (($type == "reset") && ($resetPassword == TRUE)) {
                        $mobEmailOtp = sprintf("%04d", rand(0001, 9999));
                        $this->session->set_userdata('mobemailotp', $mobEmailOtp);
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'mobemailotp' => $mobEmailOtp, 'msg' => 'OTP sent successfully!'));
                    } else {
                        $this->session->set_flashdata('message', 'Session Expired!');
                        echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Session Expired!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Session Expired!'));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function verifyOtp() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('type', 'Type', 'trim|required');
            $this->form_validation->set_rules('otp', 'OTP', 'trim|required|integer|min_length[4]|max_length[4]|regex_match[/^\d+$/]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $sessUid = $this->session->userdata('usrid');
                if ($sessUid != "") {
                    $type = trim($this->security->xss_clean($this->input->post("type")));
                    $otp = trim($this->security->xss_clean($this->input->post("otp")));
                    $closeModal = FALSE;
                    if ($type == "email") {
                        $sessEmailOtp = $this->session->userdata('emailotp');
                        if ($sessEmailOtp == $otp) {
                            $this->user->updateUserDetails(array('user_id' => $sessUid), array('is_email_verified' => 'Y'));
                            $resp = $this->user->selectDetailsModel('user_id', array('is_email_verified' => 'Y', 'is_mob_verified' => 'Y', 'user_id' => $sessUid));
                            if ($resp != NULL) {
                                $closeModal = TRUE;
                            }
                            $this->session->set_userdata('emailotp', '');
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'close_modal' => $closeModal, 'msg' => 'Email OTP verified!'));
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Invalid email OTP'));
                        }
                    } else if ($type == "mobile") {
                        $sessMobOtp = $this->session->userdata('mobotp');
                        if ($sessMobOtp == $otp) {
                            $this->user->updateUserDetails(array('user_id' => $sessUid), array('is_mob_verified' => 'Y'));
                            $resp = $this->user->selectDetailsModel('user_id', array('is_email_verified' => 'Y', 'is_mob_verified' => 'Y', 'user_id' => $sessUid));
                            if ($resp != NULL) {
                                $closeModal = TRUE;
                            }
                            $this->session->set_userdata('mobotp', '');
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'close_modal' => $closeModal, 'msg' => 'Mobile OTP verified!'));
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Invalid mobile OTP'));
                        }
                    } else {
                        $this->session->set_flashdata('message', 'Session Expired!');
                        echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Session Expired!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Session Expired!'));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function updateEmail() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('new_email_id', 'New email address', 'callback_emailcheck|trim|strip_tags');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $sessUid = $this->session->userdata('usrid');
                if ($sessUid != "") {
                    $newEmail = trim($this->security->xss_clean($this->input->post("new_email_id")));
                    $resp = $this->user->selectDetailsModel('email_id,mobile_no', array('user_id !=' . $sessUid . ' AND email_id =' => $newEmail));
                    if ($resp != NULL) {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Email address already exist!'));
                    } else {
                        $emailOtp = sprintf("%04d", rand(0001, 9999));
                        $this->session->set_userdata('emailotp', $emailOtp);
                        $this->user->updateUserDetails(array('user_id' => $sessUid), array('email_id' => $newEmail, 'is_email_verified' => 'N'));
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'emailotp' => $emailOtp, 'mobotp' => '', 'msg' => 'Email address updated!'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Session Expired!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Session Expired!'));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function updateMobile() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('new_mob_no', 'New mobile number', 'trim|required|regex_match[/^[6-9]{1}[0-9]{9}$/]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $sessUid = $this->session->userdata('usrid');
                if ($sessUid != "") {
                    $newMobNo = trim($this->security->xss_clean($this->input->post("new_mob_no")));
                    $resp = $this->user->selectDetailsModel('email_id,mobile_no', array('user_id !=' . $sessUid . ' AND mobile_no =' => $newMobNo));
                    if ($resp != NULL) {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Mobile number already exist!'));
                    } else {
                        $mobOtp = sprintf("%04d", rand(0001, 9999));
                        $this->session->set_userdata('mobotp', $mobOtp);
                        $this->user->updateUserDetails(array('user_id' => $sessUid), array('mobile_no' => $newMobNo, 'is_mob_verified' => 'N'));
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'mobotp' => $mobOtp, 'emailotp' => '', 'msg' => 'Mobile number updated!'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Session Expired!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Session Expired!'));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function forgotPassword() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('email_mobile', 'Email address or mobile number', 'trim|required', array('required' => 'Enter email address or mobile number'));
            $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|regex_match[/^[aA-zZ]+$/i]|max_length[6]|min_length[6]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('result' => FALSE, 'msg' => validation_errors()));
            } else {
                $uid = trim($this->security->xss_clean($this->input->post("email_mobile")));
                $captcha = trim($this->security->xss_clean($this->input->post("captcha")));
                $sessCaptcha = $this->session->userdata('captchaCode');
                if (strtoupper($captcha) != strtoupper($sessCaptcha)) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "Invalid captcha"));
                } else {
                    $resp = $this->user->validateUserModel('user_id,email_id,mobile_no,full_name', $uid);
                    if ($resp != NULL) {
                        $mobemailotp = sprintf("%04d", rand(0001, 9999));
                        $usrid = $resp->user_id;
                        $fullname = ucfirst($resp->full_name);
                        $mobile = $resp->mobile_no;
                        $email = $resp->email_id;
                        $htmlMsg = "Dear " . $fullname . "! Your otp for reset password is " . $mobemailotp . '<br/>' . 'Mobile : ' . $mobile . '<br/>' . 'Email : ' . $email;
                        $msg = 'OTP sent successfully!';
                        $sessArr = array(
                            'usrid' => $usrid,
                            'fullname' => $fullname,
                            'mobile' => $mobile,
                            'email' => $email,
                            'htmlmsg' => $htmlMsg,
                            'mobemailotp' => $mobemailotp,
                            'resetPassword' => TRUE
                        );
                        $this->session->set_userdata($sessArr);
                        $this->session->set_flashdata('message', $msg);
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'OTP sent successfully!'));
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Invalid email address or mobile number!'));
                    }
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function resetPassword() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('new_pwd', 'New Password', 'trim|required');
            $this->form_validation->set_rules('cnf_pwd', 'Confirm Password', 'trim|required|matches[new_pwd]');
            $this->form_validation->set_rules('email_mobile_otp', 'OTP', 'trim|required|integer|min_length[4]|max_length[4]|regex_match[/^\d+$/]');
            $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|regex_match[/^[A-Za-z0-9]{6}$/]|max_length[6]|min_length[6]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $newPwd = trim($this->security->xss_clean($this->input->post("new_pwd")));
                $otp = trim($this->security->xss_clean($this->input->post("email_mobile_otp")));
                $captcha = trim($this->security->xss_clean($this->input->post("captcha")));
                $sessCaptcha = $this->session->userdata('captchaCode');
                $sessOtp = $this->session->userdata('mobemailotp');
                $resetPassword = $this->session->userdata('resetPassword');
                $sessUid = $this->session->userdata('usrid');
                if ($resetPassword == TRUE && $sessUid != "") {
                    if (strtoupper($captcha) != strtoupper($sessCaptcha)) {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "Invalid captcha"));
                    } else if ($sessOtp != $otp) {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "Invalid OTP"));
                    } else {
                        $this->user->updateUserDetails(array('user_id' => $sessUid), array('pwd' => $newPwd));
                        $sessArr = array(
                            'usrid' => '',
                            'fullname' => '',
                            'mobile' => '',
                            'email' => '',
                            'htmlmsg' => '',
                            'mobemailotp' => '',
                            'resetPassword' => FALSE
                        );
                        $this->session->set_userdata($sessArr);
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Password changed successfully!'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Session Expired!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Session Expired!'));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Session Expired!'));
        }
    }

    function ajax_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $list = $this->user->list_databales(array('user_lvl != "SA" AND user_id !=' => $userid));
                $count_rec = $this->user->list_filtered(array('user_lvl != "SA" AND user_id !=' => $userid));
                $data = array();
                $no = $_POST['start'];
                if ($list != NULL) {
                    $nosPending = $this->user->selectDetailsModel('user_id', array('user_lvl = "UR" AND approved_flag =' => 'P'));
                    foreach ($list as $accrow) {
                        $view = '<a title="View Details" class="btn btn-outline-info btn-xs" href="javascript:void(0)" onclick=viewDetails("' . $accrow->user_id . '")><i class="fas fa-eye"></i>  </a>&nbsp;';
                        $edit = '<a title="Edit User" class="btn btn-outline-info btn-xs" href="javascript:void(0)" onclick=editDetails("' . $accrow->user_id . '")><i class="fas fa-pencil-alt"></i>  </a>&nbsp;';
                        $delete = '<a title="Delete User" class="btn btn-outline-danger btn-xs" href="javascript:void(0)" onclick=deleteDetail("' . $accrow->user_id . '")><i class="fas fa-trash"></i>  </a>&nbsp;';
                        $lvlSpan = '<small class="badge badge-success"> Super Admin </small>';
                        $lvl = $accrow->user_lvl;
                        if ($lvl == "AD") {
                            $lvlSpan = '<small class="badge badge-danger"> Admin </small>';
                        }
                        if ($lvl == "UR") {
                            $lvlSpan = '<small class="badge badge-primary"> User </small>';
                        }

                        $mobileSpan = '<span class="badge badge-danger btn-xs"><i class="fa fa-phone"></i></span>&nbsp;';
                        $emailSpan = '<span class="badge badge-danger btn-xs"><i class="fa fa-envelope"></i></span>&nbsp;';
                        $loginSpan = '<span class="badge badge-danger btn-xs"><i class="fa fa-lock"></i></span>&nbsp;';
                        $approveSpan = '<span class="badge badge-danger btn-xs"><i class="fa fa-times"></i> Pending </span>&nbsp;';

                        if ($accrow->is_mob_verified == "Y") {
                            $mobileSpan = '<span class="badge badge-success btn-xs"><i class="fa fa-phone"></i></span>&nbsp;';
                        }
                        if ($accrow->is_email_verified == "Y") {
                            $emailSpan = '<span class="badge badge-success btn-xs"><i class="fa fa-envelope"></i></span>&nbsp;';
                        }
                        if ($accrow->login_access == "Y") {
                            $loginSpan = '<span class="badge badge-success btn-xs"><i class="fa fa-lock"></i></span>&nbsp;';
                        }
                        if ($accrow->approved_flag == "A") {
                            $approveSpan = '<span class="badge badge-success btn-xs"><i class="fa fa-check"></i> Approved</span>&nbsp;';
                        }

                        $bold = "font-weight-bold";
                        if ($accrow->seen_flag == 1) {
                            $bold = "";
                        }

                        $no ++;
                        $row = array();
                        $row[] = '<span class="' . $bold . '">' . $no . '</span>';
                        $row[] = '<span class="' . $bold . '">' . ucwords($accrow->full_name) . '</span>';
                        $row[] = '<span class="' . $bold . '">' . ucwords($accrow->desig_name) . '</span>';
                        $row[] = '<span class="' . $bold . '">' . ($accrow->mobile_no) . '</span>';
                        $row[] = '<span class="' . $bold . '">' . $lvlSpan . '</span>';
                        $row[] = '<span class="' . $bold . '">' . $mobileSpan . $emailSpan . $loginSpan . '</span>';
                        $row[] = '<span class="' . $bold . '">' . $approveSpan . '</span>';
                        $row[] = $view . $edit . $delete;
                        $data[] = $row;
                    }
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, 'nosPending' => count($nosPending), "recordsTotal" => $count_rec, "recordsFiltered" => $count_rec, "data" => $data);
                    echo json_encode($output);
                } else {
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, 'nosPending' => 0, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => array());
                    echo json_encode($output);
                }
            } else {
                $this->session->set_flashdata('message', 'Invalid request!');
                echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'You are not authorized to perform these operation!'));
        }
    }

    function registerUserByAdmin() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('email_id', 'Email address', 'callback_emailcheck|trim|strip_tags');
            $this->form_validation->set_rules('mobile_no', 'Mobile number', 'trim|required|regex_match[/^[6-9]{1}[0-9]{9}$/]');
            $this->form_validation->set_rules('full_name', 'Full name', 'trim|required|regex_match[/^[a-zA-Z][a-zA-Z\s]+$/i]|max_length[65]');
            $this->form_validation->set_rules('usr_lvl', 'Level', 'trim|required|regex_match[/^[a-zA-Z][a-zA-Z\s]+$/i]|max_length[2]|min_length[2]');
            $this->form_validation->set_rules('desig', 'Designation', 'trim|required|integer|min_length[1]|max_length[3]|regex_match[/^\d+$/]');
            $this->form_validation->set_rules('pwd', 'Password', 'trim|required');
            $this->form_validation->set_rules('cnf_pwd', 'Confirm Password', 'trim|required|matches[pwd]');
            $this->form_validation->set_rules('dept_id', 'Department', 'trim|required|integer|min_length[1]|max_length[11]|regex_match[/^\d+$/]');
            $this->form_validation->set_rules('org_id[]', 'Organisation', 'trim|required|integer|min_length[1]|max_length[11]|regex_match[/^\d+$/]');
            $this->form_validation->set_rules('email_ver', 'Email Verified', 'trim|required');
            $this->form_validation->set_rules('mob_ver', 'Mobile verified', 'trim|required');
            $this->form_validation->set_rules('login_access', 'Login Access', 'trim|required');
            $this->form_validation->set_rules('approved_flag', 'Approved', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $email_id = trim($this->security->xss_clean($this->input->post("email_id")));
                $mobile_no = trim($this->security->xss_clean($this->input->post("mobile_no")));
                $full_name = trim($this->security->xss_clean($this->input->post("full_name")));
                $usr_lvl = trim($this->security->xss_clean($this->input->post("usr_lvl")));
                $desig = trim($this->security->xss_clean($this->input->post("desig")));
                $pwd = trim($this->security->xss_clean($this->input->post("pwd")));
                $dept_id = trim($this->security->xss_clean($this->input->post("dept_id")));
                $email_ver = trim($this->security->xss_clean($this->input->post("email_ver")));
                $mob_ver = trim($this->security->xss_clean($this->input->post("mob_ver")));
                $login_access = trim($this->security->xss_clean($this->input->post("login_access")));
                $approved_flag = trim($this->security->xss_clean($this->input->post("approved_flag")));

                $userid = $this->session->userdata('uid');
                $role = $this->session->userdata('role');
                if ($userid != "" && in_array($role, array('SA', 'AD'))) {
                    if (isset($_POST['org_id'])) {
                        $orgIds = $_POST['org_id'];
                        if (count($orgIds) > 1) {
                            $this->db->trans_start();
                            //check for mobile exists
                            $dbMob = "";
                            $dbEmail = "";
                            $mob_email_err = "";
                            $usrResp = $this->user->selectORDetailsModel('email_id,mobile_no', array('email_id' => $email_id, 'mobile_no' => $mobile_no));
                            if ($usrResp != NULL) {
                                foreach ($usrResp as $uRow) {
                                    $dbMob = $uRow->mobile_no;
                                    $dbEmail = $uRow->email_id;
                                }
                                if (($dbEmail != "" && ($dbEmail == $email_id)) && ($dbMob != "" && ($dbMob == $mobile_no))) {
                                    $mob_email_err .= "Email address and mobile number already exist";
                                } else if ($dbEmail != "" && ($dbEmail == $email_id)) {
                                    $mob_email_err .= "Email address already exist";
                                } else if ($dbMob != "" && ($dbMob == $mobile_no)) {
                                    $mob_email_err .= "Mobile number already exist";
                                }
                                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $mob_email_err));
                            } else {
                                //insert data into database
                                $usrDataArr = array(
                                    'user_lvl' => $usr_lvl,
                                    'email_id' => $email_id,
                                    'mobile_no' => $mobile_no,
                                    'full_name' => ucwords($full_name),
                                    'desig' => $desig,
                                    'pwd' => $pwd,
                                    'dept_id' => $dept_id,
                                    'is_mob_verified' => $mob_ver,
                                    'is_email_verified' => $email_ver,
                                    'approved_flag' => $approved_flag,
                                    'login_access' => $login_access,
                                    'registered_datetime' => date('Y-m-d H:i:s'),
                                    'registered_from_ip' => $this->input->ip_address(),
                                    'registered_from_admin' => $userid
                                );
                                $rtnId = $this->user->saveUserDetails($usrDataArr);
                                if ($rtnId != "") {
                                    $statusFlag = "PN";
                                    if ($approved_flag == "A") {
                                        $statusFlag = "AP";
                                    }
                                    $orgIdArr = NULL;
                                    foreach ($orgIds as $id) {
                                        $orgIdArr[] = array(
                                            'user_id' => $rtnId,
                                            'org_id' => $id,
                                            'status_flag' => $statusFlag,
                                            'action_taken_user' => $userid,
                                            'action_datetime' => date('Y-m-d H:i:s'),
                                            'entry_datetime' => date('Y-m-d H:i:s')
                                        );
                                    }
                                    $this->user->saveUserMappedOrgModel($orgIdArr);
                                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Registration successfully'));
                                } else {
                                    $this->db->trans_rollback();
                                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Something went wrong. Please try again'));
                                }
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "Select atleast one of organisation/office"));
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', 'Unauthorized access!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => "Unauthorized access"));
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Something went wrong. Please try again'));
                } else {
                    $this->db->trans_commit();
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function viewDetails() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('auto_id', 'User ID', 'trim|required|integer|min_length[1]|max_length[11]|regex_match[/^\d+$/]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $autoId = trim($this->security->xss_clean($this->input->post("auto_id")));
                $userid = $this->session->userdata('uid');
                $role = $this->session->userdata('role');
                if ($userid != "" && in_array($role, array('SA', 'AD'))) {
                    $usrResp = $this->user->selectComDetailsRowModel('usr.user_id,usr.user_lvl,usr.email_id,usr.mobile_no,usr.full_name,desig.desig_name,usr.is_mob_verified,usr.is_email_verified,usr.approved_flag,usr.login_access,dept.dept_name', array('usr.user_id' => $autoId));
                    if ($usrResp != NULL) {
                        $res = loadMenus();
                        $data['userDetails'] = $usrResp;
                        $data['autoId'] = $autoId;
                        $data['orgList'] = $this->user->getUserMappOrgModel($autoId, 'org.auto_id,org.org_name,mpp.org_id,mpp.status_flag', array('mpp.user_id' => $autoId));
                        $this->user->updateUserDetails(array('user_id' => $autoId), array('seen_flag' => 1, 'seen_datetime' => date('Y-m-d H:i:s'), 'seen_user' => $userid));
                        $this->session->set_userdata('approvid', $autoId);
                        $htmlData = $this->load->view('pages/' . $res . '/view_user_details', $data, TRUE);
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'htmlData' => $htmlData));
                    } else {
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'No record found!'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Unauthorized access!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => "Unauthorized access"));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function editDetails() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('auto_id', 'User ID', 'trim|required|integer|min_length[1]|max_length[11]|regex_match[/^\d+$/]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $autoId = trim($this->security->xss_clean($this->input->post("auto_id")));
                $userid = $this->session->userdata('uid');
                $role = $this->session->userdata('role');
                if ($userid != "" && in_array($role, array('SA', 'AD'))) {
                    $usrResp = $this->user->selectDetailsRowModel('user_id,user_lvl,email_id,mobile_no,full_name,desig,dept_id,is_mob_verified,is_email_verified,approved_flag,login_access', array('user_id' => $autoId));
                    if ($usrResp != NULL) {
                        $res = loadMenus();
                        $data['userDetails'] = $usrResp;
                        $data['autoId'] = $autoId;
                        $data['deptId'] = $usrResp->dept_id;
                        $this->session->set_userdata('editid', $autoId);
                        $data['desigList'] = $this->designation->selectDetailsModel('auto_id,desig_name', array());
                        $data['deptList'] = $this->department->selectDetailsModel('auto_id,dept_name', array());
                        $htmlData = $this->load->view('pages/' . $res . '/edit_user_details', $data, TRUE);
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'htmlData' => $htmlData));
                    } else {
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'No record found!'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Unauthorized access!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => "Unauthorized access"));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function editUserByAdmin() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('auto_id', 'User ID', 'trim|required|integer|min_length[1]|max_length[11]|regex_match[/^\d+$/]');
            $this->form_validation->set_rules('email_id1', 'Email address', 'callback_emailcheck|trim|strip_tags');
            $this->form_validation->set_rules('mobile_no1', 'Mobile number', 'trim|required|regex_match[/^[6-9]{1}[0-9]{9}$/]');
            $this->form_validation->set_rules('full_name1', 'Full name', 'trim|required|regex_match[/^[a-zA-Z][a-zA-Z\s]+$/i]|max_length[65]');
            $this->form_validation->set_rules('usr_lvl1', 'Level', 'trim|required|regex_match[/^[a-zA-Z][a-zA-Z\s]+$/i]|max_length[2]|min_length[2]');
            $this->form_validation->set_rules('desig1', 'Designation', 'trim|required|integer|min_length[1]|max_length[3]|regex_match[/^\d+$/]');
            $this->form_validation->set_rules('dept_id1', 'Department', 'trim|required|integer|min_length[1]|max_length[11]|regex_match[/^\d+$/]');
            $this->form_validation->set_rules('org_id1[]', 'Organisation', 'trim|required|integer|min_length[1]|max_length[11]|regex_match[/^\d+$/]');
            $this->form_validation->set_rules('email_ver1', 'Email Verified', 'trim|required');
            $this->form_validation->set_rules('mob_ver1', 'Mobile verified', 'trim|required');
            $this->form_validation->set_rules('login_access1', 'Login Access', 'trim|required');
            $this->form_validation->set_rules('approved_flag1', 'Approved', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $autoId = trim($this->security->xss_clean($this->input->post("auto_id")));
                $email_id = trim($this->security->xss_clean($this->input->post("email_id1")));
                $mobile_no = trim($this->security->xss_clean($this->input->post("mobile_no1")));
                $full_name = trim($this->security->xss_clean($this->input->post("full_name1")));
                $usr_lvl = trim($this->security->xss_clean($this->input->post("usr_lvl1")));
                $desig = trim($this->security->xss_clean($this->input->post("desig1")));
                $dept_id = trim($this->security->xss_clean($this->input->post("dept_id1")));
                $email_ver = trim($this->security->xss_clean($this->input->post("email_ver1")));
                $mob_ver = trim($this->security->xss_clean($this->input->post("mob_ver1")));
                $login_access = trim($this->security->xss_clean($this->input->post("login_access1")));
                $approved_flag = trim($this->security->xss_clean($this->input->post("approved_flag1")));

                $userid = $this->session->userdata('uid');
                $role = $this->session->userdata('role');
                $sessAutoId = $this->session->userdata('editid');
                if ($userid != "" && $autoId != "" && $sessAutoId == $autoId && in_array($role, array('SA', 'AD'))) {
                    $this->db->trans_start();
                    //check for mobile exists
                    $dbMob = "";
                    $dbEmail = "";
                    $dbUsrId = "";
                    $mob_email_err = "";
                    $usrResp = $this->user->validateEmailMobileModel($email_id, $mobile_no, $autoId);
                    if ($usrResp != NULL) {
                        foreach ($usrResp as $uRow) {
                            $dbMob = $uRow->mobile_no;
                            $dbEmail = $uRow->email_id;
                            $dbUsrId = $uRow->user_id;
                        }
                        if (($dbEmail != "" && ($dbEmail == $email_id)) && ($dbMob != "" && ($dbMob == $mobile_no))) {
                            $mob_email_err .= "Email address and mobile number already exist";
                        } else if ($dbEmail != "" && ($dbEmail == $email_id)) {
                            $mob_email_err .= "Email address already exist";
                        } else if ($dbMob != "" && ($dbMob == $mobile_no)) {
                            $mob_email_err .= "Mobile number already exist";
                        }
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $mob_email_err));
                    } else {
                        //insert data into database
                        $usrDataArr = array(
                            'user_lvl' => $usr_lvl,
                            'email_id' => $email_id,
                            'mobile_no' => $mobile_no,
                            'full_name' => ucwords($full_name),
                            'desig' => $desig,
                            'dept_id' => $dept_id,
                            'is_mob_verified' => $mob_ver,
                            'is_email_verified' => $email_ver,
                            'approved_flag' => $approved_flag,
                            'login_access' => $login_access
                        );
                        if ($this->user->updateUserDetails(array('user_id' => $autoId), $usrDataArr)) {
                            if (isset($_POST['org_id1'])) {
                                $orgIds = $_POST['org_id1'];
                                $orgIdArr = NULL;
                                foreach ($orgIds as $id) {
                                    $orgIdArr[] = array(
                                        'user_id' => $autoId,
                                        'org_id' => $id,
                                        'status_flag' => "AP",
                                        'action_taken_user' => $userid,
                                        'action_datetime' => date('Y-m-d H:i:s'),
                                        'entry_datetime' => date('Y-m-d H:i:s')
                                    );
                                }
                                if ($this->user->removeUserMappedOrgModel(array('user_id' => $autoId))) {
                                    $this->user->saveUserMappedOrgModel($orgIdArr);
                                    $this->session->set_userdata('editid', '');
                                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Registration updated successfully'));
                                } else {
                                    $this->db->trans_rollback();
                                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Something went wrong. Please try again'));
                                }
                            }
                        } else {
                            $this->db->trans_rollback();
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Something went wrong. Please try again'));
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', 'Unauthorized access!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => "Unauthorized access"));
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Something went wrong. Please try again'));
                } else {
                    $this->db->trans_commit();
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function approveUser() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('auto_id', 'User ID', 'trim|required|integer|min_length[1]|max_length[11]|regex_match[/^\d+$/]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $autoId = trim($this->security->xss_clean($this->input->post("auto_id")));
                $userid = $this->session->userdata('uid');
                $role = $this->session->userdata('role');
                $sessApprovId = $this->session->userdata('approvid');
                if ($userid != "" && $sessApprovId == $autoId && $sessApprovId != "" && in_array($role, array('SA', 'AD'))) {
                    $appDataArr = array(
                        'is_mob_verified' => 'Y',
                        'is_email_verified' => 'Y',
                        'approved_flag' => 'A',
                        'approved_datetime' => date('Y-m-d H:i:s'),
                        'approved_by_admin' => $userid,
                        'login_access' => 'Y'
                    );
                    $this->user->updateUserDetails(array('user_id' => $autoId), $appDataArr);
                    $this->session->set_userdata('approvid', '');
                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "Approved successfully!"));
                } else {
                    $this->session->set_flashdata('message', 'Unauthorized access!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => "Unauthorized access"));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function deleteUser() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('auto_id', 'User ID', 'trim|required|integer|min_length[1]|max_length[11]|regex_match[/^\d+$/]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $autoId = trim($this->security->xss_clean($this->input->post("auto_id")));
                $userid = $this->session->userdata('uid');
                $role = $this->session->userdata('role');
                if ($userid != "" && in_array($role, array('SA', 'AD'))) {
                    $this->user->deleteDetailsModel(array('user_lvl != "SA" AND user_id =' => $autoId));
                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "User removed successfully!"));
                } else {
                    $this->session->set_flashdata('message', 'Unauthorized access!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => "Unauthorized access"));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    public function emailcheck($str) {
        if ($str != '') {
            if (preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $str)) {
                return true;
            } else {
                $this->form_validation->set_message('emailcheck', 'The %s field must be a valid email address.');
                return FALSE;
            }
        }
    }

    function logOut() {
        $this->session->sess_destroy();
        redirect(base_url());
    }

}
