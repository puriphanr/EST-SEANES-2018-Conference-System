<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminSettings extends CI_Controller {
	
	
	 public function __construct(){
        parent::__construct();
		$this->utils_model->admin_logged_in();
     }
	 
	 
	 public function users($type = false){
		 
		 $role = unserialize(USER_ROLE);
		 $pass['role'] = $role;
		 
		  $pass['breadcrumbs']['Home'] = site_url('editorSubmission');
		 $pass['breadcrumbs']['Users'] = site_url('AdminSettings/users/'.$type);
		 if($type){
			 $pass['breadcrumbs'][$role[$type]] = site_url('AdminSettings/users/'.$type);
			 
		 }
		
			$this->db->select('*');
			$this->db->from('users');
			$this->db->join('users_info' , 'users.users_id = users_info.users_id');
			$this->db->join('users_confirmation' , 'users.users_id = users_confirmation.users_id');
			if($type){
				$this->db->where('users.users_role' , $type);
			}
			if($this->input->post('search')){
				$this->db->like('users.email' , $this->input->post('search'));
				$this->db->or_like('users_info.firstname' , $this->input->post('search'));
				$this->db->or_like('users_info.lastname' , $this->input->post('search'));
			}
			$this->db->order_by('users.timestamp' , 'DESC');
			$query = $this->db->get();
			
			$pass['user_role_author'] = unserialize(USER_ROLE_AUTHOR);
			$pass['user_role_top'] = unserialize(USER_ROLE_TOP);
			
			$usersData = array();
			foreach($query->result_array() as $key=>$row){
				
				$usersData[$key] = $row;
				if(in_array($row['users_role'] , $pass['user_role_top'])){
					$reviewer = $this->db->get_where('reviewer' , array('reviewer_by' => $row['users_id']));
					$usersData[$key]['countReview'] = $reviewer->num_rows();
				}
				if(in_array($row['users_role'] , $pass['user_role_author'])){
					$paper = $this->db->get_where('paper' , array('users_id' => $row['users_id']));
					$usersData[$key]['countSubmission'] = $paper->num_rows();
				}
				
			}
			
			$pass['data'] = $usersData;
			
			
			

		$data = array(
						'page_content' => $this->load->view('settings/users/home', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
		
	 }
	 
	 public function userReview($users_id){
		 $pass['breadcrumbs']['Home'] = site_url('editorSubmission');
		 $pass['breadcrumbs']['Users'] = site_url('AdminSettings/users');
		 $pass['breadcrumbs']['Review'] = site_url('AdminSettings/userReview/'.$users_id);
		 
		 
			$this->db->select('*');
			$this->db->from('reviewer');
			$this->db->join('paper' , 'reviewer.paper_id = paper.paper_id');
			if($this->input->post('search') != ""){
				$this->db->like('paper.title',$this->input->post('search'));
			}
			$this->db->where('reviewer.reviewer_by', $users_id);
			$this->db->order_by('reviewer.assign_time','desc');
			$paper = $this->db->get();
		 
		 
		 $pass['data'] = $paper->result_array();
		 
		 $data = array(
						'page_content' => $this->load->view('settings/users/userReview', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
		 
	 }
	 
	 public function userSubmission($users_id){
		 $pass['breadcrumbs']['Home'] = site_url('editorSubmission');
		 $pass['breadcrumbs']['Users'] = site_url('AdminSettings/users');
		 $pass['breadcrumbs']['Submission'] = site_url('AdminSettings/userSubmission/'.$users_id);
		 
		 
		if($this->input->post('search') != ""){
			$this->db->like('title',$this->input->post('search'));
		}
		
		$this->db->order_by('timestamp','desc');
		$this->db->where('users_id' , $users_id);
		$paper = $this->db->get('paper');
		
		$dataPaper = array();
		foreach($paper->result_array() as $key=>$row){
			$this->db->select('status_type');
			$this->db->from('paper_status');
			$this->db->where('paper_id' ,$row['paper_id']);
			$this->db->order_by('timestamp' ,'DESC');
			$this->db->limit(1);
			$status = $this->db->get();
			$dataStatus =  $status->row_array();
			$dataPaper[$key] = $row;
			$dataPaper[$key]['status'] = $dataStatus['status_type'];
		}
		$pass['data'] = $dataPaper;
		 
		 $data = array(
						'page_content' => $this->load->view('settings/users/userSubmission', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
		 
	 }
	 
	 
	 public function evaluation($id){

		$this->db->select('*');
		$this->db->from('reviewer');
		$this->db->join('users_info' , 'reviewer.reviewer_by = users_info.users_id');
		$this->db->where('reviewer.reviewer_id', $id);
		$reviewers = $this->db->get();
		
		$pass['reviewers'] = $reviewers->row_array();
		
		if($pass['reviewers']['review_status'] > 1){
			$evaluation_row = $this->db->get_where('reviewer_evaluation' , array('review_id' => $id));
			
			$pass['evaluation_row'] = $evaluation_row->row_array();
			
		}
		
		$paper = $this->db->get_where('paper' , array('paper_id' => $pass['reviewers']['paper_id']));
		$pass['paper'] = $paper->row_array();
		
		$pass['evalution'] = unserialize(EVALUATION_Q);
		$pass['evaluation_conference'] = unserialize(EVALUATION_CONFERENCE);
		$pass['evaluation_journal'] = unserialize(EVALUATION_JOURNAL);
		
		$pass['breadcrumbs'] = array(
			'Home' => site_url('editorSubmission'),
			'Submission' => site_url('editorSubmission'),
			'Reviewers' => site_url('editorSubmission/reviewers/'.$pass['reviewers']['paper_id']),
			'Evaluation' => site_url('editorSubmission/evaluation/'.$id)
		);
		
		$data = array(
						'page_content' => $this->load->view('editor/submission/evaluation', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
		
	}
	
	
	public function viewPaper($paper_id){
		
		
	}
	 
	 public function profile(){
		
		$pass['breadcrumbs'] = array(
								'Home' => site_url('editorSubmission'),
								'User Profile' => site_url('adminSettings/profile')
								);
		$users = $this->session->userdata('admin_logged_in');
		$this->db->where('users_id' , $users['users_id'] );
		$query = $this->db->get('users_info');
		$pass['users'] = $query->row_array();
		
		$data = array(
						'page_title' => 'User Profile',
						'page_content' => $this->load->view('settings/users/profile', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
		 
	 }
	 
	 public function saveProfile(){

		$data = $this->utils_model->formPost($this->input->post());
		
		$users = $this->session->userdata('admin_logged_in');
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
								);
				$this->db->where('users_id' , $users['users_id']);
				$this->db->update('users_info', $data_info);
				$this->db->trans_complete();
				
				
				$callback[0] = true;
				$this->session->sess_destroy();
				$callback[1] = site_url('admin');
				
				echo json_encode($callback);
	 }
	 
	 public function editUser($step , $id = ''){
		 if(empty($id)){
			 
			 if($step == 1){
				$pass['breadcrumbs'] = array(
								'Home' => site_url('editorSubmission'),
								'Users' => site_url('adminSettings/users')
								);

				$pass['role'] = unserialize(USER_ROLE);
				$country = $this->db->get('country');
				$pass['country'] = $country->result_array();

				$data = array(
						'page_content' => $this->load->view('settings/users/editUser', $pass ,TRUE)
					 );
				$this->parser->parse('templates/defaultAdmin', $data);
				 
			 }
			 else{
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
										'verify' => 1
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
					$callback[1] = site_url('adminSettings/users');
						
				}
				echo json_encode($callback); 
			 }
			 
		 }
		 else{
			 
			 
			 if($step == 1){
				 
				 $pass['breadcrumbs'] = array(
								'Home' => site_url('editorSubmission'),
								'Users' => site_url('adminSettings/users')
								);

				$pass['role'] = unserialize(USER_ROLE);
				$country = $this->db->get('country');
				$pass['country'] = $country->result_array();
				
				$this->db->select("*");
				$this->db->from("users");
				$this->db->join("users_info" , "users.users_id = users_info.users_id");
				$this->db->where('users.users_id' , $id );
				$query = $this->db->get();
				$pass['data'] = $query->row_array();
				
				$data = array(
						'page_content' => $this->load->view('settings/users/editUser', $pass ,TRUE)
					 );
				$this->parser->parse('templates/defaultAdmin', $data);
				 
			 }
			 else{
				 
				 $data = $this->utils_model->formPost($this->input->post());
				 $this->db->trans_start();
				 $name_title = ($data['name_title'] == 'Other') ? $data['name_title_other'] : $data['name_title'];
				$data_users = array(
									'users_role' 	=> $data['users_role']
									);

				if(!empty($data['change_password'])){
					$data_users['password'] 	= md5($data['password']);
					
				}
				$this->db->where('users_id' , $id);
				$this->db->update('users', $data_users);
				
				
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
								
				if($data['users_role'] == 2){
						$data_info['job_position'] = $data['job_position'];
						$data_info['contact_line'] = $data['contact_line'];
						$data_info['contact_messenger'] = $data['contact_messenger'];
						$data_info['contact_whatsapp'] = $data['contact_whatsapp'];
						$data_info['interest'] = $data['interest'];
				}
				$this->db->where('users_id' , $id);
				$this->db->update('users_info', $data_info);
				$this->db->trans_complete();
				
				
				$callback[0] = true;
				$callback[1] = site_url('adminSettings/editUser/1/'.$id);
				
				echo json_encode($callback); 
			 }
			 
		 }	 
	 }
	 
	 public function removeUser($id){
		 
		 $this->db->trans_start();
		 $paper = $this->db->get_where('paper' , array('users_id' => $id));
		 if($paper->num_rows() > 0){
			 foreach($paper->result_array() as $key=>$row){
				unlink(UPLOAD_PATH.$row['file_pdf']);
				unlink(UPLOAD_PATH.$row['file_word']);
				unlink(UPLOAD_PATH.$data['file_signature']); 
			 }
		 }
		 
		 $this->db->where('users_id' , $id);
		 $this->db->delete('users');
		 $this->db->trans_complete();
		 
		$callback[0] = true;
		$callback[1] = site_url('adminSettings/users');
		
		echo json_encode($callback);
	 }
	 
	 
}