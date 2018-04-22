<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");

$idDepartment = $_SESSION['user_info']['idDepartment'];

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
elseif($_SESSION['user_info']['management'] != "true"):
    echo "<script>location.href = 'logout.php';</script>";
    die();
endif;

if(isset($_POST['next'])){
    foreach ($_POST as $variable => $value):
        $$variable  = $value;
    endforeach;
} else {
	$mondayOpen = "00:00";
	$mondayClose = "00:00";
	
	$tuesdayOpen = "00:00";
	$tuesdayClose = "00:00";

	$wednesdayOpen = "00:00";
	$wednesdayClose = "00:00";

	$thursdayOpen = "00:00";
	$thursdayClose = "00:00";

	$fridayOpen = "00:00";
	$fridayClose = "00:00";

	$saturdayOpen = "00:00";
	$saturdayClose = "00:00";
	
	$sundayOpen = "00:00";
	$sundayClose = "00:00";
}

/** My Functions**/
/**This function return the time in a select output**/
function get_times($default, $interval = '+1 hour' ) {
    $output = '';
    $current = strtotime( '00:00' );
    $end = strtotime( '23:59' );
    while( $current <= $end ) {
        $time = date( 'H:i', $current );
        $sel = ( $time == $default ) ? 'selected' : '';

        $output .= "<option value='$time' $sel>".$time.'</option>';
        $current = strtotime( $interval, $current );
    }

    return $output;
}

/** This function prints the time on the screen base on the opening and closing time of the shop**/
$interval = "+60 minutes";
function output_times($startTime, $fimishTime, $interval){
    $output = '';
    $current = strtotime($startTime);
    $end = strtotime($fimishTime);
    while($current < $end){
        $time = date('H:i', $current);
        $sel = ($time==$startTime)? ' ' : '';
        //$output .= "<p>From".date('h.i.A', $current);
        $current = strtotime($interval, $current);

        $output .= "<div class='input-group mb-3'>
        	<div class ='input-group-prepend'>
        		<label class='input-group-text' for='inputGroupSelect01'>$time</label></div>
        	<select class='custom-select'>".selectNumberOption(1,20)."</select></div>";

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
<form method='post' action='roster_configuration.php'>
	<div class="container" id="openClose">
	
		<br>
		<div class="row">
			<div class="col">
				<h3 class="title">Opening Hours</h3>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col" id="monday">
				<div class="row"><p>Monday</p></div>
				<div class="row">
					<select class="custom-select" id="mondayOpen" name="mondayOpen">
						<option value="">Open</option>
					<?php echo get_times("$mondayOpen")?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="mondayClose" name="mondayClose">
						<option value="">Close</option>
					<?php echo get_times("$mondayClose")?>
					</select>
				</div>
			</div>
			<div class="col" id="tuesday">
				<div class="row"><p>Tuesday</p></div>
				<div class="row">
					<select class="custom-select" id="tuesdayOpen" name="tuesdayOpen">
						<option value="">Open</option>
					<?php echo get_times("$tuesdayOpen")?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="tuesdayClose" name="tuesdayClose">
					<option value="">Close</option>
					<?php echo get_times("$tuesdayClose")?>
					</select>
				</div>
				
			</div>
			<div class="col" id="wednesday">
				<div class="row"><p>Wednesday</p></div>
				<div class="row">
					<select class="custom-select" id="wednesdayOpen" name="wednesdayOpen">
						<option value="">Open</option>
						<?php echo get_times("$wednesdayOpen")?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="wednesdayClose" name="wednesdayClose">
						<option value="">Close</option>
						<?php echo get_times("$wednesdayClose")?>
					</select>
				</div>
			</div>
			<div class="col" id="thursday">
				<div class="row"><p>Thursday</p></div>
				<div class="row">
					<select class="custom-select" id="thursdayOpen" name="thursdayOpen">
						<option value="">Open</option>
						<?php echo get_times("$thursdayOpen")?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="thursdayClose" name="thursdayClose">					
						<option value="">Close</option>
						<?php echo get_times("$thursdayClose")?>
					</select>
				</div>
				
			</div>
			<div class="col" id="friday">
				<div class="row"><p>Friday</p></div>
				<div class="row">
					<select class="custom-select" id="fridayOpen" name="fridayOpen">
						<option value="">Open</option>
						<?php echo get_times("$fridayOpen")?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="fridayClose" name="fridayClose">
						<option value="">Close</option>
						<?php echo get_times("$fridayClose")?>
					</select>
				</div>
				
			</div>
			<div class="col" id="saturday">
				<div class="row"><p>Saturday</p></div>
				<div class="row">
					<select class="custom-select" id="saturdayOpen" name="saturdayOpen">
					<option value="">Open</option>
					<?php echo get_times("$saturdayOpen")?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="saturdayClose" name="saturdayClose">
					<option value="">Close</option>
					<?php echo get_times("$saturdayClose")?>
					</select>
				</div>	
			</div>
			<div class="col" id="sunday">
				<div class="row"><p>Sunday</p></div>
				<div class="row">
					<select class="custom-select" id="sundayOpen" name="sundayOpen">
						<option value="">Open</option>
						<?php echo get_times("$sundayOpen")?>
					</select>
				</div>

				<div class="row">
				<select class="custom-select" id="sundayClose" name="sundayClose">
					<option value="">Close</option>
						<?php echo get_times("$sundayClose"); ?>
					</select>
				</div>
			</div>
		</div>
		
		<br>
		<div class="row">
			<div class="col" style="text-align: center">
				<button type="Submit" class="btn btn-primary" name="next">Next</button>
			</div>
		</div>
<br>
 	
 	
 	<div class="row">
			<div class="col">
				<h3 class="title">Staff Hours</h3>
			</div>
	</div>
	<br>
	<div class="row">
			<div class="col" id="monday">
				<div class="row"><p>Monday</p></div>
				<div class="row">
					<?php 
					echo output_times($mondayOpen, $mondayClose, $interval);
					?>
				</div>
			</div>
			
			<div class="col" id="tuesday">
				<div class="row"><p>Tuesday</p></div>
				<div class="row">
					<?php 
					echo output_times($tuesdayOpen, $tuesdayClose, $interval);
					?>
				</div>
			</div>

			<div class="col" id="wednesday">
				<div class="row"><p>Wednesday</p></div>
				<div class="row">
					<?php 
					echo output_times($wednesdayOpen, $wednesdayClose, $interval);
					?>
				</div>
			</div>

 	
			<div class="col" id="thursday">
				<div class="row"><p>Thursday</p></div>
				<div class="row">
					<?php 
					echo output_times($thursdayOpen, $thursdayClose, $interval);
					?>
				</div>
			</div>
			
		
			<div class="col" id="friday">
				<div class="row"><p>Friday</p></div>
				<div class="row">
					<?php 
					echo output_times($fridayOpen, $fridayClose, $interval);
					?>
				</div>
			</div>
			
			<div class="col" id="saturday">
				<div class="row"><p>Saturday</p></div>
				<div class="row">
					<?php 
					echo output_times($saturdayOpen, $saturdayClose, $interval);
					?>
				</div>
			</div>

			<div class="col" id="sunday">
				<div class="row"><p>Sunday</p></div>
				<div class="row">
					<?php 
					echo output_times($sundayOpen, $sundayClose, $interval);
					?>
				</div>
			</div>
			
			
		
		
	</div>
	
	<br>
        		<div class="row">
        			<div class="col" style="text-align: center">
        				<button type="Submit" class="btn btn-primary" name="save">Save</button>
        			</div>
        		</div>
	
	
</div>
</form>
	
<br>
<br>
<?php
require_once("template/footer.php");
?>