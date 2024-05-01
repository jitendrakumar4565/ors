<?php

class RequiDraftModel extends CI_Model {

    var $column_order = array(null, 'org.org_name', 'dept.dept_name'); //set column field database for datatable orderable
    var $column_search = array('org.org_name', 'dept.dept_name'); //set column field database for datatable searchable 
    var $order = array('tmp.entry_datetime' => 'DESC'); // default order 

    private function listquery($cond) {
        $this->db->select("tmp.mst_id,tmp.auto_id,tmp.c_mode_recruitment,org.org_name,dept.dept_name,pp.post_name,tmp.entry_datetime");
        $this->db->from("draft_requisition tmp");
        $this->db->join('mst_organisation org', 'org.auto_id=tmp.org_name', 'left');
        $this->db->join('mst_department dept', 'dept.auto_id=tmp.dept_name', 'left');
        $this->db->join('mst_post pp', 'pp.auto_id=tmp.post_name', 'left');
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
        $this->db->order_by('tmp.entry_datetime', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function list_filtered($cond) {
        $this->listquery($cond);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function selectTemp2ndFormDetails($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->order_by('auto_id', 'ASC');
        return $this->db->get('draft_requisition')->result();
    }

    function selectTemp2ndFormWithPostDetails($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->join('mst_post pp', 'pp.auto_id=mm.post_name', 'left');
        $this->db->order_by('mm.auto_id', 'ASC');
        return $this->db->get('draft_requisition mm')->result();
    }

    function selectTemp2ndFormRowDetails($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->order_by('auto_id', 'ASC');
        return $this->db->get('draft_requisition')->row();
    }

    function saveTemp2ndFormModel($data) {
        if ($this->db->insert("draft_requisition", $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function updateTemp2ndFormDetails($cond, $data) {
        $this->db->where($cond);
        $this->db->update('draft_requisition', $data);
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteTempRequiModel($cond) {
        $select = $this->db->select('*')->where($cond)->get('draft_requisition');
        if ($select->num_rows()) {
            $this->db->insert_batch('trash_requisition', $select->result_array());
        }
        $this->db->where($cond);
        $this->db->delete('draft_requisition');
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteTempModel($cond) {
        $this->db->where($cond);
        $this->db->delete('draft_requisition');
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function select2ndFromCompData($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->join('mst_post pp', 'pp.auto_id=mm.post_name', 'left');
        $this->db->join('mst_organisation org', 'org.auto_id=mm.org_name', 'left');
        $this->db->join('mst_department dept', 'dept.auto_id=mm.dept_name', 'left');
        $this->db->join('mst_designation desig', 'desig.auto_id=mm.officer_desig', 'left');
        $this->db->join('post_eligibility_mapped pem', 'pem.auto_id=mm.m_criteria_eligibility', 'left');
        $this->db->order_by('mm.auto_id', 'ASC');
        return $this->db->get('draft_requisition mm')->result();
    }

    function selectPostEligList($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->order_by('auto_id', 'ASC');
        return $this->db->get('post_eligibility_mapped')->result();
    }

}
