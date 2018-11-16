<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submission extends CI_Controller {
	
	 public function __construct(){
        parent::__construct();
        $this->utils_model->is_logged_in();
     }
	
	public function index($type = 1){
			$sess_users = $this->session->userdata('is_logged_in');	
			$pass['sess_users'] = $sess_users;
			
			$this->db->where('users_id', $sess_users['users_id']);
			$this->db->order_by('timestamp','desc');
			$mineQuery = $this->db->get('paper');
			$pass['countMine'] = $mineQuery->num_rows();
			
			$coQuery = $this->db->query("SELECT * FROM `online_paper_authors` 
										 JOIN `online_paper` ON `online_paper_authors`.`paper_id` = `online_paper`.`paper_id` 
										 WHERE `online_paper_authors`.`is_corresponding` = 2 
										 AND `online_paper_authors`.`users_id` = '".$sess_users['users_id']."' 
										 OR (`online_paper_authors`.`email` = '".$sess_users['email']."' AND `online_paper_authors`.`is_corresponding` = 2 ) 
										 ORDER BY `timestamp` DESC");
			$pass['countCo'] = $coQuery->num_rows();
			
			if(in_array($sess_users['users_role'] , unserialize(USER_ROLE_TOP) )){
				
				$this->db->select('*');
				$this->db->from('reviewer');
				$this->db->join('paper' , 'reviewer.paper_id = paper.paper_id');
				$this->db->where('reviewer.reviewer_by', $sess_users['users_id']);
				$this->db->where('reviewer.review_status < ', 3 );
				$this->db->order_by('reviewer.assign_time','desc');
				$reviewer = $this->db->get();
				$pass['countReviewer'] = $reviewer->num_rows();
				
			}
		
		if($type == 1){
			$pass['breadcrumbs'] = array(
									'Home' => site_url('submission'),
									'Submission' => site_url('submission')
									);
			
			
			if($this->input->post('search') != ""){
				$this->db->like('title',$this->input->post('search'));
			}
			$this->db->where('users_id', $sess_users['users_id']);
			$this->db->order_by('timestamp','desc');
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
				
				if($dataStatus['status_type'] > 1){
					//$reviewer = $this->db->get_where('reviewer' , array('paper_id'=> $row['paper_id'] , 'review_status' => 4));
					//$dataPaper[$key]['reviewerStatus'] = $reviewer->num_rows();
					
					$reviewer = $this->db->get_where('reviewer' , array('paper_id'=> $row['paper_id'] , 'correction_status > ' => 2));
					$dataPaper[$key]['correctionStatus'] = $reviewer->num_rows();
				}
			}
			$pass['data'] = $dataPaper;
		}
		else{
			$pass['breadcrumbs'] = array(
									'Home' => site_url('submission'),
									'Submission' => site_url('submission')
									);
			$sess_users = $this->session->userdata('is_logged_in');	
			
			$strSQL = "SELECT * FROM `online_paper_authors` 
										 JOIN `online_paper` ON `online_paper_authors`.`paper_id` = `online_paper`.`paper_id` 
										 WHERE `online_paper_authors`.`is_corresponding` = 2 
										 AND `online_paper_authors`.`users_id` = '".$sess_users['users_id']."' 
										 OR (`online_paper_authors`.`email` = '".$sess_users['email']."' AND `online_paper_authors`.`is_corresponding` = 2 )";
	
									
			if($this->input->post('search') != ""){
				$strSQL .= " AND online_paper.title LIKE '%".$this->input->post('search')."%'";
			}
			$strSQL .= " ORDER BY `timestamp` DESC";
			$paper = $this->db->query($strSQL);
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
			
		}
		$data = array(
						'page_content' => $this->load->view('submission/home', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
	}

	
	public function getUser(){
		$q = $this->input->post('q');
		$query = $this->db->query("
						SELECT `online_users`.`users_id`, 
							   `users_role`, 
							   `online_users`.`email`, 
							   `firstname`, 
							   `middlename`, 
							   `lastname`, 
							   `contact_address`, 
							   `city`,
							   `state`,
							   `postal_code`,
							    `online_country`.`country_name`
						FROM `online_users`
						JOIN `online_users_info` ON `online_users`.`users_id` = `online_users_info`.`users_id`
						JOIN `online_country` ON `online_users_info`.`country` = `online_country`.`country_id`
						WHERE `online_users`.`users_role` IN (1,2,4,5)		
						AND ( `firstname` LIKE '%$q%' ESCAPE '!'
						OR  `middlename` LIKE '%$q%' ESCAPE '!'
						OR  `lastname` LIKE '%$q%' ESCAPE '!'
						OR  `online_users`.`email` LIKE '%$q%' ESCAPE '!')	
							");
		$dataArray = array();
		foreach($query->result_array() as $key=>$row){
			$nameFull = array($row['firstname'],$row['middlename'],$row['lastname']);
			$implode = implode(" ",array_filter($nameFull));
			$dataArray[$key] = $row;
			$dataArray[$key]['nameFull'] = $implode;
		}
		
		$data['items'] = $dataArray;
		echo json_encode($data);
	}
	
	public function viewPaper($id){
				$sess_users = $this->session->userdata('is_logged_in');	
				$pass['breadcrumbs'] = array(
								'Home' => site_url('submission'),
								'Submission' => site_url('submission'),
								'View' => site_url('submission/viewPaper/'.$id)
								);
								
				$this->db->where('paper_id' , $id);
				$paperQuery = $this->db->get('paper');
				$pass['data'] = $paperQuery->row_array();
				
				$this->db->where('paper_id' , $id);
				$authorsQuery = $this->db->get('paper_authors');
				$pass['authors'] = $authorsQuery->result_array();
				
				$authorGroup = array();
				$authorEmail = array();
				foreach($authorsQuery->result_array() as $key=>$row){
					$authorGroup[$key] = $row['users_id'];
					$authorEmail[$key] = $row['email'];
				}
				
				if(in_array($sess_users['users_id'] , $authorGroup ) ||  in_array($sess_users['email'] , $authorEmail )){
				
					$this->db->where('paper_id' , $id);
					$this->db->where('is_corresponding' , 1);
					$correspondingQuery = $this->db->get('paper_authors');
					$pass['corresponding'] = $correspondingQuery->row_array();
					$group_corres_name = array(
												$pass['corresponding']['firstname'],
												$pass['corresponding']['middlename'],
												$pass['corresponding']['lastname']
											  );
					$pass['implode_corres_name'] = implode('_' , array_filter($group_corres_name));
					
					$data = array(
									'page_title' => 'Paper Submission',
									'page_content' => $this->load->view('submission/viewPaper', $pass ,TRUE)
								 );
					$this->parser->parse('templates/default', $data);
				}
				else{
					
					$data = array(
									'page_title' => 'Error',
									'page_subtitle' => 'Permission Denied',
									'page_message' => "You cannot access to this page , please contact web administrator."
								 );

					$this->parser->parse('errors/baseError', $data);
					
				}
		
	}
	
	public function editPaper($step , $id = ''){
		if(empty($id)){
			if($step == 1){
				$head['breadcrumbs'] = array(
								'Home' => site_url('submission'),
								'Submission' => site_url('submission'),
								'Add Manuscript/Article' => site_url('submission/editPaper/1')
								);
				$data = array(
								'page_content' => $this->load->view('submission/editPaper', $head ,TRUE)
							 );
				$this->parser->parse('templates/default', $data);
			}
			else{
				$sess_users = $this->session->userdata('is_logged_in');
				$data = $this->utils_model->formPost($this->input->post());
				
				$this->load->helper('string');
				$randomFilename = random_string('md5');
				$userFilePath = UPLOAD_PATH.(date('Y')).'/'.$sess_users['users_id'].'/';
				
				$uploadPDF = $this->utils_model->uploadDocument('file_pdf' , 'PDF_'.$randomFilename );
				if(!$uploadPDF['status']){
					$callback[0] = false;
					$callback[1] = 'PDF File : '.$uploadPDF['error'];
				}
				else{
					$uploadWord = $this->utils_model->uploadDocument('file_word' , 'WORD_'.$randomFilename );
					if(!$uploadWord['status']){
						unlink($userFilePath.$uploadPDF['filedata']);
						$callback[0] = false;
						$callback[1] = 'MS-Word File : '.$uploadWord['error'];
					}
					else{
						$uploadSign = $this->utils_model->uploadDocument('file_signature' , 'SIGN_'.$randomFilename );
						if(!$uploadSign['status']){
							
							unlink($userFilePath.$uploadPDF['filedata']);
							unlink($userFilePath.$uploadWord['filedata']);
							$callback[0] = false;
							$callback[1] = 'Consent Form File : '.$uploadSign['error'];
						}
						else{
							
							$this->db->trans_start();
							// Create Paper Code
							$prefixQuery = $this->db->get_where('paper_prefix' , array('users_id'=>$sess_users['users_id']));
							if($prefixQuery->num_rows() == 0){
								$seq = 1;
								$this->db->set('users_id' , $sess_users['users_id']);
								$this->db->set('prefix_seq' , $seq );
								$this->db->insert('paper_prefix');			
							}
							else{
								$prefixObj = $prefixQuery->row_array();
								$seq = $prefixObj['prefix_seq'] + 1;
								$this->db->set('prefix_seq' , $seq );
								$this->db->where('users_id' , $sess_users['users_id']);
								$this->db->update('paper_prefix');	
							}

							$paper_code = PAPER_PREFIX.$sess_users['users_id'].'-'.str_pad($seq ,4,0,STR_PAD_LEFT);
							// Insert Paper
							$this->db->set('timestamp', 'NOW()', FALSE);
							$this->db->insert('paper' , array(
															'users_id' => $sess_users['users_id'],
															'paper_code' => $paper_code,
															'title' => $data['title'],
															'note' => $data['note'],
															'file_pdf' => $uploadPDF['filedata'],
															'file_word' => $uploadWord['filedata'],
															'file_signature' => $uploadSign['filedata']
														)
											 );
							$insert_id = $this->db->insert_id();				 
							

							// Insert Edit
							$this->db->set('timestamp', 'NOW()', FALSE);
							$this->db->insert('paper_edit' , array(
															'paper_id' => $insert_id ,
															'description' => 'Create new paper',
															'users_id'=>$sess_users['users_id']
														)
											 );
							// Insert Status
							$this->db->set('timestamp', 'NOW()', FALSE);
							$this->db->insert('paper_status' , array(
															'paper_id' => $insert_id ,
															'status_type' => 1,
															'remark' => ''
														)
											 );
											 
							// Insert Author
							$dataAuthor = array();
							foreach($data['users_id'] as $key=>$row){
								if($row == ""){
									$this->db->set('users_id', 'NULL', FALSE);
								}
								else{
									
									$this->db->set('users_id', $row);
								}
								$author_array =  array(
																	'paper_id' => $insert_id ,
																	'firstname' => $data['firstname'][$key],
																	'middlename' => $data['middlename'][$key],
																	'lastname' => $data['lastname'][$key],
																	'contact_address' => $data['contact_address'][$key],
																	'email' => $data['email'][$key],
																	'is_corresponding' => $data['is_corresponding'][$key]
															);
															
								$this->db->insert('paper_authors' , $author_array );
								$dataAuthor[$key] = $author_array;

							}
							$this->db->trans_complete();
								// Send Mail to Author
								foreach($dataAuthor as $key=>$row){
									$passAuthor['data'] = $row;
									$passAuthor['title'] = $data['title'];
									if($row['is_corresponding'] == 1){
										$passAuthor['url'] = site_url('submission/editPaper/1/'.$insert_id);
										$sendAuthor = $this->utils_model->sendEmail(
																					EMAIL_SENDER ,
																					EMAIL_SENDER_NAME ,
																					$row['email'] ,
																					'[SEANES2018] Received Your Manuscript (Corresponding-Author)' ,
																					$this->load->view('templates/email/receivedPaper', $passAuthor , true)
																				  );
									}
									else{
										$passAuthor['url'] = site_url('submission/viewPaper/'.$insert_id);
										$sendAuthor = $this->utils_model->sendEmail(
																					EMAIL_SENDER ,
																					EMAIL_SENDER_NAME ,
																					$row['email'] ,
																					'[SEANES2018] Received Your Manuscript (Co-Author)' ,
																					$this->load->view('templates/email/receivedPaper_coAuthor', $passAuthor , true)
																				  );
									}
									
									
								}
								
								// Send Mail to Admin
								$this->db->select('*');
								$this->db->from('users');
								$this->db->join('users_info' , 'users.users_id = users_info.users_id');
								$this->db->where('users.users_role' , 4);
								$adminQuery = $this->db->get();
								foreach($adminQuery->result_array() as $key=>$row){
									$passAdmin['data'] = $row;
									$passAdmin['url'] = site_url('editor/editPaper/1/'.$insert_id);
									$passAdmin['title'] = $data['title'];
									$sendEmail = $this->utils_model->sendEmail(
																				EMAIL_SENDER ,
																				EMAIL_SENDER_NAME ,
																				$row['email'] ,
																				'[SEANES2018] New Manuscript is submitted from author' ,
																				$this->load->view('templates/email/adminReceivedPaper', $passAdmin , true)
																			  );
								}

								$callback[0] = true;
								$callback[1] = site_url('submission');
							
						}
					}
				}
				echo json_encode($callback);
			}
		}
		else{
			if($step == 1){
				$sess_users = $this->session->userdata('is_logged_in');
				$this->db->where('paper_id' , $id);
				$paperQuery = $this->db->get('paper');
				$pass['data'] = $paperQuery->row_array();
				
				
				$this->db->select('status_type');
				$this->db->from('paper_status');
				$this->db->where('paper_id' ,$id);
				$this->db->order_by('timestamp' ,'DESC');
				$this->db->limit(1);
				$status = $this->db->get();
				$dataStatus =  $status->row_array();
				
				if($dataStatus['status_type'] != 2 && $dataStatus['status_type'] != 4){
					if($sess_users['users_id'] == $pass['data']['users_id']){
						
						
							
						$pass['breadcrumbs'] = array(
												'Home' => site_url('submission'),
												'Submission' => site_url('submission'),
												'Edit Item' => site_url('submission/editPaper/1/'.$id)
												);
												
						$this->db->where('paper_id' , $id);
						$authorsQuery = $this->db->get('paper_authors');
						$pass['authors'] = $authorsQuery->result_array();
								
						$this->db->where('paper_id' , $id);
						$this->db->where('is_corresponding' , 1);
						$correspondingQuery = $this->db->get('paper_authors');
						$pass['corresponding'] = $correspondingQuery->row_array();
						$group_corres_name = array(
															$pass['corresponding']['firstname'],
															$pass['corresponding']['middlename'],
															$pass['corresponding']['lastname']
														  );
						$pass['implode_corres_name'] = implode('_' , array_filter($group_corres_name));
								
						$data = array(
										'page_title' => 'Paper Submission',
										'page_content' => $this->load->view('submission/editPaper', $pass ,TRUE)
									 );

						$this->parser->parse('templates/default', $data);
					
					}
					else{
						$data = array(
										'page_title' => 'Error',
										'page_subtitle' => 'Permission Denied',
										'page_message' => "You cannot access to this page , please contact web administrator."
									 );

						$this->parser->parse('errors/baseError', $data);
						
					}
				}
				else{
					$data = array(
										'page_title' => 'Error',
										'page_subtitle' => 'This article is locked',
										'page_message' => "You cannot change information of this article , please contact web administrator."
									 );

						$this->parser->parse('errors/baseError', $data);
						
					
				}

			}
			else{
				$sess_users = $this->session->userdata('is_logged_in');
				$data = $this->utils_model->formPost($this->input->post());
				
				$this->db->where('paper_id' , $id);
				$query = $this->db->get('paper');
				$paper = $query->row_array();
				
				$this->load->helper('string');
				$randomFilename = random_string('md5');
					
				$updateArray = array(
									'title' => $data['title'],
									 'note' => $data['note']
									 );
				
				if($_FILES['file_pdf']['name'] != ""){
					
					if(file_exists(UPLOAD_PATH.$paper['file_pdf'])){
						unlink(UPLOAD_PATH.$paper['file_pdf']);
					}
					
					$uploadPDF = $this->utils_model->uploadDocument('file_pdf' , 'PDF_'.$randomFilename );
					$updateArray['file_pdf'] = $uploadPDF['filedata'];
				
					
				}
				
				if($_FILES['file_word']['name'] != ""){
					
					if(file_exists(UPLOAD_PATH.$paper['file_word'])){
						unlink(UPLOAD_PATH.$paper['file_word']);	
					}
					
					$uploadWord = $this->utils_model->uploadDocument('file_word' , 'WORD_'.$randomFilename );
					$updateArray['file_word'] = $uploadWord['filedata'];
					
				}
				
				if($_FILES['file_signature']['name'] != ""){
					
					
					if(file_exists(UPLOAD_PATH.$paper['file_signature'])){
						unlink(UPLOAD_PATH.$paper['file_signature']);
					}
					
					$uploadSign = $this->utils_model->uploadDocument('file_signature' , 'SIGN_'.$randomFilename );
					$updateArray['file_signature'] = $uploadSign['filedata'];
					
				
					
				}
				
				$this->db->trans_start();
				// Insert Edit
				$this->db->set('timestamp', 'NOW()', FALSE);
				$this->db->insert('paper_edit' , array(
													'paper_id' => $id ,
													'description' => 'Change instruction of manuscript',
													'users_id'=>$sess_users['users_id']
													)
												 );
				// Edit Paper
				$this->db->where('paper_id' ,$id);
				$this->db->update('paper' , $updateArray);			

				// Edit Author
				$this->db->where('paper_id' , $id);
				$this->db->delete('paper_authors');
							
				foreach($data['users_id'] as $key=>$row){
					if($row == ""){
						$this->db->set('users_id', 'NULL', FALSE);
					}
					else{			
						$this->db->set('users_id', $row);
					}
					$this->db->insert('paper_authors' , array(
																	'paper_id' => $id,
																	'firstname' => $data['firstname'][$key],
																	'middlename' => $data['middlename'][$key],
																	'lastname' => $data['lastname'][$key],
																	'contact_address' => $data['contact_address'][$key],
																	'email' => $data['email'][$key],
																	'is_corresponding' => $data['is_corresponding'][$key]
																)
											 );
				}
				$this->db->trans_complete();
			
				$callback[0] = true;
				$callback[1] = site_url('submission/editPaper/1/'.$id);		
				echo json_encode($callback);					
								
				
			}
		}
	}

	public function removePaper($id){
		
		$this->db->where('paper_id' , $id);
		$query = $this->db->get('paper');
		$data = $query->row_array();
		
				$this->db->select('status_type');
				$this->db->from('paper_status');
				$this->db->where('paper_id' ,$id);
				$this->db->order_by('timestamp' ,'DESC');
				$this->db->limit(1);
				$status = $this->db->get();
				$dataStatus =  $status->row_array();	
		
		if($dataStatus['status_type'] == 1){
			if(unlink(UPLOAD_PATH.$data['file_pdf']) && unlink(UPLOAD_PATH.$data['file_word']) && unlink(UPLOAD_PATH.$data['file_signature'])){
				$this->db->trans_start();
				$this->db->where('paper_id' ,$id);
				$this->db->delete('paper');
				$this->db->trans_complete();
				
				$callback[0] = true;
				$callback[1] = site_url('submission');
				
			}
			else{
				$callback[0] = false;
				$callback[1] = "Couldn't remove file, Please try again";
			}
		}
		else{
			$callback[0] = false;
			$callback[1] = "You cannot change information of this article , please contact web administrator.";
			
		}
		echo json_encode($callback);
	}
	
	public function viewEditLogs(){
		$this->db->where('paper_id' , $this->input->post('id'));
		$query = $this->db->get('paper_status');
		$html = '<div class="table-responsive">
                                        <table class="table table-top-campaign">
                                            <tbody>';
		foreach($query->result_array() as $key=>$row){
                             $html .= '<tr>
                                           <td width="40%">'.date('d/m/Y H:i',strtotime($row['timestamp'])).'</td>
                                            <td class="text-left width="60%">';
												if($row['status_type'] == 1){
												   $html .= 'Waiting';
											  }
											  elseif($row['status_type'] == 2){
												    $html .= 'In review';
											  }
											  elseif($row['status_type'] == 3){
												    $html .= 'In correction';
											  }
											  elseif($row['status_type'] == 4){
												    $html .= 'In press';
											  }
											  else{
												    $html .= 'Published';
											  }	
									 $html .=		'</td>
                                        </tr>';
		}
		echo $html;
	}
	
	public function downloadConsent(){
		$this->load->helper('download');
		force_download(CONSENT_PATH, NULL);
	}
	
	public function forceDownload($paper_id , $field ,$prefix = ''){
		$paperQuery = $this->db->get_where('paper' , array('paper_id'=>$paper_id));
		$paper = $paperQuery->row_array();
		
		$this->db->where('paper_id' ,$paper_id);
		$this->db->where('is_corresponding' , 1);
		$correspondingQuery = $this->db->get('paper_authors');
		$pass['corresponding'] = $correspondingQuery->row_array();
		$group_corres_name = array(
											$pass['corresponding']['firstname'],
											$pass['corresponding']['middlename'],
											$pass['corresponding']['lastname']
										  );
		$implode_corres_name = implode('_' , array_filter($group_corres_name));
		$extension = $this->utils_model->get_file_extension($paper[$field]);
		if($prefix != ""){
			$filename = $prefix."_".$implode_corres_name.'_'.$paper['paper_code'];
			
		}
		else{
			$filename = $implode_corres_name.'_'.$paper['paper_code'];
			
		}
	
		if($field == 'file_signature'){
			$filename .= '-sign';
		}
		
		$this->utils_model->forceDownload( $filename.$extension , UPLOAD_PATH.$paper[$field]);
	}
	
	public function correction($paperID){
		
		$pass['breadcrumbs'] = array(
									'Home' => site_url('submission'),
									'Submission' => site_url('submission'),
									'Correction' => site_url('submission/correction/'.$paperID )
									
									);
		
		$paper = $this->db->get_where('paper' , array('paper_id' => $paperID));
		$pass['paper'] = $paper->row_array();
		
		
		$this->db->select('status_type');
		$this->db->from('paper_status');
		$this->db->where('paper_id' ,$paperID);
		$this->db->order_by('timestamp' ,'DESC');
		$this->db->limit(1);
		$status = $this->db->get();
		$pass['paperStatus'] =  $status->row_array();
		
		

			$this->db->select('*');
			$this->db->from('reviewer');
			$this->db->join('reviewer_evaluation' , 'reviewer.reviewer_id = reviewer_evaluation.review_id');
			$this->db->where('reviewer.paper_id', $paperID);
			$this->db->where('reviewer.review_status', 4);
			$this->db->where('reviewer.correction_status > ', 0);
			$reviewers = $this->db->get();
			
			$pass['reviewers'] = $reviewers->result_array();
			$pass['evaluation_conference'] = unserialize(EVALUATION_CONFERENCE);
			$pass['evaluation_journal'] = unserialize(EVALUATION_JOURNAL);
			
			
		$this->db->where('paper_id' , $paperID);
						$this->db->where('is_corresponding' , 1);
						$this->db->limit(1);
						$correspondingQuery = $this->db->get('paper_authors');
						$pass['corresponding'] = $correspondingQuery->row_array();
						$group_corres_name = array(
															$pass['corresponding']['firstname'],
															$pass['corresponding']['middlename'],
															$pass['corresponding']['lastname']
														  );
						$pass['implode_corres_name'] = implode('_' , array_filter($group_corres_name));
		
	
		
		$data = array(
						'page_content' => $this->load->view('submission/correction', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
	}
	
	
	public function correctionEvaluation($id){
		
		$this->db->select('*');
		$this->db->from('reviewer');
		$this->db->where('reviewer_id', $id);
		$reviewers = $this->db->get();
		
		$pass['reviewers'] = $reviewers->row_array();
		
		
		$evaluation_row = $this->db->get_where('reviewer_evaluation' , array('review_id' => $id));	
		$pass['evaluation_row'] = $evaluation_row->row_array();
		
		
		
		$paper = $this->db->get_where('paper' , array('paper_id' => $pass['reviewers']['paper_id']));
		$pass['paper'] = $paper->row_array();
		
		
		
		$pass['evalution'] = unserialize(EVALUATION_Q);
		$pass['evaluation_conference'] = unserialize(EVALUATION_CONFERENCE);
		$pass['evaluation_journal'] = unserialize(EVALUATION_JOURNAL);
		
			$pass['breadcrumbs'] = array(
									'Home' => site_url('submission'),
									'Submission' => site_url('submission'),
									'Correction' => site_url('submission/correction/'.$pass['reviewers']['paper_id'] ),
									'Evaluation' => site_url('submission/correctionEvaluation/'.$id )
									);
		
		
		$data = array(
						'page_content' => $this->load->view('submission/evaluation', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
		
	}
	
	
	public function printEvaluation($id){
		
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
		
		$filename = 'U'.str_pad($pass['reviewers']['users_id'],4,0,STR_PAD_LEFT).'-'.$pass['paper']['paper_code'].'.pdf';
		
		$html =  $this->load->view('editor/submission/evaluationFormat', $pass ,TRUE);
		
		 ob_start(); 
		
		 $this->load->library('Pdf');
			// create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('TechArise');
            $pdf->SetTitle('TechArise');
            $pdf->SetSubject('TechArise');
            $pdf->SetKeywords('TechArise');
		
		
		
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
 
            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');
 
            // reset pointer to the last page
            $pdf->lastPage();       
            ob_end_clean();
            //Close and output PDF document
            $pdf->Output($filename, 'D');        
		
	}
	
	
	
	public function saveRevise(){
		
		$data = $this->utils_model->formPost($this->input->post());
		
		$query = $this->db->get_where('paper' , array('paper_id' => $data['paper_id']));
		$paper = $query->row_array();
		
		
		$corrArray = array(
							'paper_id'=>$data['paper_id'],
							'is_corresponding'=> 1
							);
		
		$this->db->where( $corrArray );
		$this->db->limit(1);
		$corrQuery = $this->db->get('paper_authors');
		$corrResult = $corrQuery->row_array();
		
		$this->load->helper('string');
		$randomFilename = random_string('md5');
		
		
		
		$this->db->trans_start();
		
		$updateArray = array(
							'revise_title' => $data['title'],
							'revise_submit_date' => date('Y-m-d H:i:s')
							);
						
		if($_FILES['file_pdf']['name'] != ""){
			
			if($paper['revise_file_pdf'] != ""){
				unlink(UPLOAD_PATH.$paper['revise_file_pdf']);
				
			}
			$uploadPDF = $this->utils_model->uploadDocument('file_pdf' , 'REVISE_PDF_'.$randomFilename );
			$updateArray['revise_file_pdf'] = $uploadPDF['filedata'];
			
							
		}
		
		if($_FILES['file_word']['name'] != ""){
			
			if($paper['revise_file_word'] != ""){
				unlink(UPLOAD_PATH.$paper['revise_file_word']);
				
			}
			$uploadWord = $this->utils_model->uploadDocument('file_word' , 'REVISE_WORD_'.$randomFilename );
			$updateArray['revise_file_word'] = $uploadWord['filedata'];
			
		}
		
		$this->db->where('paper_id' , $data['paper_id']);
		$this->db->update('paper' , $updateArray );
		
		
		// Update Reviewer Status
		$this->db->where('paper_id' , $data['paper_id']);
		$this->db->update('reviewer' , array('correction_status'=> 2) );	
		
		
		$this->db->trans_complete();
		
		
		
		// Send Mail to Admin
								$this->db->select('*');
								$this->db->from('users');
								$this->db->join('users_info' , 'users.users_id = users_info.users_id');
								$this->db->where('users.users_role' , 4);
								$adminQuery = $this->db->get();
								foreach($adminQuery->result_array() as $key=>$row){
									$pass['paper'] = $paper;
									$pass['author'] = $corrResult;
									$pass['admin'] = $row;
									$sendEmail = $this->utils_model->sendEmail(
																				EMAIL_SENDER ,
																				EMAIL_SENDER_NAME ,
																				$row['email'],
																				'[SEANES2018] A revised manuscript has been submitted ['.$paper['paper_code'].':'.$paper['title'].']' ,
																				$this->load->view('templates/email/adminReceivedRevise', $pass , true)
																			  );
								}
		
		$callback[0] = true;
		$callback[1] = site_url('submission/reviseSubmission/'.$data['paper_id']);
		echo json_encode($callback);
						
	}
	
	public function cancelRevise($paperID){
		
		$query = $this->db->get_where('paper' , array('paper_id' , $paperID));
		$paper = $query->row_array();
		
		
		$this->db->trans_start();
		
		if($paper['revise_file_pdf'] != ""){
				unlink(UPLOAD_PATH.$paper['revise_file_pdf']);
				
			}
		
		
		if($paper['revise_file_word'] != ""){
				unlink(UPLOAD_PATH.$paper['revise_file_word']);
				
			}
		$updateArray = array(
							'revise_title' => '',
							'revise_file_pdf' => '',
							'revise_file_word' => '',
							'revise_submit_date' => ''
							);
		$this->db->where('paper_id' , $paperID);
		$this->db->update('paper' , $updateArray );			


		// Update Reviewer Status
		$this->db->where('paper_id' , $paperID);
		$this->db->update('reviewer' , array('correction_status'=> 1) );			
		
		$this->db->trans_complete();
		
		$callback[0] = true;
		$callback[1] = site_url('submission/reviseSubmission/'.$paperID);
		echo json_encode($callback);
						
		
	}
	
	
	public function reviseSubmission($paperID){
		
		
		$pass['breadcrumbs'] = array(
									'Home' => site_url('submission'),
									'Submission' => site_url('submission'),
									'Revised Submission' => site_url('submission/reviseSubmission/'.$paperID )
									
									);
		
		$paper = $this->db->get_where('paper' , array('paper_id' => $paperID));
		$pass['paper'] = $paper->row_array();
		
		
		

			
			
		$this->db->where('paper_id' , $paperID);
						$this->db->where('is_corresponding' , 1);
						$this->db->limit(1);
						$correspondingQuery = $this->db->get('paper_authors');
						$pass['corresponding'] = $correspondingQuery->row_array();
						$group_corres_name = array(
															$pass['corresponding']['firstname'],
															$pass['corresponding']['middlename'],
															$pass['corresponding']['lastname']
														  );
						$pass['implode_corres_name'] = implode('_' , array_filter($group_corres_name));
		
	
		
		$data = array(
						'page_content' => $this->load->view('submission/reviseSubmission', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
		
	}
	
	public function reviewResult($paperID , $stage){
		
		$pass['breadcrumbs'] = array(
									'Home' => site_url('submission'),
									'Submission' => site_url('submission'),
									'Correction' => site_url('submission/correction/'.$paperID )
									
									);
		
		$paper = $this->db->get_where('paper' , array('paper_id' => $paperID));
		$pass['paper'] = $paper->row_array();
		
		
		$this->db->select('status_type');
		$this->db->from('paper_status');
		$this->db->where('paper_id' ,$paperID);
		$this->db->order_by('timestamp' ,'DESC');
		$this->db->limit(1);
		$status = $this->db->get();
		$pass['paperStatus'] =  $status->row_array();
	

			$this->db->select('*');
			$this->db->from('reviewer');
			$this->db->join('reviewer_evaluation' , 'reviewer.reviewer_id = reviewer_evaluation.review_id');
			$this->db->where('reviewer.paper_id', $paperID);
			$this->db->where('reviewer.review_status', 4);
			$this->db->where('reviewer.correction_status > ', 0);
			$reviewers = $this->db->get();
			
			$pass['reviewers'] = $reviewers->result_array();
			
		
		
		
		$pass['evaluation_conference'] = unserialize(EVALUATION_CONFERENCE);
		$pass['evaluation_journal'] = unserialize(EVALUATION_JOURNAL);
			
		$pass['stage'] = $stage;
	
		
		$data = array(
						'page_content' => $this->load->view('submission/reviewResult', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
		
		
	}
	
	public function inPressSubmission($paperID){
		$pass['breadcrumbs'] = array(
									'Home' => site_url('submission'),
									'Submission' => site_url('submission'),
									'In Press Submission' => site_url('submission/inpressSubmission/'.$paperID )
									
									);
		
		$paper = $this->db->get_where('paper' , array('paper_id' => $paperID));
		$pass['paper'] = $paper->row_array();
		
		$this->db->select('status_type');
		$this->db->from('paper_status');
		$this->db->where('paper_id' ,$paperID);
		$this->db->order_by('timestamp' ,'DESC');
		$this->db->limit(1);
		$status = $this->db->get();
		$pass['paperStatus'] =  $status->row_array();
		
		
		$this->db->where('paper_id' , $paperID);
						$this->db->where('is_corresponding' , 1);
						$this->db->limit(1);
						$correspondingQuery = $this->db->get('paper_authors');
						$pass['corresponding'] = $correspondingQuery->row_array();
						$group_corres_name = array(
															$pass['corresponding']['firstname'],
															$pass['corresponding']['middlename'],
															$pass['corresponding']['lastname']
														  );
						$pass['implode_corres_name'] = implode('_' , array_filter($group_corres_name));
		
		$data = array(
						'page_content' => $this->load->view('submission/inpressSubmission', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
		
	}
	
	public function saveInpress(){
		
		$data = $this->utils_model->formPost($this->input->post());

		$query = $this->db->get_where('paper' , array('paper_id' , $data['paper_id']));
		$paper = $query->row_array();
		
		
		$this->db->select('status_type');
		$this->db->from('paper_status');
		$this->db->where('paper_id' , $data['paper_id']);
		$this->db->order_by('timestamp' ,'DESC');
		$this->db->limit(1);
		$status = $this->db->get();
		$paperStatus =  $status->row_array();
		
		$this->load->helper('string');
		$randomFilename = random_string('md5');
		
		$this->db->trans_start();
		
		$updateArray = array(
							'inpress_title' => $data['title'],
							'inpress_submit_date' => date('Y-m-d H:i:s')
							);
						
		if($_FILES['file_pdf']['name'] != ""){
			
			if($paper['inpress_file_pdf'] != ""){
				unlink(UPLOAD_PATH.$paper['inpress_file_pdf']);
				
			}
			$uploadPDF = $this->utils_model->adminUploadDocument('file_pdf' , 'INPRESS_PDF_'.$randomFilename );
				$updateArray['inpress_file_pdf'] = $uploadPDF['filedata'];
							
		}
		
		if($_FILES['file_word']['name'] != ""){
			
			if($paper['inpress_file_word'] != ""){
				unlink(UPLOAD_PATH.$paper['inpress_file_word']);
				
			}
			$uploadWord = $this->utils_model->adminUploadDocument('file_word' , 'INPRESS_WORD_'.$randomFilename );
				$updateArray['inpress_file_word'] = $uploadWord['filedata'];
		}
		
		$this->db->where('paper_id' , $data['paper_id']);
		$this->db->update('paper' , $updateArray );
		
		if($paperStatus['status_type'] == 5){
			
			//Change Paper Status
			$paperArray = array(
								'timestamp' => date('Y-m-d H:i:s'),
								'paper_id' => $data['paper_id'],
								'status_type' => 4
								);
			$this->db->insert('paper_status' , $paperArray);
			
		}
		
		
		$this->db->trans_complete();
		
		$callback[0] = true;
		$callback[1] = site_url('submission/inPressSubmission/'.$data['paper_id']);
		echo json_encode($callback);
						
	
		
	}
	
	
}