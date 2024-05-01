<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    var $column_order = array(null, 'usr.full_name', 'desig.desig_name', 'usr.mobile_no', null, null, 'usr.approved_flag', null); //set column field database for datatable orderable
    var $column_search = array('usr.full_name', 'desig.desig_name', 'usr.mobile_no'); //set column field database for datatable searchable 
    var $order = array('usr.registered_datetime' => 'DESC'); // default order 

    private function listquery($cond) {
        $this->db->select("usr.user_id,usr.user_lvl,usr.email_id,usr.mobile_no,usr.full_name,desig.desig_name,usr.is_mob_verified,usr.is_email_verified,usr.approved_flag,usr.login_access,usr.seen_flag");
        $this->db->join('mst_designation desig', 'desig.auto_id=usr.desig', 'left');
        $this->db->from("users_login usr");
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
        $this->db->order_by('usr.registered_datetime', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function list_filtered($cond) {
        $this->listquery($cond);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function validateUserModel($select, $uid) {
        $this->db->select($select);
        $this->db->from("users_login");
        $this->db->or_where('email_id like binary', $uid);
        $this->db->or_where('mobile_no like binary', $uid);
        return $this->db->get()->row();
    }

    function selectORDetailsModel($select, $cond) {
        $this->db->select($select);
        $this->db->or_where($cond);
        return $this->db->get('users_login')->result();
    }

    function selectORAndDetailsModel($select, $cond, $cond1) {
        $this->db->select($select);
        $this->db->or_where($cond);
        $this->db->where($cond1);
        return $this->db->get('users_login')->result();
    }

    function validateEmailMobileModel($email, $mobile, $userid) {
        $sql = "SELECT user_id,email_id,mobile_no FROM users_login WHERE (email_id = '" . $email . "' OR mobile_no = '" . $mobile . "') AND user_id != '" . $userid . "'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function selectDetailsModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('users_login')->result();
    }

    function selectDetailsRowModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('users_login')->row();
    }

    function saveUserDetails($data) {
        $this->db->insert("users_login", $data);
        return $this->db->insert_id();
    }

    function updateUserDetails($cond, $data) {
        $this->db->where($cond);
        return $this->db->update('users_login', $data);
    }

    function selectComDetailsModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->join('mst_designation desig', 'desig.auto_id=usr.desig', 'left');
        return $this->db->get('users_login usr')->result();
    }

    function selectComDetailsRowModel($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->join('mst_designation desig', 'desig.auto_id=usr.desig', 'left');
        $this->db->join('mst_department dept', 'dept.auto_id=usr.dept_id', 'left');
        return $this->db->get('users_login usr')->row();
    }

    function deleteDetailsModel($cond) {
        $this->db->where($cond);
        $this->db->delete('users_login');
    }

    function saveUserMappedOrgModel($data) {
        $this->db->insert_batch("users_mapped_organisation", $data);
    }

    function removeUserMappedOrgModel($cond) {
        $this->db->where($cond);
        return $this->db->delete('users_mapped_organisation');
    }

    function getUserMappOrgModel($userid, $select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        $this->db->join('users_mapped_organisation mpp', 'mpp.org_id = org.auto_id AND  mpp.user_id =' . $userid, 'left');
        $this->db->order_by('org.auto_id', 'ASC');
        return $this->db->get('mst_organisation org')->result();
    }

}
