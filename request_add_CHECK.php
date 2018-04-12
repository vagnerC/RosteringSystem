<?php
session_start();
require_once("template/header.php");

if(!isset($_SESSION['user_info'])):
    header("Location: index.php");
    die();
endif;
?>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<!-- Bootstrap Core CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
<!--Font Awesome (added because you use icons in your prepend/append)-->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">

<script>
	$(document).ready(function(){
		var date_input=$('input[name="from"]');
		var date_input2=$('input[name="to"]');
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'dd/mm/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
		date_input2.datepicker({
			format: 'dd/mm/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
	
	$('document').ready(function()
	{ 
		/* validation */
		$("#request_add-form").validate({
		rules:
		{
			type: {
				required: true
			},
			from: {
				required: true
            },
            to: {
				required: true
            },
		},
		messages:
		{
			type: "Please choose a Type.",
			from: "Please select a From date.",
			to: "Please select a To date.",
		},
		errorPlacement: function(error, element) {
	        if( element.is(':radio') || element.is(':checkbox')) {
	            error.appendTo(element.parent());
	        } else {
	            error.insertAfter(element);
	        }
	    },//end errorPlacement
	    showErrors: function(errorMap, errorList) {
			if (submitted) {
	            var summary = "";
	            $.each(errorList, function() { summary += " <span class='glyphicon glyphicon-thumbs-down'></span> " + this.message + "<br/>"; });
	            $("#info").html('<div class="alert alert-warning"> '+summary+'</div>');
	            submitted = false;
	        } 
	    },          
	    
	    invalidHandler: function(form, validator) {
	        submitted = true;
	        submitForm();
	    },

	    submitHandler: function (form) {
            submitForm();
        }
	});  
	   
	/* login submit */
	function submitForm()
	{		
		var data = $("#request_add-form").serialize();
				
		$.ajax({
			type : 'POST',
			url  : 'request_add_process.php',
			data : data,
			success: function(response)
			{						
				if(response=="ok"){
					$("#info").fadeIn(1000, function(){
						$("#info").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-thumbs-up"></span> Data successfully saved.</div>');
					});
				} else {
					$("#info").fadeIn(1000, function(){						
						$("#info").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-thumbs-down"></span> &nbsp; '+response+'</div>');
					});
				}
			}
		});
		return false;
	}
});	
</script>

<div class="container">
	<div class="row">
		<div class="col-md-10 ">
			<form class="form-horizontal" method="post" id="request_add-form">
				<fieldset>
					<legend>Request Day off/Holidays </legend>
					
					<div class="form-group">
						<label class="col-md-4 control-label"></label>
						<div class="col-md-4">
							<div id="info"></div> 
						</div>
					</div>
					
                    <div class="form-group">
                    		<label class="col-md-4 control-label" for="type">Type</label>
                    		<div class="col-md-6">
                    			<div class="radio">
                    				<label>
                    					<input type="radio" name="type" id="type" value="Holidays" >
                    					<label for="Holidays">Holidays</label>
                    				</label>
                      		</div>
                      
                      		<div class="radio">
                    				<label>
                            			<input type="radio" name="type" id="type" value="Day Off" >
                            			<label for="Day Off">Day Off</label>
                         		</label>
                    			</div>
                     	</div>
					</div>

					<div class="form-group">
  						<label class="col-md-4 control-label" for="from">From</label>  
  						<div class="col-md-4">
							<div class="input-group">
								<div class="col-sm-20">
       								<div class="input-group">
        									<div class="input-group-addon">
         									<i class="fa fa-calendar"></i>
        									</div>
        									<input class="form-control" id="from" name="from" placeholder="MM/DD/YYYY" type="text"/>
       								</div>
      							</div>
      						</div>
  						</div>
					</div>

					<div class="form-group">
  						<label class="col-md-4 control-label" for="to">To</label>  
  						<div class="col-md-4">
							<div class="input-group">
								<div class="col-sm-20">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
        									<input class="form-control" id="to" name="to" placeholder="MM/DD/YYYY" type="text"/>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
  						<label class="col-md-4 control-label" ></label>  
  						<div class="col-md-4">
  							<input class="btn btn-primary" type="submit" value="Submit">
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<?php
require_once("template/footer.php");
?>