<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php'); 

require_once(TEMPLATE_PATH . "/header.php");
require_once(TEMPLATE_PATH . "/menu_manager.php");
?>
Here goes the code. you can use any HTML tags outside the php block or use them inside an echo "";
<?php
require_once(TEMPLATE_PATH . "/footer.php");

echo "test";
?>
