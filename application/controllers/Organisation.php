<?php

class Organisation extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('DepartmentModel', 'department', TRUE);
        $this->load->model('OrganisationModel', 'organisation', TRUE);
        $this->load->model('UserModel', 'user', TRUE);
        $this->load->model('RequiModel', 'requi', TRUE);
    }

    function index() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['mainmenu'] = "requisitions";
        $data['submenu'] = "org";
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $data['csrf'] = random_strings();
            $data['deptName'] = $this->department->selectDetailsModel('auto_id,dept_name', array());
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/list_organisation');
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function ajax_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $list = $this->organisation->list_databales(array());
                $count_rec = $this->organisation->list_filtered(array());

                $data = array();
                $no = $_POST['start'];
                if ($list != NULL) {
                    foreach ($list as $accrow) {
                        $edit = '<a title="Edit Details" class="btn btn-outline-info btn-xs" href="javascript:void()" onclick=editDetails("' . $accrow->auto_id . '")><i class="fas fa-pencil-alt"></i>  </a>&nbsp;';
                        $delete = '<a title="Delete Record" class="btn btn-outline-danger btn-xs" href="javascript:void(0)" onclick="deleteDetail(' . $accrow->auto_id . ')"><i class="fa fa-trash"></i></a>&nbsp;';
                        $no ++;
                        $row = array();
                        $row[] = $no;
                        $row[] = strtoupper($accrow->org_name);
                        $row[] = strtoupper($accrow->dept_name);
                        $row[] = strtoupper($accrow->dept_address);
                        $row[] = $edit . $delete;
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

    function saveChanges() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $add_update = trim($this->security->xss_clean($this->input->post("add_update")));
                $this->form_validation->set_rules('org_name', 'Organisation name is required', 'trim|required|max_length[65]|min_length[1]');
                $this->form_validation->set_rules('dept_id', 'Department name is required', 'trim|required|integer|max_length[11]|min_length[1]');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $org_name = ($this->security->xss_clean($this->input->post("org_name")));
                    $dept_id = trim($this->security->xss_clean($this->input->post("dept_id")));
                    $this->db->trans_start();
                    if ($add_update == 'add') {
                        $details = $this->organisation->selectDetailsModel('org_name', array('dept_id' => $dept_id, 'org_name' => $org_name));
                        $data = array(
                            'dept_id' => $dept_id,
                            'org_name' => trim(strtoupper($org_name)),
                            'entry_datetime' => date('Y-m-d H:i:s'),
                            'entry_by' => $userid,
                            'sys_ip' => $this->input->ip_address()
                        );
                        if ($details == NULL) {
                            $this->organisation->saveDetailsModel($data);
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Details added successfully!'));
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Organisation name is already exist!'));
                        }
                    }

                    if ($add_update == 'update') {
                        // $this->session->set_userdata('oid', $data->auto_id);
                        // $this->session->set_userdata('did', $data->dept_id);
                        // $this->session->set_userdata('oname', $data->org_name);

                        $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                        if (preg_match('/^\d+$/D', $auto_id) && $auto_id == $this->session->userdata('oid')) {
                            $data = array(
                                'dept_id' => $dept_id,
                                'org_name' => trim(strtoupper($org_name)),
                                'last_update_datetime' => date('Y-m-d H:i:s'),
                                'sys_ip' => $this->input->ip_address()
                            );

                            if ($this->session->userdata('oname') != $org_name) {
                                $details = $this->organisation->selectDetailsModel('dept_id', array('dept_id' => $dept_id, 'org_name' => trim($org_name)));
                                if ($details == NULL) {
                                    $this->organisation->updateDetailsModel(array('auto_id' => $auto_id), $data);
                                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Details updates successfully!'));
                                } else {
                                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Organisation name is already exist!'));
                                }
                            } else {
                                if ($this->session->userdata('oname') == $org_name) {
                                    $this->organisation->updateDetailsModel(array('auto_id' => $auto_id), $data);
                                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Details updates successfully!'));
                                } else {
                                    $details = $this->organisation->selectDetailsModel('org_name', array('org_name' => trim($org_name)));
                                    if ($details == NULL) {
                                        $this->organisation->updateDetailsModel(array('auto_id' => $auto_id), $data);
                                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Details updates successfully!'));
                                    } else {
                                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Organisation name is already exist!'));
                                    }
                                }
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid ID!'));
                        }
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

    function getData() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'Field', 'trim|required|regex_match[/^[0-9]+$/i]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $data = $this->organisation->selectDetailsRowModel('auto_id,dept_id,org_name', array('auto_id' => $id));
                    if ($data != null) {
                        $this->session->set_userdata('oid', $data->auto_id);
                        $this->session->set_userdata('did', $data->dept_id);
                        $this->session->set_userdata('oname', $data->org_name);
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => "", 'result' => $data));
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => "No record found"));
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

    function deleteData() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'Field', 'trim|required|regex_match[/^[0-9]+$/i]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'msg' => validation_errors()));
                } else {
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $this->organisation->deleteDetailsModel($auto_id);
                    echo json_encode(array('status' => TRUE, 'msg' => 'Record deleted successfully'));
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

    function loadOrgName() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('dept_id', 'Department name', 'trim|required|min_length[1]|max_length[11]|regex_match[/^[0-9]+$/i]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $dept_id = trim($this->security->xss_clean($this->input->post('dept_id')));
                    $data = $this->organisation->selectDetailsModel('auto_id,org_name', array('dept_id' => $dept_id));
                    if ($data != NULL) {
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'result' => $data));
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'result' => array()));
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

    function loadMultiOrgName() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('dept_id[]', 'Department name', 'trim|max_length[11]|regex_match[/^[0-9]+$/i]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $depts = $this->input->post('dept_id');
                    if (count($depts) >= 1) {
                        $dept_string = array();
                        foreach ($depts as $key => $value) {
                            $dept_string[] = $value;
                        }
                        $depts_separated = implode(",", $dept_string);
                        $str_arr = explode(",", $depts_separated);
                        $data = $this->organisation->selectInDetailsModel('auto_id,org_name', $str_arr);
                        if ($data != NULL) {
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'result' => $data));
                        } else {
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'result' => array()));
                        }
                    } else {
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'result' => array()));
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

    function loadOrganisation() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('dept_id', 'Department name', 'trim|required|min_length[1]|max_length[11]|regex_match[/^[0-9]+$/i]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
            } else {
                $dept_id = trim($this->security->xss_clean($this->input->post('dept_id')));
                $data = $this->organisation->selectDetailsModel('auto_id,org_name', array('dept_id' => $dept_id));
                if ($data != NULL) {
                    echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'result' => $data));
                } else {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'result' => array()));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

    function userMappOrg() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('dept_id', 'Department name', 'trim|required|min_length[1]|max_length[11]|regex_match[/^[0-9]+$/i]');
                $this->form_validation->set_rules('user_id', 'Username', 'trim|required|min_length[1]|max_length[11]|regex_match[/^[0-9]+$/i]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $dept_id = trim($this->security->xss_clean($this->input->post('dept_id')));
                    $user_id = trim($this->security->xss_clean($this->input->post('user_id')));
                    $data = $this->user->getUserMappOrgModel($user_id, 'org.auto_id,org.org_name,mpp.org_id,mpp.status_flag', array('org.dept_id' => $dept_id));
                    if ($data != NULL) {
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'result' => $data));
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'result' => array()));
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
