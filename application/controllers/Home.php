<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	
	 public function __construct(){
        parent::__construct();
     }
	 
	 
	 public function index(){
		 if(!$this->session->userdata('is_logged_in')){
			 redirect('account');
		 }
		 else{
			 $users = $this->session->userdata('is_logged_in');
				if($users['users_role'] == 1){
					redirect('submission');
				}
				elseif($users['users_role'] == 2){
					redirect('review');
				}
				else{
					redirect('registration');
				}
		 }
	 }
	 
	 public function testmail(){
		 $this->utils_model->smtpGmail('AdminSC@est.or.th' , 'SEANES2018' , 'puriphan.r@gmail.com' , 'First mail from Review System using Gmail SMTP' , 'First mail from Review System using Gmail SMTP');
		 
	 }
	 public function phpinfo(){
		echo phpinfo();
	}
	 
}