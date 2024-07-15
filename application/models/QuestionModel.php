<?php
class QuestionModel extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_questions($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('questions');
        return $query->result_array();
    }

    public function save_form($data) {
        $this->db->insert('forms', $data);
    }    
}