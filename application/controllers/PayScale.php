<?php

class PayScale extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('PayScaleModel', 'payScale', TRUE);
    }

    function index() {
        $this->load->view('pages/commons/1_header');
        $this->load->view('pages/commons/2_top_navbar');
        $data['submenu'] = "payscale";
        $this->load->view('pages/commons/3_main_menu', $data);
        $this->load->view('pages/admin/list_pay_scale');
        $this->load->view('pages/commons/4_footer');
    }

    function ajax_list() {
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $userid = $this->session->userdata('uid');
            $role = $this->session->userdata('role');
            if ($userid != "" && in_array($role, array('A'))) {
                $list = $this->payScale->list_databales(array());
                $count_rec = $this->payScale->list_filtered(array());
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
                    $row[] = strtoupper($accrow->pay_scale);
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
                $this->form_validation->set_rules('pay_scale', 'Group name is required', 'trim|required|max_length[65]|min_length[2]');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'msg' => validation_errors()));
                } else {
                    $pay_scale = trim($this->security->xss_clean($this->input->post("pay_scale")));
                    $this->db->trans_start();
                    if ($add_update == 'add') {
                        $details = $this->payScale->selectDetailsModel('pay_scale', array('pay_scale' => trim($pay_scale)));
                        $data = array(
                            'pay_scale' => trim(strtoupper($pay_scale)),
                            'entry_datetime' => date('Y-m-d H:i:s'),
                            'entry_by' => $userid,
                            'sys_ip' => $this->input->ip_address()
                        );
                        if ($details == NULL) {
                            $this->payScale->saveDetailsModel($data);
                            echo json_encode(array('status' => TRUE, 'msg' => 'Details added successfully!'));
                        } else {
                            echo json_encode(array('status' => FALSE, 'msg' => 'Group name is already exist!'));
                        }
                    }

                    if ($add_update == 'update') {
                        $auto_id = trim($this->security->xss_clean($this->input->post('auto_id')));
                        if (preg_match('/^\d+$/D', $auto_id) && $auto_id == $this->session->userdata('pid')) {
                            $data = array(
                                'pay_scale' => trim(strtoupper($pay_scale)),
                                'last_update_datetime' => date('Y-m-d H:i:s'),
                                'sys_ip' => $this->input->ip_address()
                            );

                            if ($this->session->userdata('pname') != $pay_scale) {
                                $details = $this->payScale->selectDetailsModel('pay_scale', array('pay_scale' => trim($pay_scale)));
                                if ($details == NULL) {
                                    $this->payScale->updateDetailsModel(array('auto_id' => $auto_id), $data);
                                    echo json_encode(array('status' => TRUE, 'msg' => 'Details updates successfully!'));
                                } else {
                                    echo json_encode(array('status' => FALSE, 'msg' => 'Group name is already exist!'));
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
                $data = $this->payScale->selectDetailsRowModel('auto_id,pay_scale', array('auto_id' => $id));
                $resdata = null;
                if ($data != null) {
                    $resdata = array(
                        'auto_id' => $data->auto_id,
                        'pay_scale' => strtoupper($data->pay_scale)
                    );
                    $this->session->set_userdata('pid', $data->auto_id);
                    $this->session->set_userdata('pname', $data->pay_scale);
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
                    $this->payScale->deleteDetailsModel($auto_id);
                    echo json_encode(array('status' => TRUE, 'msg' => 'Record deleted successfully'));
                } else {
                    echo json_encode(array('status' => FALSE, 'msg' => 'You are not authorized to perform these operation!'));
                }
            }
        }
    }

    function update5thForm() {
        $userid = $this->session->userdata('uid');
        $role = $this->session->userdata('role');
        if ($userid != "" && in_array($role, array('A', 'E'))) {
            if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $this->form_validation->set_rules('auto_id5', 'Auto ID', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('mst_id5', 'Master ID', 'trim|required|max_length[20]|min_length[20]');
                $this->form_validation->set_rules('post_name_5', 'Post name', 'trim|required|integer|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('a_group_5', 'Group', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('b_pay_scale_5', 'Pay Scale', 'trim|required|max_length[25]|min_length[1]');
                $this->form_validation->set_rules('c_mode_recruitment_5', 'Mode of recruitment', 'trim|required|max_length[25]|min_length[1]');
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
                $this->form_validation->set_rules('i_pwd_5', 'PwD age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('i_ex_sm_5', 'Ex-Servicemen age relaxation', 'trim|required|max_length[7]|min_length[1]');
                $this->form_validation->set_rules('j_ban_restric_5', 'Whether there is any ban or restriction from the Govt. for filling up the post', 'trim');
                $this->form_validation->set_rules('file_copy_k_5', 'Upload latest Recruitment Rules file', 'trim');
                $this->form_validation->set_rules('l_other_requi_cond_5', 'Any other requirement or conditions not covered above', 'trim|required|min_length[2]|max_length[225]');
                $this->form_validation->set_rules('file_copy_l_5', 'Upload relevant orders file', 'trim');
                $this->form_validation->set_rules('m_crit_elig_5', 'Specify the Criteria of Eligibility under which the LDCE post falls, as per Recruitment Rule', 'trim|required|min_length[2]|max_length[225]');
                $this->form_validation->set_rules('n_list_elig_cand_5', 'Whether a detailed list of eligible candidates (as on 1st January of the Year) duly verified by the HoD has been enclosed?', 'trim');
                $this->form_validation->set_rules('file_copy_n_5', 'Upload detailed list of eligible candidates', 'trim');

                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('status' => FALSE, 'logout' => FALSE, 'msg' => validation_errors()));
                } else {
                    $autoID = trim($this->security->xss_clean($this->input->post("auto_id5")));
                    $postName = trim($this->security->xss_clean($this->input->post("post_name_5")));
                    $aGroup = trim($this->security->xss_clean($this->input->post("a_group_5")));
                    $bPayScale = trim($this->security->xss_clean($this->input->post("b_pay_scale_5")));
                    $cModeRecuitment = trim($this->security->xss_clean($this->input->post("c_mode_recruitment_5")));
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
                    $iPwD = trim($this->security->xss_clean($this->input->post("i_pwd_5")));
                    $iExSm = trim($this->security->xss_clean($this->input->post("i_ex_sm_5")));
                    $jBanRectric = trim($this->security->xss_clean($this->input->post("j_ban_restric_5")));
                    $kFileCopy = trim($this->security->xss_clean($this->input->post("file_copy_k_5")));
                    $lOtherRequiCond = trim($this->security->xss_clean($this->input->post("l_other_requi_cond_5")));
                    $lFileCopy = trim($this->security->xss_clean($this->input->post("file_copy_l_5")));
                    $mCritElig = trim($this->security->xss_clean($this->input->post("m_crit_elig_5")));
                    $nListEligCand = trim($this->security->xss_clean($this->input->post("n_list_elig_cand_5")));
                    $nFileCopy = trim($this->security->xss_clean($this->input->post("file_copy_n_5")));


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
                    if (isset($_FILES['file_k']) && $_FILES['file_k']['size'] > 0) {
                        $fileName = basename($_FILES['file_k']['name']);
                        $filename_k = 'RR_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_k;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_k']['tmp_name'], $fileUrl)) {
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

                    if (isset($_FILES['file_l']) && $_FILES['file_l']['size'] > 0) {
                        $fileName = basename($_FILES['file_l']['name']);
                        $filename_l = 'RO_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_l;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_l']['tmp_name'], $fileUrl)) {
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

                    if (isset($_FILES['file_n']) && $_FILES['file_n']['size'] > 0) {
                        $fileName = basename($_FILES['file_n']['name']);
                        $filename_n = 'LIST_' . date('dmyhis') . '.pdf';
                        $fileUrl = 'requisitions_documents/' . $filename_n;
                        $allowTypes = array('pdf');
                        $targetFilePath = $targetDir . '/' . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        if (in_array($fileType, $allowTypes)) {
                            if (!is_dir('requisitions_documents')) {
                                mkdir('requisitions_documents', 0777, true);
                            }
                            if (move_uploaded_file($_FILES['file_n']['tmp_name'], $fileUrl)) {
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
                        'i_pwd' => trim($iPwD),
                        'i_ex_sm' => trim($iExSm),
                        'j_ban_restric' => trim($jBanRectric),
                        'file_copy_k_rr' => trim($filename_k),
                        'l_other_requi_cond' => trim($lOtherRequiCond),
                        'file_copy_l_ro' => trim($filename_l),
                        'm_criteria_eligibility' => $mCritElig,
                        'n_list_eligibility_cands' => $nListEligCand,
                        'file_copy_n_list_cands' => $filename_n,
                        'entry_datetime' => date('Y-m-d H:i:s'),
                        'sys_ip' => $this->input->ip_address(),
                        'entry_user' => $userid,
                        'mst_id' => $mstID
                    );

                    if ($file_kError == FALSE && $file_lError == FALSE) {
                        if ($this->requiDraft->updateTemp2ndFormDetails(array('mst_id' => $mstID, 'auto_id' => $autoID), $mappData)) {
                            $mData = $this->requiDraft->selectTemp2ndFormWithPostDetails('mm.auto_id,pp.post_name', array('mm.mst_id' => $mstID));
                            $html = "";
                            if ($mData != null) {
                                $sno = 1;
                                foreach ($mData as $mRow) {
                                    $html .= '<div class="col-md-2">
                                                        <div class="form-group">
                                                            <div class="small-box">
                                                                <div class="inner">
                                                                    <p><span class="float-right badge badge-primary">' . $sno . '</span> ' . $mRow->post_name . ' </p>
                                                                </div>
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
                echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'Invalid request!'));
            }
        } else {
            echo json_encode(array('status' => FALSE, 'logout' => TRUE, 'msg' => 'You are not authorized to perform these operation!'));
        }
    }

}
