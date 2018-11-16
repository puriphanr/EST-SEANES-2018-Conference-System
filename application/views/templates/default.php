<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if($this->session->userdata('is_logged_in')){
	$sess_users = $this->session->userdata('is_logged_in');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Title Page-->
    <title>Online Submission ,Review and Registration</title>
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
	<script src="<?php echo base_url()?>assets/vendor/select2/select2.min.js"></script>
	<script src="<?php echo base_url()?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
	<link href="<?php echo base_url()?>assets/vendor/jquery-ui/jquery-ui.min.css" rel="stylesheet" media="all">
	<link href="<?php echo base_url()?>assets/vendor/jquery-ui-flat-theme-master/jquery-ui.css" rel="stylesheet" media="all">
	<!-- Jquery Validation-->
	<script src="<?php echo base_url()?>assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<!-- Custom JS-->
	<script src="<?php echo base_url()?>assets/js/custom.js?v=<?php echo time()?>"></script>
</head>
<body class="animsition">
<div class="page-wrapper">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop3 d-none d-lg-block">
            <div class="section__content section__content--p35">
                <div class="header3-wrap">
                    <div class="header__logo">
                        <a href="<?php echo site_url('home')?>">
                            <i class="fas fa-file-alt"></i> Online Submission ,Review and Registration
                        </a>
                    </div>
			
                    <div class="header__navbar">
                        <ul class="list-unstyled">
                            <?php if(in_array($sess_users['users_role'] , unserialize(USER_ROLE_AUTHOR) )){ ?>
                            <li>
                                <a href="<?php echo site_url('submission')?>">
                                    <i class="fas fa-file"></i>
                                    <span class="bot-line"></span>Paper Submission</a>
                            </li>
							<?php } ?>
							<?php 
							if(in_array($sess_users['users_role'] , unserialize(USER_ROLE_TOP) )){ ?>
						
							<li>
                                <a href="<?php echo site_url('review')?>">
                                    <i class="fas fa-search"></i>
                                    <span class="bot-line"></span>Review</a>
                            </li>
						<?php } ?>
						
						 <li>
                                <a href="<?php echo site_url('registration')?>">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span class="bot-line"></span>Registration</a>
                            </li>
                            
                        </ul>
                    </div>
					
                    <div class="header__tool">
                     
                        <div class="account-wrap">
                            <div class="account-item account-item--style2 clearfix js-item-menu">
                                <div class="image">
                                    <img src="<?php echo base_url()?>assets/images/icon/avatar.png" />
                                </div>
                                <div class="content">
                                    <a class="js-acc-btn" href="#"><?php echo $sess_users['firstname'].' '.$sess_users['lastname']?></a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="info clearfix">
                                        <div class="image">
                                            <a href="#">
                                                <img src="<?php echo base_url()?>assets/images/icon/avatar.png" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h5 class="name">
                                                <a href="#"><?php echo $sess_users['firstname'].' '.$sess_users['lastname']?></a>
                                            </h5>
                                            <span class="email"><?php echo $sess_users['email']?></span>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="<?php echo site_url('account/profile')?>">
                                                <i class="zmdi zmdi-account"></i>Profile/Edit</a>
                                        </div>
                                        
                                    </div>
                                    <div class="account-dropdown__footer">
                                        <a href="<?php echo site_url('account/logout')?>">
                                            <i class="zmdi zmdi-power"></i>Sign out</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
                </div>
            </div>
        </header>
        <!-- END HEADER DESKTOP-->

        <!-- HEADER MOBILE-->
        <header class="header-mobile header-mobile-2 d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html" href="<?php echo site_url('home')?>">
                           <i class="fas fa-file-alt"></i> Online Submission and Review
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
		
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                       <?php if(in_array($sess_users['users_role'] , unserialize(USER_ROLE_AUTHOR) )){ ?>
							<li>
                                <a href="<?php echo site_url('submission')?>">
                                    <i class="fas fa-file"></i>
                                    <span class="bot-line"></span>Paper Submission</a>
                            </li>
					   <?php } ?>	
						<?php if(in_array($sess_users['users_role'] , unserialize(USER_ROLE_TOP) )){ ?>
						
							<li>
                                <a href="<?php echo site_url('review')?>">
                                    <i class="fas fa-file"></i>
                                    <span class="bot-line"></span>Review</a>
                            </li>
						<?php } ?>
						
						 <li>
                                <a href="<?php echo site_url('registration')?>">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span class="bot-line"></span>Registration</a>
                            </li>
                            
                    </ul>
                </div>
            </nav>
			
        </header>
        <div class="sub-header-mobile-2 d-block d-lg-none">
            <div class="header__tool">
               
                <div class="account-wrap">
                    <div class="account-item account-item--style2 clearfix js-item-menu">
                        <div class="image">
                            <img src="<?php echo base_url()?>assets/images/icon/avatar.png" />
                        </div>
                        <div class="content">
                            <a class="js-acc-btn" href="#"><?php echo $sess_users['firstname'].' '.$sess_users['lastname']?></a>
                        </div>
                        <div class="account-dropdown js-dropdown">
                            <div class="info clearfix">
                                <div class="image">
                                    <a href="#">
                                        <img src="<?php echo base_url()?>assets/images/icon/avatar.png" />
                                    </a>
                                </div>
                                <div class="content">
                                    <h5 class="name">
                                        <a href="#"><?php echo $sess_users['firstname'].' '.$sess_users['lastname']?></a>
                                    </h5>
                                    <span class="email"><?php echo $sess_users['email']?></span>
                                </div>
                            </div>
                            <div class="account-dropdown__body">
                                <div class="account-dropdown__item">
                                    <a href="<?php echo site_url('account/profile')?>">
                                        <i class="zmdi zmdi-account"></i>Profile/Edit</a>
                                </div>
                               
                            </div>
                            <div class="account-dropdown__footer">
                                <a href="<?php echo site_url('account/logout')?>">
                                    <i class="zmdi zmdi-power"></i>Sign out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HEADER MOBILE -->

        <!-- PAGE CONTENT-->
        <div class="page-content--bgf7">
		
            <!-- BREADCRUMB-->
            <section class="au-breadcrumb2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="au-breadcrumb-content">
                                <div class="au-breadcrumb-left">
                                 
                                    <ul class="list-unstyled list-inline au-breadcrumb__list">
									<?php 
									$i = 1;
									foreach($breadcrumbs as $key=>$row){ ?>
                                        <li class="list-inline-item <?php echo $i == count($breadcrumbs) ? 'active' : NULL ?>">
                                            <a href="<?php echo $row?>"><?php echo $key?></a>
                                        </li>
										<?php if($i < count($breadcrumbs)){ ?>
                                        <li class="list-inline-item seprate">
                                            <span>/</span>
                                        </li>
										<?php } ?>
									<?php 
									$i++;
									} ?>
                                       
                                    </ul>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END BREADCRUMB-->
			
        
			
			{page_content}

            <!-- COPYRIGHT-->
            <section class="p-t-60 p-b-20">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © 2018 by Ergonomics Society of Thailand</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END COPYRIGHT-->
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
    

    <!-- Main JS-->
    <script src="<?php echo base_url()?>assets/js/main.js"></script>
</body>
</html>
<!-- end document-->