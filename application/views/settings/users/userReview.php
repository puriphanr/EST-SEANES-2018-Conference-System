 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                         <div class="col-md-6">
							
                            <h1 class="title-4 place-inline">
								Users
                            </h1>
							
                        </div> 
						 <div class="col-md-6 text-right">
							
											<button onclick ="window.location='<?php echo site_url('adminSettings/users')?>'" type="button" class="btn btn-secondary">
												<i class="zmdi zmdi-arrow-left"></i> Back
											</button>
							
						</div>
						
						<hr class="line-seprate">
							
                    </div>
						<div class="row">
							 <div class="col-md-12">
								<form action="<?php echo site_url('adminSettings/userReview')?>" method="post" class="form-horizontal no-m-bottom">
										<div class="row form-group">
											<label class="col-md-1 m-t-10 text-right">Search</label>
											<div class="col-md-7">
												<input type="text" class="form-control" name="search" id="search" placeholder="Email / Name" />
											</div>
											<div class="col-md-4">
												 <button type="submit" class="au-btn-filter">
													<i class="zmdi zmdi-filter-list"></i> Filters
												</button>
												<button onclick ="window.location='<?php echo site_url('adminSettings/userReview')?>'" type="button" class="au-btn-filter">
													<i class="zmdi zmdi-format-clear"></i> Clear
												</button>
											</div>
										</div>
									</form>
							 </div>
							 
						</div>
                </div>
            </section>
			
			 <section class="p-t-20">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
									
										<?php 
										if(!empty($data)){
								
										?>
										<div class="table-responsive table-responsive-data2">
											<table class="table table-data2">
												<thead>
													<tr>	
														<th width="15%">Article ID</th>
														<th width="55%">Article Title</th>
														<th width="10%">Status</th>
														<th width="10%">Due Date</th>
														
													</tr>
												</thead>
												<tbody>
				
													<?php foreach($data as $key=>$row) { ?>
													<tr class="tr-shadow">
											<td><?php echo $row['paper_code']?></td>
                                            <td><a href="<?php echo site_url('editorSubmission/editPaper/1/'.$row['paper_id'].'/userReview/'.$this->uri->segment(3))?>" title="View Paper"><?php echo $row['title']?></a></td>
                                           
											<td class="text-center">
											<?php
											 $eva_status = unserialize(EVALUATION_STATUS);
											 
											 if($row['review_status'] < 4){
												echo '<div class="h6"><span class="badge badge-'.$eva_status[$row['review_status']]['label'].'">'.$eva_status[$row['review_status']]['text'].'</span></div>';
											 }
											 else{
												 echo '<div class="h6"><a href="'.site_url('editorSubmission/evaluation/'.$row['reviewer_id'].'/userReview/'.$this->uri->segment(3)).'" title="View Review"><span class="badge badge-'.$eva_status[$row['review_status']]['label'].'">'.$eva_status[$row['review_status']]['text'].'</span></a></div>';
											 }
											 ?>
											</td>
                                            <td>
											<?php
											$arrDate1 = explode("-",date('Y-m-d',strtotime($row['due_time'])));
											$arrDate2 = explode("-",date('Y-m-d'));
											$timStmp1 = mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]);
											$timStmp2 = mktime(0,0,0,$arrDate2[1],$arrDate2[2],$arrDate2[0]);

											if($timStmp1 < $timStmp2 && $row['review_status'] == 1){ ?>
												<div class="status--denied"><?php echo date('d/m/Y',strtotime($row['due_time'])) ?></div>
												<div class="status--denied"><strong>Overdue</strong></div>
											<?php }else{ ?>
												<?php echo date('d/m/Y',strtotime($row['due_time'])) ?>
											<?php } ?>
												
											</td>
                                          
                                        </tr>
                                        <tr class="spacer"></tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
										
										<?php } else { ?>
										<div class="alert alert-dark m-t-30" role="alert">
												You don't have any users here. Click the button <span class="badge badge-success">+ Add User</span> to add user information
										</div>
										
										<?php } ?>
									</div>
								</div>
							</div>
			</section>

<div class="dialog" style="display:none;" id="dialog-log" title="Status Log">
		<div class="row dialog-body">
			<div id="log-table" style="width:100%;padding:5px"></div>
		</div>
	</div>

<script type="text/javascript">
$(function(){
	$('#role').change(function(e){
		e.preventDefault();
		window.location = '<?php echo site_url('adminSettings/users')?>/'+$(this).val();
		
	});
	
	$('.remove').click(function(e){
		e.preventDefault();
		ajaxRedirectConfirm($(this).data('url') , 'Are you sure to remove this item ?');
	})
})
</script>