<section>
                <div class="section__content section__content--p30">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Forget email or password</strong>
                                    </div>
                                    <div class="card-body card-block">
										<div class="row">
											<div class="col-md-12">
											<div class="statistic__item" style="height:100%">
												<h2 class="number p-b-20">Reset my password</h2>
												<span class="desc p-b-20 normalcase">Please enter the email address you used when registering for the site. We will send you an email with instructions to reset your password. </span>
												<form class="p-t-20" action="<?php echo site_url('account/doForget/1')?>" id="forgetForm" method="post">
												
													<div class="form-group">
														<label>Email Address</label>
														<input class="au-input au-input--full" name="email" id="signin-email" placeholder="Email" type="text">
													</div>
													<div class="form-actions form-group p-t-10">
															<button type="submit" class="btn btn-primary btn-lg">Send</button>
															<button type="reset" class="btn btn-secondary btn-lg">Clear</button>
													</div>
												</form>
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
<script type="text/javascript">
$(function(){
	$('#forgetForm').validate({
		rules: {
            email: {
                required: true,
                email: true
            }
        },
        submitHandler: function (form) { 
            ajaxPostSubmit("#forgetForm");
            return false; 
        }
	 });
})
</script>