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
      <th scope="col">Request Id</th>
      <th scope="col">From / Title</th>
      <th scope="col">Start Date</th>
      <th scope="col">End Date</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark / Day Off</td>
      <td>10/04/2018</td>
      <td>15/04/2018</td>
      <td>Pending</td>
    </tr>
     <tr>
      <th scope="row">2</th>
      <td>Mark / Holiday </td>
      <td>10/04/2018</td>
      <td>15/04/2018</td>
      <td>Not approved</td>
    </tr>
     <tr>
      <th scope="row">3</th>
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