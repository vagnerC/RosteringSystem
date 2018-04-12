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
<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading"><b>View Staff</b></div>
		<div class="panel-body">

            	<div class="row">
            		<div class="col-md-12">
            			<fieldset>
            					
            				<div class="form-group">
            					<label class="col-md-4 control-label"></label>
            				</div>
            
            				<div class="input-group"> 
            					<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                					<input id="filter" type="text" class="form-control" placeholder="Filter the table below:">
            				</div>
            
                            <table class="table table-striped">
            					<thead>
            						<tr>
                                      <th>Staff</th>
                                      <th>Email</th>
                                      <th>Phone Number</th>
                                      <th>Department</th>
                                      <th>Position</th>
                                      <th>Actions</th>
                                    </tr>
                                  </thead>
                                  <tbody class="searchable">
                                   <?php 
                                   try{
                                       $sql = " SELECT
                                                CONCAT(name, ' ', surname) AS fullname,
                                                email,
                                                phoneNumber,
                                                departmentName,
                                                positionName
                                                FROM staff
                                                INNER JOIN position ON position_idPosition = idPosition
                                                INNER JOIN department ON department_idDepartment = idDepartment
                                                ORDER BY fullname";
                                       $sth = $DBH->prepare($sql);
                                       $sth->execute();
                                       while ($row = $sth->fetch(PDO::FETCH_OBJ)){
                                           echo "<tr>";
                                               echo "<td>$row->fullname</td>";
                                               echo "<td>$row->email</td>";
                                               echo "<td>$row->phoneNumber</td>";
                                               echo "<td>$row->departmentName</td>";
                                               echo "<td>$row->positionName</td>";
                                               echo "<td>Edit | View | Delete</td>";
                                           echo "</tr>";
                                       }
                                   } catch(PDOException $e) {echo $e;}
                                   ?>
                                  </tbody>
            				</table>
             			</fieldset>
            		</div>
            	</div>
            </div>   
	</div>
</div>

<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    
<script>
$(document).ready(function () {
	(function ($) {
        $('#filter').keyup(function () {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        })
    }(jQuery));
});
</script>    
<?php 
require_once("template/footer.php");
?>