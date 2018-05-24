<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
endif;

$idStaff = $_SESSION['user_info']['id'];

//Update rosterChange with notitication to Read, user comes from the home page.
if(isset($_GET['id'])){
    try{
        $sql = "UPDATE rosterChange SET notification = 'Read' WHERE idRosterChange = ? LIMIT 1;";
        $sth = $DBH->prepare($sql);
        $sth->bindParam(1, $_GET['id'], PDO::PARAM_INT);
        
        if($sth->execute()):
        else:
            echo "ERROR!";
            print_r($sth->errorInfo());
        endif;
    } catch(PDOException $e) {echo $e;}
}

if(isset($_POST['Request'])){
    $idRoster    = $_POST['idRoster'];
    $starting    = $_POST['starting'];
    $finishing   = $_POST['finishing'];
    
    try{
            $sql = "INSERT INTO rosterChange (roster_idRoster, newStartingTime, newFinishingTime)
                    VALUES (?, ?, ?);";
            $sth = $DBH->prepare($sql);
            
            $sth->bindParam(1,  $idRoster, PDO::PARAM_INT);
            $sth->bindParam(2,  $starting, PDO::PARAM_INT);
            $sth->bindParam(3,  $finishing, PDO::PARAM_INT);
            
            if($sth->execute()) {
                //echo "ok";
            } else {
                echo "Error.";
            }
    } catch(PDOException $e) {echo $e;}
    
    
}
?>
<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading"><b>Roster Change</b></div>
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
                                      <th>Starting</th>
                                      <th>Finishing</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody class="searchable">
                                   <?php 
                                   try{
                                       $sql = "  SELECT
            								        idRoster,
                                                 DATE_FORMAT(openingTime, '%d/%m/%Y') AS date,
                                                 week,
                                                 startingTime,
                                                 finishingTime,
                                                 newStartingTime,
                                                 newFinishingTime,
                                                 idRosterChange
            								        FROM roster
            								        INNER JOIN businessHours ON businessHours_idBusinessHours = idBusinessHours
                                                 LEFT JOIN rosterChange ON roster_idRoster = idRoster
            								        WHERE openingTime > CONCAT(DATE_SUB(DATE(NOW()), INTERVAL 15 DAY), ' 00:00:00')
            								        AND staff_idStaff = '$idStaff'
            								        ORDER BY openingTime DESC";
                                       $sth = $DBH->prepare($sql);
                                       $sth->execute();
                                       while ($row = $sth->fetch(PDO::FETCH_OBJ)){
                                           echo "<tr>";
                                               echo "<td>$row->week</td>";
                                               echo "<td>$row->date</td>";
                                               if($row->idRosterChange == ""):
                                                   echo "<form method='post' action='' id='roster_change-form'>";
                                                   echo "<input type='hidden' name='idRoster' value='$row->idRoster'>";
                                                   echo "<td><input type='text' name='starting' id='starting' value='$row->startingTime' class='form-control input-md'></td>";
                                                   echo "<td><input type='text' name='finishing' value='$row->finishingTime' class='form-control input-md'></td>";
                                                   echo "<td>";
                                                        echo "<button type='Submit' class='btn btn-primary' name='Request'>Request</button>"; 
                                                   echo "</td>";
                                                   echo "</form>";
                                                else:
                                                    echo "<td>$row->newStartingTime ($row->startingTime)</td>";
                                                    echo "<td>$row->newFinishingTime ($row->finishingTime)</td>";
                                                    echo "<td></td>";
                                                endif;
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
<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

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