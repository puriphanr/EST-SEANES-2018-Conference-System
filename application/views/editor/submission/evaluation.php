 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-8">
							
                            <h1 class="title-4 place-inline">
								Paper Submission / Reviewers / Evaluation
                            </h1>
							 
							
                           
                        </div> 
						<div class="col-md-4 text-right">
							<button onclick="window.history.back(-1)" class="au-btn au-btn-icon au-btn--blue au-btn--small">
                                <i class="zmdi zmdi-arrow-left"></i>back
							</button>
							
						</div>
					
						<hr class="line-seprate">
							
                    </div>
                </div>
            </section>
			
		<form id="evaForm" method="post" action="<?php echo site_url('editorSubmission/evaluationAction/'.$this->uri->segment(3))?>" >
			<input type="hidden" id="type" name="type" value="" />
			<section class="p-t-20">
                <div class="container">
                    <div class="row">
						<div class="col-md-12">
								<div class="card">
								 <div class="card-header"><strong> Article Information</strong></div>
                                    <div class="card-body">
										<table class="table table-top-campaign">
                                            <tbody>
												<tr>
                                                    <td width="30%">Reviewer's Name</td>
                                                    <td  width="70%" class="text-left"><?php echo $reviewers['firstname']?> <?php echo $reviewers['lastname']?></td>
                                                </tr>
												<tr>
                                                    <td>Please return by Date</td>
                                                    <td class="text-left"><?php echo date('d/m/Y' ,strtotime($reviewers['due_time']))?></td>
                                                </tr>
                                                <tr>
                                                    <td>Article ID</td>
                                                    <td class="text-left"><?php echo $paper['paper_code']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Article Title</td>
                                                    <td class="text-left"><?php echo $paper['title']?></td>
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
							<div class="card-header">
								<div class="row">
									<div class="col-md-12">
										<strong> Evaluation</strong>
									</div>
									
								</div>
							</div>
                            <div class="card-body">
							<div style="margin-bottom:20px">
							<table class="table table-top-campaign">
                                            <tbody>
												<tr>
                                                    <td width="20%">Reviewer Status</td>
                                                    <td width="80%" class="text-left">
													<?php 
													  if($reviewers['review_status'] == 1){
														  echo '<span class="badge badge-secondary"><h5>Waiting</h5></span>';
													  }
													  elseif($reviewers['review_status'] == 2){
														   echo '<span class="badge badge-primary"><h5>Accept</h5></span>';
													  }
													  elseif($reviewers['review_status'] == 3){
														   echo '<span class="badge badge-danger"><h5>Reject</h5></span>';
													  }
													  else{
															 echo '<span class="badge badge-success"><h5>Completed</h5></span>';	
													  }
													 
													  ?>
													</td>
                                                </tr>
												
											</tbody>
							</table>
							</div>
							<?php if($reviewers['review_status'] == 2 || $reviewers['review_status'] >= 4){ ?>
							<table class="table table-bordered evaluation-table">
							  <thead class="thead-light">
								<tr>
								  <th width="50%" scope="col" rowspan="2" class="text-center"></th>
								  <th scope="col" class="text-center" colspan="5">Quality Rating</th>
								 
								</tr>
								<tr>
									<th scope="col" width="10%" class="text-center"><div>Very Poor</div><div>1</div></th>
									<th scope="col" width="10%" class="text-center"><div>Poor</div><div>2</div></th>
									<th scope="col" width="10%" class="text-center"><div>Adequate</div><div>3</div></th>
									<th scope="col" width="10%" class="text-center"><div>Good</div><div>4</div></th>
									<th scope="col" width="10%" class="text-center"><div>Excellent</div><div>5</div></th>
								</tr>
							  </thead>
							  <tbody>
								<?php 
								$total = 0;
								foreach($evalution as $key=>$row){ ?>
								<tr>
									<td>
										<div><strong><?php echo $row ?></strong></div>
										<div><small><strong>Comment :</strong></small></div>
										<div><small>
										<?php echo $evaluation_row && $evaluation_row[$key.'_comment'] != "" ? $evaluation_row[$key.'_comment'] : '-' ?>
										</small></div>
									</td>
									<td class="text-center"><?php echo $evaluation_row && $evaluation_row[$key] == 1 ? '<i class="fa fa-check"></i>' : '-' ?></td>
									<td class="text-center"><?php echo $evaluation_row && $evaluation_row[$key] == 2 ? '<i class="fa fa-check"></i>' : '-' ?></td>
									<td class="text-center"><?php echo $evaluation_row && $evaluation_row[$key] == 3 ? '<i class="fa fa-check"></i>' : '-' ?></td>
									<td class="text-center"><?php echo $evaluation_row && $evaluation_row[$key] == 4 ? '<i class="fa fa-check"></i>' : '-' ?></td>
									<td class="text-center"><?php echo $evaluation_row && $evaluation_row[$key] == 5 ? '<i class="fa fa-check"></i>' : '-' ?></td>
								</tr>
								<?php
								$total = $total+$evaluation_row[$key];
								} ?>
								<tr>
									<td class="text-right"><strong>Total Score</strong></td>
									<td colspan="5" class="text-right"><strong><?php echo number_format($total,0) ?><strong></td>
								
								</tr>
							  </tbody>
							</table>
							
							
							<table class="table table-bordered evaluation-result-table" style="margin-top:20px">
							
							  <tbody>
								
								<tr>
									<td colspan="2">
										<strong>Evaluation</strong> : Based on the above points please indicate your recommendation for Conference Proceedings Publication and Journal Publication
									</td>	
								</tr>
								<tr>
									<td width="50%">
										<strong>Conference Proceedings Publication</strong>
									</td>
									<td width="50%">
										<strong>Journal Publication (selected paper)</strong>
									</td>
								</tr>
								<tr>
									<td>
											<?php echo $evaluation_row ? $evaluation_conference[$evaluation_row['conference_public']] : '-' ?>
									</td>
										<td>
											<?php echo $evaluation_row ? $evaluation_journal[$evaluation_row['journal_public']] : '-' ?>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										If the article requires any revision please give details of the suggested changes in the following reviewer’s comment section. If the article was unacceptable please indicate your reasons so that we may inform the authors.
									</td>	
								</tr>
								<tr>
									<td>
											<div><strong>Reason and more comments :</strong></div>
											<div><?php echo $evaluation_row && $evaluation_row['conference_comment'] != "" ? $evaluation_row['conference_comment'] : '-' ?></div>
									</td>
									<td>
											<div><strong>Reason and more comments : </strong></div>
											<div><?php echo $evaluation_row && $evaluation_row['journal_comment'] != "" ? $evaluation_row['journal_comment'] : '-' ?></div>
									</td>
								</tr>
								
							  </tbody>
							</table>
							<?php if($reviewers['review_status'] == 4){ ?>
							
										<div class="form-group" style="margin-top:20px">
											<label><strong>Note</strong></label>
											
											<textarea name="editor_comment" class="form-control" rows="5"><?php echo $evaluation_row && $evaluation_row['editor_comment'] != "" ? $evaluation_row['editor_comment'] : '-' ?></textarea>
										</div>
										
										<div class="col-md-12 text-center">
										<button id="update" <?php echo $reviewers['review_status'] < 4 ? 'disabled' : NULL ?> type="button" class="btn btn-secondary btn-lg">Update Note</button>
										<button type="button" <?php echo $reviewers['review_status'] < 4 ? 'disabled' : NULL ?>  onclick="window.location='<?php echo site_url('editorSubmission/printEvaluation/'.$this->uri->segment(3))?>'" class="btn btn-primary btn-lg">
										Print
										</button>
										</div>
							<?php } ?>		
							
							
							
							<?php } ?>
							</div>
								</div>
							</div>
						</div>
					</div>
				
		</section>
		
	</form>
	
<script type="text/javascript">
$(function(){
	
	$('#update').click(function(e){
		e.preventDefault();
		$('#type').val(1);
		$('#evaForm').validate({
			rules: {
				editor_comment: {
					required: true
				}
			}
		 });
		 
		 if ($('#evaForm').valid()) {
				ajaxPostConfirmSubmit("#evaForm" , 'Are you sure to update note for this evaluation ?');
				
		 }
	})
	
	$('#open-dialog').click(function(e){
		e.preventDefault();
		
		
		 $('#dialog-reviewer').dialog({
                    autoOpen: true,
                    width : $(window).width() > 600 ? 600 : 'auto',
					minheight: 150,
                    modal: true,
                    buttons: {
                        "Add": function(){
							$.ajax({
								url: "<?php echo site_url('editorSubmission/saveReviewer/'.$this->uri->segment(3))?>",
								type : 'POST',
								data : $('#reviewerForm').serialize(),
								dataType: 'json',
								beforeSend : function(){
									showDialogWait();
								},
								success : function (callback) {
									$('#dialog-wait').dialog('close');
									if(callback[0] == 1){
										window.location = callback[1];
									}
									else{
										showDialogError(callback[1]);	
									}
									$("#reviewer-list").val("");
									$(this).dialog("close");
								}
							})
							
						},
                        "Cancel": function () {
                            $(this).dialog("close");
							$("#reviewer-list").val("");
                        }
                    },
                    close: function () {
                         $(this).dialog("close");
						 $("#reviewer-list").val("");
                    }
             });
		
	})
	
	

})
</script>