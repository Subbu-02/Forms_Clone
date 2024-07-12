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

    public function save_form($data) {
        $this->db->insert('forms', $data);
    }    
}
