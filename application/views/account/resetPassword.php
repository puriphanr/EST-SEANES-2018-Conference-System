<section>
                <div class="section__content section__content--p30">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Reset password</strong>
                                    </div>
                                    <div class="card-body card-block">
										<div class="row">
											<div class="col-md-12">
											<div class="statistic__item" style="height:100%">
												<h2 class="number p-b-20">Reset my password</h2>
												<?php if($this->uri->segment(3)  == 1) { ?>
												<span class="desc p-b-20">Please choose a new password. </span>
												<form class="p-t-20" action="<?php echo site_url('account/resetPassword/2')?>" id="resetForm" method="post">
													<input type="hidden" name="token" value="<?php echo $this->uri->segment(4)?>" />
													<div class="form-group">
														<label>New Password</label>
														<input class="au-input au-input--full" name="password" id="password" type="password">
													</div>
													
													<div class="form-group">
														<label>Re-enter Password</label>
														<input class="au-input au-input--full" name="repassword" id="repassword" type="password">
													</div>
													<div class="form-actions form-group p-t-10">
															<button type="submit" class="btn btn-primary btn-lg">Send</button>
															<button type="reset" class="btn btn-secondary btn-lg">Clear</button>
													</div>
												</form>
												<?php } else { ?>
												<span class="desc p-b-20 normalcase">Reset password successfully. Now you can sign in with new credentials by click button below for go to sign in page.</span>
												<div class="m-t-20">
															<a href="<?php echo site_url('account')?>" class="btn btn-primary btn-lg">Sign In</a>
												</div>
												<?php } ?>
												<div class="icon">
													<i class="zmdi zmdi-key"></i>
												</div>
											</div>
											</div>
											
										</div>
                                    </div>
                                   
                                </div>
                           
                            </div>
                            
                        </div>
                    </div>
                </div>
</section>
<?php if($this->uri->segment(3)  == 1) { ?>
<script type="text/javascript">
$(function(){
	$('#resetForm').validate({
		rules: {
            password: {
                required: true
            },
			 repassword: {
                required: true,
				equalTo : '#password'
            }
			
        },
        submitHandler: function (form) { 
            ajaxPostSubmit("#resetForm");
            return false; 
        }
	 });
})
</script>
<?php } ?>