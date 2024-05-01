<?php

class RequiDraft extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RequiDraftModel', 'requiDraft', TRUE);
        $this->load->model('RequiModel', 'requi', TRUE);
        $this->load->model('OrganisationModel', 'organisation', TRUE);
        $this->load->model('DepartmentModel', 'department', TRUE);
        $this->load->model('DesignationModel', 'designation', TRUE);
        $this->load->model('PostNameModel', 'postName', TRUE);
        $this->load->model('GroupNameModel', 'groupName', TRUE);
        $this->load->model('PayScaleModel', 'payScale', TRUE);
        $this->load->model('ModeRecruitModel', 'modeRecruit', TRUE);
        $this->load->model('UserModel', 'user', TRUE);
    }

    function index() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['submenu'] = "requiDraft";
        if ($userid != "" && in_array($role, array('UR'))) {
            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $data['csrf'] = random_strings();
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/list_drafts');
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function ajax_list() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['submenu'] = "requiDraft";
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $list = $this->requiDraft->list_databales(array('entry_user' => $userid));
                $count_rec = $this->requiDraft->list_filtered(array('entry_user' => $userid));

                $data = array();
                $no = $_POST['start'];
                if ($list != NULL) {
                    foreach ($list as $accrow) {
                        $modeSpan = '<span class="badge badge-danger">LDCE RECRUITMENT</span>';
                        $modeRec = $accrow->c_mode_recruitment;
                        if ($modeRec == 'D') {
                            $modeSpan = '<span class="badge badge-success">DIRECT RECRUITMENT</span>';
                        }
                        $preview = '<a title="View Details" class="btn btn-outline-info btn-xs" href="javascript:void(0)" onclick=previewRecord("' . $accrow->auto_id . '")><i class="fas fa-eye"></i>  </a>&nbsp;';
                        $edit = '<a title="Edit Details" class="btn btn-outline-info btn-xs" href="javascript:void(0)" onclick=editRecord("' . $accrow->auto_id . '")><i class="fas fa-edit"></i>  </a>&nbsp;';
                        $previewPdf = '<a title="View Details" class="btn btn-outline-danger btn-xs" href="javascript:void(0)" onclick=previewPdfRecord("' . $accrow->auto_id . '")><i class="fa fa-file-pdf-o"></i>  </a>&nbsp;';
                        $delete = '<a title="Delete Record" class="btn btn-outline-danger btn-xs" href="javascript:void(0)" onclick=deleteRecord("' . $accrow->auto_id . '")><i class="fa fa-trash-o"></i>  </a>&nbsp;';
                        $no ++;
                        $row = array();
                        $row[] = $no;
                        $row[] = strtoupper($accrow->org_name);
                        $row[] = strtoupper($accrow->dept_name);
                        $row[] = strtoupper($accrow->post_name);
                        $row[] = $modeSpan;
                        $row[] = date("d-m-Y g:i A", strtotime($accrow->entry_datetime));
                        $row[] = $preview . $edit . $previewPdf . $delete;
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

    function addNew() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $data['submenu'] = "requiDraft";
        if ($userid != "" && in_array($role, array('UR'))) {
            $formReset = trim($this->security->xss_clean($this->input->post("form_reset")));
            if ($formReset == 'form_reset') {
                $this->session->set_userdata('MSTID', "");
            }
            $mstID = $this->session->userdata('MSTID');
            $autoid = $this->session->userdata('autoid');
            if ($mstID != "") {
                $data['MSTID'] = $mstID;
            } else {
                $mstID = $autoid . "MSTID" . date('dmYHis');
                $this->session->set_userdata('MSTID', $mstID);
                $data['MSTID'] = $mstID;
            }

            $data['orgList'] = $this->user->getUserMappOrgModel($userid, 'org.auto_id,org.org_name,mpp.org_id,mpp.status_flag', array('mpp.user_id' => $userid));
            $data['userData'] = $this->user->selectComDetailsRowModel('usr.user_lvl,usr.email_id,usr.mobile_no,usr.full_name,desig.desig_name,usr.desig,dept.dept_name,usr.dept_id', array('usr.user_id' => $userid, 'usr.approved_flag' => 'A'));
            if ($data['userData'] == NULL) {
                $this->session->set_flashdata('message', 'Unapproved user!');
                redirect(base_url('page?name=home'));
            }
            $data['desigList'] = $this->designation->selectDetailsModel('auto_id,desig_name', array());
            $data['postList'] = $this->postName->selectDetailsModel('auto_id,post_name', array());
            $data['postEligList'] = $this->requiDraft->selectPostEligList('auto_id,post_name,eligibility', array('post_name' => 'LDC'));
            $data['mData'] = $this->requiDraft->selectTemp2ndFormWithPostDetails('mm.auto_id,pp.post_name,mm.c_mode_recruitment', array('mm.mst_id' => $mstID));

            $res = loadMenus();
            $data['nosData'] = $this->requi->getNos($role, $userid);
            $data['csrf'] = random_strings();
            $this->load->view('pages/commons/1_header');
            $this->load->view('pages/commons/2_top_navbar', $data);
            $data['submenu'] = "addNew";
            $this->load->view('pages/commons/' . $res . '/3_main_menu', $data);
            $this->load->view('pages/' . $res . '/requi_draft', $data);
            $this->load->view('pages/commons/4_footer');
        } else {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function saveTemp2ndForm() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('org_name', 'Organisation name', 'trim|required|integer|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('dept_name', 'Department name', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('officer_name', 'Officer name', 'trim|required|max_length[65]|min_length[2]');
                $this->form_validation->set_rules('officer_desig', 'Designation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('contact_no', 'Contact no', 'trim|required|min_length[10]|max_length[10]');
                $this->form_validation->set_rules('officer_email', 'Email id', 'trim|max_length[120]');
                $this->form_validation->set_rules('c_mode_recruitment', 'Mode of recruitment', 'trim|required|max_length[25]|min_length[1]');
                $this->form_validation->set_rules('post_name', 'Post name', 'trim|required|integer|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('a_group', 'Group', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('b_pay_scale', 'Pay Scale', 'trim|required|max_length[25]|min_length[1]');
                $this->form_validation->set_rules('d_ur_2', 'Unreserved', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_apst_2', 'APST', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_total_2', 'Total', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_pwd_2', 'PwD', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_ex_sm_2', 'Ex-SM', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_blindness_2', 'Blindness and Low Vision', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_deaf_2', 'Deaf and Hard of hearing', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_locomotor_2', 'Locomotor Disability including Cerebral Palsy, Leprosy Cured, Dwarfism, Acid Attack Victims and Muscular Dystrophy', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_autism_2', 'Autism, Intellectual Disability, Specific Learning Disability and Mental Illness', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_multiple_2', 'Multiple Disabilities from among persons under clauses (i) to (iv) including deaf-blindness', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_total_2', 'Total Category of disability', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('f_vac_worked_out_2', 'Whether the vacancies for the person with disabilities and Ex-Serviceman have been worked out with reference to the instructions contained in the Government of Arunachal Pradesh Orders', 'trim');
                $this->form_validation->set_rules('g_edu_others_2', 'Education and other qualification laid down in the Recruitment Rules', 'trim|required|max_length[225]|min_length[1]');
                $this->form_validation->set_rules('h_min_age_2', 'Minimum age', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('h_max_age_2', 'Maximum age', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_apst_2', 'APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_pwd_apst_2', 'PwD APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_pwd_ur_2', 'PwD UR age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_ex_sm_apst_2', 'Ex-Servicemen APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_ex_sm_ur_2', 'Ex-Servicemen UR age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('j_ban_restric_2', 'Whether there is any ban or restriction from the Govt. for filling up the post', 'trim');
                $this->form_validation->set_rules('file_copy_k_2', 'Upload latest Recruitment Rules file', 'trim');
                $this->form_validation->set_rules('l_other_requi_cond_2', 'Any other requirement or conditions not covered above', 'trim|required|min_length[2]|max_length[225]');
                $this->form_validation->set_rules('file_copy_l_2', 'Upload relevant orders file', 'trim');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $orgName = trim($this->security->xss_clean($this->input->post("org_name")));
                    $deptName = trim($this->security->xss_clean($this->input->post("dept_name")));
                    $officerName = trim($this->security->xss_clean($this->input->post("officer_name")));
                    $officerDesig = trim($this->security->xss_clean($this->input->post("officer_desig")));
                    $contactNo = trim($this->security->xss_clean($this->input->post("contact_no")));
                    $officerEmail = trim($this->security->xss_clean($this->input->post("officer_email")));
                    $cModeRecuitment = trim($this->security->xss_clean($this->input->post("c_mode_recruitment")));
                    $postName = trim($this->security->xss_clean($this->input->post("post_name")));
                    $aGroup = trim($this->security->xss_clean($this->input->post("a_group")));
                    $bPayScale = trim($this->security->xss_clean($this->input->post("b_pay_scale")));
                    $dUR = trim($this->security->xss_clean($this->input->post("d_ur_2")));
                    $dAPST = trim($this->security->xss_clean($this->input->post("d_apst_2")));
                    $dTotal = trim($this->security->xss_clean($this->input->post("d_total_2")));
                    $dPwD = trim($this->security->xss_clean($this->input->post("d_pwd_2")));
                    $dExSm = trim($this->security->xss_clean($this->input->post("d_ex_sm_2")));
                    $eBlindness = trim($this->security->xss_clean($this->input->post("e_blindness_2")));
                    $eDeaf = trim($this->security->xss_clean($this->input->post("e_deaf_2")));
                    $eLocomotor = trim($this->security->xss_clean($this->input->post("e_locomotor_2")));
                    $eAutism = trim($this->security->xss_clean($this->input->post("e_autism_2")));
                    $eMultiple = trim($this->security->xss_clean($this->input->post("e_multiple_2")));
                    $eTotal = trim($this->security->xss_clean($this->input->post("e_total_2")));
                    $fVacWorkedOut = trim($this->security->xss_clean($this->input->post("f_vac_worked_out_2")));
                    $gEduOthers = trim($this->security->xss_clean($this->input->post("g_edu_others_2")));
                    $hMinAge = trim($this->security->xss_clean($this->input->post("h_min_age_2")));
                    $hMaxAge = trim($this->security->xss_clean($this->input->post("h_max_age_2")));
                    $iAPST = trim($this->security->xss_clean($this->input->post("i_apst_2")));
                    $iPwDApst = trim($this->security->xss_clean($this->input->post("i_pwd_apst_2")));
                    $iPwDUr = trim($this->security->xss_clean($this->input->post("i_pwd_ur_2")));
                    $iExSmApst = trim($this->security->xss_clean($this->input->post("i_ex_sm_apst_2")));
                    $iExSmUr = trim($this->security->xss_clean($this->input->post("i_ex_sm_ur_2")));
                    $jBanRectric = trim($this->security->xss_clean($this->input->post("j_ban_restric_2")));
                    $lOtherRequiCond = trim($this->security->xss_clean($this->input->post("l_other_requi_cond_2")));

                    $this->db->trans_start();
                    $mstID = $this->session->userdata('MSTID');
                    $autoid = $this->session->userdata('autoid');
                    if ($mstID != "") {
                        $data['MSTID'] = $mstID;
                    } else {
                        $mstID = $autoid . "MSTID" . date('dmYHis');
                        $this->session->set_userdata('MSTID', $mstID);
                        $data['MSTID'] = $mstID;
                    }

                    $file_kError = FALSE;
                    $file_kMsg = "";
                    $file_lError = FALSE;
                    $file_lMsg = "";
                    $targetDir = 'requisitions_documents';

                    $filename_k = "";
                    $filename_l = "";
                    if (isset($_FILES['file_k_2']) && $_FILES['file_k_2']['size'] > 0) {
                        $fileName = basename($_FILES['file_k_2']['name']);
                        $filename_k = 'RR_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_k;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_k_2']['tmp_name'], $fileUrl)) {
                                $file_kError = FALSE;
                                $file_kMsg = "";
                            } else {
                                $file_kError = TRUE;
                                $file_kMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_kError = TRUE;
                            $file_kMsg = "Invalid Recruitment Rules file format";
                        }
                    }

                    if (isset($_FILES['file_l_2']) && $_FILES['file_l_2']['size'] > 0) {
                        $fileName = basename($_FILES['file_l_2']['name']);
                        $filename_l = 'RO_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_l;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_l_2']['tmp_name'], $fileUrl)) {
                                $file_lError = FALSE;
                                $file_lMsg = "";
                            } else {
                                $file_lError = TRUE;
                                $file_lMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_lError = TRUE;
                            $file_lMsg = "Invalid relevant orders file format";
                        }
                    }

                    $mappData = array(
                        'org_name' => trim($orgName),
                        'dept_name' => trim($deptName),
                        'officer_name' => trim(strtoupper($officerName)),
                        'officer_desig' => trim($officerDesig),
                        'contact_no' => trim($contactNo),
                        'officer_email' => trim($officerEmail),
                        'post_name' => trim($postName),
                        'a_group' => trim($aGroup),
                        'b_pay_scale' => trim($bPayScale),
                        'c_mode_recruitment' => trim($cModeRecuitment),
                        'd_ur' => trim($dUR),
                        'd_apst' => trim($dAPST),
                        'd_total' => trim($dTotal),
                        'd_pwd' => trim($dPwD),
                        'd_ex_sm' => trim($dExSm),
                        'e_blindness' => trim($eBlindness),
                        'e_deaf' => trim($eDeaf),
                        'e_locomotor' => trim($eLocomotor),
                        'e_autism' => trim($eAutism),
                        'e_multiple' => trim($eMultiple),
                        'e_total' => trim($eTotal),
                        'f_vac_worked_out' => trim($fVacWorkedOut),
                        'g_edu_others' => trim($gEduOthers),
                        'h_min_age' => trim($hMinAge),
                        'h_max_age' => trim($hMaxAge),
                        'i_apst' => trim($iAPST),
                        'i_pwd_apst' => trim($iPwDApst),
                        'i_pwd_ur' => trim($iPwDUr),
                        'i_ex_sm_apst' => trim($iExSmApst),
                        'i_ex_sm_ur' => trim($iExSmUr),
                        'j_ban_restric' => trim($jBanRectric),
                        'file_copy_k_rr' => trim($filename_k),
                        'l_other_requi_cond' => trim($lOtherRequiCond),
                        'file_copy_l_ro' => trim($filename_l),
                        'm_criteria_eligibility_post' => '',
                        'm_criteria_eligibility' => '',
                        'file_copy_n_list_cands' => '',
                        'file_copy_o_list_cands' => '',
                        'entry_datetime' => date('Y-m-d H:i:s'),
                        'sys_ip' => $this->input->ip_address(),
                        'entry_user' => $userid,
                        'mst_id' => $mstID
                    );

                    if ($file_kError == FALSE && $file_lError == FALSE) {
                        if ($this->requiDraft->saveTemp2ndFormModel($mappData)) {
                            $mData = $this->requiDraft->selectTemp2ndFormWithPostDetails('mm.auto_id,pp.post_name,mm.c_mode_recruitment', array('mm.mst_id' => $mstID));
                            $html = "";
                            if ($mData != null) {
                                $sno = 1;
                                foreach ($mData as $mRow) {
                                    $html .= '<div class="col-md-2">
                                                        <div class="form-group">
                                                            <div class="small-box">
                                                                <div class="inner">';
                                    $html .= '<p><span class="float-right badge badge-primary">' . $sno . '</span> ' . $mRow->post_name . '</p>';
                                    $modeRec = $mRow->c_mode_recruitment;
                                    if ($modeRec == 'L') {
                                        $html .= '<span class="badge badge-danger">LDCE RECRUITMENT</span>';
                                    } else {
                                        $html .= '<span class="badge badge-success">DIRECT RECRUITMENT</span>';
                                    }
                                    $html .= '</div>
                                                <div class="icon">
                                                    <i class="ion ion-bag"></i>
                                                </div>
                                                <div class="small-box-footer">
                                                    <button title="Edit Details" onclick="editMappRecord(' . $mRow->auto_id . ')" type="button"  class="btn btn-xs btn-outline-info mr-2"> <i class="fa fa-file"></i></button>
                                                    <button title="Delete Record" onclick="delMappRecord(' . $mRow->auto_id . ')" type="button" class="btn btn-xs btn-outline-danger"> <i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                    $sno++;
                                }
                            }
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'mstid' => $mstID, 'msg' => 'Details added successfully', 'html' => $html, 'mapp_count' => count($mData)));
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to add record!'));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $file_kMsg . ' ' . $file_lMsg));
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

    function saveTemp3rdForm() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('org_name', 'Organisation name', 'trim|required|integer|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('dept_name', 'Department name', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('officer_name', 'Officer name', 'trim|required|max_length[65]|min_length[2]');
                $this->form_validation->set_rules('officer_desig', 'Designation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('contact_no', 'Contact no', 'trim|required|min_length[10]|max_length[10]');
                $this->form_validation->set_rules('officer_email', 'Email id', 'trim|max_length[120]');
                $this->form_validation->set_rules('c_mode_recruitment', 'Mode of recruitment', 'trim|required|max_length[25]|min_length[1]');
                $this->form_validation->set_rules('post_name', 'Post name', 'trim|required|integer|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('a_group', 'Group', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('b_pay_scale', 'Pay Scale', 'trim|required|max_length[25]|min_length[1]');
                $this->form_validation->set_rules('d_ur_3', 'Unreserved', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_apst_3', 'APST', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_total_3', 'Total', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_pwd_3', 'PwD', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_ex_sm_3', 'Ex-SM', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_blindness_3', 'Blindness and Low Vision', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_deaf_3', 'Deaf and Hard of hearing', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_locomotor_3', 'Locomotor Disability including Cerebral Palsy, Leprosy Cured, Dwarfism, Acid Attack Victims and Muscular Dystrophy', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_autism_3', 'Autism, Intellectual Disability, Specific Learning Disability and Mental Illness', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_multiple_3', 'Multiple Disabilities from among persons under clauses (i) to (iv) including deaf-blindness', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_total_3', 'Total Category of disability', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('f_vac_worked_out_3', 'Whether the vacancies for the person with disabilities and Ex-Serviceman have been worked out with reference to the instructions contained in the Government of Arunachal Pradesh Orders', 'trim');
                $this->form_validation->set_rules('g_edu_others_3', 'Education and other qualification laid down in the Recruitment Rules', 'trim|required|max_length[225]|min_length[1]');
                $this->form_validation->set_rules('h_min_age_3', 'Minimum age', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('h_max_age_3', 'Maximum age', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_apst_3', 'APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_pwd_apst_3', 'PwD APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_pwd_ur_3', 'PwD UR age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_ex_sm_apst_3', 'Ex-Servicemen APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_ex_sm_ur_3', 'Ex-Servicemen UR age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('j_ban_restric_3', 'Whether there is any ban or restriction from the Govt. for filling up the post', 'trim');
                $this->form_validation->set_rules('file_copy_k_3', 'Upload latest Recruitment Rules file', 'trim');
                $this->form_validation->set_rules('l_other_requi_cond_3', 'Any other requirement or conditions not covered above', 'trim|required|min_length[2]|max_length[225]');
                $this->form_validation->set_rules('file_copy_l_3', 'Upload relevant orders file', 'trim');
                $this->form_validation->set_rules('m_crit_elig_post_3', 'Select name of post', 'trim|required|min_length[3]|max_length[6]');
                $this->form_validation->set_rules('m_crit_elig_3', 'Select criteria of eligibility', 'trim|required|integer|min_length[1]|max_length[11]');
                $this->form_validation->set_rules('file_copy_n_3', 'Upload detailed list of eligible candidates(in pdf file)', 'trim');
                $this->form_validation->set_rules('file_copy_o_3', 'Upload detailed list of eligible candidates(in xls|xlsx file)', 'trim');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $orgName = trim($this->security->xss_clean($this->input->post("org_name")));
                    $deptName = trim($this->security->xss_clean($this->input->post("dept_name")));
                    $officerName = trim($this->security->xss_clean($this->input->post("officer_name")));
                    $officerDesig = trim($this->security->xss_clean($this->input->post("officer_desig")));
                    $contactNo = trim($this->security->xss_clean($this->input->post("contact_no")));
                    $officerEmail = trim($this->security->xss_clean($this->input->post("officer_email")));
                    $cModeRecuitment = trim($this->security->xss_clean($this->input->post("c_mode_recruitment")));
                    $postName = trim($this->security->xss_clean($this->input->post("post_name")));
                    $aGroup = trim($this->security->xss_clean($this->input->post("a_group")));
                    $bPayScale = trim($this->security->xss_clean($this->input->post("b_pay_scale")));
                    $dUR = trim($this->security->xss_clean($this->input->post("d_ur_3")));
                    $dAPST = trim($this->security->xss_clean($this->input->post("d_apst_3")));
                    $dTotal = trim($this->security->xss_clean($this->input->post("d_total_3")));
                    $dPwD = trim($this->security->xss_clean($this->input->post("d_pwd_3")));
                    $dExSm = trim($this->security->xss_clean($this->input->post("d_ex_sm_3")));
                    $eBlindness = trim($this->security->xss_clean($this->input->post("e_blindness_3")));
                    $eDeaf = trim($this->security->xss_clean($this->input->post("e_deaf_3")));
                    $eLocomotor = trim($this->security->xss_clean($this->input->post("e_locomotor_3")));
                    $eAutism = trim($this->security->xss_clean($this->input->post("e_autism_3")));
                    $eMultiple = trim($this->security->xss_clean($this->input->post("e_multiple_3")));
                    $eTotal = trim($this->security->xss_clean($this->input->post("e_total_3")));
                    $fVacWorkedOut = trim($this->security->xss_clean($this->input->post("f_vac_worked_out_3")));
                    $gEduOthers = trim($this->security->xss_clean($this->input->post("g_edu_others_3")));
                    $hMinAge = trim($this->security->xss_clean($this->input->post("h_min_age_3")));
                    $hMaxAge = trim($this->security->xss_clean($this->input->post("h_max_age_3")));
                    $iAPST = trim($this->security->xss_clean($this->input->post("i_apst_3")));
                    $iPwDApst = trim($this->security->xss_clean($this->input->post("i_pwd_apst_3")));
                    $iPwDUr = trim($this->security->xss_clean($this->input->post("i_pwd_ur_3")));
                    $iExSmApst = trim($this->security->xss_clean($this->input->post("i_ex_sm_apst_3")));
                    $iExSmUr = trim($this->security->xss_clean($this->input->post("i_ex_sm_ur_3")));
                    $jBanRectric = trim($this->security->xss_clean($this->input->post("j_ban_restric_3")));
                    $lOtherRequiCond = trim($this->security->xss_clean($this->input->post("l_other_requi_cond_3")));
                    $mCritPost = trim($this->security->xss_clean($this->input->post("m_crit_elig_post_3")));
                    $mCritElig = trim($this->security->xss_clean($this->input->post("m_crit_elig_3")));

                    $this->db->trans_start();
                    $mstID = $this->session->userdata('MSTID');
                    $autoid = $this->session->userdata('autoid');
                    if ($mstID != "") {
                        $data['MSTID'] = $mstID;
                    } else {
                        $mstID = $autoid . "MSTID" . date('dmYHis');
                        $this->session->set_userdata('MSTID', $mstID);
                        $data['MSTID'] = $mstID;
                    }

                    $file_kError = FALSE;
                    $file_kMsg = "";
                    $file_lError = FALSE;
                    $file_lMsg = "";
                    $targetDir = 'requisitions_documents';

                    $filename_k = "";
                    $filename_l = "";
                    $filename_n = "";
                    $filename_o = "";
                    if (isset($_FILES['file_k_3']) && $_FILES['file_k_3']['size'] > 0) {
                        $fileName = basename($_FILES['file_k_3']['name']);
                        $filename_k = 'RR_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_k;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_k_3']['tmp_name'], $fileUrl)) {
                                $file_kError = FALSE;
                                $file_kMsg = "";
                            } else {
                                $file_kError = TRUE;
                                $file_kMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_kError = TRUE;
                            $file_kMsg = "Invalid Recruitment Rules file format";
                        }
                    }

                    if (isset($_FILES['file_l_3']) && $_FILES['file_l_3']['size'] > 0) {
                        $fileName = basename($_FILES['file_l_3']['name']);
                        $filename_l = 'RO_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_l;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_l_3']['tmp_name'], $fileUrl)) {
                                $file_lError = FALSE;
                                $file_lMsg = "";
                            } else {
                                $file_lError = TRUE;
                                $file_lMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_lError = TRUE;
                            $file_lMsg = "Invalid relevant orders file format";
                        }
                    }

                    if (isset($_FILES['file_n_3']) && $_FILES['file_n_3']['size'] > 0) {
                        $fileName = basename($_FILES['file_n_3']['name']);
                        $filename_n = 'LIST_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_n;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_n_3']['tmp_name'], $fileUrl)) {
                                $file_lError = FALSE;
                                $file_lMsg = "";
                            } else {
                                $file_lError = TRUE;
                                $file_lMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_lError = TRUE;
                            $file_lMsg = "Invalid relevant orders file format";
                        }
                    }

                    if (isset($_FILES['file_o_3']) && $_FILES['file_o_3']['size'] > 0) {
                        $fileName = basename($_FILES['file_o_3']['name']);
                        $filename_o = 'LIST_' . date('dmyhis') . '.xls';
                        $fileUrl = 'requisitions_documents/' . $filename_o;
                        $allowTypes = array('xls', 'xlsx');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_o_3']['tmp_name'], $fileUrl)) {
                                $file_lError = FALSE;
                                $file_lMsg = "";
                            } else {
                                $file_lError = TRUE;
                                $file_lMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_lError = TRUE;
                            $file_lMsg = "Invalid relevant orders file format";
                        }
                    }

                    $mappData = array(
                        'org_name' => trim($orgName),
                        'dept_name' => trim($deptName),
                        'officer_name' => trim(strtoupper($officerName)),
                        'officer_desig' => trim($officerDesig),
                        'contact_no' => trim($contactNo),
                        'officer_email' => trim($officerEmail),
                        'post_name' => trim($postName),
                        'a_group' => trim($aGroup),
                        'b_pay_scale' => trim($bPayScale),
                        'c_mode_recruitment' => trim($cModeRecuitment),
                        'd_ur' => trim($dUR),
                        'd_apst' => trim($dAPST),
                        'd_total' => trim($dTotal),
                        'd_pwd' => trim($dPwD),
                        'd_ex_sm' => trim($dExSm),
                        'e_blindness' => trim($eBlindness),
                        'e_deaf' => trim($eDeaf),
                        'e_locomotor' => trim($eLocomotor),
                        'e_autism' => trim($eAutism),
                        'e_multiple' => trim($eMultiple),
                        'e_total' => trim($eTotal),
                        'f_vac_worked_out' => trim($fVacWorkedOut),
                        'g_edu_others' => trim($gEduOthers),
                        'h_min_age' => trim($hMinAge),
                        'h_max_age' => trim($hMaxAge),
                        'i_apst' => trim($iAPST),
                        'i_pwd_apst' => trim($iPwDApst),
                        'i_pwd_ur' => trim($iPwDUr),
                        'i_ex_sm_apst' => trim($iExSmApst),
                        'i_ex_sm_ur' => trim($iExSmUr),
                        'j_ban_restric' => trim($jBanRectric),
                        'file_copy_k_rr' => trim($filename_k),
                        'l_other_requi_cond' => trim($lOtherRequiCond),
                        'file_copy_l_ro' => trim($filename_l),
                        'm_criteria_eligibility_post' => $mCritPost,
                        'm_criteria_eligibility' => $mCritElig,
                        'file_copy_n_list_cands' => $filename_n,
                        'file_copy_o_list_cands' => $filename_o,
                        'entry_datetime' => date('Y-m-d H:i:s'),
                        'sys_ip' => $this->input->ip_address(),
                        'entry_user' => $userid,
                        'mst_id' => $mstID
                    );

                    if ($file_kError == FALSE && $file_lError == FALSE) {
                        if ($this->requiDraft->saveTemp2ndFormModel($mappData)) {
                            $mData = $this->requiDraft->selectTemp2ndFormWithPostDetails('mm.auto_id,pp.post_name,mm.c_mode_recruitment', array('mm.mst_id' => $mstID));
                            $html = "";
                            if ($mData != null) {
                                $sno = 1;
                                foreach ($mData as $mRow) {
                                    $html .= '<div class="col-md-2">
                                                        <div class="form-group">
                                                            <div class="small-box">
                                                                <div class="inner">';
                                    $html .= '<p><span class="float-right badge badge-primary">' . $sno . '</span> ' . $mRow->post_name . '</p>';
                                    $modeRec = $mRow->c_mode_recruitment;
                                    if ($modeRec == 'L') {
                                        $html .= '<span class="badge badge-danger">LDCE RECRUITMENT</span>';
                                    } else {
                                        $html .= '<span class="badge badge-success">DIRECT RECRUITMENT</span>';
                                    }
                                    $html .= '</div>
                                                <div class="icon">
                                                    <i class="ion ion-bag"></i>
                                                </div>
                                                <div class="small-box-footer">
                                                    <button title="Edit Details" onclick="editMappRecord(' . $mRow->auto_id . ')" type="button"  class="btn btn-xs btn-outline-info mr-2"> <i class="fa fa-file"></i></button>
                                                    <button title="Delete Record" onclick="delMappRecord(' . $mRow->auto_id . ')" type="button" class="btn btn-xs btn-outline-danger"> <i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                    $sno++;
                                }
                            }
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'mstid' => $mstID, 'msg' => 'Details added successfully', 'html' => $html, 'mapp_count' => count($mData)));
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to add record!'));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $file_kMsg . ' ' . $file_lMsg));
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

    function editMappRecord() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'Master ID', 'trim|required|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('type', 'Type', 'trim|required|max_length[4]|min_length[4]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $type = trim($this->security->xss_clean($this->input->post('type')));
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    $mData = $this->requiDraft->selectTemp2ndFormRowDetails('*', array('auto_id' => $id, 'entry_user' => $userid));
                    if ($mData != NULL) {
                        $data['type'] = $type;
                        $data['mData'] = $mData;
                        $data['id'] = $id;
                        $data['orgList'] = $this->user->getUserMappOrgModel($userid, 'org.auto_id,org.org_name,mpp.org_id,mpp.status_flag', array('mpp.user_id' => $userid));
                        $data['postList'] = $this->postName->selectDetailsModel('auto_id,post_name', array());
                        $data['desigList'] = $this->designation->selectDetailsModel('auto_id,desig_name', array());
                        $data['deptList'] = $this->department->selectDetailsRowModel('auto_id,dept_name', array('auto_id' => $mData->dept_name));
                        $data['postEligList'] = $this->requiDraft->selectPostEligList('auto_id,post_name,eligibility', array('post_name' => $mData->m_criteria_eligibility_post));
                        $res = loadMenus();
                        $resp = $this->load->view('pages/' . $res . '/edit_draft_mapp_details', $data, TRUE);
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'editMappHTML' => $resp));
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

    function updateTemp2ndForm() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'Auto ID', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('type', 'Type', 'trim|required|max_length[4]|min_length[4]');
                $this->form_validation->set_rules('org_name1', 'Organisation name', 'trim|required|integer|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('dept_name1', 'Department name', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('officer_name1', 'Officer name', 'trim|required|max_length[65]|min_length[2]');
                $this->form_validation->set_rules('officer_desig1', 'Designation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('contact_no1', 'Contact no', 'trim|required|min_length[10]|max_length[10]');
                $this->form_validation->set_rules('officer_email1', 'Email id', 'trim|max_length[120]');
                $this->form_validation->set_rules('c_mode_recruitment1', 'Mode of recruitment', 'trim|required|max_length[25]|min_length[1]');
                $this->form_validation->set_rules('post_name1', 'Post name', 'trim|required|integer|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('a_group1', 'Group', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('b_pay_scale1', 'Pay Scale', 'trim|required|max_length[25]|min_length[1]');
                $this->form_validation->set_rules('d_ur_4', 'Unreserved', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_apst_4', 'APST', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_total_4', 'Total', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_pwd_4', 'PwD', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_ex_sm_4', 'Ex-SM', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_blindness_4', 'Blindness and Low Vision', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_deaf_4', 'Deaf and Hard of hearing', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_locomotor_4', 'Locomotor Disability including Cerebral Palsy, Leprosy Cured, Dwarfism, Acid Attack Victims and Muscular Dystrophy', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_autism_4', 'Autism, Intellectual Disability, Specific Learning Disability and Mental Illness', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_multiple_4', 'Multiple Disabilities from among persons under clauses (i) to (iv) including deaf-blindness', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_total_4', 'Total Category of disability', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('f_vac_worked_out_4', 'Whether the vacancies for the person with disabilities and Ex-Serviceman have been worked out with reference to the instructions contained in the Government of Arunachal Pradesh Orders', 'trim');
                $this->form_validation->set_rules('g_edu_others_4', 'Education and other qualification laid down in the Recruitment Rules', 'trim|required|max_length[225]|min_length[1]');
                $this->form_validation->set_rules('h_min_age_4', 'Minimum age', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('h_max_age_4', 'Maximum age', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_apst_4', 'APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_pwd_apst_4', 'PwD APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_pwd_ur_4', 'PwD UR age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_ex_sm_apst_4', 'Ex-Servicemen APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_ex_sm_ur_4', 'Ex-Servicemen UR age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('j_ban_restric_4', 'Whether there is any ban or restriction from the Govt. for filling up the post', 'trim');
                $this->form_validation->set_rules('file_copy_k_4', 'Upload latest Recruitment Rules file', 'trim');
                $this->form_validation->set_rules('l_other_requi_cond_4', 'Any other requirement or conditions not covered above', 'trim|required|min_length[2]|max_length[225]');
                $this->form_validation->set_rules('file_copy_l_4', 'Upload relevant orders file', 'trim');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $autoID = trim($this->security->xss_clean($this->input->post("auto_id")));
                    $type = trim($this->security->xss_clean($this->input->post("type")));
                    $orgName = trim($this->security->xss_clean($this->input->post("org_name1")));
                    $deptName = trim($this->security->xss_clean($this->input->post("dept_name1")));
                    $officerName = trim($this->security->xss_clean($this->input->post("officer_name1")));
                    $officerDesig = trim($this->security->xss_clean($this->input->post("officer_desig1")));
                    $contactNo = trim($this->security->xss_clean($this->input->post("contact_no1")));
                    $officerEmail = trim($this->security->xss_clean($this->input->post("officer_email1")));
                    $cModeRecuitment = trim($this->security->xss_clean($this->input->post("c_mode_recruitment1")));
                    $postName = trim($this->security->xss_clean($this->input->post("post_name1")));

                    $aGroup = trim($this->security->xss_clean($this->input->post("a_group1")));
                    $bPayScale = trim($this->security->xss_clean($this->input->post("b_pay_scale1")));
                    $dUR = trim($this->security->xss_clean($this->input->post("d_ur_4")));
                    $dAPST = trim($this->security->xss_clean($this->input->post("d_apst_4")));
                    $dTotal = trim($this->security->xss_clean($this->input->post("d_total_4")));
                    $dPwD = trim($this->security->xss_clean($this->input->post("d_pwd_4")));
                    $dExSm = trim($this->security->xss_clean($this->input->post("d_ex_sm_4")));
                    $eBlindness = trim($this->security->xss_clean($this->input->post("e_blindness_4")));
                    $eDeaf = trim($this->security->xss_clean($this->input->post("e_deaf_4")));
                    $eLocomotor = trim($this->security->xss_clean($this->input->post("e_locomotor_4")));
                    $eAutism = trim($this->security->xss_clean($this->input->post("e_autism_4")));
                    $eMultiple = trim($this->security->xss_clean($this->input->post("e_multiple_4")));
                    $eTotal = trim($this->security->xss_clean($this->input->post("e_total_4")));
                    $fVacWorkedOut = trim($this->security->xss_clean($this->input->post("f_vac_worked_out_4")));
                    $gEduOthers = trim($this->security->xss_clean($this->input->post("g_edu_others_4")));
                    $hMinAge = trim($this->security->xss_clean($this->input->post("h_min_age_4")));
                    $hMaxAge = trim($this->security->xss_clean($this->input->post("h_max_age_4")));
                    $iAPST = trim($this->security->xss_clean($this->input->post("i_apst_4")));
                    $iPwDApst = trim($this->security->xss_clean($this->input->post("i_pwd_apst_4")));
                    $iPwDUr = trim($this->security->xss_clean($this->input->post("i_pwd_ur_4")));
                    $iExSmApst = trim($this->security->xss_clean($this->input->post("i_ex_sm_apst_4")));
                    $iExSmUr = trim($this->security->xss_clean($this->input->post("i_ex_sm_ur_4")));
                    $jBanRectric = trim($this->security->xss_clean($this->input->post("j_ban_restric_4")));

                    $kFileCopy = trim($this->security->xss_clean($this->input->post("file_copy_k_4")));
                    $lOtherRequiCond = trim($this->security->xss_clean($this->input->post("l_other_requi_cond_4")));
                    $lFileCopy = trim($this->security->xss_clean($this->input->post("file_copy_l_4")));

                    $this->db->trans_start();
                    $mstID = $this->session->userdata('MSTID');

                    $file_kError = FALSE;
                    $file_kMsg = "";
                    $file_lError = FALSE;
                    $file_lMsg = "";
                    $targetDir = 'requisitions_documents';

                    $filename_k = $kFileCopy;
                    $filename_l = $lFileCopy;

                    if (isset($_FILES['file_k_4']) && $_FILES['file_k_4']['size'] > 0) {
                        $fileName = basename($_FILES['file_k_4']['name']);
                        $filename_k = 'RR_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_k;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_k_4']['tmp_name'], $fileUrl)) {
                                $file_kError = FALSE;
                                $file_kMsg = "";
                            } else {
                                $file_kError = TRUE;
                                $file_kMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_kError = TRUE;
                            $file_kMsg = "Invalid Recruitment Rules file format";
                        }
                    }

                    if (isset($_FILES['file_l_4']) && $_FILES['file_l_4']['size'] > 0) {
                        $fileName = basename($_FILES['file_l_4']['name']);
                        $filename_l = 'RO_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_l;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_l_4']['tmp_name'], $fileUrl)) {
                                $file_lError = FALSE;
                                $file_lMsg = "";
                            } else {
                                $file_lError = TRUE;
                                $file_lMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_lError = TRUE;
                            $file_lMsg = "Invalid relevant orders file format";
                        }
                    }

                    $mappData = array(
                        'org_name' => trim($orgName),
                        'dept_name' => trim($deptName),
                        'officer_name' => trim(strtoupper($officerName)),
                        'officer_desig' => trim($officerDesig),
                        'contact_no' => trim($contactNo),
                        'officer_email' => trim($officerEmail),
                        'post_name' => trim($postName),
                        'a_group' => trim($aGroup),
                        'b_pay_scale' => trim($bPayScale),
                        'c_mode_recruitment' => trim($cModeRecuitment),
                        'd_ur' => trim($dUR),
                        'd_apst' => trim($dAPST),
                        'd_total' => trim($dTotal),
                        'd_pwd' => trim($dPwD),
                        'd_ex_sm' => trim($dExSm),
                        'e_blindness' => trim($eBlindness),
                        'e_deaf' => trim($eDeaf),
                        'e_locomotor' => trim($eLocomotor),
                        'e_autism' => trim($eAutism),
                        'e_multiple' => trim($eMultiple),
                        'e_total' => trim($eTotal),
                        'f_vac_worked_out' => trim($fVacWorkedOut),
                        'g_edu_others' => trim($gEduOthers),
                        'h_min_age' => trim($hMinAge),
                        'h_max_age' => trim($hMaxAge),
                        'i_apst' => trim($iAPST),
                        'i_pwd_apst' => trim($iPwDApst),
                        'i_pwd_ur' => trim($iPwDUr),
                        'i_ex_sm_apst' => trim($iExSmApst),
                        'i_ex_sm_ur' => trim($iExSmUr),
                        'j_ban_restric' => trim($jBanRectric),
                        'file_copy_k_rr' => trim($filename_k),
                        'l_other_requi_cond' => trim($lOtherRequiCond),
                        'file_copy_l_ro' => trim($filename_l),
                        'm_criteria_eligibility_post' => '',
                        'm_criteria_eligibility' => '',
                        'file_copy_n_list_cands' => '',
                        'file_copy_o_list_cands' => '',
                        'entry_datetime' => date('Y-m-d H:i:s'),
                        'sys_ip' => $this->input->ip_address(),
                        'entry_user' => $userid,
                        'updated_datetime' => date('Y-m-d H:i:s')
                    );

                    if ($file_kError == FALSE && $file_lError == FALSE) {
                        if ($this->requiDraft->updateTemp2ndFormDetails(array('auto_id' => $autoID, 'entry_user' => $userid), $mappData)) {
                            if ($type == "list") {
                                echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'type' => $type, 'mstid' => $mstID, 'msg' => 'Details updated successfully'));
                            } else {
                                $mData = $this->requiDraft->selectTemp2ndFormWithPostDetails('mm.auto_id,pp.post_name,mm.c_mode_recruitment', array('mm.mst_id' => $mstID));
                                $html = "";
                                if ($mData != null) {
                                    $sno = 1;
                                    foreach ($mData as $mRow) {
                                        $html .= '<div class="col-md-2">
                                                        <div class="form-group">
                                                            <div class="small-box">
                                                                <div class="inner">';
                                        $html .= '<p><span class="float-right badge badge-primary">' . $sno . '</span> ' . $mRow->post_name . '</p>';
                                        $modeRec = $mRow->c_mode_recruitment;
                                        if ($modeRec == 'L') {
                                            $html .= '<span class="badge badge-danger">LDCE RECRUITMENT</span>';
                                        } else {
                                            $html .= '<span class="badge badge-success">DIRECT RECRUITMENT</span>';
                                        }
                                        $html .= '</div>
                                                <div class="icon">
                                                    <i class="ion ion-bag"></i>
                                                </div>
                                                <div class="small-box-footer">
                                                    <button title="Edit Details" onclick="editMappRecord(' . $mRow->auto_id . ')" type="button"  class="btn btn-xs btn-outline-info mr-2"> <i class="fa fa-file"></i></button>
                                                    <button title="Delete Record" onclick="delMappRecord(' . $mRow->auto_id . ')" type="button" class="btn btn-xs btn-outline-danger"> <i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                        $sno++;
                                    }
                                }
                                echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'type' => $type, 'mstid' => $mstID, 'msg' => 'Details added successfully', 'html' => $html, 'mapp_count' => count($mData)));
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to update record!'));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $file_kMsg . ' ' . $file_lMsg));
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

    function updateTemp3rdForm() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'Auto ID', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('type', 'Type', 'trim|required|max_length[4]|min_length[4]');
                $this->form_validation->set_rules('org_name1', 'Organisation name', 'trim|required|integer|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('dept_name1', 'Department name', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('officer_name1', 'Officer name', 'trim|required|max_length[65]|min_length[2]');
                $this->form_validation->set_rules('officer_desig1', 'Designation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('contact_no1', 'Contact no', 'trim|required|min_length[10]|max_length[10]');
                $this->form_validation->set_rules('officer_email1', 'Email id', 'trim|max_length[120]');
                $this->form_validation->set_rules('c_mode_recruitment1', 'Mode of recruitment', 'trim|required|max_length[25]|min_length[1]');
                $this->form_validation->set_rules('post_name1', 'Post name', 'trim|required|integer|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('a_group1', 'Group', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('b_pay_scale1', 'Pay Scale', 'trim|required|max_length[25]|min_length[1]');
                $this->form_validation->set_rules('d_ur_5', 'Unreserved', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_apst_5', 'APST', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_total_5', 'Total', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_pwd_5', 'PwD', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('d_ex_sm_5', 'Ex-SM', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_blindness_5', 'Blindness and Low Vision', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_deaf_5', 'Deaf and Hard of hearing', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_locomotor_5', 'Locomotor Disability including Cerebral Palsy, Leprosy Cured, Dwarfism, Acid Attack Victims and Muscular Dystrophy', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_autism_5', 'Autism, Intellectual Disability, Specific Learning Disability and Mental Illness', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_multiple_5', 'Multiple Disabilities from among persons under clauses (i) to (iv) including deaf-blindness', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('e_total_5', 'Total Category of disability', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('f_vac_worked_out_5', 'Whether the vacancies for the person with disabilities and Ex-Serviceman have been worked out with reference to the instructions contained in the Government of Arunachal Pradesh Orders', 'trim');
                $this->form_validation->set_rules('g_edu_others_5', 'Education and other qualification laid down in the Recruitment Rules', 'trim|required|max_length[225]|min_length[1]');
                $this->form_validation->set_rules('h_min_age_5', 'Minimum age', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('h_max_age_5', 'Maximum age', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_apst_5', 'APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_pwd_apst_5', 'PwD APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_pwd_ur_5', 'PwD UR age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_ex_sm_apst_5', 'Ex-Servicemen APST age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_ex_sm_ur_5', 'Ex-Servicemen UR age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('j_ban_restric_5', 'Whether there is any ban or restriction from the Govt. for filling up the post', 'trim');
                $this->form_validation->set_rules('file_copy_k_5', 'Upload latest Recruitment Rules file', 'trim');
                $this->form_validation->set_rules('l_other_requi_cond_5', 'Any other requirement or conditions not covered above', 'trim|required|min_length[2]|max_length[225]');
                $this->form_validation->set_rules('m_crit_elig_post_5', 'Select name of post', 'trim|required|min_length[3]|max_length[6]');
                $this->form_validation->set_rules('m_crit_elig_5', 'Select criteria of eligibility', 'trim|required|integer|min_length[1]|max_length[11]');
                $this->form_validation->set_rules('file_copy_n_5', 'Upload detailed list of eligible candidates(in pdf file)', 'trim');
                $this->form_validation->set_rules('file_copy_o_5', 'Upload detailed list of eligible candidates(in xls|xlsx file)', 'trim');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $autoID = trim($this->security->xss_clean($this->input->post("auto_id")));
                    $type = trim($this->security->xss_clean($this->input->post("type")));
                    $orgName = trim($this->security->xss_clean($this->input->post("org_name1")));
                    $deptName = trim($this->security->xss_clean($this->input->post("dept_name1")));
                    $officerName = trim($this->security->xss_clean($this->input->post("officer_name1")));
                    $officerDesig = trim($this->security->xss_clean($this->input->post("officer_desig1")));
                    $contactNo = trim($this->security->xss_clean($this->input->post("contact_no1")));
                    $officerEmail = trim($this->security->xss_clean($this->input->post("officer_email1")));
                    $cModeRecuitment = trim($this->security->xss_clean($this->input->post("c_mode_recruitment1")));
                    $postName = trim($this->security->xss_clean($this->input->post("post_name1")));
                    $aGroup = trim($this->security->xss_clean($this->input->post("a_group1")));
                    $bPayScale = trim($this->security->xss_clean($this->input->post("b_pay_scale1")));
                    $dUR = trim($this->security->xss_clean($this->input->post("d_ur_5")));
                    $dAPST = trim($this->security->xss_clean($this->input->post("d_apst_5")));
                    $dTotal = trim($this->security->xss_clean($this->input->post("d_total_5")));
                    $dPwD = trim($this->security->xss_clean($this->input->post("d_pwd_5")));
                    $dExSm = trim($this->security->xss_clean($this->input->post("d_ex_sm_5")));
                    $eBlindness = trim($this->security->xss_clean($this->input->post("e_blindness_5")));
                    $eDeaf = trim($this->security->xss_clean($this->input->post("e_deaf_5")));
                    $eLocomotor = trim($this->security->xss_clean($this->input->post("e_locomotor_5")));
                    $eAutism = trim($this->security->xss_clean($this->input->post("e_autism_5")));
                    $eMultiple = trim($this->security->xss_clean($this->input->post("e_multiple_5")));
                    $eTotal = trim($this->security->xss_clean($this->input->post("e_total_5")));
                    $fVacWorkedOut = trim($this->security->xss_clean($this->input->post("f_vac_worked_out_5")));
                    $gEduOthers = trim($this->security->xss_clean($this->input->post("g_edu_others_5")));
                    $hMinAge = trim($this->security->xss_clean($this->input->post("h_min_age_5")));
                    $hMaxAge = trim($this->security->xss_clean($this->input->post("h_max_age_5")));
                    $iAPST = trim($this->security->xss_clean($this->input->post("i_apst_5")));
                    $iPwDApst = trim($this->security->xss_clean($this->input->post("i_pwd_apst_5")));
                    $iPwDUr = trim($this->security->xss_clean($this->input->post("i_pwd_ur_5")));
                    $iExSmApst = trim($this->security->xss_clean($this->input->post("i_ex_sm_apst_5")));
                    $iExSmUr = trim($this->security->xss_clean($this->input->post("i_ex_sm_ur_5")));
                    $jBanRectric = trim($this->security->xss_clean($this->input->post("j_ban_restric_5")));
                    $kFileCopy = trim($this->security->xss_clean($this->input->post("file_copy_k_5")));
                    $lOtherRequiCond = trim($this->security->xss_clean($this->input->post("l_other_requi_cond_5")));
                    $lFileCopy = trim($this->security->xss_clean($this->input->post("file_copy_l_5")));
                    $mCritPost = trim($this->security->xss_clean($this->input->post("m_crit_elig_post_5")));
                    $mCritElig = trim($this->security->xss_clean($this->input->post("m_crit_elig_5")));
                    $nFileCopy = trim($this->security->xss_clean($this->input->post("file_copy_n_5")));
                    $oFileCopy = trim($this->security->xss_clean($this->input->post("file_copy_o_5")));

                    $this->db->trans_start();
                    $mstID = $this->session->userdata('MSTID');

                    $file_kError = FALSE;
                    $file_kMsg = "";
                    $file_lError = FALSE;
                    $file_lMsg = "";
                    $targetDir = 'requisitions_documents';

                    $filename_k = $kFileCopy;
                    $filename_l = $lFileCopy;
                    $filename_n = $nFileCopy;
                    $filename_o = $oFileCopy;
                    if (isset($_FILES['file_k_5']) && $_FILES['file_k_5']['size'] > 0) {
                        $fileName = basename($_FILES['file_k_5']['name']);
                        $filename_k = 'RR_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_k;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_k_5']['tmp_name'], $fileUrl)) {
                                $file_kError = FALSE;
                                $file_kMsg = "";
                            } else {
                                $file_kError = TRUE;
                                $file_kMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_kError = TRUE;
                            $file_kMsg = "Invalid Recruitment Rules file format";
                        }
                    }

                    if (isset($_FILES['file_l_5']) && $_FILES['file_l_5']['size'] > 0) {
                        $fileName = basename($_FILES['file_l_5']['name']);
                        $filename_l = 'RO_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_l;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_l_5']['tmp_name'], $fileUrl)) {
                                $file_lError = FALSE;
                                $file_lMsg = "";
                            } else {
                                $file_lError = TRUE;
                                $file_lMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_lError = TRUE;
                            $file_lMsg = "Invalid relevant orders file format";
                        }
                    }

                    if (isset($_FILES['file_n_5']) && $_FILES['file_n_5']['size'] > 0) {
                        $fileName = basename($_FILES['file_n_5']['name']);
                        $filename_n = 'LIST_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_n;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_n_5']['tmp_name'], $fileUrl)) {
                                $file_lError = FALSE;
                                $file_lMsg = "";
                            } else {
                                $file_lError = TRUE;
                                $file_lMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_lError = TRUE;
                            $file_lMsg = "Invalid relevant orders file format";
                        }
                    }

                    if (isset($_FILES['file_o_5']) && $_FILES['file_o_5']['size'] > 0) {
                        $fileName = basename($_FILES['file_o_5']['name']);
                        $filename_o = 'LIST_' . date('dmyhis') . '.xls';
                        $fileUrl = 'requisitions_documents/' . $filename_o;
                        $allowTypes = array('xls', 'xlsx');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_o_5']['tmp_name'], $fileUrl)) {
                                $file_lError = FALSE;
                                $file_lMsg = "";
                            } else {
                                $file_lError = TRUE;
                                $file_lMsg = "Something went wrong. Unable to upload file";
                            }
                        } else {
                            $file_lError = TRUE;
                            $file_lMsg = "Invalid relevant orders file format";
                        }
                    }

                    $mappData = array(
                        'org_name' => trim($orgName),
                        'dept_name' => trim($deptName),
                        'officer_name' => trim(strtoupper($officerName)),
                        'officer_desig' => trim($officerDesig),
                        'contact_no' => trim($contactNo),
                        'officer_email' => trim($officerEmail),
                        'post_name' => trim($postName),
                        'a_group' => trim($aGroup),
                        'b_pay_scale' => trim($bPayScale),
                        'c_mode_recruitment' => trim($cModeRecuitment),
                        'd_ur' => trim($dUR),
                        'd_apst' => trim($dAPST),
                        'd_total' => trim($dTotal),
                        'd_pwd' => trim($dPwD),
                        'd_ex_sm' => trim($dExSm),
                        'e_blindness' => trim($eBlindness),
                        'e_deaf' => trim($eDeaf),
                        'e_locomotor' => trim($eLocomotor),
                        'e_autism' => trim($eAutism),
                        'e_multiple' => trim($eMultiple),
                        'e_total' => trim($eTotal),
                        'f_vac_worked_out' => trim($fVacWorkedOut),
                        'g_edu_others' => trim($gEduOthers),
                        'h_min_age' => trim($hMinAge),
                        'h_max_age' => trim($hMaxAge),
                        'i_apst' => trim($iAPST),
                        'i_pwd_apst' => trim($iPwDApst),
                        'i_pwd_ur' => trim($iPwDUr),
                        'i_ex_sm_apst' => trim($iExSmApst),
                        'i_ex_sm_ur' => trim($iExSmUr),
                        'j_ban_restric' => trim($jBanRectric),
                        'file_copy_k_rr' => trim($filename_k),
                        'l_other_requi_cond' => trim($lOtherRequiCond),
                        'file_copy_l_ro' => trim($filename_l),
                        'm_criteria_eligibility_post' => $mCritPost,
                        'm_criteria_eligibility' => $mCritElig,
                        'file_copy_n_list_cands' => $filename_n,
                        'file_copy_o_list_cands' => $filename_o,
                        'entry_datetime' => date('Y-m-d H:i:s'),
                        'sys_ip' => $this->input->ip_address(),
                        'entry_user' => $userid,
                        'mst_id' => $mstID,
                        'updated_datetime' => date('Y-m-d H:i:s')
                    );

                    if ($file_kError == FALSE && $file_lError == FALSE) {
                        if ($this->requiDraft->updateTemp2ndFormDetails(array('auto_id' => $autoID, 'entry_user' => $userid), $mappData)) {
                            if ($type == "list") {
                                echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'type' => $type, 'mstid' => $mstID, 'msg' => 'Details updated successfully'));
                            } else {
                                $mData = $this->requiDraft->selectTemp2ndFormWithPostDetails('mm.auto_id,pp.post_name,mm.c_mode_recruitment', array('mm.mst_id' => $mstID));
                                $html = "";
                                if ($mData != null) {
                                    $sno = 1;
                                    foreach ($mData as $mRow) {
                                        $html .= '<div class="col-md-2">
                                                        <div class="form-group">
                                                            <div class="small-box">
                                                                <div class="inner">';
                                        $html .= '<p><span class="float-right badge badge-primary">' . $sno . '</span> ' . $mRow->post_name . '</p>';
                                        $modeRec = $mRow->c_mode_recruitment;
                                        if ($modeRec == 'L') {
                                            $html .= '<span class="badge badge-danger">LDCE RECRUITMENT</span>';
                                        } else {
                                            $html .= '<span class="badge badge-success">DIRECT RECRUITMENT</span>';
                                        }
                                        $html .= '</div>
                                                <div class="icon">
                                                    <i class="ion ion-bag"></i>
                                                </div>
                                                <div class="small-box-footer">
                                                    <button title="Edit Details" onclick="editMappRecord(' . $mRow->auto_id . ')" type="button"  class="btn btn-xs btn-outline-info mr-2"> <i class="fa fa-file"></i></button>
                                                    <button title="Delete Record" onclick="delMappRecord(' . $mRow->auto_id . ')" type="button" class="btn btn-xs btn-outline-danger"> <i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                        $sno++;
                                    }
                                }
                                echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'type' => $type, 'mstid' => $mstID, 'msg' => 'Details added successfully', 'html' => $html, 'mapp_count' => count($mData)));
                            }
                        } else {
                            echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => 'Unable to update record!'));
                        }
                    } else {
                        echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => $file_kMsg . ' ' . $file_lMsg));
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

    function deleteTempMapping() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id', 'Master ID', 'trim|required|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('type', 'Type', 'trim|required|max_length[4]|min_length[4]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $type = trim($this->security->xss_clean($this->input->post('type')));
                    $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                    $mData = $this->requiDraft->selectTemp2ndFormDetails('auto_id', array('auto_id' => $auto_id, 'entry_user' => $userid));
                    if ($mData != NULL) {
                        $mstID = $this->session->userdata('MSTID');
                        if ($this->requiDraft->deleteTempRequiModel(array('auto_id' => $auto_id))) {
                            if ($type == 'list') {
                                echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'type' => $type, 'msg' => 'Record deleted successfully'));
                            } else {
                                $mData = $this->requiDraft->selectTemp2ndFormWithPostDetails('mm.auto_id,pp.post_name,mm.c_mode_recruitment', array('mm.mst_id' => $mstID));
                                $html = "";
                                if ($mData != null) {
                                    $sno = 1;
                                    foreach ($mData as $mRow) {
                                        $html .= '<div class="col-md-2">
                                                        <div class="form-group">
                                                            <div class="small-box">
                                                                <div class="inner">';
                                        $html .= '<p><span class="float-right badge badge-primary">' . $sno . '</span> ' . $mRow->post_name . '</p>';
                                        $modeRec = $mRow->c_mode_recruitment;
                                        if ($modeRec == 'L') {
                                            $html .= '<span class="badge badge-danger">LDCE RECRUITMENT</span>';
                                        } else {
                                            $html .= '<span class="badge badge-success">DIRECT RECRUITMENT</span>';
                                        }
                                        $html .= '</div>
                                                <div class="icon">
                                                    <i class="ion ion-bag"></i>
                                                </div>
                                                <div class="small-box-footer">
                                                    <button title="Edit Details" onclick="editMappRecord(' . $mRow->auto_id . ')" type="button"  class="btn btn-xs btn-outline-info mr-2"> <i class="fa fa-file"></i></button>
                                                    <button title="Delete Record" onclick="delMappRecord(' . $mRow->auto_id . ')" type="button" class="btn btn-xs btn-outline-danger"> <i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                        $sno++;
                                    }
                                }
                                echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'type' => $type, 'msg' => 'Record deleted successfully', 'html' => $html, 'mapp_count' => count($mData)));
                            }
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

    function printDraft() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'ID', 'trim|required|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('type', 'Type', 'trim|required|max_length[4]|min_length[4]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $type = trim($this->security->xss_clean($this->input->post('type')));
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    if ($type == 'list') {
                        $mData = $this->requiDraft->select2ndFromCompData('mm.auto_id,org.org_name,dept.dept_name,mm.officer_name,desig.desig_name,mm.contact_no,mm.officer_email,pp.post_name,mm.a_group,mm.b_pay_scale,mm.c_mode_recruitment,mm.d_ur,mm.d_apst,mm.d_total,mm.d_pwd,mm.d_ex_sm,mm.e_blindness,mm.e_deaf,mm.e_locomotor,mm.e_autism,mm.e_multiple,mm.e_total,mm.f_vac_worked_out,mm.g_edu_others,mm.h_min_age,mm.h_max_age,mm.i_apst,mm.i_pwd_apst,mm.i_pwd_ur,mm.i_ex_sm_apst,mm.i_ex_sm_ur,mm.j_ban_restric,mm.file_copy_k_rr,mm.l_other_requi_cond,mm.file_copy_l_ro,mm.m_criteria_eligibility,mm.m_criteria_eligibility_post,mm.m_criteria_eligibility,mm.file_copy_n_list_cands,mm.file_copy_o_list_cands,pem.eligibility', array('mm.auto_id' => $id, 'mm.entry_user' => $userid));
                    } else {
                        $mData = $this->requiDraft->select2ndFromCompData('mm.auto_id,org.org_name,dept.dept_name,mm.officer_name,desig.desig_name,mm.contact_no,mm.officer_email,pp.post_name,mm.a_group,mm.b_pay_scale,mm.c_mode_recruitment,mm.d_ur,mm.d_apst,mm.d_total,mm.d_pwd,mm.d_ex_sm,mm.e_blindness,mm.e_deaf,mm.e_locomotor,mm.e_autism,mm.e_multiple,mm.e_total,mm.f_vac_worked_out,mm.g_edu_others,mm.h_min_age,mm.h_max_age,mm.i_apst,mm.i_pwd_apst,mm.i_pwd_ur,mm.i_ex_sm_apst,mm.i_ex_sm_ur,mm.j_ban_restric,mm.file_copy_k_rr,mm.l_other_requi_cond,mm.file_copy_l_ro,mm.m_criteria_eligibility,mm.m_criteria_eligibility_post,mm.m_criteria_eligibility,mm.file_copy_n_list_cands,mm.file_copy_o_list_cands,pem.eligibility', array('mm.mst_id' => $id, 'mm.entry_user' => $userid));
                    }
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
                        $epass_header = $this->load->view('pages/' . $res . '/print_draft_details', $data, TRUE);
                        $mpdf->SetHTMLFooter($footer);
                        $mpdf->WriteHTML($epass_header);
                        $mpdf->Output('vendor/temp_pdf/' . $id . '.pdf');
                        echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'fileUrl' => base_url('vendor/temp_pdf/' . $id . '.pdf')));
                    }
                }
            } else {
                echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
            }
        } else {
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'You are not authorized to perform these operation!'));
        }
    }

    function viewData() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'Master ID', 'trim|required|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('type', 'Type', 'trim|required|max_length[4]|min_length[4]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $type = trim($this->security->xss_clean($this->input->post('type')));
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    if ($type == 'list') {
                        $mData = $this->requiDraft->select2ndFromCompData('mm.auto_id,org.org_name,dept.dept_name,mm.officer_name,desig.desig_name,mm.contact_no,mm.officer_email,pp.post_name,mm.a_group,mm.b_pay_scale,mm.c_mode_recruitment,mm.d_ur,mm.d_apst,mm.d_total,mm.d_pwd,mm.d_ex_sm,mm.e_blindness,mm.e_deaf,mm.e_locomotor,mm.e_autism,mm.e_multiple,mm.e_total,mm.f_vac_worked_out,mm.g_edu_others,mm.h_min_age,mm.h_max_age,mm.i_apst,mm.i_pwd_apst,mm.i_pwd_ur,mm.i_ex_sm_apst,mm.i_ex_sm_ur,mm.j_ban_restric,mm.file_copy_k_rr,mm.l_other_requi_cond,mm.file_copy_l_ro,mm.m_criteria_eligibility,mm.m_criteria_eligibility_post,mm.m_criteria_eligibility,mm.file_copy_n_list_cands,mm.file_copy_o_list_cands,pem.eligibility', array('mm.auto_id' => $id, 'mm.entry_user' => $userid));
                    } else {
                        $mData = $this->requiDraft->select2ndFromCompData('mm.auto_id,org.org_name,dept.dept_name,mm.officer_name,desig.desig_name,mm.contact_no,mm.officer_email,pp.post_name,mm.a_group,mm.b_pay_scale,mm.c_mode_recruitment,mm.d_ur,mm.d_apst,mm.d_total,mm.d_pwd,mm.d_ex_sm,mm.e_blindness,mm.e_deaf,mm.e_locomotor,mm.e_autism,mm.e_multiple,mm.e_total,mm.f_vac_worked_out,mm.g_edu_others,mm.h_min_age,mm.h_max_age,mm.i_apst,mm.i_pwd_apst,mm.i_pwd_ur,mm.i_ex_sm_apst,mm.i_ex_sm_ur,mm.j_ban_restric,mm.file_copy_k_rr,mm.l_other_requi_cond,mm.file_copy_l_ro,mm.m_criteria_eligibility,mm.m_criteria_eligibility_post,mm.m_criteria_eligibility,mm.file_copy_n_list_cands,mm.file_copy_o_list_cands,pem.eligibility', array('mm.mst_id' => $id, 'mm.entry_user' => $userid));
                    }
                    if ($mData != NULL) {
                        $res = loadMenus();
                        $mstSettings = $this->requi->selectSettingsModel('*', array('auto_id' => 1));
                        $this->session->set_userdata(array('newReqForm' => $mstSettings->requisition_form_flag));
                        $data['type'] = $type;
                        $data['mData'] = $mData;
                        $data['id'] = $id;
                        $data['newReqForm'] = $mstSettings->requisition_form_flag;
                        $resp = $this->load->view('pages/' . $res . '/view_draft_details', $data, TRUE);
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

    function finalSubmitReqData() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        $mstSettings = $this->requi->selectSettingsModel('*', array('auto_id' => 1));
        if ($userid != "" && in_array($role, array('UR')) && $mstSettings->requisition_form_flag == 1) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('id', 'Master ID', 'trim|required|max_length[20]|min_length[1]');
                $this->form_validation->set_rules('type', 'Type', 'trim|required|max_length[4]|min_length[4]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $type = trim($this->security->xss_clean($this->input->post('type')));
                    $id = trim($this->security->xss_clean($this->input->post('id')));
                    if ($type == 'list') {
                        $mData = $this->requiDraft->selectTemp2ndFormDetails('*', array('auto_id' => $id, 'entry_user' => $userid));
                    } else {
                        $mData = $this->requiDraft->selectTemp2ndFormDetails('*', array('mst_id' => $id, 'entry_user' => $userid));
                    }
                    if ($mData != NULL) {
                        $mappDataArr = array();
                        if ($mData != NULL) {
                            foreach ($mData as $mRow) {
                                $mappDataArr[] = array(
                                    'org_name' => $mRow->org_name,
                                    'dept_name' => $mRow->dept_name,
                                    'officer_name' => $mRow->officer_name,
                                    'officer_desig' => $mRow->officer_desig,
                                    'contact_no' => $mRow->contact_no,
                                    'officer_email' => $mRow->officer_email,
                                    'post_name' => $mRow->post_name,
                                    'a_group' => $mRow->a_group,
                                    'b_pay_scale' => $mRow->b_pay_scale,
                                    'c_mode_recruitment' => $mRow->c_mode_recruitment,
                                    'd_ur' => $mRow->d_ur,
                                    'd_apst' => $mRow->d_apst,
                                    'd_total' => $mRow->d_total,
                                    'd_pwd' => $mRow->d_pwd,
                                    'd_ex_sm' => $mRow->d_ex_sm,
                                    'e_blindness' => $mRow->e_blindness,
                                    'e_deaf' => $mRow->e_deaf,
                                    'e_locomotor' => $mRow->e_locomotor,
                                    'e_autism' => $mRow->e_autism,
                                    'e_multiple' => $mRow->e_multiple,
                                    'e_total' => $mRow->e_total,
                                    'f_vac_worked_out' => $mRow->f_vac_worked_out,
                                    'g_edu_others' => $mRow->g_edu_others,
                                    'h_min_age' => $mRow->h_min_age,
                                    'h_max_age' => $mRow->h_max_age,
                                    'i_apst' => $mRow->i_apst,
                                    'i_pwd_apst' => $mRow->i_pwd_apst,
                                    'i_pwd_ur' => $mRow->i_pwd_ur,
                                    'i_ex_sm_apst' => $mRow->i_ex_sm_apst,
                                    'i_ex_sm_ur' => $mRow->i_ex_sm_ur,
                                    'j_ban_restric' => $mRow->j_ban_restric,
                                    'file_copy_k_rr' => $mRow->file_copy_k_rr,
                                    'l_other_requi_cond' => $mRow->l_other_requi_cond,
                                    'file_copy_l_ro' => $mRow->file_copy_l_ro,
                                    'm_criteria_eligibility_post' => $mRow->m_criteria_eligibility_post,
                                    'm_criteria_eligibility' => $mRow->m_criteria_eligibility,
                                    'file_copy_n_list_cands' => $mRow->file_copy_n_list_cands,
                                    'file_copy_o_list_cands' => $mRow->file_copy_o_list_cands,
                                    'entry_datetime' => $mRow->entry_datetime,
                                    'sent_datetime' => date('Y-m-d H:i:s'),
                                    'sys_ip' => $this->input->ip_address(),
                                    'entry_user' => $userid,
                                    'mst_id' => $mRow->mst_id
                                );
                            }
                            $this->db->trans_start();
                            $this->requi->saveTemp2ndFormBatchModel($mappDataArr);
                            if ($type == 'list') {
                                $this->requiDraft->deleteTempModel(array('auto_id' => $id));
                            } else {
                                $this->requiDraft->deleteTempModel(array('mst_id' => $id));
                                $this->session->set_userdata('MSTID', '');
                            }
                            $this->session->set_flashdata('message', 'Details sent successfully');
                            echo json_encode(array('status' => TRUE, 'logout' => FALSE, 'msg' => 'Details sent successfully'));
                        }
                    } else {
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
            $this->session->set_flashdata('message', 'Session Expired!.You are not authorized to perform these operation');
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'You are not authorized to perform these operation!'));
        }
    }

    function loadCriteriaEligibility() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('UR'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('post_name', 'Post name', 'trim|required|min_length[3]|max_length[6]');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $post_name = trim($this->security->xss_clean($this->input->post('post_name')));
                    $data = $this->requiDraft->selectPostEligList('auto_id,post_name,eligibility', array('post_name' => $post_name));
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
