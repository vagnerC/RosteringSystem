<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
endif;

$idMessage  = $_GET['id'];
$status     = $_GET['s'];

if($idMessage == "" OR $status == ""):
    echo "<script>location.href = 'message_archive.php';</script>";
    die();
else:
    try{
        $sql = " SELECT
                 DATE_FORMAT(date, '%d/%m/%Y %H:%m:%s') AS dateFormatted,
                 IF(staffFrom = '1','Me', sF.name) AS staffF,
                 IF(staffTo = '1','Me', sT.name) AS staffT,
                 subject,
                 message
                 FROM message
                 INNER JOIN staff AS sF ON staffFrom = sF.idStaff
                 INNER JOIN staff AS sT ON staffTo = sT.idStaff
                 WHERE idMessage = '$idMessage'";
        
        $sth = $DBH->prepare($sql);
        $sth->execute();
        $row = $sth->fetch(PDO::FETCH_OBJ);
        
    } catch(PDOException $e) {echo $e;}
endif;


?>
<div class="container">
	<div class="row">
		<div class="col-md-10 ">
			<form class="form-horizontal" method="post" id="message_view-form">
				<fieldset>
					<legend><?php echo $row->subject; ?>: </legend>
                        
                        <div class="form-group">
							<label class="col-md-4 control-label" for="message">From:</label>
    							<div class="col-md-4">                     
    								<?php echo $row->staffF; ?>
  							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label" for="message">To:</label>
    							<div class="col-md-4">                     
    								<?php echo $row->staffT; ?>
  							</div>
						</div>
                        
                        <div class="form-group">
							<label class="col-md-4 control-label" for="message">Date:</label>
    							<div class="col-md-4">                     
    								<?php echo $row->dateFormatted; ?>
  							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label" for="message">Message:</label>
    							<div class="col-md-4">                     
    								<?php echo $row->message; ?>
  							</div>
						</div>

						<div class="form-group">
  							<label class="col-md-4 control-label" ></label>  
  							<div class="col-md-4">
  								<button class="btn btn-primary"  type="button" onclick="location.href='<?php echo "message_view_process_sent.php?action=delete&idMessage=$idMessage"; ?>'">Delete</button>
  							</div>
						</div>
						
						<br><br>
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
		$("#message_view-form").validate({
		rules:
		{
            message: {
				required: true
            },
		},
		messages:
		{
			message: "Please write a message.",
		},
	    submitHandler: submitForm
	});  
	   
	/* login submit */
	function submitForm()
	{		
		var data = $("#message_view-form").serialize();
				
		$.ajax({
			type : 'POST',
			url  : 'message_view_process.php',
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