<?php
session_start();
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");

//require_once(TEMPLATE_PATH . "/menu_staff.php");
require_once("calendar.php");

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
        	<div class="panel-heading">Notification</div>
            	<div class="panel-body">
                	<div class="alert alert-warning alert-dismissable">
	    				<a href="#" class="close" data-dismiss="alert" aria-label="close">Read</a>
	    				<strong>Success!</strong> This alert box could indicate a successful or positive action.
  					</div>
                	<div class="alert alert-warning alert-dismissable">
	    				<a href="#" class="close" data-dismiss="alert" aria-label="close">Read</a>
	    				<strong>Success!</strong> This alert box could indicate a successful or positive action.
  					</div>
				</div>
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
//echo draw_calendar(date('m'), date('Y'));

require_once(TEMPLATE_PATH . "/footer.php");
?>