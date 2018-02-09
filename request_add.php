<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");

?>
<div class="form-style-2">
		<div class="form-style-2-heading"> Request Add </div>
<p>Type:</p>
<form action="/action_page.php">
  <input type="radio" name="holiday" value="Holiday" checked> Holiday<br>
  <input type="radio" name="dayoff" value="Day off"> Day off<br>
    <label><span>&nbsp;</span><input type="submit" value="Submit" /></label>
  
  <form>
  <div>
    <label for="party">From:
    <input type="date" id="from" name="from" ></label>
     <span class="validity"></span>
    
    <label for="party">To:  
    <input type="date" id="to" name="to"></label>
    <span class="validity"></span>
  </div>
  <div>
    <input type="submit">
  </div>
</form>


	</div>
	





<?php
require_once(TEMPLATE_PATH . "/footer.php");
?>