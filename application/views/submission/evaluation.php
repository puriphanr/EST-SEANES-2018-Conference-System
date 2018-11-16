 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-8">
							
                            <h1 class="title-4 place-inline">
								Paper Submission / Correction / Reviewer Evaluation
                            </h1>
							 
							
                           
                        </div> 
						<div class="col-md-4 text-right">
							<button onclick="window.location='<?php echo site_url('submission/reviewResult/'.$paper['paper_id'])?>'" class="au-btn au-btn-icon au-btn--blue au-btn--small">
                                <i class="zmdi zmdi-arrow-left"></i>back
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
								 <div class="card-header"><strong> Article Information</strong></div>
                                    <div class="card-body">
										<table class="table table-top-campaign">
                                            <tbody>
												<tr>
                                                    <td width="20%">Reviewer ID</td>
                                                    <td width="80%" class="text-left"><?php echo 'U'.str_pad($reviewers['reviewer_by'],4,0,STR_PAD_LEFT) ?></td>
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
					
							<table class="table table-bordered table-striped evaluation-table">
							  <thead class="thead-light">
								<tr>
								  <th width="50%" scope="col" rowspan="2">If the article requires any revision please give details of the suggested changes in the following reviewer’s comment section. </th>
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
										<div style="font-weight:bold; color:#4272d7"><strong><?php echo $row ?></strong></div>
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
									<td>
										<strong>Conference Proceedings Publication</strong>
									</td>
									<td>
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
										If the article was unacceptable please indicate your reasons so that we may inform the authors.
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
								
								<tr>
									<td colspan="2">
										<strong>Editor's Note</strong>
									</td>
								</tr>
								
								<tr>
									<td colspan="2">
										<?php echo $evaluation_row['editor_comment'] != "" ? $evaluation_row['editor_comment'] : "-"  ?>
									</td>
								</tr>
								
								
							  </tbody>
							</table>
							
							</div>
								</div>
							</div>
						</div>
					</div>
				
		</section>
		
	<div class="dialog" style="display:none;" id="dialog-reviewer" title="Add Reviewers">
		<div class="row dialog-body">
			<div class="col-md-12">
			<form method="post" id="reviewerForm" novalidate="novalidate">
				<div class="form-group">
					<label class="control-label mb-1">Reviewer</label>
					<select class="js-data-example-ajax form-control" id="reviewer-list" name="reviewer">
					</select>
				</div>
               
				<div class="form-group">
                    <label class="control-label mb-1">Due Date</label>
                    <input type="date" name="due_date" class="form-control"/>
                </div>
			</form>
			</div>
		</div>
	</div>

<script type="text/javascript">
$(function(){

	$('#reviewForm').validate({
		rules: {
			<?php foreach($evalution as $key=>$row){ ?>
			<?php echo $key?> :{
                required: true
            },
			<?php } ?>
            conference_public: {
                required: true
            },
			journal_public: {
                required: true
            }
        },
        submitHandler: function (form) { 
           ajaxPostConfirmSubmit("#reviewForm" , 'You could not change any comment and evaluation results after your submission.');
            return false; 
        }
	 });
	
})
</script>