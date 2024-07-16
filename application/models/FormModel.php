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

    public function deleteForm($form_id)
    {
        $this->db->where('form_id', $form_id);
        $this->db->delete('forms');
    }
        
    public function get_questions($form_id) {
        $this->db->where('form_id', $form_id);
        $query = $this->db->get('questions');
        return $query->result_array();
    }

    public function insertForm($data) {
        $this->db->insert('forms', $data);
        return $this->db->insert_id();
    }

    public function updateForm($form_id, $form_title, $form_description)
    {
        // Update form data
        $this->db->where('form_id', $form_id);

        $this->db->set('form_title', $form_title);
        $this->db->set('form_description', $form_description);
        $this->db->update('forms');
        // $this->db->set('forms', $formData);

        // Update questions data
        // foreach ($questionsData as $question) {
        //     if (isset($question['question_id'])) {
        //         // Update existing question
        //         $this->db->where('question_id', $question['id']);
        //         $this->db->update('questions', $question);
        //     } else {
        //         // Insert new question
        //         $question['form_id'] = $formId;
        //         $this->db->insert('questions', $question);
        //     }
        // }

        // if ($this->db->trans_status() === FALSE) {
        //     return false;
        // } else {
        //     return true;
        // }
    }

    public function updateQuestions($formId, $questions)
    {
    // Remove existing questions for the form
        $this->db->where('form_id', $formId);
        $this->db->delete('questions');

        // Insert updated questions
        foreach ($questions as $question) {
            $data = [
                'form_id' => $formId,
                'question_text' => $question['question_text'],
                'type' => $question['type']
            ];
            $this->db->insert('questions', $data);
            $questionId = $this->db->insert_id();

            // Insert options if the question has them
            if (in_array($question['type'], ['multiple-choice', 'checkboxes', 'dropdown'])) {
                foreach ($question['options'] as $option) {
                    $optionData = [
                        'question_id' => $questionId,
                        'option_text' => $option
                    ];
                    $this->db->insert('question_options', $optionData);
                }
            }
        }
    }

}
