<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");
require_once("calendar.php");

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
        	<div class="panel-heading">Notifications:</div>
            	<div class="panel-body">
                	<?php 
                	if($_SESSION['user_info']['management'] == "true"):
                    	try{
                    	    $sql = "   SELECT
                    	               typeRequest,
                    	               COUNT(*) AS total
                    	               FROM request
                    	               WHERE status = 'Pending'
                    	               GROUP BY (typeRequest)";
                    	    $sth = $DBH->prepare($sql);
                    	    $sth->execute();
                    	    while ($row = $sth->fetch(PDO::FETCH_OBJ)){
                    	        echo "<div class='alert alert-warning'>";
                    	        echo "<a href='request_view.php?t=$row->typeRequest' class='close'>Go</a>";
                    	        echo "<strong>$row->total</strong> $row->typeRequest request to be approved/disapproved.";
                    	        echo "</div>";
                    	    }
                    	} catch(PDOException $e) {echo $e;}
                	endif;
                	?>
		</div>				
	</div>			

	<div class="">
	<div class="calendarClass">
	<?php 
		echo draw_calendar(date('m'), date('Y'));
	?>
	</div>
	</div>

<?php 
require_once("template/footer.php");
?>