<?php
session_start();
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . "/RosteringSystem/resource/config.php");
require_once(TEMPLATE_PATH . "/header.php");
if(isset($_SESSION['user_info'])):
    header("Location: home.php");
    die();
endif;
?>
<!-- Bootstrap Core CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">

<!--Font Awesome (added because you use icons in your prepend/append)-->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">


<script type="text/javascript">
$('document').ready(function()
{ 
	/* validation */
	$("#login-form").validate({
		rules:
		{
			password: {
				required: true
			},
			username: {
				required: true
            },
		},
		messages:
		{
			password: "Please enter your Password.",
			username: "Please enter your Username.",
		},
		submitHandler: submitForm	
	});  
	   
	/* login submit */
	function submitForm()
	{		
		var data = $("#login-form").serialize();
				
		$.ajax({
			type : 'POST',
			url  : 'index_process.php',
			data : data,
			success: function(response)
			{						
				if(response=="ok"){
					$("#login").html('<span class="glyphicon glyphicon-refresh"></span> &nbsp; Signing In...');
					setTimeout('window.location.href = "home.php"; ',500);
				} else {
					$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+'</div>');
						$("#login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
					});
				}
			}
		});
		return false;
	}
});
</script>
<form class="form-horizontal" method="post" id="login-form">
	<div class="row">
		<div class="col-md-12 ">
			
			<div class="form-group">
				<label class="col-md-4 control-label" for="newEmail"></label>
				<div class="col-md-4">
					<div id="error"></div> 
				</div>
			</div>
					
					<div class="form-group">
					<label class="col-md-4 control-label" for="newEmail"></label>
						<div class="col-md-4">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-envelope-o"></i>
								</div>
							<input id="username" name="username" type="text" placeholder="Username" class="form-control input-md" value="">
							</div>
						</div>
					</div>

					<div class="form-group">
					<label class="col-md-4 control-label" for="newPassword"></label>
						<div class="col-md-4">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-key"></i>
								</div>
							<input id="password" name="password" type="password" placeholder="Password" class="form-control input-md" value="">
							</div>
						</div>
					</div>

					<div class="form-group">
  					<label class="col-md-4 control-label" ></label>  
  						<div class="col-md-4">
							<button type="submit" name="login" id="login" class="btn btn-primary">
    								<i class="glyphicon glyphicon-log-in"></i> &nbsp; Login
							</button>
  						</div>
					</div>
				</fieldset>
			
	</div>
</div>
</form>
<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>