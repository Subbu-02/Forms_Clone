<?php
class ResponseModel extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_responses($form_id) {
        $this->db->select('GROUP_CONCAT(response) as responses, created_by, created_at');
        $this->db->from('responses');
        
        $this->db->where('form_id', $form_id);
        $this->db->group_by(['created_at', 'created_by']);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_form_title($form_id) {
        $this->db->select('form_title');
        $this->db->from('forms');
        $this->db->where('form_id', $form_id);
        $query = $this->db->get();
        return $query->row()->form_title;
    }
}    