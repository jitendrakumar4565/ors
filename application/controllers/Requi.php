<?php

class Requi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RequiModel', 'requi', TRUE);
        $this->load->model('RequiSentModel', 'requiSent', TRUE);
        $this->load->model('OrganisationModel', 'organisation', TRUE);
        $this->load->model('DepartmentModel', 'department', TRUE);
        $this->load->model('DesignationModel', 'designation', TRUE);
        $this->load->model('PostNameModel', 'postName', TRUE);
        $this->load->model('GroupNameModel', 'groupName', TRUE);
        $this->load->model('PayScaleModel', 'payScale', TRUE);
        $this->load->model('ModeRecruitModel', 'modeRecruit', TRUE);
    }

    function countNos() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $nosData = $this->requi->getNos($role, $userid);
        $newDatetime = trim($this->security->xss_clean($this->input->post("currentDatetime")));
        $this->session->set_userdata('oldDateTime', $newDatetime);
        $oldDateTime = $this->session->userdata("oldDateTime");
        $curr_time = date('Y-m-d H:i:s');
        $start_datetime = new DateTime($oldDateTime);
        $diff = $start_datetime->diff(new DateTime($curr_time));
        $mins = $diff->i;
        $screenLock = FALSE;
        $logOut = FALSE;
        //$dt = "DAYS : " . $diff->days . " YEARS : " . $diff->y . " MONTH : " . $diff->m . " DAYS : " . $diff->d . " HOURS : " . $diff->h . " MINUTES : " . $diff->i . " SECONDS : " . $diff->s;
        if ($mins >= 10) {
            $this->session->set_userdata('screenlock', TRUE);
            $screenLock = TRUE;
        }
        if ($mins >= 30) {
            $this->session->set_flashdata('message', 'Session Expired!');
            $logOut = TRUE;
        }
        $mstSettings = $this->requi->selectSettingsModel('*', array('auto_id' => 1));
        $this->session->set_userdata(array('newReqForm' => $mstSettings->requisition_form_flag));
        if ($nosData != NULL) {
            echo json_encode(array('mins' => $diff->i . " : " . $diff->s, 'screenlock' => $screenLock, 'logout' => $logOut, 'status' => TRUE, "nosDirectReq" => $nosData['nosDirectReq'], "nosLDCEReq" => $nosData['nosLDCEReq'], "nosUsr" => $nosData['nosUsr'], "nosDirectTrash" => $nosData['nosDirectTrash'], "nosLDCETrash" => $nosData['nosLDCETrash']));
        } else {
            echo json_encode(array('mins' => $diff->i . " : " . $diff->s, 'screenlock' => $screenLock, 'logout' => $logOut, 'status' => FALSE));
        }
    }

    function enableDisableNewForm() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('flag', 'Flag', 'trim|required|regex_match[/^[0-9]+$/i]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $flag = trim($this->security->xss_clean($this->input->post("flag")));
                    $this->db->trans_start();
                    $this->requi->updateSettingsModel(array('auto_id' => 1), array('requisition_form_flag' => $flag));
                    $this->session->set_userdata(array('newReqForm' => $flag));
                    if ($flag == 1) {
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Requisition form enabled!'));
                    }
                    if ($flag == 0) {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Requisition form disabled!'));
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
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'You are not authorized to perform these operation!'));
        }
    }

}
