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

    public function updateForm($form_id, $form_data)
    {
        // Update form data
        $this->db->where('form_id', $form_id);
        $this->db->update('forms', $form_data);
    }

    public function updateQuestions($formId, $questions) {
        // Fetch existing questions
        $existingQuestions = $this->db->select('question_id')
                                      ->from('questions')
                                      ->where('form_id', $formId)
                                      ->get()
                                      ->result_array();

        $existingQuestionIds = array_column($existingQuestions, 'question_id');
        $newQuestionIds = array_column($questions, 'id');

        // Delete questions that are not in the new questions array
        $questionsToDelete = array_diff($existingQuestionIds, $newQuestionIds);
        if (!empty($questionsToDelete)) {
            $this->db->where_in('question_id', $questionsToDelete)
                     ->delete('questions');
        }

        // Update existing questions and add new ones
        foreach ($questions as $question) {
            $questionData = [
                'form_id' => $formId,
                'question_text' => $question['text'],
                'type' => $question['type']
            ];

            if (in_array($question['id'], $existingQuestionIds)) {
                // Update existing question
                $this->db->where('question_id', $question['id'])
                         ->update('questions', $questionData);
            } else {
                // Insert new question
                $this->db->insert('questions', $questionData);
                $question_id = $this->db->insert_id();

                // Insert options if the question type requires them
                if (isset($question['options']) && in_array($question['type'], ['multiple-choice', 'checkboxes', 'dropdown'])) {
                    foreach ($question['options'] as $option) {
                        $optionData = [
                            'question_id' => $question_id,
                            'option_text' => $option
                        ];
                        $this->db->insert('question_options', $optionData);
                    }
                }
            }
        }
    }

}
