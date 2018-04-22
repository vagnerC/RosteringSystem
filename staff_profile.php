<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/RosteringSystem/resource/config.php');
require_once(TEMPLATE_PATH . "/header.php");

if(!isset($_SESSION['user_info'])):
echo "<script>location.href = 'index.php';</script>";
die();
elseif($_SESSION['user_info']['management'] != "true"):
echo "<script>location.href = 'logout.php';</script>";
die();
endif;

$idStaff            = $_GET['idStaff'];

$sql                = " SELECT *,
						DATE_FORMAT(dateOfBirth, '%d/%m/%Y') AS dateOfBirth
						FROM staff
						WHERE idStaff = '$idStaff'";

$sth = $DBH->prepare($sql);
$sth->execute();
$row = $sth->fetch(PDO::FETCH_OBJ);

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

					<div class="form-group">
						<label class="col-md-4 control-label"></label>
						<div class="col-md-4">
							<div id="info"></div> 
						</div>
					</div>
					
					<div class="form-group">
  						<label class="col-md-4 control-label" for="name">* First Name </label>  
  						<div class="col-md-4">
 							<div class="input-group">
       							<div class="input-group-addon">
        								<i class="fa fa-user"></i>
       							</div>
       							<input disabled id="name" name="name" type="text" placeholder="First Name" class="form-control input-md" value="<?php echo $row->name; ?>">
     	 					</div>
						</div>
					</div>

                    <div class="form-group">
						<label class="col-md-4 control-label" for="surname">* Last Name</label>  
                      	<div class="col-md-4">
                     		<div class="input-group">
                            		<div class="input-group-addon">
                            			<i class="fa fa-user"></i>
                            		</div>
                           		<input disabled id="surname" name="surname" type="text" placeholder="Last Name" class="form-control input-md" value="<?php echo $row->surname; ?>">
                    			</div>
                    		</div>
                    </div>

                    <div class="form-group">
                    		<label class="col-md-4 control-label" for="dateOfBirth">* Date Of Birth</label>  
                      	<div class="col-md-4">
                    			<div class="input-group">
                            		<div class="input-group-addon">
                             		<i class="fa fa-calendar"></i>
                            		</div>
                            		<input disabled class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="MM/DD/YYYY" type="text"/  value="<?php echo $row->dateOfBirth; ?>">
                          	</div>
						</div> 
                    </div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="phoneNumber">Phone number </label>  
  						<div class="col-md-4">
  							<div class="input-group">
       							<div class="input-group-addon">
    	    								<i class="fa fa-phone"></i>
            						</div>
    								<input id="phoneNumber" name="phoneNumber" type="text" placeholder="Phone number " class="form-control input-md" value="<?php echo $row->phoneNumber; ?>">
        						</div>
    						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="email">* Email Address</label>  
    						<div class="col-md-4">
							<div class="input-group">
								<div class="input-group-addon">
     								<i class="fa fa-envelope-o"></i>
								</div>
    								<input id="email" name="email" type="email" placeholder="Email Address" class="form-control input-md" value="<?php echo $row->email; ?>">
							</div>
 						</div>
					</div>

                    <div class="form-group">
                    		<label class="col-md-4 control-label" for="nextOfKinName">Next of kin Name</label>  
						<div class="col-md-4">
                     		<div class="input-group">
                    				<div class="input-group-addon">
                    					<i class="fa fa-male" style="font-size: 20px;"></i>
                           	    </div>
                           		<input id="nextOfKinName" name="nextOfKinName" type="text" placeholder="Next of Kin Name" class="form-control input-md" value="<?php echo $row->nextOfKinName; ?>">
							</div>
						</div>
                    </div>

                    <div class="form-group">
                     	<label class="col-md-4 control-label" for="nextOfKinPhoneNumber"> Next of Kin Phone Number </label>  
                      	<div class="col-md-4">
                      		<div class="input-group">
                           		<div class="input-group-addon">
                         			<i class="fa fa-phone"></i>
								</div>
                        			<input id="nextOfKinPhoneNumber" name="nextOfKinPhoneNumber" type="text" placeholder="Next of Kin Phone number " class="form-control input-md"  value="<?php echo $row->nextOfKinPhoneNumber; ?>">
                     		</div>
						</div>
					</div>
	
			
				</fieldset>
			</form>
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