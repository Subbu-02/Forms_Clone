<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {
	public function home() {
		$this->session->set_userdata('current_page', 'home');
        $data['forms'] = $this->FormModel->get_forms($this->session->userdata('user_id'));
        $this->load->view('Templates/header');
        $this->load->view('home', $data);
        $this->load->view('Templates/footer');
    }

	public function edit()
	{
		$this->session->set_userdata('current_page', 'edit');
		$this->load->view('Templates/header');
		$this->load->view('edit');
		$this->load->view('Templates/footer');
	}

    public function create() {
        // Load form creation view
		$this->session->set_userdata('current_page', 'create');
        $this->load->view('Templates/header');
        $this->load->view('create');
        $this->load->view('Templates/footer');
    }

	public function save() {
		$this->session->set_userdata('current_page', 'create');
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'form_title' => $this->input->post('title'),
			'form_description' => $this->input->post('description'),
			'status' => 'draft'
		);
	
		$this->FormModel->save_form($data);
		redirect('home');
	}	
}
