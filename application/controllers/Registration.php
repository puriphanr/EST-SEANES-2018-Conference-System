<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {
	
	
	 public function __construct(){
        parent::__construct();
		 $this->utils_model->is_logged_in();
     }
	 
	 
	 public function index(){
		 
		$sess_users = $this->session->userdata('is_logged_in');	
		$pass['sess_users'] = $sess_users;
			
		$this->db->where('users_id', $sess_users['users_id']);
		$registration = $this->db->get('registration');
		$pass['data'] = $registration->result_array();
		$pass['participant_type'] = unserialize(REGISTRATION_TYPE);
		$pass['breadcrumbs'] = array(
									'Home' => site_url('submission'),
									'Registration' => site_url('registration')
									);
			
			
		$data = array(
						'page_content' => $this->load->view('registration/home', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
	 }
	 
	 
	 public function addRegistration($th = ''){
		 
		$sess_users = $this->session->userdata('is_logged_in');	
		$pass['sess_users'] = $sess_users;
			
		$this->db->where('users_id', $sess_users['users_id']);
		$users = $this->db->get('users_info');
		$pass['users'] = $users->row_array();
		
		$topAuthor = unserialize(USER_ROLE_AUTHOR);
		if(in_array($sess_users['users_role'] , $topAuthor )){
			
			$this->db->select('*');
			$this->db->from('paper_authors');
			$this->db->join('paper' , 'paper_authors.paper_id = paper.paper_id');
			$this->db->where('paper_authors.email', $sess_users['email']);
			$this->db->where('online_paper.reg_id IS NULL',null, false);
			$paper = $this->db->get();
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
						'page_content' => $this->load->view('registration/addRegistration', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
		 
	 }
	 
	 public function confirmRegistration(){
		 
		 $data = $this->utils_model->formPost($this->input->post());
		 $pass['data'] = $data;
		 
		 
		 $sess_users = $this->session->userdata('is_logged_in');	
		$pass['users'] = $sess_users;
	
		
		$calculateFee = $this->utils_model->calculateFee($data['conference_fee'],$data['is_th']);
		
		$subtotal = $calculateFee['fee'];
		
		if(!empty($data['student_dinner'])){
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
		
		
		if(!empty($data['paper'])){
			$paper = array();
			foreach($data['paper'] as $key=>$row){
				$paperQuery = $this->db->get_where('paper' , array('paper_id'=>$row));
				$rs = $paperQuery->row_array(); 
				$paper[$key] = $rs;
			}
			$pass['paper'] = $paper;
		}
		
		$due_date = $this->utils_model->registration_due_date();
		
		$pass['due_date'] = $due_date;
		$pass['fee'] = $calculateFee['fee'];
		$pass['subtotal'] = $subtotal;
		if($data['is_th'] == 0){
			$pass['subtotal_word'] = $this->utils_model->convert_number($subtotal);
		}
		else{
			
			$pass['subtotal_word'] = $this->utils_model->convert_number_th(number_format($subtotal,2));
		}
		 
		 $pass['breadcrumbs'] = array(
									'Home' => site_url('submission'),
									'Registration' => site_url('registration'),
									'Add Registration' => site_url('registration/addRegistration')
									);
									
		  $data = array(
						'page_content' => $this->load->view('registration/confirmRegistration', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
	 }
	 
	 public function saveRegistration(){
		 $fix_due_date = '2018-11-10';
		 date_default_timezone_set('asia/bangkok');
		 $this->load->helper('date');
		 
		 $sess_users = $this->session->userdata('is_logged_in');
		 $data = $this->utils_model->formPost($this->input->post());
		 
		
		$this->db->where('users_id', $sess_users['users_id']);
		$users = $this->db->get('users_info');
		$passEmail['data'] = $users->row_array();
		
		$calculateFee = $this->utils_model->calculateFee($data['conference_type'],$data['is_th']);
		
		$subtotal = $calculateFee['fee'];
		
		if(!empty($data['student_dinner'])){
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
		 
		 $nowDate = date('Y-m-d');
		 
		 $due_date = $this->utils_model->registration_due_date();
		
		 $this->db->trans_start();
		 $insertReg = array(
							'reg_date' => date('Y-m-d H:i:s'),
							'users_id' => $sess_users['users_id'],
							'invoice_address' => $data['invoice_address'],
							'conference_type'=>$data['conference_type'],
							'payment_type' =>$data['payment_type'],
							'pre_conference' => $data['pre_conference'],
							'welcome_dinner' => $data['welcome_dinner'],
							'price_type'=> $calculateFee['price_type'],
							'price' => $calculateFee['fee'] ,
							'total' => $subtotal,
							'due_date' => $due_date,
							'is_th' => $data['is_th'],
							'dietary' => $data['dietary']
						);
		if($data['dietary'] == 4){
			
			$insertReg['dietary_other'] = $data['dietary_other'];
		}
		
		if( $data['student_dinner'] == 1 && !empty($data['student_dinner'])){
			
			$insertReg['student_dinner'] = $data['student_dinner'];
			
		}
		 
		 $insertQuery = $this->db->insert('registration' , $insertReg );
		 $insert_id = $this->db->insert_id();
		 
		
		 if(!empty($data['paper'])){
			foreach($data['paper'] as $key=>$row){
				$this->db->where('paper_id' , $row);
				$this->db->update('paper' , array('reg_id' => $insert_id));
			}
			 
		 }
		 
		 $regCode = 'IV-U'.str_pad($passEmail['data']['users_id'], 4 , 0, STR_PAD_LEFT).'-'.str_pad($insert_id, 4 , 0, STR_PAD_LEFT);
		 
		 $this->db->set('reg_code' , $regCode);
		 $this->db->set('invoice_file' , $regCode.'.pdf');
		 $this->db->where('reg_id' , $insert_id);
		 $this->db->update('registration');
		 
		 
		 $this->db->trans_complete();
		 
		 $passInvoice['data'] = $data;
		 $passInvoice['due_date'] = $due_date;
		 $passInvoice['data']['reg_id'] = $insert_id;
		 $passInvoice['reg_code'] =$regCode;
		 $passInvoice['users'] = $passEmail['data'];
		
	
		$passInvoice['fee'] = $calculateFee['fee'];
		$passInvoice['subtotal'] = $subtotal;
		
		if($data['is_th'] == 0){
			$passInvoice['subtotal_word']  = $this->utils_model->convert_number($subtotal);
		}
		else{
			
			$passInvoice['subtotal_word']  = $this->utils_model->convert_number_th(number_format($subtotal,2));
		}
	
		 // Create PDF
		 $filename = FCPATH.'/invoice/'.$regCode.'.pdf';
		 $imgLogo = FCPATH.'/assets/images/EST-Logo02.png';
		 $html =  $this->load->view('registration/invoice', $passInvoice ,TRUE);
		
		 ob_start(); 
		
		 $this->load->library('Pdf');
			// create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Invoice');
            $pdf->SetTitle('Invoice');
            $pdf->SetSubject('Invoice');
            $pdf->SetKeywords('Invoice');
		
		
		
		// set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
 
            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
 
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
          
			
			
						// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
		
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 10);
			 
            
 
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }       
 
            // set font
            $pdf->SetFont('freeserif', '', 10);
 
            // add a page
            $pdf->AddPage();
			$pdf->Image($imgLogo, 20 ,22  , 40,38,'png');
            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');
 
            // reset pointer to the last page
            $pdf->lastPage();       
            ob_end_clean();
            //Close and output PDF document
            $pdf->Output($filename, 'F'); 
			
			
			
		//Send Email
		 $cc = array(
						'teeraphunk@gmail.com',
						'naris@engr.tu.ac.th'
					);
		 $sendAuthor = $this->utils_model->sendEmail(
																					EMAIL_SENDER ,
																					EMAIL_SENDER_NAME ,
																					$sess_users['email'],
																					'[SEANES2018] Registration Information and Invoice' ,
																					$this->load->view('templates/email/sendInvoice', $passEmail , true),
																					FCPATH.'/invoice/'.$regCode.'.pdf',
																					$cc
																				  );
		 
		
			
		$callback[0] = true;
		$callback[1] = site_url('registration/viewRegistration/'.$insert_id);		
		echo json_encode($callback);	
		 
	 }
	 
	 public function viewRegistration($reg_id){
		 
		 $this->db->where('reg_id' , $reg_id);
		 $regQuery = $this->db->get_where('registration');
		 $data = $regQuery->row_array();
		 $pass['data'] = $data;
		 
		 
		$sess_users = $this->session->userdata('is_logged_in');	
		$pass['users'] = $sess_users;
		
		
		$topAuthor = unserialize(USER_ROLE_AUTHOR);
		if(in_array($sess_users['users_role'] , $topAuthor )){
			
			$this->db->where('users_id', $sess_users['users_id']);
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
									'Home' => site_url('submission'),
									'Registration' => site_url('registration'),
									'View Registration' => site_url('registration/viewRegistration/'.$reg_id)
									);
									
		  $data = array(
						'page_content' => $this->load->view('registration/viewRegistration', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
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
		$callback[1] = site_url('registration');
		echo json_encode($callback);
	}
	
	
	
	/*public function testFee($conference_type , $is_th = 0 ){
		
		 date_default_timezone_set('asia/bangkok');
		 $this->load->helper('date');
		 
		 $now = date('Y-m-d');
		 
		 $dateEarly = '2018-11-10';
		 $dateAfter = '2018-11-30';
		 echo $dateEarly;
			if($now <= $dateEarly){
				$price_type = 1;
			 }
			 elseif($now <= $dateAfter){
				 $price_type = 2;
			 }
			 else{
				 $price_type = 3;
			 }
		
			
			if($is_th == 0){
			
				if($conference_type == 1){
					
					 
					 if($now <= $dateEarly){
						 $fee = 350;
					 }
					 elseif($now <= $dateAfter){
						 $fee = 400;
					 }
					 else{
						 $fee = 500;
					 }
					
				}
				elseif($conference_type == 2){
					
					 if($now <= $dateEarly){
						 $fee = 400;
					 }
					 elseif($now <= $dateAfter){
						 $fee = 450;
					 }
					 else{
						 $fee = 550;
					 }
					
				}
				elseif($conference_type == 3){
					
					 if($now <= $dateEarly){
						 $fee = 450;
					 }
					 elseif($now <= $dateAfter){
						 $fee = 500;
					 }
					 else{
						 $fee = 600;
					 }
				}
				else{
					 if($now <= $dateEarly){
						 $fee = 200;
					 }
					 elseif($now <= $dateAfter){
						 $fee = 350;
					 }
					 else{
						 $fee = 400;
					 }
					
				}
				
			
			}
			else{
				
				if($conference_type == 1){
					
					 
					 if($now <= $dateEarly){
						 $fee = 7500;
					 }
					 elseif($now <= $dateAfter){
						 $fee = 8500;
					 }
					 else{
						 $fee = 13000;
					 }
					
				}
				elseif($conference_type == 2){
					
					 if($now <= $dateEarly){
						 $fee = 7000;
					 }
					 elseif($now <= $dateAfter){
						 $fee = 8000;
					 }
					 else{
						 $fee = 12000;
					 }
					
				}
				elseif($conference_type == 3){
					
					 if($now <= $dateEarly){
						 $fee = 5000;
					 }
					 elseif($now <= $dateAfter){
						 $fee = 6000;
					 }
					 else{
						 $fee = 10000;
					 }
				}
				else{
					 if($now <= $dateEarly){
						 $fee = 3000;
					 }
					 elseif($now <= $dateAfter){
						 $fee = 4000;
					 }
					 else{
						 $fee = 6000;
					 }
					
				}
				
				
				
			}
			
			
		print_r(array('fee' => $fee , 'price_type' => $price_type)) ;
		
	}
	
	
	public function test_due_date(){
		
		date_default_timezone_set('asia/bangkok');
		 $this->load->helper('date');
		 
		 $now = date('Y-m-d');
		 $dateEarly = '2018-11-10';
		 $dateAfter = '2018-11-30';
		
		if($now <= $dateEarly){
			
			$due_date = $dateEarly;
			
		}
		elseif($now <= $dateAfter){
			
			$due_date = $dateAfter;
		}
		else{
			$due_date = NULL;
			
		}
		
		return $due_date;
		
	}*/
	
	 
}