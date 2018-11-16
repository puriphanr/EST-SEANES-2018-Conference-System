<section>
                <div class="section__content section__content--p30">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>User Sign in</strong>
                                    </div>
                                    <div class="card-body card-block ">
									<div class="row">
										<div class="col-md-7">
										<div class="statistic__item" style="height:100%; background:#dbf7d9">
											<h2 class="number">SEANES 2018</h2>
											<span class="desc">The 5th International Conference of Southeast Asian Network of Ergonomics Societies</span>
											<p class="p-t-20">If you have got an account, you can use it to log on. </p>

											<p class="p-t-20">If you have forgotten your login credentials, click the “Forget password?”.</p>
											<p class="p-t-20">If you don't have an account, please sign up.</p>
											
											<div class="h6 p-t-30 row" >
												<div class="col-md-12 m-b-10">
													<a href="<?php echo site_url('account/downloadUserGuide/1') ?>" target="_blank" style="text-decoration:underline">User Guide for Author</a>
												</div>
												<div class="col-md-12 m-b-10">
													<a href="<?php echo site_url('account/downloadUserGuide/2') ?>" target="_blank" style="text-decoration:underline">User Guide for Reviewer</a>
												</div>
												<div class="col-md-12 m-b-10">
													<a href="<?php echo site_url('account/downloadUserGuide/3') ?>" target="_blank" style="text-decoration:underline">Registration User Guide for non-author</a>
												</div>
												<div class="col-md-12">
													<a href="<?php echo site_url('account/downloadUserGuide/4') ?>" target="_blank" style="text-decoration:underline">Registration User Guide for author</a>
												</div>
											</div>
											<div class="p-t-10" style="color: #fa4251">After signing up SEANES2018 online submission and review system you will receive our auto email to verify your registration, sometime the auto-verified email will be filtered in SPAM/TRASH box of your email system because of the email system policy.</div>
											<div class="icon">
												<i class="zmdi zmdi-account-o"></i>
											</div>
										</div>
										</div>
                                        <div class="login-form col-md-5">
											<form id="siginForm" action="<?php echo site_url('account/signin')?>" method="post">
												<div class="form-group">
													<label>Email Address</label>
													<input class="au-input au-input--full" name="email" id="signin-email" placeholder="Email" type="text">
												</div>
												<div class="form-group">
													<label>Password</label>
													<input class="au-input au-input--full" name="password" id="signin-password" placeholder="Password" type="password">
												</div>
												<div class="login-checkbox">
													<label>
														<input name="remember" type="checkbox">Remember Me
													</label>
													<label>
														<a href="<?php echo site_url('account/forget')?>">Forget Password?</a>
													</label>
												</div>
												<button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
												
											</form>
											<div class="register-link">
												<p>
													Don't you have account?
													<a href="<?php echo site_url('account/signupForm')?>" id="go-signup">Sign Up Click Here</a>
												</p>
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
	$('#siginForm').validate({
		rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        submitHandler: function (form) { 
            ajaxPostSubmit("#siginForm");
            return false; 
        }
	 });
})
</script>