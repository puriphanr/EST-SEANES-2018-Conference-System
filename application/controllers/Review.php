<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {
	
	 public function __construct(){
        parent::__construct();
        $this->utils_model->is_logged_in();
     }
	
	public function index($type = 1){
		$sess_users = $this->session->userdata('is_logged_in');	
		
		$pass['breadcrumbs'] = array(
									'Home' => site_url('submission'),
									'Review' => site_url('review')
									);
		

		$count1 = $this->db->get_where('reviewer' , array(
																	'reviewer_by' => $sess_users['users_id'],
																	'review_status < ' => 3
																)
												);
		$count2 = $this->db->get_where('reviewer' , array(
																	'reviewer_by' => $sess_users['users_id'],
																	'review_status >= ' => 3
																)
												);
		
		$pass['count1'] = $count1->num_rows();	
		$pass['count2'] = $count2->num_rows();	
			
		if($type == 1){	
			$this->db->select('*');
			$this->db->from('reviewer');
			$this->db->join('paper' , 'reviewer.paper_id = paper.paper_id');
			if($this->input->post('search') != ""){
				$this->db->like('paper.title',$this->input->post('search'));
			}
			$this->db->where('reviewer.reviewer_by', $sess_users['users_id']);
			$this->db->where('reviewer.review_status < ', 3 );
			$this->db->order_by('reviewer.assign_time','desc');
			$paper = $this->db->get();

		}
		else{
			
			$this->db->select('*');
			$this->db->from('reviewer');
			$this->db->join('paper' , 'reviewer.paper_id = paper.paper_id');
			if($this->input->post('search') != ""){
				$this->db->like('paper.title',$this->input->post('search'));
			}
			$this->db->where('reviewer.reviewer_by', $sess_users['users_id']);
			$this->db->where('reviewer.review_status >= ', 3 );
			$this->db->order_by('reviewer.assign_time','desc');
			$paper = $this->db->get();
			
		}
		
		$pass['data'] = $paper->result_array();
		
		$data = array(
						'page_content' => $this->load->view('review/home', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
		
	}

	
	public function viewPaper($reviewer_id){
				$sess_users = $this->session->userdata('is_logged_in');	
				
				$reviewer = $this->db->get_where('reviewer' , array('reviewer_id' => $reviewer_id));
				$reviewer_result = $reviewer->row_array();
				$id = $reviewer_result['paper_id'];
				
				$pass['breadcrumbs'] = array(
					'Home' => site_url('submission'),
					'Review' => site_url('review'),
					'Ariticle' => site_url('review/viewPaper/'.$reviewer_id)
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
				

				if($sess_users['users_id'] == $reviewer_result['reviewer_by']){
				
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
									'page_content' => $this->load->view('review/viewPaper', $pass ,TRUE)
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
			'Home' => site_url('submission'),
			'Review' => site_url('review'),
			'Evaluation' => site_url('review/evaluation/'.$id)
		);
		
		
		$data = array(
						'page_content' => $this->load->view('review/evaluation', $pass ,TRUE)
					 );
		$this->parser->parse('templates/default', $data);
		
	}
	
	public function acceptReview($id , $status){
			$this->db->trans_start();
			$this->db->where('reviewer_id' , $id);
			$this->db->set('accept_time' , 'NOW()' , false);
			$this->db->update('reviewer' , array('review_status' => $status ));
			$this->db->trans_complete();
			
			$getReview = $this->db->get_where('reviewer' , array('reviewer_id' => $id));
			$reviewInfo = $getReview->row_array();
			
			$this->db->select('*');
			$this->db->from('users_info');
			$this->db->join('country' , 'users_info.country = country.country_id');
			$this->db->where('users_info.users_id' , $reviewInfo['reviewer_by']);
			$getReviewer = $this->db->get();
			$reviewerInfo = $getReviewer->row_array();
			
			$getPaper = $this->db->get_where('paper' , array('paper_id' => $reviewInfo['paper_id']));
			$paperInfo = $getPaper->row_array();
			
						
			$pass['reviewer'] = $reviewerInfo;
			$pass['paper'] = $paperInfo;
			$pass['status'] = $status;
			
			if($status == 2){
				$subjectStatus = 'Accept';
			}
			else{
				$subjectStatus = 'Reject';
			}
			
			// Send Mail to Admin
			$this->db->select('*');
			$this->db->from('users');
			$this->db->join('users_info' , 'users.users_id = users_info.users_id');
			$this->db->where('users.users_role' , 4);
			$adminQuery = $this->db->get();
			foreach($adminQuery->result_array() as $key=>$row){
				$pass['admin'] = $row;
				$sendEmail = $this->utils_model->sendEmail(
														EMAIL_SENDER ,
														EMAIL_SENDER_NAME ,
														$row['email'] ,
														'[SEANES2018] '.$subjectStatus.' to review the manuscript ['.$paperInfo['paper_code'].'] '.$paperInfo['title'] ,
														$this->load->view('templates/email/reviewerAcceptPaper', $pass , true)
													  );
			}

			$callback[0] = true;
			$callback[1] = site_url('review');

			echo json_encode($callback);
	}
	
	public function saveReview($id){
		$data = $this->utils_model->set($this->input->post());
		$query = $this->db->get_where('reviewer_evaluation' , array('review_id' => $id));
		$this->db->trans_start();
		if($query->num_rows() == 0){
			$this->db->set('review_id' , $id);
			$this->db->insert('reviewer_evaluation' , $data);
			
			$this->db->set('review_status' , 4);
			$this->db->where('reviewer_id' , $id);
			$this->db->update('reviewer');
		}
		else{
			$this->db->where('review_id' , $id);
			$this->db->update('reviewer_evaluation' , $data);
			
		}
		$this->db->trans_complete();
		
		$getReview = $this->db->get_where('reviewer' , array('reviewer_id' => $id));
		$reviewInfo = $getReview->row_array();
		
		$getReviewer = $this->db->get_where('users_info' , array('users_id' => $reviewInfo['reviewer_by']));
		$reviewerInfo = $getReviewer->row_array();
		

					
		$getPaper = $this->db->get_where('paper' , array('paper_id' => $reviewInfo['paper_id']));
		$paperInfo = $getPaper->row_array();
					
		$pass['reviewer'] = $reviewerInfo;
		$pass['paper'] = $paperInfo;
		
		// Send Mail to Admin
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('users_info' , 'users.users_id = users_info.users_id');
		$this->db->where('users.users_role' , 4);
		$adminQuery = $this->db->get();
		foreach($adminQuery->result_array() as $key=>$row){
			$pass['admin'] = $row;
			$sendEmail = $this->utils_model->sendEmail(
													EMAIL_SENDER ,
													EMAIL_SENDER_NAME ,
													$row['email'] ,
													'[SEANES2018] New Reviewing Result of the manuscript entitled: '.$paperInfo['title'] ,
													$this->load->view('templates/email/reviewerEvaluated', $pass , true)
												  );
		}
		
					
		
			
		$callback[0] = true;
		$callback[1] = site_url('review/evaluation/'.$id);

		echo json_encode($callback);
	}
	
}