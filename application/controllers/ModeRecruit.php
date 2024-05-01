<?php

class ModeRecruit extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ModeRecruitModel', 'modeRecruit', TRUE);
    }

    function index() {
        $this->load->view('pages/commons/1_header');
        $this->load->view('pages/commons/2_top_navbar');
        $data['submenu'] = "moderecruit";
        $this->load->view('pages/commons/3_main_menu', $data);
        $this->load->view('pages/admin/list_mode_name');
        $this->load->view('pages/commons/4_footer');
    }

    function ajax_list() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $userid = $this->session->userdata('uid');
            $role = $this->session->userdata('role');
            if ($userid != "" && in_array($role, array('A'))) {
                $list = $this->modeRecruit->list_databales(array());
                $count_rec = $this->modeRecruit->list_filtered(array());
            } else {
                $list = NULL;
                $count_rec = array();
            }

            $data = array();
            $no = $_POST['start'];
            if ($list != NULL) {
                foreach ($list as $accrow) {
                    $edit = '<a title="Edit Details" class="btn btn-outline-info btn-xs" href="javascript:vpid()" onclick=editDetails("' . $accrow->auto_id . '")><i class="fas fa-pencil-alt"></i>  </a>&nbsp;';
                    $delete = '<a title="Delete Record" class="btn btn-outline-danger btn-xs" href="javascript:vpid(0)" onclick="deleteDetail(' . $accrow->auto_id . ')"><i class="fa fa-trash"></i></a>&nbsp;';
                    $no ++;
                    $row = array();
                    $row[] = $no;
                    $row[] = strtoupper($accrow->mode_name);
                    $row[] = $edit . $delete;
                    $data[] = $row;
                }
                $output = array("draw" => $_POST['draw'], "recordsTotal" => $count_rec, "recordsFiltered" => $count_rec, "data" => $data);
                echo json_encode($output);
            } else {
                $output = array("draw" => $_POST['draw'], "recordsTotal" => 0, "recordsFiltered" => 0, "data" => array());
                echo json_encode($output);
            }
        }
    }

    function saveChanges() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('A'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $add_update = trim($this->security->xss_clean($this->input->post("add_update")));
                $this->form_validation->set_rules('mode_name', 'Mode name is required', 'trim|required|max_length[65]|min_length[2]');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'msg' => validation_errors()));
                } else {
                    $mode_name = trim($this->security->xss_clean($this->input->post("mode_name")));
                    $this->db->trans_start();
                    if ($add_update == 'add') {
                        $details = $this->modeRecruit->selectDetailsModel('mode_name', array('mode_name' => trim($mode_name)));
                        $data = array(
                            'mode_name' => trim(strtoupper($mode_name)),
                            'entry_datetime' => date('Y-m-d H:i:s'),
                            'entry_by' => $userid,
                            'sys_ip' => $this->input->ip_address()
                        );
                        if ($details == NULL) {
                            $this->modeRecruit->saveDetailsModel($data);
                            echo json_encode(array('status' => TRUE, 'msg' => 'Details added successfully!'));
                        } else {
                            echo json_encode(array('status' => FALSE, 'msg' => 'Mode name is already exist!'));
                        }
                    }

                    if ($add_update == 'update') {
                        $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                        if (preg_match('/^\d+$/D', $auto_id) && $auto_id == $this->session->userdata('pid')) {
                            $data = array(
                                'mode_name' => trim(strtoupper($mode_name)),
                                'last_update_datetime' => date('Y-m-d H:i:s'),
                                'sys_ip' => $this->input->ip_address()
                            );

                            if ($this->session->userdata('pname') != $mode_name) {
                                $details = $this->modeRecruit->selectDetailsModel('mode_name', array('mode_name' => trim($mode_name)));
                                if ($details == NULL) {
                                    $this->modeRecruit->updateDetailsModel(array('auto_id' => $auto_id), $data);
                                    echo json_encode(array('status' => TRUE, 'msg' => 'Details updates successfully!'));
                                } else {
                                    echo json_encode(array('status' => FALSE, 'msg' => 'Mode name is already exist!'));
                                }
                            } else {
                                echo json_encode(array('status' => TRUE, 'msg' => 'Details updates successfully!'));
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'msg' => 'Invalid auto ID'));
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
                echo json_encode(array('status' => FALSE, 'msg' => 'Something went wrong. Please try again'));
            }
        } else {
            //  redirect('auth/logOut');
            echo json_encode(array('status' => FALSE, 'msg' => 'Logout'));
        }
    }

    function getData() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $this->form_validation->set_rules('id', 'Field', 'trim|required|regex_match[/^[0-9]+$/i]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => FALSE, 'msg' => validation_errors()));
            } else {
                $id = trim($this->security->xss_clean($this->input->post('id')));
                $data = $this->modeRecruit->selectDetailsRowModel('auto_id,mode_name', array('auto_id' => $id));
                $resdata = null;
                if ($data != null) {
                    $resdata = array(
                        'auto_id' => $data->auto_id,
                        'mode_name' => strtoupper($data->mode_name)
                    );
                    $this->session->set_userdata('pid', $data->auto_id);
                    $this->session->set_userdata('pname', $data->mode_name);
                    echo json_encode(array('status' => TRUE, 'msg' => "", 'result' => $data));
                } else {
                    echo json_encode(array('status' => FALSE, 'msg' => "No record found"));
                }
            }
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
                if ($userid != "" && in_array($role, array('A'))) {
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $this->modeRecruit->deleteDetailsModel($auto_id);
                    echo json_encode(array('status' => TRUE, 'msg' => 'Record deleted successfully'));
                } else {
                    echo json_encode(array('status' => FALSE, 'msg' => 'You are not authorized to perform these operation!'));
                }
            }
        }
    }

}
