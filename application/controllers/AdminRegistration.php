<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminRegistration extends CI_Controller {
	
	
	 public function __construct(){
        parent::__construct();
		$this->utils_model->admin_logged_in();
     }
	 
	 
	 public function index(){
		$this->db->order_by('reg_date', 'DESC');
		$this->db->select('*');
		$this->db->from('registration');
		$this->db->join('users_info' , 'users_info.users_id = registration.users_id');
		$registration = $this->db->get();
		$pass['data'] = $registration->result_array();
		
		$pass['participant_type'] = unserialize(REGISTRATION_TYPE);
		$pass['breadcrumbs'] = array(
									'Home' => site_url('adminRegistration'),
									'Registration' => site_url('adminRegistration')
									);
			
			
		$data = array(
						'page_content' => $this->load->view('admins/registration', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
		
	 }
	 
	 public function editRegistration($step = 1 , $id = ''){
		 
		 if(empty($id)){
			 if($step == 1){
					$sess_users = $this->session->userdata('is_logged_in');	
					$pass['sess_users'] = $sess_users;
						
					$this->db->where('users_id', $sess_users['users_id']);
					$users = $this->db->get('users_info');
					$pass['users'] = $users->row_array();
					
					$topAuthor = unserialize(USER_ROLE_AUTHOR);
					if(in_array($sess_users['users_role'] , $topAuthor )){
						
						$this->db->where('users_id', $sess_users['users_id']);
						$this->db->where('reg_id IS NULL',null, false);
						$paper = $this->db->get('paper');
						$pass['paper'] = $paper->result_array();
						$pass['isPaper'] = true;
						$pass['titleNumber'] = 6;
					}
					else{
						$pass['isPaper'] = false;
						$pass['titleNumber'] = 5;
					}
					
					if($th != ''){
						$pass['th'] = 1;
						
					}
					else{
						
						$pass['th'] = 0;
					}
					
					 $country = $this->db->get('country');
					$pass['country'] = $country->result_array();
					
					$pass['breadcrumbs'] = array(
												'Home' => site_url('submission'),
												'Registration' => site_url('registration'),
												'Add Registration' => site_url('registration/addRegistration')
												);
					 $data = array(
									'page_content' => $this->load->view('adminRegistration/addRegistration', $pass ,TRUE)
								 );
					$this->parser->parse('templates/default', $data);
					 
				 }
				 else{
					 
					 
				 }		 
		 }
		 else{
			  if($step == 1){
				 
				 
			 }
			 else{
				 
				 
			 }		
			 
		 }
		 
	 }
	 
	public function removeRegistration($id){
		
		$this->db->where('reg_id' , $id);
		$query = $this->db->get('registration');
		$data = $query->row_array();
		
		if(file_exists('./invoice/'.$data['invoice_file'])){
			unlink('./invoice/'.$data['invoice_file']);
		}
		
		if(file_exists('./uploads/'.$data['pay_slip']) && $data['pay_slip'] != ""){
			unlink('./uploads/'.$data['pay_slip']);
		}
		
			
				$this->db->trans_start();
				
				$this->db->where('reg_id' , $id);
				$paper = $this->db->get('paper');
				
				if($paper->num_rows() > 0){
					foreach($paper->result_array() as $key=>$row){
						$this->db->where('paper_id' , $row['paper_id']);
						$this->db->set('reg_id', 'NULL', false);
						$this->db->update('paper' );
					}
					
				}
				
				$this->db->where('reg_id' ,$id);
				$this->db->delete('registration');
				$this->db->trans_complete();
				
			
		$callback[0] = true;
		$callback[1] = site_url('adminRegistration');
		echo json_encode($callback);
	}
	 
	  public function viewRegistration($reg_id){
		 
		 $this->db->where('reg_id' , $reg_id);
		 $regQuery = $this->db->get_where('registration');
		 $data = $regQuery->row_array();
		 $pass['data'] = $data;
		 
		 
		 
		 $this->db->select('*');
		 $this->db->from('users');
		 $this->db->join('users_info' , 'users.users_id = users_info.users_id');
		 $this->db->where('users.users_id' , $data['users_id']);
		$users = $this->db->get();	
		$pass['users'] = $users->row_array();
		
		
		$topAuthor = unserialize(USER_ROLE_AUTHOR);
		if(in_array($pass['users']['users_role'] , $topAuthor )){
			
			$this->db->where('users_id', $data['users_id']);
			$this->db->where('reg_id',$reg_id);
			$paper = $this->db->get('paper');
			$pass['paper'] = $paper->result_array();		
		}
		
		
		
		
		$calculateFee = $this->utils_model->calculateFee($data['conference_type'],$data['is_th']);
		
		$subtotal = $calculateFee['fee'];
		
		if($data['student_dinner'] == 1){
			if($data['is_th'] == 0){
				$subtotal += 25;	
			}
			else{
				$subtotal += 800;	
			}	
		}
		
			
		if($data['payment_type'] == 2){
			$subtotal += 15;
		}
		
	
		
		$due_date = $this->utils_model->registration_due_date();
		
		
		$pass['fee'] = $calculateFee['fee'];
		$pass['subtotal'] = $subtotal;
		
		if($data['is_th'] == 0){
			$pass['subtotal_word'] = $this->utils_model->convert_number($subtotal);
		}
		else{
			
			$pass['subtotal_word'] = $this->utils_model->convert_number_th(number_format($subtotal,2));
		}
		
		 $pass['breadcrumbs'] = array(
									'Home' => site_url('adminRegistration'),
									'Registration' => site_url('adminRegistration'),
									'View Registration' => site_url('adminRegistration/viewRegistration/'.$reg_id)
									);
									
		  $data = array(
						'page_content' => $this->load->view('admins/viewRegistration', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
	 }
	 
	 public function downloadInvoice($reg_id){
		  
		 $this->db->where('reg_id' , $reg_id);
		 $regQuery = $this->db->get_where('registration');
		 $reg = $regQuery->row_array();
		 
		 $this->load->helper('download');
		$this->load->helper('file');
		$data = read_file(FCPATH.'/invoice/'.$reg['invoice_file']);
		force_download($reg['invoice_file'] , $data );
		 
	 }
	 
	 public function downloadSlip($reg_id){
		  $this->db->where('reg_id' , $reg_id);
		 $regQuery = $this->db->get_where('registration');
		 $reg = $regQuery->row_array();
		 
		 $this->load->helper('download');
		$this->load->helper('file');
		$data = read_file(FCPATH.'/uploads/'.$reg['pay_slip']);
		force_download($reg['pay_slip'] , $data );
		 
		 
	 }
	 
	 
	 public function uploadSlip(){
		 $data = $this->utils_model->formPost($this->input->post());
		 $this->db->where('reg_id' , $data['reg_id']);
		 $regQuery = $this->db->get_where('registration');
		 $reg = $regQuery->row_array();
		 
		 
		 if($_FILES['pay_slip']['name'] != ""){
					
			if(file_exists('./uploads/'.$reg['pay_slip']) && $reg['pay_slip'] != ""){
				unlink('./uploads/'.$reg['pay_slip']);
			}
			$this->load->helper('string');
			$randomFilename = random_string('md5');		
			$upload = $this->utils_model->uploadDocument('pay_slip' , 'SLIP_'.$randomFilename );
			$updateArray['pay_slip'] = $upload['filedata'];
				
			$this->db->where('reg_id' , $data['reg_id']);
			$this->db->update('registration' , $updateArray);
		}
		
		$callback[0] = true;
		$callback[1] = site_url('registration/viewRegistration/'.$data['reg_id']);		
		echo json_encode($callback);	
		 
	 }
	 
}