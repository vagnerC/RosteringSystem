<?php
session_start();
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . "/RosteringSystem/resource/config.php");
require_once(TEMPLATE_PATH . "/header.php");
require_once("calendar_payment.php");
if(!isset($_SESSION['user_info'])):
    header("Location: index.php");
    die();
endif;
    
	echo draw_calendar(date('m'), date('Y'));

require_once(TEMPLATE_PATH . "/footer.php");
?>

