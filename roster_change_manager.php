<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
elseif($_SESSION['user_info']['management'] != "true"):
    echo "<script>location.href = 'logout.php';</script>";
    die();
endif;

$idDepartment   = $_SESSION['user_info']['idDepartment'];

if(isset($_POST['View']) OR isset($_GET['week'])){
    $week = $_REQUEST['week'];
}
?>
<form action='roster_change_manager.php' method='post' id='roster_change_manager-form' name='roster_change_manager-form'>
<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading"><b>Select a week</b></div>
		<div class="panel-body">
            	<div class="row">
            		<div class="col-md-12">
            			<fieldset>
						<div class="row">
        						<div class="col" style="text-align: center">
        							<select name ='week'> <!-- class="custom-select" -->
								   <?php 
								   $sql    = " SELECT 
                                                DISTINCT(week) AS distWeek 
                                                FROM businessHours
                                                ORDER BY week";
								   $sth    = $DBH->prepare($sql);
								   $sth->execute();
								   while ($row     = $sth->fetch(PDO::FETCH_OBJ)){
								       if($row->distWeek == $week):
								            echo "<option value='$row->distWeek' selected> Week $row->distWeek</option>";
								       else:
								            echo "<option value='$row->distWeek'> Week $row->distWeek</option>";
								       endif;
								   }
                                    ?>
                					</select>
                					<br><br>
                					<button type="Submit" class="btn btn-primary" name="View">View</button>
        						</div>
        					</div>
					</fieldset>
            		</div>
            	</div>
		</div>   
	</div>
</div>

<?php 
if(isset($_POST['View']) OR isset($_GET['week'])){
?>
<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading"><b><?php echo "Week $week"; ?></b></div>
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
                                      <th>Start</th>
                                      <th>Finish</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody class="searchable">
                                   <?php 
                                   try{
                                       $sql = " SELECT
                                                idRoster,
                                                businessHours_idBusinessHours,
                                                startingTime,
                                                finishingTime,
                                                DATE_FORMAT(openingTime, '%d/%m/%Y %H:%i:%s') AS openingTimeDate, 
                                                DATE_FORMAT(closingTime, '%H:%i:%s') AS closingTimeDate,                                                
                                                CONCAT(name, ' ', surname) AS fullname
                                                FROM roster
                                                INNER JOIN businessHours    ON businessHours_idBusinessHours = idBusinessHours
                                                INNER JOIN staff            ON staff_idStaff = idStaff
                                                WHERE week = '$week'
                                                AND department_idDepartment = '$idDepartment'
                                                ORDER BY openingTime, startingTime";
                                       $sth = $DBH->prepare($sql);
                                       $sth->execute();
                                       $opening = 0;
                                       while ($row = $sth->fetch(PDO::FETCH_OBJ)){
                                           if($row->openingTimeDate != $opening):
                                                echo "<tr>";
                                                echo "<th colspan='4'>Opening Hours: $row->openingTimeDate - $row->closingTimeDate <a href='roster_change_manager_add.php?id=$row->businessHours_idBusinessHours&w=$week'>[Add Staff]</a></th>";
                                                echo "</tr>";
                                           endif;
                                           
                                           echo "<tr>";
                                               echo "<td>$row->fullname</td>";
                                               echo "<td>$row->startingTime</td>";
                                               echo "<td>$row->finishingTime</td>";
                                               echo "<td><a href='roster_change_manager_edit.php?id=$row->idRoster&w=$week'>Edit</a> | <a href='roster_change_manager_delete.php?id=$row->idRoster&w=$week'>Delete</a></td>";
                                           echo "</tr>";
                                           $opening = $row->openingTimeDate;
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

<?php } ?>
</form>

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