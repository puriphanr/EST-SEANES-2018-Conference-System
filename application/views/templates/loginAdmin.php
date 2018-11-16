<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Online Submission and Review</title>
	<link href="<?php echo base_url()?>images/favicon.ico" rel="shortcut icon" />
    <!-- Fontfaces CSS-->
    <link href="<?php echo base_url()?>assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="<?php echo base_url()?>assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="<?php echo base_url()?>assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>assets/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>assets/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="<?php echo base_url()?>assets/css/theme.css?v=<?php echo time()?>" rel="stylesheet" media="all">
	 <!-- Jquery JS-->
    <script src="<?php echo base_url()?>assets/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="<?php echo base_url()?>assets/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>
	<!-- Jquery UI-->
	<script src="<?php echo base_url()?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
	<link href="<?php echo base_url()?>assets/vendor/jquery-ui/jquery-ui.min.css" rel="stylesheet" media="all">
	<link href="<?php echo base_url()?>assets/vendor/jquery-ui-flat-theme-master/jquery-ui.css" rel="stylesheet" media="all">
	<!-- Jquery Validation-->
	<script src="<?php echo base_url()?>assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
	<!-- Custom JS-->
	<script src="<?php echo base_url()?>assets/js/custom.js?v=<?php echo time()?>"></script>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                           <div class="h5">
                                Online Submission and Review
                            </div>
                        </div>
                        <div class="login-form">
                            <form id="siginForm" action="<?php echo site_url('account/adminSignin')?>" method="post">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                                </div>
                               
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                            
                            </form>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
 
	<div class="dialog" style="display:none;" id="dialog-wait">
		<div class="row dialog-body">
			<div class="dialog-icon col-xs-2">
				<img src="<?php echo base_url()?>images/loading.gif" />
			</div>
			<div class="dialog-text col-xs-10">Please Wait</div>
		</div>
	</div>

	<div class="dialog" style="display:none;" id="dialog-err" title="Error">
		<div class="row dialog-body">
			<div class="dialog-icon col-md-2">
				<img src="<?php echo base_url()?>images/error.png" />
			</div>
			<div class="dialog-text  col-md-10"></div>
		</div>
	</div>
	
	<div class="dialog" style="display:none;" id="dialog-warn" title="Message">
		<div class="row dialog-body">
			<div class="dialog-icon col-md-2">
				<img src="<?php echo base_url()?>images/warning.png" />
			</div>
			<div class="dialog-text  col-md-10"></div>
		</div>
	</div>
    <!-- Vendor JS-->
    <script src="<?php echo base_url()?>assets/vendor/slick/slick.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendor/wow/wow.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendor/animsition/animsition.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendor/counter-up/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo base_url()?>assets/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendor/select2/select2.min.js"></script>

    <!-- Main JS-->
    <script src="<?php echo base_url()?>assets/js/main.js"></script>
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

</body>

</html>
<!-- end document-->