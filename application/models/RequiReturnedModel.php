<?php

class RequiReturnedModel extends CI_Model {

    var $column_order = array(null, 'org.org_name', 'dept.dept_name'); //set column field database for datatable orderable
    var $column_search = array('org.org_name', 'dept.dept_name'); //set column field database for datatable searchable 
    var $order = array('req.sent_datetime' => 'DESC'); // default order 

    private function listquery($cond) {
        $this->db->select("req.mst_id,req.auto_id,req.c_mode_recruitment,org.org_name,dept.dept_name,req.officer_name,desig.desig_name,pp.post_name,req.entry_datetime,req.sent_datetime,req.seen_flag,req.action_taken,req.action_datetime,req.seen_by_dept");
        $this->db->from("inbox_requisition req");
        $this->db->join('mst_organisation org', 'org.auto_id=req.org_name', 'left');
        $this->db->join('mst_department dept', 'dept.auto_id=req.dept_name', 'left');
        $this->db->join('mst_post pp', 'pp.auto_id=req.post_name', 'left');
        $this->db->join('mst_designation desig', 'desig.auto_id=req.officer_desig', 'left');
        //$this->db->join('inbox_requisition inb', 'inb.auto_id=req.auto_id');
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
        $this->db->order_by('req.sent_datetime', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function list_filtered($cond) {
        $this->listquery($cond);
        $query = $this->db->get();
        return $query->num_rows();
    }
/*
    function selectTemp2ndFormDetails($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->order_by('auto_id', 'ASC');
        return $this->db->get('returned_requisition')->result();
    }

    function select2ndFromCompData($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->join('mst_post pp', 'pp.auto_id=req.post_name', 'left');
        $this->db->join('mst_organisation org', 'org.auto_id=req.org_name', 'left');
        $this->db->join('mst_department dept', 'dept.auto_id=req.dept_name', 'left');
        $this->db->join('mst_designation desig', 'desig.auto_id=req.officer_desig', 'left');
        $this->db->join('inbox_requisition inb', 'inb.auto_id=req.auto_id');
        $this->db->order_by('req.auto_id', 'ASC');
        return $this->db->get('returned_requisition req')->result();
    }

    function selectDetailsModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('returned_requisition')->result();
    }

    function updateDetailsModel($cond, $data) {
        $this->db->where($cond);
        $this->db->update('returned_requisition', $data);
    }
*/
}
