function ajaxPostSubmit(form){
		var formData = $(form);
        $.ajax({
           url : formData.attr("action"),
           type : "POST",
           data : new FormData(formData[0]),
           processData: false,
           contentType: false,
           dataType: "json",
           beforeSend : function(){ showDialogWait(); },
           success : function(data){
			   
			   $("#dialog-wait").dialog("close");
               if(data[0]){
				  window.location = data[1];
               }
               else{
                 showDialogError(data[1]);
               }
           }
        });

}

function ajaxPostConfirmSubmit(form , message){
	  var formData = $(form);
      $( "#dialog-warn .dialog-text" ).html(message);
		$( "#dialog-warn" ).dialog({
			modal: true,
			width: $(window).width() > 600 ? 400 : 'auto',
			minheight: 150,
			buttons: {
			'OK': function() {
				$( this ).dialog( "close" );
					$.ajax({
						url : formData.attr('action'),
						type : "POST",
						data : new FormData(formData[0]),
						   processData: false,
						   contentType: false,
						dataType: "json",
						beforeSend : function(){ 
							showDialogWait(); 
						},
						success : function(callback){
							 
							$("#dialog-wait").dialog("close");
							if(callback[0]){
								window.location = callback[1];
							}
							else{
								showDialogError(callback[1]);
							}
						}
					})
			},
			'Cancel' : function(){
				$( this ).dialog( "close" );
			}
		  }
		});
}

function ajaxRedirectConfirm(redirectUrl , message){
	
		$( "#dialog-warn .dialog-text" ).html(message);
		$( "#dialog-warn" ).dialog({
			modal: true,
			width: $(window).width() > 600 ? 400 : 'auto',
			minheight: 150,
			buttons: {
			'OK': function() {
					$.ajax({
						url : redirectUrl,
						type : "POST",
						dataType: "json",
						beforeSend : function(){ 
							showDialogWait(); 
						},
						success : function(callback){
							$("#dialog-wait").dialog("close");
							if(callback[0]){
								window.location = callback[1];
							}
							else{
								showDialogError(callback[1]);
							}
						}
					})
			},
			'Cancel' : function(){
				$( this ).dialog( "close" );
			}
		  }
		});

}

function showDialogWait(){
	 $( "#dialog-wait" ).dialog({
        modal: true,
        closeOnEscape: false,
        beforeclose: function (event, ui) { return false; },
        dialogClass: "no-titlebar"
    });
}

function showDialogError(message){
    $( "#dialog-err .dialog-text" ).html(message);
    $( "#dialog-err" ).dialog({
        modal: true,
        width: $(window).width() > 600 ? 400 : 'auto',
        minheight: 150,
        buttons: {
        'OK': function() {
          $( this ).dialog( "close" );
        }
      }
    });
}


function showDialogWarning(message , redirectUrl){
    $( "#dialog-warn .dialog-text" ).html(message);
    $( "#dialog-warn" ).dialog({
        modal: true,
        width: $(window).width() > 600 ? 400 : 'auto',
        minheight: 150,
        buttons: {
        'OK': function() {
			window.location = redirectUrl;

        },
		'Cancel' : function(){
			$( this ).dialog( "close" );
		}
      }
    });
}

function showDialogSuccess(message , redirect){
    $( "#dialog-succ .showMsg" ).html(message);
    $( "#dialog-succ" ).dialog({
        modal: true,
        width: $(window).width() > 600 ? 400 : 'auto',
        minheight: 150,
        buttons: {
        'OK': function() {
          window.location.href = redirect;
        }
      }
    });
}


function slideDiv(buttonID , target){
	$(buttonID).click(function(e) {
		e.preventDefault();
		$('html, body').animate({
			scrollTop: $(target).offset().top
		}, 500);
	});
}


function removeFile_showInput(hideDiv , showDiv){
	$(hideDiv).hide();
	$(showDiv).show();
	
}

function bs_input_file() {
	$(".input-file").after(
		function() {
			if ( ! $(this).prev().hasClass('input-ghost') ) {
				var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0;display:block;'>");
				element.attr("name",$(this).attr("name"));
				element.change(function(){
					element.prev(element).find('input').val((element.val()).split('\\').pop());
				});
				$(this).find("button.btn-choose").click(function(){
					element.click();
				});
				$(this).find("button.btn-reset").click(function(){
					element.val(null);
					$(this).parents(".input-file").find('input').val('');
				});
				$(this).find('input').css("cursor","pointer");
				$(this).find('input').mousedown(function() {
					$(this).parents('.input-file').prev().click();
					return false;
				});
				return element;
			}
		}
	);
}

$(document).ready(function() {
	$('.select2').select2();
});