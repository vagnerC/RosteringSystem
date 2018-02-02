<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");
?>
		<form class="form-staff-profile">
			<input type="text" id="userName" name="	userName" class="form-control" placeholder="Name" required autofocus><br />
        	<input type="text" id="userSurname" class="form-control" placeholder="Surname" required autofocus><br />
            <input type="email" id="userEmail" class="form-control" placeholder="Email" required autofocus><br />
  			<input type="text" id="userMobileNumber" class="form-control" placeholder="Mobile Number" required autofocus><br />
  			<input type="text" id="nextOfKinName" class="form-control" placeholder="Next of Kin Name" required autofocus><br />
  			<input type="text" id="nextOfKinMobile" class="form-control" placeholder="Next of Kin Mobile Number" required autofocus><br />
   			<input type="text" id="minimumHours" class="form-control" placeholder="Minimum Hours" required autofocus><br />
   			<input type="text" id="maximumHours" class="form-control" placeholder="Maximum Hours" required autofocus><br />
   			<input type="text" id="hourWage" class="form-control" placeholder="Hour Wage" required autofocus><br />
   			
   			<label for='formDaysAvailable[]'>Select the days you are available:</label><br>
   			<input type="text" id="position" class="form-control" placeholder="Position" required autofocus><br />
   			<input type="checkbox" id="daysAvailable" class="form-control" placeholder="Sunday" required autofocus><br />
   			<input type="checkbox" id="daysAvailable" class="form-control" placeholder="Monday" required autofocus><br />
   			<input type="checkbox" id="daysAvailable" class="form-control" placeholder="Tuesday" required autofocus><br />
   			<input type="checkbox" id="daysAvailable" class="form-control" placeholder="Wednesday" required autofocus><br />
   			<input type="checkbox" id="daysAvailable" class="form-control" placeholder="Thursday" required autofocus><br />
   			<input type="checkbox" id="daysAvailable" class="form-control" placeholder="Friday" required autofocus><br />
   			<input type="checkbox" id="daysAvailable" class="form-control" placeholder="Saturday" required autofocus><br />

		</form>
<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>	