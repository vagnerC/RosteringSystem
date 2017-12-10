<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");

require_once(TEMPLATE_PATH . "/menu_manager.php");


?>

<br>
<br>
<form>
  Name:<input type="text" name="name"><br>
  Surname:<input type="text" name="surname"><br>
  Email:<input type="email" name="email"><br>
  Mobile Number:<input type="tel" name="mobilenumber"><br>
  Next Kin Name:<input type="text" name="nextkinname"><br>
  Next Kin Mobile Number:<input type="tel" name="nextkinmobilenumber"><br>
  Minimum hours:<input type="number" name="minimumhours" min="0" max="24"><br>
  Maximum hours:<input type="number" name="maximumhours" min="0" max="24"><br>
  Department:<input list="department" name="department">
  <datalist id="department">
    <option value="Kitchen">
    <option value="Restaurant">
    </datalist><br>
  Position:<input list="position" name="position">
   <datalist id="position">
    <option value="KitchenPorter">
    <option value="Supervisor">
    <option value="Floor Staff">
    </datalist><br>  
  Days Available:<input type="checkbox" name="day1" value="Sunday"> Sunday<br>
                 <input type="checkbox" name="day2" value="Monday"> Monday<br>
                 <input type="checkbox" name="day3" value="Tuesday"> Tuesday<br>
                 <input type="checkbox" name="day4" value="Wednesday"> Wednesday<br>
                 <input type="checkbox" name="day5" value="Thursday"> Thursday<br>
                 <input type="checkbox" name="day6" value="Friday"> Friday<br>
                 <input type="checkbox" name="day7" value="Saturday"> Saturday<br>	
                   <input type="submit">
</form>
<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>