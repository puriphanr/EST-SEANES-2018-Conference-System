 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4 place-inline">
								Registration
								
                            </h1>
							
                        </div>
						
						<div class="col-md-6 text-right">
											<?php if($th == 0 ){ ?>
											<button onclick ="window.location='<?php echo site_url('registration/addRegistration/th')?>'" type="button" class="btn btn-primary">
												 Thai Version
											</button>
											<?php }else{ ?>
											<button onclick ="window.location='<?php echo site_url('registration/addRegistration')?>'" type="button" class="btn btn-primary">
												 English Version
											</button>
											<?php } ?>
											<button onclick ="window.location='<?php echo site_url('registration')?>'" type="button" class="btn btn-secondary">
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
                                
                         <div class="card-body">
									
						<form action="<?php echo site_url('registration/confirmRegistration')?>" method="POST" >
							<input type="hidden" name="is_th" value="<?php echo $th ?>" />
							<div class="text-center m-b-20">
								<h3 class="m-b-15">Conference Registration Form</h3>
								<h4 class="m-b-15">Conference Date: 12-14 December 2018</h4>
								<h4 class="m-b-15">Place: Windsor Suites & Convention Bangkok, THAILAND</h4>
							</div>	
							<div class="alert alert-danger m-t-20 m-b-20" role="alert">
										<span class="badge badge-pill badge-danger">Important!</span>
										Please check and edit your profile at the menu on the top-right corner or <a href="<?php echo site_url('account/profile')?>" class="alert-link">click here</a> before adding registration. 
										The name and contact address on your profile will be automatically added to the invoice.
										</div>
							<div class="fieldset-title">Participants Information</div>
							<div class="row form-group">
								<label class="col-sm-2">Participant Type</label>
								<div class="col-sm-3">
								<strong>
								<?php if($sess_users['users_role'] == 3){ ?>
									Participant (Non-author)
								
								<?php } else { ?>
								
									Author
								<?php } ?>
								</strong>
								</div>
							</div>
							
							<div class="row form-group">
								<label class="col-sm-2">Name</label>
								<div class="col-sm-3">
									<input type="text" name="firstname" placeholder="First Name" class="form-control" value="<?php echo $users['firstname']?>" disabled >
								</div>
								<div class="col-sm-3">
									<input type="text" name="middlename" placeholder="Middle Name" class="form-control" value="<?php echo $users['middlename']?>" disabled>
								</div>
								<div class="col-sm-3">
									<input type="text" name="lastname" placeholder="Last Name" class="form-control" value="<?php echo $users['lastname']?>" disabled >
								</div>
							
							</div>
							
							<div class="row form-group">
														<div class="col col-md-2">
															<label for="text-input" class="form-control-label">Name Title</label>
														</div>
														<div class="col-12 col-md-3">
															<select name="name_title" readonly id="name_title" class="form-control" disabled>
															<option value="">Please select</option>
																<option value="Prof." <?php echo $users["name_title"] == 'Prof.' ? 'selected' : NULL ?> >Prof.</option>
																<option value="Dr." <?php echo $users["name_title"] == 'Dr.' ? 'selected' : NULL ?>>Dr.</option>
																<option value="Mr." <?php echo $users["name_title"] == 'Mr.' ? 'selected' : NULL ?>>Mr.</option>
																<option value="Ms." <?php echo $users["name_title"] == 'Ms.' ? 'selected' : NULL ?>>Ms.</option>
																<option value="Mrs." <?php echo $users["name_title"] == 'Mrs.' ? 'selected' : NULL ?>>Mrs.</option>
																<option value="Other" <?php echo $users["name_title"] != 'Prof.' && $users["name_title"] != 'Dr.' && $users["name_title"] != 'Mr.' && $users["name_title"] != 'Ms.' && $users["name_title"] != 'Mrs.' ? 'selected' : NULL ?>>Other</option>
															</select>
														</div>
														<div class="col-12 col-md-3">
															<input id="name_title_other" name="name_title_other" class="form-control" disabled type="text" value="<?php echo $users["name_title"] != 'Prof.' && $users["name_title"] != 'Dr.' && $users["name_title"] != 'Mr.' && $users["name_title"] != 'Ms.' && $users["name_title"] != 'Mrs.' ? $users['name_title'] : NULL ?>" >
														</div>
							</div>
							
							<div class="row form-group">
														<div class="col col-md-2">
															<label for="text-input" class=" form-control-label">Organization</label>
														</div>
														<div class="col-12 col-md-9">
															<input id="organization" name="organization" class="form-control" type="text" value="<?php echo $users['organization']?>" disabled >
														</div>
													</div>
													<div class="row form-group">
														<div class="col col-md-12">
															<label for="textarea-input" class="required form-control-label">Contact Address</label>
														
															<textarea name="contact_address" id="contact_address" rows="4" class="form-control" disabled><?php echo $users['contact_address']?></textarea>
														</div>
													</div>
													<div class="row form-group">
				
														<div class="col-12 col-md-12">
															<div class="row">
																<div class="col-12 col-md-2">
																	<label class=" form-control-label">City</label>
																</div>
																
																<div class="col-12 col-md-4">
																	<input id="city" name="city" class="form-control" type="text" disabled value="<?php echo $users['city']?>">
																</div>
																<div class="col-12 col-md-2">
																	<label class=" form-control-label">State/Province</label>
																</div>
																<div class="col-12 col-md-4">
																	<input id="state" name="state" class="form-control" type="text" disabled value="<?php echo $users['state']?>">
																</div>
																
															</div>
														</div>
													</div>
													<div class="row form-group">
				
														<div class="col-12 col-md-12">
															<div class="row">
																<div class="col-12 col-md-2">
																	<label class=" form-control-label">Postal Code</label>
																</div>
																<div class="col-12 col-md-4">
																	<input id="postal_code" name="postal_code" class="form-control" type="text" disabled value="<?php echo $users['postal_code']?>">
																</div>
																<div class="col-12 col-md-2">
																	<label class="required form-control-label">Country</label>
																</div>
																<div class="col-12 col-md-4">
																	
																	<select name="country" id="country" class="form-control select2" disabled>
																		<option value="">Please Select</option>
																		<?php foreach($country as $key=>$row){ ?>
																		<option value="<?php echo $row['country_id']?>" <?php echo $row['country_id'] == $users['country'] ? 'selected' : NULL ?>><?php echo $row['country_name']?></option>
																		<?php } ?>
																	</select>
																</div>
															</div>
														</div>
													</div>
												
													<div class="row form-group">
														<div class="col col-md-2">
															<label for="phone" class=" form-control-label">Phone</label>
														</div>
														<div class="col-12 col-md-4">
															<input name="phone" id="phone"  class="form-control" type="text" disabled value="<?php echo $users['phone']?>">
														</div>
														<div class="col col-md-2">
															<label for="fax" class=" form-control-label">Fax</label>
														</div>
														<div class="col-12 col-md-4">
															<input name="fax" id="fax"  class="form-control" type="text" disabled value="<?php echo $users['fax']?>">
														</div>
													</div>
													
													<div class="row form-group">
														<div class="col col-md-2">
															<label for="email-input" class="required  form-control-label">Email</label>
														</div>
														<div class="col-12 col-md-4">
																<input id="email" name="email" class="form-control" type="text" disabled value="<?php echo $users['email']?>">
														</div>
													</div>
							<?php if($isPaper){ ?>					
							<div class="fieldset-title">
								Title of Paper 
								<p>(Maximum of two papers of which the registered participant is an author or co-author)</p>
							</div>
							
							<div class="row form-group">
								<div class="col-12">
								<?php if(!empty($paper)){ ?>
								<div class="table-responsive m-b-10">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
												<th width="5%"></th>
												<th width="20%" class="text-center">Article ID</th>
												<th width="75%"class="text-center">Article Title</th>
												
											</tr>
                                        </thead>
                                        <tbody>
											<?php foreach($paper as $key=>$row){ ?>
                                            <tr>
												<td><input type="checkbox" name="paper[]" value="<?php echo $row['paper_id']?>"  required /></td>
												<td class="text-center"><?php echo $row['paper_code']?></td>
												<td class="text-left"><?php echo $row['title']?></td>
											
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
								
								<?php }else{ ?>
								<div class="alert alert-dark m-t-30" role="alert">
									You don't have any paper for registration here.
							</div>
								
								<?php } ?>
								
								</div>
							
							</div>
							
							<?php } ?>
							<div class="fieldset-title">
								Conference Fee
								
							</div>
							<p class="m-b-10">
								Conference fees include an Electronic conference proceeding, welcome reception dinner on December 11, 2018, conference bag with souvenir and information material, invitation ticket to the SEANES 2018 dinner on December 13, 2018, and lunch buffet and 2 coffee breaks each day during the conference. For other people are coming with you and would like to join reception event, lunch and conference banquet, please ask for extra registration at the registration desk.
								</p>
							<div class="row form-group">
								<div class="col-12">
								
								
								<div class="table-responsive m-b-10">
								
								<?php if($th == 0){ ?>
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
												
                                                <th rowspan="2" class="text-center">Participant</th>
                                                <th rowspan="2" class="text-center"><div>Early Bird</div><div>Before Nov 10,2018</div></th>
                                                <th colspan="2" class="text-center">After Nov 10,2018</th>
                                               
                                            </tr>
											<tr>
												<th class="text-center">Nov 11-30, 2018</th>
												<th class="text-center">Late</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <tr>
												
												<td>
													<label for="radio1" class="form-check-label ">
														<input type="radio" name="conference_fee" value="1" checked class="form-check-input"> SEANES member of Developing Countries
													</label>
												</td>
												<td class="text-center">US$ 350</td>
												<td class="text-center">US$ 400</td>
												<td class="text-center">US$ 500</td>
											</tr>
											<tr>
												
												<td>
													<label for="radio1" class="form-check-label ">
														<input type="radio" name="conference_fee" value="2" class="form-check-input"> IEA Federated Societies
													</label>
												</td>
												<td class="text-center">US$ 400</td>
												<td class="text-center">US$ 450</td>
												<td class="text-center">US$ 550</td>
											</tr>
											<tr>
												
												<td >
													<label for="radio1" class="form-check-label ">
														<input type="radio" name="conference_fee" value="3" class="form-check-input"> Others Participants
													</label>
												</td>
												<td class="text-center">US$ 450</td>
												<td class="text-center">US$ 500</td>
												<td class="text-center">US$ 600</td>
											</tr>
											<tr>
												
												<td>
													<label for="radio1" class="form-check-label ">
														<input type="radio" name="conference_fee" value="4" class="form-check-input"> Students *
													</label>
												</td>
												<td class="text-center">US$ 200</td>
												<td class="text-center">US$ 350</td>
												<td class="text-center">US$ 400</td>
											</tr>
										</tbody>
									</table>
									
								<?php } else { ?>
								
									<table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
												
                                                <th class="text-center">
												<div>ผู้เข้าร่วมประชุมคนไทย </div>
												<div>นักศึกษาไทยและต่างชาติที่เรียนในประเทศไทย</div>
												</th>
                                                <th class="text-center"><div>ภายใน</div><div>10 พ.ย. 2561</div><div>(บาท)</div></th>
                                                <th class="text-center"><div> 11 - 30 พ.ย. 2561</div><div>(บาท)</div></th>
                                               <th class="text-center"><div>ชำระล่าช้า</div><div>1-11 ธ.ค. 2561</div><div>(บาท)</div></th>
                                            </tr>
											
                                        </thead>
                                        <tbody>
                                            <tr>
												
												<td>
													<label for="radio1" class="form-check-label ">
														<input type="radio" name="conference_fee" value="1" checked class="form-check-input"> บุคคลทั่วไป
													</label>
												</td>
												<td class="text-center">7,500</td>
												<td class="text-center">8,500</td>
												<td class="text-center">13,000</td>
											</tr>
											<tr>
												
												<td>
													<label for="radio1" class="form-check-label ">
														<input type="radio" name="conference_fee" value="2" class="form-check-input"> สมาชิกสมาคมการยศาสตร์ไทย<br>
    สมาชิกหน่วยงานเครือข่าย*

													</label>
												</td>
												<td class="text-center">7,000</td>
												<td class="text-center">8,000</td>
												<td class="text-center">12,000</td>
											</tr>
											<tr>
												
												<td >
													<label for="radio1" class="form-check-label ">
														<input type="radio" name="conference_fee" value="3" class="form-check-input"> นักศึกษาปริญญาโท-เอก**
													</label>
												</td>
												<td class="text-center">5,000</td>
												<td class="text-center">6,000</td>
												<td class="text-center">10,000</td>
											</tr>
											<tr>
												
												<td>
													<label for="radio1" class="form-check-label ">
														<input type="radio" name="conference_fee" value="4" class="form-check-input"> นักศึกษาปริญญาตรี**
													</label>
												</td>
												<td class="text-center">3,000</td>
												<td class="text-center">4,000</td>
												<td class="text-center">6,000</td>
											</tr>
										</tbody>
									</table>
								
							
								
								<?php } ?>
								</div>
								
								
								</div>
							</div>
							
							<p class="m-b-10">
							<?php if($th == 0){ ?>
							
							<strong>Note: </strong><br>
1. Each full-time student is required to submit an official letter of status proof from his/her university or advisor at the time of registration.<br>
<!--- The payment should be performed to complete the early registration on or before September 30, 2018.<br>-->

2. Each corresponding author is required an additional registration fee when more than two papers are accepted for presentations.<br>

							<div id="student_dinner" style="display:none">
								<div>4. Student fee will not include a special dinner and activities on December 13, 2018</div>
								<div class="form-group m-l-30 m-b-20 m-t-10">
									<label for="radio1" class="form-check-label ">
										<input type="checkbox" name="student_dinner" value="1" class="form-check-input"> <span style="color:#0063be"> US$ 25 for additional fee for this event. </span>
									</label>
								</div>
								
							</div>
							
						
							<?php }else{ ?>
							
							* สมาชิกหน่วยงานเครือข่ายต้องแสดงบัตรสมาชิกที่ไม่หมดอายุ หรือหนังสือรับรองจากหน่วยงานเครือข่าย<br>
							** นักศึกษาแสดงบัตรประจำตัวนักศึกษาที่ยังไม่หมดอายุหรือหนังสือรับรองจากสถาบัน<br>
							
							<div id="student_dinner" style="display:none">
								<div>หากประสงค์เข้าร่วมงานเลี้ยงช่วงเย็นสามารถชำระค่าลงทะเบียนเพิ่มได้</div>
								<div class="form-group m-l-30 m-b-20 m-t-10">
									<label for="radio1" class="form-check-label ">
										<input type="checkbox" name="student_dinner" value="1" class="form-check-input"> <span style="color:#0063be">ลงทะเบียนร่วมงานเลี้ยงและกิจกรรมเย็นวันที่ 13 ธันวาคม 2561 จำนวน 800 บาท </span>
									</label>
								</div>
							</div>
							
							<?php } ?>
							</p>
							
							<div class="fieldset-title">
								Payment Method
								
							</div>
							
								<div class="row form-group">
								<div class="col-12">
								
								
								<div class="table-responsive m-b-10">
                                    <table class="table table-borderless table-data3">
                                        
                                        <tbody>
                                            <tr>
												
												<td class="text-left" style="border-top: 1px solid #f5f5f5;">
													<div class="m-b-10">
													<label for="radio1" class="form-check-label bold">
														<input type="radio" name="payment_type" value="1" checked class="form-check-input"> Bank transfer (in <?php echo $th == 0 ? 'US$' : 'baht'?>)
													</label>
													</div>
													<div class="row col-12">
														<div class="col-sm-4">
															     Bank Name: <strong>Bangkok Bank, Thailand</strong><br>
																 A/C Type: <strong>Savings</strong> 
														</div>
														<div class="col-sm-5">
															    Branch: <strong>Thammasat University Rangsit Campus</strong><br>
																A/C Name: <strong>ERGONOMICS SOCIETY OF THAILAND </strong>
														</div>
														<div class="col-sm-3">
															    Swift Code: <strong>BKKBTHBK     </strong><br>
																A/C No.: <strong>091-0-22408-8</strong>
														</div>
													</div>
													<div class="m-t-10">
													Bank Address:<br> Bangkok Bank Public Company Limited, Thammasat University Rangsit Campus  99/18 Phaholyothin Road, Klong 1, Klongluang, Pathum Thani, THAILAND 12120
													</div>
												</td>
												
											</tr>
											<?php if($th == 0){ ?>
											 <tr>
												
												<td class="text-left">
													<div class="m-b-10">
													<label for="radio1" class="form-check-label bold">
														<input type="radio" name="payment_type" value="2" class="form-check-input"> Online payment via PayPal or Credit Card (US$ 15 additional fee for service charge)
													</label>
													</div>
												
												</td>
												
											</tr>
											
											<?php } ?>
										</tbody>
									</table>
								</div>
								
								
								<p class="m-b-10 red">
							
							<strong>Cancellation Policy:</strong><br>
							For cancellations notified by November 30, 2018, all registration fees of 50% (to cover administration costs) shall be
refunded. After November 30, 2018, there shall be no refunds.

							
								</p>
								
								</div>
							</div>
							
							
							<div class="fieldset-title">
							 Registration for the pre-conference special event
								
							</div>
							
							
							<p class="m-b-10">
								Pre-conference special program on December 11, 2018 (Learning Ergonomics successful cases of Thai organizations, onsite visit). 
(All participants who will be arriving early, are invited to join a special pre-conference program on December 11, 2018 without additional fee. Since this activity is supported by Thai industrial sectors, we have to inform them how many visitors to visit their site. You will be required to sign up for joining the event before arrival. We will update you information of the trip after you complete the registration. Two cases of onsite visit are following, select one of them if you prefer.  Each group will be limited at 30 persons based on time of registration.    

								</p>
							<div class="row form-group col-12">
								
														<div class="col col-sm-12 m-l-20 m-b-10">
															<label for="radio1" class="form-check-label ">
																<input type="radio" name="pre_conference" value="1" class="form-check-input"> Visit I: <a href="http://www.est.or.th/SEANES2018/index.php/schedule/visit-toyota-gateway-plant" target="_blank"> Toyota Gateway Plant (Car Assembly Manufacturing).</a> <span class="red">[Limit at 30 persons only]</span>
															</label>
															 
														</div>
														<div class="col col-sm-12 m-l-20  m-b-10">
															 <label for="radio1" class="form-check-label ">
																<input type="radio" name="pre_conference" value="2" class="form-check-input"> Visit II: <a href="http://www.est.or.th/SEANES2018/index.php/schedule/visit-scg-office-bangsue" target="_blank">SCG Workplace Solution Division.</a> <span class="red"> [Limit at 50 persons only]</span>
															</label>
														</div>
														<div class=" col col-sm-12 m-l-20  m-b-10">
															   <label for="radio1" class="form-check-label ">
																<input type="radio" name="pre_conference" value="3" class="form-check-input" checked> No, I will not join the events.


															</label>
														</div>
							</div>
							
							<div class="fieldset-title">
								Registration for Welcome Dinner on December 11,2018 During 18.30-20.30 (Free of Charge)
								
							</div>
							<div class="row form-group col-12">
								
														<div class="col col-sm-4 m-l-20">
															<label for="radio1" class="form-check-label ">
																<input type="radio" name="welcome_dinner"  value="1" class="form-check-input"> I would like to join Welcome Dinner
															</label>
															 
														</div>
														<div class="col-sm-3">
															 <label for="radio1" class="form-check-label ">
																<input type="radio" name="welcome_dinner" checked value="2" class="form-check-input"> I would not join Welcome Dinner
															</label>
														</div>
													
							</div>
							
							
							<div class="fieldset-title">
								Dietary Preference (Please tick as appropriate or give information at other)
							</div>
							
							<div class="row form-group col-12">
								
														<div class="col col-sm-12 m-l-20  m-b-10">
															<label for="radio1" class="form-check-label ">
																<input type="radio" name="dietary" checked  value="1" class="form-check-input"> No specific preference
															</label>
															 
														</div>
														<div class="col-sm-12 m-l-20  m-b-10">
															 <label for="radio1" class="form-check-label ">
																<input type="radio" name="dietary" value="2" class="form-check-input"> Vegetarian
															</label>
														</div>
														<div class="col-sm-12 m-l-20  m-b-10">
															 <label for="radio1" class="form-check-label ">
																<input type="radio" name="dietary" value="3" class="form-check-input"> Halal food
															</label>
														</div>
														<div class="col-sm-12 m-l-20 m-b-10">
															<div class="row">
																 <label for="radio1" class="form-check-label col-sm-1">
																	<input type="radio" name="dietary" value="4" class="form-check-input"> Other
																</label>
																<div class="col-sm-6">
																	<input type="text" name="dietary_other" id="dietary_other" class="form-control" disabled>
																</div>
															</div>
														</div>
							</div>
							
							
								<div class="form-actions form-group text-center p-t-20">
															<button type="submit" class="btn btn-primary btn-lg">Submit</button>
															<button type="reset" class="btn btn-secondary btn-lg">Cancel</button>
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
	
	$('form').validate();
	$('input[type=checkbox]').on('change', function (e) {
    if ($('input[type=checkbox]:checked').length > 2) {
        $(this).prop('checked', false);
        showDialogError("Maximum of two papers of which the registered participant is an author or co-author.");
    }
});


	$('input[name=dietary]').on('change', function (e) {
		$('#dietary_other').val('');
		if($(this).val() == 4){
			
			$('#dietary_other').removeAttr('disabled');
		}
		else{
			$('#dietary_other').attr('disabled' , 'disabled');
		}
	})
	<?php if($sess_users['users_role'] == 3){ ?>
	$('input[name=conference_fee]').on('change', function (e) {
		<?php if($th == 0) { ?>
		if($(this).val() > 3){
			
		<?php } else { ?>
		
		if($(this).val() > 2){
		<?php } ?>
			$('#student_dinner').show();
		}
		else{
			
			$('#student_dinner').hide();
		}
		
	})
	<?php } ?>
})

</script>