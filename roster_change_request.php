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

if(isset($_GET['a'])){
    
    $idRosterChange = $_GET['idRC'];
    $idRoster       = $_GET['idR'];
    
    //Approve
    if($_GET['a'] == "a"){
        try{
            $sql = "UPDATE roster
                    INNER JOIN rosterChange ON idRoster = roster_idRoster
                    SET startingTime = newStartingTime,
                    finishingTime = newFinishingTime
                    WHERE idRoster = ?;";
            $sth = $DBH->prepare($sql);
            $sth->bindParam(1, $idRoster, PDO::PARAM_INT);
            if($sth->execute()):
                $sql = "UPDATE rosterChange SET status = 'Approved' WHERE idRosterChange = ? LIMIT 1;";
                $sth = $DBH->prepare($sql);
                $sth->bindParam(1, $idRosterChange, PDO::PARAM_INT);
                if($sth->execute()):
                else:
                    echo "ERROR!";
                    print_r($sth->errorInfo());
                endif;
            else:
                echo "ERROR!";
                print_r($sth->errorInfo());
            endif;
        } catch(PDOException $e) {echo $e;}
    } 
    // Disapprove
    elseif($_GET['a'] == "d") {
        try{
            $sql = "UPDATE rosterChange SET status = 'Disapproved' WHERE idRosterChange = ? LIMIT 1;";
            $sth = $DBH->prepare($sql);
            $sth->bindParam(1, $idRosterChange, PDO::PARAM_INT);
            if($sth->execute()):
            else:
                echo "ERROR!";
                print_r($sth->errorInfo());
            endif;
        } catch(PDOException $e) {echo $e;}
    }
}
?>
<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading"><b>Roster Change Request</b></div>
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
                                      <th>Week</th>
                                      <th>Date</th>
                                      <th>Staff</th>
                                      <th>Starting</th>
                                      <th>Requested Starting</th>
                                      <th>Finishing</th>
                                      <th>Requested Finishing</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody class="searchable">
                                   <?php 
                                   try{
                                       $sql = "  SELECT
            								        idRosterChange,
                                                 idRoster,
                                                 CONCAT(name, ' ', surname) AS fullname,
                                                 DATE_FORMAT(openingTime, '%d/%m/%Y') AS date,
                                                 week,
                                                 startingTime,
                                                 finishingTime,
                                                 newStartingTime,
                                                 newFinishingTime
            								        FROM rosterChange
            								        INNER JOIN roster ON roster_idRoster    = idRoster
                                                 INNER JOIN staff  ON staff_idStaff      = idStaff
                                                 INNER JOIN businessHours ON businessHours_idBusinessHours = idBusinessHours
            								        WHERE status = 'Pending'
            								        ORDER BY openingTime DESC";
                                       $sth = $DBH->prepare($sql);
                                       $sth->execute();
                                       while ($row = $sth->fetch(PDO::FETCH_OBJ)){
                                           echo "<tr>";
                                               echo "<td>$row->week</td>";
                                               echo "<td>$row->date</td>";
                                               echo "<td>$row->fullname</td>";
                                               echo "<td>$row->startingTime</td>";
                                               echo "<td>$row->newStartingTime</td>";
                                               echo "<td>$row->finishingTime</td>";
                                               echo "<td>$row->newFinishingTime</td>";
                                               echo "<td><a href='?idRC=$row->idRosterChange&idR=$row->idRoster&a=a'>Approve</a> | <a href='?idRC=$row->idRosterChange&idR=$row->idRoster&a=d'>Disapprove</a></td>";
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