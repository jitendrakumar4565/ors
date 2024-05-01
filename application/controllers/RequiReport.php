<?php

class RequiReport extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RequiReportModel', 'requiReport', TRUE);
        $this->load->model('RequiModel', 'requi', TRUE);
        $this->load->model('PostNameModel', 'postName', TRUE);
        $this->load->model('DepartmentModel', 'department', TRUE);
        $this->load->model('RequiInboxModel', 'requiInbox', TRUE);
    }

    function index() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['mainmenu'] = "";
        $data['submenu'] = "requiReport";
        if ($userid != "" && in_array($role, array('SA', 'AD', 'UR'))) {
            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $data['deptList'] = $this->department->selectDetailsModel('auto_id,dept_name', array());
            $data['postList'] = $this->postName->selectDetailsModel('auto_id,post_name', array());
            $data['csrf'] = random_strings();
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/list_report');
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function ajax_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('SA', 'AD', 'UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $cond = "";
                $condArr = array();
                $cdname = "";
                if (isset($_POST['dept_name'])) {
                    $deptName = $_POST['dept_name'];
                    if (count($deptName) > 1) {
                        foreach ($deptName as $pname) {
                            if (trim($pname) != '') {
                                $cdname .= "'" . trim($pname) . "',";
                            }
                        }
                        $cdname = rtrim($cdname, ",");
                        if ($cdname != "") {
                            array_push($condArr, 'req.dept_name IN ( ' . $cdname . ' )');
                        }
                    } else if (count($deptName) == 1) {
                        foreach ($deptName as $pname) {
                            if (trim($pname) != '') {
                                $cdname .= $pname;
                            }
                        }
                        if ($cdname != "") {
                            array_push($condArr, "req.dept_name = '" . $cdname . "'");
                        } else {
                            $cdname = "";
                        }
                    }
                } else {
                    $cdname = "";
                }

                $corgname = "";
                if (isset($_POST['org_name'])) {
                    $orgName = $_POST['org_name'];
                    if (count($orgName) > 1) {
                        foreach ($orgName as $pname) {
                            if (trim($pname) != '') {
                                $corgname .= "'" . trim($pname) . "',";
                            }
                        }
                        $corgname = rtrim($corgname, ",");
                        if ($corgname != "") {
                            array_push($condArr, 'req.org_name IN ( ' . $corgname . ' )');
                        }
                    } else if (count($orgName) == 1) {
                        foreach ($orgName as $pname) {
                            if (trim($pname) != '') {
                                $corgname .= $pname;
                            }
                        }
                        if ($corgname != "") {
                            array_push($condArr, "req.org_name = '" . $corgname . "'");
                        } else {
                            $corgname = "";
                        }
                    }
                } else {
                    $corgname = "";
                }

                $cpostname = "";
                if (isset($_POST['post_name'])) {
                    $postName = $_POST['post_name'];
                    if (count($postName) > 1) {
                        foreach ($postName as $pname) {
                            if (trim($pname) != '') {
                                $cpostname .= "'" . trim($pname) . "',";
                            }
                        }
                        $cpostname = rtrim($cpostname, ",");
                        if ($cpostname != "") {
                            array_push($condArr, 'req.post_name IN ( ' . $cpostname . ' )');
                        }
                    } else if (count($postName) == 1) {
                        foreach ($postName as $pname) {
                            if (trim($pname) != '') {
                                $cpostname .= $pname;
                            }
                        }
                        if ($cpostname != "") {
                            array_push($condArr, "req.post_name = '" . $cpostname . "'");
                        } else {
                            $cpostname = "";
                        }
                    }
                } else {
                    $cpostname = "";
                }

                $cmodename = "";
                if (isset($_POST['mode_recuit'])) {
                    $modeName = $_POST['mode_recuit'];
                    if (count($modeName) > 1) {
                        foreach ($modeName as $pname) {
                            if (trim($pname) != '') {
                                $cmodename .= "'" . trim($pname) . "',";
                            }
                        }
                        $cmodename = rtrim($cmodename, ",");
                        if ($cmodename != "") {
                            array_push($condArr, 'req.c_mode_recruitment IN ( ' . $cmodename . ' )');
                        }
                    } else if (count($modeName) == 1) {
                        foreach ($modeName as $pname) {
                            if (trim($pname) != '') {
                                $cmodename .= $pname;
                            }
                        }
                        if ($cmodename != "") {
                            array_push($condArr, "req.c_mode_recruitment = '" . $cmodename . "'");
                        } else {
                            $cmodename = "";
                        }
                    }
                } else {
                    $cmodename = "";
                }

                $cpayscalename = "";
                if (isset($_POST['pay_scale'])) {
                    $payscaleName = $_POST['pay_scale'];
                    if (count($payscaleName) > 1) {
                        foreach ($payscaleName as $pname) {
                            if (trim($pname) != '') {
                                $cpayscalename .= "'" . trim($pname) . "',";
                            }
                        }
                        $cpayscalename = rtrim($cpayscalename, ",");
                        if ($cpayscalename != "") {
                            array_push($condArr, 'req.b_pay_scale IN ( ' . $cpayscalename . ' )');
                        }
                    } else if (count($payscaleName) == 1) {
                        foreach ($payscaleName as $pname) {
                            if (trim($pname) != '') {
                                $cpayscalename .= $pname;
                            }
                        }
                        if ($cpayscalename != "") {
                            array_push($condArr, "req.b_pay_scale = '" . $cpayscalename . "'");
                        } else {
                            $cpayscalename = "";
                        }
                    }
                } else {
                    $cpayscalename = "";
                }


                $cactionname = "";
                if (isset($_POST['status'])) {
                    $actionName = $_POST['status'];
                    if (count($actionName) > 1) {
                        foreach ($actionName as $pname) {
                            if (trim($pname) != '') {
                                $cactionname .= "'" . trim($pname) . "',";
                            }
                        }
                        $cactionname = rtrim($cactionname, ",");
                        if ($cactionname != "") {
                            array_push($condArr, 'req.action_taken IN ( ' . $cactionname . ' )');
                        }
                    } else if (count($actionName) == 1) {
                        foreach ($actionName as $pname) {
                            if (trim($pname) != '') {
                                $cactionname .= $pname;
                            }
                        }
                        if ($cactionname != "") {
                            array_push($condArr, "req.action_taken = '" . $cactionname . "'");
                        } else {
                            $cactionname = "";
                        }
                    }
                } else {
                    $cactionname = "";
                }

                if ($condArr != NULL) {
                    for ($ci = 0; $ci < count($condArr); $ci++) {
                        $cond .= $condArr[$ci];
                        if (($ci + 1) < count($condArr)) {
                            $cond .= ' AND ';
                        }
                    }
                }


                if (in_array($role, array('UR'))) {
                    if ($cond != "") {
                        $cond .= ' AND req.entry_user = ' . $userid;
                    } else {
                        $cond .= 'req.entry_user = ' . $userid;
                    }
                } else if (in_array($role, array('SA', 'AD')) && $cond == "") {
                    $cond = array();
                }
                $allcat = $this->requiReport->getAllCategoryNosDataModel($cond);
                $list = $this->requiReport->list_databales($cond);
                $count_rec = $this->requiReport->list_filtered($cond);
                /*
                  if ($condArr == NULL) {
                  //count all
                  $allcat = $this->requiReport->getAllCategoryNosDataModel(array());
                  } else {
                  //count with condition
                  $allcat = $this->requiReport->getAllCategoryNosDataModel($cond);
                  }
                 * 
                 */
                /*
                  if ($cond == "") {
                  $list = $this->requiReport->list_databales(array());
                  $count_rec = $this->requiReport->list_filtered(array());
                  } else {
                  $list = $this->requiReport->list_databales($cond);
                  $count_rec = $this->requiReport->list_filtered($cond);
                  }
                 * 
                 */

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

                        $no ++;
                        $row = array();
                        $row[] = $no;
                        $row[] = strtoupper($accrow->org_name);
                        $row[] = strtoupper($accrow->dept_name);
                        $row[] = strtoupper($accrow->post_name);
                        $row[] = $modeSpan;
                        $row[] = $statusSpan;
                        $row[] = $accrow->d_ur;
                        $row[] = $accrow->d_apst;
                        $row[] = $accrow->d_pwd;
                        $row[] = $accrow->d_ex_sm;
                        $row[] = "";
                        $row[] = $accrow->rec_ur;
                        $row[] = $accrow->rec_apst;
                        $row[] = $accrow->rec_pwd;
                        $row[] = $accrow->rec_ex_sm;
                        $row[] = "";
                        $row[] = ($accrow->d_ur - $accrow->rec_ur);
                        $row[] = ($accrow->d_apst - $accrow->rec_apst);
                        $row[] = ($accrow->d_pwd - $accrow->rec_pwd);
                        $row[] = ($accrow->d_ex_sm - $accrow->rec_ex_sm);

                        $row[] = $preview . $previewPdf;
                        $data[] = $row;
                    }
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, "recordsTotal" => $count_rec, "recordsFiltered" => $count_rec, "data" => $data, 'allcat' => $allcat);
                    echo json_encode($output);
                } else {
                    $output = array("draw" => $_POST['draw'], 'logout' => FALSE, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => array(), 'allcat' => $allcat);
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

    function printReport() {
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
                    $mData = $this->requiReport->select2ndFromCompData('req.auto_id,org.org_name,dept.dept_name,req.officer_name,desig.desig_name,req.contact_no,req.officer_email,pp.dept_name,req.a_group,req.b_pay_scale,req.c_mode_recruitment,req.d_ur,req.d_apst,req.d_total,req.d_pwd,req.d_ex_sm,req.e_blindness,req.e_deaf,req.e_locomotor,req.e_autism,req.e_multiple,req.e_total,req.f_vac_worked_out,req.g_edu_others,req.h_min_age,req.h_max_age,req.i_apst,req.i_pwd,req.i_ex_sm,req.j_ban_restric,req.file_copy_k_rr,req.l_other_requi_cond,req.file_copy_l_ro,req.m_criteria_eligibility_post,req.m_criteria_eligibility,req.file_copy_n_list_cands,req.file_copy_o_list_cands,req.seen_flag,req.action_taken,req.action_datetime,req.entry_datetime,req.sent_datetime,req.action_remarks,pem.eligibility', array('req.auto_id' => $id));
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
                        $mpdf = new \Mpdf\Mpdf($constructor);
                        $footer = '<div style="font-size:8px;text-align:right;padding-right:30px;margin-top:-11px;">Page : {PAGENO} / {nb}</div>';
                        $epass_header = $this->load->view('pages/' . $res . '/print_report_details', $data, TRUE);
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
        if ($userid != "" && in_array($role, array('SA', 'AD', 'UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $mData = $this->requiInbox->select2ndFromCompData('req.auto_id,org.org_name,dept.dept_name,req.officer_name,desig.desig_name,req.contact_no,req.officer_email,pp.post_name,req.a_group,req.b_pay_scale,req.c_mode_recruitment,req.d_ur,req.d_apst,req.d_total,req.d_pwd,req.d_ex_sm,req.e_blindness,req.e_deaf,req.e_locomotor,req.e_autism,req.e_multiple,req.e_total,req.f_vac_worked_out,req.g_edu_others,req.h_min_age,req.h_max_age,req.i_apst,req.i_pwd_apst,req.i_pwd_ur,req.i_ex_sm_apst,req.i_ex_sm_ur,req.j_ban_restric,req.file_copy_k_rr,req.l_other_requi_cond,req.file_copy_l_ro,req.m_criteria_eligibility_post,req.m_criteria_eligibility,req.file_copy_n_list_cands,req.file_copy_o_list_cands,req.seen_flag,req.action_taken,req.action_datetime,req.entry_datetime,req.sent_datetime,req.seen_by_dept,req.action_remarks,pem.eligibility,req.rec_ur,req.rec_apst,req.rec_pwd,req.rec_ex_sm', array('req.auto_id' => $id));
                    if ($mData != NULL) {
                        $res = loadMenus();
                        $data['mData'] = $mData;
                        $data['id'] = $id;
                        $resp = $this->load->view('pages/' . $res . '/view_report_details', $data, TRUE);
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
