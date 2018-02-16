<?php
/**
*@author Felipe Mello
*@version 0.3
**/
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');
require_once(TEMPLATE_PATH . "/header.php");


// My functions



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
<script type="text/javascript" src="js/jquery-3.3.1.js"></script> 
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
					<select class="custom-select" id="sundayOpen">
						<option selected>Open...</option>
						<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
				<select class="custom-select" id="sundayClose">
					<option selected>Close...</option>
						<?php echo get_times(); ?>
					</select>
				</div>
			</div>
			<div class="col" id="monday">
				<div class="row"><p>Monday</p></div>
				<div class="row">
					<select class="custom-select" id="mondayOpen">
						<option selected>Open...</option>
					<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="mondayClose">
						<option selected>Close...</option>
					<?php echo get_times()?>
					</select>
				</div>
			</div>
			<div class="col" id="tuesday">
				<div class="row"><p>Tuesday</p></div>
				<div class="row">
					<select class="custom-select" id="tuesdayOpen">
						<option selected>Open...</option>
					<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="tuesdayClose">
					<option selected>Close...</option>
					<?php echo get_times()?>
					</select>
				</div>
				
			</div>
			<div class="col" id="wednesday">
				<div class="row"><p>Wednesday</p></div>
				<div class="row">
					<select class="custom-select" id="wednesdayOpen">
						<option selected>Open...</option>
						<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="wednesdayClose">
						<option selected>Close...</option>
						<?php echo get_times()?>
					</select>
				</div>
			</div>
			<div class="col" id="thursday">
				<div class="row"><p>Thursday</p></div>
				<div class="row">
					<select class="custom-select" id="thursdayOpen">
						<option selected>Open...</option>
						<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="thursdayClose">					
						<option selected>Close...</option>
						<?php echo get_times()?>
					</select>
				</div>
				
			</div>
			<div class="col" id="friday">
				<div class="row"><p>Friday</p></div>
				<div class="row">
					<select class="custom-select" id="fridayOpen">
						<option selected>Open...</option>
						<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="fridayClose">
						<option selected>Close...</option>
						<?php echo get_times()?>
					</select>
				</div>
				
			</div>
			<div class="col" id="saturday">
				<div class="row"><p>Saturday</p></div>
				<div class="row">
					<select class="custom-select" id="saturdayOpen">
					<option selected>Open...</option>
					<?php echo get_times()?>
					</select>
				</div>
				<div class="row">
					<select class="custom-select" id="saturdayClose">
					<option selected>Close...</option>
					<?php echo get_times()?>
					</select>
				</div>	
				
		</div>
	</div>
	<br>
	<script type="text/javascript" src="js/felipe.js"></script> 

	<div class="row">
		<div class="col" style="text-align: right">
			<button type="button" class="btn btn-info">Cancel</button>
		</div>
		<div class="col" style="text-align: left">
			<button onclick="saveOpenClose()" type="button" class="btn btn-info">Save</button>
		</div>
	</div>
	<div class="hline"></div>
	<br>
	<div class="row">
		<div class="col">
			<h3 class="title">Staff Hours</h3>
		</div>

	</div>
	<br>
	<div class="row" id="staffHours">
		<!-- <div class="col" id="sundayStaff">
			<p>Sunday</p>
			<div class="row">
				<div class="col">Time</div>
				<div class="col">Staff</div>
			</div>
		</div>
		<div class="col">
			<p>Monday</p>
			<div class="row">
				
				<div class="col">Time</div>
				<div class="col">Staff</div>
			</div>
		</div>
		<div class="col">
			<p>Tuesday</p>
			<div class="row">
				<div class="col">Time</div>
				<div class="col">Staff</div>
			</div>
		</div>
		<div class="col">
			<p>Wednesday</p>
			<div class="row">
				<div class="col">Time</div>
				<div class="col">Staff</div>
			</div>
		</div>
		<div class="col">
			<p>Thursday</p>
			<div class="row">
				<div class="col">Time</div>
				<div class="col">Staff</div>
			</div>
		</div>
		<div class="col">
			<p>Friday</p>
			<div class="row">
				<div class="col">Time</div>
				<div class="col">Staff</div>
			</div>
		</div>
		<div class="col">
			<p>Saturday</p>
			<div class="row">
				<div class="col">Time</div>
				<div class="col">Staff</div>
			</div>
		</div>
 -->

	</div>
</div>	
</div>
<br>

<?php
require_once(TEMPLATE_PATH . "/footer.php");
?>