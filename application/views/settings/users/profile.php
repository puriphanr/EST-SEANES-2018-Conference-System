<section class="p-t-20">
                <div class="container">
                    <div class="row">
						<div class="col-12 col-md-12">
							<div class="card">
                                    <div class="card-header"><strong> User Profile</strong></div>
                                    <div class="card-body">
                               
                                        <form action="<?php echo site_url('adminSettings/saveProfile')?>" method="post" id="profileForm" >
                           	
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class="required  form-control-label">First Name</label>
														</div>
														<div class="col-12 col-md-9">
															<input value="<?php echo $users['firstname']?>" id="firstname" name="firstname" class="form-control" type="text">
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class=" form-control-label">Middle Name</label>
														</div>
														<div class="col-12 col-md-9">
															<input id="middlename" value="<?php echo $users['middlename']?>" name="middlename" class="form-control" type="text">
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class="required  form-control-label">Last Name</label>
														</div>
														<div class="col-12 col-md-9">
															<input id="lastname" name="lastname" value="<?php echo $users['lastname']?>" class="form-control" type="text">
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="text-input" class="required form-control-label">Name Title</label>
														</div>
														<div class="col-12 col-md-4">
															<select name="name_title" id="name_title" class="form-control">
																<option value="">Please select</option>
																<option value="Prof." <?php echo $users["name_title"] == 'Prof.' ? 'selected' : NULL ?> >Prof.</option>
																<option value="Dr." <?php echo $users["name_title"] == 'Dr.' ? 'selected' : NULL ?>>Dr.</option>
																<option value="Mr." <?php echo $users["name_title"] == 'Mr.' ? 'selected' : NULL ?>>Mr.</option>
																<option value="Ms." <?php echo $users["name_title"] == 'Ms.' ? 'selected' : NULL ?>>Ms.</option>
																<option value="Mrs." <?php echo $users["name_title"] == 'Mrs.' ? 'selected' : NULL ?>>Mrs.</option>
																<option value="Other" <?php echo $users["name_title"] != 'Prof.' && $users["name_title"] != 'Dr.' && $users["name_title"] != 'Mr.' && $users["name_title"] != 'Ms.' && $users["name_title"] != 'Mrs.' ? 'selected' : NULL ?>>Other</option>
															</select>
														</div>
														<div class="col-12 col-md-5">
															<input id="name_title_other" value="<?php echo $users["name_title"] != 'Prof.' && $users["name_title"] != 'Dr.' && $users["name_title"] != 'Mr.' && $users["name_title"] != 'Ms.' && $users["name_title"] != 'Mrs.' ? $users['name_title'] : NULL ?>" name="name_title_other" class="form-control" <?php echo $users["name_title"] != 'Prof.' && $users["name_title"] != 'Dr.' && $users["name_title"] != 'Mr.' && $users["name_title"] != 'Ms.' && $users["name_title"] != 'Mrs.' ? NULL :'disabled' ?> type="text">
														</div>
													</div>
												
													
													
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="email-input" class=" form-control-label">Email</label>
														</div>
														<div class="col-12 col-md-9">
																<input id="email" disabled name="email" class="form-control" type="text" value="<?php echo $users['email']?>">
														</div>
													</div>
													<div class="row form-group">
														
														<div class="col-12 ">
															<label>
																<input type="checkbox" name="change_password" value="1" id="change_password" /> Change Password
															</label>
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="password-input" class="required  form-control-label">Password</label>
														</div>
														<div class="col-12 col-md-9">
															
																<input id="password" name="password" class="form-control" type="password" disabled>
															
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-3">
															<label for="repassword" class="required  form-control-label">Re-enter Password</label>
														</div>
														<div class="col-12 col-md-9">
															
																<input id="repassword" name="repassword" class="form-control" type="password" disabled>
															
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
			contact_address:{
				required: true
			},
			country:{
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
			 $( "#dialog-warn .dialog-text" ).html('If you confirm to change your profile information, It should be sign in again for update to system.');
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