<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");

$firstName= $lastName = $emailAddress = $phoneNumber = $secondaryPhoneNumber = "";

?>

<div>
<table class="table table-hover">
  <thead>
    <tr class="table-secondary">
      <td scope="col">Request Id</td>
      <td scope="col">From / Type</td>
      <td scope="col">Start Date</td>
      <td scope="col">End Date</td>
      <td scope="col">Status</td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td scope="row">1</td>
      <td>Mark / Day Off</td>
      <td>10/04/2018</td>
      <td>15/04/2018</td>
      <td>Pending</td>
    </tr>
     <tr>
      <td scope="row">2</td>
      <td>Mark / Holiday </td>
      <td>10/04/2018</td>
      <td>15/04/2018</td>
      <td>Not approved</td>
    </tr>
     <tr>
      <td scope="row">3</td>
      <td>Mark</td>
      <td>10/04/2018</td>
      <td>15/04/2018</td>
      <td>Approved</td>
    </tr>
    
  </tbody>
</table>
</div>
<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>