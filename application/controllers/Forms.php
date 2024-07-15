<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {
	public function home() {
		// If the user is logged out, redirect to login page
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}
		$this->session->set_userdata('current_page', 'home');
        $data['forms'] = $this->FormModel->get_forms($this->session->userdata('user_id'));
        $this->load->view('Templates/header');
        $this->load->view('home', $data);
        $this->load->view('Templates/footer');
    }

	public function edit($form_id)
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}
		$data['questions'] = $this->FormModel->get_questions($form_id);
		$data['form_id'] = $form_id;
		$data['form'] = $this->FormModel->get_form($form_id);
		$this->session->set_userdata('current_page', 'edit');
		$this->load->view('Templates/header');
		$this->load->view('edit', $data);
		$this->load->view('Templates/footer');
	}

    public function create() {
        // Load form creation view
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
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
}
