<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");
?>
		<div class="form-style-2">
		<div class="form-style-2-heading"> Staff Search</div>
		<form action="staff_search.php" method="post">
			<label for="field1"><span>Name <span class="required">*</span></span><input type="text" class="input-field" name="field1" value="" /></label>
			<label for="field2"><span>Surname <span class="required">*</span></span><input type="text" class="input-field" name="field2" value="" /></label>
			<label for="field3"><span>Email <span class="required">*</span></span><input type="text" class="input-field" name="field3" value="" /></label>
			<label><span>Telephone</span><input type="text" class="tel-number-field" name="tel_no_1" value="" maxlength="4" />-<input type="text" class="tel-number-field" name="tel_no_2" value="" maxlength="4"  />-<input type="text" class="tel-number-field" name="tel_no_3" value="" maxlength="10"  /></label>
			<label><span>&nbsp;</span><input type="submit" value="Search" /></label>
			

			</form>
	</div>
<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>