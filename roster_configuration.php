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
					"Open"=> ,
					"Close"=>17:00),
				array(
					"day"=>"Tuesday",
					"Open"=>10:00,
					"Close"=>18:00
				)
			);

echo "<div class='container'>".
	 	"<div class='row'>".
		  "<div class='col-sm'></div>";	
		foreach($daysOfWeek as $val){
			 echo "<div class='col-sm'><b>".$val['day']."</b></div>";
		}
		echo "</div><br>".
	 	"<div class='row'>".
	 		"<div class='col-sm-6'>".
	 			"<p>Opening Hours</p>".

	 		"</div>".
		"</div>".
"</div>";



require_once(TEMPLATE_PATH . "/footer.php");
?>