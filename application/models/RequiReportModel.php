<?php

class RequiReportModel extends CI_Model {

    var $column_order = array(null, 'org.org_name', 'dept.dept_name', 'pp.post_name', 'req.officer_name', 'desig.desig_name', null, 'action_taken', 'req.sent_datetime', null); //set column field database for datatable orderable
    var $column_search = array('org.org_name', 'dept.dept_name'); //set column field database for datatable searchable 
    var $order = array('req.sent_datetime' => 'DESC'); // default order 

    private function listquery($cond) {
        $this->db->select("req.mst_id,req.auto_id,req.c_mode_recruitment,org.org_name,dept.dept_name,pp.post_name,req.entry_datetime,req.action_taken,req.d_ur,req.d_apst,req.d_total,req.d_pwd,req.d_ex_sm,req.rec_ur,req.rec_apst,req.rec_pwd,req.rec_ex_sm");
        $this->db->from("inbox_requisition req");
        $this->db->join('mst_organisation org', 'org.auto_id=req.org_name', 'left');
        $this->db->join('mst_department dept', 'dept.auto_id=req.dept_name', 'left');
        $this->db->join('mst_post pp', 'pp.auto_id=req.post_name', 'left');
        $this->db->join('mst_designation desig', 'desig.auto_id=req.officer_desig', 'left');
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

    function getAllCategoryNosDataModel($cond) {
        $this->db->select("
	SUM(d_ur) AS adv_ur,
	SUM(d_apst) AS adv_apst,
	SUM(d_pwd) AS adv_pwd,
	SUM(d_ex_sm) AS adv_exsm,
	SUM(d_ur + d_apst + d_pwd + d_ex_sm) AS adv_total,
	SUM(rec_ur) AS rec_ur,
	SUM(rec_apst) AS rec_apst,
	SUM(rec_pwd) AS rec_pwd,
	SUM(rec_ex_sm) AS rec_exsm,
	SUM(rec_ur + rec_apst + rec_pwd + rec_ex_sm) AS rec_total,
        (SUM(d_ur) - SUM(rec_ur)) as res_ur,
        (SUM(d_apst) - SUM(rec_apst)) as res_apst,
        (SUM(d_pwd) - SUM(rec_pwd)) as res_pwd,
        (SUM(d_ex_sm) - SUM(rec_ex_sm)) as res_exsm,
        (SUM(d_ur + d_apst + d_pwd + d_ex_sm) - SUM(rec_ur + rec_apst + rec_pwd + rec_ex_sm)) as res_total");
        $this->db->where($cond);
        return $this->db->get('inbox_requisition req')->row();
    }

}
