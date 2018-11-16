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
								Paper Submission / Reviewers / Article
                            </h1>
							
                        </div> 
						 <div class="col-md-6 text-right">
							
											<button onclick ="window.location='<?php echo site_url('review')?>'" type="button" class="btn btn-secondary">
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
						<div class="col-12 col-md-12">
							<div class="card">
                                    <div class="card-header"><strong> Manuscript Information</strong></div>
                                    <div class="card-body">
                               
									
											<div class="form-group">
                                                <label class="bold" for="cc-payment" class="control-label mb-1">Article Title</label>
                                                <input id="title" name="title" class="form-control" value="<?php echo $data['title']?>" type="text" readonly>
                                            </div>
                                          
											<div class="form-group">
												<div class="row">
													<div class="col-md-12">
														<label for="cc-payment" class="control-label mb-10 bold">Authors</label>
													</div>
												</div>
												
                                              
											
												<div class="table-responsive table-responsive-data2">
													<table class="table table-data2" id="table-author">
														<thead>
															<tr>
																<th width="40%">Name / Email</th>
																<th width="40%">Contact Address</th>
																<th width="20%">Role</th>
																
															</tr>
														</thead>
														<tbody>
															
																<?php foreach($authors as $key=>$row){ ?>
															<tr class="tr-border">
															  
																<td>
																	<input class="users_id" type="hidden" name="users_id[]" value="<?php echo $row['users_id']?>" />
																	<input class="fname" type="hidden" name="firstname[]" value="<?php echo $row['firstname']?>" />
																	<input class="mname" type="hidden" name="middlename[]" value="<?php echo $row['middlename']?>" />
																	<input class="lname" type="hidden" name="lastname[]" value="<?php echo $row['lastname']?>" />
																	<input class="address" type="hidden" name="contact_address[]" value="<?php echo $row['contact_address']?>" />
																	<input class="email" type="hidden" name="email[]" value="<?php echo $row['email']?>" />
																	<input class="role" type="hidden" name="is_corresponding[]" value="<?php echo $row['is_corresponding']?>" />
																	<div  class="table-data__info">
																			<h6><?php echo $row['firstname'].' '.$row['middlename'].' '.$row['lastname']?></h6>
																			<span><a href="javascript:void(0)" style="cursor:default"><?php echo $row['email']?></a></span>
																	</div>
																	
																	
																</td>
																<td>
																		<div><?php echo nl2br($row['contact_address'])?></div>
																</td>
																
																<td>
																	<?php if($row['is_corresponding'] == 1){ ?>
																	<span class="status--process">Corresponding</span>
																	<?php }else{ ?>
																	<span>Author</span>
																	<?php } ?>
																</td>
																
															</tr>		

															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
											
											 <div class="form-group row">
												<div class="col-md-12">
													<label class="bold" for="cc-payment" class="control-label mb-1">Upload Manuscript/Article Files</label>
												</div>
											
												
											 </div>
											 
											  <div class="form-group row">
												<label class="col-md-2">1. PDF</label>
												<div class="col-md-5">
														
													
														<div class="card fileInfo" id="file_pdf_uploaded">
															  <div class="card-body">
																<div class="row">
																	<div class="col-md-2">
																		<div class="h1"><i class="zmdi zmdi-file"></i></div>
																	</div>
																	<div class="col-md-8">
																		<div>
																			<?php echo $implode_corres_name."_".$data['paper_code'] ?>
																			<span class="badge badge-danger">PDF</span>
																		</div>
																		<div>
																		<a target="_blank" href="<?php echo  site_url("submission/forceDownload/".$data['paper_id']."/file_pdf")?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo DOC_VIEWER.base_url()?>uploads/<?php echo $data['file_pdf']?>" class="card-link">View</a>
																		</div>
																	</div>
																
																</div>
																
															  </div>
														</div>
													
												 </div>
											 </div>
											 
											  <div class="form-group row">
												<label class="col-md-2">2. MS-Word</label>
												<div class="col-md-5">
														
														<div class="card fileInfo" id="file_word_uploaded">
															  <div class="card-body">
																<div class="row">
																	<div class="col-md-2">
																		<div class="h1"><i class="zmdi zmdi-file"></i></div>
																	</div>
																	<div class="col-md-8">
																		<div>
																			<?php echo $implode_corres_name."_".$data['paper_code'] ?>
																			<span class="badge badge-primary">WORD</span>
																		</div>
																		<div>
																		<a target="_blank" href="<?php echo  site_url("submission/forceDownload/".$data['paper_id']."/file_word")?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo DOC_VIEWER.base_url()?>uploads/<?php echo $data['file_word']?>" class="card-link">View</a>
																		</div>
																	</div>
																	
																</div>
																
															  </div>
														</div>
														
												 </div>
											 </div>
											 
											
											 <div class="form-group row">
												<label class="col-md-4 ">PDF with signature of Corresponding Authors</label>
												<div class="col-md-5">
													
														<div class="card fileInfo" id="file_signature_uploaded">
															  <div class="card-body">
																<div class="row">
																	<div class="col-md-2">
																		<div class="h1"><i class="zmdi zmdi-file"></i></div>
																	</div>
																	<div class="col-md-8">
																		<div>
																			<?php echo $implode_corres_name."_".$data['paper_code']."-signature" ?>
																			<span class="badge badge-danger">PDF</span>
																		</div>
																		<div>
																		<a target="_blank" href="<?php echo  site_url("submission/forceDownload/".$data['paper_id']."/file_signature")?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo DOC_VIEWER.base_url()?>uploads/<?php echo $data['file_signature']?>" class="card-link">View</a>
																		</div>
																	</div>
																	
																</div>
																
															  </div>
														</div>
														
												 </div>
											 </div>
												
											 <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1 bold">Note</label>
                                                <textarea name="note" rows="8" class="form-control" id="note" readonly><?php echo $data['note']?></textarea>
                                            </div>
										
                                    </div>
                                </div>
                        </div>
						
					</div>
				</div>
</section>