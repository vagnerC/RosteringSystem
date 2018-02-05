<?php
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
			echo "<div class='col-sm'><b>".$val['day']."</b></div>";//	  $val['day'];
		}
	
}

/** It prints a number of columns to select time **/
function printBlockOfTime(){
	GLOBAL $daysOfWeek;
	for($i =0; $i< sizeof($daysOfWeek);$i++){
				echo "<div class='col-sm'>
						<select name='".$i."'".get_times()."></select></div>";
			}
}

/** It returns a string list of time AM/PM **/
function get_times( $default = '19:00', $interval = '+30 minutes' ) {

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


<div class="container">
	
	<div class="row">
		<div class="col-sm">
			<p><b>Days</b></p>
		</div>
		<?php 
			echo getDaysOfTheWeek();
		?>
	</div>

	<div class="row">
		<div class="col-sm">
			<p><b>Open:</b></p>	
		</div>
		<?php
		 	echo printBlockOfTime();
		  ?>
	</div>
	
	<div class="row">
		<div class="col-sm">
			<p><b>Close:</b></p> 
		</div>
		<?php
			echo printBlockOfTime();
		?>
		
	</div>
</div>

 <?php
require_once(TEMPLATE_PATH . "/footer.php");
?>