 
            <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-8">
							
                            <h1 class="title-4 place-inline">
								Paper Submission / Reviewers
                            </h1>
							 
							
                           
                        </div> 
						<div class="col-md-4 text-right">
							<button onclick="window.location='<?php echo site_url('editorSubmission')?>'" class="au-btn au-btn-icon au-btn--blue au-btn--small">
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
                                                    <td width="10%">Article ID</td>
                                                    <td width="90%" class="text-left"><?php echo $paper['paper_code']?></td>
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
									<div class="col-md-6">
										<strong> Reviewer List</strong>
									</div>
									<div class="col-md-6 text-right">
										
										
											<button type="button" id="open-dialog" class="btn btn-success btn-sm">
												<i class="fa fa-plus"></i> Add Reviewer
											</button>
										
										
								</div>
								</div>
							</div>
                            <div class="card-body">
									
										<?php if(!empty($reviewers)){ ?>
                           <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-data2">
                                    <thead>
                                        <tr>
											
											<th width="40%">Reviewer Name</th>
                                            <th width="10%">Status</th>
                                            <th width="15%">Due Date</th>
											<th width="25%">Assign by</th>
                                            <th width="10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
										foreach($reviewers as $key=>$row) {

										?>
                                        <tr class="tr-shadow">
											
											<td><?php echo $row['reviewer_info_firstname']?> <?php echo $row['reviewer_info_lastname']?></td>
                                            <td>
												<div class="h6">
                                              <?php 
											  if($row['review_status'] == 1){
												  echo '<span class="badge badge-secondary">Waiting</span>';
											  }
											  elseif($row['review_status'] == 2){
												   echo '<span class="badge badge-warning">Accept</span>';
											  }
											  elseif($row['review_status'] == 3){
												   echo '<span class="badge badge-danger">Reject</span>';
											  }
												elseif($row['review_status'] == 4){
													 echo '<span class="badge badge-success">Completed</span>';	
											  }
											  else{
												   echo '<span class="badge badge-primary">Sent</span>';	
												  
											  }
											 
											  ?></div>
                                            </td>
                                            <td>
											<?php 
											
											$arrDate1 = explode("-",date('Y-m-d',strtotime($row['due_time'])));
											$arrDate2 = explode("-",date('Y-m-d'));
											$timStmp1 = mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]);
											$timStmp2 = mktime(0,0,0,$arrDate2[1],$arrDate2[2],$arrDate2[0]);

											if($timStmp1 < $timStmp2 && ($row['review_status'] == 1 || $row['review_status'] == 2)){ ?>
												<div class="status--denied"><?php echo date('d/m/Y',strtotime($row['due_time'])) ?></div>
												<div class="status--denied">Overdue</div>
											<?php }else{ ?>
												<?php echo date('d/m/Y',strtotime($row['due_time'])) ?>
											<?php } ?>
												
											</td>
                                          
											<td>
												<div><?php echo $row['assign_info_firstname']?> <?php echo $row['assign_info_lastname']?></div>
												<div><small><?php echo date('d/m/Y H:i', strtotime($row['assign_time']))?></small></div>
												
											</td>
                                            <td>
                                                <div class="table-data-feature">
													 <button title="Evaluation" type="button" onclick="window.location='<?php echo site_url('editorSubmission/evaluation/'.$row['reviewer_id'])?>'" class="btn btn-primary btn-xs">
                                                      View
                                                    </button>
													&nbsp;
                                                    <button title="Remove" type="button" data-url="<?php echo site_url('editorSubmission/removeReviewer/'.$row['reviewer_id'])?>" class="btn btn-danger btn-xs remove">
                                                       Remove
                                                    </button>
                                                   
                                                </div>
                                            </td>
                                        </tr>
                                      
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
							
							<?php } else { ?>
							<div class="alert alert-dark m-t-30" role="alert">
									You don't have any reviewers for this article <span class="badge badge-success">+ Add Reviewer</span> to add information
							</div>
							
							<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				
		</section>
		
	
	<div class="dialog" style="display:none;" id="dialog-reviewer" title="Add Reviewers">
		<div class="row dialog-body">
			<div class="col-md-12">
			<form method="POST" id="reviewerForm" >
				<div class="form-group">
					<label class="required control-label mb-1">Reviewer</label>
					<select class="js-data-example-ajax form-control" id="reviewer" name="reviewer">
					</select>
				</div>
               
				<div class="form-group">
                    <label class="required control-label mb-1">Due Date</label>
                    <input type="text" name="due_date" class="form-control datepicker"/>
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
	
	$('.cannot-send').click(function(e){
		e.preventDefault();
		showDialogError('Cannot send this evaluation before completed status');
	})
	
	$('#send-correction-btn').click(function(e){
		e.preventDefault();
		var ck_box = $('.send-correction:checked').length;
		if(ck_box == 0){
		  showDialogError('Please select at least one of evaluation');
		} 
		else{
			 $('#dialog-revise').dialog({
                    autoOpen: true,
                    width : $(window).width() > 600 ? 600 : 'auto',
					minheight: 150,
                    modal: true,
                    buttons: {
                        "Send Correction": function(){
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
			
		}
	});
	
	$( ".datepicker" ).datepicker({
		changeMonth : true,
		changeYear : true,
		minDate: 0,
		dateFormat : 'dd/mm/yy'
	}).focus(function() {
        $(".ui-datepicker-prev, .ui-datepicker-next").remove();
	});
	
	
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
	
	$("#reviewer").select2({
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
		  "<div class='select2-result-repository__title'><strong>" + repo.nameFull +"</strong></div>"+
		   "<div class='select2-result-repository__country'>Country: " + repo.country_name +"</div>"+
		   "<div class='select2-result-repository__email'>Email: " + repo.email + "</div>";
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