<?php

class RecommendedFinalModel extends CI_Model {

    var $column_order = array(null, 'roll_no', 'full_name', 'dob', 'father_name', 'category_allot', 'is_pwd', 'is_ex_sm', null); //set column field database for datatable orderable
    var $column_search = array('roll_no', 'full_name', 'dob', 'father_name', 'category_allot'); //set column field database for datatable searchable 
    var $order = array('roll_no' => 'asc'); // default order 

    private function listquery($cond) {
        $this->db->select("auto_id,inbox_requi_auto_id,full_name,roll_no,dob,father_name,category_allot,is_pwd,is_ex_sm,dossier_link,iol_flag,uol_flag,uol_dossier,ial_flag,ual_flag,ual_dossier,iol_datetime,uol_datetime,ial_datetime,ual_datetime");
        $this->db->from("final_recomm_list");
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
        //$this->db->order_by('full_name', 'asc');
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
        return $this->db->get('final_recomm_list')->result();
    }

    function selectDetailsRowModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('final_recomm_list')->row();
    }

    function updateDetailsModel($cond, $data) {
        $this->db->where($cond);
        $res = $this->db->update('final_recomm_list', $data);
        if ($res) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
