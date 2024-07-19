<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Responses extends CI_Controller {
	public function responses_fetch($form_id) {
		// If the user is logged out, redirect to login page
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}
		$this->session->set_userdata('current_page', 'responses');
        $data['responses'] = $this->ResponseModel->get_responses($form_id);
        $data['form_id'] = $form_id;
        $data['form_title'] = $this->ResponseModel->get_form_title($form_id);
        // $data['form_name'] = $form_name;
        $this->load->view('Templates/header', $data);
        $this->load->view('responses_all', $data);
        $this->load->view('Templates/footer');
    }

    public function view_response($created_at, $created_by, $form_id) {
        // echo $created_at;
        // echo "\t";
        // echo gettype($created_at);
        // echo $created_by;
        // exit;
        if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}
        $this->session->set_userdata('current_page', 'view_response');
        $data['response'] = $this->ResponseModel->get_grouped_response($created_at, $created_by);
        $form = $this->FormModel->get_form($form_id);
		$questions = $this->FormModel->get_questions($form_id);
        $user = $this->UserModel->user_data($created_by);
		$data['form'] = $form;
		$data['questions'] = $questions;
        $data['user'] = $user;
        $data['created_at'] = str_replace('%20', ' ', $created_at);
        // print_r($data['questions']);
        // exit;
        $this->load->view('Templates/header');
        $this->load->view('view_response', $data);
        $this->load->view('Templates/footer');
    }

    public function responseStats($form_id) {
        if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}
        $this->session->set_userdata('current_page', 'response_stats');
        $data['responses'] = $this->ResponseModel->get_all_responses($form_id);
        $data['form'] = $this->FormModel->get_form($form_id);
		$data['questions'] = $this->FormModel->get_questions($form_id);
        $data['form_id'] = $form_id;
        $data['form_title'] = $this->ResponseModel->get_form_title($form_id);
        $this->load->view('Templates/header');
        $this->load->view('response_stats', $data);
        $this->load->view('Templates/footer');
    }
}