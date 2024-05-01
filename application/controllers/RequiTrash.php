<?php

class RequiTrash extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RequiTrashModel', 'requiTrash', TRUE);
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
        $data['submenu'] = "requiTrash";
        if ($userid != "" && in_array($role, array('UR'))) {
            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $data['csrf'] = random_strings();
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/list_trashs');
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function ajax_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['submenu'] = "requiTrash";
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $list = $this->requiTrash->list_databales(array('entry_user' => $userid));
                $count_rec = $this->requiTrash->list_filtered(array('entry_user' => $userid));

                $data = array();
                $no = $_POST['start'];
                if ($list != NULL) {
                    foreach ($list as $accrow) {
                        $preview = '<a title="View Details" class="btn btn-outline-info btn-xs" href="javascript:void(0)" onclick=previewRecord("' . $accrow->auto_id . '")><i class="fas fa-eye"></i>  </a>&nbsp;';
                        $delete = '<a title="Delete Record" class="btn btn-outline-danger btn-xs" href="javascript:void(0)" onclick=deleteRecord("' . $accrow->auto_id . '")><i class="fa fa-trash-o"></i>  </a>&nbsp;';
                        $restore = '<a title="Restore to draft" class="btn btn-outline-danger btn-xs" href="javascript:void(0)" onclick=restoreRecord("' . $accrow->auto_id . '")><i class="fa fa fa-refresh"></i>  </a>&nbsp;';

                        $modeSpan = '<span class="badge badge-danger">LDCE RECRUITMENT</span>';
                        $modeRec = $accrow->c_mode_recruitment;
                        if ($modeRec == 'D') {
                            $modeSpan = '<span class="badge badge-success">DIRECT RECRUITMENT</span>';
                        }

                        $no ++;
                        $row = array();
                        $row[] = $no;
                        $row[] = strtoupper($accrow->org_name);
                        $row[] = strtoupper($accrow->dept_name);
                        $row[] = strtoupper($accrow->post_name);
                        $row[] = $modeSpan;
                        $row[] = date("d-m-Y g:i A", strtotime($accrow->entry_datetime));
                        $row[] = $preview . $delete . $restore;
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

    function deleteTempTrash() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'AutoId', 'trim|required|integer|max_length[7]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $mData = $this->requiTrash->selectTemp2ndFormDetails('auto_id', array('auto_id' => $auto_id, 'entry_user' => $userid));
                    if ($mData != NULL) {
                        if ($this->requiTrash->deleteTempRequiModel(array('auto_id' => $auto_id))) {
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Record deleted successfully'));
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to delete record!'));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'You are not authorized to perform these operation!'));
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
                $this->form_validation->set_rules('auto_id', 'Auto ID', 'trim|required|max_length[11]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $autoId = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $mData = $this->requiTrash->select2ndFromCompData('mm.auto_id,org.org_name,dept.dept_name,mm.officer_name,desig.desig_name,mm.contact_no,mm.officer_email,pp.post_name,mm.a_group,mm.b_pay_scale,mm.c_mode_recruitment,mm.d_ur,mm.d_apst,mm.d_total,mm.d_pwd,mm.d_ex_sm,mm.e_blindness,mm.e_deaf,mm.e_locomotor,mm.e_autism,mm.e_multiple,mm.e_total,mm.f_vac_worked_out,mm.g_edu_others,mm.h_min_age,mm.h_max_age,mm.i_apst,mm.i_pwd_apst,mm.i_pwd_ur,mm.i_ex_sm_apst,mm.i_ex_sm_ur,mm.j_ban_restric,mm.file_copy_k_rr,mm.l_other_requi_cond,mm.file_copy_l_ro,mm.m_criteria_eligibility,mm.m_criteria_eligibility_post,mm.m_criteria_eligibility,mm.file_copy_n_list_cands,mm.file_copy_o_list_cands,pem.eligibility', array('mm.auto_id' => $autoId, 'mm.entry_user' => $userid));
                    if ($mData != NULL) {
                        $res = loadMenus();
                        $data['mData'] = $mData;
                        $data['auto_id'] = $autoId;
                        $resp = $this->load->view('pages/' . $res . '/view_trash_details', $data, TRUE);
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

    function restoreFormData() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'AutoId', 'trim|required|integer|max_length[7]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $this->db->trans_start();
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $mData = $this->requiTrash->selectTemp2ndFormDetails('auto_id', array('auto_id' => $auto_id, 'entry_user' => $userid));
                    if ($mData != NULL) {
                        if ($this->requiTrash->restoreFormDataModel(array('auto_id' => $auto_id))) {
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Restore successfully'));
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to restore the record!'));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'You are not authorized to perform these operation!'));
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
