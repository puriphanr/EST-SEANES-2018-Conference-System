
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4 place-inline">
								Registration
								
                            </h1>
							
                        </div> 
						
						<hr class="line-seprate">
							
                    </div>
                </div>
            </section>
			
			<section class="p-t-20">
                <div class="container">
                    <div class="row">
						<div class="col-md-12">
								<div class="card">
								 <div class="card-header"><strong> Conference Information </strong></div>
                                    <div class="card-body">
										<table class="table table-top-campaign">
                                            <tbody>
												<tr>
                                                    <td width="40%">Participant Type</td>
                                                    <td  width="60%" class="text-left">
													<strong>
													<?php if($users['users_role'] == 3){ ?>
														Participant (Non-author)
													
													<?php } else { ?>
													
														Author
													<?php } ?>
													</strong>
													</td>
                                                </tr>
												<?php if(!empty($data['paper'])){ ?>
                                                <tr>
                                                    <td>Paper</td>
                                                    <td class="text-left">
														<?php foreach($paper as $key=>$row){ ?>
															<div class="m-b-5">[<?php echo $row['paper_code']?>] <?php echo $row['title']?> </div>
														<?php } ?>
													</td>
                                                </tr>
												<?php } ?>
                                                <tr>
                                                    <td>Conference Type</td>
                                                    <td class="text-left">
													<?php 
													if($data['is_th'] == 0){
														if($data['conference_fee'] == 1){ 
															echo 'SEANES member of Developing Countries';
														}
														elseif($data['conference_fee'] == 2){
															echo 'IEA Federated Societies';
														}
														elseif($data['conference_fee'] == 3){
															echo 'Others Participants';
														}
														else{
															echo 'Students';
														}
													}
													else{
														if($data['conference_fee'] == 1){ 
															echo 'บุคคลทั่วไป';
														}
														elseif($data['conference_fee'] == 2){
															echo 'สมาชิกสมาคมการยศาสตร์ไทย / สมาชิกหน่วยงานเครือข่าย';
														}
														elseif($data['conference_fee'] == 3){
															echo 'นักศึกษาปริญญาโท-เอก';
														}
														else{
															echo 'นักศึกษาปริญญาตรี';
														}
														
													}
													?>
													
													
													</td>
                                                </tr>
												<tr>
                                                    <td>Payment Method</td>
                                                    <td class="text-left">
													<?php 
													if($data['payment_type'] == 1){ 
														echo 'Bank transfer';
													}else{
														echo 'Online payment via Paypal or Credit Card';
													}
													?>
													</td>
                                                </tr>
											
												<tr>
                                                    <td>Registration for the pre-conference special event</td>
                                                    <td class="text-left">
													<?php 
													if($data['pre_conference'] == 1){ 
														echo 'Case I: Ergonomics in Manufacturing.';
													}
													elseif($data['pre_conference'] == 2){
														echo 'Case II: Ergonomics in Office.';
													}
													else{
														echo 'No, I will not join the events.';
													}
													?>
													</td>
                                                </tr>
												
												<tr>
                                                    <td>Registration for Welcome Dinner</td>
                                                    <td class="text-left">
													<?php 
													if($data['welcome_dinner'] == 1){ 
														echo 'I would like to join Welcome Dinner';
													}else{
														echo 'I would not join Welcome Dinner';
													}
													?>
													</td>
                                                </tr>
												
												<tr>
                                                    <td>Dietary Preference</td>
                                                    <td class="text-left">
													<?php 
													if($data['dietary'] == 1){ 
														echo 'No specific preference';
													}
													elseif($data['dietary'] == 2){
														echo 'Vegetarian';
													}
													elseif($data['dietary'] == 3){
														echo 'Halal food';
													}
													else{
														echo 'Other ('.$data['dietary_other'].')';
													}
													?>
													</td>
                                                </tr>
												
                                            </tbody>
                                        </table>
									</div>
								</div>
							</div>
						</div>
					</div>
			
		</section>

 <section class="p-t-20">
                <div class="container">
                    <div class="row">
						<div class="col-md-12">
						<div class="card">
                                   <div class="card-header"><strong> Invoice Information </strong></div>      
                         <div class="card-body">
									
							<form action="<?php echo site_url('registration/saveRegistration')?>" method="POST" >
								<?php 
								if(!empty($data['paper'])){
								foreach($data['paper'] as $row){ ?>
								<input type="hidden" name="paper[]" value="<?php echo $row ?>" />
								
								<?php } } ?>
								<input type="hidden" name="conference_type" value="<?php echo $data['conference_fee']?>" />
								<input type="hidden" name="payment_type" value="<?php echo $data['payment_type']?>" />
								<input type="hidden" name="pre_conference" value="<?php echo $data['pre_conference']?>" />
								<input type="hidden" name="welcome_dinner" value="<?php echo $data['welcome_dinner']?>" />
								<input type="hidden" name="dietary" value="<?php echo $data['dietary']?>" />
								<?php if($data['dietary'] == 4){ ?>
								<input type="hidden" name="dietary_other" value="<?php echo $data['dietary_other']?>" />
								<?php } ?>
								
								<input type="hidden" name="is_th" value="<?php echo $data['is_th']?>" />
								<?php if(!empty($data['student_dinner'])){ ?>
								<input type="hidden" name="student_dinner" value="<?php echo $data['student_dinner']?>" />
								<?php } else { ?>
								<input type="hidden" name="student_dinner" value="0" />
								<?php } ?>
								<div class="invoice-template">
									<div class="org-header"><h2>Ergonomics Society of Thailand (EST)</h2></div>
									<div class="org-detail">
										<div class="row">
											<div class="col-sm-2">
												<img src="<?php echo base_url()?>assets/images/EST-Logo02.png" class="img-responsive" />
											</div>
											<div class="col-sm-10">
											
												<p>22/3 Borommaratchachonnani Road, Khwaeng Chim Phli, Taling Chan, Bangkok, Thailand 10170</p>
												<p>Mobile phone 097 084 2890; www.est.or.th; E-mail: ergo@est.or.th</p>
												<p>Tax ID Number: 0994000013540</p>
												<p>Reference: SEANES2018: U<?php echo str_pad($users['users_id'], 4 , 0 , STR_PAD_LEFT) ?> </p>
											</div>
										</div>
									
									</div>
									
									<div class="invoice-title">
										<h1>INVOICE</h1>
									</div>
									
									<div class="invoice-header">
										<div class="row">
											<div class="col-sm-8">
												<p class="issue_to">
													<strong>Issued to: </strong> <span class="hilight-text"><?php echo $users['firstname']?> <?php echo $users['middlename']?> <?php echo $users['lastname']?>
												</p>
												
												<p class="invoice-address">
													<div class="form-group">
														<label class="bold"> Address: </label>
														<textarea class="form-control" name="invoice_address" required id="invoice_address" rows="4"><?php echo $users['contact_address']?></textarea>
													</div>
												</p>
											</div>
											<div class="col-sm-4">
												<p class="date_issue text-right">
													<strong>Date Issued: <?php echo date('d F Y')?>
												</p>
											</div>
										</div>
									</div>
									
									<div class="invoice-detail">
										<h5 class="m-b-20">PAYMENT INFORMATION</h5>
										<table class="table table-borderless table-data3 table-normal">
                                        <thead>
                                            <tr>
												<th width="70%" class="text-center">DESCRIPTION</th>
												<th width="10%" class="text-center">NO.</th>
												<th width="20%"class="text-center">AMOUNT ( <?php echo $data['is_th'] == 0 ? 'US$' : 'บาท' ?> )</th>
												
											</tr>
                                        </thead>
                                        <tbody>
											
                                            <tr>
												<td>SEANES2018 Conference Registration Fee</td>
												<td class="text-center">1</td>
												<td class="text-right">
													<?php echo number_format($fee ,2)?>
												</td>
											
											</tr>
											<?php if($data['payment_type'] == 2){ ?>
											<tr>
												<td class="hilight-text">Service Charge for Online Payment via Paypal</td>
												<td class="text-center hilight-text">1</td>
												<td class="text-right hilight-text">
												15.00
												</td>
											
											</tr>
											
											<?php } ?>
											
												<?php if(!empty($data['student_dinner']) && $data['student_dinner'] == 1){ ?>
												
												<?php if($data['is_th'] == 1){ ?>
											<tr>
												<td class="hilight-text">ค่าลงทะเบียนร่วมงานเลี้ยงและกิจกรรมเย็นวันที่ 13 ธันวาคม 2561 </td>
												<td class="text-center hilight-text">1</td>
												<td class="text-right hilight-text">
												800.00
												</td>
											
											</tr>
												<?php }else{ ?>
													<tr>
												<td class="hilight-text">Additional fee for a special dinner and activities on December 13, 2018</td>
												<td class="text-center hilight-text">1</td>
												<td class="text-right hilight-text">
												25.00
												</td>
											
											</tr>
												
												<?php } ?>
											
											<?php } ?>
											<tr>
												<td>The 5th International Conference of Southeast Asian Network of Ergonomics Societies (SEANES2018)</td>
												<td></td>
												<td></td>
											
											</tr>
											<tr>
												<td>12 - 14 December 2018, Windsor Suites & Convention Bangkok, THAILAND</td>
												<td></td>
												<td></td>
											
											</tr>
											<tr>
												<td>
													<div class="m-b-10"><strong>PAYMENT METHOD</strong></div>
													<?php if($data['payment_type'] == 1){ ?>
													<div class="m-b-10">Bank transfer (in <?php echo $data['is_th'] == 0 ? 'US$' : 'baht'?>)</div>
													<div>
														<p>Bank Name: Bangkok Bank, Thailand</p>
														<p>A/C Type: Savings</p>
														<p>Branch: Thammasat University Rangsit Campus</p>
															<p>	A/C Name: ERGONOMICS SOCIETY OF THAILAND </p>
																<p>Swift Code: BKKBTHBK  </p>
																<p>A/C No.: 091-0-22408-8</p>
														<p>Bank Address: Bangkok Bank Public Company Limited, Thammasat University Rangsit Campus  99/18 Phaholyothin Road, Klong 1, Klongluang, Pathum Thani, THAILAND 12120</p>
													</div>
													<?php } else { ?>
													<div class="m-b-10">Online payment via Paypal or Credit Card (This will have US$ 15 for service charge)</div>
													<div>Use the follwing name <strong>"paypal.me/SEANES2018"</strong> or <strong>ergo@est.or.th for making payment</strong></div>
													<?php } ?>
												</td>
												<td></td>
												<td></td>
											
											</tr>
											<tr>
											
												<td colspan="3" class="text-right">
													<span style="color:red;font-weight:bold">Important Note: Due Date for the payment is on <?php echo date('F d, Y',strtotime($due_date))?></span>
												</td>
											</tr>
											<tr>
											
												<td colspan="2" class="text-right">
													Sub total
												</td>
												<td>
													<span class="hilight-text bold"><?php echo number_format($subtotal ,2)?></span>
												</td>
											</tr>
											<tr>
											
												<td colspan="2" class="text-right">
													With holding tax 3% on Payment in Thailand
												</td>
												<td>
													0.00
												</td>
											</tr>
											<tr>
											
												<td colspan="2" class="text-right">
													Total
												</td>
												<td>
													<span class="hilight-text bold"><strong><?php echo number_format($subtotal ,2)?></strong></span>
												</td>
											</tr>
											<tr>
											
												<td colspan="3" class="text-right">
													<span class="hilight-text">(<?php echo ucfirst(strtolower($subtotal_word))?>)</span>
												</td>
											</tr>
										</tbody>
									</table>
									</div>
									<div class="form-actions form-group text-center p-t-20">
															<button type="submit" class="btn btn-primary btn-lg">Confirm</button>
															<button type="button" onclick="window.location='<?php echo $data['is_th'] == 0 ? site_url('registration/addRegistration') : site_url('registration/addRegistration/th') ?>'" class="btn btn-secondary btn-lg">Cancel</button>
											</div>
								
								</div>
							</form>
									
						</div>
						</div>
						
						</div>
					</div>
				</div>
</section>
<script>
$(function(){
	$('form').validate({
		 submitHandler: function (form) { 
            ajaxPostConfirmSubmit('form' , 'Are you sure to submit this information.');
            return false; 
        }
		
	});
	
})

</script>