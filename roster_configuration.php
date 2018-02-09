<?php
/**
*@author Felipe Mello
*@version 0.2
**/
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');
require_once(TEMPLATE_PATH . "/header.php");

/** Configuration - In this section the manager will configure the week: what time and which days the shop will be opened, how many staff the shop will need per hour **/


// $daysOfWeek = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");

// https://stackoverflow.com/questions/13719116/dealing-with-time-in-php-mysql



$daysOfWeek = array(
				array(
					"day"=>"Monday",
					"Open"=> "",
					"Close"=>""),
				array(
					"day"=>"Tuesday",
					"Open"=>"",
					"Close"=>""),

				array(
					"day"=>"Wednesday",
					"Open"=>"",
					"Close"=>""),
				array(
					"day"=>"Thursday",
					"Open"=>"",
					"Close"=>""),
				array(
					"day"=>"Friday",
					"Open"=>"" ,
					"Close"=>""),
				array(
					"day"=>"Saturday",
					"Open"=>"",
					"Close"=>""),
				array(
					"day"=>"Sunday",
					"Open"=>"" ,
					"Close"=>"")
			);


/** It returns all the days of the week**/
function getDaysOfTheWeek(){
	GLOBAL $daysOfWeek;
	foreach($daysOfWeek as $val){
			echo "<div class='col'><b>".$val['day']."</b></div>";//	  $val['day'];
		}
	
}



/** It prints a number of columns to select time **/
function printBlockOfTime(){
	GLOBAL $daysOfWeek;
	for($i =0; $i< sizeof($daysOfWeek);$i++){
				echo "<div class='col'>
						<select name='day".$i."'".get_times()."></select></div>";
			}
}

/** It returns a string list of time AM/PM **/
function get_times( $default = '15:00', $interval = '+30 minutes' ) {
    $output = '';
    $current = strtotime( '00:00' );
    $end = strtotime( '23:59' );

    while( $current <= $end ) {
        $time = date( 'H:i', $current );
        $sel = ( $time == $default ) ? ' selected' : '';

        $output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
        $current = strtotime( $interval, $current );
    }

    return $output;
}
?>

<style type="text/css">
	.title{
		text-align: center;
		letter-spacing: 5px;
	}
	.hline{
		display: block;
		width: 100%;
		height: 1px;
		border: 0;
		border-top: 1px solid #ccc;
		margin: 1em 0;
		padding: 0;

	}
</style>

<div class="container-fluid" id="openClose">
	<div class="row">
		<div class="col">
			<h4 class="title">Opening Hours</h4>
		</div>

	</div>
	<br>
	<form action="roster_configuration.php" method="post">
		
	
		<div class="row">
			<div class="col">
				<p><b></b></p>
			</div>
			<?php 
				echo getDaysOfTheWeek();
			?>
		</div>

		<div class="row">
			<div class="col">
				<p><b>Open:</b></p>	
			</div>
			<?php
			 	echo printBlockOfTime();
			 ?>

		</div>
		<div class="row">
			<div class="col">
				<p><b>Close:</b></p> 
			</div>
			<?php
				echo printBlockOfTime();
			?>
			
		</div>
		<br>
		<!-- I need to get the time the user selected and insert into the array -->

		<div class="row row-centered">
			<div class="col" style="text-align: right">
				<button id="cancelOpeningTime" type="button" class="btn btn-danger">Cancel</button>
			</div>

			<div class="col" style="text-align: left;">
				<button id="submitOpeningTime" type="button" class="btn btn-success">Submit</button>
			</div>
		</div>
	</form>
		<br>
	
	<div class="hline"></div>
	<br>
	<div class="row">
		<div class="col">
			<h4 class="title">Staff Hours</h4>
		</div>
	</div>
	


</div>





 <?php
require_once(TEMPLATE_PATH . "/footer.php");
?>