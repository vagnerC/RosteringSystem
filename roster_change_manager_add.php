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

$idBusiness     = $_REQUEST['id'];
$week           = $_REQUEST['w'];

if(isset($_POST['Save'])){
    $idStaff    = $_POST['idStaff'];
    $timeFrom   = $_POST['timeFrom'].":00:00";
    $timeTo     = $_POST['timeTo'].":00:00";
    try{
        $sql = "INSERT INTO roster (businessHours_idBusinessHours, staff_idStaff, startingTime, finishingTime) VALUES (?, ?, ?, ?);";
        $sth = $DBH->prepare($sql);
        
        $sth->bindParam(1, $idBusiness, PDO::PARAM_INT);
        $sth->bindParam(2, $idStaff, PDO::PARAM_INT);
        $sth->bindParam(3, $timeFrom, PDO::PARAM_INT);
        $sth->bindParam(4, $timeTo, PDO::PARAM_INT);
        
        if($sth->execute()) {
            echo "<script>location.href = 'roster_change_manager.php?week=$week';</script>";
        } else {
            echo "Error.";
        }
    } catch(PDOException $e) {echo $e;}
}

try{
               $sql = " SELECT 
                        DATE_FORMAT(openingTime, '%d/%m/%Y %H:%i:%s') AS openingT,
                        DATE_FORMAT(closingTime, '%d/%m/%Y %H:%i:%s') AS closingT,
                        DATE_FORMAT(openingTime, '%H') AS openingH,
                        DATE_FORMAT(closingTime, '%H') AS closingH
                        FROM businessHours
                        WHERE idbusinessHours = '$idBusiness'";
               $sth = $DBH->prepare($sql);
               $sth->execute();
               $row = $sth->fetch(PDO::FETCH_OBJ);
               $openingTime = $row->openingT;
               $closingTime = $row->closingT;
               $openingHour = $row->openingH;
               $closingHour = $row->closingH;
} catch(PDOException $e) {echo $e;}
?>
<div class="container">
	<div class="row">
		<div class="col-md-10 ">
			<form class="form-horizontal" method="post" action="roster_change_manager_add.php" id="roster_change_manager_add-form">
				<input type="hidden" name="id" value="<?php echo $idBusiness;?>">
				<input type="hidden" name="w" value="<?php echo $week;?>">
				
				<fieldset>
					<legend>Add</legend>
                        
						<div class="form-group">
							<label class="col-md-4 control-label"></label>
							<div class="col-md-4">
								<div id="info"></div> 
							</div>
						</div>
                        
                        <div class="form-group">
							<label class="col-md-4 control-label" for="open">Opening Time:</label>  
    							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
     									<i class="fa fa-envelope-o"></i>
									</div>
    									<input id="open" name="open" type="text" placeholder="Open" class="form-control input-md" value="<?php echo $openingTime;?>" disabled>
								</div>
 							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-4 control-label" for="close">Closing Time:</label>  
    							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
     									<i class="fa fa-envelope-o"></i>
									</div>
    									<input id="close" name="close" type="text" placeholder="Close" class="form-control input-md" value="<?php echo $closingTime;?>" disabled>
								</div>
 							</div>
						</div>
						
                        
						<div class="form-group">
                        		<label class="col-md-4 control-label" for="idStaff">Staff:</label>  
							<div class="col-md-4">
                        			<div class="input-group">
                        				<div class="input-group-addon">
                             			<i class="fa fa-envelope-o"></i>
                        				</div>
                            			<select class="form-control" name="idStaff" id="idStaff">
                            			<option value=''></option>
        									<?php
        									try{
        									    $sql = "SELECT idStaff, CONCAT(name, ' ', surname) AS fullname FROM staff ORDER BY name, surname";
        									    $sth = $DBH->prepare($sql);
        									    $sth->execute();
        									    while ($row = $sth->fetch(PDO::FETCH_OBJ)){
        									        if($row->idStaff <> $_SESSION['user_info']['id']):
        									           echo "<option value='".$row->idStaff."'>".$row->fullname."</option>";
        									        endif;
        									    }
        									} catch(PDOException $e) {echo $e;}
        									?>
        								</select>
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
                            			<option value=''></option>
        									<?php
        									    for($i=$openingHour; $i<=$closingHour;$i++){
        									        $i = str_pad($i, 2, "0", STR_PAD_LEFT);
        									        echo "<option value='$i'>$i</option>";
        									    }
        									?>
        								</select>
        								to 
        								<select class="form-control" name="timeTo" id="timeTo">
                            			<option value=''></option>
        									<?php
        									    for($i=$openingHour; $i<=$closingHour;$i++){
        									        $i = str_pad($i, 2, "0", STR_PAD_LEFT);
        									        echo "<option value='$i'>$i</option>";
        									    }
        									?>
        								</select>
								</div>
 							</div>
						</div>


						<div class="form-group">
  							<label class="col-md-4 control-label" ></label>  
  							<div class="col-md-4">
  								<input class="btn btn-primary" type="submit" name="Save" value="Save">
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