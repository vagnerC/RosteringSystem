<?php
session_start();
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');
require_once(TEMPLATE_PATH . "/header.php");
require_once("calendar.php");
?>
	<div id="size" class="calendarBox">
	<?php 	echo draw_calendar(date('m'), date('Y')); ?>
	</div>

<?php
	require_once(TEMPLATE_PATH . "/footer.php");
?>