<?php

class RecommendedDraft extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RecommendedDraftModel', 'recommendedDraft', TRUE);
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

    function ajax_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $inbox_requi_id = trim($this->security->xss_clean($this->input->post("inbox_requi_id")));
                $totalRecc = $this->requiInbox->selectDetailsRowModel('(rec_ur + rec_apst + rec_pwd + rec_ex_sm) as total_recc', array('auto_id' => $inbox_requi_id));
                $rollNosDraft = $this->recommendedDraft->selectDetailsModel('roll_no', array('inbox_requi_auto_id' => $inbox_requi_id));

                $dbRollNos = array();
                if ($rollNosDraft != NULL) {
                    foreach ($rollNosDraft as $rRow) {
                        $dbRollNos[] = $rRow->roll_no . '.pdf';
                    }
                }
                $validDossiers = array();
                $targetDir = "dossiers_documents/" . $inbox_requi_id . "/pdf/";
                $dF = glob($targetDir . "*.pdf");
                if (count($dF) > 0) {
                    $allFiles = scandir($targetDir);
                    $files = array_diff($allFiles, array('.', '..'));
                    if ($files != NULL) {
                        $validDossiers = array_intersect($dbRollNos, $files);
                    }
                }

                $list = $this->recommendedDraft->list_databales(array('inbox_requi_auto_id' => $inbox_requi_id));
                $count_rec = $this->recommendedDraft->list_filtered(array('inbox_requi_auto_id' => $inbox_requi_id));
                $data = array();
                $no = $_POST['start'];
                if ($list != NULL) {
                    foreach ($list as $accrow) {
                        //$edit = '<a title="Edit Details" class="btn btn-outline-info btn-xs" href="javascript:vpid()" onclick=editDetails("' . $accrow->auto_id . '")><i class="fas fa-pencil-alt"></i>  </a>&nbsp;';
                        $delete = '<a title="Delete Record" class="btn btn-outline-danger btn-xs" href="javascript:vpid(0)" onclick="deleteDetail(' . $accrow->auto_id . ')"><i class="fa fa-trash"></i></a>&nbsp;';
                        $doc_link = '<a title="Document File" class="btn btn-outline-danger btn-xs" href="javascript:vpid(0)" onclick=viewFile("' . base_url($accrow->dossier_link) . '")><i class="fa fa-file-pdf"></i> Dossier </a>&nbsp;';
                        $no ++;
                        $row = array();
                        $row[] = $no;
                        $row[] = $accrow->roll_no;
                        $row[] = strtoupper($accrow->full_name);
                        $row[] = reverseDate($accrow->dob);
                        $row[] = strtoupper($accrow->father_name);
                        $row[] = $accrow->category_allot;
                        $row[] = $accrow->is_pwd;
                        $row[] = $accrow->is_ex_sm;
                        $row[] = $doc_link . $delete;
                        $data[] = $row;
                    }
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, "recordsTotal" => $count_rec, "recordsFiltered" => $count_rec, "data" => $data, "nosDraftRecord" => count($rollNosDraft), 'totalRecc' => $totalRecc->total_recc, 'validDossiers' => count($validDossiers), 'dbRollNos' => $dbRollNos);
                    echo json_encode($output);
                } else {
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => array(), "nosDraftRecord" => count($rollNosDraft), 'totalRecc' => $totalRecc->total_recc, 'validDossiers' => count($validDossiers), 'dbRollNos' => $dbRollNos);
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

    function addDraftRecommendedForm() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $mData = $this->requiInbox->selectDataForAddReccRowModel('req.auto_id,org.org_name,dept.dept_name,req.officer_name,desig.desig_name,req.contact_no,req.officer_email,pp.post_name,req.a_group,req.b_pay_scale,req.c_mode_recruitment,req.d_ur,req.d_apst,req.d_total,req.d_pwd,req.d_ex_sm,req.e_total,req.rec_ur,req.rec_apst,req.rec_pwd,req.rec_ex_sm,(req.rec_ur + req.rec_apst + req.rec_pwd + req.rec_ex_sm) as total_rec', array('req.auto_id' => $id, 'req.action_taken' => 'ADVERTISED'));
                    if ($mData != NULL) {
                        $res = loadMenus();
                        $data['mData'] = $mData;
                        $data['id'] = $id;
                        $resp = $this->load->view('pages/' . $res . '/add_recommended_form', $data, TRUE);
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'draftRecommendedHTML' => $resp));
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'No record found!'));
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

    function saveDraftRecommendedForm() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('rec_auto_id', 'ID', 'trim|required|integer|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('full_name', 'Full name', 'trim|required|max_length[65]|min_length[2]');
                $this->form_validation->set_rules('roll_no', 'Roll no', 'trim|required|integer|max_length[7]|min_length[7]');
                $this->form_validation->set_rules('dob', 'DOB', 'trim|required|max_length[10]|min_length[10]');
                $this->form_validation->set_rules('father_name', 'Father name', 'trim|required|max_length[65]|min_length[2]');
                $this->form_validation->set_rules('category_allot', 'Category Allot', 'trim|required|max_length[4]|min_length[2]');
                $this->form_validation->set_rules('is_pwd', 'Select PwD', 'trim|required|max_length[1]|min_length[1]');
                $this->form_validation->set_rules('is_ex_sm', 'Select Ex-SM', 'trim|required|max_length[1]|min_length[1]');
                $this->form_validation->set_rules('file_copy_n_3', 'Upload dossier file(in pdf file)', 'trim');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $req_auto_id = trim($this->security->xss_clean($this->input->post("rec_auto_id")));
                    $full_name = trim($this->security->xss_clean($this->input->post("full_name")));
                    $roll_no = trim($this->security->xss_clean($this->input->post("roll_no")));
                    $dob = trim($this->security->xss_clean($this->input->post("dob")));
                    $father_name = trim($this->security->xss_clean($this->input->post("father_name")));
                    $category_allot = trim($this->security->xss_clean($this->input->post("category_allot")));
                    $is_pwd = trim($this->security->xss_clean($this->input->post("is_pwd")));
                    $is_ex_sm = trim($this->security->xss_clean($this->input->post("is_ex_sm")));

                    $totalRec = $this->requiInbox->selectDetailsRowModel('(rec_ur + rec_apst + rec_pwd + rec_ex_sm) as total_rec', array('auto_id' => $req_auto_id));
                    $nosDraftRecord = $this->recommendedDraft->selectDetailsRowModel('COUNT(auto_id) as total_draft', array('inbox_requi_auto_id' => $req_auto_id));

                    if ($nosDraftRecord->total_draft < $totalRec->total_rec) {
                        $resp = $this->recommendedDraft->selectDetailsRowModel('auto_id', array('inbox_requi_auto_id' => $req_auto_id, 'roll_no' => $roll_no));
                        if ($resp == NULL) {
                            $this->db->trans_start();
                            $targetDir = 'dossiers_documents/' . $req_auto_id . '/pdf';
                            $file_nError = FALSE;
                            $file_nMsg = "";
                            $filename_n = "";
                            $dossier_link = $targetDir . '/' . $roll_no . '.pdf';
                            if (isset($_FILES['file_n_3']) && $_FILES['file_n_3']['size'] > 0) {
                                $fileName = basename($_FILES['file_n_3']['name']);
                                $filename_n = $roll_no . '.pdf';
                                $fileUrl = $targetDir . '/' . $filename_n;
                                $allowTypes = array('pdf');
                                $targetFilePath = $targetDir . '/' . $fileName;
                                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                                if (in_array($fileType, $allowTypes)) {
                                    if (!is_dir($targetDir)) {
                                        mkdir($targetDir, 0777, true);
                                    }
                                    if (move_uploaded_file($_FILES['file_n_3']['tmp_name'], $fileUrl)) {
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

                            if ($dob != "") {
                                $dob = trim(str_replace('/', '-', $dob));
                            }
                            $reccMappedData = array(
                                'inbox_requi_auto_id' => $req_auto_id,
                                'full_name' => trim($full_name),
                                'roll_no' => trim($roll_no),
                                'dob' => reverseDate($dob),
                                'father_name' => trim($father_name),
                                'category_allot' => trim($category_allot),
                                'is_pwd' => trim($is_pwd),
                                'is_ex_sm' => $is_ex_sm,
                                'dossier_link' => $dossier_link,
                                'entry_datetime' => date('Y-m-d H:i:s'),
                                'sys_ip' => $this->input->ip_address(),
                                'entry_user' => $userid
                            );

                            if ($file_nError == FALSE) {
                                if ($this->recommendedDraft->saveDetailsModel($reccMappedData)) {
                                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Details added successfully'));
                                } else {
                                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to add record!'));
                                }
                            } else {
                                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $file_nMsg));
                            }

                            $this->db->trans_complete();
                            if ($this->db->trans_status() === FALSE) {
                                $this->db->trans_rollback();
                                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Something went wrong. Please try again'));
                            } else {
                                $this->db->trans_commit();
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Roll number already exist!'));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to add details. The number of recommended candidates cannot be greater than the total number of recommended!'));
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

    function importDraftRecommendedData() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('rec_auto_id_excel', 'ID', 'trim|required|integer|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('file_copy_o_3', 'Upload file(in excel file)', 'trim|required');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post("rec_auto_id_excel")));
                    $mData = $this->requiInbox->selectDetailsRowModel('auto_id,(rec_ur + rec_apst + rec_pwd + rec_ex_sm) as total_rec', array('auto_id' => $auto_id, 'action_taken' => 'ADVERTISED'));
                    $this->db->trans_start();
                    $result = FALSE;
                    $importFlag = FALSE;
                    $errorMsg = "Something went wrong! Please re-upload";
                    if ($mData != NULL) {
                        $this->load->library('excel');
                        $targetDir = 'dossiers_documents/' . $auto_id . '/excel';
                        $targetDirPdf = 'dossiers_documents/' . $auto_id . '/pdf';
                        $file_oError = FALSE;
                        $file_oMsg = "";
                        $filename_o = "";
                        $fileUrl = "";
                        if (isset($_FILES['file_o_3']) && $_FILES['file_o_3']['size'] > 0) {
                            $fileName = basename($_FILES['file_o_3']['name']);
                            $filename_o = date("dmY_his") . '.xls';
                            $fileUrl = $targetDir . '/' . $filename_o;
                            $allowTypes = array('xlsx', 'xls');
                            $targetFilePath = $targetDir . '/' . $fileName;
                            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                            if (in_array($fileType, $allowTypes)) {
                                if (!is_dir($targetDir)) {
                                    mkdir($targetDir, 0777, true);
                                }
                                if (move_uploaded_file($_FILES['file_o_3']['tmp_name'], $fileUrl)) {
                                    $file_oError = FALSE;
                                    $file_oMsg = "";
                                } else {
                                    $file_oError = TRUE;
                                    $file_oMsg = "Something went wrong. Unable to upload file";
                                }
                            } else {
                                $file_oError = TRUE;
                                $file_oMsg = "Invalid file format";
                            }
                        }
                        if ($file_oError == FALSE) {
                            $inputFileName = $fileUrl;
                            try {
                                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                                $objPHPExcel = $objReader->load($inputFileName);
                                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                                $i = 0;
                                $j = 0;
                                $totalRec = $mData->total_rec;
                                $rollNosDraft = $this->recommendedDraft->selectDetailsModel('roll_no', array('inbox_requi_auto_id' => $auto_id));
                                if ($rollNosDraft != NULL) {
                                    $excelRollNos = array();
                                    $dbRollNos = array();
                                    foreach ($allDataInSheet as $value) {
                                        if ($j > 0) {
                                            $roll_no = trim($value['B']);
                                            if ($roll_no != "") {
                                                $excelRollNos[] = $roll_no;
                                            }
                                        }
                                        $j++;
                                    }
                                    foreach ($rollNosDraft as $rRow) {
                                        $dbRollNos[] = $rRow->roll_no;
                                    }
                                    $unqRollNos = array_values(array_diff($excelRollNos, $dbRollNos));
                                    if (count($unqRollNos) == 0) {
                                        if (count($allDataInSheet) > ($totalRec + 1)) {
                                            $importFlag = FALSE;
                                            $errorMsg = 'Unable to import details. The number of recommended candidates cannot be greater than the total number of recommended!';
                                        } else {
                                            $importFlag = TRUE;
                                            $errorMsg = "";
                                        }
                                    } else if (count($unqRollNos) > 0) {
                                        if ((count($unqRollNos) + count($rollNosDraft)) > $totalRec) {
                                            $importFlag = FALSE;
                                            $errorMsg = 'Unable to import details. The number of recommended candidates cannot be greater than the total number of recommended!';
                                        } else {
                                            $importFlag = TRUE;
                                            $errorMsg = "";
                                        }
                                    }
                                    /*
                                      else {
                                      $result = TRUE;
                                      $errorMsg = "";
                                      }
                                     * 
                                     */
                                } else {
                                    if (count($allDataInSheet) > ($totalRec + 1)) {
                                        $importFlag = FALSE;
                                        $errorMsg = 'Unable to import details. The number of recommended candidates cannot be greater than the total number of recommended!';
                                    } else {
                                        $importFlag = TRUE;
                                        $errorMsg = "";
                                    }
                                }

                                if ($importFlag) {
                                    foreach ($allDataInSheet as $value) {
                                        $roll_no = trim($value['B']);
                                        if ($i > 0) {
                                            if ($roll_no != "") {
                                                $dob = trim($value['C']);
                                                if ($dob != "") {
                                                    $dob = trim(str_replace('/', '-', $dob));
                                                }

                                                $dossier_link = trim($value['H']);
                                                $reccMappedData = array(
                                                    'inbox_requi_auto_id' => $auto_id,
                                                    'full_name' => trim($value['A']),
                                                    'roll_no' => $roll_no,
                                                    'dob' => reverseDate($dob),
                                                    'father_name' => trim($value['D']),
                                                    'category_allot' => trim($value['E']),
                                                    'is_pwd' => trim($value['F']),
                                                    'is_ex_sm' => trim($value['G']),
                                                    'dossier_link' => $targetDirPdf . '/' . $dossier_link,
                                                    'entry_datetime' => date('Y-m-d H:i:s'),
                                                    'sys_ip' => $this->input->ip_address(),
                                                    'entry_user' => $userid
                                                );
                                                $resp = $this->recommendedDraft->selectDetailsModel('auto_id', array('inbox_requi_auto_id' => $auto_id, 'roll_no' => $roll_no));
                                                if ($resp != NULL) {
                                                    //update
                                                    if ($this->recommendedDraft->updateDetailsModel(array('inbox_requi_auto_id' => $auto_id, 'roll_no' => $roll_no), $reccMappedData)) {
                                                        $result = TRUE;
                                                    } else {
                                                        $result = FALSE;
                                                    }
                                                } else {
                                                    //add
                                                    if ($this->recommendedDraft->saveDetailsModel($reccMappedData)) {
                                                        $result = TRUE;
                                                    } else {
                                                        $result = FALSE;
                                                    }
                                                }
                                            }
                                        }
                                        $i++;
                                    }
                                }

                                if ($result) {
                                    //echo "Imported successfully";
                                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Data imported successfully!'));
                                } else {
                                    //echo "ERROR !";
                                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $errorMsg));
                                }
                            } catch (Exception $e) {
                                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $file_oMsg));
                        }
                    } else {
                        $this->session->set_flashdata('message', 'No record found!');
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

    function draftRecommendedList() {
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
                    $resp = $this->load->view('pages/' . $res . '/list_draft_recommended', $data, TRUE);
                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'draftRecommendedListHTML' => $resp));
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

    function deleteData() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'Field', 'trim|required|regex_match[/^[0-9]+$/i]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $this->db->trans_start();
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $resp = $this->recommendedDraft->selectDetailsModel('auto_id,dossier_link', array('auto_id' => $auto_id));
                    if ($resp != NULL) {
                        $doclink = "";
                        foreach ($resp as $rrow) {
                            $doclink = $rrow->dossier_link;
                            break;
                        }
                        $delRes = $this->recommendedDraft->deleteDetailsModel($auto_id);
                        if ($delRes) {
                            if ($doclink != "") {
                                if (file_exists($doclink)) {
                                    unlink($doclink);
                                }
                            }
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Record deleted successfully'));
                        } else {
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => $delRes));
                        }
                    } else {
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "No record found!"));
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

    function sendRecommendedToDepartment() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'Field', 'trim|required|regex_match[/^[0-9]+$/i]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $this->db->trans_start();
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $mData = $this->requiInbox->selectDetailsRowModel('auto_id,(rec_ur + rec_apst + rec_pwd + rec_ex_sm) as total_rec', array('auto_id' => $auto_id, 'action_taken' => 'ADVERTISED'));
                    if ($mData != NULL) {
                        $rollNosDraft = $this->recommendedDraft->selectDetailsModel('roll_no', array('inbox_requi_auto_id' => $auto_id));
                        $totalRecc = $mData->total_rec;
                        $dbRollNos = array();
                        if ($rollNosDraft != NULL) {
                            foreach ($rollNosDraft as $rRow) {
                                $dbRollNos[] = $rRow->roll_no . '.pdf';
                            }
                        }
                        $validDossiers = array();
                        $targetDir = "dossiers_documents/" . $auto_id . "/pdf/";
                        $dF = glob($targetDir . "*.pdf");
                        if (count($dF) > 0) {
                            $allFiles = scandir($targetDir);
                            $files = array_diff($allFiles, array('.', '..'));
                            if ($files != NULL) {
                                $validDossiers = array_intersect($dbRollNos, $files);
                            }
                        }

                        if ($totalRecc == count($rollNosDraft) && $totalRecc == count($validDossiers)) {
                            //update
                            if ($this->requiInbox->updateDetailsModel(array('auto_id' => $auto_id), array('action_taken' => 'RECOMMENDED', 'rec_sent_to_dept_flag' => 'F', 'action_taken_user' => $userid, 'action_datetime' => date('Y-m-d H:i:s'), 'recommended_datetime' => date('Y-m-d H:i:s'), 'recommended_user' => $userid))) {
                                $this->recommendedDraft->sendRecommendedToDepartmentModel(array('inbox_requi_auto_id' => $auto_id));
                                echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "Recommended sent successfully!"));
                            } else {
                                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "Unable to update the record!"));
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "The number of dossier files or number of recommended candidate lists cannot be less than the total recommended vacancy!"));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "No record found!"));
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
