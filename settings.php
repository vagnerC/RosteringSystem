<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');

require_once(TEMPLATE_PATH . "/header.php");

?>

<head>


<title>Settings </title>
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
<legend>Settings</legend>

<!-- Text input-->
<div class="form-group">
<label class="col-md-4 control-label" for="newEmail">New Email</label>
<div class="col-md-4">
<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-envelope-o"></i>

</div>
<input id="newEmail" name="New Email" type="text" placeholder="New Email" class="form-control input-md" value="<?php echo $newEmail;?>">

</div>

</div>
</div>


<!-- Text input-->
<div class="form-group">
<label class="col-md-4 control-label" for="newPassword">New Password</label>
<div class="col-md-4">
<div class="input-group">
<div class="input-group-addon">
<i class="fa fa-key"></i>

</div>
<input id="newEmail" name="New Password" type="text" placeholder="New Password" class="form-control input-md" value="<?php echo $newPassword;?>">

</div>

</div>
</div>
</fieldset>
</form>

<?php
require_once(TEMPLATE_PATH . "/footer.php");
?>

