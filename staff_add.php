<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
elseif($_SESSION['user_info']['position'] != "Manager"):
    echo "<script>location.href = 'logout.php';</script>";
    die();
endif;
?>
<div class="container">
	<div class="row">
		<div class="col-md-10 ">
			<form class="form-horizontal" method="post" id="staff_add-form">
				<fieldset>
					<legend>User profile form </legend>
					
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
       							<input id="name" name="name" type="text" placeholder="First Name" class="form-control input-md">
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
                           		<input id="surname" name="surname" type="text" placeholder="Last Name" class="form-control input-md">
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
                            		<input class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="MM/DD/YYYY" type="text"/>
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
    								<input id="phoneNumber" name="phoneNumber" type="text" placeholder="Primary Phone number " class="form-control input-md">
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
    								<input id="email" name="email" type="email" placeholder="Email Address" class="form-control input-md">
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
                           		<input id="nextOfKinName" name="nextOfKinName" type="text" placeholder="Next of Kin Name" class="form-control input-md">
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
                        			<input id="nextOfKinPhoneNumber" name="nextOfKinPhoneNumber" type="text" placeholder="Next of Kin Phone number " class="form-control input-md">
                     		</div>
						</div>
					</div>
					
					<div class="form-group">
                     	<label class="col-md-4 control-label" for="position_idPosition">* Position</label>  
                      	<div class="col-md-4">
                      		<div class="input-group">
                           		<div class="input-group-addon">
                         			<i class="fa fa-briefcase"></i>
								</div>
                        			<select class="form-control input-md" name="position_idPosition" id="position_idPosition">
                        				<option value=''>Position</option>
        								<?php
        								try{
                                        $dep = "";
        								   $sql = "SELECT * 
                                                FROM position
                                                INNER JOIN department ON department_idDepartment = idDepartment
                                                ORDER BY departmentName, positionName";
                                        $sth = $DBH->prepare($sql);
                                        $sth->execute();
                                        while ($row = $sth->fetch(PDO::FETCH_OBJ)):
                                            if($dep != $row->departmentName):
                                                echo "<optgroup label='$row->departmentName'>";
                                                echo "<option value='$row->idPosition'>$row->positionName</option>";
                                                $dep = $row->departmentName;
                                            else:
                                                echo "<option value='$row->idPosition'>$row->positionName</option>";
                                            endif;
        									endwhile;
        								} catch(PDOException $e) {echo $e;}
        								?>
        							</select>
                     		</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="minHours">* Minimum Hour Available</label>
  						<div class="col-md-4">
  							<div class="input-group">
                           		<div class="input-group-addon">
                         			<i class="fa fa-hourglass-o"></i>
								</div>
                        			<input name="minHours" id="minHours" type="number" placeholder="0" min="0" max="40" class="form-control input-md">
                     		</div>
 						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label" for="maxHours">* Maximum Hour Available</label>
  						<div class="col-md-4">
  							<div class="input-group">
                           		<div class="input-group-addon">
                         			<i class="fa fa-hourglass"></i>
								</div>
                        			<input name="maxHours" id="maxHours" type="number" placeholder="0" min="0" max="40" class="form-control input-md">
                     		</div>
 						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="daysAvailable">* Days Available</label>
							<div class="col-md-4">
								<div class="checkbox">
    									<label for="Monday">
                        	      			<input type="checkbox" name="daysAvailable[]" id="Monday" value="Monday" > Monday
                        	    			</label>
                    	    			</div>
                    	  			
                    	  			<div class="checkbox">
                    	  				<label for="Tuesday">
                    	     				<input type="checkbox" name="daysAvailable[]" id="Tuesday" value="Tuesday"> Tuesday
                    	    				</label>
                    	    			</div>
                    	  	
                    	  			<div class="checkbox">
                    	    				<label for="Wednesday">
                    	    					<input type="checkbox" name="daysAvailable[]" id="Wednesday" value="Wednesday"> Wednesday
                    	    				</label>
                    	    			</div>
                    	    			
                    	    			<div class="checkbox">
                    	    				<label for="Thursday">
                    	   					<input type="checkbox" name="daysAvailable[]" id="Thursday" value="Thursday"> Thursday
                    	    				</label>
                    	    			</div>
                    	    
								<div class="checkbox">
                    	    				<label for="Friday">
										<input type="checkbox" name="daysAvailable[]" id="Friday" value="Friday"> Friday
                    	    				</label>
                    	    			</div>
                    	    			
                    	    			<div class="checkbox">
                    	    				<label for="Saturday">
                    	    					<input type="checkbox" name="daysAvailable[]" id="Saturday" value="Saturday"> Saturday
                    	    				</label>
                    	    			</div>
                    	    			
                    	    			<div class="checkbox">
                    	    				<label for="Sunday">
                    	    					<input type="checkbox" name="daysAvailable[]" id="Sunday" value="Sunday"> Sunday
                    	    				</label>
                           		</div>
                    			</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" ></label>  
  						<div class="col-md-4">
  							<input class="btn btn-primary" type="submit" value="Register">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label" ></label>  
  						<div class="col-md-4">
						</div>
					</div>
					
				</fieldset>
			</form>
		</div>
	</div>
</div>

<!-- Bootstrap Core CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
<!--Font Awesome (added because you use icons in your prepend/append)-->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-3dkvEK0WLHRJ7/Csr0BZjAWxERc5WH7bdeUya2aXxdU= sha512-+L4yy6FRcDGbXJ9mPG8MT/3UCDzwR9gPeyFNMCtInsol++5m3bk2bXWKdZjvybmohrAsn3Ua5x8gfLnbE1YkOg==" crossorigin="anonymous">
<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script>
	$(document).ready(function(){
		var date_input=$('input[name="dateOfBirth"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'dd/mm/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
	
	
	$('document').ready(function(){ 
		/* validation */
		$("#staff_add-form").validate({
		rules:
		{
			name: {
				required: true
			},
			surname: {
				required: true
            },
            dateOfBirth: {
				required: true
            },
            email: {
				required: true,
				email: true
            },
            minHours: {
				required: true
            },
            maxHours: {
				required: true
            },
            daysAvailable: {
				required: true
            },
            position_idPosition: {
				required: true
            },
		},
		messages:
		{
			type: "Please choose a Type.",
			from: "Please select a From date.",
			to: "Please select a To date.",
		},
	    submitHandler: submitForm
	});  
	   
	/* login submit */
	function submitForm()
	{		
		var data = $("#staff_add-form").serialize();
				
		$.ajax({
			type : 'POST',
			url  : 'staff_add_process.php',
			data : data,
			success: function(response)
			{						
				if(response=="ok"){
					$("#info").fadeIn(1000, function(){
						$("#info").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-thumbs-up"></span> Data successfully saved.</div>');
					});
				} else {
					$("#info").fadeIn(1000, function(){						
						$("#info").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-thumbs-down"></span> &nbsp; '+response+'</div>');
					});
				}
			}
		});
		return false;
	}
});	
</script>
<?php 
require_once("template/footer.php");
?>