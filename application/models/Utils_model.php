<?php
class Utils_model extends CI_Model {
	
	public function sendEmail($from ,$fromname , $to , $subject, $message , $attach = '' , $cc = ''){
		$config = array(
			'protocol' => 'mail',
			'mailpath' => "/usr/bin/sendmail",
			'mailtype' => 'html',
			'smtp_host'  => "localhost",
			'smtp_port'  => "25",
		    'charset' => 'utf8',
		    'wordwrap' => TRUE
		);
		
        $this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from($from , $fromname);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if(!empty($attach)){
			$this->email->attach($attach);
		}
		
		if(!empty($cc)){
			
				$this->email->cc($cc);
			
		}
		  
		if($this->email->send()){
			return true;
		}
		
	}
	
	public function set($dataArray){
		$result_array = array();
		foreach($dataArray as $key=>$row){

				$result_array[$key] = $row;
			
		}
		return $result_array;
	}
	
	
	public function formPost($data , $exclude = array()){
		$output = array();
		foreach($data as $key=>$row){
			if(!in_array($key , $exclude)){
				$output[$key] = $row;
			}
		}
		return $output;
	}
	
	public function is_logged_in(){
		if(!$this->session->userdata('is_logged_in')){
			redirect('account');
		}
		
	}
	
	public function already_logged_in(){
		if($this->session->userdata('is_logged_in')){
			redirect('Home');
		}
	}
	
	public function deleteSession($session){
		if($session){
			$this->session->sess_destroy();
			redirect($this->uri->uri_string());
		}
	}
	
	public function forceDownload($filename , $path){
		$this->load->helper('download');
		$this->load->helper('file');
		$data = read_file($path);
		force_download($filename , $data );
	}
	
	public function get_file_extension($file){
		$info = pathinfo($file);
		return '.'.$info['extension'];
	}
	
	
	public function uploadDocument($fileField , $filename  , $maxSize = 10485760){
		
		$file_size = $_FILES[$fileField]['size'];
		$extension = $this->get_file_extension($_FILES[$fileField]['name']);
		
		$yearfolder = date('Y');
		if (!file_exists(UPLOAD_PATH.$yearfolder)) {
			mkdir(UPLOAD_PATH.$yearfolder);
		}
		
		$sessUsers = $this->session->userdata('is_logged_in');
		if (!file_exists(UPLOAD_PATH.$yearfolder.'/'.$sessUsers['users_id'])) {
			mkdir(UPLOAD_PATH.$yearfolder.'/'.$sessUsers['users_id']);
		}
		
		$result = array();
		if($file_size > $maxSize){
			$result['status'] = false;
			$result['error'] = 'Exceed maximum limit file size, please try another file';
			
		}
		else{
			if (!move_uploaded_file($_FILES[$fileField]['tmp_name'] , UPLOAD_PATH.$yearfolder.'/'.$sessUsers['users_id'].'/'.$filename.$extension )) {
				$result['status'] = false;
				$result['error'] = 'Cannot upload file, please try again';
			}
			else{
				$result['status'] = true;
				$result['filedata'] = $yearfolder.'/'.$sessUsers['users_id'].'/'.$filename.$extension ;
			}
		}
		return $result;
	}
	
	
	public function adminUploadDocument($fileField , $filename  , $maxSize = 10485760){
		
		$file_size = $_FILES[$fileField]['size'];
		$extension = $this->get_file_extension($_FILES[$fileField]['name']);
		
		$yearfolder = date('Y');
		if (!file_exists(UPLOAD_PATH.$yearfolder)) {
			mkdir(UPLOAD_PATH.$yearfolder);
		}
		
		$sessUsers = $this->session->userdata('admin_logged_in');
		if (!file_exists(UPLOAD_PATH.$yearfolder.'/'.$sessUsers['users_id'])) {
			mkdir(UPLOAD_PATH.$yearfolder.'/'.$sessUsers['users_id']);
		}
		
		$result = array();
		if($file_size > $maxSize){
			$result['status'] = false;
			$result['error'] = 'Exceed maximum limit file size, please try another file';
			
		}
		else{
			if (!move_uploaded_file($_FILES[$fileField]['tmp_name'] , UPLOAD_PATH.$yearfolder.'/'.$sessUsers['users_id'].'/'.$filename.$extension )) {
				$result['status'] = false;
				$result['error'] = 'Cannot upload file, please try again';
			}
			else{
				$result['status'] = true;
				$result['filedata'] = $yearfolder.'/'.$sessUsers['users_id'].'/'.$filename.$extension ;
			}
		}
		return $result;
	}
	
	
	public function admin_logged_in(){
		if(!$this->session->userdata('admin_logged_in')){
			redirect('account/admin');
		}
	}
	
	
	public function smtpGmail($from ,$fromname , $to , $subject, $message){
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.gmail.com',
			'smtp_user' => 'puriphan.r@gmail.com',
			'smtp_pass' => '2395hsmct',
			'mailtype' => 'html',
		    'charset' => 'iso-8859-1',
		    'wordwrap' => TRUE
		);
		
        $this->load->library('email', $config);
		$this->email->from($from , $fromname);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		  
		if($this->email->send()){
			echo 'sent';
		}
		else{
			show_error($this->email->print_debugger());
		}
	}
		
		
	public function calculateFee($conference_type , $is_th = 0 ){
		
		 date_default_timezone_set('asia/bangkok');
		 $this->load->helper('date');
		 
		 $now = date('Y-m-d');
		 
		 $dateEarly = '2018-11-10';
		 $dateAfter = '2018-11-30';
		 
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
			
			
		return array('fee' => $fee , 'price_type' => $price_type) ;
		
	}
	
	
	public function registration_due_date(){
		
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
		
	}
	
	public function convert_number($number) {
		if (($number < 0) || ($number > 999999999)) {
			throw new Exception("Number is out of range");
		}
		$Gn = floor($number / 1000000);
		/* Millions (giga) */
		$number -= $Gn * 1000000;
		$kn = floor($number / 1000);
		/* Thousands (kilo) */
		$number -= $kn * 1000;
		$Hn = floor($number / 100);
		/* Hundreds (hecto) */
		$number -= $Hn * 100;
		$Dn = floor($number / 10);
		/* Tens (deca) */
		$n = $number % 10;
		/* Ones */
		$res = "";
		if ($Gn) {
			$res .= $this->convert_number($Gn) .  "Million";
		}
		if ($kn) {
			$res .= (empty($res) ? "" : " ") .$this->convert_number($kn) . " Thousand";
		}
		if ($Hn) {
			$res .= (empty($res) ? "" : " ") .$this->convert_number($Hn) . " Hundred";
		}
		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
		if ($Dn || $n) {
			if (!empty($res)) {
				$res .= " and ";
			}
			if ($Dn < 2) {
				$res .= $ones[$Dn * 10 + $n];
			} else {
				$res .= $tens[$Dn];
				if ($n) {
					$res .= "-" . $ones[$n];
				}
			}
		}
		if (empty($res)) {
			$res = "zero";
		}
		return $res;
	}
	
	function convert_number_th($number){ 
		$txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
		$txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
		$number = str_replace(",","",$number); 
		$number = str_replace(" ","",$number); 
		$number = str_replace("บาท","",$number); 
		$number = explode(".",$number); 
		if(sizeof($number)>2){ 
		return 'ทศนิยมหลายตัวนะจ๊ะ'; 
		exit; 
		} 
		$strlen = strlen($number[0]); 
		$convert = ''; 
		for($i=0;$i<$strlen;$i++){ 
			$n = substr($number[0], $i,1); 
			if($n!=0){ 
				if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; } 
				elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; } 
				elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
				else{ $convert .= $txtnum1[$n]; } 
				$convert .= $txtnum2[$strlen-$i-1]; 
			} 
		} 

		$convert .= 'บาท'; 
		if($number[1]=='0' OR $number[1]=='00' OR 
		$number[1]==''){ 
		$convert .= 'ถ้วน'; 
		}else{ 
		$strlen = strlen($number[1]); 
		for($i=0;$i<$strlen;$i++){ 
		$n = substr($number[1], $i,1); 
			if($n!=0){ 
			if($i==($strlen-1) AND $n==1){$convert 
			.= 'เอ็ด';} 
			elseif($i==($strlen-2) AND 
			$n==2){$convert .= 'ยี่';} 
			elseif($i==($strlen-2) AND 
			$n==1){$convert .= '';} 
			else{ $convert .= $txtnum1[$n];} 
			$convert .= $txtnum2[$strlen-$i-1]; 
			} 
		} 
		$convert .= 'สตางค์'; 
		} 
		return $convert; 
	} 
}