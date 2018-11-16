 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4">
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
							<form action="<?php echo site_url('adminSettings/users/'.$this->uri->segment(3))?>" method="post" class="form-horizontal no-m-bottom">
									<div class="row form-group">
										<label class="col-md-1 m-t-10 text-right">Search</label>
										<div class="col-md-7">
											<input type="text" class="form-control" name="search" id="search" placeholder="Title" />
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
											<th width="10%">Article ID</th>
                                            <th width="50%">Article Title</th>
                                            <th width="10%">Status</th>
                                            <th width="20%">Create Time</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php foreach($data as $key=>$row) { ?>
                                        <tr class="tr-shadow">
											<td><?php echo $row['paper_code']?></td>
                                            <td><a href="<?php echo site_url('editorSubmission/editPaper/1/'.$row['paper_id'].'/userSubmission/'.$this->uri->segment(3))?>" title="View Paper"><?php echo $row['title']?></a></td>
                                            <td>
												<div class="h6">
                                              <?php 
											  if($row['status'] == 1){
												  echo '<span class="badge badge-secondary">Waiting</span>';
											  }
											  elseif($row['status'] == 2){
												   echo '<span class="badge badge-warning">In review</span>';
											  }
											  elseif($row['status'] == 3){
												   echo '<span class="badge badge-danger">In correction</span>';
											  }
											  elseif($row['status'] == 4){
												   echo '<span class="badge badge-primary">In press</span>';
											  }
											  else{
												   echo '<span class="badge badge-success">Published</span>';
											  }
												
											  ?></div>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i',strtotime($row['timestamp'])) ?></td>
                                          
                                          
                                         
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