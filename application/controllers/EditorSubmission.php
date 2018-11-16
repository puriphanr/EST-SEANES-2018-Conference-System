<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditorSubmission extends CI_Controller {
	
	 public function __construct(){
        parent::__construct();
        $this->utils_model->admin_logged_in();
     }
	
	public function index(){
		$pass['breadcrumbs'] = array(
								'Home' => site_url('editorSubmission'),
								'Submission' => site_url('editorSubmission')
								);
		$sess_users = $this->session->userdata('admin_logged_in');	
		
		if($this->input->post('search') != ""){
			$this->db->like('title',$this->input->post('search'));
		}
		
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
			
			$authors_where = array(
									'paper_id' => $row['paper_id'],
									'is_corresponding' => 1
								);
			$this->db->select('firstname,middlename,lastname');
			$this->db->from('paper_authors');
			$this->db->where($authors_where);
			$this->db->order_by('authors_id' ,'ASC');
			$this->db->limit(1);
			$authorsQuery = $this->db->get();
			$dataPaper[$key]['authors'] = $authorsQuery->row_array();
		}
		$pass['data'] = $dataPaper;
		$data = array(
						'page_content' => $this->load->view('editor/submission/home', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
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
						WHERE (`online_users`.`users_role` = 1
						OR 		`online_users`.`users_role` = 4)				
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
	
	public function editPaper($step , $id = ''){
		if(empty($id)){
			if($step == 1){
				$head['breadcrumbs'] = array(
								'Home' => site_url('editorSubmission'),
								'Submission' => site_url('editorSubmission'),
								'Add Manuscript/Article' => site_url('editorSubmission/editPaper/1')
								);
				$data = array(
								'page_content' => $this->load->view('editor/submission/editPaper', $head ,TRUE)
							 );
				$this->parser->parse('templates/defaultAdmin', $data);
			}
			else{
				$sess_users = $this->session->userdata('admin_logged_in');
				$data = $this->utils_model->formPost($this->input->post());
				
				if(!empty($data['users_id'])){
					$corr_arr = array();
					foreach($data['is_corresponding'] as $ckey=> $crow){
						if($crow == 1){
							$corr_arr[$ckey] = $crow;
						}
					}
					
					if(count($corr_arr) == 1){
						$ownerID = $data['users_id'][array_search(1 ,$data['is_corresponding'])];
						$this->load->helper('string');
						$randomFilename = random_string('md5');
						$userFilePath = UPLOAD_PATH.(date('Y')).'/'.$sess_users['users_id'].'/';
						
						$uploadPDF = $this->utils_model->adminUploadDocument('file_pdf' , 'PDF_'.$randomFilename );
						if(!$uploadPDF['status']){
							$callback[0] = false;
							$callback[1] = 'PDF File : '.$uploadPDF['error'];
						}
						else{
							$uploadWord = $this->utils_model->adminUploadDocument('file_word' , 'WORD_'.$randomFilename );
							if(!$uploadWord['status']){
								unlink($userFilePath.$uploadPDF['filedata']);
								$callback[0] = false;
								$callback[1] = 'MS-Word File : '.$uploadWord['error'];
							}
							else{
								$uploadSign = $this->utils_model->adminUploadDocument('file_signature' , 'SIGN_'.$randomFilename );
								if(!$uploadSign['status']){
									
									unlink($userFilePath.$uploadPDF['filedata']);
									unlink($userFilePath.$uploadWord['filedata']);
									$callback[0] = false;
									$callback[1] = 'Consent Form File : '.$uploadSign['error'];
								}
								else{
									$this->db->trans_start();
									// Create Paper Code
									$prefixQuery = $this->db->get_where('paper_prefix' , array('users_id'=>$ownerID));
									if($prefixQuery->num_rows() == 0){
										$seq = 1;
										$this->db->set('users_id' , $ownerID);
										$this->db->set('prefix_seq' , $seq );
										$this->db->insert('paper_prefix');			
									}
									else{
										$prefixObj = $prefixQuery->row_array();
										$seq = $prefixObj['prefix_seq'] + 1;
										$this->db->set('prefix_seq' , $seq );
										$this->db->where('users_id' , $ownerID);
										$this->db->update('paper_prefix');	
									}

									$paper_code = PAPER_PREFIX.$ownerID.'-'.str_pad($seq ,4,0,STR_PAD_LEFT);
									// Insert Paper
									$this->db->set('timestamp', 'NOW()', FALSE);
									$this->db->insert('paper' , array(
																	'users_id' => $ownerID,
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
																	'description' => 'Create new paper (By Admin : '.$sess_users['firstname'].' '.$sess_users['lastname'].')',
																	'users_id'=> $ownerID
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
								
									$callback[0] = true;
									$callback[1] = site_url('editorSubmission');
									
								}
							}
						}
					}
					else{
						$callback[0] = false;
						$callback[1] = "Corresponding-Author must be at least one row only.";
					}
				}
				else{
					$callback[0] = false;
					$callback[1] = "Please choose at least one author.";
						
				}
				
				echo json_encode($callback);
			}
		}
		else{
			if($step == 1){
				
				$pass['breadcrumbs'] = array(
								'Home' => site_url('editorSubmission'),
								'Submission' => site_url('editorSubmission'),
								'Add Manuscript/Article' => site_url('editorSubmission/editPaper/1/'.$id)
								);
								
				$this->db->where('paper_id' , $id);
				$paperQuery = $this->db->get('paper');
				$pass['data'] = $paperQuery->row_array();
				
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
								'page_content' => $this->load->view('editor/submission/editPaper', $pass ,TRUE)
							 );
				$this->parser->parse('templates/defaultAdmin', $data);
			}
			else{
				$sess_users = $this->session->userdata('admin_logged_in');
				$data = $this->utils_model->formPost($this->input->post());
				if(!empty($data['users_id'])){
					$corr_arr = array();
					foreach($data['is_corresponding'] as $ckey=> $crow){
						if($crow == 1){
							$corr_arr[$ckey] = $crow;
						}
					}
					
					if(count($corr_arr) == 1){
						$ownerID = $data['users_id'][array_search(1 ,$data['is_corresponding'])];
						
						$this->db->where('paper_id' , $id);
						$query = $this->db->get('paper');
						$paper = $query->row_array();
												
						$this->load->helper('string');
						$randomFilename = random_string('md5');
						
						
						
						$updateArray = array(
											'users_id' => $ownerID,
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
															'description' => 'Change instruction of manuscript (By Admin : '.$sess_users['firstname'].' '.$sess_users['lastname'].')',
															'users_id'=>$sess_users['users_id']
															)
														 );
						// Edit Paper
						if($ownerID != $paper['users_id']){
							
							// Create Paper Code
							$prefixQuery = $this->db->get_where('paper_prefix' , array('users_id'=>$ownerID));
							if($prefixQuery->num_rows() == 0){
								$seq = 1;
								$this->db->set('users_id' , $ownerID);
								$this->db->set('prefix_seq' , $seq );
								$this->db->insert('paper_prefix');			
							}
							else{
								$prefixObj = $prefixQuery->row_array();
								$seq = $prefixObj['prefix_seq'] + 1;
								$this->db->set('prefix_seq' , $seq );
								$this->db->where('users_id' , $ownerID);
								$this->db->update('paper_prefix');	
							}

							$paper_code = PAPER_PREFIX.$ownerID.'-'.str_pad($seq ,4,0,STR_PAD_LEFT);
							$updateArray['paper_code'] = $paper_code;
						}
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
						$callback[1] = site_url('editorSubmission/editPaper/1/'.$id);		
						echo json_encode($callback);					
										
					}
					
					else{
						$callback[0] = false;
						$callback[1] = "Corresponding-Author must be at least one row only.";
						echo json_encode($callback);
						exit();
					}
				}
				else{
					$callback[0] = false;
					$callback[1] = "Please choose at least one author.";
					echo json_encode($callback);
					exit();
				}
				
				
			}
		}
	}

	public function removePaper($id){
		
		$this->db->where('paper_id' , $id);
		$query = $this->db->get('paper');
		$data = $query->row_array();
		
		if(unlink(UPLOAD_PATH.$data['file_pdf']) && unlink(UPLOAD_PATH.$data['file_word']) && unlink(UPLOAD_PATH.$data['file_signature'])){
			$this->db->trans_start();
			$this->db->where('paper_id' ,$id);
			$this->db->delete('paper');
			$this->db->trans_complete();
			
			$callback[0] = true;
			$callback[1] = site_url('editorSubmission');
 			
		}
		else{
			$callback[0] = false;
			$callback[1] = "Couldn't remove file, Please try again";
		}
		echo json_encode($callback);
	}
	
	public function forceDownload($paper_id , $field  ,$prefix = ''){
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
	
	
	public function reviewers($paperID){
		
		
		$pass['breadcrumbs'] = array(
			'Home' => site_url('editorSubmission'),
			'Submission' => site_url('editorSubmission'),
			'Reviewers' => site_url('editorSubmission/reviewers/'.$paperID)
		);
		
		$paper = $this->db->get_where('paper' , array('paper_id' => $paperID));
		$pass['paper'] = $paper->row_array();

		$this->db->select('* , 
						   assign_info.firstname AS assign_info_firstname,
						   assign_info.middlename AS assign_info_middlename,
						   assign_info.lastname AS assign_info_lastname,
						   reviewer_info.firstname AS reviewer_info_firstname,
						   reviewer_info.middlename AS reviewer_info_middlename,
						   reviewer_info.lastname AS reviewer_info_lastname');
		$this->db->from('reviewer');
		$this->db->join('users_info AS reviewer_info' , 'reviewer.reviewer_by = reviewer_info.users_id');
		$this->db->join('users_info AS assign_info' , 'reviewer.assign_by = assign_info.users_id');
		$this->db->where('reviewer.paper_id', $paperID);
		$reviewers = $this->db->get();
		
		$pass['reviewers'] = $reviewers->result_array();
		
		$data = array(
						'page_content' => $this->load->view('editor/submission/reviewers', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
	}
	
	
	public function getReviewer(){
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
						WHERE `online_users`.`users_role` IN (2,4,5)			
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
	
	public function saveReviewer($paperID){
		
		$data = $this->utils_model->formPost($this->input->post());
		
		if($this->input->post('reviewer') != "" && $this->input->post('due_date') != ""){
			
			$query = $this->db->get_where('reviewer' , array(
															'paper_id' => $paperID,
															'reviewer_by' => $data['reviewer']
														));
														
			if($query->num_rows() == 0){
			
				
				$sess_users = $this->session->userdata('admin_logged_in');
				$this->db->trans_start();
				$getReviewer = $this->db->get_where('reviewer' , array(
															'paper_id' => $paperID
														));
				if($getReviewer->num_rows() == 0){
					$this->db->set('timestamp' , 'NOW()' , false);
					$this->db->set('paper_id' , $paperID);
					$this->db->set('status_type' , 2 );
					$this->db->insert('paper_status');
				}
				
				$explode_date = explode('/',$data['due_date']);
				$insertArray = array(
									'paper_id' => $paperID ,
									'reviewer_by' => $data['reviewer'],
									'review_status' => 1,
									'assign_by' => $sess_users['users_id'],
									'due_time' => $explode_date[2]."-".$explode_date[1]."-".$explode_date[0]
								);
				$this->db->set('assign_time' , 'NOW()' , false);
				$this->db->insert('reviewer' , $insertArray);
				
				
				
				$this->db->trans_complete();
				
					$getReviewer = $this->db->get_where('users_info' , array('users_id' => $data['reviewer']));
					$reviewerInfo = $getReviewer->row_array();
					
					$getPaper = $this->db->get_where('paper' , array('paper_id' => $paperID));
					$paperInfo = $getPaper->row_array();
					$passReviewer['due_date'] = $data['due_date'];
					$passReviewer['reviewer'] = $reviewerInfo;
					$passReviewer['paper'] = $paperInfo;
					
					$sendEmail = $this->utils_model->sendEmail(
																EMAIL_SENDER ,
																EMAIL_SENDER_NAME ,
																$reviewerInfo['email'] ,
																'[SEANES2018] Invitation letter for reviewing the manuscript entitled: '.$paperInfo['title'] ,
																$this->load->view('templates/email/adminInviteReviewer', $passReviewer , true)
															 );
					$callback[0] = true;
					$callback[1] = site_url('editorSubmission/reviewers/'.$paperID);		
					echo json_encode($callback);					
						
				
			}
			else{
				$callback[0] = false;
				$callback[1] = "This scientific committee already add for this article, please try another account";
				echo json_encode($callback);
				
			}
			
		}
		else{
			
				$callback[0] = false;
				$callback[1] = "Please enter reviewer and due date.";
				echo json_encode($callback);
		}
		
	}
	
	public function removeReviewer($id){
			$query = $this->db->get_where('reviewer' , array('reviewer_id'=>$id));
			$current = $query->row_array();
			$this->db->trans_start();
			$this->db->where('reviewer_id' , $id);
			$this->db->delete('reviewer');
			
			
			$getReviewer = $this->db->get_where('reviewer' , array(
														'paper_id' => $current['paper_id']
													));
			if($getReviewer->num_rows() == 0){
				$this->db->where('paper_id' ,$current['paper_id']);
				$this->db->where('status_type' , 2 );
				$this->db->delete('paper_status');
			}
			
			$this->db->trans_complete();
			
			$callback[0] = true;
			$callback[1] = site_url('editorSubmission/reviewers/'.$current['paper_id']);
			echo json_encode($callback);
		
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
	
	
	
	
	public function evaluationAction ($id){
		
		$data = $this->utils_model->formPost($this->input->post());
	
		if($data['type'] == 1){ // Update Note
			
			$this->db->trans_start();
			$this->db->where('review_id' , $id);
			$this->db->update('reviewer_evaluation' , array('editor_comment' => $data['editor_comment']) );
			
			$this->db->trans_complete();
			
			$callback[0] = true;
			$callback[1] = site_url('editorSubmission/evaluation/'.$id);
			
			
		}
		
		elseif($data['type'] == 2){
			
			
		}
		else{
			
			
		}
		
		echo json_encode($callback);
		
	}
	
	
		
	public function correction($paperID){
		
		$pass['breadcrumbs'] = array(
			'Home' => site_url('editorSubmission'),
			'Submission' => site_url('editorSubmission'),
			'Correction' => site_url('editorSubmission/correction/'.$paperID)
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
		
		if($pass['paperStatus']['status_type'] < 3){

			$this->db->select('* , 
							   reviewer_info.firstname AS reviewer_info_firstname,
							   reviewer_info.middlename AS reviewer_info_middlename,
							   reviewer_info.lastname AS reviewer_info_lastname');
			$this->db->from('reviewer');
			$this->db->join('reviewer_evaluation' , 'reviewer.reviewer_id = reviewer_evaluation.review_id');
			$this->db->join('users_info AS reviewer_info' , 'reviewer.reviewer_by = reviewer_info.users_id');
			$this->db->where('reviewer.paper_id', $paperID);
			$this->db->where('reviewer.review_status', 4);
			$reviewers = $this->db->get();
			
			
			$pass['reviewers'] = $reviewers->result_array();
			$pass['evaluation_conference'] = unserialize(EVALUATION_CONFERENCE);
			$pass['evaluation_journal'] = unserialize(EVALUATION_JOURNAL);
			
			
		}
		
		else{
			
			$this->db->select('* , 
							   reviewer_info.firstname AS reviewer_info_firstname,
							   reviewer_info.middlename AS reviewer_info_middlename,
							   reviewer_info.lastname AS reviewer_info_lastname');
			$this->db->from('reviewer');
			$this->db->join('reviewer_evaluation' , 'reviewer.reviewer_id = reviewer_evaluation.review_id');
			$this->db->join('users_info AS reviewer_info' , 'reviewer.reviewer_by = reviewer_info.users_id');
			$this->db->where('reviewer.paper_id', $paperID);
			$this->db->where('reviewer.correction_status > ', 0);
			$reviewers = $this->db->get();
			
			$pass['reviewers'] = $reviewers->result_array();
			
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
		
			
			
		}
		$data = array(
						'page_content' => $this->load->view('editor/submission/correction', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
		
		
	}
	
	public function sendCorrection(){
		
		$data = $this->utils_model->formPost($this->input->post());
		
		
		// Get Paper Info
		$this->db->where('paper_id' , $data['paper_id']);
		$paperQuery = $this->db->get('paper');
		$paperInfo = $paperQuery->row_array();
		
		// Get Corresponding-Author
		$authors_where = array(
									'paper_id' => $data['paper_id'],
									'is_corresponding' => 1
								);
		$this->db->select('*');
		$this->db->from('paper_authors');
		$this->db->where($authors_where);
		$this->db->order_by('authors_id' ,'ASC');
		$this->db->limit(1);
		$authorsQuery = $this->db->get();
		$authors = $authorsQuery->row_array();
		
		
		$this->db->trans_start();
		
		$explode_date = explode('/',$data['revise_due_date']);
		
		$this->db->where('paper_id' , $data['paper_id']);
		$this->db->update('paper', array('revise_due_date' => $explode_date[2]."-".$explode_date[1]."-".$explode_date[0]));
				
		//Change Paper Status
		$paperArray = array(
							'timestamp' => date('Y-m-d H:i:s'),
							'paper_id' => $data['paper_id'],
							'status_type' => 3
							);
		$this->db->insert('paper_status' , $paperArray);
		
		
		//Change Reviewer Status
		foreach($data['correction'] as $key=>$row){
			if($row == 1){
				$this->db->where('reviewer_id' , $key);
				$this->db->update('reviewer', array('correction_status' => 1));
			}
			
		}
		
		$this->db->trans_complete();
		
		$pass['users'] = $authors;
		$pass['paper'] = $paperInfo;
		$pass['revise_due_date'] = $data['revise_due_date'];
		
		//Send Email
		
					$sendEmail = $this->utils_model->sendEmail(
																EMAIL_SENDER ,
																EMAIL_SENDER_NAME ,
																$authors['email'] ,
																'[SEANES2018] Reviewing Results for the Manuscript No# ['.$paperInfo['paper_code'].'] '.$paperInfo['title'] ,
																$this->load->view('templates/email/adminSendCorrection', $pass , true)
															 );
			
		$callback[0] = true;
		$callback[1] = site_url('editorSubmission/correction/'.$data['paper_id']);
		echo json_encode($callback);
	}
	
	
	public function cancelCorrection($paperID){
		
		
		$query = $this->db->get_where('paper' , array('paper_id' => $paperID));
		$paper = $query->row_array();
		
		
		$paper = $query->row_array();
		
		$this->db->trans_start();
		
		
		if($paper['revise_file_pdf'] != ""){
				unlink(UPLOAD_PATH.$paper['revise_file_pdf']);
				
			}
		
		
		if($paper['revise_file_word'] != ""){
				unlink(UPLOAD_PATH.$paper['revise_file_word']);
				
			}
		
		$updatePaper = array(
							'revise_due_date' => '',
							'revise_title' => '',
							'revise_file_pdf' => '',
							'revise_file_word' => '',
							'revise_submit_date' => ''
		
						);
		$this->db->where('paper_id' , $paperID);
		$this->db->update('paper', $updatePaper );
		
		
		$this->db->delete('paper_status' , array(
													'paper_id' => $paperID,
																		'status_type' => 3
																	));
																	
		$this->db->where('paper_id' , $paperID);
		$this->db->update('reviewer' , array('correction_status'=> 0) );	
		
		$this->db->trans_complete();
		
		$callback[0] = true;
		$callback[1] = site_url('editorSubmission/correction/'.$paperID);
		echo json_encode($callback);
	}
	
	
	public function saveRevise(){
		
		$data = $this->utils_model->formPost($this->input->post());

		$query = $this->db->get_where('paper' , array('paper_id' , $data['paper_id']));
		$paper = $query->row_array();
		
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
			$uploadPDF = $this->utils_model->adminUploadDocument('file_pdf' , 'REVISE_PDF_'.$randomFilename );
				$updateArray['revise_file_pdf'] = $uploadPDF['filedata'];
							
		}
		
		if($_FILES['file_word']['name'] != ""){
			
			if($paper['revise_file_word'] != ""){
				unlink(UPLOAD_PATH.$paper['revise_file_word']);
				
			}
			$uploadWord = $this->utils_model->adminUploadDocument('file_word' , 'REVISE_WORD_'.$randomFilename );
				$updateArray['revise_file_word'] = $uploadWord['filedata'];
		}
		
		$this->db->where('paper_id' , $data['paper_id']);
		$this->db->update('paper' , $updateArray );
		
		
		// Update Reviewer Status
		$this->db->where('paper_id' , $data['paper_id']);
		$this->db->update('reviewer' , array('correction_status'=> 2) );	
		
		
		$this->db->trans_complete();
		
		$callback[0] = true;
		$callback[1] = site_url('editorSubmission/correction/'.$data['paper_id']);
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
		$callback[1] = site_url('editorSubmission/correction/'.$paperID);
		echo json_encode($callback);
						
		
	}
	
	public function sendInpress(){
		
		$data = $this->utils_model->formPost($this->input->post());
		
		$query = $this->db->get_where('paper' , array('paper_id' => $data['paper_id']));
		$paper = $query->row_array();
		
		$coAuthorQuery = $this->db->get_where('paper_authors' , array('paper_id' => $data['paper_id']));
		$coAuthor = $coAuthorQuery->result_array();
		
		$filepath = date('Y').'/'.$paper['users_id'];
		
		$this->load->helper('string');
		$randomFilename = 'INPRESS_'.random_string('md5');
		
		copy(FCPATH.'/uploads/'.$paper['revise_file_pdf'] , FCPATH.'/uploads/'.$filepath.'/'.$randomFilename.$this->utils_model->get_file_extension($paper['revise_file_pdf']));
		copy(FCPATH.'/uploads/'.$paper['revise_file_word'] , FCPATH.'/uploads/'.$filepath.'/'.$randomFilename.$this->utils_model->get_file_extension($paper['revise_file_word']));
		
		$paperArray = array(
							'editor_revise_note' => $data['editor_revise_note'],
							'inpress_title' => $data['title'],
							'inpress_file_pdf' => $filepath.'/'.$randomFilename.$this->utils_model->get_file_extension($paper['revise_file_pdf']),
							'inpress_file_word' => $filepath.'/'.$randomFilename.$this->utils_model->get_file_extension($paper['revise_file_word']),
							'inpress_submit_date' => date('Y-m-d H:i:s')
						);
		$this->db->where('paper_id' , $data['paper_id']);
		$this->db->update('paper' ,$paperArray );
		
		//Change Paper Status
		$paperArray = array(
							'timestamp' => date('Y-m-d H:i:s'),
							'paper_id' => $data['paper_id'],
							'status_type' => 4
							);
		$this->db->insert('paper_status' , $paperArray);
		
		$pass['paper'] = $paper;
		
		
		//Send Email
		foreach($coAuthor as $key=>$row){
			$pass['users'] = $row;
			if($row['email'] != ""){
					$sendEmail = $this->utils_model->sendEmail(
																EMAIL_SENDER ,
																EMAIL_SENDER_NAME ,
																$row['email'] ,
																'[SEANES 2018] The Acceptance Letter for the paper entitle "'.$paper['title'].'" and registration information.',
																$this->load->view('templates/email/adminSendInpress', $pass , true),
																FCPATH.'/document/RegistrationUserManualForAuthor.pdf'
															 );
			}
		}
			
		$callback[0] = true;
		$callback[1] = site_url('editorSubmission/correction/'.$data['paper_id']);
		echo json_encode($callback);
		
	}
	
	public function cancelInpress($paperID){
		
		$query = $this->db->get_where('paper' , array('paper_id' , $paperID));
		$paper = $query->row_array();
		
		
		if($paper['inpress_file_pdf'] != "" && file_exists(FCPATH.'/uploads/'.$paper['inpress_file_pdf'])){
				unlink(FCPATH.'/uploads/'.$paper['inpress_file_pdf']);
				
		}
		
		
		if($paper['inpress_file_word'] != "" &&  file_exists(FCPATH.'/uploads/'.$paper['inpress_file_word'])){
				unlink(FCPATH.'/uploads/'.$paper['inpress_file_word']);
				
		}
		
		
		$paperArray = array(
							'editor_revise_note' => '',
							'inpress_title' => '',
							'inpress_file_pdf' => '',
							'inpress_file_word' =>'',
							'inpress_submit_date' =>'0000-00-00 00:00:00'
						);
		$this->db->where('paper_id' , $paperID);
		$this->db->update('paper' ,$paperArray );
		
		$this->db->where('paper_id' , $paperID);
		$this->db->where('status_type > ' , 3);
		$this->db->delete('paper_status');
		
		
		
	
		$callback[0] = true;
		$callback[1] = site_url('editorSubmission/correction/'.$paperID);
		echo json_encode($callback);
		
	}
	
	
	public function inpress($paperID){
		
		$query = $this->db->get_where('paper' , array('paper_id' , $paperID));
		$paper = $query->row_array();
		
		
		$pass['breadcrumbs'] = array(
			'Home' => site_url('editorSubmission'),
			'Submission' => site_url('editorSubmission'),
			'In Press' => site_url('editorSubmission/inpress/'.$paperID)
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
						'page_content' => $this->load->view('editor/submission/inpress', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
		
		
	}
	
	
	public function saveInpress(){
		
		$data = $this->utils_model->formPost($this->input->post());

		$query = $this->db->get_where('paper' , array('paper_id' , $data['paper_id']));
		$paper = $query->row_array();
		
		
		$this->db->select('status_type');
		$this->db->from('paper_status');
		$this->db->where('paper_id' ,$data['paper_id']);
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
		$callback[1] = site_url('editorSubmission/inpress/'.$data['paper_id']);
		echo json_encode($callback);
						
	
		
	}
	
	
	public function sendSecondRevise(){
		
		$data = $this->utils_model->formPost($this->input->post());
		
		$query = $this->db->get_where('paper' , array('paper_id' => $data['paper_id']));
		$paper = $query->row_array();
		
		$coAuthorQuery = $this->db->get_where('paper_authors' , array('paper_id' => $data['paper_id']));
		$coAuthor = $coAuthorQuery->result_array();
		
		$paperArray = array(
							'editor_revise_note' => $data['editor_revise_note']
						);
		$this->db->where('paper_id' , $data['paper_id']);
		$this->db->update('paper' ,$paperArray );
		
		//Change Paper Status
		$paperArray = array(
							'timestamp' => date('Y-m-d H:i:s'),
							'paper_id' => $data['paper_id'],
							'status_type' => 5
							);
		$this->db->insert('paper_status' , $paperArray);
		
		$pass['paper'] = $paper;
		
		//Send Email
		foreach($coAuthor as $key=>$row){
			$pass['users'] = $row;
			if($row['email'] != ""){
					$sendEmail = $this->utils_model->sendEmail(
																EMAIL_SENDER ,
																EMAIL_SENDER_NAME ,
																$row['email'] ,
																'[SEANES 2018] The Acceptance Letter for the paper entitle "'.$paper['title'].'" and registration information.',
																$this->load->view('templates/email/adminSendInpress', $pass , true),
																FCPATH.'/document/RegistrationUserManualForAuthor.pdf'
															 );
			}
		}
			
		$callback[0] = true;
		$callback[1] = site_url('editorSubmission/correction/'.$data['paper_id']);
		echo json_encode($callback);
		
	}
	
	
}