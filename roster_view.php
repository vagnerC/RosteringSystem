<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");
require_once("calendar.php");

	echo draw_calendar(date('m'), date('Y'));
	//echo "<p>";
	//echo draw_calendar(date('m')+4, date('Y'));

	require_once(TEMPLATE_PATH . "/footer.php");
?>