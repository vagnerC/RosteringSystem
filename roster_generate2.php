<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");

$idDepartment = $_SESSION['user_info']['idDepartment'];

$addStaffError = 0;
$addStaffErrorMessage = "";

if(!isset($_SESSION['user_info'])):
echo "<script>location.href = 'index.php';</script>";
die();
elseif($_SESSION['user_info']['management'] != "true"):
echo "<script>location.href = 'logout.php';</script>";
die();
endif;


if(isset($_GET['w'])):
unset($_SESSION['days_array']);
unset($_SESSION['staff_array']);
unset($_SESSION['info_array']);
endif;


if(isset($_SESSION['days_array'])):
$days_array     = $_SESSION['days_array'];
$staff_array    = $_SESSION['staff_array'];
$info_array     = $_SESSION['info_array'];
else:

// Array: days_array[][]
// Key = Day of the week.                       Eg: Monday
// Array[day] = Day of the month.                 Eg: 01/02/2018
// Array[openingTime] = Opening Time.                     Eg: 09:00:00
// Array[closingTime] = Closing Time.                     Eg: 22:00:00
// Array[employeePerHour] = Array(x)
// Array[employeePerHour][x] = KEY Hour                           Eg: 13:00:00
// Array[employeePerHour][x] = numberOfEmployeePerHour        Eg: 2
// Array[staff] = array
$days_array         = array();
//Array that contains staff informations.
$staff_array         = array();

$info_array = array();
//Variables to show on the table the minimum and maximum hours of the week.
$info_array['week'] = $_GET['w'];
$info_array['min_openingTime'] = "22";
$info_array['max_closingTime'] = "09";

try{
    $sql            = " SELECT
                            idbusinessHours,
                            DATE_FORMAT(openingTime, '%W') AS weekDay,
                            DATE_FORMAT(openingTime, '%d/%m/%Y') AS monthDay,
                            DATE_FORMAT(openingTime, '%H:%i:%s') AS openingT,
                            DATE_FORMAT(closingTime, '%H:%i:%s') AS closingT,
                            DATE_FORMAT(openingTime, '%H') AS hourOpeningTime,
                            DATE_FORMAT(closingTime, '%H') AS hourClosingTime,
                            hour,
                            numberOfEmployeePerHour
                            FROM businessHours
                            LEFT JOIN employeePerHour ON businessHours_idBusinessHours = idBusinessHours
                            WHERE week = '".$info_array['week']."'
                            AND department_idDepartment = '$idDepartment'
                            ORDER BY openingTime, hour";
    $sth = $DBH->prepare($sql);
    $sth->execute();
    while ($row     = $sth->fetch(PDO::FETCH_OBJ)):
    //Check if the Week Day is already in the array, if not it adds.
    if(!array_key_exists($row->weekDay, $days_array)):
    $days_array[$row->weekDay]["day"] = $row->monthDay;
    $days_array[$row->weekDay]["openingTime"] = $row->openingT;
    $days_array[$row->weekDay]["closingTime"] = $row->closingT;
    $days_array[$row->weekDay]["idbusinessHours"] = $row->idbusinessHours;
    endif;
    
    //Add a new array at the position 3 with the number of employee required per hour.
    $days_array[$row->weekDay]["employeePerHour"][$row->hour][0] = $row->numberOfEmployeePerHour;
    for($i=1; $i<=$row->numberOfEmployeePerHour;$i++){
        $days_array[$row->weekDay]["employeePerHour"][$row->hour][$i] = "ADD STAFF";
    }
    
    
    //Check the earliest time the shop opens.
    if($row->hourOpeningTime < $info_array['min_openingTime']):
    $info_array['min_openingTime'] = $row->hourOpeningTime;
    endif;
    
    //Check the latest time the shop closes.
    if($row->hourClosingTime > $info_array['max_closingTime']):
    $info_array['max_closingTime'] = $row->hourClosingTime;
    endif;
    
    endwhile;
    
    //$days_array['min_openingTime'] = $min_openingTime;
    //$days_array['max_closingTime'] = $max_closingTime;
    
}catch(PDOException $e) {echo $e;}

//STAFF
try{
    $sql           = "  SELECT
                            idStaff,
                            CONCAT (name,' ',surname) AS fullname,
                            minHours,
                            maxHours,
                            TRIM(daysAvailable) AS daysAvailable
                            FROM staff
                            INNER JOIN position ON position_idPosition = idPosition
                            WHERE disabled = 'No'
                            AND department_idDepartment = '$idDepartment'";
    $sth = $DBH->prepare($sql);
    $sth->execute();
    while ($row     = $sth->fetch(PDO::FETCH_OBJ)):
    $staff_array[$row->idStaff]["fullname"] = $row->fullname;
    $staff_array[$row->idStaff]["minHours"] = $row->minHours;
    $staff_array[$row->idStaff]["maxHours"] = $row->maxHours;
    $staff_array[$row->idStaff]["workedHours"] = 0;
    $staff_array[$row->idStaff]["daysAvailable"] = explode(" ", $row->daysAvailable);
    endwhile;
    
}catch(PDOException $e) {echo $e;}



foreach ($days_array as $dayWeek => $arraysDays){
    
    $newDate0 = explode("/", $arraysDays["day"]);
    $newDate1 = $newDate0[2]."-".$newDate0[1]."-".$newDate0[0];
    
    $sql           = "  SELECT
                            request.*,
                            name
                            FROM request
                            INNER JOIN staff ON staff_idStaff = idStaff
                            INNER JOIN position ON position_idPosition = idPosition
                            WHERE ('$newDate1' BETWEEN startDate AND finishDate)
                            AND status = 'Approved'
                            AND department_idDepartment = '$idDepartment'";
    
    $sth = $DBH->prepare($sql);
    $sth->execute();
    while ($row     = $sth->fetch(PDO::FETCH_OBJ)):
    
    if (in_array($dayWeek, $staff_array[$row->staff_idStaff]['daysAvailable'])) {
        
        $key = array_search($dayWeek, $staff_array[$row->staff_idStaff]['daysAvailable']);
        array_splice($staff_array[$row->staff_idStaff]['daysAvailable'], $key, 1);
    }
    endwhile;
}

foreach ($days_array as $dayWeek => $arraysDays){
    
    foreach ($arraysDays["employeePerHour"] as $time => $employeePerHour){
        
        $cont = 1;
        foreach ($staff_array as $idStaff => $arraysStaff){
            
            if (in_array($dayWeek, $arraysStaff['daysAvailable'])) {
                
                if($cont <= $employeePerHour[0]){
                    
                    if($arraysStaff["workedHours"] < $arraysStaff["maxHours"]){
                        
                        $days_array[$dayWeek]["employeePerHour"][$time][$cont] = $arraysStaff["fullname"];
                        $staff_array[$idStaff]["workedHours"] = $staff_array[$idStaff]["workedHours"] + 1;
                        $cont++;
                    }
                }
            }
        }
    }
}


$_SESSION['days_array'] = $days_array;
$_SESSION['staff_array'] = $staff_array;
$_SESSION['info_array'] = $info_array;

endif;


//ACTION
if(isset($_REQUEST['a'])){
    
    if($_REQUEST['a'] == "d"):
    //DELETE
    $week_day   = $_GET['wd'];
    $hour       = $_GET['h'];
    $position   = $_GET['p'];
    
    $totalPerHour = $days_array[$week_day]["employeePerHour"]["$hour:00:00"][0];
    $totalElements = (count($days_array[$week_day]["employeePerHour"]["$hour:00:00"])-1);
    
    foreach ($staff_array as $idStaff => $arraysStaff){
        if($arraysStaff["fullname"] == $days_array[$week_day]["employeePerHour"]["$hour:00:00"][$position]):
        $staff_array[$idStaff]["workedHours"] = ($staff_array[$idStaff]["workedHours"] - 1);
        break;
        endif;
    }
    
    if($totalElements == $totalPerHour):
    $days_array[$week_day]["employeePerHour"]["$hour:00:00"][$position] = "ADD STAFF";
    elseif($totalElements > $totalPerHour):
    array_splice($days_array[$week_day]["employeePerHour"]["$hour:00:00"], $position, 1);
    endif;
    
    
    
    
    $_SESSION['days_array'] = $days_array;
    $_SESSION['staff_array'] = $staff_array;
    
    
    elseif($_REQUEST['a'] == "saveStaff"):
    $week_day   = $_POST['wd'];
    $hour       = $_POST['h'];
    $position   = $_POST['p'];
    $fullname_idStaff    = $_POST['fullname_idStaff'];
    $fullname_idStaff = explode("|", $fullname_idStaff);
    echo "<br>FULL: ".$fullname = $fullname_idStaff[0];
    echo "<br>FULL: ".$idStaff = $fullname_idStaff[1];
    
    $days_array[$week_day]["employeePerHour"]["$hour:00:00"][$position] = $fullname;
    $staff_array[$idStaff]["workedHours"] = ($staff_array[$idStaff]["workedHours"] + 1);
    
    
    $_SESSION['days_array'] = $days_array;
    $_SESSION['staff_array'] = $staff_array;
    
    
    elseif($_REQUEST['a'] == "s"):
    //SAVE
    
    $staff_save_array = array();
    
    
    foreach ($days_array as $dayWeek => $arraysDays){
        
        $oT = substr($arraysDays['openingTime'], 0, 2);
        $cT = substr($arraysDays['closingTime'], 0, 2);
        $newDate0 = explode("/", $arraysDays["day"]);
        $newDate1 = $newDate0[2]."-".$newDate0[1]."-".$newDate0[0];
        
        for($i=$oT; $i<$cT; $i++){
            
            $i = str_pad($i, 2, "0", STR_PAD_LEFT);
            
            for($x=1; $x<=$arraysDays['employeePerHour']["$i:00:00"][0]; $x++){
                
                if($arraysDays['employeePerHour']["$i:00:00"][$x] == "ADD STAFF"):
                $addStaffError = 1;
                $addStaffErrorMessage = "<br> Add a Staff at $i:00:00 on ".$arraysDays["day"];
                break;
                endif;
                
                //Get ID from $arraysStaff
                foreach ($staff_array as $idStaff => $arraysStaff){
                    
                    if($arraysStaff["fullname"] == $arraysDays['employeePerHour']["$i:00:00"][$x]):
                    $staffID = $idStaff;
                    break;
                    endif;
                }
                
                if(!array_key_exists($staffID, $staff_save_array)):
                
                $staff_save_array[$staffID][$newDate1][0] = "$i:00:00";
                $staff_save_array[$staffID][$newDate1][1] = $i.":00:00";
                $staff_save_array[$staffID][$newDate1][2] = $arraysDays['idbusinessHours'];
                else:
                //echo "<br>ELSE 1: $i: ".($i+1);
                if(!array_key_exists($newDate1,  $staff_save_array[$staffID])):
                $staff_save_array[$staffID][$newDate1][0] = "$i:00:00";
                $staff_save_array[$staffID][$newDate1][1] = $i.":00:00";
                $staff_save_array[$staffID][$newDate1][2] = $arraysDays['idbusinessHours'];
                endif;
                
                endif;
                
                if(array_key_exists($newDate1, $staff_save_array[$staffID])):
                
                if("$i:00:00" < $staff_save_array[$staffID][$newDate1][0]):
                $staff_save_array[$staffID][$newDate1][0] = "$i:00:00";
                endif;
                //echo "<br>Before If 2: $i: ".$staff_save_array[$staffID][$newDate1][1];
                
                if("$i:00:00" >= $staff_save_array[$staffID][$newDate1][1]):
                
                $staff_save_array[$staffID][$newDate1][1] = $i.":00:00";
                endif;
                
                endif;
                
                
                
            }
            
        }
        
        //                 echo "<hr>";
        //                 echo "<hr>";
        //                 echo "<br>STAFF SAVE ARRAY:<br>";
        //                 print_r($staff_save_array);
        //                 echo "<hr>";
        //                 echo "<hr>";
    }
    
    if($addStaffError == 0){
        
        //SAVE DATABASE
        $sql = "";
        foreach ($staff_save_array as $idStaff => $staff_save_arrays){
            
            foreach($staff_save_arrays as $date => $values){
                
                //$new_hour
                $new_hour = date('H:i:s', strtotime($values[1].'+1 hour'));
                
                echo "<br>SQL: ".$sql .= "   INSERT INTO roster (businessHours_idBusinessHours, staff_idStaff, startingTime, finishingTime)
                                VALUES ('$values[2]', '$idStaff', '$date $values[0]', '$date $new_hour');";
            }
        }
        
        
        //             $sth = $DBH->prepare($sql);
        //             if($sth->execute()):
        //                 echo "<script>location.href = 'roster_view.php';</script>";
        //                 die();
        //             else:
        //                 echo "Error, Insert";
        //             endif;
    }
    
    
    
    endif;
}




echo "<hr>";
echo "<br>DAYS: ";
print_r($days_array);
echo "<hr>";
echo "<br>STAFF: ";
print_r($staff_array);
echo "<hr>";
?>
<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading">Select a week | Opening Hours | Staff Per Hour | <b>Generate Roster</b></div>
		<div class="panel-body">
            	<div class="row">
            		<div class="col-md-12">
            			<fieldset>
						<div class="row">
        						<div class="col" style="text-align: center">

<?php    
    
    echo "<table border='1' width='100%' class='calendar'>";
       
        if($addStaffError > 0):
            echo "<tr>";
                echo "<td class='calendar-day' colspan='8'><a name='error'>$addStaffErrorMessage</a></td>";
            echo "</tr>";
        endif;
        
        echo "<tr>";
            echo "<td rowspan='2' class='calendar-day-head'></td>";
            foreach ($days_array as $key => $item){
                echo "<td align='center' class='calendar-day-head'>$key<br>".$item["day"]."</td>";
            }
        echo "</tr>";
        
        echo "<tr>";
            foreach ($days_array as $key => $item) {
                echo "<td class='calendar-day-head'>".$item['openingTime']." - ".$item['closingTime']."</td>";
            }
        echo "</tr>";
        
        for($i=$info_array['min_openingTime']; $i<$info_array['max_closingTime']; $i++){
            $i = str_pad($i, 2, "0", STR_PAD_LEFT);
            echo "<tr>";
            echo "<td class='calendar-day-head'><a name='$i'></a> $i:00:00</td>";
            
            foreach ($days_array as $dayWeek => $arraysDays){
                echo "<td align='left' valign='top' class='calendar-day'>";
                    
                    if(array_key_exists("$i:00:00", $arraysDays["employeePerHour"])):
                    
                        for($x=1; $x<=$arraysDays["employeePerHour"]["$i:00:00"][0];$x++){
                            echo "$x - ";
                            
                            if($arraysDays["employeePerHour"]["$i:00:00"][$x] == "ADD STAFF"):
                                //echo "<a href='roster_generate.php?a=d&wd=$dayWeek&h=$i&p=$x'>".$arraysDays["employeePerHour"]["$i:00:00"][$x]."</a> <br>";
                            
                            echo "<form method='post' action='roster_generate.php'>";
                                echo "<input type='hidden' name='a' value='saveStaff'>";
                                echo "<input type='hidden' name='wd' value='$dayWeek'>";
                                echo "<input type='hidden' name='h' value='$i'>";
                                echo "<input type='hidden' name='p' value='$x'>";
                            
                                echo "<select class='custom-select' name='fullname_idStaff' onchange='this.form.submit()'>";
                                    
                                    foreach ($staff_array as $idStaff => $arraysStaff){
                                        
                                        foreach ($arraysStaff["daysAvailable"] as $key => $daysAvailable){
                                            
                                            if($daysAvailable == $dayWeek):
                                                
                                                
                                            if (!in_array($arraysStaff["fullname"], $arraysDays["employeePerHour"]["$i:00:00"])) {
                                                echo "<option value='".$arraysStaff["fullname"]."|$idStaff'>".$arraysStaff["fullname"]."</option>";
                                                
                                            }
                                            
                                            
                                                //foreach($arraysDays["employeePerHour"]["$i:00:00"] as $key2 => $sta)
                                            
                                            
                                            
                                            endif;
                                        }
                                        
                                    }
                                    
                                    
                                echo "</select><br>";
                                echo "</form>";
                                
                                
                            else:
                                echo $arraysDays["employeePerHour"]["$i:00:00"][$x]." <a href='roster_generate.php?a=d&wd=$dayWeek&h=$i&p=$x#$i'>(D)</a> <br>";
                            endif;
                        }
                        
                    else:
                        echo "&nbsp;";
                    endif;
                echo "</td>";
            }
            echo "</tr>";
        }
        
        
        
        echo "<tr>";
        echo "<td colspan='8'>";
        echo "<br><a href='roster_generate.php?a=s'><button class='btn btn-primary'>Save</button></a><br><br>";
        echo "</td>";
        echo "</tr>";
        
        
        
        echo "<tr>";
        echo "<td>Total</td>";
            echo "<td colspan='7'>";
                echo "<table border='1'>";
                    echo "<tr>";
                        echo "<td>Staff</td>";
                        echo "<td>Hours Available</td>";
                        echo "<td>Hours Scheduled</td>";
                    echo "</tr>";
                    $hoursAvailable = 0;
                    $hoursScheduled = 0;
                    foreach ($staff_array as $idStaff => $arraysStaff){
                            
                            echo "<tr>";
                                echo "<td>".$arraysStaff["fullname"]."</td>";
                                echo "<td>".$arraysStaff["maxHours"]."</td>";
                                echo "<td>".$arraysStaff["workedHours"]."</td>";
                            echo "</tr>";
                    $hoursAvailable += $arraysStaff["maxHours"];
                    $hoursScheduled += $arraysStaff["workedHours"];
                    }
                    echo "<tr>";
                        echo "<td>Total</td>";
                        echo "<td>$hoursAvailable</td>";
                        echo "<td>$hoursScheduled</td>";
                    echo "</tr>";
                echo "</table>";
            echo "</td>";
        echo "</tr>";

        
        
        
        
        
    echo "</table>";
?>

        							
        							
        							
        							
        						</div>
        					</div>
					</fieldset>
            		</div>
            	</div>
		</div>   
	</div>
</div>


<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<?php 
require_once("template/footer.php");
?>