<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model {

    function signInModel($uid, $pwd) {
        $this->db->select('user_id,user_lvl,email_id,mobile_no,full_name,pwd,is_mob_verified,is_email_verified,approved_flag,login_access,block_reason');
        $this->db->from("users_login");
        $this->db->or_where('email_id like binary', $uid);
        $this->db->or_where('mobile_no like binary', $uid);
        $row = $this->db->get()->row();
        if ($row != NULL) {
            $storedpw = $row->pwd;
            if ($pwd == $storedpw) {
                return $row;
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }

    function unLockScreenModel($uid, $pwd) {
        $this->db->select('user_id,user_lvl,pwd,is_mob_verified,is_email_verified,approved_flag,login_access,block_reason');
        $this->db->from("users_login");
        $this->db->where('user_id', $uid);
        $row = $this->db->get()->row();
        if ($row != NULL) {
            $storedpw = $row->pwd;
            if ($pwd == $storedpw) {
                return $row;
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }

}
