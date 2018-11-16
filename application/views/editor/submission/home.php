 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4">
								Paper Submission
								
                            </h1>
							
                           
                        </div> 
						 <div class="col-md-6 text-right">
							 <button onclick="window.location='<?php echo site_url('editorSubmission/editPaper/1')?>'" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>ADD Manuscript/Article
							</button>
						</div>
							
						<hr class="line-seprate">
							
                    </div>
					<div class="row">
						 <div class="col-md-12">
							<form action="<?php echo site_url('editorSubmission')?>" method="post" class="form-horizontal no-m-bottom">
									<div class="row form-group">
										<label class="col-md-1 m-t-10 text-right">Search</label>
										<div class="col-md-7">
											<input type="text" class="form-control" name="search" id="search" placeholder="Article Title" />
										</div>
										<div class="col-md-4">
											 <button type="submit" class="au-btn-filter">
												<i class="zmdi zmdi-filter-list"></i> Filters
											</button>
											<button onclick ="window.location='<?php echo site_url('editorSubmission')?>'" type="button" class="au-btn-filter">
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
							<?php if(!empty($data)){ ?>
                          <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-data2">
             
                                    <thead>
                                        <tr>
											<th width="15%">Article ID</th>
                                            <th width="70%">Article Title</th>
                                            <th width="5%">Status</th>
											
                                            <th width="10%">Create Time</th>
                                           
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
												<div class="table-author m-b-10">
													<strong>Corresponding Author:</strong> <?php echo $row['authors']['firstname']?> <?php echo $row['authors']['middlename']?> <?php echo $row['authors']['lastname']?>
												</div>
												  <div class="table-button m-b-5">
												
													<button title="Edit" onclick="window.location='<?php echo site_url('editorSubmission/editPaper/1/'.$row['paper_id'])?>'" type="button" class="btn btn-secondary btn-xs">
                                                      Edit
                                                    </button>
													
													<button title="Remove" type="button" data-url="<?php echo site_url('editorSubmission/removePaper/'.$row['paper_id'])?>" class="remove btn btn-danger btn-xs">
                                                      Remove
                                                    </button>
													
													<button title="Reviewers" onclick="window.location='<?php echo site_url('editorSubmission/reviewers/'.$row['paper_id'])?>'" type="button" class="btn btn-primary btn-xs">
                                                      Reviewers
                                                    </button>
													<?php 
													if($row['status'] >= 2){
													?>
													<button title="Correction" onclick="window.location='<?php echo site_url('editorSubmission/correction/'.$row['paper_id'])?>'" type="button" class="btn btn-warning btn-xs">
                                                      Correction
                                                    </button>
													<?php } ?>
														
													<?php 
													if($row['status'] >= 4){
													?>
													<button title="In Press" onclick="window.location='<?php echo site_url('editorSubmission/inpress/'.$row['paper_id'])?>'" type="button" class="btn btn-<?php echo $row['status'] == 4 ? 'success' : 'primary'?> btn-xs">
                                                      In Press
                                                    </button>
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


<script type="text/javascript">
$(function(){
	$('.remove').click(function(e){
		e.preventDefault();
		ajaxRedirectConfirm($(this).data('url') , 'Are you sure to remove this item ?');
	})
	
})
</script>