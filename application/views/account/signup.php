<section class="register">
                <div class="container">
                   
                    <div class="row">
                        <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">User Registration</strong>
                                    </div>
                                    <div class="card-body card-block">
										<div class="row">
											<div class="col-md-4 statistic2">
												<div class="statistic__item statistic__item--green">
													<h2 class="number">Authors</h2>
													<span class="desc">To submission your paper</span>
													
													<div class="icon">
														<i class="zmdi zmdi-file-text"></i>
													</div>
												</div>
												
												<div class="statistic__item statistic__item--pink" >
													<h2 class="number">Non-Authors</h2>
													<span class="desc">To participate the conference</span>
													
													<div class="icon">
														<i class="zmdi zmdi-account"></i>
													</div>
												</div>
												
												
												<div class="statistic__item statistic__item--orange" >
													<h2 class="number">Scientific Comittee</h2>
													<span class="desc">To review submission</span>
													
													<div class="icon">
														<i class="zmdi zmdi-assignment-check"></i>
													</div>
												</div>
												<div class="statistic__item statistic__item--blue" >
													<h2 class="number">Participants</h2>
													<span class="desc">To join conference event</span>
													
													<div class="icon">
														<i class="zmdi zmdi-walk"></i>
													</div>
												</div>
											</div>
											<div class="col-md-8">
												<div class="card-title">
													<h3 class="text-center title-2">Registration Form</h3>
												</div>
												<hr>
												<form action="<?php echo site_url('account/signup')?>" id="registerForm" method="post" class="form-horizontal">
													<div class="row form-group">
														<div class="col col-md-3">
															<label class="required form-control-label">Register as</label>
														</div>
														<div class="col-12 col-md-6">
															<select name="users_role" id="users_role" class="form-control">
																<option value="0">Please select</option>
																<option value="1" selected>Authors</option>
																<option value="2">Scientific Comittee / Reviewers</option>
																<option value="3">Participants (Non-auhor)</option>
															</select>
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
													<div class="is_hide">
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">Current Job Position</label>
															</div>
															<div class="col col-md-9">
																<input id="job_position" name="job_position" class="form-control" type="text">
															</div>
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
													
													
													
													<div class="is_hide">
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">Line ID</label>
															</div>
															<div class="col-12 col-md-9">
																<input id="contact_line" name="contact_line" class="form-control" type="text">
															</div>
														</div>
													</div>
													
													<div class="is_hide">
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">WhatsApp</label>
															</div>
															<div class="col col-md-9">
																<input id="contact_whatsapp" name="contact_whatsapp" class="form-control" type="text">
															</div>
														</div>
													</div>
													
													<div class="is_hide">
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">Facebook Messenger</label>
															</div>
															<div class="col col-md-9">
																<input id="contact_messenger" name="contact_messenger" class="form-control" type="text">
															</div>
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
													
													<div class="is_hide">
														<div class="row form-group">
															<div class="col col-md-12">
																<label for="textarea-input" class="required form-control-label">Human Factors and Ergonomics Fields of Interest</label>
															
																<textarea name="interest" id="interest" rows="4" class="form-control"></textarea>
															</div>
														</div>
													</div>
													
													<div class="form-actions form-group text-center p-t-20">
															<button type="submit" class="btn btn-primary btn-lg">Sign up</button>
															<button type="reset" class="btn btn-secondary btn-lg">Clear</button>
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
	 $('#registerForm').validate({
		rules: {
			users_role:{
				required: true
			},
			firstname:{
				required: true
			},
			lastname:{
				required: true
			},
			name_title:{
				required: true
			},
			name_title_other:{
				required: true
			},
			contact_address:{
				required: true
			},
			country:{
				required: true
			},
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
				minlength: 6
            }
			,
            repassword: {
                required: true,
				minlength: 6,
				equalTo : '#password'
				
            }
        },
        submitHandler: function (form) { 
            ajaxPostSubmit("#registerForm");
            return false; 
        },
		
	 });
	 
	 $('#users_role').change(function(){
		 if($(this).val() == 2){
			 $('.is_hide').show();
		 }
		 else{
			 $('.is_hide').hide(); 
		 }
	 });
	 
	 
	$('#name_title').change(function(){
		var bEnabled = $(this).val() === "Other";
		$('#name_title_other').prop("disabled", !bEnabled);
	})
})
</script>