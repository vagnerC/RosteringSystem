<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");

// if(!isset($_SESSION['user_info'])):
//     echo "<script>location.href = 'index.php';</script>";
//     die();
// elseif($_SESSION['user_info']['position'] != "Manager"):
//     echo "<script>location.href = 'logout.php';</script>";
//     die();
// endif;

function weekNumber(){
    return (new DateTime())->format("W");
}

function weekDays($weekNumber, $format)
{
    $result     = array();
    $datetime   = new DateTime('00:00:00');
    $datetime->setISODate((int)$datetime->format('o'), $weekNumber, 1);
    $interval   = new DateInterval('P1D');
    $week       = new DatePeriod($datetime, $interval, 6);
    
    foreach($week as $day){
        $result[] = $day->format($format);
    }
    return $result;
}


if(isset($_POST['Generate'])):

    $week_number                            = $_POST['week_number'];
    
    /** Array: days_array[][]
     * Key = Day of the week.            Eg: Monday 
     * Array[0] = Day of the month.      Eg: 01/02/2018
     * Array[1] = Opening Time.          Eg: 09:00:00
     * Array[2] = Closing Time.          Eg: 22:00:00
     * Array[3] = idbusinessHours        Eg: 1 
     */
    $days_array                             = array();
    
    foreach (weekDays($week_number, "l-d/m/Y") as $days){
        $days_explode                       = explode("-", $days);
        $days_array[$days_explode[0]]       = array($days_explode[1]);
    }
    
    $min_openingTime = "22";
    $max_closingTime = "09";
    try{
        $sql                                = " SELECT *,
                                                LEFT(openingTime, 2) AS leftOT,
                                                LEFT(closingTime, 2) AS leftCT
                                                FROM businessHours";
        $sth = $DBH->prepare($sql);
        $sth->execute();
        while ($row                         = $sth->fetch(PDO::FETCH_OBJ)){
            $days_array[$row->daysOfWeek][] = $row->openingTime;
            $days_array[$row->daysOfWeek][] = $row->closingTime;
            $days_array[$row->daysOfWeek][] = $row->idbusinessHours;
            
            if($row->leftOT < $min_openingTime){
                $min_openingTime = $row->leftOT;
            }
            if($row->leftCT > $max_closingTime){
                $max_closingTime = $row->leftCT;
            }
        }
    }catch(PDOException $e) {echo $e;}
    
    echo "<table border='1'>";
       
        echo "<tr>";
            echo "<td rowspan='2'></td>";
            foreach ($days_array as $key => $item) {
                echo "<th>$key - $item[0]</th>";
            }
        echo "</tr>";
        
        
        echo "<tr>";
            foreach ($days_array as $key => $item) {
                echo "<td>$item[1] - $item[2]</td>";
            }
        echo "</tr>";
        
        for($i=$min_openingTime; $i<$max_closingTime; $i++){
            echo "<tr>";
            echo "<td> $i:00:00 </td>";
            
            foreach ($days_array as $key => $item) {
                //echo "<td>$key - $item[0]</td>";
                    
                try{
                    $sql                                = " SELECT
                                                            numberOfEmployeePerHour
                                                            FROM employeePerHour
                                                            WHERE hour = '$i:00:00'
                                                            AND businessHours_idBusinessHours = $item[3]";
                    $sth = $DBH->prepare($sql);
                    $sth->execute();
                    
                    if($sth->rowCount() > 0){
                        $row = $sth->fetch(PDO::FETCH_OBJ);
                        echo "<td>$row->numberOfEmployeePerHour</td>";
                    } else {
                        echo "<td></td>";
                    }
                    
                }catch(PDOException $e) {echo $e;}
                
                    

            }
            
            echo "</tr>";
        }
        
        
        
        
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