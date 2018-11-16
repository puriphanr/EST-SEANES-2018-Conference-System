<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	
	 public function __construct(){
        parent::__construct();
		$this->utils_model->admin_logged_in();
     }
	 
	 
	 public function index(){
		 $this->utils_model->deleteSession($this->session->userdata('is_logged_in'));
		 $this->utils_model->deleteSession($this->session->userdata('admin_logged_in'));
		 
		 if(!$this->session->userdata('admin_logged_in')){
			 redirect('account/admin');
		 }
		 else{
			 $users = $this->session->userdata('admin_logged_in');
			
				if($users['users_role'] == 4){
					redirect('editorSubmission');
				}
				elseif($users['users_role'] == 5){
					redirect('treasurer');
				}
				else{
					redirect('editorSubmission');
				}
		 }
	 }
	 
	 public function signout(){
		 
		 $this->session->sess_destroy();
		 redirect('admin');
	 }
	 
	 	
}