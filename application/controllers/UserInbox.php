<?php

class UserInbox extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserInboxModel', 'userInbox', TRUE);
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
        $data['submenu'] = "userInbox";
        if ($userid != "" && in_array($role, array('UR'))) {
            $res = loadMenus();
            $data['csrf'] = random_strings();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/list_user_inbox');
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function ajax_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['submenu'] = "userInbox";
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $list = $this->userInbox->list_databales(array('req.action_taken IN("ACCEPTED","RETURNED","ADVERTISED","RECOMMENDED")  AND req.entry_user = ' => $userid, 'req.seen_flag' => 1, 'move_to_draft' => 0));
                $count_rec = $this->userInbox->list_filtered(array('req.action_taken IN("ACCEPTED","RETURNED","ADVERTISED","RECOMMENDED") AND req.entry_user =' => $userid, 'req.seen_flag' => 1, 'move_to_draft' => 0));

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

                        $moveToDraft = "";
                        if ($accrow->seen_flag == 1 && in_array($actionTaken, array('R'))) {
                            $moveToDraft = '<a title="Move to draft" class="btn btn-outline-danger btn-xs" href="javascript:void(0)" onclick=moveToDraft("' . $accrow->auto_id . '")><i class="fa fa-arrow-circle-o-right"></i>  </a>&nbsp;';
                        }

                        $bold = "font-weight-bold";
                        if ($accrow->seen_by_dept == 1) {
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
                        $row[] = $preview . $previewPdf . $moveToDraft;
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
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $mData = $this->userInbox->select2ndFromCompData('req.auto_id,org.org_name,dept.dept_name,req.officer_name,desig.desig_name,req.contact_no,req.officer_email,pp.post_name,req.a_group,req.b_pay_scale,req.c_mode_recruitment,req.d_ur,req.d_apst,req.d_total,req.d_pwd,req.d_ex_sm,req.e_blindness,req.e_deaf,req.e_locomotor,req.e_autism,req.e_multiple,req.e_total,req.f_vac_worked_out,req.g_edu_others,req.h_min_age,req.h_max_age,req.i_apst,req.i_pwd_apst,req.i_pwd_ur,req.i_ex_sm_apst,req.i_ex_sm_ur,req.j_ban_restric,req.file_copy_k_rr,req.l_other_requi_cond,req.file_copy_l_ro,req.m_criteria_eligibility_post,req.m_criteria_eligibility,req.file_copy_n_list_cands,req.file_copy_o_list_cands,req.seen_flag,req.action_taken,req.action_datetime,req.entry_datetime,req.sent_datetime,req.action_remarks,pem.eligibility', array('req.auto_id' => $id, 'req.action_taken IN("ACCEPTED","RETURNED","ADVERTISED","RECOMMENDED")  AND req.entry_user =' => $userid, 'req.seen_flag' => 1));
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
                        $this->userInbox->updateDetailsModel(array('auto_id' => $id), array('seen_by_dept' => 1));
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
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $mData = $this->userInbox->select2ndFromCompData('req.auto_id,org.org_name,dept.dept_name,req.officer_name,desig.desig_name,req.contact_no,req.officer_email,pp.post_name,req.a_group,req.b_pay_scale,req.c_mode_recruitment,req.d_ur,req.d_apst,req.d_total,req.d_pwd,req.d_ex_sm,req.e_blindness,req.e_deaf,req.e_locomotor,req.e_autism,req.e_multiple,req.e_total,req.f_vac_worked_out,req.g_edu_others,req.h_min_age,req.h_max_age,req.i_apst,req.i_pwd_apst,req.i_pwd_ur,req.i_ex_sm_apst,req.i_ex_sm_ur,req.j_ban_restric,req.file_copy_k_rr,req.l_other_requi_cond,req.file_copy_l_ro,req.m_criteria_eligibility_post,req.m_criteria_eligibility,req.file_copy_n_list_cands,req.file_copy_o_list_cands,req.seen_flag,req.action_taken,req.action_datetime,req.entry_datetime,req.sent_datetime,req.seen_by_dept,req.action_remarks,pem.eligibility', array('req.auto_id' => $id, 'req.action_taken IN("ACCEPTED","RETURNED","ADVERTISED","RECOMMENDED")  AND req.entry_user =' => $userid, 'req.seen_flag' => 1));
                    if ($mData != NULL) {
                        $res = loadMenus();
                        $data['mData'] = $mData;
                        $data['id'] = $id;
                        $this->userInbox->updateDetailsModel(array('auto_id' => $id), array('seen_by_dept' => 1));
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

    function moveToDraftForm() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $mData = $this->userInbox->selectTemp2ndFormDetails('auto_id', array('auto_id' => $auto_id, 'action_taken IN("RETURNED")  AND entry_user =' => $userid, 'seen_flag' => 1));
                    $this->db->trans_start();
                    if ($mData != NULL) {
                        if ($this->userInbox->moveToDraftFormModel(array('auto_id' => $auto_id))) {
                            $this->userInbox->updateDetailsModel(array('auto_id' => $auto_id, 'entry_user' => $userid), array('move_to_draft' => 1));
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Move to draft successfully'));
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to copy as draft!'));
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

}
