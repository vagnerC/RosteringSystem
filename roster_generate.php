<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");

$idDepartment = $_SESSION['user_info']['idDepartment'];

$addStaffError = 0;
$addStaffErrorMessage = "";

// -------------------------------------------------------------------------------------------------------------------
// Redirect user in case they are not logged in/if they are not manager.
if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
elseif($_SESSION['user_info']['management'] != "true"):
    echo "<script>location.href = 'logout.php';</script>";
    die();
endif;

// -------------------------------------------------------------------------------------------------------------------
// If user comes from page roster_configuration.php it will get a W(Week) parameter from it and will delete all the sessios in case they exists.
if(isset($_GET['w'])){
    unset($_SESSION['days_array']);
    unset($_SESSION['staff_array']);
    unset($_SESSION['info_array']);
}

// -------------------------------------------------------------------------------------------------------------------
// If sessions exist they will be added to the specic variables.
if(isset($_SESSION['days_array'])){
    $days_array     = $_SESSION['days_array'];
    $staff_array    = $_SESSION['staff_array'];
    $info_array     = $_SESSION['info_array'];
// -------------------------------------------------------------------------------------------------------------------
// There are no Sessions, so the roster will be generated and informations will be added to the sessions. 
} else {

    // Array with informations about the week/days.
    $days_array                     = array();
    // Array that contains staff informations.
    $staff_array                    = array();
    // Array with informations about the week, minimum and maximum hours of the week.
    $info_array                     = array();
    $info_array['week']             = $_GET['w'];
    $info_array['min_openingTime']  = "22";
    $info_array['max_closingTime']  = "09";
    
    // -------------------------------------------------------------------------------------------------------------------
    // days_array - Get the information about opening, closing Time, numberOfEmployeePerHour, etc. in the database and add them into the array.
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
        $sth            = $DBH->prepare($sql);
        $sth->execute();
        while ($row     = $sth->fetch(PDO::FETCH_OBJ)){
            //Check if the Week Day is already in the array, if not it adds.
            if(!array_key_exists($row->weekDay, $days_array)):
                $days_array[$row->weekDay]["day"]               = $row->monthDay;
                $days_array[$row->weekDay]["openingTime"]       = $row->openingT;
                $days_array[$row->weekDay]["closingTime"]       = $row->closingT;
                $days_array[$row->weekDay]["idbusinessHours"]   = $row->idbusinessHours;
            endif;
            
            // Add a new element at the position 0 with the number of employee required per hour.
            $days_array[$row->weekDay]["employeePerHour"][$row->hour][0] = $row->numberOfEmployeePerHour;
            // Create the positions in the array and add the text "ADD STAFF" to them, this text will be replaced with the Staff name later.
            for($i=1; $i<=$row->numberOfEmployeePerHour;$i++):
                $days_array[$row->weekDay]["employeePerHour"][$row->hour][$i] = "ADD STAFF";
            endfor;
            
            //Check the earliest time the shop opens.
            if($row->hourOpeningTime < $info_array['min_openingTime']):
                $info_array['min_openingTime'] = $row->hourOpeningTime;
            endif;
            
            //Check the latest time the shop closes.
            if($row->hourClosingTime > $info_array['max_closingTime']):
                $info_array['max_closingTime'] = $row->hourClosingTime;
            endif;
        }
        //Add to the $info_array infos about the earliest and latest times that the shop opens/closes.
        //$info_array['min_openingTime'] = $min_openingTime;
        //$info_array['max_closingTime'] = $max_closingTime;
    }catch(PDOException $e) {echo $e;}
    
    // -------------------------------------------------------------------------------------------------------------------
    // staff_array - Get the information about staff like name, daysAvailable, maxHours, etc. in the database and add them into the array.
    try{
        $sql            = " SELECT
                            idStaff,
                            CONCAT (name,' ',surname) AS fullname,
                            maxHours,
                            TRIM(daysAvailable) AS daysAvailable,
                            wage
                            FROM staff
                            INNER JOIN position ON position_idPosition = idPosition
                            WHERE disabled = 'No'
                            AND department_idDepartment = '$idDepartment'";
        $sth            = $DBH->prepare($sql);
        $sth->execute();
        while ($row     = $sth->fetch(PDO::FETCH_OBJ)):
            $staff_array[$row->idStaff]["fullname"]                             = $row->fullname;
            $staff_array[$row->idStaff]["maxHours"]                             = $row->maxHours;
            $staff_array[$row->idStaff]["wage"]                                 = $row->wage;
            $staff_array[$row->idStaff]["workedHours"]                          = 0;
            $staff_array[$row->idStaff]["daysAvailable"]                        = explode(" ", $row->daysAvailable);
            foreach ($days_array as $dayWeek => $arraysDays):
                $staff_array[$row->idStaff]["workedHoursSpecific"][$dayWeek]    = 0;
            endforeach;
            
        endwhile;
    }catch(PDOException $e) {echo $e;}
    
    // -------------------------------------------------------------------------------------------------------------------
    // Loop the array $days_array and check in the database if theres a request for the specific date, if so remove staff from the $staff_array so when the roster is generated this staff will not appear.
    foreach ($days_array as $dayWeek => $arraysDays){
        
        $newDate0 = explode("/", $arraysDays["day"]);
        $newDate1 = $newDate0[2]."-".$newDate0[1]."-".$newDate0[0];
        
        $sql            = " SELECT
                            request.*,
                            name
                            FROM request
                            INNER JOIN staff ON staff_idStaff = idStaff
                            INNER JOIN position ON position_idPosition = idPosition
                            WHERE ('$newDate1' BETWEEN startDate AND finishDate)
                            AND status = 'Approved'
                            AND department_idDepartment = '$idDepartment'";
        
        $sth            = $DBH->prepare($sql);
        $sth->execute();
        while ($row     = $sth->fetch(PDO::FETCH_OBJ)):
            //Check if the Week Days is in the array, if so delete it.
            if (in_array($dayWeek, $staff_array[$row->staff_idStaff]['daysAvailable'])):
                $key = array_search($dayWeek, $staff_array[$row->staff_idStaff]['daysAvailable']);
                array_splice($staff_array[$row->staff_idStaff]['daysAvailable'], $key, 1);
            endif;
        endwhile;
    }
    
    // -------------------------------------------------------------------------------------------------------------------
    // Loop the $days_array to start doing the roster.
    foreach ($days_array as $dayWeek => $arraysDays){
        foreach ($arraysDays["employeePerHour"] as $time => $employeePerHour):
            $cont = 1;
            foreach ($staff_array as $idStaff => $arraysStaff):
                // Check if theres the specic day in the Staff_array
                if (in_array($dayWeek, $arraysStaff['daysAvailable'])):
                    // Check if the there are enough employee per Hour.
                    if($cont <= $employeePerHour[0]):
                        // Check if the worked Hours for the employee is smaller than maxHours. 
                        if($arraysStaff["workedHours"] < $arraysStaff["maxHours"]):
                            // Staff can work max of 9 hours per day. 
                            if($staff_array[$idStaff]["workedHoursSpecific"][$dayWeek] < 9):
                                // Add the staff to the array // Add 1 hour to the workedHours
                                $days_array[$dayWeek]["employeePerHour"][$time][$cont] = $arraysStaff["fullname"];
                                $staff_array[$idStaff]["workedHours"] = $staff_array[$idStaff]["workedHours"] + 1;
                                $staff_array[$idStaff]["workedHoursSpecific"][$dayWeek] = $staff_array[$idStaff]["workedHoursSpecific"][$dayWeek] + 1;
                                $cont++;
                            endif;
                        endif;
                    endif;
                endif;
            endforeach;
        endforeach;
    }

    // Add to the sessions all the arrays.
    $_SESSION['days_array']     = $days_array;
    $_SESSION['staff_array']    = $staff_array;
    $_SESSION['info_array']     = $info_array;
}

// -------------------------------------------------------------------------------------------------------------------
// If user request an ACTION
if(isset($_REQUEST['a'])){
    
    // -------------------------------------------------------------------------------------------------------------------
    // Delete
    if($_REQUEST['a'] == "d"){
        $week_day       = $_GET['wd'];
        $hour           = $_GET['h'];
        $position       = $_GET['p'];
        $totalPerHour   = $days_array[$week_day]["employeePerHour"]["$hour:00:00"][0];
        $totalElements  = (count($days_array[$week_day]["employeePerHour"]["$hour:00:00"])-1);
            
        // Subtract 1 hour from the worked Hours.
        foreach ($staff_array as $idStaff => $arraysStaff):
            if($arraysStaff["fullname"] == $days_array[$week_day]["employeePerHour"]["$hour:00:00"][$position]):
                $staff_array[$idStaff]["workedHours"] = ($staff_array[$idStaff]["workedHours"] - 1);
                $staff_array[$idStaff]["workedHoursSpecific"][$week_day] = $staff_array[$idStaff]["workedHoursSpecific"][$week_day] + 1;
                break;
            endif;
        endforeach;
        
        // If total staff per Hour is the same to the amount of positions in the array. The staff deleted will be replaced with a "ADD STAFF" text.  
        if($totalElements == $totalPerHour):
            $days_array[$week_day]["employeePerHour"]["$hour:00:00"][$position] = "ADD STAFF";
        elseif($totalElements > $totalPerHour):
            array_splice($days_array[$week_day]["employeePerHour"]["$hour:00:00"], $position, 1);
        endif;
            
        $_SESSION['days_array']     = $days_array;
        $_SESSION['staff_array']    = $staff_array;
    }
    // -------------------------------------------------------------------------------------------------------------------
    // REPLACE/SAVE Staff - Staff was deleted, so a new staff have to be added to its position.
    elseif($_REQUEST['a'] == "saveStaff"){
        $week_day           = $_POST['wd'];
        $hour               = $_POST['h'];
        $position           = $_POST['p'];
        $fullname_idStaff   = $_POST['fullname_idStaff'];
        $fullname_idStaff   = explode("|", $fullname_idStaff);
            $fullname       = $fullname_idStaff[0];
            $idStaff        = $fullname_idStaff[1];
        
        // ADD staff to the array.
        $days_array[$week_day]["employeePerHour"]["$hour:00:00"][$position] = $fullname;
        // ADD 1 hour to the the worked Hours.
        $staff_array[$idStaff]["workedHours"] = ($staff_array[$idStaff]["workedHours"] + 1);
        $staff_array[$idStaff]["workedHoursSpecific"][$week_day] = $staff_array[$idStaff]["workedHoursSpecific"][$week_day] + 1;
            
        $_SESSION['days_array']     = $days_array;
        $_SESSION['staff_array']    = $staff_array;
    }
    // -------------------------------------------------------------------------------------------------------------------
    // SAVE - Arrays will be saved in the database
    elseif($_REQUEST['a'] == "s"){
        // Array to keep the information and then use them to save in the database.     
        $staff_save_array = array();
            
        foreach ($days_array as $dayWeek => $arraysDays){
            $oT         = substr($arraysDays['openingTime'], 0, 2);
            $cT         = substr($arraysDays['closingTime'], 0, 2);
            $newDate0   = explode("/", $arraysDays["day"]);
            $newDate1   = $newDate0[2]."-".$newDate0[1]."-".$newDate0[0];
                
                // Run from the opening until the closing Time.
                for($i=$oT; $i<$cT; $i++){
                    // Add 0 on the left side of the number when its has only one character.
                    $i = str_pad($i, 2, "0", STR_PAD_LEFT);
                    for($x=1; $x<=$arraysDays['employeePerHour']["$i:00:00"][0]; $x++){
                        // Check if any of the staff on a specific hour is missing(ADD STAFF), if so the user will be asked to insert a staff for that specific time.
                        if($arraysDays['employeePerHour']["$i:00:00"][$x] == "ADD STAFF"):
                            $addStaffError = 1;
                            $addStaffErrorMessage = "<br> Add a Staff at $i:00:00 on ".$arraysDays["day"];
                            break;
                        else:
                            // Get ID from $arraysStaff
                            foreach ($staff_array as $idStaff => $arraysStaff):
                                if($arraysStaff["fullname"] == $arraysDays['employeePerHour']["$i:00:00"][$x]):
                                    $staffID = $idStaff;
                                    break;
                                endif;
                            endforeach;
                            
                            // Check if the staff is not in the $staff_save_array, if not, add it.
                            if(!array_key_exists($staffID, $staff_save_array)):
                                $staff_save_array[$staffID][$newDate1][0] = "$i:00:00";
                                $staff_save_array[$staffID][$newDate1][1] = $i.":00:00";
                                $staff_save_array[$staffID][$newDate1][2] = $arraysDays['idbusinessHours'];
                            endif;

                            // Check if the date its not in the $staff_save_array, if not, add it.
                            if(!array_key_exists($newDate1,  $staff_save_array[$staffID])):
                                $staff_save_array[$staffID][$newDate1][0] = $i.":00:00";
                                $staff_save_array[$staffID][$newDate1][1] = $i.":00:00";
                                $staff_save_array[$staffID][$newDate1][2] = $arraysDays['idbusinessHours'];
                            endif;

                            // Check if has a earlier starting hour.
                            if("$i:00:00" < $staff_save_array[$staffID][$newDate1][0]):
                                $staff_save_array[$staffID][$newDate1][0] = "$i:00:00";
                            endif;
                            
                            // Check if has a later finishing time.    
                            if("$i:00:00" >= $staff_save_array[$staffID][$newDate1][1]):
                                $staff_save_array[$staffID][$newDate1][1] = $i.":00:00";
                            endif;
                        endif;
                    }
                }
        }
        
        // IF there is no error(ADD STAFF), save in the database.
        if($addStaffError == 0){
            $sql = "";
            foreach ($staff_save_array as $idStaff => $staff_save_arrays):
                foreach($staff_save_arrays as $date => $values):
                    //New finishing Time
                    $new_hour    = date('H:i:s', strtotime($values[1].'+1 hour'));
                    $sql        .= "    INSERT INTO roster (businessHours_idBusinessHours, staff_idStaff, startingTime, finishingTime)
                                        VALUES ('$values[2]', '$idStaff', '$date $values[0]', '$date $new_hour');";
                endforeach;
            endforeach;
           
            $sth = $DBH->prepare($sql);
            if($sth->execute()):
                echo "<script>location.href = 'roster_view.php';</script>";
                die();
            else:
                echo "Error, Insert";
            endif;
        }
    } //elseif($_REQUEST['a'] == "s"){
} //if(isset($_REQUEST['a'])){
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
                                        foreach ($days_array as $key => $item):
                                            echo "<td align='center' class='calendar-day-head'>$key<br>".$item["day"]."</td>";
                                        endforeach;
                                    echo "</tr>";
        
                                    echo "<tr>";
                                        foreach ($days_array as $key => $item):
                                            echo "<td class='calendar-day-head'>".$item['openingTime']." - ".$item['closingTime']."</td>";
                                        endforeach;
                                    echo "</tr>";
                                    
                                    // Create a variable with the day of the week to show the total hours within a specific day.
                                    foreach ($days_array as $key => $item):
                                        $total = "totalHour_".$key;
                                        $$total = 0;
                                    endforeach;
                                    
                                    for($i=$info_array['min_openingTime']; $i<$info_array['max_closingTime']; $i++){
                                        $i = str_pad($i, 2, "0", STR_PAD_LEFT);
                                        
                                        echo "<tr>";
                                                echo "<td class='calendar-day-head'><a name='$i'></a> $i:00:00</td>";
                                                foreach ($days_array as $dayWeek => $arraysDays){
                                                    echo "<td align='left' valign='top' class='calendar-day'>";
                                                        if(array_key_exists("$i:00:00", $arraysDays["employeePerHour"])):
                    
                                                            for($x=1; $x<=$arraysDays["employeePerHour"]["$i:00:00"][0];$x++):
                                                                echo "$x - ";
                                                                if($arraysDays["employeePerHour"]["$i:00:00"][$x] == "ADD STAFF"):
                                                                    echo "<form method='post' action='roster_generate.php'>";
                                                                        echo "<input type='hidden' name='a' value='saveStaff'>";
                                                                        echo "<input type='hidden' name='wd' value='$dayWeek'>";
                                                                        echo "<input type='hidden' name='h' value='$i'>";
                                                                        echo "<input type='hidden' name='p' value='$x'>";
                                                                        echo "<select class='custom-select' name='fullname_idStaff' onchange='this.form.submit()'>";
                                                                        echo "<option value=''>New Staff</option>";
                                                                        foreach ($staff_array as $idStaff => $arraysStaff):
                                                                            foreach ($arraysStaff["daysAvailable"] as $key => $daysAvailable):
                                                                                if($daysAvailable == $dayWeek):
                                                                                    if (!in_array($arraysStaff["fullname"], $arraysDays["employeePerHour"]["$i:00:00"])):
                                                                                        echo "<option value='".$arraysStaff["fullname"]."|$idStaff'>".$arraysStaff["fullname"]."</option>";
                                                                                    endif;
                                                                                endif;
                                                                            endforeach;
                                                                        endforeach;
                                                                        echo "</select><br>";
                                                                    echo "</form>";
                                                                else:
                                                                    echo $arraysDays["employeePerHour"]["$i:00:00"][$x]." <a href='roster_generate.php?a=d&wd=$dayWeek&h=$i&p=$x#$i' title='Delete'>(D)</a> <br>";
                                                                endif;
                                                                // Add 1 hour to the total hour of a specific day
                                                                $total = "totalHour_".$dayWeek;
                                                                $$total = $$total + 1;
                                                            endfor;
                                                        else:
                                                            echo "&nbsp;";
                                                        endif;
                                                    echo "</td>";
                                                }
                                        echo "</tr>";
                                    }
                                    
                                    echo "<tr>";
                                        echo "<td class='calendar-day-head'>Total<br>Hour/Staff</td>";
                                        foreach ($days_array as $dayWeek => $item):
                                            echo "<td class='calendar-day' align='left' valign='top'>";
                                                foreach ($staff_array as $idStaff => $arraysStaff):
                                                    if($arraysStaff['workedHoursSpecific'][$dayWeek] > 0):
                                                        echo $arraysStaff['fullname']." - ";
                                                        echo $arraysStaff['workedHoursSpecific'][$dayWeek]."<br>";
                                                    endif;
                                                endforeach;
                                            echo "</td>";
                                        endforeach;
                                    echo "</tr>";
                                    
                                    echo "<tr>";
                                        echo "<td class='calendar-day-head'>Total<br>Hour/Day </td>";
                                        foreach ($days_array as $key => $item):
                                            $total = "totalHour_".$key;
                                            echo "<td class='calendar-day-head'>".$$total."</td>";
                                        endforeach;
                                    echo "</tr>";
                                    
                                    echo "<tr>";
                                        echo "<td colspan='8'>";
                                            echo "<br><a href='roster_generate.php?a=s'><button class='btn btn-primary'>Save</button></a><br><br>";
                                        echo "</td>";
                                    echo "</tr>";
        
                                    echo "<tr>";
                                        echo "<td colspan='8'>";
                                            echo "<table border='1' width='100%'>";
                                                echo "<tr>";
                                                    echo "<td class='calendar-day-head'>Staff</td>";
                                                    echo "<td class='calendar-day-head'>Hours Available</td>";
                                                    echo "<td class='calendar-day-head'>Hours Scheduled</td>";
                                                    echo "<td class='calendar-day-head'>Rate</td>";
                                                    echo "<td class='calendar-day-head'>Gross Pay</td>";
                                                echo "</tr>";
                                                $hoursScheduled = 0;
                                                $totalGrossPay  = 0;
                                                foreach ($staff_array as $idStaff => $arraysStaff):
                                                    $grossPay = $arraysStaff["workedHours"]*$arraysStaff["wage"];
                                                    echo "<tr>";
                                                        echo "<td class='calendar-day'>".$arraysStaff["fullname"]."</td>";
                                                        echo "<td class='calendar-day'>".$arraysStaff["maxHours"]."</td>";
                                                        echo "<td class='calendar-day'>".$arraysStaff["workedHours"]."</td>";
                                                        echo "<td class='calendar-day'>".$arraysStaff["wage"]."</td>";
                                                        echo "<td class='calendar-day'>".$grossPay."</td>";
                                                    echo "</tr>";
                                                $hoursScheduled += $arraysStaff["workedHours"];
                                                $totalGrossPay += $grossPay;
                                                endforeach;
                                                echo "<tr>";
                                                    echo "<td class='calendar-day-head'>Total</td>";
                                                    echo "<td class='calendar-day-head'>&nbsp;</td>";
                                                    echo "<td class='calendar-day-head'>$hoursScheduled</td>";
                                                    echo "<td class='calendar-day-head'>&nbsp;</td>";
                                                    echo "<td class='calendar-day-head'>$totalGrossPay</td>";
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