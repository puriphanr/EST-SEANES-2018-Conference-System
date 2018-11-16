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
                         
                                    <div class="card-body">
									
											<nav>
												<div class="nav nav-tabs" id="nav-tab" role="tablist">
													<a class="nav-item nav-link active show" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Account</a>
													<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
													
												</div>
											</nav>
											 <form action="<?php echo site_url('adminSettings/editUser/2/'.$this->uri->segment(4))?>" method="post" id="profileForm" >
											
											<div class="tab-content pl-3 pt-2" id="nav-tabContent">
												<div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
													<div class="row form-group">
														<div class="col col-md-3">
															<label class="required form-control-label">User Role</label>
														</div>
														<div class="col-12 col-md-6">
															<select name="users_role" id="users_role" class="form-control">
																<option value="0" selected>Please select</option>
																<?php foreach($role as $key=>$row){ ?>
																<option value="<?php echo $key?>" <?php echo $this->uri->segment(4) && $key==$data['users_role'] ? 'selected' : NULL ?>><?php echo $row ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class="required  form-control-label">First Name</label>
														</div>
														<div class="col-12 col-md-9">
															<input id="firstname" name="firstname" class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['firstname'] : NULL ?>">
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class=" form-control-label">Middle Name</label>
														</div>
														<div class="col-12 col-md-9">
															<input id="middlename" name="middlename" class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['middlename'] : NULL ?>">
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class="required  form-control-label">Last Name</label>
														</div>
														<div class="col-12 col-md-9">
															<input id="lastname" name="lastname" class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['lastname'] : NULL ?>">
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class="required form-control-label">Name Title</label>
														</div>
														<div class="col-12 col-md-4">
															<select name="name_title" id="name_title" class="form-control">
																<option value="">Please select</option>
																<option value="Prof." <?php echo $this->uri->segment(4) && $data['name_title'] == 'Prof.' ? 'selected' : NULL ?>>Prof.</option>
																<option value="Dr." <?php echo $this->uri->segment(4) && $data['name_title'] == 'Dr.' ? 'selected' : NULL ?>>Dr.</option>
																<option value="Mr." <?php echo $this->uri->segment(4) && $data['name_title'] == 'Mr.' ? 'selected' : NULL ?>>Mr.</option>
																<option value="Ms." <?php echo $this->uri->segment(4) && $data['name_title'] == 'Ms.' ? 'selected' : NULL ?>>Ms.</option>
																<option value="Mrs." <?php echo $this->uri->segment(4) && $data['name_title'] == 'Mrs.' ? 'selected' : NULL ?>>Mrs.</option>
																<option value="Other" <?php echo $this->uri->segment(4) && $data["name_title"] != 'Prof.' && $data["name_title"] != 'Dr.' && $data["name_title"] != 'Mr.' && $data["name_title"] != 'Ms.' && $data["name_title"] != 'Mrs.' ? 'selected' : NULL ?>>Other</option>
															</select>
														</div>
														<div class="col-12 col-md-5">
															<input id="name_title_other" name="name_title_other" class="form-control" disabled type="text" value="<?php echo $this->uri->segment(4) && $data["name_title"] != 'Prof.' && $data["name_title"] != 'Dr.' && $data["name_title"] != 'Mr.' && $data["name_title"] != 'Ms.' && $data["name_title"] != 'Mrs.' ? $data['name_title'] : NULL ?>" <?php echo $this->uri->segment(4) && $data["name_title"] != 'Prof.' && $data["name_title"] != 'Dr.' && $data["name_title"] != 'Mr.' && $data["name_title"] != 'Ms.' && $data["name_title"] != 'Mrs.' ? NULL :'disabled' ?>>
														</div>
													</div>
													
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="email-input" class="required  form-control-label">Email</label>
														</div>
														<div class="col-12 col-md-9">
																<input id="email" name="email" class="form-control" <?php echo $this->uri->segment(4) ? 'readonly' : NULL ?> type="text" value="<?php echo $this->uri->segment(4) ? $data['email'] : NULL ?>">
														</div>
													</div>
													<?php if($this->uri->segment(4)){ ?>
														<div class="row form-group">
														
														<div class="col-12 ">
															<label>
																<input type="checkbox" name="change_password" value="1" id="change_password" /> Change Password
															</label>
														</div>
													</div>
													<?php } ?>
													
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="password-input" class="required  form-control-label">Password</label>
														</div>
														<div class="col-12 col-md-9">
															
																<input id="password" name="password" class="form-control" type="password" <?php echo $this->uri->segment(4) ? 'disabled' : NULL ?>>
															
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="repassword" class="required  form-control-label">Re-enter Password</label>
														</div>
														<div class="col-12 col-md-9">
															
																<input id="repassword" name="repassword" class="form-control" type="password" <?php echo $this->uri->segment(4) ? 'disabled' : NULL ?>>
															
														</div>
													</div>
													
												</div>
												<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
														<div class="is_hide">
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">Current Job Position</label>
															</div>
															<div class="col col-md-9">
																<input id="job_position" name="job_position" class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['job_position'] : NULL ?>">
															</div>
														</div>
													</div>
													
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class=" form-control-label">Organization</label>
														</div>
														<div class="col-12 col-md-9">
															<input id="organization" name="organization" class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['organization'] : NULL ?>">
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-12">
															<label for="textarea-input" class="form-control-label">Contact Address</label>
														
															<textarea name="contact_address" id="contact_address" rows="4" class="form-control"><?php echo $this->uri->segment(4) ? $data['contact_address'] : NULL ?></textarea>
														</div>
													</div>
													<div class="row form-group">
				
														<div class="col-12 col-md-12">
															<div class="row">
																<div class="col-12 col-md-2">
																	<label class=" form-control-label">City</label>
																</div>
																
																<div class="col-12 col-md-4">
																	<input id="city" name="city" class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['city'] : NULL ?>">
																</div>
																<div class="col-12 col-md-2">
																	<label class=" form-control-label">State/Province</label>
																</div>
																<div class="col-12 col-md-4">
																	<input id="state" name="state" class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['state'] : NULL ?>">
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
																	<input id="postal_code" name="postal_code" class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['postal_code'] : NULL ?>">
																</div>
																<div class="col-12 col-md-2">
																	<label class="form-control-label">Country</label>
																</div>
																<div class="col-12 col-md-4">
																	
																	<select name="country" id="country" class="form-control select2">
																		<option value="">Please Select</option>
																		<?php foreach($country as $key=>$row){ ?>
																		<option value="<?php echo $row['country_id']?>" <?php echo $this->uri->segment(4) && $data['country'] == $row['country_id'] ? 'selected' : NULL ?>><?php echo $row['country_name']?></option>
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
															<input name="phone" id="phone"  class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['phone'] : NULL ?>">
														</div>
														<div class="col col-md-2">
															<label for="fax" class=" form-control-label">Fax</label>
														</div>
														<div class="col-12 col-md-4">
															<input name="fax" id="fax"  class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['fax'] : NULL ?>">
														</div>
													</div>
													
													
													
													<div class="is_hide">
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">Line ID</label>
															</div>
															<div class="col-12 col-md-9">
																<input id="contact_line" name="contact_line" class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['contact_line'] : NULL ?>">
															</div>
														</div>
													</div>
													
													<div class="is_hide">
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">WhatsApp</label>
															</div>
															<div class="col col-md-9">
																<input id="contact_whatsapp" name="contact_whatsapp" class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['contact_whatsapp'] : NULL ?>">
															</div>
														</div>
													</div>
													
													<div class="is_hide">
														<div class="row form-group">
															<div class="col col-md-3">
																<label for="text-input" class=" form-control-label">Facebook Messenger</label>
															</div>
															<div class="col col-md-9">
																<input id="contact_messenger" name="contact_messenger" class="form-control" type="text" value="<?php echo $this->uri->segment(4) ? $data['contact_messenger'] : NULL ?>">
															</div>
														</div>
													</div>
													
													
													
													
													<div class="is_hide">
														<div class="row form-group">
															<div class="col col-md-12">
																<label for="textarea-input" class="form-control-label">Human Factors and Ergonomics Fields of Interest</label>
															
																<textarea name="interest" id="interest" rows="4" class="form-control"><?php echo $this->uri->segment(4) ? $data['interest'] : NULL ?></textarea>
															</div>
														</div>
													</div>
												
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
	
	
	
	
		 if($('#users_role').val() == 2){
			 $('.is_hide').show();
		 }
		 else{
			 $('.is_hide').hide(); 
		 }
	
	
	 $('#users_role').change(function(){
		 if($(this).val() == 2){
			 $('.is_hide').show();
		 }
		 else{
			 $('.is_hide').hide(); 
		 }
	 });
	 
	 
	 $('#profileForm').validate({
		rules: {
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
			$( "#dialog-warn .dialog-text" ).html('Are you confirm to change this profile information ?');
			$( "#dialog-warn" ).dialog({
				modal: true,
				width: $(window).width() > 600 ? 400 : 'auto',
				minheight: 150,
				buttons: {
				'OK': function() {
					$( this ).dialog( "close" );
				    ajaxPostSubmit("#profileForm");
					return false; 

				},
				'Cancel' : function(){
					$( this ).dialog( "close" );
				}
			  }
			});
          
        },
		
	 });
	 
	$('.select2').select2();
	
	$('#change_password').change(function(){
		if($(this).is(':checked')){
			$('#password').removeAttr('disabled');
			$('#repassword').removeAttr('disabled');
		}
		else{
			$('#password').attr('disabled' , 'disabled');
			$('#repassword').attr('disabled' ,'disabled');
		}
	});

	 
	$('#name_title').change(function(){
		var bEnabled = $(this).val() === "Other";
		$('#name_title_other').prop("disabled", !bEnabled);
	})
	 
})
</script>