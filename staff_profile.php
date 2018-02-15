<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");

$name = $surname = $email = $telephone = $nextOfKinName = $nextOfKinPhone = $minHour = $maxHour = $department = $position = $availability ="";

?>
<!-- Bootstrap Core CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 

<!--Font Awesome (added because you use icons in your prepend/append)-->
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">

<!-- Custom CSS -->
<style>
.othertop{margin-top:10px;}

</style>

<div class="container">
	<div class="row">
		<div class="col-md-10 ">
			<form class="form-horizontal">
			<fieldset>

<!-- Form Name -->
<legend>User profile </legend>

<!-- Text input-->
<div class="form-group">
  	<label class="col-md-4 control-label" for="firstName">First Name: </label>  
  	<div class="col-md-4">
 		<div class="input-group">
 		
       	</div>
	</div>
</div>

<!-- Text input-->
<div class="form-group">
 	<label class="col-md-4 control-label" for="lastName">Last Name: </label>  
  	<div class="col-md-4">
 		<div class="input-group">
        	
		</div>
	</div>
</div>

<!-- Text input-->
<div class="form-group">
	<label class="col-md-4 control-label" for="dateOfBirth">Date Of Birth: </label>  
  	<div class="col-md-4">
		<div class="input-group">
			
      	</div> 
      	
	</div>
</div>

<!-- Text input-->
<div class="form-group">
	<label class="col-md-4 control-label" for="phoneNumber ">Phone number: </label>  
  	<div class="col-md-4">
  		<div class="input-group">
        </div>
			<div class="input-group othertop">
	        </div>
		</div>
</div>

<!-- Text input-->
<div class="form-group">
	<label class="col-md-4 control-label" for="emailAddress">Email Address: </label>  
    <div class="col-md-4">
		<div class="input-group">
		</div>
 	</div>
</div>

<!-- Text input-->
<div class="form-group">
	<label class="col-md-4 control-label" for="nextOfKinName">Next of kin Name: </label>  
    <div class="col-md-4">
 		<div class="input-group">
		
		</div>
    </div>
</div>

<!-- Text input-->
<div class="form-group">
 	<label class="col-md-4 control-label" for="nextOfKinPhoneNumber"> Next of Kin Phone Number:  </label>  
  	<div class="col-md-4">
  		<div class="input-group">
       		
 		</div>
	</div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
 	<label class="col-md-4 control-label" for="department">Department: </label>
  	<div class="col-md-4"> 
    	
	</div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
 	<label class="col-md-4 control-label" for="radios">Position: </label>
  	<div class="col-md-4"> 
	    
	</div>
</div>

<!-- Textarea -->
<div class="form-group">
	<label class="col-md-4 control-label" for="address)">Address: </label>
  	<div class="col-md-4">                     

 	</div>
</div>

<!-- Multiple Checkboxes -->
<div class="form-group">
	<label class="col-md-4 control-label" for="availability">Days Available: </label>
  	<div class="col-md-4">
  	
 	</div>	    
</div>

<!-- Textarea -->
<div class="form-group">
	<label class="col-md-4 control-label" for="Overview (max 200 words)">Notes: </label>
    <div class="col-md-4">                     

  	</div>
</div>

</fieldset>
</form>
</div>

<div class="col-md-2 hidden-xs">
	<img src="http://websamplenow.com/30/userprofile/images/avatar.jpg" class="img-responsive img-thumbnail ">
</div>

	</div>
	</div>


    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
</body>
</html>



<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>