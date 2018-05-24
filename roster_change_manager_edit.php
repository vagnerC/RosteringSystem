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

$idRoster       = $_REQUEST['id'];
$week           = $_REQUEST['w'];

if(isset($_POST['Update'])){
    $timeFrom   = $_POST['timeFrom'].":00:00";
    $timeTo     = $_POST['timeTo'].":00:00";
    try{
        $sql = "UPDATE roster SET startingTime = '$timeFrom', finishingTime = '$timeTo'
                WHERE idRoster = '$idRoster'
                LIMIT 1;";
        $sth = $DBH->prepare($sql);
        if($sth->execute()) {
            echo "<script>location.href = 'roster_change_manager.php?week=$week';</script>";
        } else {
            echo "Error.";
        }
        
    } catch(PDOException $e) {echo $e;}
}

try{
               $sql = " SELECT
                        CONCAT(name,' ', surname) AS fullName,
                        DATE_FORMAT(startingTime, '%H') AS startingT,
                        DATE_FORMAT(finishingTime, '%H') AS finishingT
                        FROM roster
                        INNER JOIN staff ON staff_idStaff = idStaff
                        WHERE idRoster = '$idRoster'";
               $sth = $DBH->prepare($sql);
               $sth->execute();
               $row = $sth->fetch(PDO::FETCH_OBJ);
               $fullName = $row->fullName;
               $startingT = str_pad($row->startingT, 2, "0", STR_PAD_LEFT);
               $finishingT = str_pad($row->finishingT, 2, "0", STR_PAD_LEFT);
} catch(PDOException $e) {echo $e;}
?>
<div class="container">
	<div class="row">
		<div class="col-md-10 ">
			<form class="form-horizontal" method="post" action="roster_change_manager_edit.php" id="roster_change_manager_edit-form">
				<input type="hidden" name="id" value="<?php echo $idRoster;?>">
				<input type="hidden" name="w" value="<?php echo $week;?>">
				
				<fieldset>
					<legend>Edit</legend>
                        
						<div class="form-group">
							<label class="col-md-4 control-label"></label>
							<div class="col-md-4">
								<div id="info"></div> 
							</div>
						</div>
                        
                        <div class="form-group">
							<label class="col-md-4 control-label" for="open">Staff:</label>  
    							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
     									<i class="fa fa-envelope-o"></i>
									</div>
    									<input id="open" name="open" type="text" placeholder="Open" class="form-control input-md" value="<?php echo $fullName;?>" disabled>
								</div>
 							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="from">Time:</label>  
    							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
     									<i class="fa fa-envelope-o"></i>
									</div>
    									<select class="form-control" name="timeFrom" id="timeFrom">
        									<?php
        									    for($i=06; $i<=23;$i++){
        									        $i = str_pad($i, 2, "0", STR_PAD_LEFT);
        									        if($i == $startingT){
        									           echo "<option value='$i' selected>$i</option>";
        									        } else{
        									            echo "<option value='$i'>$i</option>";
        									        }
        									    }
        									?>
        								</select>
        								to 
        								<select class="form-control" name="timeTo" id="timeTo">
        									<?php
        									   for($i=06; $i<=23;$i++){
        									        $i = str_pad($i, 2, "0", STR_PAD_LEFT);
        									        if($i == $finishingT){
        									           echo "<option value='$i' selected>$i</option>";
        									        } else {
        									            echo "<option value='$i'>$i</option>";
        									        }
        									    }
        									?>
        								</select>
								</div>
 							</div>
						</div>


						<div class="form-group">
  							<label class="col-md-4 control-label" ></label>  
  							<div class="col-md-4">
  								<input class="btn btn-primary" type="submit" name="Update" value="Update">
  							</div>
						</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<!-- Bootstrap Core CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
<?php 
require_once("template/footer.php");
?>