 <?php
if($this->session->userdata('is_logged_in')){
	$sess_users = $this->session->userdata('is_logged_in');
}
 ?>
  
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4 place-inline">
							Paper Submission / Reviewing Result
                            </h1>
							
                        </div> 
						 <div class="col-md-6 text-right">
							
											<button onclick ="window.location='<?php echo site_url('submission')?>'" type="button" class="btn btn-secondary">
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
							<div class="card-header">
								<div class="row">
									<div class="col-md-12">
										<strong>Reviewing Result</strong>
									</div>
									
								</div>
							</div>
                            <div class="card-body">
							
								<div class="p-b-30">
									<h4 class="p-b-20">Aritcle Information</h4>
									<div class="table-responsive table--no-card m-b-30">
									<table class="table table-top-campaign">
                                            <tbody>
											
                                                <tr>
                                                    <td>Article ID</td>
                                                    <td class="text-left"><?php echo $paper['paper_code']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Article Title</td>
                                                    <td class="text-left"><?php echo $paper['title']?></td>
                                                </tr>
												<tr>
                                                    <td>Status</td>
                                                    <td class="text-left">
													 <?php 
													
											  if($paperStatus['status_type'] == 1){
												  echo '<span class="badge badge-secondary">Waiting</span>';
											  }
											  elseif($paperStatus['status_type'] == 2){
												   echo '<span class="badge badge-warning">In Review</span>';
											  }
											  elseif($paperStatus['status_type'] == 3){
												   echo '<span class="badge badge-danger">In Correction</span>';
											  }
											  elseif($paperStatus['status_type'] == 4){
												   echo '<span class="badge badge-success">In Press</span>';
											  }
											  else{
												   echo '<span class="badge badge-danger">2<sup>nd</sup> Revise</span>';
											  }
												
											  ?>
													</td>
                                                </tr>
												
                                            </tbody>
                                        </table>
									</div>
									
								</div>
								
								<div class="p-b-30">
									<?php if($stage == 1){ ?>
									<h4 class="p-b-20">1<sup>st</sup> Submission Evaluation</h4>
									
									<div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-data2">
                                    <thead>
                                        <tr>
											
											<th width="25%">Reviewer ID</th>
											<th width="10%">Total Score</th>
											<th width="30%">Conference Proceedings Publication</th>
											<th width="30%">Journal Publication</th>
                                           
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
										foreach($reviewers as $key=>$row) {

										?>
                                        <tr class="tr-shadow">
											
											<td><strong><?php echo 'U'.str_pad($row['reviewer_by'],4,0,STR_PAD_LEFT) ?></strong></td>
											
                                            <td class="text-center">
												<?php 
												$total = 0;
												for($i=1;$i<=12;$i++){ 
													$total += $row['q'.$i];
												}
												echo $total;
												?>
                                            </td>
											<td><?php echo $evaluation_conference[$row['conference_public']]?></td>
											<td><?php echo $evaluation_journal[$row['journal_public']]?></td>
                                       
                                            <td>
                                                <div class="table-data-feature">
													 <button title="View" type="button" onclick="window.location='<?php echo site_url('submission/correctionEvaluation/'.$row['reviewer_id'])?>'" class="btn btn-primary btn-xs">
                                                      View
                                                    </button>
													
													&nbsp;
                                                     <button title="Print" type="button" onclick="window.location='<?php echo site_url('submission/printEvaluation/'.$row['reviewer_id'])?>'" class="btn btn-danger btn-xs">
                                                      Print
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                      
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
									
									
									
									<?php } else { ?>
									
									<h4 class="p-b-20">Note from editor</h4>
									
									<div class="m-b-30">
									<?php echo $paper['editor_revise_note'] ?>
									</div>
									
									
									<?php } ?>
								</div>
					
							</div>
							</div>
							</div>
						</div>
					</div>
		</section>