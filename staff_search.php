<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");
?>
		<form class="form-staff-search">
			<input type="text" id="userName" class="form-control" placeholder="Name" required autofocus><br />
        	<input type="text" id="userSurname" class="form-control" placeholder="Surname" required autofocus><br />
            <input type="email" id="userEmail" class="form-control" placeholder="Email" required autofocus><br />
  			<input type="text" id="userMobileNumber" class="form-control" placeholder="Mobile Number" required autofocus><br />
  			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Search</button>
		</form>
<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>