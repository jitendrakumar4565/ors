<?php

class OrganisationModel extends CI_Model {

    var $column_order = array(null, 'org.org_name', 'dept.dept_name', 'dept.dept_address'); //set column field database for datatable orderable
    var $column_search = array('org.org_name', 'dept.dept_name', 'dept.dept_address'); //set column field database for datatable searchable 
    var $order = array('org.org_name' => 'ASC', 'dept.dept_name' => 'ASC'); // default order 

    private function listquery($cond) {
        $this->db->select("org.org_name,org.auto_id,dept.dept_name,dept.dept_address");
        $this->db->from("mst_organisation org");
        $this->db->join('mst_department dept', 'dept.auto_id=org.dept_id', 'left');
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
        $this->db->order_by('org.org_name', 'asc');
        $this->db->order_by('dept.dept_name', 'asc');
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
        return $this->db->get('mst_organisation')->result();
    }

    function selectInDetailsModel($select, $datain) {
        $this->db->select($select);
        $this->db->where_in('dept_id', $datain);
        return $this->db->get('mst_organisation')->result();
    }

    function selectDetailsRowModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('mst_organisation')->row();
    }

    function saveDetailsModel($data) {
        $this->db->insert("mst_organisation", $data);
    }

    function updateDetailsModel($cond, $data) {
        $this->db->where($cond);
        $this->db->update('mst_organisation', $data);
    }

    function deleteDetailsModel($id) {
        $this->db->where('auto_id', $id);
        $this->db->delete('mst_organisation');
    }

}
