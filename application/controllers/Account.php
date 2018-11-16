<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	
	
	 public function __construct(){
        parent::__construct();
     }
	
	public function index(){
		$this->utils_model->deleteSession($this->session->userdata('is_logged_in'));
		$data = array(
						'page_title' => 'Online Submission and Review',
						'page_content' => $this->load->view('account/home',NULL,TRUE)
					 );
		$this->parser->parse('templates/login', $data);
	}
	
	public function signupForm(){
		
		$this->utils_model->deleteSession($this->session->userdata('is_logged_in'));
		$country = $this->db->get('country');
		$passData['country'] = $country->result_array();
		$data = array(
						'page_title' => 'Online Submission and Review',
						'page_content' => $this->load->view('account/signup',$passData,TRUE)
					 );
		$this->parser->parse('templates/login', $data);
	}
	
	
	public function signin(){
		$data = $this->utils_model->formPost($this->input->post());
		
		$this->db->where('email' , $data['email']);
		$this->db->where('password' , md5($data['password']));
	
		$getUser = $this->db->get('users');
		
		if($getUser->num_rows() > 0){
			$userData = $getUser->row_array();
			$this->db->where('users_id' , $userData['users_id']);
			$getUserConfirm = $this->db->get('users_confirmation');
			$dataConfirm = $getUserConfirm->row_array();
			
			if($dataConfirm['verify'] == 0){
				$callback[0] = false;
				$callback[1] = "Please confirm your email before sign in.";
			}
			else{
				$this->db->select('*');
				$this->db->from('users_info');
				$this->db->join('country', 'users_info.country = country.country_id');
				$this->db->where('users_info.users_id' , $userData['users_id']);
				$users_info = $this->db->get();
				$dataUsersInfo = $users_info->row_array();
				$dataUsersInfo['users_role'] = $userData['users_role'];
				
				$this->session->set_userdata('is_logged_in',$dataUsersInfo);
				$callback[0] = true;
				if($userData['users_role'] == 3){
					$callback[1] = site_url('registration');
				}
				else{
					$callback[1] = site_url('submission');
				}
				
				
			}
			
		}
		else{
			$callback[0] = false;
			$callback[1] = "Couldn't find your account or wrong password.";
		}
		echo json_encode($callback);
	}
	
	public function signup(){
		$data = $this->utils_model->formPost($this->input->post());
		//Check Repeat Email
		$this->db->where('email' , $data['email']);
		$query = $this->db->get('users');
		if($query->num_rows() > 0){
			$callback[0] = false;
			$callback[1] = "This email is already register in this system.";
		}
		else{
			$this->load->helper('string');
			$token = random_string('alnum', 30);
			$name_title = ($data['name_title'] == 'Other') ? $data['name_title_other'] : $data['name_title'];
			$passData['token'] = $token;
			$passData['data'] = $data;
			
			$sendEmail = $this->utils_model->sendEmail(
															EMAIL_SENDER ,
															EMAIL_SENDER_NAME ,
															$data['email'] ,
														    '[SEANES2018] Welcome to SEANES2018' ,
															$this->load->view('templates/email/confirmation', $passData , true)
														  );
			
			if($sendEmail){
		
				$this->db->trans_start();
				$data_users = array(
								'email' 	=> $data['email'],
								'password' 	=> md5($data['password']),
								'users_role'=> $data['users_role']
								);
				$this->db->set('timestamp', 'NOW()', FALSE);
				$this->db->insert('users', $data_users);
				$users_id = $this->db->insert_id();
				
				$data_confirmation = array(
										'users_id' => $users_id,
										'email' => $data['email'],
										'token' => $token ,
										'verify' => 0
									);
				$this->db->set('create_time', 'NOW()', FALSE);
				$this->db->insert('users_confirmation', $data_confirmation );
				
				$data_info	 = array(
									'users_id'		=> $users_id,
									'email'			=> $data['email'],
									'name_title'	=> $name_title ,
									'firstname' 	=> $data['firstname'],
									'middlename'	=> $data['middlename'],
									'lastname'		=> $data['lastname'],
									'organization'	=> $data['organization'],
									'contact_address'	=> $data['contact_address'],
									'city'			=> $data['city'],
									'state'			=> $data['state'],
									'postal_code'	=> $data['postal_code'],
									'country'		=> $data['country'],
									'phone'			=> $data['phone'],
									'fax'			=> $data['fax']
								);
				if($data['users_role'] == 2){
					$data_info['job_position'] = $data['job_position'];
					$data_info['contact_line'] = $data['contact_line'];
					$data_info['contact_messenger'] = $data['contact_messenger'];
					$data_info['contact_whatsapp'] = $data['contact_whatsapp'];
					$data_info['interest'] = $data['interest'];
				}
				$this->db->set('timestamp', 'NOW()', FALSE);
				$this->db->insert('users_info', $data_info);
				$this->db->trans_complete();
				
				
				$callback[0] = true;
				$callback[1] = site_url('account/successSignup');
				
				
			}
			else{
				$callback[0] = false;
				$callback[1] = "Couldn't send confirmation email, Please try again";
			}			
		}

		echo json_encode($callback);
	}
	
	public function successSignup(){
		$this->utils_model->deleteSession($this->session->userdata('is_logged_in'));
		$data = array(
						'page_title' => 'Online Submission and Review',
						'page_content' => $this->load->view('account/successSignup',NULL,TRUE)
					 );
		$this->parser->parse('templates/login', $data);
	}
	
	public function confirmation($token){
		$this->utils_model->deleteSession($this->session->userdata('is_logged_in'));
		$this->db->where('token' , $token);
		$query = $this->db->get('users_confirmation');
		$confirm_row = $query->row_array();
		if($confirm_row['verify'] == 0){
			$this->db->trans_start();
			$this->db->where('token' , $token);
			$this->db->update('users_confirmation' , array('verify' => 1));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				$pass['success'] = false;
				$pass['text'] = "Couldn't confirm your email, please try again";
			}
			else{
				$pass['success'] = true;
				$pass['text'] = "Confirmation your email successfully. Now you can sign in by click button below for go to sign in page.";
			}
		}
		else{
			$pass['success'] = true;
			$pass['text'] = "You already confirm your account. you can sign in by click button below for go to sign in page.";
		}
		
		$data = array(
						'page_title' => 'Online Submission and Review',
						'page_content' => $this->load->view('account/confirmation',$pass,TRUE)
					 );
		$this->parser->parse('templates/login', $data);
	}
	
	public function forget(){
		$this->utils_model->deleteSession($this->session->userdata('is_logged_in'));
		$data = array(
						'page_title' => 'Online Submission and Review',
						'page_content' => $this->load->view('account/forget',NULL,TRUE)
					 );
		$this->parser->parse('templates/login', $data);
	}
	
	public function doForget($step){
		if($step == 1){
			$this->db->where('email' , $this->input->post('email'));
			$users = $this->db->get('users_confirmation');
			if($users->num_rows() > 0){
					$dataUsers = $users->row_array();
					
					$this->db->where('users_id' , $dataUsers['users_id']);
					$users_info = $this->db->get('users_info');
					$dataUsersInfo = $users_info->row_array();
					$passData['users'] = $dataUsers;
					$passData['data'] = $dataUsersInfo;
				
					$sendEmail = $this->utils_model->sendEmail(
															EMAIL_SENDER ,
															EMAIL_SENDER_NAME ,
															$this->input->post('email') ,
														    '[SEANES2018] Password Reset' ,
															$this->load->view('templates/email/forget', $passData , true)
														  );
			
					if($sendEmail){
						$callback[0] = true;
						$callback[1] = site_url('account/doForget/2');
					}
					else{
						$callback[0] = false;
						$callback[1] = "Couldn't send email, Please try again";
					}
			}
			else{
				$callback[0] = false;
				$callback[1] = "Couldn't find your email, please try another email.";
			}
			echo json_encode($callback);
		}
		else{
			$this->utils_model->deleteSession($this->session->userdata('is_logged_in'));
			$data = array(
						'page_title' => 'Online Submission and Review',
						'page_content' => $this->load->view('account/forgetSent',NULL,TRUE)
					 );
			$this->parser->parse('templates/login', $data);
		}
	}
	
	
	public function resetPassword($step = 1,$token = ''){
		if($step == 1){
			$this->utils_model->deleteSession($this->session->userdata('is_logged_in'));
			$data = array(
						'page_title' => 'Online Submission and Review',
						'page_content' => $this->load->view('account/resetPassword',NULL,TRUE)
					 );
			$this->parser->parse('templates/login', $data);
		}
		elseif($step == 2){
			$data = $this->utils_model->formPost($this->input->post());
			$this->db->where('token' , $data['token']);
			$users_confirmation = $this->db->get('users_confirmation');
			if($users_confirmation->num_rows() > 0){
				$dataUsers = $users_confirmation->row_array();
				$this->db->trans_start();
				$this->db->where('users_id' , $dataUsers['users_id']);
				$this->db->update('users' , array('password' => md5($data['password'])));
				$this->db->trans_complete();
				
				$callback[0] = true;
				$callback[1] = site_url('account/resetPassword/3');
				
			}
			else{
				$callback[0] = false;
				$callback[1] = "Couldn't find your information, Please try again";
			}
			
			echo json_encode($callback);
		}
		else{
			$this->utils_model->deleteSession($this->session->userdata('is_logged_in'));
			$data = array(
						'page_title' => 'Online Submission and Review',
						'page_content' => $this->load->view('account/resetPassword',NULL,TRUE)
					 );
			$this->parser->parse('templates/login', $data);
		}
	}
	
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('account');
	}
	
	public function profile(){
		$this->utils_model->is_logged_in();
		
		$pass['breadcrumbs'] = array(
								'Home' => site_url('home'),
								'User Profile' => site_url('account/profile')
								);
		$users = $this->session->userdata('is_logged_in');
		$this->db->where('users_id' , $users['users_id'] );
		$query = $this->db->get('users_info');
		$pass['users'] = $query->row_array();
		
		$country = $this->db->get('country');
		$pass['country'] = $country->result_array();
		$data = array(
						'page_title' => 'User Profile',
						'page_content' => $this->load->view('account/profile', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
	}
	
	public function saveProfile(){
		$this->utils_model->is_logged_in();
		$data = $this->utils_model->formPost($this->input->post());
		
		$users = $this->session->userdata('is_logged_in');
				$this->db->trans_start();
				$name_title = ($data['name_title'] == 'Other') ? $data['name_title_other'] : $data['name_title'];
				
				if(!empty($data['change_password'])){
					$data_users = array(
									'password' 	=> md5($data['password'])
									);
					$this->db->where('users_id' , $users['users_id']);
					$this->db->update('users', $data_users);
				}
				
				$data_info	 = array(
									'name_title'	=> $name_title ,
									'firstname' 	=> $data['firstname'],
									'middlename'	=> $data['middlename'],
									'lastname'		=> $data['lastname'],
									'organization'	=> $data['organization'],
									'contact_address'	=> $data['contact_address'],
									'city'			=> $data['city'],
									'state'			=> $data['state'],
									'postal_code'	=> $data['postal_code'],
									'country'		=> $data['country'],
									'phone'			=> $data['phone'],
									'fax'			=> $data['fax']
								);
				$this->db->where('users_id' , $users['users_id']);
				$this->db->update('users_info', $data_info);
				$this->db->trans_complete();
				
				
				$callback[0] = true;
				$callback[1] = site_url('account/profile');
				
				echo json_encode($callback);
	}
	
	public function admin(){
		$this->session->sess_destroy();
		$this->load->view('templates/loginAdmin');
	}
	
	public function adminSignin(){
		$data = $this->utils_model->formPost($this->input->post());
		
		$this->db->where('email' , $data['email']);
		$this->db->where('password' , md5($data['password']));
		$this->db->where('users_role' , 4);
		$this->db->or_where('users_role'  , 5);
		$this->db->or_where('users_role'  , 6);
		$getUser = $this->db->get('users');
		
		if($getUser->num_rows() > 0){
			$userData = $getUser->row_array();
			$this->db->where('users_id' , $userData['users_id']);
			$users_info = $this->db->get('users_info');
			$dataUsersInfo = $users_info->row_array();
			$dataUsersInfo['users_role'] = $userData['users_role'];
				
			$this->session->set_userdata('admin_logged_in',$dataUsersInfo);
			$callback[0] = true;
			if($userData['users_role'] == 4){
				$callback[1] = site_url('editorSubmission');
			}
			elseif($userData['users_role'] == 5){
				$callback[1] = site_url('treasurer');
			}
			else{
				$callback[1] = site_url('editorSubmission');
			}
		}
		else{
			$callback[0] = false;
			$callback[1] = "Couldn't find your account or wrong password.";
		}
		echo json_encode($callback);
	}
	
	public function downloadUserGuide($role){
		$this->load->helper('download');
		if($role == 1){
			$path = USER_GUIDE_PATH;
		}
		elseif($role == 2){
			$path = REVIEWER_GUIDE_PATH;
		}
		elseif($role == 3){
			$path = REG_NON_AUTHOR_GUIDE_PATH;
		}
		else{
			$path = REG_AUTHOR_GUIDE_PATH;
		}
		force_download($path, NULL);
	}

}