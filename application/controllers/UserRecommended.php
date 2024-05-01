<?php

class UserRecommended extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserRecommendedModel', 'userRecommended', TRUE);
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

    function index() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['mainmenu'] = "requisitions";
        $data['submenu'] = "userRecommended";
        if ($userid != "" && in_array($role, array('UR'))) {
            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $data['csrf'] = random_strings();
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/list_user_recommended');
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function ajax_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['submenu'] = "userRecommended";
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $list = $this->userRecommended->list_databales(array('req.action_taken' => 'RECOMMENDED', 'req.entry_user' => $userid, 'rec_sent_to_dept_flag' => 'F'));
                $count_rec = $this->userRecommended->list_filtered(array('req.action_taken' => 'RECOMMENDED', 'req.entry_user' => $userid, 'rec_sent_to_dept_flag' => 'F'));

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

                        $statusSpan = '<span class="badge badge-primary">RECOMMENDED</span>';

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
                        $row[] = date("d-m-Y", strtotime($accrow->recommended_datetime));
                        $row[] = ($accrow->d_ur + $accrow->d_apst);
                        $row[] = ($accrow->rec_ur + $accrow->rec_apst);
                        $row[] = $preview . $previewPdf;
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

    function viewRecommendedData() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $mData = $this->requiInbox->select2ndFromCompData('req.auto_id,org.org_name,dept.dept_name,req.officer_name,desig.desig_name,req.contact_no,req.officer_email,pp.post_name,req.a_group,req.b_pay_scale,req.c_mode_recruitment,req.d_ur,req.d_apst,req.d_total,req.d_pwd,req.d_ex_sm,req.e_blindness,req.e_deaf,req.e_locomotor,req.e_autism,req.e_multiple,req.e_total,req.f_vac_worked_out,req.g_edu_others,req.h_min_age,req.h_max_age,req.i_apst,req.i_pwd_apst,req.i_pwd_ur,req.i_ex_sm_apst,req.i_ex_sm_ur,req.j_ban_restric,req.file_copy_k_rr,req.l_other_requi_cond,req.file_copy_l_ro,req.m_criteria_eligibility_post,req.m_criteria_eligibility,req.file_copy_n_list_cands,req.file_copy_o_list_cands,req.seen_flag,req.action_taken,req.action_datetime,req.entry_datetime,req.sent_datetime,req.seen_by_dept,req.action_remarks,pem.eligibility,req.rec_ur,req.rec_apst,req.rec_pwd,req.rec_ex_sm', array('req.auto_id' => $id, 'req.action_taken' => 'RECOMMENDED', 'req.entry_user' => $userid, 'rec_sent_to_dept_flag' => 'F'));
                    if ($mData != NULL) {
                        $res = loadMenus();
                        $data['mData'] = $mData;
                        $data['id'] = $id;
                        $this->requiInbox->updateDetailsModel(array('auto_id' => $id), array('seen_flag' => 1, 'seen_datetime' => date('Y-m-d H:i:s'), 'seen_user' => $userid));
                        $resp = $this->load->view('pages/' . $res . '/view_recommended_details', $data, TRUE);
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

}
