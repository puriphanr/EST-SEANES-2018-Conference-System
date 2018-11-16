 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-8">
							
                            <h1 class="title-4 place-inline">
								Paper Submission / Correction
                            </h1>
							 
							
                           
                        </div> 
						<div class="col-md-4 text-right">
							<button onclick="window.location='<?php echo site_url('editorSubmission')?>'" class="au-btn au-btn-icon au-btn--blue au-btn--small">
                                <i class="zmdi zmdi-arrow-left"></i>back
							</button>
						</div>
					
						<hr class="line-seprate">
							
                    </div>
                </div>
            </section>
			
			
			<section class="p-t-20">
                <div class="container">
                    <div class="row">
						<div class="col-md-12">
								<div class="card">
								 <div class="card-header"><strong> Article Information</strong></div>
                                    <div class="card-body">
										<table class="table table-top-campaign">
                                            <tbody>
                                                <tr>
                                                    <td width="10%">Article ID</td>
                                                    <td width="90%" class="text-left"><?php echo $paper['paper_code']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Article Title</td>
                                                    <td class="text-left"><?php echo $paper['title']?></td>
                                                </tr>
                                          
													<tr>
                                                    <td>Status</td>
                                                    <td class="text-left">
													 <?php 
													
											  if($paperStatus['status_type'] == 1){
												  echo '<span class="badge badge-secondary">Waiting</span>';
											  }
											  elseif($paperStatus['status_type'] == 2){
												   echo '<span class="badge badge-warning">In Review</span>';
											  }
											  elseif($paperStatus['status_type'] == 3){
												   echo '<span class="badge badge-danger">In Correction</span>';
											  }
											  elseif($paperStatus['status_type'] == 4){
												   echo '<span class="badge badge-success">In Press</span>';
											  }
											  else{
												   echo '<span class="badge badge-danger">2<sup>nd</sup> Revise</span>';
											  }
												
											  ?>
													</td>
                                                </tr>
                                            </tbody>
                                        </table>
									</div>
								</div>
							</div>
						</div>
					</div>
			
		</section>
		
		<?php if($paperStatus['status_type'] == 2){ ?>
		
		<section class="p-t-20">
                <div class="container">
                    <div class="row">
						<div class="col-md-12">
							<div class="card">
							<div class="card-header">
								<div class="row">
									<div class="col-md-12">
										<strong>Send for Correction</strong>
									</div>
									
								</div>
							</div>
                            <div class="card-body">
									
							<?php if(!empty($reviewers) ){ ?>
							<form id="eva-form" action="<?php echo site_url('editorSubmission/sendCorrection')?>" method="post" >
								<input type="hidden" value="<?php echo $this->uri->segment(3)?>" name="paper_id" />			
								<h4 class="p-b-20">Completed Evaluation List</h4>
								<div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-data2">
                                    <thead>
                                        <tr>
											<th width="2%"></th>
											<th width="33%">Reviewer Name</th>
											<th width="10%">Total Score</th>
											<th width="20%" style="font-size:10px">Conference Proceedings Publication</th>
											<th width="20%" style="font-size:12px">Journal Publication</th>
                                            <th width="10%">Incorection Status</th>
                                           
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
										foreach($reviewers as $key=>$row) {

										?>
                                        <tr class="tr-shadow">
											<th width="2%" class="text-center">
													<label class="au-checkbox">
                                                        <input type="checkbox" class="send-correction" type="checkbox" value="1" name="correction[<?php echo $row['reviewer_id']?>]" <?php echo  $row['review_status'] < 4 ? 'disabled' : NULL   ?>>
                                                        <span class="au-checkmark <?php echo  $row['review_status'] < 4 ? 'cannot-send' : NULL   ?>"></span>
                                                    </label>
											</th>
											<td><?php echo $row['reviewer_info_firstname']?> <?php echo $row['reviewer_info_lastname']?></td>
											<td class="text-center">
												<?php 
												$total = 0;
												for($i=1;$i<=12;$i++){ 
													$total += $row['q'.$i];
												}
												echo $total;
												?>
											</td>
											<td><?php echo $evaluation_conference[$row['conference_public']]?></td>
											<td><?php echo $evaluation_journal[$row['journal_public']]?></td>
                                            <td>
												<div class="h6">
                                              <?php 
											  if($row['correction_status'] == 0){
												  echo '<span class="badge badge-secondary">Waiting for Send</span>';
											  }
											  elseif($row['correction_status'] == 1){
												   echo '<span class="badge badge-secondary">Waiting for Correction</span>';
											  }
											  elseif($row['correction_status'] == 2){
												   echo '<span class="badge badge-warning">Waiting for Review</span>';
											  }
												else{
													 echo '<span class="badge badge-success">Completed</span>';	
											  }
											  
											 
											  ?></div>
                                            </td>
                                 
                                       
                                            <td>
                                                <div class="table-data-feature">
													 <a title="View" type="button" target="_blank" href="<?php echo site_url('editorSubmission/evaluation/'.$row['reviewer_id'])?>" class="btn btn-primary btn-xs">
                                                      View
                                                    </a>
													&nbsp;
                                                   
                                                </div>
                                            </td>
                                        </tr>
                                      
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
								<div class="row">
											
												
												<label class="required control-label mb-1 col-md-2">Revise Due Date</label>
												
												<div class="col-md-4">
													<input type="text" name="revise_due_date" id="revise_due_date" class="form-control datepicker"/>
												</div>
												
												<div class="col-md-4">
													
													<button type="button" id="send-correction-btn" class="btn btn-warning">
														<i class="fa fa-check"></i> Send for correction
													</button>
												
												</div>
												
											</div>
							</form>
		
							<?php } else { ?>
							<div class="alert alert-dark m-t-30" role="alert">
									You don't have any completed evaluation list for this article
							</div>
							
							<?php } ?>
							
										
									</div>
								</div>
							</div>
						</div>
					</div>
				
		</section>
		
		<?php } else { ?>
	
			
		<section class="p-t-20">
                <div class="container">
                    <div class="row">
						<div class="col-md-12">
							<div class="card">
							<div class="card-header">
								<div class="row">
									<div class="col-md-8">
										<strong>Revised Submission</strong>
									</div>
									<?php if($paperStatus['status_type'] < 4){ ?>
									<div class="col-md-4 text-right">
										<button type="button" id="cancel-correction" class="btn btn-danger btn-sm" data-url="<?php echo site_url('editorSubmission/cancelCorrection/'.$paper['paper_id'])?>"><i class="fa fa-times"></i> Cancel Correction</button>
									</div>
									
									<?php } ?>
								</div>
							</div>
                            <div class="card-body">
								<div class="p-b-30">
									<?php if(!empty($reviewers) ){ ?>
									<h4 class="p-b-20">Reviewer List</h4>
									
									<div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-data2">
                                    <thead>
                                        <tr>
											<th width="90%">Reviewer Name</th>
                                            
                                            <th width="10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
										foreach($reviewers as $key=>$row) {

										?>
                                        <tr class="tr-shadow">
											
											<td><?php echo $row['reviewer_info_firstname']?> <?php echo $row['reviewer_info_lastname']?></td>

                                            <td>
                                                <div class="table-data-feature">
													 <button title="View" type="button" onclick="window.location='<?php echo site_url('editorSubmission/evaluation/'.$row['reviewer_id'])?>'" class="btn btn-primary btn-xs">
                                                      View
                                                    </button>
													&nbsp;
                                                   
                                                </div>
                                            </td>
                                        </tr>
                                      
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
									
									
									
									<?php } ?>
								</div>
								
								
								<div class="p-b-30">
									<h4 class="p-b-20">Revised Paper</h4>
									<form action="" method="post" id="reviseForm" enctype="multipart/form-data">
											<input type="hidden" value="<?php echo $this->uri->segment(3)?>" name="paper_id" />		
											<div class="form-group">
                                                <label class="required bold" for="cc-payment" class="control-label mb-1">Article Title</label>
                                                <input <?php echo $paper['revise_file_pdf'] != "" ? 'readonly' : NULL ?> id="title" name="title" class="form-control" value="<?php echo $paper['revise_title'] != "" ? $paper['revise_title'] : NULL ?>" type="text">
                                            </div>
											
											<div class="form-group row">
												<div class="col-md-12">
													<label class="bold" for="cc-payment" class="control-label mb-1">Upload Manuscript/Article Files</label>
												</div>
											
												
											 </div>
											 
											  <div class="form-group row">
												<label class="col-md-2  required">1. PDF</label>
												<div class="col-md-5">
														<div class="input-group input-file" name="file_pdf" id="file_pdf_input" <?php echo $paper['revise_file_pdf'] != "" ? 'style="display:none"' : NULL ?>>
																
																<input type="text" class="form-control" />
																<span class="input-group-btn">
																	<button class="btn btn-success btn-choose" type="button">Choose</button>
																</span>
																
														</div>
														<?php if($paper['revise_file_pdf'] != ""){ ?>
														<div class="card fileInfo" id="file_pdf_uploaded">
															  <div class="card-body">
																<div class="row">
																	<div class="col-md-2">
																		<div class="h1"><i class="zmdi zmdi-file"></i></div>
																	</div>
																	<div class="col-md-10">
																		<div>
																			REVISE_<?php echo $implode_corres_name."_".$paper['paper_code'] ?>
																			<span class="badge badge-danger">PDF</span>
																		</div>
																		<div>
																		<a target="_blank" href="<?php echo  site_url("editorSubmission/forceDownload/".$paper['paper_id']."/revise_file_pdf/REVISE")?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo DOC_VIEWER.base_url()?>uploads/<?php echo $paper['revise_file_pdf']?>" class="card-link">View</a>
																		</div>
																	</div>
																
																</div>
																
															  </div>
														</div>
														
														<?php } ?>
												 </div>
											 </div>
											 
											  <div class="form-group row">
												<label class="col-md-2  required">2. MS-Word</label>
												<div class="col-md-5">
														<div class="input-group input-file" name="file_word" id="file_word_input" <?php echo $paper['revise_file_word'] != "" ? 'style="display:none"' : NULL ?>>
																<input type="text" class="form-control" />
																<span class="input-group-btn">
																	<button class="btn btn-success btn-choose" type="button">Choose</button>
																</span>
														</div>
														<?php if($paper['revise_file_word'] != ""){ ?>
														<div class="card fileInfo" id="file_word_uploaded">
															  <div class="card-body">
																<div class="row">
																	<div class="col-md-2">
																		<div class="h1"><i class="zmdi zmdi-file"></i></div>
																	</div>
																	<div class="col-md-10">
																		<div>
																			REVISE_<?php echo $implode_corres_name."_".$paper['paper_code'] ?>
																			<span class="badge badge-primary">WORD</span>
																		</div>
																		<div>
																		<a target="_blank" href="<?php echo  site_url("editorSubmission/forceDownload/".$paper['paper_id']."/revise_file_word/REVISE")?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo DOC_VIEWER.base_url()?>uploads/<?php echo $paper['revise_file_word']?>" class="card-link">View</a>
																		</div>
																	</div>
																	
																</div>
																
															  </div>
														</div>
														
														<?php } ?>
												 </div>
											 </div>
											 <?php if($paper['revise_file_pdf'] != ""){ ?>
											  <div class="form-group row">
												<label class="col-md-2">Note from Editor</label>
												<div class="col-md-12">
													<textarea name="editor_revise_note" id="editor_revise_note" class="form-control" rows="6"><?php echo $paper['editor_revise_note'] != "" ? $paper['editor_revise_note'] : NULL ?></textarea>
												</div>
											</div>
											 <?php } ?>
											<div class="form-actions form-group text-center p-t-20">
															<?php if($paper['revise_file_pdf'] == ""){ ?>
															<button type="submit" class="btn btn-primary btn-lg">Update Revised</button>
															<?php } else { ?>
																<?php if($paperStatus['status_type'] < 4){ ?>
																<button type="button" id="send-inpress" class="btn btn-success btn-lg">Send for In Press</button>
																<button type="button" id="send-second-revise" class="btn btn-danger btn-lg">2<sup>nd</sup> Revise</button>
																<button type="button" id="cancel-revise" class="btn btn-warning btn-lg" data-url="<?php echo site_url('editorSubmission/cancelRevise/'.$paper['paper_id'])?>">Cancel Revised</button>
																<?php } else { ?>
																<button type="button" id="cancel-inpress" class="btn btn-warning btn-lg" data-url="<?php echo site_url('editorSubmission/cancelInpress/'.$paper['paper_id'])?>">Cancel Inpress</button>
																
																<?php } ?>
															<?php } ?>
															
											</div>
									</form>
								</div>
							</div>
							</div>
							</div>
						</div>
					</div>
		</section>
		<?php } ?>
		
<script type="text/javascript">
$(function(){

	$('#send-correction-btn').click(function(e){
		e.preventDefault();
		var ck_box = $('.send-correction:checked').length;
		if(ck_box == 0){
		  showDialogError('Please select at least one of evaluation');
		} 
		else if($('#revise_due_date').val() == ""){
			showDialogError('Please enter revise due date');
			
		}
		else{
			 ajaxPostConfirmSubmit('#eva-form' , 'Are you sure to send this evaluation to author?');
			
		}
	});
	
	$( ".datepicker" ).datepicker({
		changeMonth : true,
		changeYear : true,
		minDate: 0,
		dateFormat : 'dd/mm/yy'
	}).focus(function() {
        $(".ui-datepicker-prev, .ui-datepicker-next").remove();
	});
	
	
	$('#cancel-revise').click(function(e){
		e.preventDefault();
		ajaxRedirectConfirm($(this).data('url') , "Are you sure to cancel this revised paper ?");
		
	})
	
	$('#cancel-correction').click(function(e){
		e.preventDefault();
		ajaxRedirectConfirm($(this).data('url') , "Are you sure to cancel this correction process ?");
		
	})
	
	$('#send-inpress').click(function(e){
		e.preventDefault();
		$('#reviseForm').attr('action' , '<?php echo site_url('editorSubmission/sendInpress')?>');
		ajaxPostConfirmSubmit("#reviseForm" , "Are your sure send for inpress to this author?");
	})
	
	$('#send-second-revise').click(function(e){
		e.preventDefault();
		$('#reviseForm').attr('action' , '<?php echo site_url('editorSubmission/sendSecondRevise')?>');
		ajaxPostConfirmSubmit("#reviseForm" , "Are your sure send for 2nd Revise to this author?");
	})
	
	$('#cancel-inpress').click(function(e){
		e.preventDefault();
		ajaxRedirectConfirm($(this).data('url') , "Are you sure to cancel in press status ?");
		
	})
	
	
	bs_input_file();
	<?php if($paper['revise_file_pdf'] == ""){ ?>
	$('#reviseForm').validate({
		rules: {
			file_pdf: {
                required: true,
				 extension: "pdf"
            },
			file_word:{
				 required: true,
				 extension: "doc|docx"
			}
        },
		messages: {
			file_pdf: {
				extension : 'Please correct and submit only PDF file'
			},
			file_word: {
				extension : 'Please correct and submit only Microsoft Word file'
			}
		},
        submitHandler: function (form) { 
			$('#reviseForm').attr('action' , '<?php echo site_url('editorSubmission/saveRevise')?>');
            ajaxPostConfirmSubmit("#reviseForm" , "Are your sure to update revise paper?");
            return false; 
        }
	 });
	 
	<?php } else { ?>
	$('#reviseForm').submit(function(e){
		e.preventDefault();
		$('#reviseForm').attr('action' , '<?php echo site_url('editorSubmission/saveRevise')?>');
		 ajaxPostConfirmSubmit("#reviseForm" , "Are your sure to update revise paper?");
	});
	<?php } ?>
})
</script>