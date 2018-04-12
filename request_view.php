<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
endif;
?>
<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading"><b>View Day Off/Holidays</b></div>
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
                                      <th>Type</th>
                                      <th>Start</th>
                                      <th>Finish</th>
                                      <th>Days</th>
                                      <th>Staff</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody class="searchable">
                                   <?php 
                                   if($_SESSION['user_info']['management'] == "true"):
                                        $where = "";
                                   else:
                                        $where = " WHERE staff_idStaff = ".$_SESSION['user_info']['id'];
                                   endif;
                                   
                                   try{
                                       $sql = " SELECT
                                                request.*,
                                                DATE_FORMAT(startDate, '%d/%m/%Y') AS startDate, 
                                                DATE_FORMAT(finishDate, '%d/%m/%Y') AS finishDate,
                                                CONCAT (staff.name, ' ', staff.surname) AS fullname,
                                                DATEDIFF(finishDate, startDate)+1 AS difference
                                                FROM request 
                                                INNER JOIN staff ON staff_idStaff = idStaff
                                                $where
                                                ORDER BY idRequest DESC";
                                       $sth = $DBH->prepare($sql);
                                       $sth->execute();
                                       while ($row = $sth->fetch(PDO::FETCH_OBJ)){
                                           echo "<tr>";
                                               echo "<td>$row->typeRequest</td>";
                                               echo "<td>$row->startDate</td>";
                                               echo "<td>$row->finishDate</td>";
                                               echo "<td>$row->difference</td>";
                                               echo "<td>$row->fullname</td>";
                                               echo "<td>$row->status</td>";
                                               echo "<td>";
                                                   if($_SESSION['user_info']['management'] == "true"):
                                                        if($row->status == "Pending"):
                                                            echo "<a href='request_action.php?idRequest=$row->idRequest&status=Approved'>Approve</a> | "; 
                                                            echo "<a href='request_action.php?idRequest=$row->idRequest&status=Disapproved'>Disapprove</a> | ";
                                                        endif;
                                                        echo "<a href='request_action.php?idRequest=$row->idRequest&status=Delete'>Delete</a>";
                                                   elseif($row->status == "Pending"):
                                                        echo "<a href='request_action.php?idRequest=$row->idRequest&status=Delete'>Delete</a>";
                                                   endif;
                                               echo "</td>";
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