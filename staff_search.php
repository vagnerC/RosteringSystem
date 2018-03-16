<?php
session_start();
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . "/RosteringSystem/resource/config.php");
require_once(TEMPLATE_PATH . "/header.php");
if(!isset($_SESSION['user_info'])):
header("Location: index.php");
die();
endif;

$name = $surname = $email = $telephone = $nextOfKinName = $nextOfKinPhone = $minHour = $maxHour = $department = $position = $availability ="";

?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">

 <!-- Custom CSS -->
<style>

 .othertop{margin-top:10px;}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-10 ">
		<form class="form-horizontal">
		<fieldset>

<legend>Search Staff </legend>

<!-- Text input-->
<div class="form-group">
  	<label class="col-md-4 control-label" for="firstName">First Name </label>  
  	<div class="col-md-4">
 		<div class="input-group">
       		<div class="input-group-addon">
        	<i class="fa fa-user"></i>
       		</div>
       		<input id="firstName" name="firstName" type="text" placeholder="First Name" class="form-control input-md" value="">
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
       		<input id="lastName" name="lastName" type="text" placeholder="Last Name" class="form-control input-md" value="">
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
    <input id="Phone number " name="Phone number " type="text" placeholder="Primary Phone number " class="form-control input-md" value="">
    
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
    <input id="Email Address" name="Email Address" type="text" placeholder="Email Address" class="form-control input-md" value="">
    
      </div>
  
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" ></label>  
  <div class="col-md-4">
  <input class="btn btn-primary" type=â€œsubmitâ€� value="Search">
  <!--  <a href="#" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span> Search</a>
  <a href="#" class="btn btn-danger" value="<?php echo $note;?>"><span class="glyphicon glyphicon-remove-sign"></span> Clear</a>-->
    
  </div>
</div>

</fieldset>
</form>
</div>
</div>
   </div>
    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

<?php 
require_once(TEMPLATE_PATH . "/footer.php");
?>