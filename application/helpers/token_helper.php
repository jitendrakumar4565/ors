<?php

include APPPATH . 'third_party/random_compat/lib/random.php';
if (!function_exists('getCSRFToken')) {

    function getCSRFToken() {
        $ci = &get_instance();
        $bytes = bin2hex(random_bytes(25));
        $token = $bytes . date("YmdHis");
        $hashed_token = hash('sha256', $token);
        $ci->session->set_userdata('_token', $hashed_token);
        session_regenerate_id();
        return $hashed_token;
    }

}

if (!function_exists('isValidToken')) {

    function isValidToken() {
        $ci = &get_instance();
        $_token = trim($ci->security->xss_clean($_GET['token']));
        //if($_token == "")return FALSE;
        if ($_token == $ci->session->userdata('_token')) {
            return true;
        } else {
            // return false;
            return true;
        }
    }

}

function cusDate($date) {
    $exploded = explode("/", $date);
    $exploded = array_reverse($exploded);
    $newFormat = implode("-", $exploded);
    return $newFormat;
}

function reverseDate($date) {
    $exploded = explode("-", $date);
    $exploded = array_reverse($exploded);
    $newFormat = implode("-", $exploded);
    return $newFormat;
}

function reverseDateTime($dateTime, $start, $limit) {
    $result = substr($dateTime, $start, $limit);
    $exploded = explode("-", $result);
    $exploded = array_reverse($exploded);
    $newFormat = implode("-", $exploded);
    return $newFormat;
}

function loadMenus() {
    $ci = &get_instance();
    $role = $ci->session->userdata('role');
    $menu_name = "";
    if ($role == 'SA') {
        $menu_name = 'super_admin';
    } else if ($role == 'AD') {
        $menu_name = 'admin';
    } else if ($role == 'UR') {
        $menu_name = 'user';
    }
    return $menu_name;
}

function random_strings() {
    $ci = &get_instance();
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $mycsrf = substr(str_shuffle($str_result), 0, 50);
    $ci->session->set_userdata('_csrf', $mycsrf);
    return $mycsrf;
}

function randomStr($length_of_string) {
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($str_result), 0, $length_of_string);
}
