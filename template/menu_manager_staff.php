<?php
session_start();
require_once("template/header.php");

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
endif;
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
.calendarClass {
    display: block;
    margin-left: auto;
    margin-right: auto;
    padding: 2%;
    width: 90%;
 </style>

	<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading">Staff</div>
            	<div class="panel-body">
                	<?php 
                	
                    	        echo "<div class='alert alert-warning'>";
                    	        echo "<a href='staff_add.php' class='close'>Go</a>";
                    	        echo "<strong>Add Staff.</strong>";
                    	        echo "</div>"; 

                	?>
		</div>				
	</div>			


<?php 
require_once("template/footer.php");
?>