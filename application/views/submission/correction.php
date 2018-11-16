 <?php
if($this->session->userdata('is_logged_in')){
	$sess_users = $this->session->userdata('is_logged_in');
}
 ?>
  
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4 place-inline">
							Paper Submission / Correction
                            </h1>
							
                        </div> 
						 <div class="col-md-6 text-right">
							
											<button onclick ="window.location='<?php echo site_url('submission')?>'" type="button" class="btn btn-secondary">
												<i class="zmdi zmdi-arrow-left"></i> Back
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
							<div class="card-header">
								<div class="row">
									<div class="col-md-12">
										<strong>Revised Submission</strong>
									</div>
									
								</div>
							</div>
                            <div class="card-body">
							
								<div class="p-b-30">
									<h4 class="p-b-20">Aritcle Information</h4>
									<div class="table-responsive table--no-card m-b-30">
									<table class="table table-top-campaign">
                                            <tbody>
											
                                                <tr>
                                                    <td>Article ID</td>
                                                    <td class="text-left"><?php echo $paper['paper_code']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Article Title</td>
                                                    <td class="text-left"><?php echo $paper['title']?></td>
                                                </tr>
												<tr>
                                                    <td>Revised Due Date</td>
                                                    <td class="text-left" style="color:red;font-weight:bold"><?php echo date('d/m/Y' ,strtotime($paper['revise_due_date']) )?></td>
                                                </tr>
												
                                            </tbody>
                                        </table>
									</div>
									
								</div>
								
								<div class="p-b-30">
									<?php if(!empty($reviewers) ){ ?>
									<h4 class="p-b-20">1<sup>st</sup> Submission Evaluation</h4>
									
									<div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-data2">
                                    <thead>
                                        <tr>
											
											<th width="25%">Reviewer ID</th>
											<th width="10%">Total Score</th>
											<th width="30%">Conference Proceedings Publication</th>
											<th width="30%">Journal Publication</th>
                                           
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
										foreach($reviewers as $key=>$row) {

										?>
                                        <tr class="tr-shadow">
											
											<td><strong><?php echo 'U'.str_pad($row['reviewer_by'],4,0,STR_PAD_LEFT) ?></strong></td>
											
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
                                                <div class="table-data-feature">
													 <button title="View" type="button" onclick="window.location='<?php echo site_url('submission/correctionEvaluation/'.$row['reviewer_id'])?>'" class="btn btn-primary btn-xs">
                                                      View
                                                    </button>
													
													&nbsp;
                                                     <button title="Print" type="button" onclick="window.location='<?php echo site_url('submission/printEvaluation/'.$row['reviewer_id'])?>'" class="btn btn-danger btn-xs">
                                                      Print
                                                    </button>
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
									<form action="<?php echo site_url('submission/saveRevise')?>" method="post" id="reviseForm" enctype="multipart/form-data">
											<input type="hidden" value="<?php echo $this->uri->segment(3)?>" name="paper_id" />		
											<div class="form-group">
                                                <label class="bold" for="cc-payment" class="control-label mb-1">Article Title</label>
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
														<div class="input-group input-file" name="file_pdf" id="file_pdf_input" <?php echo $paper['revise_file_pdf'] != "" ? 'style="display:none"' : NULL ?> >
																
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
																		<a target="_blank" href="<?php echo  site_url("submission/forceDownload/".$paper['paper_id']."/revise_file_pdf/REVISE")?>" class="card-link">Download</a>
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
														<div class="input-group input-file" name="file_word" id="file_word_input" <?php echo $paper['revise_file_word'] != "" ? 'style="display:none"' : NULL ?> >
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
																		<a target="_blank" href="<?php echo  site_url("submission/forceDownload/".$paper['paper_id']."/revise_file_word/REVISE")?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo DOC_VIEWER.base_url()?>uploads/<?php echo $paper['revise_file_word']?>" class="card-link">View</a>
																		</div>
																	</div>
																	
																</div>
																
															  </div>
														</div>
														
														<?php } ?>
												 </div>
											 </div>
											 
											<div class="form-actions form-group text-center p-t-20">
												<?php if($paper['revise_file_pdf'] == ""){ ?>
															<button type="submit" class="btn btn-primary btn-lg">Update Revised</button>
															
															<button type="button" class="btn btn-secondary btn-lg" onclick ="window.location='<?php echo site_url('submission')?>'">Cancel</button>
												<?php }else { ?>			
												
													<button type="button" id="cancel-revise" class="btn btn-danger btn-lg" data-url="<?php echo site_url('submission/cancelRevise/'.$paper['paper_id'])?>">Cancel Revised</button>
										
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



<script type="text/javascript">
$(function(){
	
	$('#cancel-revise').click(function(e){
		e.preventDefault();
		ajaxRedirectConfirm($(this).data('url') , "Are you sure to cancel this revised paper ?");
		
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
            ajaxPostConfirmSubmit("#reviseForm" , "Are your sure to update revise paper?");
            return false; 
        }
	 });
	 
	<?php } else { ?>
	$('#reviseForm').submit(function(e){
		e.preventDefault();
		 ajaxPostConfirmSubmit("#reviseForm" , "Are your sure to update revise paper?");
	});
	
	 
	<?php } ?>
	
	
})
</script>