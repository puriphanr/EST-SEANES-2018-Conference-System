<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editor extends CI_Controller {
	
	 public function __construct(){
        parent::__construct();
        $this->utils_model->admin_logged_in();
     }
	
	public function index(){
		$pass['breadcrumbs'] = array(
								'Home' => site_url('submission'),
								'Submission' => site_url('submission')
								);
		$sess_users = $this->session->userdata('admin_logged_in');	
		
		if($this->input->post('search') != ""){
			$this->db->like('title',$this->input->post('search'));
		}
		
		$this->db->order_by('timestamp','desc');
		$paper = $this->db->get('paper');
		
		$dataPaper = array();
		foreach($paper->result_array() as $key=>$row){
			$this->db->select('status_type , max(timestamp)' , false);
			$this->db->where('paper_id' ,$row['paper_id']);
			$status = $this->db->get('paper_status');
			$dataStatus =  $status->row_array();
			$dataPaper[$key] = $row;
			$dataPaper[$key]['status'] = $dataStatus['status_type'];
		}
		$pass['data'] = $dataPaper;
		$data = array(
						'page_content' => $this->load->view('editor/submission/home', $pass ,TRUE)
					 );
		$this->parser->parse('templates/defaultAdmin', $data);
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
							$currentPaper = $this->db->get_where('paper' ,array('users_id'=>$sess_users['users_id']));
							$countPaper = $currentPaper->num_rows();
							
							$paper_code = PAPER_PREFIX.$sess_users['users_id'].'-'.str_pad($countPaper+1,3,0,STR_PAD_LEFT);
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
							// Insert Author
							foreach($data['firstname'] as $key=>$row){
								$this->db->insert('paper_authors' , array(
																	'paper_id' => $insert_id ,
																	'firstname' => $row,
																	'middlename' => $data['middlename'][$key],
																	'lastname' => $data['lastname'][$key],
																	'contact_address' => $data['contact_address'][$key],
																	'email' => $data['email'][$key],
																	'is_corresponding' => $data['is_corresponding'][$key]
																)
											 );
							}

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
							$this->db->trans_complete();
							if ($this->db->trans_status() === FALSE){
								unlink('./uploads/paper/pdf/'.$uploadPDF['filedata']['file_name']);
								unlink('./uploads/paper/word/'.$uploadWord['filedata']['file_name']);
								unlink('./uploads/paper/signature/'.$uploadSign['filedata']['file_name']);
								$callback[0] = false;
								$callback[1] = "Couldn't save your information, Please try again";
							}
							else{
								
								$passData['data'] = $sess_users;
								$passData['url'] = site_url('submission/editPaper/1/'.$insert_id);
								$passData['title'] = $data['title'];
								$sendEmail = $this->utils_model->sendEmail(
																			EMAIL_SENDER ,
																			EMAIL_SENDER_NAME ,
																			$sess_users['email'] ,
																			'[SEANES2018] Received Your Manuscript' ,
																			$this->load->view('templates/email/receivedPaper', $passData , true)
																		  );
								
			
								if($sendEmail){
									$callback[0] = true;
									$callback[1] = site_url('submission');
								}
								else{
									
									$callback[0] = false;
									$callback[1] = "Couldn't send email, Please try again";
								}
							}
						}
					}
				}

			
				 echo json_encode($callback);
			}
		}
		else{
			if($step == 1){
				
				$pass['breadcrumbs'] = array(
								'Home' => site_url('submission'),
								'Submission' => site_url('submission'),
								'Edit Item' => site_url('submission/editPaper/1/'.$id)
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
								'page_content' => $this->load->view('submission/editPaper', $pass ,TRUE)
							 );
				$this->parser->parse('templates/default', $data);
			}
			else{
				$sess_users = $this->session->userdata('is_logged_in');
				$data = $this->utils_model->formPost($this->input->post());
				
				$this->load->helper('string');
				$randomFilename = random_string('md5');
				
				$this->db->where('paper_id' , $id);
				$query = $this->db->get('paper');
				$paper = $query->row_array();
				
				$updateArray = array(
									'title' => $data['title'],
									 'note' => $data['note']
									 );
				
				if($_FILES['file_pdf']['name'] != ""){
					if(unlink(UPLOAD_PATH.$paper['file_pdf'])){
						$uploadPDF = $this->utils_model->uploadDocument('file_pdf' , 'PDF_'.$randomFilename );
						if($uploadPDF['status']){
							$updateArray['file_pdf'] = $uploadPDF['filedata'];
						}
						else{
							$callback[0] = false;
							$callback[1] = 'PDF File : '.$uploadPDF['error'];
							echo json_encode($callback);
							exit();
						}
					}
					else{
						$callback[0] = false;
						$callback[1] = "PDF File : Couldn't remove old file, Please try again";
						echo json_encode($callback);
						exit();
					}
					
				}
				
				if($_FILES['file_word']['name'] != ""){
					
					if(unlink(UPLOAD_PATH.$paper['file_word'])){
						$uploadWord = $this->utils_model->uploadDocument('file_word' , 'WORD_'.$randomFilename );
						if($uploadPDF['status']){
							$updateArray['file_word'] = $uploadWord['filedata'];
						}
						else{
							$callback[0] = false;
							$callback[1] = 'Word File : '.$uploadWord['error'];
							echo json_encode($callback);
							exit();
						}
					}
					else{
						$callback[0] = false;
						$callback[1] = "Word File : Couldn't remove old file, Please try again";
						echo json_encode($callback);
						exit();
					}
				}
				
				if($_FILES['file_signature']['name'] != ""){
					if(unlink(UPLOAD_PATH.$paper['file_signature'])){
						$uploadSign = $this->utils_model->uploadDocument('file_signature' , 'SIGN_'.$randomFilename );
						if($uploadSign['status']){
							$updateArray['file_signature'] = $uploadSign['filedata'];
						}
						else{
							$callback[0] = false;
							$callback[1] = 'Signature File : '.$uploadSign['error'];
							echo json_encode($callback);
							exit();
						}
					}
					else{
						$callback[0] = false;
						$callback[1] = "Couldn't remove old file, Please try again";
						echo json_encode($callback);
						exit();
					}
					
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
							
				foreach($data['firstname'] as $key=>$row){
					$this->db->insert('paper_authors' , array(
																	'paper_id' => $id,
																	'firstname' => $row,
																	'middlename' => $data['middlename'][$key],
																	'lastname' => $data['lastname'][$key],
																	'contact_address' => $data['contact_address'][$key],
																	'email' => $data['email'][$key],
																	'is_corresponding' => $data['is_corresponding'][$key]
																)
											 );
				}
				$this->db->trans_complete();		
				if ($this->db->trans_status() === FALSE){
					$callback[0] = false;
					$callback[1] = "Couldn't save your information, Please try again";
					echo json_encode($callback);
					exit();
				}
				else{
					$callback[0] = true;
					$callback[1] = site_url('submission/editPaper/1/'.$id);		
					echo json_encode($callback);					
				}				
				
				
				
			}
		}
	}

	public function removePaper($id){
		
		$this->db->where('paper_id' , $id);
		$query = $this->db->get('paper');
		$data = $query->row_array();
		
		if(unlink('./uploads/paper/'.$data['filename'])){
			$this->db->trans_start();
			$this->db->where('paper_id' ,$id);
			$this->db->delete('paper');
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				$callback[0] = false;
				$callback[1] = "Couldn't remove your information, Please try again";
			}
			else{
				$callback[0] = true;
				$callback[1] = site_url('submission');
 			}
		}
		else{
			$callback[0] = false;
			$callback[1] = "Couldn't remove file, Please try again";
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
	
	public function forceDownload($paper_id , $field){
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
		$filename = $implode_corres_name.'_'.$paper['paper_code'];
		if($field == 'file_signature'){
			$filename .= '-sign';
		}
		
		$this->utils_model->forceDownload( $filename.$extension , UPLOAD_PATH.$paper[$field]);
	}
}