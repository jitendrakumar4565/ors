<?php

class RequiInbox extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RequiInboxModel', 'requiInbox', TRUE);
        $this->load->model('RequiModel', 'requi', TRUE);
        $this->load->model('OrganisationModel', 'organisation', TRUE);
        $this->load->model('DepartmentModel', 'department', TRUE);
        $this->load->model('DesignationModel', 'designation', TRUE);
        $this->load->model('PostNameModel', 'postName', TRUE);
        $this->load->model('GroupNameModel', 'groupName', TRUE);
        $this->load->model('PayScaleModel', 'payScale', TRUE);
        $this->load->model('ModeRecruitModel', 'modeRecruit', TRUE);
    }

    function index() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['mainmenu'] = "requisitions";
        $data['submenu'] = "requiInbox";
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $data['csrf'] = random_strings();
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/list_inbox');
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function ajax_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['submenu'] = "requiInbox";
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $list = $this->requiInbox->list_databales(array());
                $count_rec = $this->requiInbox->list_filtered(array());

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

                        $statusSpan = '<span class="badge badge-danger">PENDING</span>';
                        $actionTaken = $accrow->action_taken;
                        if ($actionTaken == 'ACCEPTED') {
                            $statusSpan = '<span class="badge badge-success">ACCEPTED</span>';
                        } else if ($actionTaken == 'RETURNED') {
                            $statusSpan = '<span class="badge badge-info">RETURNED</span>';
                        } else if ($actionTaken == 'ADVERTISED') {
                            $statusSpan = '<span class="badge badge-primary">ADVERTISED</span>';
                        } else if ($actionTaken == 'RECOMMENDED') {
                            $statusSpan = '<span class="badge badge-primary">RECOMMENDED</span>';
                        }

                        $pullBack = "";
                        if ($accrow->seen_by_dept == 0 && in_array($actionTaken, array('ACCEPTED', 'RETURNED'))) {
                            $pullBack = '<a title="Pull Back" class="btn btn-outline-danger btn-xs" href="javascript:void(0)" onclick=pullBack("' . $accrow->auto_id . '")><i class="fa fa-arrow-circle-o-left"></i>  </a>&nbsp;';
                        }

                        $bold = "font-weight-bold";
                        if ($accrow->seen_flag == 1) {
                            $bold = "";
                        }

                        $no ++;
                        $row = array();
                        $row[] = '<span class="' . $bold . '">' . $no . '</span>';
                        $row[] = '<span class="' . $bold . '">' . strtoupper($accrow->org_name) . '</span>';
                        $row[] = '<span class="' . $bold . '">' . strtoupper($accrow->dept_name) . '</span>';
                        $row[] = '<span class="' . $bold . '">' . strtoupper($accrow->post_name) . '</span>';
                        $row[] = '<span class="' . $bold . '">' . strtoupper($accrow->officer_name) . '</span>';
                        $row[] = '<span class="' . $bold . '">' . strtoupper($accrow->desig_name) . '</span>';
                        $row[] = $modeSpan;
                        $row[] = $statusSpan;
                        $row[] = '<span class="' . $bold . '">' . date("d-m-Y g:i A", strtotime($accrow->sent_datetime)) . '</span>';
                        $row[] = $preview . $previewPdf . $pullBack;
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

    function printInbox() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $type = trim($this->security->xss_clean($this->input->post('type')));
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $mData = $this->requiInbox->select2ndFromCompData('req.auto_id,org.org_name,dept.dept_name,req.officer_name,desig.desig_name,req.contact_no,req.officer_email,pp.post_name,req.a_group,req.b_pay_scale,req.c_mode_recruitment,req.d_ur,req.d_apst,req.d_total,req.d_pwd,req.d_ex_sm,req.e_blindness,req.e_deaf,req.e_locomotor,req.e_autism,req.e_multiple,req.e_total,req.f_vac_worked_out,req.g_edu_others,req.h_min_age,req.h_max_age,req.i_apst,req.i_pwd_apst,req.i_pwd_ur,req.i_ex_sm_apst,req.i_ex_sm_ur,req.j_ban_restric,req.file_copy_k_rr,req.l_other_requi_cond,req.file_copy_l_ro,req.m_criteria_eligibility_post,req.m_criteria_eligibility,req.file_copy_n_list_cands,req.file_copy_o_list_cands,req.seen_flag,req.action_taken,req.action_datetime,req.entry_datetime,req.sent_datetime,req.action_remarks,pem.eligibility', array('req.auto_id' => $id));
                    if ($mData != NULL) {
                        $constructor = [
                            'mode' => '',
                            'format' => 'A4', //[190, 135]
                            'default_font_size' => 0,
                            'default_font' => '',
                            'margin_left' => 5,
                            'margin_right' => 5,
                            'margin_top' => 10,
                            'margin_bottom' => 10,
                            'margin_header' => 6,
                            'margin_footer' => 6,
                            'orientation' => 'P',
                            'pagenumPrefix' => '',
                            'pagenumSuffix' => '',
                            'nbpgPrefix' => '',
                            'nbpgSuffix' => '',
                            'tempDir' => __DIR__ . '/custom/temp/dir/path'
                        ];
                        $data['mData'] = $mData;
                        $res = loadMenus();
                        $this->requiInbox->updateDetailsModel(array('auto_id' => $id), array('seen_flag' => 1, 'seen_datetime' => date('Y-m-d H:i:s'), 'seen_user' => $userid));
                        $mpdf = new \Mpdf\Mpdf($constructor);
                        $footer = '<div style="font-size:8px;text-align:right;padding-right:30px;margin-top:-11px;">Page : {PAGENO} / {nb}</div>';
                        $epass_header = $this->load->view('pages/' . $res . '/print_inbox_details', $data, TRUE);
                        $mpdf->SetHTMLFooter($footer);
                        $mpdf->WriteHTML($epass_header);
                        $mpdf->Output('vendor/temp_pdf/' . $id . '.pdf');
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'fileUrl' => base_url('vendor/temp_pdf/' . $id . '.pdf')));
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

    function viewData() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $mData = $this->requiInbox->select2ndFromCompData('req.auto_id,org.org_name,dept.dept_name,req.officer_name,desig.desig_name,req.contact_no,req.officer_email,pp.post_name,req.a_group,req.b_pay_scale,req.c_mode_recruitment,req.d_ur,req.d_apst,req.d_total,req.d_pwd,req.d_ex_sm,req.e_blindness,req.e_deaf,req.e_locomotor,req.e_autism,req.e_multiple,req.e_total,req.f_vac_worked_out,req.g_edu_others,req.h_min_age,req.h_max_age,req.i_apst,req.i_pwd_apst,req.i_pwd_ur,req.i_ex_sm_apst,req.i_ex_sm_ur,req.j_ban_restric,req.file_copy_k_rr,req.l_other_requi_cond,req.file_copy_l_ro,req.m_criteria_eligibility_post,req.m_criteria_eligibility,req.file_copy_n_list_cands,req.file_copy_o_list_cands,req.seen_flag,req.action_taken,req.action_datetime,req.entry_datetime,req.sent_datetime,req.seen_by_dept,req.action_remarks,pem.eligibility', array('req.auto_id' => $id));
                    if ($mData != NULL) {
                        $res = loadMenus();
                        $data['mData'] = $mData;
                        $data['id'] = $id;
                        $this->requiInbox->updateDetailsModel(array('auto_id' => $id), array('seen_flag' => 1, 'seen_datetime' => date('Y-m-d H:i:s'), 'seen_user' => $userid));
                        $resp = $this->load->view('pages/' . $res . '/view_inbox_details', $data, TRUE);
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'previewDetailsHTML' => $resp));
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

    function approveRequi() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('status', 'Status', 'trim|required|max_length[1]|min_length[1]');
                $this->form_validation->set_rules('remarks', 'Remarks', 'trim|max_length[255]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $this->db->trans_start();
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $status = trim($this->security->xss_clean($this->input->post('status')));
                    $remarks = trim($this->security->xss_clean($this->input->post('remarks')));
                    if (in_array($status, array('A', 'R'))) {
                        $action_taken = "RETURNED";
                        if ($status == 'A') {
                            $action_taken = "ACCEPTED";
                        }
                        $mData = $this->requiInbox->selectDetailsModel('auto_id', array('auto_id' => $auto_id, 'action_taken' => 'PENDING'));
                        if ($mData != NULL) {
                            if ($status == "A") {
                                $this->requiInbox->updateDetailsModel(array('auto_id' => $auto_id), array('action_taken' => $action_taken, 'action_remarks' => $remarks, 'action_taken_user' => $userid, 'action_datetime' => date('Y-m-d H:i:s'), 'seen_flag' => 1, 'seen_by_dept' => 0, 'accept_user' => $userid, 'accept_datetime' => date('Y-m-d H:i:s')));
                                //$accpData = $this->requiInbox->updateAcceptedListModel(array('auto_id' => $auto_id));
                                echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Accepted successfully'));
                            }
                            if ($status == "R") {
                                $this->requiInbox->updateDetailsModel(array('auto_id' => $auto_id), array('action_taken' => $action_taken, 'action_remarks' => $remarks, 'action_taken_user' => $userid, 'action_datetime' => date('Y-m-d H:i:s'), 'seen_flag' => 1, 'seen_by_dept' => 0, 'returned_user' => $userid, 'returned_datetime' => date('Y-m-d H:i:s')));
                                //$returnData = $this->requiInbox->updateReturnedListModel(array('auto_id' => $auto_id));
                                echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Returned successfully'));
                            }
                        } else {
                            $this->session->set_flashdata('message', 'Session Expired!');
                            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'You are not authorized to perform these operation!'));
                        }
                    } else {
                        $this->session->set_flashdata('message', 'Invalid request!');
                        echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
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

    function pullBackSentForm() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $mData = $this->requiInbox->selectTemp2ndFormDetails('auto_id,seen_by_dept,action_taken', array('auto_id' => $auto_id));
                    $seenFlag = 0;
                    $actionFlag = 'ACCEPTED';
                    $this->db->trans_start();
                    if ($mData != NULL) {
                        foreach ($mData as $mRow) {
                            $seenFlag = $mRow->seen_by_dept;
                            $actionFlag = $mRow->action_taken;
                        }
                        if ($seenFlag == 0) {
                            if ($this->requiInbox->pullBackFormModel(array('auto_id' => $auto_id), array('action_taken' => 'PENDING', 'pull_back_datetime' => date('Y-m-d H:i:s'), 'pull_back_user' => $userid), $actionFlag)) {
                                echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Pullback successfully'));
                            } else {
                                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to restore the record!'));
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Already seen by the user. Unable to pull back'));
                        }
                    } else {
                        $this->session->set_flashdata('message', 'Session Expired!');
                        echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'You are not authorized to perform these operation!'));
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

    function postAdvertised() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('adv_date', 'Advertised Date', 'trim|required|max_length[10]|min_length[10]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $adv_date = trim($this->security->xss_clean($this->input->post('adv_date')));
                    $mData = $this->requiInbox->selectDetailsModel('auto_id', array('auto_id' => $auto_id, 'action_taken' => 'ACCEPTED'));
                    $this->db->trans_start();
                    if ($mData != NULL) {
                        $this->requiInbox->updateDetailsModel(array('auto_id' => $auto_id), array('action_taken' => 'ADVERTISED', 'advertised_date' => cusDate($adv_date), 'advertised_datetime' => date('Y-m-d H:i:s'), 'advertised_user' => $userid));
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Post advertised successfully'));
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
