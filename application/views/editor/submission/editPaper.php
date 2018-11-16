 <section class="welcome p-t-10">
                <div class="container">
                    <div class="row">
						 
                        <div class="col-md-6">
							
                            <h1 class="title-4 place-inline">
								Paper Submission
								
                            </h1>
							
                        </div> 
						 <div class="col-md-6 text-right">
							
											<button onclick ="window.location='<?php echo !$this->uri->segment(5) ? site_url('editorSubmission') : site_url('adminSettings/'.$this->uri->segment(5).'/'.$this->uri->segment(6))?>'" type="button" class="btn btn-secondary">
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
						<div class="col-12 col-md-12">
							<div class="card">
                                    <div class="card-header"><strong> Manuscript Information</strong></div>
                                    <div class="card-body">
                               
                                        <form action="<?php echo site_url('editorSubmission/editPaper/2/'.$this->uri->segment(4))?>" method="post" id="paperForm" enctype="multipart/form-data">
                           
											<div class="form-group">
                                                <label class="required bold" for="cc-payment" class="control-label mb-1">Article Title</label>
                                                <input id="title" name="title" class="form-control" value="<?php echo $this->uri->segment(4) ? $data['title'] : NULL ?>" type="text">
                                            </div>
                                          
											<div class="form-group">
												<div class="row">
													<div class="col-md-1">
														<label for="cc-payment" class="control-label mb-10 bold">Authors</label>
													</div>
													<div class="col-md-11">
														<div class="dropdown">
																  <button class="m-l-20 au-btn au-btn-icon au-btn--green au-btn--small dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	<i class="zmdi zmdi-plus"></i>add author</button>
																  </button>
																  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
																	<a class="dropdown-item" href="#" id="open-from-list">From List</a>
																	<a class="dropdown-item" href="#" id="open-custom">By Custom</a>
																  </div>
																</div>
													</div>
												</div>
												
                                              
														<input type="hidden" id="select_users" value="" />
														<input type="hidden" id="select-fname" value="" />
														<input type="hidden" id="select-lname" value="" />
														<input type="hidden" id="select-mname" value="" />
														<input type="hidden" id="select-address" value="" />
														<input type="hidden" id="select-email" value="" />
														<input type="hidden" id="select-city" value="" />
														<input type="hidden" id="select-state" value="" />
														<input type="hidden" id="select-country" value="" />
														<input type="hidden" id="select-postal" value="" />
												<div class="table-responsive table-responsive-data2">
													<table class="table table-data2" id="table-author">
														<thead>
															<tr>
																<th width="40%">Name / Email</th>
																<th width="40%">Contact Address</th>
																<th width="10%">Role</th>
																<th width="10%"></th>
															</tr>
														</thead>
														<tbody>
														<?php if(!$this->uri->segment(4)){ ?>
															<tr class="tr-border no-item">
																<td colspan="4">
																	<strong >
																		You don't have any author on this manuscript/article.
																	</strong>
																</td>
				
															</tr>
															<?php } else { ?>
															<?php foreach($authors as $key=>$row){ ?>
															<tr class="tr-border">
															  
																<td>
																	<input class="users_id" type="hidden" name="users_id[]" value="<?php echo $row['users_id']?>" />
																	<input class="fname" type="hidden" name="firstname[]" value="<?php echo $row['firstname']?>" />
																	<input class="mname" type="hidden" name="middlename[]" value="<?php echo $row['middlename']?>" />
																	<input class="lname" type="hidden" name="lastname[]" value="<?php echo $row['lastname']?>" />
																	<input class="address" type="hidden" name="contact_address[]" value="<?php echo $row['contact_address']?>" />
																	<input class="email" type="hidden" name="email[]" value="<?php echo $row['email']?>" />
																	<input class="is_corresponding" type="hidden" name="is_corresponding[]" value="<?php echo $row['is_corresponding']?>" />
																	<div  class="table-data__info">
																			<h6><?php echo $row['firstname'].' '.$row['middlename'].' '.$row['lastname']?></h6>
																			<span><a href="javascript:void(0)" style="cursor:default"><?php echo $row['email']?></a></span>
																	</div>
																	
																	
																</td>
																<td>
																		<div><?php echo nl2br($row['contact_address'])?></div>
																</td>
																
																<td>
																	<?php if($row['is_corresponding'] == 1){ ?>
																	<span class="status--process">Corresponding</span>
																	<?php }else{ ?>
																	<span>Author</span>
																	<?php } ?>
																</td>
																<td>
																
																		<div class="table-data-feature">
																			
																			<button type="button" class="item delete" data-toggle="tooltip" data-placement="top" title="Remove" data-original-title="Delete">
																				<i class="zmdi zmdi-delete"></i>
																			</button>
																		</div>
																	
																</td>
															</tr>		
																	
																	
																<?php } ?>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
											
											 <div class="form-group row">
												<div class="col-md-12">
													<label class="bold" for="cc-payment" class="control-label mb-1">Upload Manuscript/Article Files</label>
												</div>
											
												
											 </div>
											 
											  <div class="form-group row">
												<label class="col-md-2  required">1. PDF</label>
												<div class="col-md-5">
														<div class="input-group input-file" name="file_pdf" id="file_pdf_input" <?php echo $this->uri->segment(4) ? 'style="display:none"' : NULL ?>>
																
																<input type="text" class="form-control" />
																<span class="input-group-btn">
																	<button class="btn btn-success btn-choose" type="button">Choose</button>
																</span>
																
														</div>
														<?php if($this->uri->segment(4)){ ?>
														<div class="card fileInfo" id="file_pdf_uploaded">
															  <div class="card-body">
																<div class="row">
																	<div class="col-md-2">
																		<div class="h1"><i class="zmdi zmdi-file"></i></div>
																	</div>
																	<div class="col-md-8">
																		<div>
																			<?php echo $implode_corres_name."_".$data['paper_code'] ?>
																			<span class="badge badge-danger">PDF</span>
																		</div>
																		<div>
																		<a target="_blank" href="<?php echo  site_url("editorSubmission/forceDownload/".$data['paper_id']."/file_pdf")?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo DOC_VIEWER.base_url()?>uploads/<?php echo $data['file_pdf']?>" class="card-link">View</a>
																		</div>
																	</div>
																	<div class="col-md-2">
																		<div class="table-data-feature">
																			<button id="remove_pdf" type="button" class="item removeFile" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" aria-describedby="ui-id-1">
																					<i class="zmdi zmdi-delete"></i>
																			</button>
																		</div>
																	</div>
																</div>
																
															  </div>
														</div>
														
														<?php } ?>
												 </div>
											 </div>
											 
											  <div class="form-group row">
												<label class="col-md-2  required">2. MS-Word</label>
												<div class="col-md-5">
														<div class="input-group input-file" name="file_word" id="file_word_input" <?php echo $this->uri->segment(4) ? 'style="display:none"' : NULL ?>>
																<input type="text" class="form-control" />
																<span class="input-group-btn">
																	<button class="btn btn-success btn-choose" type="button">Choose</button>
																</span>
														</div>
														<?php if($this->uri->segment(4)){ ?>
														<div class="card fileInfo" id="file_word_uploaded">
															  <div class="card-body">
																<div class="row">
																	<div class="col-md-2">
																		<div class="h1"><i class="zmdi zmdi-file"></i></div>
																	</div>
																	<div class="col-md-8">
																		<div>
																			<?php echo $implode_corres_name."_".$data['paper_code'] ?>
																			<span class="badge badge-primary">WORD</span>
																		</div>
																		<div>
																		<a target="_blank" href="<?php echo  site_url("editorSubmission/forceDownload/".$data['paper_id']."/file_word")?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo DOC_VIEWER.base_url()?>uploads/<?php echo $data['file_word']?>" class="card-link">View</a>
																		</div>
																	</div>
																	<div class="col-md-2">
																		<div class="table-data-feature">
																			<button id="remove_word" type="button" class="item removeFile" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" aria-describedby="ui-id-1">
																					<i class="zmdi zmdi-delete"></i>
																			</button>
																		</div>
																	</div>
																</div>
																
															  </div>
														</div>
														
														<?php } ?>
												 </div>
											 </div>
											
											 <div class="form-group row">
												<label class="col-md-5  required">3. PDF with signature of Corresponding Authors</label>
												<div class="col-md-5">
														<div class="input-group input-file" name="file_signature" id="file_signature_input" <?php echo $this->uri->segment(4) ? 'style="display:none"' : NULL ?>>
																<input type="text" class="form-control" />
																<span class="input-group-btn">
																	<button class="btn btn-success btn-choose" type="button">Choose</button>
																</span>
														</div>
														<?php if($this->uri->segment(4)){ ?>
														<div class="card fileInfo" id="file_signature_uploaded">
															  <div class="card-body">
																<div class="row">
																	<div class="col-md-2">
																		<div class="h1"><i class="zmdi zmdi-file"></i></div>
																	</div>
																	<div class="col-md-8">
																		<div>
																			<?php echo $implode_corres_name."_".$data['paper_code']."-signature" ?>
																			<span class="badge badge-danger">PDF</span>
																		</div>
																		<div>
																		<a target="_blank" href="<?php echo  site_url("editorSubmission/forceDownload/".$data['paper_id']."/file_signature")?>" class="card-link">Download</a>
																		<a class="m-l-10" target="_blank" href="<?php echo DOC_VIEWER.base_url()?>uploads/<?php echo $data['file_signature']?>" class="card-link">View</a>
																		</div>
																	</div>
																	<div class="col-md-2">
																		<div class="table-data-feature">
																			<button id="remove_signature" type="button" class="item removeFile" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" aria-describedby="ui-id-1">
																					<i class="zmdi zmdi-delete"></i>
																			</button>
																		</div>
																	</div>
																</div>
																
															  </div>
														</div>
														
														<?php } ?>
												 </div>
											 </div>
												
											 <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1 bold">Note</label>
                                                <textarea name="note" rows="8" class="form-control" id="note"><?php echo $this->uri->segment(4) ? $data['note'] : NULL ?></textarea>
                                            </div>
											
											<div class="form-actions form-group text-center p-t-20">
															<button type="submit" class="btn btn-primary btn-lg">Save</button>
															<button type="reset" class="btn btn-secondary btn-lg">Clear</button>
											</div>
                                        </form>
                                    </div>
                                </div>
                        </div>
						
					</div>
				</div>
</section>
	<div class="dialog" style="display:none;" id="dialog-from-list" title="Add Author">
		<div class="row dialog-body">
			<div class="col-md-12">
			<form action="" method="post" id="customForm" novalidate="novalidate">
				<div class="form-group">
					<label class="control-label mb-1">Author</label>
					<select class="js-data-example-ajax form-control" id="user-list">
					</select>
				</div>
               
				<div class="form-group">
                    <label class="control-label mb-1">Author Position</label>
                    <select name="is_corresponding" id="is_corresponding1" class="form-control">
						<option value="1">Corresponding</option>
						<option value="2">Author</option>
					</select>
                </div>
			</form>
			</div>
		</div>
	</div>
	
	<div class="dialog" style="display:none;" id="dialog-author" title="Add Author">
		<div class="row dialog-body">
			<div class="col-md-12">
			<form action="" method="post" id="customForm" novalidate="novalidate">
				
                <div class="form-group col-md-12">
                    <label class="control-label mb-1">First Name</label>
                    <input id="firstname" name="firstname" type="text" class="form-control" >
                </div>
				<div class="form-group col-md-12">
                    <label class="control-label mb-1">Middle Name</label>
                    <input id="middlename" name="middlename" type="text" class="form-control" >
                </div>
				<div class="form-group col-md-12">
                    <label class="control-label mb-1">Last Name</label>
                    <input id="lastname" name="lastname" type="text" class="form-control" >
                </div>
				<div class="form-group col-md-12">
                    <label class="control-label mb-1">Contact Address</label>
                    <textarea name="contact_address" id="contact_address" rows="4" class="form-control"></textarea>
                </div>
				<div class="form-group col-md-12">
                    <label class="control-label mb-1">Email</label>
                    <input id="email" name="email" type="text" class="form-control" >
                </div>
				<div class="form-group col-md-12">
                    <label class="control-label mb-1">Author Position</label>
                    <select name="is_corresponding" id="is_corresponding2" class="form-control">
						<option value="1">Corresponding</option>
						<option value="2">Author</option>
					</select>
                </div>
			</form>
			</div>
		</div>
	</div>

<script type="text/javascript">
$(function(){
	$('#open-from-list').click(function(e){
		e.preventDefault();
		 $('#dialog-from-list').dialog({
                    autoOpen: true,
                    width : $(window).width() > 600 ? 600 : 'auto',
					minheight: 150,
                    modal: true,
                    buttons: {
                        "Add": function(){
							save_data_from_list();
							$("#user-list").val("");
							 $(this).dialog("close");
						},
                        "Cancel": function () {
                            $(this).dialog("close");
							$("#user-list").val("");
                        }
                    },
                    close: function () {
                         $(this).dialog("close");
						 $("#user-list").val("");
                    }
             });
		
	})
							
	 $("#user-list").select2({
	  ajax: {
		url: "<?php echo site_url('editorSubmission/getUser')?>",
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
	   placeholder: "Please choose registered author",
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
	
	$('#user-list').on("select2:select", function(e) { 
		$("#select_users").val(e.params.data.users_id) ;
		$("#select-fname").val(e.params.data.firstname) ;  
		$("#select-mname").val(e.params.data.middlename)  ; 
		$("#select-lname").val(e.params.data.lastname)  ; 
		$("#select-address").val(e.params.data.contact_address)  ; 
		$("#select-email").val(e.params.data.email) ;  
		$("#select-city").val(e.params.data.city)  ; 
		$("#select-state").val(e.params.data.state)  ; 
		$("#select-country").val(e.params.data.country_name)  ; 
		$("#select-postal").val(e.params.data.postal_code) ;
	});
	
	function save_data_from_list() {
			if($('.no-item').length > 0){
				$('.no-item').hide();
			}
			var html = '<tr class="tr-border">';
				html+= '	<td>';
				html+= '		<input class="users_id" type="hidden" name="users_id[]" value="'+$('#select_users').val()+'" />';
				html+= '		<input class="fname" type="hidden" name="firstname[]" value="'+$('#select-fname').val()+'" />';
				html+= '		<input class="mname" type="hidden" name="middlename[]" value="'+$('#select-mname').val()+'" />';
				html+= '		<input class="lname" type="hidden" name="lastname[]" value="'+$('#select-lname').val()+'" />';
				html+= '		<input class="address" type="hidden" name="contact_address[]" value="'+$('#select-address').val()+'" />';
				html+= '		<input class="email" type="hidden" name="email[]" value="'+$('#select-email').val()+'" />';
				html+= '		<input class="role" type="hidden" name="is_corresponding[]" value="'+$('#is_corresponding1').val()+'" />';
				html+= '					<div class="table-data__info">';
				html+= '						<h6>'+$('#select-fname').val()+' '+$('#select-mname').val()+' '+$('#select-lname').val()+'</h6>';
				html+= '						<span><a href="javascript:void(0)" style="cursor:default">'+$('#select-email').val()+'</a></span>';
				html+= '					</div>';
				html+= '				</td>';
				html+= '				<td>';
				html+= '					<div>'+$('#select-address').val()+'</div>';		
				html +='					<div>'+$('#select-city').val()+' '+$('#select-state').val()+' </div>';	
				html +='					<div>'+$('#select-country').val()+' '+$('#select-postal').val()+' </div>';	
				html+= '				</td>';
				html+= '				<td>';
				if($('#is_corresponding1').val() == 1){
					html+= '					<span class="status--process">Corresponding</span>';
				}
				else{
					html+= '					<span>Author</span>';
				}
				html+= '				</td>';
				html+= '				<td>';
				html+= '					<div class="table-data-feature">';					
				html+= '						<button type="button" class="item delete" data-toggle="tooltip" data-placement="top" title="Remove" data-original-title="Delete">';
				html+= '							<i class="zmdi zmdi-delete"></i>';
				html+= '						</button>';
				html+= '					</div>';
				html+= '				</td>';
				html+= '			</tr>';
            $("#table-author tbody").append(html);
         }


	var new_dialog = function(type,row){
		var dlg = $('#dialog-author').clone();
		var fname = dlg.find(("#firstname")),
			mname = dlg.find(("#middlename")),
			lname = dlg.find(("#lastname")),
			email = dlg.find(("#email")),
			address = dlg.find(("#contact_address"));
			corr = dlg.find(("#is_corresponding2"));
		 type = type || 'Create';
		 
		
		 
		  var config = {
                    autoOpen: true,
                    width : $(window).width() > 600 ? 600 : 'auto',
					minheight: 150,
                    modal: true,
                    buttons: {
                        "Add": function(){
							save_data();
						},
                        "Cancel": function () {
                            dlg.dialog("close");
                        }
                    },
                    close: function () {
                        dlg.remove();
                    }
             };
			 
		 if (type === 'Edit') {
                    config.title = "Edit Author";
                    get_data();
                    delete (config.buttons['Add']);
                    config.buttons['Edit account'] = function () {
                        row.remove();
                        save_data(); 
                    }; 
        }
		dlg.dialog(config); 
		
		function get_data() {
                    var _fname = $(row.children().find('.fname')).val(),
					 _mname = $(row.children().find('.mname')).val(),
					 _lname = $(row.children().find('.lname')).val(),
					 _address = $(row.children().find('.address')).val(),
					 _email = $(row.children().find('.email')).val();
					 _corr = $(row.children().find('.is_corresponding')).val();
                    email.val(_email);
                    fname.val(_fname); 
					lname.val(_lname);
					mname.val(_mname);
					address.val(_address);
					corr.val(_corr);
        } 

        function save_data() {
			if($('.no-item').length > 0){
				$('.no-item').hide();
			}
			var html = '<tr class="tr-border">';
				html+= '	<td>';
				html+= '		<input class="users_id" type="hidden" name="users_id[]" value="" />';
				html+= '		<input class="fname" type="hidden" name="firstname[]" value="'+fname.val()+'" />';
				html+= '		<input class="mname" type="hidden" name="middlename[]" value="'+mname.val()+'" />';
				html+= '		<input class="lname" type="hidden" name="lastname[]" value="'+lname.val()+'" />';
				html+= '		<input class="address" type="hidden" name="contact_address[]" value="'+address.val()+'" />';
				html+= '		<input class="email" type="hidden" name="email[]" value="'+email.val()+'" />';
				html+= '		<input class="is_corresponding" type="hidden" name="is_corresponding[]" value="'+corr.val()+'" />';
				html+= '					<div class="table-data__info">';
				html+= '						<h6>'+fname.val()+' '+mname.val()+' '+lname.val()+'</h6>';
				html+= '						<span><a href="javascript:void(0)" style="cursor:default">'+email.val()+'</a></span>';
				html+= '					</div>';
				html+= '				</td>';
				html+= '				<td>';
				html+= '					<div>'+address.val()+'</div>';		
				html+= '				</td>';
				html+= '				<td>';
			
					if(corr.val() == 1){
					html+= '					<span class="status--process">Corresponding</span>';
					}
					else{
						html+= '					<span>Author</span>';
					}
				html+= '				</td>';
				html+= '				<td>';
				html+= '					<div class="table-data-feature">';
				html+= '						<button type="button" class="item edit" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit">';
				html+= '							<i class="zmdi zmdi-edit"></i>';
				html+= '						</button>';
				html+= '						<button type="button" class="item delete" data-toggle="tooltip" data-placement="top" title="Remove" data-original-title="Delete">';
				html+= '							<i class="zmdi zmdi-delete"></i>';
				html+= '						</button>';
				html+= '					</div>';
				html+= '				</td>';
				html+= '			</tr>';
            $("#table-author tbody").append(html);
			dlg.dialog("close");
         }
	}; 

     $(document).on('click', '.delete', function () {
		 
         $(this).closest('tr').find('td').fadeOut(100, 
        function () {
            $(this).parents('tr:first').remove();

        }); 
		 if($('#table-author>tbody>tr').length <= 2){
			 $('.no-item').show();
		 }
        return false;
     });

    $(document).on('click', 'td .edit', function () {
        new_dialog('Edit', $(this).parents('tr'));
        return false;
    }); 

    $("#open-custom").click(function(e){
		e.preventDefault();
		new_dialog();
	}); 
	bs_input_file();
	
	<?php if(!$this->uri->segment(4)){ ?>
	$('#paperForm').validate({
		rules: {
            title: {
                required: true
            },
			file_pdf: {
                required: true,
				 extension: "pdf"
            },
			file_word:{
				 required: true,
				 extension: "doc|docx"
			},
			file_signature:{
				 required: true,
				 extension: "pdf"
			}
        },
		messages: {
			file_pdf: {
				extension : 'Please correct and submit only PDF file'
			},
			file_word: {
				extension : 'Please correct and submit only Microsoft Word file'
			},
			file_signature: {
				extension : 'Please correct and submit only PDF file'
			}
		},
        submitHandler: function (form) { 
            ajaxPostSubmit("#paperForm");
            return false; 
        }
	 });
	<?php }else{ ?>
	$('#paperForm').validate({
		rules: {
            title: {
                required: true
            }
        },
        submitHandler: function (form) { 
           ajaxPostConfirmSubmit("#paperForm" , 'Are you sure to change this instruction ?');
            return false; 
        }
	 });
	 
	 $('#remove_pdf').click(function(e){
		 e.preventDefault();
		 removeFile_showInput('#file_pdf_uploaded','#file_pdf_input'); 
		$('input[name="file_pdf"]').rules("add", {
			 required: true,
			extension: "pdf",
			 messages: {
				extension : 'Please correct and submit only PDF file'
			  }
		 });
	 })
	  $('#remove_word').click(function(e){
		 e.preventDefault();
		 removeFile_showInput('#file_word_uploaded','#file_word_input'); 
		 $('input[name="file_word"]').rules("add", {
			 required: true,
			 extension: "doc|docx",
			 messages: {
				extension : 'Please correct and submit only Microsoft Word file'
			  }
		 });
		
	 })
	  $('#remove_signature').click(function(e){
		 e.preventDefault();
		 removeFile_showInput('#file_signature_uploaded','#file_signature_input'); 
		  $('input[name="file_signature"]').rules("add", {
			 required: true,
			extension: "pdf",
			 messages: {
				extension : 'Please correct and submit only PDF file'
			  }
		 });
	 })
	
	<?php } ?>
})
</script>