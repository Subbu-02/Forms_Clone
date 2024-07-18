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
        $this->load->view('Templates/header');
        $this->load->view('responses_all', $data);
        $this->load->view('Templates/footer');
    }
}