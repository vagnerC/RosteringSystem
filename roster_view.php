<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");
require_once("calendar.php"); 	
  
    echo "<h2>Feb 2018</h2>";
	echo draw_calendar(2,2018);

	require_once(TEMPLATE_PATH . "/footer.php");
?>