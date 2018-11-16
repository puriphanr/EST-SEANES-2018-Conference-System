 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4 place-inline">
								Paper Submission
								
                            </h1>
							 <button onclick="window.location='<?php echo site_url('submission/editPaper/1')?>'" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>ADD Manuscript/Article
							</button>
                           
                        </div> 
						 <div class="col-md-6">
							
								<form action="<?php echo site_url('submission/index/'.$this->uri->segment(3))?>" method="post" class="form-horizontal no-m-bottom">
									<div class="row form-group">
										<label class="col-md-2 m-t-10 text-right">Search</label>
										<div class="col-md-6">
											<input type="text" class="form-control" name="search" id="search" placeholder="Article Title" />
										</div>
										<div class="col-md-4">
											 <button type="submit" class="au-btn-filter">
												<i class="zmdi zmdi-filter-list"></i>Filters
											</button>
											<button onclick ="window.location='<?php echo site_url('submission/index/'.$this->uri->segment(3))?>'" type="button" class="au-btn-filter">
												<i class="zmdi zmdi-format-clear"></i>Clear
											</button>
										</div>
									</div>
								</form>
						 </div>
						<hr class="line-seprate">
							
                    </div>
                </div>
            </section>

 <section class="p-t-20">
                <div class="container">
                    <div class="row">
						<div class="col-md-12">
						
						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link <?php echo $this->uri->segment(3) != 2 ? 'active' : NULL ?>" href="<?php echo site_url('submission/index/1') ?>" id="pills-home-tab" href="#pills-home" role="tab" aria-controls="pills-mine" aria-selected="false">Mine <span class="badge badge-light"><?php echo $countMine ?></span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?php echo $this->uri->segment(3) == 2 ? 'active' : NULL ?>" href="<?php echo site_url('submission/index/2') ?>" id="pills-profile-tab" href="#pills-profile" role="tab" aria-controls="pills-author" aria-selected="false">Co-Author <span class="badge badge-light"><?php echo $countCo ?></span></a>
							</li>				
							<?php if(in_array($sess_users['users_role'] , unserialize(USER_ROLE_TOP) )){ ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('review') ?>" id="pills-review-tab" href="#pills-review" role="tab" aria-controls="pills-review" aria-selected="false">Your Review <span class="badge badge-light"><?php echo $countReviewer ?></span></a>
							</li>	
							
							<?php } ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('registration') ?>" id="pills-reg-tab" href="#pills-reg" role="tab" aria-controls="pills-mine" aria-selected="false">Registration </a>
							</li>
						</ul>
						<hr class="nav-divide">
						<?php if(!empty($data)){ ?>
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2">
                                    <thead>
                                        <tr>
											<th width="10%">Article ID</th>
                                            <th width="60%">Article Title</th>
                                            <th width="10%">Status</th>
                                            <th width="20%">Create Time</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php foreach($data as $key=>$row) { ?>
                                        <tr class="tr-shadow">
											<td><?php echo $row['paper_code']?></td>
                                            <td>
												<div class="table-title m-b-5 title--sbold">
													<?php echo $row['title']?>
												</div>
												<div class="table-button m-b-5">
												<?php if ($row['status'] < 2){ ?>
													<button title="View" onclick="window.location='<?php echo site_url('submission/viewPaper/'.$row['paper_id'])?>'" type="button" class="btn btn-primary btn-xs">
                                                      View
                                                    </button>
													<?php if($this->uri->segment(3) == 1 || !$this->uri->segment(3)) { ?>
													<button title="Edit" onclick="window.location='<?php echo site_url('submission/editPaper/1/'.$row['paper_id'])?>'" type="button" class="btn btn-secondary btn-xs">
                                                      Edit
                                                    </button>
													
													<button title="Remove" type="button" data-url="<?php echo site_url('submission/removePaper/'.$row['paper_id'])?>" class="remove btn btn-danger btn-xs">
                                                      Remove
                                                    </button>
													
													<?php } ?>
												<?php } else { ?>
												<div class="row">
												<div class="col-sm-4">
													<div class="m-b-10">
														<button onclick="window.location='<?php echo site_url('submission/viewPaper/'.$row['paper_id'])?>'" type="button" class="btn btn-primary btn-block btn-xs">
															1<sup>st</sup> Submission
														</button>
													</div>
													<div>
														<button <?php echo $row['status'] < 3 ? 'disabled' : NULL ?>  type="button" onclick="window.location='<?php echo site_url('submission/reviewResult/'.$row['paper_id'].'/1')?>'" class="btn btn-warning btn-block btn-xs <?php echo $row['status'] < 3 ? 'disabled' : NULL ?>">
															Reviewing Result
														</button>
													</div>
												</div>
												<div class="col-sm-4">
													<div  class="m-b-10">
														<button <?php echo $row['status'] < 3 ? 'disabled' : NULL ?> onclick="window.location='<?php echo site_url('submission/reviseSubmission/'.$row['paper_id'])?>'" type="button" class="btn btn-primary btn-block btn-xs <?php echo $row['status'] < 3 ? 'disabled' : NULL ?>">
															Revise Submission
														</button>
														
													</div>
													
													<div>
														<button <?php echo $row['status'] < 4 ? 'disabled' : NULL ?> type="button" onclick="window.location='<?php echo site_url('submission/reviewResult/'.$row['paper_id'].'/2')?>'" class="btn btn-<?php echo $row['status'] == 4 ? 'success' : 'danger'?> btn-block btn-xs <?php echo $row['status'] < 4 ? 'disabled' : NULL ?>">
															Reviewing Result
														</button>
													</div>
												
												</div>
												
												<div class="col-sm-4">
													<div  class="m-b-10">
														<button <?php echo $row['status'] < 4 ? 'disabled' : NULL ?> onclick="window.location='<?php echo site_url('submission/inPressSubmission/'.$row['paper_id'])?>'" type="button" class="btn btn-<?php echo $row['status'] == 4 ? 'success' : 'primary'?> btn-block btn-xs <?php echo $row['status'] < 4 ? 'disabled' : NULL ?>">
															In Press Submission
														</button>
													</div>
													
												
												</div>
												</div>
													
												<?php } ?>
													 
                                                </div>
											</td>
                                            <td>
												<div class="h6">
                                              <?php 
											  if($row['status'] == 1){
												  echo '<span class="badge badge-secondary">Waiting</span>';
											  }
											  elseif($row['status'] == 2){
												   echo '<span class="badge badge-warning">In Review</span>';
											  }
											  elseif($row['status'] == 3){
												   echo '<span class="badge badge-danger">In Correction</span>';
											  }
											  elseif($row['status'] == 4){
												   echo '<span class="badge badge-success">In Press</span>';
											  }
											  else{
												    echo '<span class="badge badge-danger">2<sup>nd</sup> Revise</span>';
											  }
											  
												
											  ?></div>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i',strtotime($row['timestamp'])) ?></td>
                                          
                                      
                                        </tr>
                                       
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
							
							<?php } else { ?>
							<div class="alert alert-dark m-t-30" role="alert">
									You don't have any manuscript or research article submitted here. Click the button <span class="badge badge-success">+ Add Manuscript/Article</span> to upload
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
	$('.remove').click(function(e){
		e.preventDefault();
		ajaxRedirectConfirm($(this).data('url') , 'Are you sure to remove this item ?');
	})
	
	$('.logs').click(function(e){
		e.preventDefault();
		$.ajax({
           url : '<?php echo site_url('submission/viewEditLogs')?>',
           type : "POST",
           data : 'id='+$(this).data('id'),
           beforeSend : function(){ showDialogWait(); },
           success : function(data){
			    $('#log-table').html('').html(data);
				$("#dialog-wait").dialog("close");
				$( "#dialog-log" ).dialog({
					modal: true,
					width: $(window).width() > 600 ? 600 : 'auto',
					minheight: 150,
					buttons: {
					'Close': function() {
					  $( this ).dialog( "close" );
					}
				  }
				});
           }
        });
	})
	
})
</script>