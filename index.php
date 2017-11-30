<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");
?>
		<form class="form-signin">
			<input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus><br />
        
			<input type="password" id="inputPassword" class="form-control" placeholder="Password" required><br />
        
			<button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
		</form>
<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>