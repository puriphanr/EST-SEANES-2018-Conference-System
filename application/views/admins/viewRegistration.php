 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4 place-inline">
								Registration
								
                            </h1>
							
                        </div> 
						<div class="col-md-6 text-right">
							
											<button onclick ="window.location='<?php echo site_url('adminRegistration')?>'" type="button" class="btn btn-secondary">
												<i class="zmdi zmdi-arrow-left"></i> Back
											</button>
							
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
                                                    <td width="80%" class="text-left">
													<strong>
													<?php if($users['users_role'] == 3){ ?>
														Participant (Non-author)
													
													<?php } else { ?>
													
														Author
													<?php } ?>
													</strong>
													</td>
                                                </tr>
												<?php if(!empty($paper)){ ?>
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
														if($data['conference_type'] == 1){ 
															echo 'SEANES member of Developing Countries';
														}
														elseif($data['conference_type'] == 2){
															echo 'IEA Federated Societies';
														}
														elseif($data['conference_type'] == 3){
															echo 'Others Participants';
														}
														else{
															echo 'Students';
														}
													}
													else{
														if($data['conference_type'] == 1){ 
															echo 'บุคคลทั่วไป';
														}
														elseif($data['conference_type'] == 2){
															echo 'สมาชิกสมาคมการยศาสตร์ไทย / สมาชิกหน่วยงานเครือข่าย';
														}
														elseif($data['conference_type'] == 3){
															echo 'นักศึกษาปริญญาโท-เอก';
														}
														else{
															echo 'นักศึกษาปริญญาตรี';
														}
														
													}
													?>
													
													<?php 
													if($data['price_type'] == 1){ 
														echo '(Early Bird Before Nov 10,2018)';
													}
													elseif($data['price_type'] == 2){
														echo '(Nov 11-30, 2018)';
													}
													else{
														echo '(Late)';
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
												
												<?php if($data['payment_type'] == 1){ ?>
												
												<tr>
                                                    <td>Pay Slip</td>
                                                    <td class="text-left">
													  <div class="form-group row">
							
												<div class="col-md-10">
														<form  id="pay_slip_input" action="<?php echo site_url('registration/uploadSlip')?>" method="POST" class="form-horizontal" <?php echo $data['pay_slip'] != "" ? 'style="display:none"' : NULL ?>>	
														<input type="hidden" name="reg_id" value="<?php echo $data['reg_id']?>" />
															<div class="input-group input-file" name="pay_slip"  >
																
																	
																	<input type="text" class="form-control" />
																	<span class="input-group-btn">
																		<button class="btn btn-success btn-choose" type="button">Choose</button>
																	</span>
																	
																
															</div><p class="text-help">File type image only</p>
															<button class="btn btn-primary m-t-10" type="submit">Upload</button>
														</form>
														<?php if($data['pay_slip'] != ""){ ?>
														<div class="card fileInfo" id="pay_slip_uploaded">
															  <div class="card-body">
																<div class="row">
																	<div class="col-md-2">
																		<div class="h1"><i class="zmdi zmdi-file"></i></div>
																	</div>
																	<div class="col-md-8">
																		<div>
																			<?php echo  'SLIP-'.$data['reg_code'] ?>
																			<span class="badge badge-success">IMG</span>
																		</div>
																		<div>
																		<a target="_blank" href="<?php echo  site_url("registration/downloadSlip/".$data['reg_id'])?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo base_url()?>uploads/<?php echo $data['pay_slip']?>"  class="card-link">View</a>
																		</div>
																	</div>
																	<div class="col-md-2">
																		<div class="table-data-feature">
																			<button id="remove_slip" type="button" class="item removeFile" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" aria-describedby="ui-id-1">
																					<i class="zmdi zmdi-delete"></i>
																			</button>
																		</div>
																	</div>
																</div>
																
															  </div>
														</div>
														
														<?php } ?>
												 </div>
											 </div>
											 
													</td>
                                                </tr>
													
												<?php } ?>
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
														<?php echo $data['invoice_address']?>
													</div>
												</p>
											</div>
											<div class="col-sm-4">
												<p class="date_issue text-right">
													<strong>Date Issued: <?php echo date('d F Y' , strtotime($data['reg_date']))?></strong>
												</p>
												<p class="text-right">
													<strong>No. <?php echo $data['reg_code'] ?>/<?php echo date('Y',strtotime($data['reg_date']))?></strong>
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
												<th width="20%"class="text-center">AMOUNT (<?php echo $data['is_th'] == 0 ? 'US$' : 'บาท' ?> )</th>
												
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
											
											<?php if($data['student_dinner'] == 1){ ?>
												
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
													<div class="m-b-10">Bank transfer (in US$)</div>
													<div>
														<p>Bank Name: Bangkok Bank, Thailand</p>
														<p>A/C Type: Savings</p>
														<p>Branch: Thammasat University Rangsit Campus</p>
															<p>	A/C Name: ERGONOMICS SOCIETY OF THAILAND </p>
																<p>Swift Code: BKKBTHBK  </p>
																<p>A/C No.: 091-0-18112-2</p>
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
												
													<span style="color:red;font-weight:bold">Important Note: Due Date for the payment is on  <?php echo date('F d, Y',strtotime($data['due_date']))?></span>
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
									<div class="form-actions form-group text-center p-t-20 m-b-20">
															<a style="display:inline-block; margin-right:10px;" href="<?php echo base_url()?>invoice/<?php echo $data['invoice_file']?>" target="_blank" class="btn btn-primary btn-lg">Print</a>
															<a style="display:inline-block;margin-right:10px;" target="_blank" href="<?php echo site_url('adminRegistration/downloadInvoice/'.$data['reg_id'])?>" class="btn btn-danger btn-lg">Save PDF</a>
											
											</div>
								
								</div>
							
									
						</div>
						</div>
						
						</div>
					</div>
				</div>
</section>

<script>
$(function(){
	
	bs_input_file();
	
	$('#pay_slip_input').validate({
		rules: {

			file_pdf: {
                required: true,
				 extension: "jpg|png|bmp|jpeg"
            }
        },
		messages: {
			file_pdf: {
				extension : 'Please correct and submit only image file'
			}
		},
        submitHandler: function (form) { 
            ajaxPostSubmit("#pay_slip_input");
            return false; 
        }
	 });
	 
	  $('#remove_slip').click(function(e){
		 e.preventDefault();
		 removeFile_showInput('#pay_slip_uploaded','#pay_slip_input'); 
		$('input[name="pay_slip"]').rules("add", {
			 required: true,
			 extension: "jpg|png|bmp|jpeg",
			 messages: {
				extension : 'Please correct and submit only image file'
			  }
		 });
	 })
});

</script>