<section>
                <div class="section__content section__content--p30">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>User Registration</strong>
                                    </div>
                                    <div class="card-body card-block">
										<div class="row">
											<div class="col-md-12">
											<div class="statistic__item" style="height:100%">
												<h2 class="number p-b-20">Please confirm your email</h2>
												<span class="desc p-b-20 normalcase">An email with a link to confirmation register email has been sent, Please follow the instructions in the email to confirm your email.</span>
												
												<div class="p-t-10">
															<a href="<?php echo site_url('account')?>" class="btn btn-primary btn-lg">Back</a>
												</div>
												
												<div class="icon">
													<i class="zmdi zmdi-account-o"></i>
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