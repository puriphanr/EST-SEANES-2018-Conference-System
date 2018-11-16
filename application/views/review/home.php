 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4 place-inline">
								Review
                            </h1>
							
                        </div> 
						 <div class="col-md-6">
							
								<form action="<?php echo site_url('review/index/'.$this->uri->segment(3))?>" method="post" class="form-horizontal no-m-bottom">
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
								<a class="nav-link <?php echo $this->uri->segment(3) != 2 ? 'active' : NULL ?>" href="<?php echo site_url('review/index/1') ?>" id="pills-home-tab" href="#pills-home" role="tab" aria-controls="pills-mine" aria-selected="false">In Review <span class="badge badge-light"><?php echo  $count1 ?></span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?php echo $this->uri->segment(3) == 2 ? 'active' : NULL ?>" href="<?php echo site_url('review/index/2') ?>" id="pills-profile-tab" href="#pills-profile" role="tab" aria-controls="pills-author" aria-selected="false">Reviewed/Evaluated <span class="badge badge-light"><?php echo $count2 ?></span></a>
							</li>				
						</ul>
						
						<?php if(!empty($data)){ ?>
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2">
                                    <thead>
                                        <tr>
											<th width="10%">Article ID</th>
                                            <th width="50%">Article Title</th>
											<th width="20%">Accept or Reject for Reviewing</th>
                                            <th width="10%">Due Date</th>
                                            <th width="10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php foreach($data as $key=>$row) { ?>
                                        <tr class="tr-shadow">
											<td><?php echo $row['paper_code']?></td>
                                            <td><a href="<?php echo site_url('review/viewPaper/'.$row['reviewer_id'])?>" title="View Paper"><?php echo $row['title']?></a></td>
                                           
											<td class="text-center">
											<?php if($row['review_status'] == 1 ){ ?>
							
											
												<a href="#" data-url="<?php echo site_url("review/acceptReview/".$row['reviewer_id']."/2")?>" data-text="accept" class="btn btn-primary accept-btn">Accept</a>
												<a href="#" data-url="<?php echo site_url("review/acceptReview/".$row['reviewer_id']."/3")?>" data-text="reject" class="btn btn-danger reject-btn">Reject</a>
											
											<?php } else { 
											 $eva_status = unserialize(EVALUATION_STATUS);
											 echo '<div class="h6"><span class="badge badge-'.$eva_status[$row['review_status']]['label'].'">'.$eva_status[$row['review_status']]['text'].'</span></div>';
											
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
                                          
                                          
                                            <td>
											
                                                <div class="table-data-feature">
													 <button title="View Paper" onclick="window.location='<?php echo site_url('review/viewPaper/'.$row['reviewer_id'])?>'" type="button" class="item">
                                                        <i class="zmdi zmdi-eye"></i>
                                                    </button>
													<?php  if($row['review_status'] == 2 || $row['review_status'] == 4){ ?>
													 <button title="Evaluation" type="button" onclick="window.location='<?php echo site_url('review/evaluation/'.$row['reviewer_id'])?>'" class="item">
                                                        <i class="zmdi zmdi-assignment-check"></i>
                                                    </button>
													<?php } ?>
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
									You don't have any manuscript or research article for review here.
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
	$('.accept-btn , .reject-btn').click(function(e){
		e.preventDefault();
		ajaxRedirectConfirm($(this).data('url') , 'Are you sure to '+$(this).data('text')+' review this article ?');
	})
	
	
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