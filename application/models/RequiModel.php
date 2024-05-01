<?php

class RequiModel extends CI_Model {

    function selectTemp1stFormDetails($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('temp_requisition')->result();
    }

    function selectTemp1stFormRowDetails($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('temp_requisition')->row();
    }

    function saveTemp1stFormModel($data) {
        $this->db->insert("inbox_requisition", $data);
    }

    function updateTemp1stFormModel($cond, $data) {
        $this->db->where($cond);
        $this->db->update('temp_requisition', $data);
    }

    function selectTemp2ndFormDetails($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->order_by('auto_id', 'ASC');
        return $this->db->get('temp_requisition_mapping')->result();
    }

    function updateTemp2ndFormDetails($cond, $data) {
        $this->db->where($cond);
        $this->db->update('temp_requisition_mapping', $data);
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function selectTemp2ndFormWithPostDetails($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->join('mst_post pp', 'pp.auto_id=mm.post_name', 'left');
        $this->db->order_by('mm.auto_id', 'ASC');
        return $this->db->get('temp_requisition_mapping mm')->result();
    }

    function selectTemp2ndFormRowDetails($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->order_by('auto_id', 'ASC');
        return $this->db->get('temp_requisition_mapping')->row();
    }

    function saveTemp2ndFormModel($data) {
        if ($this->db->insert("temp_requisition_mapping", $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function saveTemp2ndFormBatchModel($data) {
        $this->db->insert_batch("inbox_requisition", $data);
    }

    function deleteTempMappingModel($id) {
        $this->db->where('auto_id', $id);
        $this->db->delete('temp_requisition_mapping');
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getNos($role, $userid) {
        if (in_array($role, array("SA", "AD"))) {
            $this->db->select('auto_id');
            $this->db->where(array("seen_flag" => "0", "c_mode_recruitment" => "D"));
            $nosDirectReq = $this->db->get('inbox_requisition')->result();

            $this->db->select('auto_id');
            $this->db->where(array("seen_flag" => "0", "c_mode_recruitment" => "L"));
            $nosLDCEReq = $this->db->get('inbox_requisition')->result();

            $this->db->select('user_id');
            $this->db->where(array("seen_flag" => "0", "user_lvl" => "UR"));
            $nosUsr = $this->db->get('users_login')->result();
            return array("nosDirectReq" => count($nosDirectReq), "nosLDCEReq" => count($nosLDCEReq), "nosUsr" => count($nosUsr), "nosDirectTrash" => 0, "nosLDCETrash" => 0);
        }
        if (in_array($role, array("UR"))) {
            $this->db->select('auto_id');
            $this->db->where(array("seen_by_dept" => "0", "entry_user" => $userid, "action_taken IN ('ACCEPTED','RETURNED','ADVERTISED','RECOMMENDED') AND c_mode_recruitment =" => "D"));
            $nosDirectReq = $this->db->get('inbox_requisition')->result();

            $this->db->select('auto_id');
            $this->db->where(array("seen_by_dept" => "0", "entry_user" => $userid, "action_taken IN ('ACCEPTED','RETURNED','ADVERTISED','RECOMMENDED') AND c_mode_recruitment =" => "L"));
            $nosLDCEReq = $this->db->get('inbox_requisition')->result();


            $this->db->select('auto_id');
            $this->db->where(array("entry_user" => $userid, "c_mode_recruitment" => "D"));
            $nosDirectTrash = $this->db->get('trash_requisition')->result();

            $this->db->select('auto_id');
            $this->db->where(array("entry_user" => $userid, "c_mode_recruitment" => "L"));
            $nosLDCETrash = $this->db->get('trash_requisition')->result();
            return array("nosDirectReq" => count($nosDirectReq), "nosLDCEReq" => count($nosLDCEReq), "nosUsr" => 0, "nosDirectTrash" => count($nosDirectTrash), "nosLDCETrash" => count($nosLDCETrash));
        }
    }

    function selectSettingsModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('mst_settings')->row();
    }

    function updateSettingsModel($cond, $data) {
        $this->db->where($cond);
        $this->db->update('mst_settings', $data);
    }

}
