<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");

require_once(TEMPLATE_PATH . "/menu_staff.php");


?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<div class="container">
	<h2>Home </h2>
	<div class="panel-group">
    	<div class="panel panel-primary">
        	<div class="panel-heading">Notification</div>
            	<div class="panel-body">
                	<div class="alert alert-success alert-dismissable">
	    				<a href="#" class="close" data-dismiss="alert" aria-label="close">Read</a>
	    				<strong>Success!</strong> This alert box could indicate a successful or positive action.
  					</div>
  					<div class="alert alert-danger alert-dismissable">
    					<a href="#" class="close" data-dismiss="alert" aria-label="close">Read</a>
   						<strong>Danger!</strong> This alert box could indicate a dangerous or potentially negative action.
  					</div>
				</div>
		</div>				
	</div>			
</div>

<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>