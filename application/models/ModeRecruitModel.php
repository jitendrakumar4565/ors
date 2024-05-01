<?php

class ModeRecruitModel extends CI_Model {

    var $column_order = array(null, 'mode_name'); //set column field database for datatable orderable
    var $column_search = array('mode_name'); //set column field database for datatable searchable 
    var $order = array('mode_name' => 'asc'); // default order 

    private function listquery($cond) {
        $this->db->select("auto_id,mode_name");
        $this->db->from("mst_mode_recruit");
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
        $this->db->order_by('mode_name', 'asc');
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
        return $this->db->get('mst_mode_recruit')->result();
    }

    function selectDetailsRowModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('mst_mode_recruit')->row();
    }

    function saveDetailsModel($data) {
        $this->db->insert("mst_mode_recruit", $data);
    }

    function updateDetailsModel($cond, $data) {
        $this->db->where($cond);
        $this->db->update('mst_mode_recruit', $data);
    }

    function deleteDetailsModel($id) {
        $this->db->where('auto_id', $id);
        $this->db->delete('mst_mode_recruit');
    }

}
