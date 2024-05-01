<?php

class ExamModel extends CI_Model {

    function deleteExamSetupDetails() {
        $this->db->delete('exam_setup');
    }

    function selectExamSetupDetails($select, $cond) {
        $this->db->select($select);
        $this->db->where($cond);
        return $this->db->get('exam_setup')->result();
    }

    function saveExamSetupModel($data) {
        $this->db->insert("exam_setup", $data);
        return $this->db->insert_id();
    }

    function updateExamSetupModel($cond, $data) {
        $this->db->where($cond);
        $this->db->update('exam_setup', $data);
    }

}
