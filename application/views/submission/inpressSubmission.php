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
							Paper Submission / In Press Submission
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
										<strong>In Press Submission</strong>
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
								
								
								
								<div class="p-b-30">
										<h4 class="p-b-20">In Press Paper</h4>
									<form action="<?php echo site_url('submission/saveInpress')?>" method="post" id="inpressForm" enctype="multipart/form-data">
											<input type="hidden" value="<?php echo $this->uri->segment(3)?>" name="paper_id" />		
											<div class="form-group">
                                                <label class="required bold" for="cc-payment" class="control-label mb-1">Article Title</label>
												<?php if($paperStatus['status_type'] == 4){ ?>
                                                <input  id="title" name="title" class="form-control" value="<?php echo $paper['inpress_title'] != "" ? $paper['inpress_title'] : NULL ?>" type="text">
												<?php }else{ ?>
												<input  id="title" name="title" class="form-control" value="<?php echo $paper['revise_title'] != "" ? $paper['revise_title'] : NULL ?>" type="text">
												<?php } ?>
                                            </div>
											
											<div class="form-group row">
												<div class="col-md-12">
													<label class="bold" for="cc-payment" class="control-label mb-1">Upload Manuscript/Article Files</label>
												</div>
											
												
											 </div>
											 
											  <div class="form-group row">
												<label class="col-md-2  required">1. PDF</label>
												<div class="col-md-5">
														<div class="input-group input-file" name="file_pdf" id="file_pdf_input" <?php echo $paper['inpress_file_pdf'] != "" ? 'style="display:none"' : NULL ?>>
																
																<input type="text" class="form-control" />
																<span class="input-group-btn">
																	<button class="btn btn-success btn-choose" type="button">Choose</button>
																</span>
																
														</div>
														<?php if($paper['inpress_file_pdf'] != ""){ ?>
														<div class="card fileInfo" id="file_pdf_uploaded">
															  <div class="card-body">
																<div class="row">
																	<div class="col-md-2">
																		<div class="h1"><i class="zmdi zmdi-file"></i></div>
																	</div>
																	<div class="col-md-8">
																		<div>
																			INPRESS_<?php echo $implode_corres_name."_".$paper['paper_code'] ?>
																			<span class="badge badge-danger">PDF</span>
																		</div>
																		<div>
																		<a target="_blank" href="<?php echo  site_url("submission/forceDownload/".$paper['paper_id']."/inpress_file_pdf/INPRESS")?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo DOC_VIEWER.base_url()?>uploads/<?php echo $paper['inpress_file_pdf']?>" class="card-link">View</a>
																		</div>
																	</div>
																	<div class="col-md-2">
																		<div class="table-data-feature">
																			<button id="remove_pdf" type="button" class="item removeFile" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" aria-describedby="ui-id-1">
																					<i class="zmdi zmdi-delete"></i>
																			</button>
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
														<div class="input-group input-file" name="file_word" id="file_word_input" <?php echo $paper['inpress_file_word'] != "" ? 'style="display:none"' : NULL ?>>
																<input type="text" class="form-control" />
																<span class="input-group-btn">
																	<button class="btn btn-success btn-choose" type="button">Choose</button>
																</span>
														</div>
														<?php if($paper['inpress_file_word'] != ""){ ?>
														<div class="card fileInfo" id="file_word_uploaded">
															  <div class="card-body">
																<div class="row">
																	<div class="col-md-2">
																		<div class="h1"><i class="zmdi zmdi-file"></i></div>
																	</div>
																	<div class="col-md-8">
																		<div>
																			INPRESS_<?php echo $implode_corres_name."_".$paper['paper_code'] ?>
																			<span class="badge badge-primary">WORD</span>
																		</div>
																		<div>
																		<a target="_blank" href="<?php echo  site_url("submission/forceDownload/".$paper['paper_id']."/inpress_file_word/INPRESS")?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo DOC_VIEWER.base_url()?>uploads/<?php echo $paper['inpress_file_word']?>" class="card-link">View</a>
																		</div>
																	</div>
																	
																	<div class="col-md-2">
																		<div class="table-data-feature">
																			<button id="remove_word" type="button" class="item removeFile" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" aria-describedby="ui-id-1">
																					<i class="zmdi zmdi-delete"></i>
																			</button>
																		</div>
																	</div>
																	
																</div>
																
															  </div>
														</div>
														
														<?php } ?>
												 </div>
											 </div>
											 
											<div class="form-actions form-group text-center p-t-20">
															
															<button type="submit" class="btn btn-primary btn-lg">Update In Press</button>
														
																
															
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
	
	bs_input_file();
	<?php if($paper['inpress_file_pdf'] == ""){ ?>
	$('#inpressForm').validate({
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
            ajaxPostConfirmSubmit("#inpressForm" , "Are your sure to update this in press ?");
            return false; 
        }
	 });
	<?php } else { ?>
	
	$('#inpressForm').validate({
		rules: {
            title: {
                required: true
            }
        },
        submitHandler: function (form) { 
           ajaxPostConfirmSubmit("#inpressForm" , 'Are your sure to update this in press ?');
            return false; 
        }
	 });
	 
	 $('#remove_pdf').click(function(e){
		 e.preventDefault();
		 removeFile_showInput('#file_pdf_uploaded','#file_pdf_input'); 
		$('input[name="file_pdf"]').rules("add", {
			 required: true,
			extension: "pdf",
			 messages: {
				extension : 'Please correct and submit only PDF file'
			  }
		 });
	 })
	  $('#remove_word').click(function(e){
		 e.preventDefault();
		 removeFile_showInput('#file_word_uploaded','#file_word_input'); 
		 $('input[name="file_word"]').rules("add", {
			 required: true,
			 extension: "doc|docx",
			 messages: {
				extension : 'Please correct and submit only Microsoft Word file'
			  }
		 });
		
	 })
	<?php } ?>
	
	
})
</script>