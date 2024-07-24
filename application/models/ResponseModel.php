<?php
class ResponseModel extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_responses($form_id) {
        $this->db->select('GROUP_CONCAT(response) as responses, responses.created_by, users.name, responses.created_at');
        $this->db->from('responses');
        $this->db->join('users', 'users.user_id = responses.created_by'); // Join with users table
        $this->db->where('form_id', $form_id);
        $this->db->group_by(['responses.created_at', 'responses.created_by']);
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

    public function get_grouped_response($created_at, $created_by) {
        // $this->db->select('GROUP_CONCAT(response) as responses, created_by, created_at, form_id');
        // $this->db->from('responses');
        // $this->db->where('created_at', $created_at);
        // $this->db->where('created_by', $created_by);
        // $query = $this->db->get();
        // print_r($query->row());
        // exit();
        // return $query->row();
        // echo $created_at;
        // echo "\n";
        $created_at = str_replace('%20', ' ', $created_at);
        $this->db->select('response');
        $this->db->from('responses');
        $this->db->where('created_at', $created_at);
        $this->db->where('created_by', $created_by);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // exit;
        $responses = array_column($query->result_array(), 'response');
        // print_r($responses);
        // exit;
        return $responses;
    }

    public function get_all_responses($form_id) {
        $this->db->select('*');
        $this->db->from('responses');
        $this->db->where('form_id', $form_id);
        $query = $this->db->get();
        return $query->result();
    }
}