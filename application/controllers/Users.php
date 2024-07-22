<?php
    class Users extends CI_Controller{
        public function register(){
            $data['title'] = 'Sign Up';

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
            $this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');

            if($this->form_validation->run() === FALSE){
                $this->load->view('Templates/header');
                $this->load->view('users/register', $data);
                $this->load->view('Templates/footer');
            }
            else{
                $enc_password = md5($this->input->post('password'));
				// $enc_password = $this->input->post('password');
                $this->UserModel->register($enc_password);
                $this->session->set_flashdata('user_registered', 'You are now registered and can log in');
                redirect('home');
            }
        }

        public function login(){
			$data['title'] = 'Sign In';

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('Templates/header');
				$this->load->view('users/login', $data);
				$this->load->view('Templates/footer');
			} else {
				// Get username
				$username = $this->input->post('username');
				// Get and encrypt the password
				$password = md5($this->input->post('password'));
				// $password = $this->input->post('password');

				// Login user
				$user_id = $this->UserModel->login($username, $password);

				if($user_id){
					// Create session
					$user_data = array(
						'user_id' => $user_id,
						'username' => $username,
						'logged_in' => true
					);

					$this->session->set_userdata($user_data);

					// Set message
					$this->session->set_flashdata('user_loggedin', 'You are now logged in');

					redirect('home');
				} else {
					// Set message
					$this->session->set_flashdata('login_failed', 'Login is invalid');

					redirect('users/login');
				}		
			}
		}

        public function logout(){
			// Unset user data
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('username');

			// Set message
			$this->session->set_flashdata('user_loggedout', 'You are now logged out');

			redirect('users/login');
		}

        public function check_username_exists($username){
			$this->form_validation->set_message('check_username_exists', 'That username is taken. Please choose a different one');
			if($this->UserModel->check_username_exists($username)){
				return true;
			} else {
				return false;
			}
		}

        public function check_email_exists($email){
			$this->form_validation->set_message('check_email_exists', 'That email is taken. Please choose a different one');
			if($this->UserModel->check_email_exists($email)){
				return true;
			} else {
				return false;
			}
		}

        public function profile(){
            $user_id = $this->session->userdata('user_id'); // Get the logged-in user's ID
            $data['user'] = $this->UserModel->user_data($user_id); // Fetch user data
			$this->session->set_userdata('current_page', 'create');
            $data['title'] = 'Profile'; // Set the title for the profile page
            $this->load->view('Templates/header'); // Load header
            $this->load->view('profile', $data); // Load profile view
            $this->load->view('Templates/footer'); // Load footer
        }
    }