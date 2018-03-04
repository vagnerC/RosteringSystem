<?php
/**
*@author Felipe Mello
*@version 0.3
**/
/**Roster Configuration 
	In this section the manager will configure the week: what time and which days the shop will be opened, how many staff the shop will need per hour.
**/
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');
require_once(TEMPLATE_PATH . "/header.php");

if(isset($_POST['next'])){
	$sundayOpen = $_POST['sundayOpen'];
	$sundayClose = $_POST['sundayClose'];

	$mondayOpen = $_POST['mondayOpen'];
	$mondayClose = $_POST['mondayClose'];
	
	$tuesdayOpen = $_POST['tuesdayOpen'];
	$tuesdayClose = $_POST['tuesdayClose'];

	$wednesdayOpen = $_POST['wednesdayOpen'];
	$wednesdayClose = $_POST['wednesdayClose'];

	$thursdayOpen = $_POST['thursdayOpen'];
	$thursdayClose = $_POST['thursdayClose'];

	$fridayOpen = $_POST['fridayOpen'];
	$fridayClose = $_POST['fridayClose'];

	$saturdayOpen = $_POST['saturdayOpen'];
	$saturdayClose = $_POST['saturdayClose'];

}else{
	// do something else
	$sundayOpen = "";
	$sundayClose ="";

	$mondayOpen ="";
	$mondayClose = "";
	
	$tuesdayOpen = "";
	$tuesdayClose = "";

	$wednesdayOpen = "";
	$wednesdayClose = "";

	$thursdayOpen = "";
	$thursdayClose = "";

	$fridayOpen = "";
	$fridayClose = "";

	$saturdayOpen = "";
	$saturdayClose ="";
}

/** My Functions**/
/**This function return the time in a select output**/
function get_times( $default = '00:00', $interval = '+30 minutes' ) {
    $output = '';
    $current = strtotime( '00:00' );
    $end = strtotime( '23:59' );
    while( $current <= $end ) {
        $time = date( 'H:i', $current );
        $sel = ( $time == $default ) ? ' ' : '';

        $output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
        $current = strtotime( $interval, $current );
    }

    return $output;
}

/** This function prints the time on the screen base on the opening and closing time of the shop**/
$interval = "+60 minutes";
function output_times($startTime, $fimishTime, 
    $interval){
    $output = '';
    $current = strtotime($startTime);
    $end = strtotime($fimishTime);
    while($current <= $end){
        $time = date('H:i', $current);
        $sel = ($time==$startTime)? ' ' : '';
        $output .= "<p>From ".date('h.i.A', $current);
        $current = strtotime($interval, $current);

        $output .= " to ".date('h.i.A',$current).
        "<div class='input-group mb-3'>
        	<div class ='input-group-prepend'>
        		<label class='input-group-text' for='inputGroupSelect01'>Number of Staff</label></div>
        	<select class='custom-select'>".selectNumberOption(2,10)."</select></div>";

    }
    return $output;

}

/** This function retuns options from 0 to max **/
function selectNumberOption($min, $max) {
    $output ='';
    foreach(range($min, $max) as $number){
    	$output .= '<option>'.$number.'</option>';
    }
    return $output;
}


  
  

?>

<script type="text/javascript" src="js/jquery-3.3.1.js"></script> 

<form method='post' action='roster_configuration.php'>

	<div class="container" id="openClose">
	<div class="jumbotron">
		<div class="row">
			<div class="col">
				<h3 class="title">Opening Hours</h3>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col" id="sunday">
				<div class="row"><p>Sunday</p></div>
				<div class="row">
					<select class="custom-select" id="sundayOpen" name="sundayOpen" value ="">
						<option selected>Open...</option>
						<?php echo get_times()?>
					</select>
				</div>

				<div class="row">
				<select class="custom-select" id="sundayClose" name="sundayClose" value ="">
					<option selected>Close...</option>
						<?php echo get_times(); ?>
					</select>
				</div>
			</div>
			<div class="col" id="monday">
				<div class="row"><p>Monday</p></div>
				<div class="row">
					<select class="custom-select" id="mondayOpen" name="mondayOpen" value="">
						<option selected>Open...</option>
					<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="mondayClose" name="mondayClose" value="">
						<option selected>Close...</option>
					<?php echo get_times()?>
					</select>
				</div>
			</div>
			<div class="col" id="tuesday">
				<div class="row"><p>Tuesday</p></div>
				<div class="row">
					<select class="custom-select" id="tuesdayOpen" name="tuesdayOpen" value="">
						<option selected>Open...</option>
					<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="tuesdayClose" name="tuesdayClose" value ="">
					<option selected>Close...</option>
					<?php echo get_times()?>
					</select>
				</div>
				
			</div>
			<div class="col" id="wednesday">
				<div class="row"><p>Wednesday</p></div>
				<div class="row">
					<select class="custom-select" id="wednesdayOpen" name="wednesdayOpen" value="">
						<option selected>Open...</option>
						<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="wednesdayClose" name="wednesdayClose" id="">
						<option selected>Close...</option>
						<?php echo get_times()?>
					</select>
				</div>
			</div>
			<div class="col" id="thursday">
				<div class="row"><p>Thursday</p></div>
				<div class="row">
					<select class="custom-select" id="thursdayOpen" name="thursdayOpen" value="">
						<option selected>Open...</option>
						<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="thursdayClose" name="thursdayClose" value="">					
						<option selected>Close...</option>
						<?php echo get_times()?>
					</select>
				</div>
				
			</div>
			<div class="col" id="friday">
				<div class="row"><p>Friday</p></div>
				<div class="row">
					<select class="custom-select" id="fridayOpen" name="fridayOpen" value="">
						<option selected>Open...</option>
						<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="fridayClose" name="fridayClose" value="">
						<option selected>Close...</option>
						<?php echo get_times()?>
					</select>
				</div>
				
			</div>
			<div class="col" id="saturday">
				<div class="row"><p>Saturday</p></div>
				<div class="row">
					<select class="custom-select" id="saturdayOpen" name="saturdayOpen" value="">
					<option selected>Open...</option>
					<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="saturdayClose" name="saturdayClose" value="">
					<option selected>Close...</option>
					<?php echo get_times()?>
					</select>
				</div>	
				
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col" style="text-align: right">
			<button type="button" class="btn btn-info">Cancel</button>
		</div>
		<div class="col" style="text-align: left">
			<button type="Submit" class="btn btn-info" name="next" value="next">Next</button>
		</div>
	</div>
</form>

<br>
<script type="text/javascript" src="js/felipe.js"></script> 
 
	<div class="hline"></div>
	<br>
	<div class="row">
		<div class="col">
			<h3 class="title">Staff Hours</h3>
		</div>

	</div>
	<br>
	<div class="row" id="staffHours">
		<div class="col">

			<div class="col" id="sunday">
				<div class="col">
					<p><strong>Sunday</strong></p>
					<div class="col">
						<?php 
							echo output_times($sundayOpen, $sundayClose, $interval);
						?>
					</div>
				</div>
			</div>
			<div class="col" id="monday">
				<div class="col">
					<p><strong>Monday</strong></p>
					<div class="col">
						<?php 
							echo output_times($mondayOpen, $mondayClose, $interval);
						?>
					</div>
				</div>
			</div>

			<div class="col" id="tuesday">
				<div class="col">
					<p><strong>Tuesday</strong></p>
					<div class="col">
						<?php 
							echo output_times($tuesdayOpen, $tuesdayClose, $interval);
						?>
					</div>
				</div>
			</div>


			<div class="col" id="wednesday">
				<div class="col">
					<p><strong>Wednesday</strong></p>
					<div class="col">
						<?php 
							echo output_times($wednesdayOpen, $wednesdayClose, $interval);
						?>
					</div>
				</div>
			</div>
		

			<div class="col" id="thursday">
				<div class="col">
					<p><strong>Thursday</strong></p>
					<div class="col">
						<?php 
							echo output_times($thursdayOpen, $thursdayClose, $interval);
						?>
					</div>
				</div>
			</div>


			<div class="col" id="friday">
				<div class="col">
					<p><strong>Friday</strong></p>
					<div class="col">
						<?php 
							echo output_times($fridayOpen, $fridayClose, $interval);
						?>
					</div>
				</div>
			</div>


			<div class="col" id="saturday">
				<div class="col">
					<p><strong>Saturday</strong></p>
					<div class="col">
						<?php 
							echo output_times($saturdayOpen, $saturdayClose, $interval);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col" style="text-align: right">
			<button type="button" class="btn btn-info">Cancel</button>
		</div>
		<div class="col" style="text-align: left">
			<button type="Submit" class="btn btn-info" name="next" value="next">Save</button>
		</div>
	</div>
</div>	
</div>
<br>

<?php
require_once(TEMPLATE_PATH . "/footer.php");
?>