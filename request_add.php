<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

?>
<head>

    
 <title>Request Holidays and Day Off </title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">
    <!-- Bootstrap Core CSS -->
<!--     <link href="css/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">

<!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 

<!--Font Awesome (added because you use icons in your prepend/append)-->
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

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
<legend>Request Day off and Holidays </legend>

<!-- Text input-->


<div class="form-group">
  <label class="col-md-4 control-label" for="type">Type</label>
  <div class="col-md-4">
  <div class="checkbox">
    <label for="holidays">
      <input type="checkbox" name="type" id="Holidays" value="Holidays" >
      Holidays
    </label>
    </div>
  <div class="checkbox">
    <label for="Day Off">
      <input type="checkbox" name="type" id="Day Off" value="Day Off">
      Day Off
    </label>
    </div>
 </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="from">From</label>  
  <div class="col-md-4">

  <div class="input-group">
   
	<div class="col-sm-20">
       <div class="input-group">
        <div class="input-group-addon">
         <i class="fa fa-calendar">
         </i>
        </div>
        <input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" type="text"/>
       </div>
      </div>      </div>
  
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="to">To</label>  
  <div class="col-md-4">

  <div class="input-group">
   
	<div class="col-sm-20">
       <div class="input-group">
        <div class="input-group-addon">
         <i class="fa fa-calendar">
         </i>
        </div>
        <input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" type="text"/>
       </div>
      </div>      </div>
  
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" ></label>  
  <div class="col-md-4">
  <input class="btn btn-primary" type="submit" value="Submit">
    
  </div>
</div>

</fieldset>
</form>
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