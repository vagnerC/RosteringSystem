<?php
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

	<br><br><br>
<div class="panel-group">
    <div class="panel panel-primary">
        <div class="panel-body">
             
            <div class="bs-calltoaction bs-calltoaction-default">
                <div class="row">
					<div class="col" style="text-align: right">
						<select class="input-xlarge" width="50%" id="sel1">
						<option> Week 1</option>
						<option> Week 2</option>
						<option> Week 3</option>
						<option> Week 4</option>
						</select>
					</div>
				<div class="col" style="text-align: left">
				<button onclick="saveOpenClose()" type="button" class="btn btn-secondary">Generate</button>
				</div>
					
               	</div>
				<div class="calendarClass">
					<?php 
					echo draw_calendar(date('m'), date('Y'));
					?>
				</div>	        
			</div>		
		</div>		     
	</div>
</div>
			

<?php 
//echo draw_calendar(date('m'), date('Y'));

require_once(TEMPLATE_PATH . "/footer.php");
?>