 <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4 place-inline">
								Users
                            </h1>
							
                        </div> 
						 <div class="col-md-6 text-right">
							
											<button onclick ="window.location='<?php echo site_url('adminSettings/users')?>'" type="button" class="btn btn-secondary">
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
                               
                                        <form action="<?php echo site_url('editorSubmission/editPaper/2/'.$this->uri->segment(4))?>" method="post" id="paperForm" enctype="multipart/form-data">
                           
											<div class="row form-group">
														<div class="col col-md-3">
															<label class="required form-control-label">User Role</label>
														</div>
														<div class="col-12 col-md-6">
															<?php echo $role[$this->uri->segment(4)]?>
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class="required  form-control-label">First Name</label>
														</div>
														<div class="col-12 col-md-9">
															<input id="firstname" name="firstname" class="form-control" type="text">
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class=" form-control-label">Middle Name</label>
														</div>
														<div class="col-12 col-md-9">
															<input id="middlename" name="middlename" class="form-control" type="text">
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class="required  form-control-label">Last Name</label>
														</div>
														<div class="col-12 col-md-9">
															<input id="lastname" name="lastname" class="form-control" type="text">
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class="required form-control-label">Name Title</label>
														</div>
														<div class="col-12 col-md-4">
															<select name="name_title" id="name_title" class="form-control">
																<option value="">Please select</option>
																<option value="Prof.">Prof.</option>
																<option value="Dr.">Dr.</option>
																<option value="Mr.">Mr.</option>
																<option value="Ms.">Ms.</option>
																<option value="Mrs.">Mrs.</option>
																<option value="Other">Other</option>
															</select>
														</div>
														<div class="col-12 col-md-5">
															<input id="name_title_other" name="name_title_other" class="form-control" disabled type="text">
														</div>
													</div>
													
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">Current Job Position</label>
															</div>
															<div class="col col-md-9">
																<input id="job_position" name="job_position" class="form-control" type="text">
															</div>
														</div>
													
													
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class=" form-control-label">Organization</label>
														</div>
														<div class="col-12 col-md-9">
															<input id="organization" name="organization" class="form-control" type="text">
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-12">
															<label for="textarea-input" class="required form-control-label">Contact Address</label>
														
															<textarea name="contact_address" id="contact_address" rows="4" class="form-control"></textarea>
														</div>
													</div>
													<div class="row form-group">
				
														<div class="col-12 col-md-12">
															<div class="row">
																<div class="col-12 col-md-2">
																	<label class=" form-control-label">City</label>
																</div>
																
																<div class="col-12 col-md-4">
																	<input id="city" name="city" class="form-control" type="text">
																</div>
																<div class="col-12 col-md-2">
																	<label class=" form-control-label">State/Province</label>
																</div>
																<div class="col-12 col-md-4">
																	<input id="state" name="state" class="form-control" type="text">
																</div>
																
															</div>
														</div>
													</div>
													<div class="row form-group">
				
														<div class="col-12 col-md-12">
															<div class="row">
																<div class="col-12 col-md-2">
																	<label class=" form-control-label">Postal Code</label>
																</div>
																<div class="col-12 col-md-4">
																	<input id="postal_code" name="postal_code" class="form-control" type="text">
																</div>
																<div class="col-12 col-md-2">
																	<label class="required form-control-label">Country</label>
																</div>
																<div class="col-12 col-md-4">
																	
																	<select name="country" id="country" class="form-control select2">
																		<option value="">Please Select</option>
																		<?php foreach($country as $key=>$row){ ?>
																		<option value="<?php echo $row['country_id']?>"><?php echo $row['country_name']?></option>
																		<?php } ?>
																	</select>
																</div>
															</div>
														</div>
													</div>
												
													<div class="row form-group">
														<div class="col col-md-2">
															<label for="phone" class=" form-control-label">Phone</label>
														</div>
														<div class="col-12 col-md-4">
															<input name="phone" id="phone"  class="form-control" type="text">
														</div>
														<div class="col col-md-2">
															<label for="fax" class=" form-control-label">Fax</label>
														</div>
														<div class="col-12 col-md-4">
															<input name="fax" id="fax"  class="form-control" type="text">
														</div>
													</div>
													
													
													
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">Line ID</label>
															</div>
															<div class="col-12 col-md-9">
																<input id="contact_line" name="contact_line" class="form-control" type="text">
															</div>
														</div>
													
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">WhatsApp</label>
															</div>
															<div class="col col-md-9">
																<input id="contact_whatsapp" name="contact_whatsapp" class="form-control" type="text">
															</div>
														</div>
													
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">Facebook Messenger</label>
															</div>
															<div class="col col-md-9">
																<input id="contact_messenger" name="contact_messenger" class="form-control" type="text">
															</div>
														</div>
													
													
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="email-input" class="required  form-control-label">Email</label>
														</div>
														<div class="col-12 col-md-9">
																<input id="email" name="email" class="form-control" type="text">
														</div>
													</div>
													
													
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="password-input" class="required  form-control-label">Password</label>
														</div>
														<div class="col-12 col-md-9">
															
																<input id="password" name="password" class="form-control" type="password">
															
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="repassword" class="required  form-control-label">Re-enter Password</label>
														</div>
														<div class="col-12 col-md-9">
															
																<input id="repassword" name="repassword" class="form-control" type="password">
															
														</div>
													</div>
												
														<div class="row form-group">
															<div class="col col-md-12">
																<label for="textarea-input" class="required form-control-label">Human Factors and Ergonomics Fields of Interest</label>
															
																<textarea name="interest" id="interest" rows="4" class="form-control"></textarea>
															</div>
														</div>
													
											<div class="form-actions form-group text-center p-t-20">
															<button type="submit" class="btn btn-primary btn-lg">Save</button>
															<button type="reset" class="btn btn-secondary btn-lg">Clear</button>
											</div>
                                        </form>
                                    </div>
                                </div>
                        </div>
						
					</div>
				</div>
</section>
	

<script type="text/javascript">
$(function(){
	
})
</script>