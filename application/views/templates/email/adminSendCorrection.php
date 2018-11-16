<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="format-detection" content="telephone=no">
<title>SEANES2018</title>
</head>
<body style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; margin: 0; padding: 0;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<style type="text/css">
@media screen and (max-width: 599px) {
  table[class="force-row"] {
    width: 100% !important; max-width: 100% !important;
  }
  table[class="container"] {
    width: 100% !important; max-width: 100% !important;
  }
}
@media screen and (max-width: 400px) {
  td[class*="container-padding"] {
    padding-left: 12px !important; padding-right: 12px !important;
  }
}
</style>

<!-- 100% background wrapper (grey background) -->
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" style="border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tr>
<td align="center" valign="top" style="border-collapse: collapse;">

      <br>
	  <!-- 600px container (white background) -->
	  <table border="0" width="100%" cellpadding="0" cellspacing="0" class="container" style="width: 100%; max-width: 100%; border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
<tr>
<td class="container-padding content" align="left" style="border-collapse: collapse; background: #ffffff; padding: 12px 24px;" bgcolor="#ffffff">
            <br><div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 600; color: #374550;">Dear <?php echo $users['firstname']?> <?php echo $users['middlename']?> <?php echo $users['lastname']?></div>
<br><div class="body-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: left; color: black;" align="left">
 <p>You receive this email because you have submitted your research works to SEANES2018 Conference in Bangkok, Thailand during 12-14 December 2018.</p>
 <p>The following is your manuscript No. and title.</p>
 
 <p style="font-weight:bold"><?php echo $paper['paper_code']?> <strong>Title :</strong> <?php echo $paper['title'] ?></p>
 <p>We would like to inform that your manuscript has been reviewed completely. You can see the reviewing results and reviewers' comments by signing into the reviewing system. </p>
<br>
 <p><a href="<?php echo site_url()?>" target="_blank">Click here</a> to log in to the reviewing system. If you are unable to open the sign in page, please use the following URL [<?php echo site_url()?>] instead.</p>
<br>

<p>
To log in the system, the username is your email. If you forget the last password, please select <span style="color:red"> forget password"</span> at the log in page. Then you will be able to reset and request a new password. The system will automatically send you a new password within 5 minutes. If you haven't received any email after resetting the password, please firstly recheck the email in the trash/junk mailbox.  
</p>

<p><strong>Please correct your manuscript with the highlight where you make the corrections. </strong> </p>
<p>Resubmit the revised manuscript to the reviewing system by <strong><?php echo $revise_due_date ?></p>

<p>Thank you so much for your contribution to SEANES2018</p>
<p>We wish you will succeed to resubmit the revised manuscript as soon. </p>
<p>
You can find an update of SEANES2018 schedule by <a href="http://www.est.or.th/SEANES2018/index.php/schedule" target="_blank">click here.</a>
</p>
<br>

<p>Best Regards,</p>
<br>
The 5th International Conference of Southeast Asian Network of Ergonomics Societies (SEANES 2018)
<?php echo EMAIL_SENDER?>
</div>

</td>
 </tr>

</table>
<!--/600px container -->
</td>
  </tr></table>
<!--/100% background wrapper-->
</body>
</html>