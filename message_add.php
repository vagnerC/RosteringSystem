<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
endif;
?>
<div class="container">
	<div class="row">
		<div class="col-md-10 ">
			<form class="form-horizontal" method="post" id="message_add-form">
				<fieldset>
					<legend>New Message </legend>
                        
						<div class="form-group">
							<label class="col-md-4 control-label"></label>
							<div class="col-md-4">
								<div id="info"></div> 
							</div>
						</div>
                        
						<div class="form-group">
                        		<label class="col-md-4 control-label" for="idStaff">Send To:</label>  
							<div class="col-md-4">
                        			<div class="input-group">
                        				<div class="input-group-addon">
                             			<i class="fa fa-envelope-o"></i>
                        				</div>
                            			<select class="form-control" name="idStaff" id="idStaff">
                            			<option value=''></option>
        									<?php
        									try{
        									    $sql = "SELECT idStaff, CONCAT(name, ' ', surname) AS fullname FROM staff ORDER BY name, surname";
        									    $sth = $DBH->prepare($sql);
        									    $sth->execute();
        									    while ($row = $sth->fetch(PDO::FETCH_OBJ)){
        									        if($row->idStaff <> $_SESSION['user_info']['id']):
        									           echo "<option value='".$row->idStaff."'>".$row->fullname."</option>";
        									        endif;
        									    }
        									} catch(PDOException $e) {echo $e;}
        									?>
        								</select>
                        			</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="subject">Subject:</label>  
    							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
     									<i class="fa fa-envelope-o"></i>
									</div>
    									<input id="subject" name="subject" type="text" placeholder="Subject" class="form-control input-md">
								</div>
 							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="message">Message:</label>
    							<div class="col-md-4">                     
    								<textarea class="form-control" rows="10"  id="message" name="message" placeholder="Message"></textarea>
  							</div>
						</div>

						<div class="form-group">
  							<label class="col-md-4 control-label" ></label>  
  							<div class="col-md-4">
  								<input class="btn btn-primary" type="submit" value="Send">
  							</div>
						</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<!-- Bootstrap Core CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">


<script>
	$('document').ready(function()
	{ 
		/* validation */
		$("#message_add-form").validate({
		rules:
		{
			idStaff: {
				required: true
			},
			subject: {
				required: true
            },
            message: {
				required: true
            },
		},
		messages:
		{
			idStaff: "Please choose a Staff to send the message to.",
			subject: "Please write a subject.",
			message: "Please write a message.",
		},
	    submitHandler: submitForm
	});  
	   
	/* login submit */
	function submitForm()
	{		
		var data = $("#message_add-form").serialize();
				
		$.ajax({
			type : 'POST',
			url  : 'message_add_process.php',
			data : data,
			success: function(response)
			{						
				if(response=="ok"){
					$("#info").fadeIn(1000, function(){
						$("#info").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-thumbs-up"></span> Message successfully sent.</div>');
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
<?php 
require_once("template/footer.php");
?>