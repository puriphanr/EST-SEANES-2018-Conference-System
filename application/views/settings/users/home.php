 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4">
								Users
                            </h1>
							
                           
                        </div> 
						 <div class="col-md-6 text-right">
						 
						 
                             <button onclick="window.location='<?php echo site_url('adminSettings/editUser/1')?>'" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>ADD User
							</button>
                         
						</div>
							
						<hr class="line-seprate">
							
                    </div>
					<div class="row">
						 <div class="col-md-8">
							<form action="<?php echo site_url('adminSettings/users/'.$this->uri->segment(3))?>" method="post" class="form-horizontal no-m-bottom">
									<div class="row form-group">
										<label class="col-md-1 m-t-10 text-right">Search</label>
										<div class="col-md-7">
											<input type="text" class="form-control" name="search" id="search" placeholder="Email / Name" />
										</div>
										<div class="col-md-4">
											 <button type="submit" class="au-btn-filter">
												<i class="zmdi zmdi-filter-list"></i> Filters
											</button>
											<button onclick ="window.location='<?php echo site_url('adminSettings/users/'.$this->uri->segment(3))?>'" type="button" class="au-btn-filter">
												<i class="zmdi zmdi-format-clear"></i> Clear
											</button>
										</div>
									</div>
								</form>
						 </div>
						 <div class="col-md-4">
							<div class="form-group row">
											<label class="col-md-2 text-right">Role</label>
											<div class="col-md-10">
												<select id="role" name="role" class="form-control">
													<option value="" <?php !$this->uri->segment(3) ? 'selected' : NULL ?>>All</option>
													<?php foreach($role as $key=>$row){ ?>
													<option value="<?php echo $key?>" <?php echo $this->uri->segment(3) == $key ? 'selected' : NULL ?> ><?php echo $row ?></a>
													
													<?php } ?>	
												</select>
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
									
										<?php 
										if(!empty($data)){
								
										?>
										<div class="table-responsive table-responsive-data2">
											<table class="table table-data2">
												<thead>
													<tr>	
														<th width="15%">User ID</th>
														<th width="35%">User Detail</th>
														<th width="20%">Role</th>
														<th width="10%">Confirmation</th>
														<th width="10%">Create Time</th>
														<th width="10%"></th>
													</tr>
												</thead>
												<tbody>
				
													<?php foreach($data as $key=>$row) { ?>
													<tr class="tr-shadow">
														<td>U<?php echo str_pad($row['users_id'],4,0,STR_PAD_LEFT)?></td>
														<td>
															<div><strong><?php echo $row['firstname']?> <?php echo $row['middlename']?> <?php echo $row['lastname']?></strong></div>
															<div><?php echo $row['email']?></div>
															<div >
																<?php if(in_array($row['users_role'] , $user_role_top)){ ?>
																<button onclick="window.location='<?php echo site_url('adminSettings/userReview/'.$row['users_id'])?>'" type="button" class="btn btn-sm btn-primary m-t-5">Review
																  <span class="badge badge-light"><?php echo $row['countReview']?></span>
																</button>
																
																<?php } ?>
																<?php if(in_array($row['users_role'] , $user_role_author)){ ?>
																<button onclick="window.location='<?php echo site_url('adminSettings/userSubmission/'.$row['users_id'])?>'" type="button"  class="btn btn-sm btn-info m-t-5">Submission
																  <span class="badge badge-light"><?php echo $row['countSubmission']?></span>
																</button>
																
																<?php } ?>
															</div>
														</td>
														
														<td><?php echo $role[$row['users_role']] ?></td>
														
														<td class="text-center">
															<?php if($row['verify'] == 1) { ?>
															<span class="badge badge-success">YES</span>
															<?php } else { ?>
															<span class="badge badge-danger">NO</span>
															<?php } ?>
														</td>
														
														<td><?php echo date('d/m/Y H:i',strtotime($row['timestamp'])) ?></td>
													  
													  
														<td>
															<div class="table-data-feature">
															
																<button title="Edit" onclick="window.location='<?php echo site_url('adminSettings/editUser/1/'.$row['users_id'])?>'" type="button" class="item" data-toggle="tooltip" data-placement="top" >
																	<i class="zmdi zmdi-edit"></i>
																</button>
																<button title="Remove" type="button" data-url="<?php echo site_url('adminSettings/removeUser/'.$row['users_id'])?>" class="item  remove" data-toggle="tooltip" data-placement="top">
																	<i class="zmdi zmdi-delete"></i>
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