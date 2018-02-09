<<<<<<< HEAD
=======
<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");

?>
	<div class="form-style-2">
		<div class="form-style-2-heading"> Add Staff </div>
		<form action="" method="post">
			<label for="field1"><span>Name <span class="required">*</span></span><input type="text" class="input-field" name="field1" value="" /></label>
			<label for="field2"><span>Surname <span class="required">*</span></span><input type="text" class="input-field" name="field2" value="" /></label>
			<label for="field3"><span>Email <span class="required">*</span></span><input type="text" class="input-field" name="field3" value="" /></label>
			<label><span>Telephone</span><input type="text" class="tel-number-field" name="tel_no_1" value="" maxlength="4" />-<input type="text" class="tel-number-field" name="tel_no_2" value="" maxlength="4"  />-<input type="text" class="tel-number-field" name="tel_no_3" value="" maxlength="10"  /></label>
			<label><span>Next of Kin Name<span class="required">*</span></span><input type="text" class="input-field" name="field1" value="" /></label>
			<label><span>Next of Kin Telephone</span><input type="text" class="tel-number-field" name="tel_no_1" value="" maxlength="4" />-<input type="text" class="tel-number-field" name="tel_no_2" value="" maxlength="4"  />-<input type="text" class="tel-number-field" name="tel_no_3" value="" maxlength="10"  /></label>
			<label><span>Minimum Hours</span><input type="number" min="1" max="10"></label><br>
			<label><span>Maximum Hours</span><input type="number" min="1" max="10"></label><br/>
			
			<label><span>Department</span><select name="field4" class="select-field">
			<option value="Kithen">Kitchen</option>
			<option value="floor">Floor</option>
			</select></label>
			
			<label><span>Position</span><select name="field4" class="select-field">
			<option value="Waiter">Waiter</option>
			<option value="Supervisor">Supervisor</option>
			<option value="Kitchen Porter">Kitchen Porter</option>
			<option value="Chef">Chef</option>
			<option value="Manager">Manager</option>
			</select></label>
					 
  			<label><span>Availability</span><br/><br/>
  			<input type="checkbox" id="Monday">  Monday <br/>
   			<input type="checkbox" id="Tuesday"> Tuesday <br/>
   			<input type="checkbox" id="Wednesday">  Wednesday <br />
   			<input type="checkbox" id="Thursday">  Thursday <br />
   			<input type="checkbox" id="Friday">  Friday <br/>
   			<input type="checkbox" id="Saturday">  Saturday <br />
			<input type="checkbox" id="Sunday">  Sunday <br/>  
  			</label>

			<label><span>&nbsp;</span><input type="submit" value="Submit" /></label>
			</form>
	</div>

<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>
>>>>>>> branch 'master' of https://github.com/vagnerC/RosteringSystem.git
