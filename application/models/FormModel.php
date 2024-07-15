<?php
class FormModel extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_forms($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('forms');
        return $query->result_array();
    }

    public function get_form($form_id) {
        $this->db->where('form_id', $form_id);
        $query = $this->db->get('forms');
        return $query->row_array();
    }

    public function save_form($data) {
        $this->db->insert('forms', $data);
    }
    
    public function get_questions($form_id) {
        $this->db->where('form_id', $form_id);
        $query = $this->db->get('questions');
        return $query->result_array();
    }

    public function update_question($question_id, $data) {
        $this->db->where('question_id', $question_id);
        return $this->db->update('questions', $data);
    }

    public function delete_question($question_id) {
        $this->db->where('question_id', $question_id);
        return $this->db->delete('questions');
    }
}
