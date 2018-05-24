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

$weekName       = array(1=>"Monday", 2=>"Tuesday", 3=>"Wednesday", 4=>"Thursday", 5=>"Friday", 6=>"Saturday", 7=>"Sunday");
$idDepartment   = $_SESSION['user_info']['idDepartment'];

// ---------------------------------------------------------------------------------------------------
// Function returns the week we are in.
function weekNumber(){
    return (new DateTime())->format("W");
}

echo "<form action='roster_configuration.php' method='post' id='roster_configuration-form' name='roster_configuration-form'>";

// ---------------------------------------------------------------------------------------------------
// GET all the variables and pass them via hidden form.
foreach ($_POST as $variable => $value):
$$variable  = $value;
echo "<input type='hidden' name='$variable' value='$value'>";
endforeach;

// ---------------------------------------------------------------------------------------------------
// SAVE IN DATABASE! // 4
if (isset($_POST['3Next'])):

$date = date('Y-m-d',strtotime((date("Y")."W".$week_number)));
echo "<br>Y: ".$year = date('Y',strtotime((date("Y")."W".$week_number)));
return;
for($i=1; $i<=7; $i++) {
    
    $starting       = $weekName[$i]."Open";
    $starting_full  = $date." ".$$starting.":00:00";
    $ending         = $weekName[$i]."Close";
    $ending_full    = $date." ".$$ending.":00:00";
    
    if($$starting != ""){
        $sql = "SELECT
                idbusinessHours
                FROM businessHours
                WHERE department_idDepartment = '$idDepartment'
                AND week = '$week_number'
                AND openingTime LIKE '$date%'";
        $sth = $DBH->prepare($sql);
        $sth->execute();
        if($sth->rowCount() > 0):
        $row = $sth->fetch(PDO::FETCH_OBJ);
        $idbusinessHours = $row->idbusinessHours;
        $sql = "UPDATE businessHours SET openingTime = ?, closingTime = ?
                    WHERE idbusinessHours = ?
                    LIMIT 1;";
        $sth = $DBH->prepare($sql);
        
        $sth->bindParam(1,  $starting_full, PDO::PARAM_INT);
        $sth->bindParam(2,  $ending_full, PDO::PARAM_INT);
        $sth->bindParam(3,  $idbusinessHours, PDO::PARAM_INT);
        
        if($sth->execute()) {
            //echo "ok, Update";
        } else {
            echo "Error, Update";
        }
        else:
        
        
        try{
            $sql = "DELETE FROM businessHours
                        WHERE department_idDepartment = ?
                        AND week = ?";
            
            $sth = $DBH->prepare($sql);
            
            $sth->bindParam(1, $idDepartment, PDO::PARAM_INT);
            $sth->bindParam(2, $week_number, PDO::PARAM_INT);
            
            if($sth->execute()):
            echo "<script>location.href = 'request_view.php#$idRequest';</script>";
            else:
            echo "ERROR!";
            print_r($sth->errorInfo());
            endif;
        } catch(PDOException $e) {echo $e;}
        
        
        
        $sql = "INSERT INTO businessHours (openingTime, closingTime, department_idDepartment, week)
                    VALUES (?, ?, ?, ?)";
        $sth = $DBH->prepare($sql);
        
        $sth->bindParam(1,  $starting_full, PDO::PARAM_INT);
        $sth->bindParam(2,  $ending_full, PDO::PARAM_INT);
        $sth->bindParam(3,  $idDepartment, PDO::PARAM_INT);
        $sth->bindParam(4,  $week_number, PDO::PARAM_INT);
        
        if($sth->execute()):
        //echo "ok, Insert";
        $idbusinessHours = $DBH->lastInsertId();
        else:
        echo "Error, Insert";
        endif;
        
        endif;
    }
    $date = date('Y-m-d',date(strtotime("+1 day", strtotime("$date"))));
    
    for($x=06; $x<=23; $x++){
        $staff_Hour = $weekName[$i]."_".$x;
        
        if(isset($$staff_Hour)):
        //echo "<br>SIM: $staff_Hour: ".$$staff_Hour;
        $sql = "SELECT *
                        FROM employeePerHour
                        WHERE hour = '$x:00:00'
                        AND businessHours_idBusinessHours = '$idbusinessHours'";
        
        $sth = $DBH->prepare($sql);
        $sth->execute();
        if($sth->rowCount() > 0):
        $row = $sth->fetch(PDO::FETCH_OBJ);
        $idEmployeePerHour = $row->idEmployeePerHour;
        $sql = "UPDATE employeePerHour SET numberOfEmployeePerHour = ?
                            WHERE idEmployeePerHour = ?
                            LIMIT 1;";
        $sth = $DBH->prepare($sql);
        
        $sth->bindParam(1,  $$staff_Hour, PDO::PARAM_INT);
        $sth->bindParam(2,  $idEmployeePerHour, PDO::PARAM_INT);
        
        if($sth->execute()) {
            //echo "ok, Update";
        } else {
            echo "Error, Update (idEmployeePerHour)";
        }
        else:
        $sql = "INSERT INTO employeePerHour (hour, numberOfEmployeePerHour, businessHours_idBusinessHours)
                    VALUES (?, ?, ?)";
        $sth = $DBH->prepare($sql);
        
        $hour = "$x:00:00";
        
        $sth->bindParam(1,  $hour, PDO::PARAM_INT);
        $sth->bindParam(2,  $$staff_Hour, PDO::PARAM_INT);
        $sth->bindParam(3,  $idbusinessHours, PDO::PARAM_INT);
        
        if($sth->execute()):
        //echo "ok, Insert";
        else:
        echo "Error, Insert (idEmployeePerHour)";
        endif;
        endif;
        endif;
    }
}

echo "<script>location.href = 'roster_generate.php?w=$week_number';</script>";
die();

// ---------------------------------------------------------------------------------------------------
// STAFF PER HOUR // 3
elseif (isset($_POST['2Next'])):
?>
<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading">Select a week | Opening Hours | <b>Staff Per Hour</b> | Generate Roster</div>
		<div class="panel-body">
            	<div class="row">
            		<div class="col-md-12">
            			<fieldset>
						<div class="row">
        						<div class="container" id="openClose">
                					<div class="row">
        								<?php 
                                    for($i=1; $i<=7; $i++) {
                                        echo "<div class='col'>";
                                            echo "<div class='row'><p>$weekName[$i]</p></div>";
                                            echo "<div class='row'>";
                                                $starting = $weekName[$i]."Open";
                                                $ending = $weekName[$i]."Close";
                                                for($x=$$starting; $x<$$ending; $x++){
                                                    echo "<div class='input-group mb-2'>";
                                                        echo "<div class ='input-group-prepend'>";
                                                        echo "<label class='input-group-text' for='inputGroupSelect01'>".str_pad($x, 2, "0", STR_PAD_LEFT).":00</label>";
                                                            $sql = "SELECT
                                                                    numberOfEmployeePerHour
                                                                    FROM employeePerHour
                                                                    INNER JOIN businessHours ON businessHours_idBusinessHours = idBusinessHours
                                                                    WHERE hour = '$x:00:00'
                                                                    AND DATE_FORMAT(openingTime, '%W') = '$weekName[$i]'
                                                                    AND department_idDepartment = '$idDepartment'
                                                                    ORDER BY idEmployeePerHour DESC
                                                                    LIMIT 1";
                                                            $sth = $DBH->prepare($sql);
                                                            $sth->execute();
                                                            $row = $sth->fetch(PDO::FETCH_OBJ);
                                                            echo "<select class='custom-select' name='$weekName[$i]_$x'>";
                                                                for($y=1; $y<=20; $y++){
                                                                    if($row->numberOfEmployeePerHour == $y):
                                                                        echo "<option value='$y' selected>$y</option>";
                                                                    else:
                                                                        echo "<option value='$y'>$y</option>";
                                                                    endif;
                                                                }
                                                            echo "</select>";
                                                        echo "</div>";
                                                    echo "</div>";
        											}
        									echo "</div>";
        								echo "</div>";
        								}?>
        							</div>
        							
        							<br>
                            		<div class="row">
                            			<div class="col" style="text-align: center">
                            				<button type="Submit" class="btn btn-primary" name="3Next">Next, Generate Roster</button>
                            			</div>
                            		</div>
        						</div>
        						
        					</div>
					</fieldset>
            		</div>
            	</div>
		</div>   
	</div>
</div>

<?php 
// ---------------------------------------------------------------------------------------------------
// OPENING HOURS // 2
elseif(isset($_POST['1Next'])):
?>

<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading">Select a week | <b>Opening Hours</b> | Staff Per Hour | Generate Roster</div>
		<div class="panel-body">
            	<div class="row">
            		<div class="col-md-12">
            			<fieldset>
						<div class="row">
        						
        						<div class="container" id="openClose">
                					<div class="row">
        								<?php 
                                    for($i=1; $i<=7; $i++) {
                                        $dayOpen = $weekName[$i]."Open";
                                        $dayClose = $weekName[$i]."Close";
        							       
                                        $sql = "    SELECT
                                                    DATE_FORMAT(openingTime, '%H') AS opening,
                                                    DATE_FORMAT(closingTime, '%H') AS closing
                                                    FROM businessHours
                                                    WHERE week = '$week_number'
                                                    AND department_idDepartment = '$idDepartment'
                                                    AND DATE_FORMAT(openingTime, '%W') = '$weekName[$i]'";
                                        $sth = $DBH->prepare($sql);
                                        $sth->execute();
                                        if($sth->rowCount() == 0):
                                        $sql = "    SELECT
                                                        DATE_FORMAT(openingTime, '%H') AS opening,
                                                        DATE_FORMAT(closingTime, '%H') AS closing
                                                        FROM businessHours
                                                        WHERE week = (SELECT MAX(week) FROM businessHours WHERE department_idDepartment = '$idDepartment' AND week <> '$week_number')
                                                        AND department_idDepartment = '$idDepartment'
                                                        AND DATE_FORMAT(openingTime, '%W') = '$weekName[$i]'";
                                            $sth = $DBH->prepare($sql);
                                            $sth->execute();
                                        endif;
                                        
                                        $row = $sth->fetch(PDO::FETCH_OBJ);
                                        
        								?>
        								<div class="col">
        									<div class="row"><p><?php echo $weekName[$i]; ?></p></div>
        									<div class="row">
        										<select class="custom-select" name="<?php echo $dayOpen; ?>">
        											<option value="">Open</option>
        											<?php 
        											for($x=06; $x<=23; $x++){
        											    if($row->opening == $x):
        											         echo "<option value='$x' selected>".str_pad($x, 2, "0", STR_PAD_LEFT).":00</option>";
        											    else:
        											         echo "<option value='$x'>".str_pad($x, 2, "0", STR_PAD_LEFT).":00</option>";
        											    endif;
        											}?>
        										</select>
        									</div>
        									<br>
        									<div class="row">
        										<select class="custom-select" name="<?php echo $dayClose; ?>">
        											<option value="">Close</option>
        											<?php 
        											for($x=06; $x<=23; $x++){
        											    if($row->closing == $x):
        											         echo "<option value='$x' selected>".str_pad($x, 2, "0", STR_PAD_LEFT).":00</option>";
        											    else:
        											         echo "<option value='$x'>".str_pad($x, 2, "0", STR_PAD_LEFT).":00</option>";
        											    endif;
        											}?>
        										</select>
        									</div>
        								</div>
        								<?php }?>
        							</div>
        							
        							<br>
                            		<div class="row">
                            			<div class="col" style="text-align: center">
                            				<button type="Submit" class="btn btn-primary" name="2Next">Next</button>
                            			</div>
                            		</div>
        						</div>
        						
        					</div>
					</fieldset>
            		</div>
            	</div>
		</div>   
	</div>
</div>

<?php 
// ---------------------------------------------------------------------------------------------------
// SELECT A WEEK // 1
else: 
?>

<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading"><b>Select a week</b> | Opening Hours | Staff Per Hour | Generate Roster</div>
		<div class="panel-body">
            	<div class="row">
            		<div class="col-md-12">
            			<fieldset>
						<div class="row">
        						<div class="col" style="text-align: center">
        							<select name ='week_number'> <!-- class="custom-select" -->
								   <?php 
								   $sql    = " SELECT
                                                idbusinessHours,
                                                week AS maximum,
                                                idRoster
                                                FROM businessHours
                                                LEFT JOIN roster ON idbusinessHours = businessHours_idBusinessHours
                                                WHERE department_idDepartment = '$idDepartment'
                                                ORDER BY week DESC
                                                LIMIT 1";
								   $sth    = $DBH->prepare($sql);
								   $sth->execute();
								   $row    = $sth->fetch(PDO::FETCH_OBJ);

								   if($sth->rowCount() > 0):
								        if($row->idRoster > 0):
        								        for ($i=($row->maximum + 1); $i<($row->maximum + 4); $i++):
        								            echo "<option value='$i'> Week $i</option>";
        								        endfor;
								        else:
        								        for ($i=($row->maximum); $i<($row->maximum + 4); $i++):
        								            echo "<option value='$i'> Week $i</option>";
        								        endfor;
                                        endif;
                                    else:
                                        for ($i=weekNumber(); $i<(weekNumber() + 4); $i++):
                                            echo "<option value='$i'> Week $i</option>";
                                        endfor;
                                    endif;
                                    ?>
                					</select>
                					<br><br>
                					<button type="Submit" class="btn btn-primary" name="1Next">Next</button>
        						</div>
        					</div>
					</fieldset>
            		</div>
            	</div>
		</div>   
	</div>
</div>

<?php 
endif; 
echo "</form>";
?>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script> 
<?php 
require_once("template/footer.php");
?>