<?php

class Designation extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('DesignationModel', 'designation', TRUE);
        $this->load->model('RequiModel', 'requi', TRUE);
    }

    function index() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['mainmenu'] = "requisitions";
        $data['submenu'] = "designation";
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $data['csrf'] = random_strings();
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar',$data);
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/list_designation');
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
                $list = $this->designation->list_databales(array());
                $count_rec = $this->designation->list_filtered(array());
                $data = array();
                $no = $_POST['start'];
                if ($list != NULL) {
                    foreach ($list as $accrow) {
                        $edit = '<a title="Edit Details" class="btn btn-outline-info btn-xs" href="javascript:void()" onclick=editDetails("' . $accrow->auto_id . '")><i class="fas fa-pencil-alt"></i>  </a>&nbsp;';
                        $delete = '<a title="Delete Record" class="btn btn-outline-danger btn-xs" href="javascript:void(0)" onclick="deleteDetail(' . $accrow->auto_id . ')"><i class="fa fa-trash"></i></a>&nbsp;';
                        $no ++;
                        $row = array();
                        $row[] = $no;
                        $row[] = strtoupper($accrow->desig_name);
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
                $this->form_validation->set_rules('desig_name', 'Designation name is required', 'trim|required|max_length[65]|min_length[2]');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'msg' => validation_errors()));
                } else {
                    $desig_name = trim($this->security->xss_clean($this->input->post("desig_name")));
                    $this->db->trans_start();
                    if ($add_update == 'add') {
                        $details = $this->designation->selectDetailsModel('desig_name', array('desig_name' => trim($desig_name)));
                        $data = array(
                            'desig_name' => trim(strtoupper($desig_name)),
                            'entry_datetime' => date('Y-m-d H:i:s'),
                            'entry_by' => $userid,
                            'sys_ip' => $this->input->ip_address()
                        );
                        if ($details == NULL) {
                            $this->designation->saveDetailsModel($data);
                            echo json_encode(array('status' => TRUE, 'msg' => 'Details added successfully!'));
                        } else {
                            echo json_encode(array('status' => FALSE, 'msg' => 'Designation name is already exist!'));
                        }
                    }

                    if ($add_update == 'update') {
                        $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                        if (preg_match('/^\d+$/D', $auto_id) && $auto_id == $this->session->userdata('oid')) {
                            $data = array(
                                'desig_name' => trim(strtoupper($desig_name)),
                                'last_update_datetime' => date('Y-m-d H:i:s'),
                                'sys_ip' => $this->input->ip_address()
                            );

                            if ($this->session->userdata('oname') != $desig_name) {
                                $details = $this->designation->selectDetailsModel('desig_name', array('desig_name' => trim($desig_name)));
                                if ($details == NULL) {
                                    $this->designation->updateDetailsModel(array('auto_id' => $auto_id), $data);
                                    echo json_encode(array('status' => TRUE, 'msg' => 'Details updates successfully!'));
                                } else {
                                    echo json_encode(array('status' => FALSE, 'msg' => 'Designation name is already exist!'));
                                }
                            } else {
                                echo json_encode(array('status' => TRUE, 'msg' => 'Details updates successfully!'));
                            }
                        }
                    }
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        echo json_encode(array('status' => FALSE, 'msg' => 'Something went wrong. Please try again'));
                    } else {
                        $this->db->trans_commit();
                    }
                }
            } else {
                $this->session->set_flashdata('message', 'Session Expired!');
                echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
            }
        } else {
            $this->session->set_flashdata('message', 'Unauthorized access!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => "Unauthorized access"));
        }
    }

    function getData() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'Field', 'trim|required|regex_match[/^[0-9]+$/i]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'msg' => validation_errors()));
                } else {
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $data = $this->designation->selectDetailsRowModel('auto_id,desig_name', array('auto_id' => $id));
                    $resdata = null;
                    if ($data != null) {
                        $resdata = array(
                            'auto_id' => $data->auto_id,
                            'desig_name' => strtoupper($data->desig_name)
                        );
                        $this->session->set_userdata('oid', $data->auto_id);
                        $this->session->set_userdata('oname', $data->desig_name);
                        echo json_encode(array('status' => TRUE, 'msg' => "", 'result' => $data));
                    } else {
                        echo json_encode(array('status' => FALSE, 'msg' => "No record found"));
                    }
                }
            } else {
                $this->session->set_flashdata('message', 'Session Expired!');
                echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
            }
        } else {
            $this->session->set_flashdata('message', 'Unauthorized access!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => "Unauthorized access"));
        }
    }

    function deleteData() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('auto_id', 'Field', 'trim|required|regex_match[/^[0-9]+$/i]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'msg' => validation_errors()));
            } else {
                $userid = $this->session->userdata('uid');
                $role = $this->session->userdata('role');
                if ($userid != "" && in_array($role, array('SA', 'AD'))) {
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $this->designation->deleteDetailsModel($auto_id);
                    echo json_encode(array('status' => TRUE, 'msg' => 'Record deleted successfully'));
                } else {
                    $this->session->set_flashdata('message', 'Session Expired!');
                    echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'You are not authorized to perform these operation!'));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Session Expired!');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
        }
    }

}