<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");
?>
	
<!-- Bootstrap Core CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 

<!--Font Awesome (added because you use icons in your prepend/append)-->
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">


<div class="container">
	<div class="row">
		<div class="col-md-10 ">
			<form class="form-horizontal">
			<fieldset>

<!-- Form Name -->

<br>
<!-- Table -->
<div>
<div>
<table class="table table-hover" border=2>
  <thead>
    <tr class="table-secondary">
      <th scope="col">Subject</th>
      <th scope="col">To</th>
      <th scope="col">Date</th>	
      <th scope="col">Action</th>
      <th scope=“col”><i class="fa fa-trash"></i></th>
      		
    </tr>
  </thead>
    <tr>
	<td>
	<input type="checkbox" name="type"> Holiday
	</td>
	<td>Manager</td>	
	<td>02/02/2018</td>
	<td><a href=“message_view.php” target=“_self”>View</a></td>
	<td><i class="fa fa-trash"></i></td>
	
    </tr>

    <tr>
	<td>
	<input type="checkbox" name="type"> Day Off
	</td>
	<td>Manager</td>	
	<td>03/02/2018</td>
	<td><a href=“message_view.php” target=“_self”>View</a></td>
	<td><i class="fa fa-trash"></i></td>
    </tr>

   <tr>
	<td>
	<input type="checkbox" name="type"> Holiday
	</td>
	<td>Manager</td>	
	<td>02/03/2018</td>
	<td><a href=“message_view.php” target=“_self”>View</a></td>
	<td><i class="fa fa-trash"></i></td>
    </tr>

	
</div>

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
</body>
</html>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>



<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>