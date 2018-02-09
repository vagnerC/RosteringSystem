<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");


// define variables and set to empty values
$nameErr = $surnameErr = $emailErr = $telephoneErr = $nextOfKinNameErr = $nextOfKinPhoneErr = $minHourErr = $maxHourErr = $departmentErr = $positionErr = $availabilityErr ="";
$name = $surname = $email = $telephone = $nextOfKinName = $nextOfKinPhone = $minHour = $maxHour = $department = $position = $availability ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$nameErr = "Name is required";
	} else {
		$name = test_input($_POST["name"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
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
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User profile form </title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">
    <!-- Bootstrap Core CSS -->
<!--     <link href="css/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
   

    .othertop{margin-top:10px;}
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
  <label class="col-md-4 control-label" for="First Name">First Name </label>  
  <div class="col-md-4">
 <div class="input-group">
       <div class="input-group-addon">
        <i class="fa fa-user">
        </i>
       </div>
       <input id="First Name" name="First Name" type="text" placeholder="First Name" class="form-control input-md" value="<?php echo $name;?>">
      </div>

    
  </div>

  
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="Last Name">Last Name</label>  
  <div class="col-md-4">
 <div class="input-group">
       <div class="input-group-addon">
        <i class="fa fa-user">
        </i>
       </div>
       <input id="Last Name" name="Last Name" type="text" placeholder="Last Name" class="form-control input-md" value="<?php echo $surname;?>">
      </div>

    
  </div>

  
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="Upload photo">Upload photo</label>
  <div class="col-md-4">
    <input id="Upload photo" name="Upload photo" class="input-file" type="file">
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Date Of Birth">Date Of Birth</label>  
  <div class="col-md-4">

  <div class="input-group">
       <div class="input-group-addon">
     <i class="fa fa-birthday-cake"></i>
        
       </div>
       <input id="Date Of Birth" name="Date Of Birth" type="text" placeholder="Date Of Birth" class="form-control input-md">
      </div>
  
    
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Phone number ">Phone number </label>  
  <div class="col-md-4">
  <div class="input-group">
       <div class="input-group-addon">
     <i class="fa fa-phone"></i>
        
       </div>
    <input id="Phone number " name="Phone number " type="text" placeholder="Primary Phone number " class="form-control input-md" value="<?php echo $primaryPhone;?>">
    
      </div>
      <div class="input-group othertop">
       <div class="input-group-addon">
     <i class="fa fa-mobile fa-1x" style="font-size: 20px;"></i>
        
       </div>
    <input id="Phone number " name="Secondary Phone number " type="text" placeholder=" Secondary Phone number " class="form-control input-md" value="<?php echo $secondaryPhone;?>">
    
      </div>
  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Email Address">Email Address</label>  
  <div class="col-md-4">
  <div class="input-group">
       <div class="input-group-addon">
     <i class="fa fa-envelope-o"></i>
        
       </div>
    <input id="Email Address" name="Email Address" type="text" placeholder="Email Address" class="form-control input-md" value="<?php echo $email;?>">
    
      </div>
  
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Next of kin Name">Next of kin Name</label>  
  <div class="col-md-4">
  <div class="input-group">
       <div class="input-group-addon">
      <i class="fa fa-male" style="font-size: 20px;"></i>
        
       </div>
      <input id="Next of kin Name" name="Next of kin Name" type="text" placeholder="Next of kin Name" class="form-control input-md">

      </div>
    
  </div>
</div>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" for="NK Phone number "> Next of Kin Phone Number </label>  
  <div class="col-md-4">
  <div class="input-group">
       <div class="input-group-addon">
     <i class="fa fa-phone"></i>
        
       </div>
    <input id="NK Phone number " name="NK Phone number " type="text" placeholder="Primary Phone number " class="form-control input-md">
    
      </div>
      <div class="input-group othertop">
       <div class="input-group-addon">
     <i class="fa fa-mobile fa-1x" style="font-size: 20px;"></i>
        
       </div>
    <input id="Phone number " name="Secondary Phone number " type="text" placeholder=" Secondary Phone number " class="form-control input-md">
    
      </div>
  
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="Department">Department</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="Department-0">
      <input type="radio" name="Department" id="floor" value="<?php echo $floor;?>" checked="checked">
      Floor
    </label> 
    <label class="radio-inline" for="Department-1">
      <input type="radio" name="Department" id="kitchen" value="<?php echo $kitchen;?>">
      Kitchen
    </label> 
    
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">Position</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0">
      <input type="radio" name="Manager" id="Manager" value="1" checked="checked" value="<?php echo $position;?>">
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

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label col-xs-12" for="Permanent Address">Permanent Address</label>  
  <div class="col-md-2  col-xs-4">
  <input id="Permanent Address" name="Permanent Address" type="text" placeholder="District" class="form-control input-md " value="<?php echo $addressDistrict;?>">
  </div>

  <div class="col-md-2 col-xs-4">

  <input id="Permanent Address" name="Permanent Address" type="text" placeholder="Area" class="form-control input-md " value="<?php echo $addressArea;?>">
  </div>
 
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="Permanent Address"></label>  
  <div class="col-md-2  col-xs-4">
  <input id="Permanent Address" name="Permanent Address" type="text" placeholder="Street" class="form-control input-md" value="<?php echo $addressStreet;?>">
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

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

	<div class="form-style-2">
		<div class="form-style-2-heading"> Add Staff </div>
		<form action="staff_add.php" method="post">
			<label for="name"><span>Name <span class="required">*</span></span><input type="text" class="input-field" name="name" value="" /></label>
			<label for="surname"><span>Surname <span class="required">*</span></span><input type="text" class="input-field" name="surname" value="" /></label>
			<label for="email"><span>Email <span class="required">*</span></span><input type="text" class="input-field" name="email" value="" /></label>
			<label><span>Telephone</span><input type="text" class="tel-number-field" name="tel_no_1" value="" maxlength="4" />-<input type="text" class="tel-number-field" name="tel_no_2" value="" maxlength="4"  />-<input type="text" class="tel-number-field" name="tel_no_3" value="" maxlength="10"  /></label>
			<label><span>Next of Kin Name<span class="required">*</span></span><input type="text" class="input-field" name="field1" value="" /></label>
			<label><span>Next of Kin Telephone</span><input type="text" class="tel-number-field" name="tel_no_1" value="" maxlength="4" />-<input type="text" class="tel-number-field" name="tel_no_2" value="" maxlength="4"  />-<input type="text" class="tel-number-field" name="tel_no_3" value="" maxlength="10"  /></label>
			<label><span>Minimum Hours</span><input type="number" min="1" max="10" name="minHour" ></label><br>
			<label><span>Maximum Hours</span><input type="number" min="1" max="10" name="maxHour" ></label><br/>
			
			<label><span>Department</span><select name="department" class="select-field">
			<option value="Kithen">Kitchen</option>
			<option value="floor">Floor</option>
			</select></label>
			
			<label><span>Position</span><select name="position" class="select-field">
			<option <?php if (isset($position) && $position=="Waiter") echo "checked";?> value="Waiter">Waiter</option>
			<option <?php if (isset($position) && $position=="Supervisor") echo "checked";?> value="Supervisor">Supervisor</option>
			<option <?php if (isset($position) && $position=="Kitchen Porter") echo "checked";?> value="Kitchen Porter">Kitchen Porter</option>
			<option <?php if (isset($position) && $position=="Chef") echo "checked";?> value="Chef">Chef</option>
			<option <?php if (isset($position) && $position=="Manager") echo "checked";?> value="Manager">Manager</option>
			</select></label>
					 
  			<label><span>Availability</span><br/><br/>
  			<input type="checkbox" id="Monday" name="availability" <?php if (isset($availability) && $availability=="monday") echo "checked";?> value="monday" >  Monday <br/>
   			<input type="checkbox" id="Tuesday" name="availability" <?php if (isset($availability) && $availability=="monday") echo "checked";?> value="tuesday"> Tuesday <br/>
   			<input type="checkbox" id="Wednesday" name="availability" <?php if (isset($availability) && $availability=="monday") echo "checked";?> value="wednesday">  Wednesday <br />
   			<input type="checkbox" id="Thursday" name="availability" <?php if (isset($availability) && $availability=="monday") echo "checked";?> value="thursday">  Thursday <br />
   			<input type="checkbox" id="Friday" name="availability" <?php if (isset($availability) && $availability=="monday") echo "checked";?>  value="friday">  Friday <br/>
   			<input type="checkbox" id="Saturday" name="availability" <?php if (isset($availability) && $availability=="monday") echo "checked";?> value="saturday">  Saturday <br />
   			<input type="checkbox" id="Sunday" name="availability" <?php if (isset($availability) && $availability=="monday") echo "checked";?> value=sunday>  Sunday <br/>  
  			</label>

			<label><span>&nbsp;</span><input type="submit" value="Submit" /></label>
			</form>
	</div>
	
	
	
	
	
	

<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>