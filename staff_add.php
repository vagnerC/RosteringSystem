<<<<<<< HEAD
=======
<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");


// define variables and set to empty values
$nameErr = $surnameErr = $emailErr = $telephoneErr = $nextOfKinNameErr = $nextOfKinPhoneErr = $minHourErr = $maxHourErr = $departmentErr = $positionErr = $availabilityErr ="";
$firstName= $lastName = $emailAddress = $phoneNumber = $secondaryPhoneNumber = $nextOfKinName = $nextOfKinPhoneNumber 
= $address = $minHour = $maxHour = $department = $position = $availability ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["firstName"])) {
		$nameErr = "Name is required";
	} else {
		$name = test_input($_POST["firstName"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
			$nameErr = "Only letters and white space allowed";
		}
	}
	if (empty($_POST["surname"])) {
		$surnameErr = "Surname is required";
	} else {
		$surname = test_input($_POST["surname"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$surname)) {
			$surnameErr = "Only letters and white space allowed";
		}
	}
	if (empty($_POST["email"])) {
		$emailErr = "Email is required";
	} else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid email format";
		}
	}
	if (empty($_POST["telephone"])) {
		$telephoneErr = "Name is required";
	} else {
		$telephone = test_input($_POST["telephone"]);
		// check if name only contains only number
		if (!preg_match("/^[a-zA-Z ]*$/",$telephone)) {
			$telephoneErr = "Only number and white space allowed";
		}
	}
	if (empty($_POST["nextOfKinName"])) {
		$nextOfKinNameErr= "Name is required";
	} else {
		$nextOfKinName = test_input($_POST["nextOfKinName"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$nextOfKinName)) {
			$nextOfKinNameErr = "Only letters and white space allowed";
		}
	}
	if (empty($_POST["nextOfKinPhone"])) {
		$nextOfKinPhoneErr = "Name is required";
	} else {
		$nextOfKinPhone = test_input($_POST["nextOfKinPhone"]);
		// check if name only contains only number
		if (!preg_match("/^[a-zA-Z ]*$/",$nextOfKinPhone)) {
			$nextOfKinPhoneErr= "Only number and white space allowed";
		}
	}
	if (empty($_POST["minHour"])) {
		$minHourErr = "Mininum Hours Available is required";
	} else {
		$minHour= test_input($_POST["minHour"]);
	}
	if (empty($_POST["maxHour"])) {
		$maxHourErr = "Maximum Hours Available is required";
	} else {
		$maxHour= test_input($_POST["maxHour"]);
	}
	if (empty($_POST["department"])) {
		$departmentErr= "Department is required";
	} else {
		$department = test_input($_POST["department"]);
	}
	if (empty($_POST["position"])) {
		$positionErr = "Position is required";
	} else {
		$position = test_input($_POST["nextOfKinName"]);
	}
	if (empty($_POST["availability"])) {
		$availabilityErr = "Availability is required";
	} else {
		$availability = test_input($_POST["availability"]);
	}
	if (empty($_POST["comment"])) {
		$comment = "";
	} else {
		$comment = test_input($_POST["comment"]);
	}
}
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>

<head>
<title>User profile form </title>
<!-- Bootstrap Core CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 

<!--Font Awesome (added because you use icons in your prepend/append)-->
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">

<!-- Inline CSS based on choices in "Settings" tab -->
<style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style>

<!-- Custom CSS -->
<style>
.othertop{margin-top:10px;}
</style>
</head>

<body>

<div class="container">
	<div class="row">
		<div class="col-md-10 ">
			<form class="form-horizontal">
			<fieldset>

<!-- Form Name -->
<legend>User profile form </legend>

<!-- Text input-->
<div class="form-group">
  	<label class="col-md-4 control-label" for="firstName">First Name </label>  
  	<div class="col-md-4">
 		<div class="input-group">
       		<div class="input-group-addon">
        	<i class="fa fa-user"></i>
       		</div>
       		<input id="firstName" name="firstName" type="text" placeholder="First Name" class="form-control input-md" value="<?php echo $firstName;?>">
     	 </div>
	</div>
</div>

<!-- Text input-->
<div class="form-group">
 	<label class="col-md-4 control-label" for="lastName">Last Name</label>  
  	<div class="col-md-4">
 		<div class="input-group">
        	<div class="input-group-addon">
        	<i class="fa fa-user"></i>
        	</div>
       		<input id="lastName" name="lastName" type="text" placeholder="Last Name" class="form-control input-md" value="<?php echo $lastName;?>">
		</div>
	</div>
</div>

<!-- File Picture Button --> 
<div class="form-group">
	<label class="col-md-4 control-label" for="uploadPhoto">Upload photo</label>
  	<div class="col-md-4">
    	<input id="uploadPhoto" name="uploadPhoto" class="input-file" type="file">
    </div>
</div>

<!-- Text input-->
<div class="form-group">
	<label class="col-md-4 control-label" for="dateOfBirth">Date Of Birth</label>  
  	<div class="col-md-4">
		<div class="input-group">
			<div class="col-sm-20">
				<div class="input-group">
        			<div class="input-group-addon">
         				<i class="fa fa-calendar"></i>
        			</div>
        			<input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" type="text"/>
      		    </div>
      		</div> 
      	</div>
	</div>
</div>

<!-- Text input-->
<div class="form-group">
	<label class="col-md-4 control-label" for="phoneNumber ">Phone number </label>  
  	<div class="col-md-4">
  		<div class="input-group">
       		<div class="input-group-addon">
    	    <i class="fa fa-phone"></i>
            </div>
    		<input id="phoneNumber" name="phoneNumber" type="text" placeholder="Primary Phone number " class="form-control input-md" value="<?php echo $phoneNumber;?>">
        </div>
			<div class="input-group othertop">
	        	<div class="input-group-addon">
	    		<i class="fa fa-mobile fa-1x" style="font-size: 20px;"></i>
	        	</div>
    			<input id="secondaryPhoneNumber" name="secondaryPhoneNumber" type="text" placeholder=" Secondary Phone number " class="form-control input-md" value="<?php echo $secondaryPhoneNumber;?>">
     		</div>
		</div>
</div>

<!-- Text input-->
<div class="form-group">
	<label class="col-md-4 control-label" for="emailAddress">Email Address</label>  
    <div class="col-md-4">
		<div class="input-group">
			<div class="input-group-addon">
     		<i class="fa fa-envelope-o"></i>
			</div>
    		<input id="emailAddress" name="Email Address" type="text" placeholder="Email Address" class="form-control input-md" value="<?php echo $emailAddress;?>">
		</div>
 	</div>
</div>

<!-- Text input-->
<div class="form-group">
	<label class="col-md-4 control-label" for="nextOfKinName">Next of kin Name</label>  
    <div class="col-md-4">
 		<div class="input-group">
			<div class="input-group-addon">
			<i class="fa fa-male" style="font-size: 20px;"></i>
       	    </div>
       		<input id="nextOfKinName" name="nextOfKinName" type="text" placeholder="Next of Kin Name" class="form-control input-md" value="<?php echo $nextOfKinName;?>">
        </div>
    </div>
</div>

<!-- Text input-->
<div class="form-group">
 	<label class="col-md-4 control-label" for="nextOfKinPhoneNumber"> Next of Kin Phone Number </label>  
  	<div class="col-md-4">
  		<div class="input-group">
       		<div class="input-group-addon">
     		<i class="fa fa-phone"></i>
            </div>
    	<input id="nextOfKinPhoneNumber" name="nextOfKinPhoneNumber" type="text" placeholder="Next of Kin Phone number " class="form-control input-md" value="<?php echo $nextOfKinPhoneNumber;?>">
           
 		</div>
	</div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
 	<label class="col-md-4 control-label" for="department">Department</label>
  	<div class="col-md-4"> 
    	<label class="radio-inline" for="floor">
	    <input type="radio" name="department" id="floor" value="<?php echo $floor;?>" >
	      	Floor
    	</label> 
    	<label class="radio-inline" for="kitchen">
        <input type="radio" name="department" id="kitchen" value="<?php echo $kitchen;?>">
      	Kitchen
    	</label> 
	</div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
 	<label class="col-md-4 control-label" for="radios">Position</label>
  	<div class="col-md-4"> 
	    <label class="radio-inline" for="radios-0">
	    <input type="radio" name="Manager" id="Manager" value="1" value="<?php echo $position;?>">
	   	Manager
	    </label> 
	    <label class="radio-inline" for="radios-1">
	    <input type="radio" name="Waiter" id="Waiter" value="<?php echo $position;?>">
	    Waiter
	    </label>
	    <label class="radio-inline" for="radios-1">
	    <input type="radio" name="radios" id="radios-1" value="<?php echo $position;?>">
	    Chef
	    </label>
	    <label class="radio-inline" for="radios-1">
	    <input type="radio" name="Chef" id="Chef" value="<?php echo $position;?>">
	    KP
	    </label>
	</div>
</div>

<!-- Textarea -->
<div class="form-group">
	<label class="col-md-4 control-label" for="address)">Address</label>
  	<div class="col-md-4">                     
    <textarea class="form-control" rows="1"  id="address" name="address"><?php echo $address;?> </textarea>
 	</div>
</div>

<!-- Multiple Checkboxes -->
<div class="form-group">
	<label class="col-md-4 control-label" for="availability">Days Available</label>
  	<div class="col-md-4">
	    <div class="checkbox">
	    	<label for="monday">
	      	<input type="checkbox" name="availability" id="Monday" value="Monday" >
	     	 Monday
	    </label>
	    </div>
	  	<div class="checkbox">
	  		<label for="Tuesday">
	     	<input type="checkbox" name="availability" id="Tuesday" value="Tuesday">
	      	Tuesday
	    </label>
	    </div>
	  	<div class="checkbox">
	    <label for="Wednesday">
	    	<input type="checkbox" name="availability" id="Wednesday" value="Wednesday">
	      	Wednesday
	    </label>
	    </div>
	    <div class="checkbox">
	    <label for="Thursday">
	   		<input type="checkbox" name="availabilityn" id="Thursday" value="Thursday">
	      	Thursday
	    </label>
	    </div>
	    <div class="checkbox">
	    <label for="Friday">
	    	<input type="checkbox" name="availabilityn" id="Friday" value="Friday">
	        Friday
	    </label>
	    </div>
	    <div class="checkbox">
	    <label for="Saturday">
	    	<input type="checkbox" name="availabilityn" id="Saturday" value="Saturday">
	        Saturday
	    </label>
	    </div>
	    <div class="checkbox">
	    <label for="Sunday">
	    	<input type="checkbox" name="availabilityn" id="Sunday" value="Sunday">
	        Sunday
	    </label>
       </div>
	</div>
</div>

<!-- Textarea -->
<div class="form-group">
	<label class="col-md-4 control-label" for="Overview (max 200 words)">Notes (max 200 words)</label>
    <div class="col-md-4">                     
    	<textarea class="form-control" rows="10"  id="Overview (max 200 words)" name="Overview (max 200 words)">Overview</textarea>
  	</div>
</div>


<div class="form-group">
	<label class="col-md-4 control-label" ></label>  
  	<div class="col-md-4">
  	<a href="#" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span> Register</a>
  	<a href="#" class="btn btn-danger" value="<?php echo $note;?>"><span class="glyphicon glyphicon-remove-sign"></span> Clear</a>
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

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
	$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'dd/mm/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>

<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>
>>>>>>> branch 'master' of https://github.com/vagnerC/RosteringSystem.git
