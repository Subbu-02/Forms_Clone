<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {
	public function home() {
		// If the user is logged out, redirect to login page
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}
		$this->session->set_userdata('current_page', 'home');
        $data['forms'] = $this->FormModel->get_forms($this->session->userdata('user_id'));
        $this->load->view('Templates/header');
        $this->load->view('home', $data);
        $this->load->view('Templates/footer');
    }

	public function deleteForm($form_id)
	{
		$this->load->model('FormModel');
		$this->FormModel->deleteForm($form_id);
		redirect('home');
	}

	public function edit($form_id)
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}
		$data['questions'] = $this->FormModel->get_questions($form_id);
		$data['form_id'] = $form_id;
		$data['form'] = $this->FormModel->get_form($form_id);
		$this->session->set_userdata('current_page', 'edit');
		$this->load->view('Templates/header');
		$this->load->view('edit', $data);
		$this->load->view('Templates/footer');
	}

	public function respond($form_id)
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}
		$form = $this->FormModel->get_form($form_id);
		$questions = $this->FormModel->get_questions($form_id);
		$this->session->set_userdata('current_page', 'respond');
		// Pass the form data to the view
		$data['form'] = $form;
		$data['questions'] = $questions;
		
		// Load the view with form data
		$this->load->view('Templates/header');
		$this->load->view('respond', $data);
		$this->load->view('Templates/footer');
	}

	public function fillform() {
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}
		$this->session->set_userdata('current_page', 'fillform');
		$data['forms'] = $this->FormModel->get_all_forms();
		$this->load->view('Templates/header');
        $this->load->view('fillform', $data);
        $this->load->view('Templates/footer');
	}

    public function create() {
        // Load form creation view
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}
		$this->session->set_userdata('current_page', 'create');
        $this->load->view('Templates/header');
        $this->load->view('create');
        $this->load->view('Templates/footer');
    }

	public function save() {
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}
		$this->session->set_userdata('current_page', 'create');
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'form_title' => $this->input->post('title'),
			'form_description' => $this->input->post('description'),
			'status' => 'draft'
		);
		$questions = $this->input->post('questions');
        if ($questions && is_array($questions)) {
            foreach ($questions as $question_id => $question_data) {
                $this->FormModel->update_question($question_id, $question_data);
            }
        }
		$this->FormModel->save_form($data);
		redirect('home');
	}

	public function saveForm() {
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }

        $form_id = $this->input->post('form_id');
        $form_title = $this->input->post('form_title');
        $form_description = $this->input->post('form_description');
        $questions = $this->input->post('questions'); 
        $form_data = array(
            'form_title' => $form_title,
            'form_description' => $form_description
        );
        // Update form details
        $this->FormModel->updateForm($form_id, $form_data);
		// print_r($questions);
		// exit;
        // Update questions if provided
        if (!empty($questions)) {
            $this->FormModel->updateQuestions($form_id, $questions);
        }

        redirect('home');
    }

	public function saveResponses(){
		if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }
		$form_id = $this->input->post('form_id');
		$responses = $this->input->post('responses');
		$user_id = $this->input->post('user_id');
		$this->FormModel->addResponse($form_id, $responses, $user_id);
		// print_r($form_id);
		// print_r($responses);
		// echo $user_id;
		// exit;
		redirect('fillform');
	}

	// public function update($form_id)
	// {
	// 	$formData = $this->input->post('form');
	// 	$questionsData = $this->input->post('questions');

	// 	$updateResult = $this->FormModel->updateForm($form_id, $formData, $questionsData);

	// 	if ($updateResult) {
	// 		$this->session->set_flashdata('success', 'Form updated successfully');
	// 	} else {
	// 		$this->session->set_flashdata('error', 'Failed to update form');
	// 	}

	// 	redirect('forms/edit/'.$form_id);
	// }


	public function view($formId)
	{
		// Load the FormModel
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}		
		// Fetch the form data
		$form = $this->FormModel->get_form($formId);
		$questions = $this->FormModel->get_questions($formId);
		$this->session->set_userdata('current_page', 'view');
		// Pass the form data to the view
		$data['form'] = $form;
		$data['questions'] = $questions;
		
		// Load the view with form data
		$this->load->view('Templates/header');
		$this->load->view('view', $data);
		$this->load->view('Templates/footer');
	}
}