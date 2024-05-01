<?php

class RecommendedDraftModel extends CI_Model {

    var $column_order = array(null, 'roll_no', 'full_name', 'dob', 'father_name', 'category_allot', 'is_pwd', 'is_ex_sm', null); //set column field database for datatable orderable
    var $column_search = array('roll_no', 'full_name', 'dob', 'father_name', 'category_allot'); //set column field database for datatable searchable 
    var $order = array('roll_no' => 'asc', 'full_name' => 'ASC'); // default order 

    private function listquery($cond) {
        $this->db->select("auto_id,inbox_requi_auto_id,full_name,roll_no,dob,father_name,category_allot,is_pwd,is_ex_sm,dossier_link");
        $this->db->from("draft_recomm_list");
        $this->db->where($cond);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function list_databales($cond) {
        $this->listquery($cond);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->order_by('roll_no', 'asc');
        $this->db->order_by('full_name', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function list_filtered($cond) {
        $this->listquery($cond);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function selectDetailsModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('draft_recomm_list')->result();
    }

    function selectDetailsArrModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('draft_recomm_list')->result_array();
    }

    function selectDetailsRowModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('draft_recomm_list')->row();
    }

    function saveDetailsModel($data) {
        if ($this->db->insert("draft_recomm_list", $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function updateDetailsModel($cond, $data) {
        $this->db->where($cond);
        $res = $this->db->update('draft_recomm_list', $data);
        if ($res) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteDetailsModel($id) {
        $this->db->where('auto_id', $id);
        return $this->db->delete('draft_recomm_list');
    }

    function sendRecommendedToDepartmentModel($cond) {
        $select = $this->db->select('inbox_requi_auto_id,full_name,roll_no,dob,father_name,category_allot,is_pwd,is_ex_sm,dossier_link,entry_datetime,sys_ip,entry_user')->where($cond)->get('draft_recomm_list');
        if ($select->num_rows()) {
            $this->db->insert_batch('final_recomm_list', $select->result_array());
        }
        $this->db->where($cond);
        $this->db->delete('draft_recomm_list');
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
