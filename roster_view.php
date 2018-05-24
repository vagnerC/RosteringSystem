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
<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading"><b>Roster View</b></div>
		<div class="panel-body">
            	<div class="row">
            		<div class="col-md-12">
            			<fieldset>
						<div class="row">
        						<div class="col" style="text-align: center">
        							<?php 
        							echo draw_calendar(date('m'), date('Y'),'not specific');
        							?>
        						</div>
        					</div>
					</fieldset>
            		</div>
            	</div>
		</div>   
	</div>
</div>

<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script> 
<?php 
require_once("template/footer.php");
?>