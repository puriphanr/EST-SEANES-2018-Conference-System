<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<table width="100%" cellpadding="10">
  <tbody>
    <tr>
      <td colspan="2" bgcolor="#7ae05e" ><h2 style="text-align: right;background:#7ae05e;">Ergonomics Society of Thailand (EST)</h2></td>
    </tr>
    <tr>
      <td width="30%">&nbsp;</td>
      <td width="70%" align="right" style="text-align: right"><p>22/3 Borommaratchachonnani Road, Khwaeng Chim Phli, Taling Chan, Bangkok, Thailand 10170</p>
        <p>Mobile phone 097 084 2890; www.est.or.th; E-mail: ergo@est.or.th</p>
        <p>Tax ID Number: 0994000013540</p>
      <p>Reference: SEANES2018: U0018</p></td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: center" border="1"><h1>INVOICE</h1></td>
    </tr>
    <tr>
       <td align="left" width="50%" border="0">
            	
            	<p>
													<strong>Issued to: </strong> <span class="hilight-text"><?php echo $users['firstname']?> <?php echo $users['middlename']?> <?php echo $users['lastname']?></span>
												</p>
												
												<p class="invoice-address">
													
														<strong> Address: </strong>
														<?php echo $data['invoice_address']?>
													
												</p>
            </td>
            <td align="right"width="50%" border="0">
            	
            	<p class="text-right">
													<strong>Date Issued: <?php echo date('d F Y')?></strong>
												</p>
												<p class="text-right">
													<strong>No. <?php echo $reg_code ?>/<?php echo date('Y')?></strong>
												</p>
            </td>
	 </tr>
	 <tr>
	 <td colspan="2" cellpadding="0">
	 	<p class="m-b-20">PAYMENT INFORMATION</p>
										<table class="table table-borderless table-data3 table-normal" width="100%" cellpadding="10" border="1">
                                        <thead>
                                            <tr>
												<th width="70%" align="center" class="text-center" bgcolor="black" color="#fff">DESCRIPTION</th>
												<th width="10%" align="center" class="text-center" bgcolor="black" color="#fff">NO.</th>
												<th width="20%" align="center" class="text-center" bgcolor="black"color="#fff">AMOUNT ( <?php echo $data['is_th'] == 0 ? 'US$' : 'baht'?> )</th>
												
											</tr>
                                        </thead>
                                        <tbody>
											
                                            <tr>
												<td width="70%" align="left">SEANES2018 Conference Registration Fee</td>
												<td width="10%" align="center">1</td>
												<td width="20%" align="right">
													<?php echo number_format($fee ,2)?>
												</td>
											
											</tr>
											<?php if($data['payment_type'] == 2){ ?>
											<tr>
												<td width="70%" class="hilight-text" align="left"><font color="#0063be">Service Charge for Online Payment via Paypal</font></td>
												<td width="10%" align="center" class="text-center hilight-text">1</td>
												<td width="20%" align="right" class="text-right hilight-text">
												<font color="#0063be">15.00</font>
												</td>
											
											</tr>
											
											<?php } ?>
											
											<?php if(!empty($data['student_dinner']) && $data['student_dinner'] == 1){ ?>
												
												<?php if($data['is_th'] == 1){ ?>
											<tr>
												<td class="hilight-text">ค่าลงทะเบียนร่วมงานเลี้ยงและกิจกรรมเย็นวันที่ 13 ธันวาคม 2561 </td>
												<td class="text-center hilight-text" align="center">1</td>
												<td class="text-right hilight-text" align="right">
												800.00
												</td>
											
											</tr>
												<?php }else{ ?>
													<tr>
												<td class="hilight-text">Additional fee for a special dinner and activities on December 13, 2018</td>
												<td class="text-center hilight-text" align="center">1</td>
												<td class="text-right hilight-text" align="right">
												25.00
												</td>
											
											</tr>
												
												<?php } ?>
											
											<?php } ?>
											<tr>
												<td width="70%" align="left">The 5th International Conference of Southeast Asian Network of Ergonomics Societies (SEANES2018)</td>
												<td width="10%"></td>
												<td width="20%"></td>
											
											</tr>
											<tr>
												<td width="70%"align="left">12 - 14 December 2018, Windsor Suites & Convention Bangkok, THAILAND</td>
												<td width="10%"></td>
												<td width="20%"></td>
											
											</tr>
											<tr>
												<td width="70%" align="left">
													<div><strong>PAYMENT METHOD</strong></div>
													<?php if($data['payment_type'] == 1){ ?>
													
														<p>Bank transfer (in <?php echo $data['is_th'] == 0 ? 'US$' : 'baht'?>)</p>
														<p>Bank Name: Bangkok Bank, Thailand</p>
														<p>A/C Type: Savings</p>
														<p>Branch: Thammasat University Rangsit Campus</p>
															<p>	A/C Name: ERGONOMICS SOCIETY OF THAILAND </p>
																<p>Swift Code: BKKBTHBK  </p>
																<p>A/C No.: 091-0-22408-8</p>
														<p>Bank Address: Bangkok Bank Public Company Limited, Thammasat University Rangsit Campus  99/18 Phaholyothin Road, Klong 1, Klongluang, Pathum Thani, THAILAND 12120</p>
													
													<?php } else { ?>
													<div class="m-b-10">Online payment via Paypal or Credit Card (This will have US$ 15 for service charge)</div>
													<div>Use the follwing name <strong>"paypal.me/SEANES2018"</strong> or <strong>ergo@est.or.th for making payment</strong></div>
													<?php } ?>
												</td>
												<td width="10%"></td>
												<td width="20%"></td>
											
											</tr>
											<tr>
											
												<td colspan="3" align="right">
												
													<span style="color:red;font-weight:bold">Important Note: Due Date for the payment is on  <?php echo date('F d, Y',strtotime($due_date))?></span>
												</td>
											</tr>
											<tr>
											
												<td colspan="2" align="right">
													Sub total
												</td>
												<td align="right">
													<span class="hilight-text bold"><font color="#0063be"><?php echo number_format($subtotal ,2)?></font></span>
												</td>
											</tr>
											<tr>
											
												<td colspan="2" align="right">
													With holding tax 3% on Payment in Thailand
												</td>
												<td align="right">
													0.00
												</td>
											</tr>
											<tr>
											
												<td colspan="2" align="right">
													Total
												</td>
												<td align="right">
													<span class="hilight-text bold"><strong><font color="#0063be"><?php echo number_format($subtotal ,2)?></font></strong></span>
												</td>
											</tr>
											<tr>
											
												<td colspan="3" align="right">
													<span class="hilight-text"><font color="#0063be">(<?php echo ucfirst(strtolower($subtotal_word))?>)</font></span>
												</td>
											</tr>
										</tbody>
									</table>
	 
	  
	  </td>
    </tr>
  </tbody>
</table>
</body>
</html>