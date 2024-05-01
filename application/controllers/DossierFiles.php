<?php

class DossierFiles extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RequiAdvertisedModel', 'requiAdvertised', TRUE);
        $this->load->model('RequiModel', 'requi', TRUE);
        $this->load->model('OrganisationModel', 'organisation', TRUE);
        $this->load->model('DepartmentModel', 'department', TRUE);
        $this->load->model('DesignationModel', 'designation', TRUE);
        $this->load->model('PostNameModel', 'postName', TRUE);
        $this->load->model('GroupNameModel', 'groupName', TRUE);
        $this->load->model('PayScaleModel', 'payScale', TRUE);
        $this->load->model('ModeRecruitModel', 'modeRecruit', TRUE);
        $this->load->model('RequiInboxModel', 'requiInbox', TRUE);
        $this->load->model('RecommendedDraftModel', 'recommendedDraft', TRUE);
    }

    function index() {
        $targetDir = "dossiers_documents/153/";
        $allFiles = scandir($targetDir);
        $files = array_diff($allFiles, array('.', '..'));
        // $data['files'] = $files;
        foreach ($files as $file) {
            $size = " bytes";
            $value = filesize($targetDir . $file);
            //convert Bytes Logic
            if ($value < 1024) {
                $size = $value . " bytes";
            }
            //convert Kilobytes Logic
            else if ($value < 1024000) {
                $size = round(($value / 1024), 1) . "k";
            }
            //convert Megabytes Logic
            else {
                $size = round(($value / 1024000), 1) . "MB";
            }
            echo $file . ' : ' . date("d-m-Y H:i", filemtime($targetDir . $file)) . ' : ' . $size . '<br/>';
        }
    }

    function uploadDossierFiles() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('rec_auto_id_pdf', 'ID', 'trim|required|integer|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('file_copy_d_3', 'Upload file(in excel file)', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post("rec_auto_id_pdf")));
                    $mData = $this->requiInbox->selectDetailsRowModel('auto_id,(rec_ur + rec_apst + rec_pwd + rec_ex_sm) as total_rec', array('auto_id' => $auto_id, 'action_taken' => 'ADVERTISED'));
                    $rollNosDraft = $this->recommendedDraft->selectDetailsModel('roll_no', array('inbox_requi_auto_id' => $auto_id));
                    $targetDir = 'dossiers_documents/' . $auto_id . '/pdf';
                    $this->db->trans_start();
                    if ($rollNosDraft != NULL) {
                        if ($mData != NULL) {
                            $dbRollNos = array();
                            foreach ($rollNosDraft as $rRow) {
                                $dbRollNos[] = $rRow->roll_no . '.pdf';
                            }
                            $successUploadFile = "";
                            $notUploadedFile = "";
                            $invalidFile = "";

                            //$allFiles = scandir($targetDir);
                            //$dirFiles = array_reverse(array_diff($allFiles, array('.', '..')));
                            $total_count = count($_FILES['file_d_3']['name']);
                            $fileExistsArr = array();
                            for ($i = 0; $i < $total_count; $i++) {
                                $tmpFilePath = $_FILES['file_d_3']['tmp_name'][$i];
                                $fname = $_FILES['file_d_3']['name'][$i];
                                //echo 'Valid File Name : ' . $fname . '<br/><br/>';
                                $extension = pathinfo($fname, PATHINFO_EXTENSION);
                                if (in_array(strtolower($extension), array('pdf'))) {
                                    if (in_array($fname, $dbRollNos)) {
                                        //check for file exist
                                        $dbfile = ('dossiers_documents/' . $auto_id . '/' . $fname);
                                        if (file_exists($dbfile)) {
                                            $fileExistsArr1 = array(
                                                'index' => $i,
                                                'filename' => $fname
                                            );
                                            array_push($fileExistsArr, $fileExistsArr1);
                                        } else {
                                            if ($tmpFilePath != "") {
                                                $newFilePath = 'dossiers_documents/' . $auto_id . '/pdf/' . $fname;
                                                if (!is_dir($targetDir)) {
                                                    mkdir($targetDir, 0777, true);
                                                }
                                                //File is uploaded to temp dir
                                                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                                                    //Other code goes here
                                                    $successUploadFile .= "<li>" . $fname . " uploaded </li>";
                                                } else {
                                                    $notUploadedFile .= "<li>" . $fname . " not uploaded </li>";
                                                }
                                            }
                                        }
                                    } else {
                                        $invalidFile .= "<li>" . $fname . " invalid file name </li>";
                                    }
                                } else {
                                    $invalidFile .= "<li>" . $fname . " invalid file format </li>";
                                }
                            }
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => $successUploadFile . $notUploadedFile . $invalidFile));
                        } else {
                            $this->session->set_flashdata('message', 'No record found!');
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'No record found!'));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Recommended details list not found. Please add some recommended detail list!'));
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

    function draftDossiersList() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $res = loadMenus();
                    $data['id'] = $id;
                    $data['files'] = NULL;
                    $targetDir = "dossiers_documents/" . $id . "/pdf/";
                    $dF = glob($targetDir . "*.pdf");
                    if (count($dF) > 0) {
                        $allFiles = scandir($targetDir);
                        $files = array_diff($allFiles, array('.', '..'));
                        if ($files != NULL) {
                            $data['files'] = $files;
                        }
                    }
                    $data['targetDir'] = $targetDir;
                    $rollNosDraft = $this->recommendedDraft->selectDetailsModel('roll_no', array('inbox_requi_auto_id' => $id));
                    $data['rollNosDraft'] = $rollNosDraft;
                    $resp = $this->load->view('pages/' . $res . '/list_draft_dossiers', $data, TRUE);
                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'draftDossiersListHTML' => $resp));
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

    function downloadDossier() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            $this->load->helper('download');
            $fname = trim($this->security->xss_clean($this->input->get("fname")));
            $id = trim($this->security->xss_clean($this->input->get("id")));
            $fileUrl = 'dossiers_documents/' . $id . '/pdf/' . $fname;
            $data = file_get_contents(base_url($fileUrl));
            force_download($fname, $data);
        } else {
            $this->session->set_flashdata('message', 'Un-authorized access!');
            redirect(base_url('skillTest/logOut'));
        }
    }

    function deleteDraftDossier() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('fname', 'File Name', 'trim|required|max_length[220]|min_length[1]');
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $fname = trim($this->security->xss_clean($this->input->post('fname')));
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $targetDir = "dossiers_documents/" . $id . "/pdf/";
                    $filename = $targetDir . $fname;
                    if (file_exists($filename)) {
                        if (!unlink($filename)) {
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "$fname cannot be deleted due to an error"));
                        } else {
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "$fname has been deleted"));
                        }
                    } else {
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "The file $fname does not exist"));
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
