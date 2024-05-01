<?php

class RecommendedFinal extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RecommendedFinalModel', 'recommendedFinal', TRUE);
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
    }

    function ajax_recc_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD', 'UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $inbox_requi_id = trim($this->security->xss_clean($this->input->post("inbox_requi_id")));
                $list = $this->recommendedFinal->list_databales(array('inbox_requi_auto_id' => $inbox_requi_id));
                $count_rec = $this->recommendedFinal->list_filtered(array('inbox_requi_auto_id' => $inbox_requi_id));
                $data = array();
                $no = $_POST['start'];
                if ($list != NULL) {
                    foreach ($list as $accrow) {
                        $doc_link = '<a title="Document File" class="btn btn-outline-danger btn-xs" href="javascript:vpid(0)" onclick=viewFile("' . base_url($accrow->dossier_link) . '")><i class="fa fa-file-pdf"></i> Dossier </a>&nbsp;';
                        $olDossier = '';
                        $alDossier = '';

                        $no ++;
                        $row = array();
                        $row[] = $no;

                        $iol_flag = $accrow->iol_flag;
                        $uol_flag = $accrow->uol_flag;
                        $uol_dossier = $accrow->uol_dossier;
                        $ial_flag = $accrow->ial_flag;
                        $ual_flag = $accrow->ual_flag;
                        $ual_dossier = $accrow->ual_dossier;

                        $iolF = '<i class="fa fa-times text-danger"></i>';
                        $uolF = '<i class="fa fa-times text-danger"></i>';
                        $ialF = '<i class="fa fa-times text-danger"></i>';
                        $ualF = '<i class="fa fa-times text-danger"></i>';

                        if ($iol_flag == 1 && $uol_flag == 0 && $ial_flag == 0 && $ual_flag == 0) {
                            $iolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->iol_datetime, 0, 10);
                        } else if ($iol_flag == 1 && $uol_flag == 1 && $ial_flag == 0 && $ual_flag == 0) {
                            $iolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->iol_datetime, 0, 10);
                            $uolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->uol_datetime, 0, 10);
                            $olDossier = '<a title="Offer Letter" class="btn btn-outline-success btn-xs" href="javascript:vpid(0)" onclick=viewFile("' . base_url($uol_dossier) . '")><i class="fa fa-file-pdf"></i> OL </a>&nbsp;';
                        } else if ($iol_flag == 1 && $uol_flag == 1 && $ial_flag == 1 && $ual_flag == 0) {
                            $iolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->iol_datetime, 0, 10);
                            $uolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->uol_datetime, 0, 10);
                            $ialF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->ial_datetime, 0, 10);
                            $olDossier = '<a title="Offer Letter" class="btn btn-outline-success btn-xs" href="javascript:vpid(0)" onclick=viewFile("' . base_url($uol_dossier) . '")><i class="fa fa-file-pdf"></i> OL </a>&nbsp;';
                        } else if ($iol_flag == 1 && $uol_flag == 1 && $ial_flag == 1 && $ual_flag == 1) {
                            $iolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->iol_datetime, 0, 10);
                            $uolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->uol_datetime, 0, 10);
                            $ialF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->ial_datetime, 0, 10);
                            $ualF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->ual_datetime, 0, 10);
                            $olDossier = '<a title="Offer Letter" class="btn btn-outline-success btn-xs" href="javascript:vpid(0)" onclick=viewFile("' . base_url($uol_dossier) . '")><i class="fa fa-file-pdf"></i> OL </a>&nbsp;';
                            $alDossier = '<a title="Offer Letter" class="btn btn-outline-info btn-xs" href="javascript:vpid(0)" onclick=viewFile("' . base_url($ual_dossier) . '")><i class="fa fa-file-pdf"></i> AL </a>&nbsp;';
                        }
                        $row[] = $iolF;
                        $row[] = $uolF;
                        $row[] = $ialF;
                        $row[] = $ualF;
                        $row[] = $accrow->roll_no;
                        $row[] = strtoupper($accrow->full_name);
                        $row[] = $accrow->dob;
                        $row[] = strtoupper($accrow->father_name);
                        $row[] = $accrow->category_allot;
                        $row[] = $olDossier . $alDossier . $doc_link;
                        $data[] = $row;
                    }
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, "recordsTotal" => $count_rec, "recordsFiltered" => $count_rec, "data" => $data);
                    echo json_encode($output);
                } else {
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => array());
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

    function ajax_user_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $inbox_requi_id = trim($this->security->xss_clean($this->input->post("inbox_requi_id")));
                $list = $this->recommendedFinal->list_databales(array('inbox_requi_auto_id' => $inbox_requi_id));
                $count_rec = $this->recommendedFinal->list_filtered(array('inbox_requi_auto_id' => $inbox_requi_id));
                $data = array();
                $no = $_POST['start'];
                if ($list != NULL) {
                    foreach ($list as $accrow) {
                        $uploadOL = '';
                        $issueAL = '';
                        $uploadAL = '';
                        $doc_link = '<a title="Document File" class="btn btn-outline-danger btn-xs" href="javascript:vpid(0)" onclick=viewFile("' . base_url($accrow->dossier_link) . '")><i class="fa fa-file-pdf"></i> Dossier </a>&nbsp;';
                        $olDossier = '';
                        $alDossier = '';

                        $no ++;
                        $row = array();
                        $row[] = $no;

                        $iol_flag = $accrow->iol_flag;
                        $uol_flag = $accrow->uol_flag;
                        $uol_dossier = $accrow->uol_dossier;
                        $ial_flag = $accrow->ial_flag;
                        $ual_flag = $accrow->ual_flag;
                        $ual_dossier = $accrow->ual_dossier;

                        $iolF = '<i class="fa fa-times text-danger"></i>';
                        $uolF = '<i class="fa fa-times text-danger"></i>';
                        $ialF = '<i class="fa fa-times text-danger"></i>';
                        $ualF = '<i class="fa fa-times text-danger"></i>';

                        if ($iol_flag == 0 && $uol_flag == 0 && $ial_flag == 0 && $ual_flag == 0) {
                            $iolF = '<input type="checkbox">';
                        } else if ($iol_flag == 1 && $uol_flag == 0 && $ial_flag == 0 && $ual_flag == 0) {
                            $iolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->iol_datetime, 0, 10);
                            $uploadOL = '<a title="Upload Offer Letter" class="btn btn-outline-info btn-xs" href="javascript:vpid()" onclick=showFileUpload("' . $accrow->roll_no . '")><i class="fa fa-upload"></i> UOL </a>&nbsp;';
                        } else if ($iol_flag == 1 && $uol_flag == 1 && $ial_flag == 0 && $ual_flag == 0) {
                            $iolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->iol_datetime, 0, 10);
                            $uolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->uol_datetime, 0, 10);
                            $olDossier = '<a title="Offer Letter" class="btn btn-outline-success btn-xs" href="javascript:vpid(0)" onclick=viewFile("' . base_url($uol_dossier) . '")><i class="fa fa-file-pdf"></i> OL </a>&nbsp;';
                            $issueAL = '<a title="Issue Appointment Letter" class="btn btn-outline-success btn-xs" href="javascript:vpid(0)" onclick=issueAppointmentLetterModal("' . $accrow->roll_no . '")><i class="fa fa-file-text"></i> IAL </a>&nbsp;';
                        } else if ($iol_flag == 1 && $uol_flag == 1 && $ial_flag == 1 && $ual_flag == 0) {
                            $iolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->iol_datetime, 0, 10);
                            $uolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->uol_datetime, 0, 10);
                            $ialF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->ial_datetime, 0, 10);
                            $olDossier = '<a title="Offer Letter" class="btn btn-outline-success btn-xs" href="javascript:vpid(0)" onclick=viewFile("' . base_url($uol_dossier) . '")><i class="fa fa-file-pdf"></i> OL </a>&nbsp;';
                            $uploadAL = '<a title="Upload Appointment Letter" class="btn btn-outline-info btn-xs" href="javascript:vpid()" onclick=showFileUploadAL("' . $accrow->roll_no . '")><i class="fa fa-upload"></i> UAL </a>&nbsp;';
                        } else if ($iol_flag == 1 && $uol_flag == 1 && $ial_flag == 1 && $ual_flag == 1) {
                            $iolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->iol_datetime, 0, 10);
                            $uolF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->uol_datetime, 0, 10);
                            $ialF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->ial_datetime, 0, 10);
                            $ualF = '<i class="fa fa-check text-success"></i> ' . reverseDateTime($accrow->ual_datetime, 0, 10);
                            $olDossier = '<a title="Offer Letter" class="btn btn-outline-success btn-xs" href="javascript:vpid(0)" onclick=viewFile("' . base_url($uol_dossier) . '")><i class="fa fa-file-pdf"></i> OL </a>&nbsp;';
                            $alDossier = '<a title="Offer Letter" class="btn btn-outline-info btn-xs" href="javascript:vpid(0)" onclick=viewFile("' . base_url($ual_dossier) . '")><i class="fa fa-file-pdf"></i> AL </a>&nbsp;';
                        }
                        $row[] = $iolF;
                        $row[] = $uolF;
                        $row[] = $ialF;
                        $row[] = $ualF;
                        $row[] = $accrow->roll_no;
                        $row[] = strtoupper($accrow->full_name);
                        $row[] = $accrow->dob;
                        $row[] = strtoupper($accrow->father_name);
                        $row[] = $accrow->category_allot;
                        $row[] = $uploadOL . $olDossier . $alDossier . $doc_link . $issueAL . $uploadAL;
                        $data[] = $row;
                    }
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, "recordsTotal" => $count_rec, "recordsFiltered" => $count_rec, "data" => $data);
                    echo json_encode($output);
                } else {
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => array());
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

    function finalRecommendedList() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $res = loadMenus();
                    $data['id'] = $id;
                    $resp = $this->load->view('pages/' . $res . '/list_final_recommended', $data, TRUE);
                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'finalRecommendedListHTML' => $resp));
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

    function finalRecommendedListView() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD', 'UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $res = loadMenus();
                    $data['id'] = $id;
                    $resp = $this->load->view('pages/' . $res . '/list_final_recommended_view', $data, TRUE);
                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'finalRecommendedListHTML' => $resp));
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

    function issueOfferLetter() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('roll_nos[]', 'Roll Nos', 'trim|required|integer|max_length[7]|min_length[7]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $roll_nos = $this->security->xss_clean($this->input->post('roll_nos'));
                    $mData = $this->requiInbox->selectDetailsModel('auto_id', array('auto_id' => $auto_id, 'action_taken' => 'RECOMMENDED'));
                    $this->db->trans_start();
                    if ($mData != NULL) {
                        foreach ($roll_nos as $key => $value) {
                            $chkRollNo = $this->recommendedFinal->selectDetailsModel('auto_id', array('inbox_requi_auto_id' => $auto_id, 'roll_no' => $value, 'iol_flag' => 0));
                            if ($chkRollNo != NULL) {
                                $this->recommendedFinal->updateDetailsModel(array('inbox_requi_auto_id' => $auto_id, 'roll_no' => $value), array('iol_flag' => 1, 'iol_datetime' => date('Y-m-d H:i:s'), 'iol_user' => $userid));
                            }
                        }
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Offer letter issued successfully'));
                    } else {
                        $this->session->set_flashdata('message', 'Record not found');
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'No record found!'));
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

    function uploadOfferLetter() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('inbox_auto_id', 'ID', 'trim|required|integer|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('roll_no', 'Roll No', 'trim|required|integer|max_length[7]|min_length[7]');
                $this->form_validation->set_rules('file_copy_d_3', 'Upload file(in excel file)', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post("inbox_auto_id")));
                    $roll_no = trim($this->security->xss_clean($this->input->post("roll_no")));
                    $mData = $this->requiInbox->selectDetailsModel('auto_id', array('auto_id' => $auto_id, 'action_taken' => 'RECOMMENDED'));
                    $this->db->trans_start();
                    if ($mData != NULL) {
                        $chkRollNo = $this->recommendedFinal->selectDetailsModel('auto_id', array('inbox_requi_auto_id' => $auto_id, 'roll_no' => $roll_no, 'iol_flag' => 1, 'uol_flag' => 0));
                        if ($chkRollNo != NULL) {
                            $targetDir = 'offer_letter_documents/' . $auto_id . '/' . $roll_no;
                            $file_nError = FALSE;
                            $file_nMsg = "";
                            $filename_n = "";
                            $dossier_link = "";
                            if (isset($_FILES['file_d_3']) && $_FILES['file_d_3']['size'] > 0) {
                                $fileName = basename($_FILES['file_d_3']['name']);
                                $filename_n = $roll_no . '.pdf';
                                $fileUrl = $targetDir . '/' . $filename_n;
                                $allowTypes = array('pdf');
                                $targetFilePath = $targetDir . '/' . $fileName;
                                $dossier_link = $fileUrl;
                                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                                if (in_array($fileType, $allowTypes)) {
                                    if (!is_dir($targetDir)) {
                                        mkdir($targetDir, 0777, true);
                                    }
                                    if (move_uploaded_file($_FILES['file_d_3']['tmp_name'], $fileUrl)) {
                                        $file_nError = FALSE;
                                        $file_nMsg = "";
                                    } else {
                                        $file_nError = TRUE;
                                        $file_nMsg = "Something went wrong. Unable to upload file";
                                    }
                                } else {
                                    $file_nError = TRUE;
                                    $file_nMsg = "Invalid relevant orders file format";
                                }
                            }
                            if ($file_nError == FALSE) {
                                if ($this->recommendedFinal->updateDetailsModel(array('inbox_requi_auto_id' => $auto_id, 'roll_no' => $roll_no), array('uol_flag' => 1, 'uol_datetime' => date('Y-m-d H:i:s'), 'uol_dossier' => $dossier_link, 'uol_user' => $userid))) {
                                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Document uploaded successfully'));
                                } else {
                                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to upload document!'));
                                }
                            } else {
                                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $file_nMsg));
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Invalid Roll No!'));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'No record found!'));
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

    function issueAppointmentLetter() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('inbox_auto_id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('roll_no', 'Roll Nos', 'trim|required|integer|max_length[7]|min_length[7]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post('inbox_auto_id')));
                    $roll_no = $this->security->xss_clean($this->input->post('roll_no'));
                    $mData = $this->requiInbox->selectDetailsModel('auto_id', array('auto_id' => $auto_id, 'action_taken' => 'RECOMMENDED'));
                    $this->db->trans_start();
                    if ($mData != NULL) {
                        $chkRollNo = $this->recommendedFinal->selectDetailsModel('auto_id', array('inbox_requi_auto_id' => $auto_id, 'roll_no' => $roll_no, 'iol_flag' => 1, 'uol_flag' => 1, 'ial_flag' => 0, 'ual_flag' => 0));
                        if ($chkRollNo != NULL) {
                            $this->recommendedFinal->updateDetailsModel(array('inbox_requi_auto_id' => $auto_id, 'roll_no' => $roll_no), array('ial_flag' => 1, 'ial_datetime' => date('Y-m-d H:i:s'), 'ial_user' => $userid));
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Appointment letter issued successfully'));
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'No record found!'));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'No record found!'));
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

    function uploadAppointmentLetter() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('inbox_auto_id', 'ID', 'trim|required|integer|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('roll_no', 'Roll No', 'trim|required|integer|max_length[7]|min_length[7]');
                $this->form_validation->set_rules('file_copy_a_3', 'Upload file(in excel file)', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post("inbox_auto_id")));
                    $roll_no = trim($this->security->xss_clean($this->input->post("roll_no")));
                    $mData = $this->requiInbox->selectDetailsModel('auto_id', array('auto_id' => $auto_id, 'action_taken' => 'RECOMMENDED'));
                    $this->db->trans_start();
                    if ($mData != NULL) {
                        $chkRollNo = $this->recommendedFinal->selectDetailsModel('auto_id', array('inbox_requi_auto_id' => $auto_id, 'roll_no' => $roll_no, 'iol_flag' => 1, 'uol_flag' => 1, 'ial_flag' => 1, 'ual_flag' => 0));
                        if ($chkRollNo != NULL) {
                            $targetDir = 'appointment_letter_documents/' . $auto_id . '/' . $roll_no;
                            $file_nError = FALSE;
                            $file_nMsg = "";
                            $filename_n = "";
                            $dossier_link = "";
                            if (isset($_FILES['file_a_3']) && $_FILES['file_a_3']['size'] > 0) {
                                $fileName = basename($_FILES['file_a_3']['name']);
                                $filename_n = $roll_no . '.pdf';
                                $fileUrl = $targetDir . '/' . $filename_n;
                                $allowTypes = array('pdf');
                                $targetFilePath = $targetDir . '/' . $fileName;
                                $dossier_link = $fileUrl;
                                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                                if (in_array($fileType, $allowTypes)) {
                                    if (!is_dir($targetDir)) {
                                        mkdir($targetDir, 0777, true);
                                    }
                                    if (move_uploaded_file($_FILES['file_a_3']['tmp_name'], $fileUrl)) {
                                        $file_nError = FALSE;
                                        $file_nMsg = "";
                                    } else {
                                        $file_nError = TRUE;
                                        $file_nMsg = "Something went wrong. Unable to upload file";
                                    }
                                } else {
                                    $file_nError = TRUE;
                                    $file_nMsg = "Invalid relevant orders file format";
                                }
                            }
                            if ($file_nError == FALSE) {
                                if ($this->recommendedFinal->updateDetailsModel(array('inbox_requi_auto_id' => $auto_id, 'roll_no' => $roll_no), array('ual_flag' => 1, 'ual_datetime' => date('Y-m-d H:i:s'), 'ual_dossier' => $dossier_link, 'ual_user' => $userid))) {
                                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Document uploaded successfully'));
                                } else {
                                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to upload document!'));
                                }
                            } else {
                                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $file_nMsg));
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Invalid Roll No!'));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'No record found!'));
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
