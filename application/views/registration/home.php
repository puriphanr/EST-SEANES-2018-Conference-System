 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-12">
							
                             <h1 class="title-4 place-inline">
								Registration
                            </h1>
							 <button onclick="window.location='<?php echo site_url('registration/addRegistration')?>'" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>ADD Registration
							</button>
							<div class="alert alert-danger m-t-20" role="alert">
										<span class="badge badge-pill badge-danger">Important!</span>
										Please check and edit your profile at the menu on the top-right corner or <a href="<?php echo site_url('account/profile')?>" class="alert-link">click here</a> before adding registration. 
										The name and address on your profile will be automatically add to the invoice.
										</div>
                        </div> 
						
						<hr class="line-seprate">
							
                    </div>
                </div>
            </section>

 <section class="p-t-20">
                <div class="container">
                    <div class="row">
						<div class="col-md-12">
						
						<?php if(!empty($data)){ ?>
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2">
                                    <thead>
                                        <tr>
											<th width="15%">Register ID</th>
                                            <th width="30%">Conference Type</th>
											<th width="15%">Payment Method</th>
											<th width="10%">Total</th>
											<th width="5%">Unit</th>
                                            <th width="15%">Register Time</th>
                                            <th width="10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php foreach($data as $key=>$row) { ?>
                                        <tr class="tr-shadow">
											<td><?php echo $row['reg_code']?></td>
                                            <td>
												<?php 
													if($row['is_th'] == 0){
														if($row['conference_type'] == 1){ 
															echo 'SEANES member of Developing Countries';
														}
														elseif($row['conference_type'] == 2){
															echo 'IEA Federated Societies';
														}
														elseif($row['conference_type'] == 3){
															echo 'Others Participants';
														}
														else{
															echo 'Students';
														}
													}
													else{
														if($row['conference_type'] == 1){ 
															echo 'บุคคลทั่วไป';
														}
														elseif($row['conference_type'] == 2){
															echo 'สมาชิกสมาคมการยศาสตร์ไทย / สมาชิกหน่วยงานเครือข่าย';
														}
														elseif($row['conference_type'] == 3){
															echo 'นักศึกษาปริญญาโท-เอก';
														}
														else{
															echo 'นักศึกษาปริญญาตรี';
														}
														
													}
													?>
											
											</td>
                                           
											<td class="text-center">
											<?php 
											if($row['payment_type'] == 1 ){ 
												echo 'Bank Transfer';
											 }
											 else{
												 echo 'Paypal';
											 }
											 ?>
											</td>
											<td class="text-right"><?php echo number_format($row['total'] , 2)?> </td>
											<td class="text-center"><?php echo $row['is_th'] == 0 ? 'US$' : 'บาท' ?></td>
                                            <td class="text-center">
											<?php echo date('d/m/Y',strtotime($row['reg_date']))?>
												
											</td>
                                          
                                          
                                            <td>
											
													<div class="table-data-feature">
													<button title="View" onclick="window.location='<?php echo site_url('registration/viewRegistration/'.$row['reg_id'])?>'" type="button" class="btn btn-primary btn-xs m-r-5">
                                                      View
                                                    </button>
													
													<button title="Remove" type="button" data-url="<?php echo site_url('registration/removeRegistration/'.$row['reg_id'])?>" class="remove btn btn-danger btn-xs">
                                                      Remove
                                                    </button>
													
													</div>
											
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
							
							<?php } else { ?>
							<div class="alert alert-dark m-t-30" role="alert">
									You don't have any registration information here.
							</div>
							
							<?php } ?>
						</div>
					</div>
				</div>
</section>
<script>
$(function(){
$('.remove').click(function(e){
		e.preventDefault();
		ajaxRedirectConfirm($(this).data('url') , 'Are you sure to remove this registration?');
	})
})	
</script>