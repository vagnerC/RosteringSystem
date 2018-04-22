<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");

$idDepartment = $_SESSION['user_info']['idDepartment'];

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
elseif($_SESSION['user_info']['management'] != "true"):
    echo "<script>location.href = 'logout.php';</script>";
    die();
endif;

//Function to show the current week
function weekNumber(){
    return (new DateTime())->format("W");
}

if(isset($_POST['Generate'])):

    // Week number chose by the user.
    $week_number        = $_POST['week_number'];

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
    //Variables to show on the table the minimum and maximum hours of the week.
    $min_openingTime = "22";
    $max_closingTime = "09";
    //Array that contains staff informations.
    $staff_array         = array();
    
    try{
        $sql            = " SELECT
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
                            WHERE week = '$week_number'
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
            endif;
            
            //Add a new array at the position 3 with the number of employee required per hour.
            $days_array[$row->weekDay]["employeePerHour"][$row->hour][0] = $row->numberOfEmployeePerHour;
            for($i=1; $i<=$row->numberOfEmployeePerHour;$i++){
                $days_array[$row->weekDay]["employeePerHour"][$row->hour][$i] = "ADD STAFF";
            }
            
            
            //Check the earliest time the shop opens.
            if($row->hourOpeningTime < $min_openingTime):
                $min_openingTime = $row->hourOpeningTime;
            endif;
            
            //Check the latest time the shop closes.
            if($row->hourClosingTime > $max_closingTime):
                $max_closingTime = $row->hourClosingTime;
            endif;
            
        endwhile;
    
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
   
    
    echo "<hr>";
    print_r($staff_array);
    echo "<hr>";
    
    
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
    
    echo "<hr>";
    print_r($days_array);
    echo "<hr>";
    print_r($staff_array);
    echo "<hr>";
//     echo "<hr>";
    //$ePH = array_column($days_array, 'employeePerHour');
    //print_r($first_names);
    
    
    echo "<table border='1'>";
       
        echo "<tr>";
            echo "<td rowspan='2'></td>";
            foreach ($days_array as $key => $item){
                echo "<th>$key - ".$item["day"]."</th>";
            }
        echo "</tr>";
        
        echo "<tr>";
            foreach ($days_array as $key => $item) {
                echo "<td>".$item['openingTime']." - ".$item['closingTime']."</td>";
            }
        echo "</tr>";
        
        for($i=$min_openingTime; $i<$max_closingTime; $i++){
            echo "<tr>";
            echo "<td> $i:00:00 </td>";
            
            foreach ($days_array as $dayWeek => $arraysDays){
                echo "<td>";
                    
                    if(array_key_exists("$i:00:00", $arraysDays["employeePerHour"])):
                    
                        for($x=1; $x<=$arraysDays["employeePerHour"]["$i:00:00"][0];$x++){
                            echo $arraysDays["employeePerHour"]["$i:00:00"][$x]."<br>";
                        }
                        
                    else:
                        echo "&nbsp;";
                    endif;
                echo "</td>";
            }
            echo "</tr>";
        }
        
        echo "<tr>";
        foreach ($days_array as $dayWeek => $arraysDays){
            echo "<td>";
            foreach ($staff_array as $idStaff => $arraysStaff){
                if (in_array($dayWeek, $arraysStaff['daysAvailable'])) {
                    
                    echo $arraysStaff["fullname"]." = ".$arraysStaff["workedHours"]."<br>";
                    
                }
                else{
                    echo "&nbsp;";
                }
            }
            echo "</td>";
        }
        echo "</tr>";

    echo "</table>";
endif;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
.calendarClass {
    display: block;
    margin-left: auto;
    margin-right: auto;
    padding: 2%;
    width: 90%;
 </style>

<div class="panel-group">
    <div class="panel panel-primary">
        <div class="panel-body">
             
            <div class="bs-calltoaction bs-calltoaction-default">
                <div class="row">
					<div class="col" style="text-align: right">
						<form action='roster_generate.php' method='post' id='roster_generate-form' name='roster_generate-form'>
						<select name ='week_number' class="input-xlarge" width="50%" id="sel1">
						<?php 
						for ($i=weekNumber(); $i<(weekNumber()+4);$i++):
						      echo "<option value='$i'> Week $i</option>";
						  endfor;
						?>
						</select>
						
					</div>
				<div class="col" style="text-align: left">
				<input class="btn btn-primary" type="submit" value="Generate" name='Generate'>
				</div>
					</form>
               	</div>
				<div class="calendarClass">
					<?php 
					
					?>
				</div>	        
			</div>		
		</div>		     
	</div>
</div>
			

<?php 
require_once("template/footer.php");
?>