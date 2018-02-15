TESTE.
<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . "/RosteringSystem/resource/config.php");
require_once(TEMPLATE_PATH . "/header.php");
?>
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
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#login").html('<span class="glyphicon glyphicon-transfer"></span>&nbsp; sending...');
			},
			success: function(response)
			{						
				if(response=="ok"){
					$("#login").html('<img src="image/content/btn-ajax-loader.gif" /> &nbsp; Signing In ...');
					setTimeout(' window.location.href = "home.php"; ',3000);
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
	   /* login submit */
});
</script>

<div class="signin-form">
	<form class="form-signin" method="post" id="login-form">
        
		<div id="error"></div>
        
		<div class="form-group">
			<input type="text" name="username" id="username" class="form-control" placeholder="Username" />
		</div>
        
		<div class="form-group">
			<input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
		</div>
       
		<hr />
        
		<div class="form-group">
			<button type="submit" name="login" id="login" class="btn btn-default">
			<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
			</button> 
		</div>  
		
	</form>
</div>
<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>