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
            <br><div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 600; color: #374550;">Dear <?php echo $reviewer['firstname']?> <?php echo $reviewer['middlename']?> <?php echo $reviewer['lastname']?></div>
<br><div class="body-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; text-align: left; color: black;" align="left">
 <p>You receive this email because you have registered as a scientific committee of The 5th International Conference of Southeast Asian Network of Ergonomics Societies (SEANES 2018).</p>
 <p>We believe that you would serve as an excellent reviewer of the following manuscript. </p>
 
 <p style="font-weight:bold">Title : <?php echo $paper['title'] ?></p>
 <p>The research manuscript has been submitted to The 5th International Conference of Southeast Asian Network of Ergonomics Societies (SEANES 2018). </p>
 <p>We hope that you will consider this important task for us. We would like to receive your review and comments by <?php echo $due_date ?></p>

 <p style="font-weight:bold;color:red"> IMPORTANCE: If you accept to review this manuscript please <a href="<?php echo site_url('review')?>" target="_blank">click here</a>
 and sign in to the reviewing page. And then click "ACCEPT"
</p>
	<p>Thank you for considering this invitation. It you have any enquiry pleased do not hesitate to contact us at <a href="mailto:SEANES2018@est.or.th" target="_blank">SEANES2018@est.or.th</a>
</p>
<br>
<p><a href="<?php echo site_url('account/downloadUserGuide/2')?>">Click here to download "User Guide for Reviewer"</a></p>
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