 
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
                                                    <td>Reviewer's Name</td>
                                                    <td class="text-left"><?php echo $reviewers['firstname']?> <?php echo $reviewers['lastname']?></td>
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
						
							<table class="table table-bordered">
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
							
							
							<table class="table table-bordered" style="margin-top:20px">
							
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
	$('.remove').click(function(e){
		e.preventDefault();
		ajaxRedirectConfirm($(this).data('url') , 'Are you sure to remove this item ?');
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
	
	$("#reviewer-list").select2({
	  ajax: {
		url: "<?php echo site_url('editorSubmission/getReviewer')?>",
		type : 'POST',
		dataType: 'json',
		 data: function (params) {
		  return {
			q: params.term
		  };
		},
		 dropdownParent: $('#dialog-from-list'),
		delay: 100,
		processResults: function (data , params) {
			var select2Data = $.map(data.items, function (obj) {
                    obj.id = obj.users_id;
                    obj.firstname = obj.firstname;
					obj.lastname = obj.lastname;
					obj.middlename = obj.middlename;
					obj.email = obj.email;
                    return obj;
           });
		  return {
			results: select2Data,
		  };
		},
		cache: true
	  },
	   placeholder: "Please choose registered scientific committee",
	  escapeMarkup: function (markup) { return markup; }, 
	  minimumInputLength: 1,
	  templateResult: formatRepo,
	  templateSelection: formatRepoSelection
	});
	
	$.ui.dialog.prototype._allowInteraction = function (e) {
    return true;
};

	function formatRepo (repo) {
	 if (!repo.nameFull) {
		return repo.text;
	}
	  var markup = "<div class='select2-result-repository clearfix'>" +
		"<div class='select2-result-repository__meta'>" +
		  "<div class='select2-result-repository__title'>" + repo.nameFull +"</div>"+
		   "<div class='select2-result-repository__email'>(" + repo.email + ")</div>";
	  return markup;
	}

	function formatRepoSelection (repo) {
		if (repo.nameFull) {
			 return repo.nameFull+" ("+repo.email+")" ;
			
		}
		else{
			return repo.text;
		}
	  
	}

})
</script>