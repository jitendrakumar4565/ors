<?php

class RequiAdvertised extends CI_Controller {

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
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['mainmenu'] = "requisitions";
        $data['submenu'] = "requiAdvertised";
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $data['csrf'] = random_strings();
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/list_advertised_requi');
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function ajax_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['submenu'] = "requiAdvertised";
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $list = $this->requiAdvertised->list_databales(array('req.action_taken' => 'ADVERTISED'));
                $count_rec = $this->requiAdvertised->list_filtered(array('req.action_taken' => 'ADVERTISED'));

                $data = array();
                $no = $_POST['start'];
                if ($list != NULL) {
                    foreach ($list as $accrow) {
                        $preview = '<a title="View Details" class="btn btn-outline-info btn-xs" href="javascript:void(0)" onclick=previewRecord("' . $accrow->auto_id . '")><i class="fas fa-eye"></i>  </a>&nbsp;';
                        $previewPdf = '<a title="View Details" class="btn btn-outline-danger btn-xs" href="javascript:void(0)" onclick=previewPdfRecord("' . $accrow->auto_id . '")><i class="fa fa-file-pdf-o"></i>  </a>&nbsp;';

                        $modeSpan = '<span class="badge badge-danger">LDCE</span>';
                        $modeRec = $accrow->c_mode_recruitment;
                        if ($modeRec == 'D') {
                            $modeSpan = '<span class="badge badge-success">DIRECT</span>';
                        }
                        $actionTaken = $accrow->action_taken;
                        $statusSpan = '<span class="badge badge-primary">ADVERTISED</span>';
                        $darftRecommendedForm = "";
                        if (in_array($actionTaken, array('ADVERTISED'))) {
                            $darftRecommendedForm = '<a title="Draft Recommended Form" class="btn btn-outline-primary btn-xs" href="javascript:void(0)" onclick=addDraftRecommended("' . $accrow->auto_id . '")><i class="fa fa-thumbs-up"></i> Recommended </a>&nbsp;';
                        }
                        $no ++;
                        $row = array();
                        $row[] = $no;
                        $row[] = strtoupper($accrow->org_name);
                        $row[] = strtoupper($accrow->dept_name);
                        $row[] = strtoupper($accrow->post_name);
                        $row[] = strtoupper($accrow->officer_name);
                        $row[] = strtoupper($accrow->desig_name);
                        $row[] = $modeSpan;
                        $row[] = $statusSpan;
                        $row[] = date("d-m-Y", strtotime($accrow->advertised_date));
                        $row[] = $preview . $previewPdf . $darftRecommendedForm;
                        $data[] = $row;
                    }
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, "recordsTotal" => $count_rec, "recordsFiltered" => $count_rec, "data" => $data);
                    echo json_encode($output);
                } else {
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => array());
                    echo json_encode($output);
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

    function fillPostAdvertised() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('vf_auto_id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('rec_ur', 'Unreserved', 'trim|required|max_length[5]|min_length[1]');
                $this->form_validation->set_rules('rec_apst', 'APST', 'trim|required|max_length[5]|min_length[1]');
                $this->form_validation->set_rules('rec_pwd', 'PwD', 'trim|required|max_length[5]|min_length[1]');
                $this->form_validation->set_rules('rec_ex_sm', 'Ex-SM', 'trim|required|max_length[5]|min_length[1]');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post('vf_auto_id')));
                    $rec_ur = trim($this->security->xss_clean($this->input->post('rec_ur')));
                    $rec_apst = trim($this->security->xss_clean($this->input->post('rec_apst')));
                    $rec_pwd = trim($this->security->xss_clean($this->input->post('rec_pwd')));
                    $rec_ex_sm = trim($this->security->xss_clean($this->input->post('rec_ex_sm')));
                    $mData = $this->requiInbox->selectDetailsRowModel('auto_id,d_ur,d_apst,d_pwd,d_ex_sm', array('auto_id' => $auto_id, 'action_taken' => 'ADVERTISED'));
                    $this->db->trans_start();
                    if ($mData != NULL) {
                        $errorFlag = FALSE;
                        $errorMsg = "";
                        $dur = $mData->d_ur;
                        $dapst = $mData->d_apst;
                        $dpwd = $mData->d_pwd;
                        $dexsm = $mData->d_ex_sm;
                        $totalRec = ($rec_ur + $rec_apst + $rec_pwd + $rec_ex_sm);
                        if ($rec_ur > $dur) {
                            $errorFlag = TRUE;
                            $errorMsg .= "<li>Unreserved recommended cannot be greater than " . $dur . "</li>";
                        }
                        if ($rec_apst > $dapst) {
                            $errorFlag = TRUE;
                            $errorMsg .= "<li>APST recommended cannot be greater than " . $dapst . "</li>";
                        }
                        if ($rec_pwd > $dpwd) {
                            $errorFlag = TRUE;
                            $errorMsg .= "<li>PwD recommended cannot be greater than " . $dpwd . "</li>";
                        }
                        if ($rec_ex_sm > $dexsm) {
                            $errorFlag = TRUE;
                            $errorMsg .= "<li>Ex-SM recommended cannot be greater than " . $dexsm . "</li>";
                        }

                        if ($errorFlag) {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $errorMsg));
                        } else {
                            $nosDraftRecord = $this->recommendedDraft->selectDetailsRowModel('COUNT(auto_id) as total_draft', array('inbox_requi_auto_id' => $auto_id));
                            if ($totalRec >= $nosDraftRecord->total_draft) {
                                $this->requiInbox->updateDetailsModel(array('auto_id' => $auto_id), array('action_taken' => 'ADVERTISED', 'rec_ur' => $rec_ur, 'rec_apst' => $rec_apst, 'rec_pwd' => $rec_pwd, 'rec_ex_sm' => $rec_ex_sm, 'rec_sent_to_dept_flag' => 'D'));
                                echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Details updated successfully'));
                            } else {
                                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to update the details. The number of recommended candidates cannot be greater than the total number of recommended!'));
                            }
                        }
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

}
