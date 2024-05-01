<?php

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserModel', 'user', TRUE);
        $this->load->model('RequiModel', 'requi', TRUE);
    }

    function index() {
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
            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $uid);
            $data['csrf'] = random_strings();
            //load dashboard
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $data['mainmenu'] = "";
            $data['submenu'] = "home";
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/dashboard', $data);
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            $data['csrf'] = random_strings();
            redirect(base_url());
        }
    }

    function changePwd() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['mainmenu'] = "requisitions";
        $data['submenu'] = "changePwd";
        if ($userid != "" && in_array($role, array('SA', 'AD', 'UR'))) {
            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $data['csrf'] = random_strings();
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/change_pwd');
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function updatePassword() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('old_pwd', 'Old Password', 'trim|required|min_length[2]|max_length[25]');
            $this->form_validation->set_rules('new_pwd', 'New Password', 'trim|required|min_length[2]|max_length[25]');
            $this->form_validation->set_rules('cnf_pwd', 'Confirm Password', 'trim|required|min_length[1]|max_length[25]|matches[new_pwd]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'msg' => validation_errors()));
            } else {
                $uid = $this->session->userdata('uid');
                $role = $this->session->userdata('role');
                if ($uid != "" && in_array($role, array('SA', 'AD', 'UR'))) {
                    $oldpwd = trim($this->security->xss_clean($this->input->post("old_pwd")));
                    $newpwd = trim($this->security->xss_clean($this->input->post("new_pwd")));
                    $result = $this->user->selectDetailsModel('user_id', array('user_id' => $uid, 'pwd' => $oldpwd));
                    if ($result != NULL) {
                        $this->user->updateUserDetails(array('user_id' => $uid), array('pwd' => $newpwd));
                        $this->session->set_flashdata('message', 'Password Updated Successfully!!');
                        echo json_encode(array('status' => TRUE, 'msg' => 'Password Updated Successfully!'));
                    } else {
                        echo json_encode(array('status' => FALSE, 'msg' => 'Invalid old password'));
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

}
