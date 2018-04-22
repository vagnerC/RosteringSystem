<?php
session_start();
require_once("resource/database.php");

if(!isset($_SESSION['user_info'])):
	echo "<script>location.href = 'index.php';</script>";
	die();
endif;

//Get POST
foreach ($_POST as $variable => $value):
	$$variable  = $value;
endforeach;

$idStaff = $_SESSION['user_info']['id'];

try{
	$sql = "SELECT idStaff FROM staff WHERE email = ? and idStaff != ?";
	$sth = $DBH->prepare($sql);
	
	$sth->bindParam(1, $email, PDO::PARAM_INT);
	$sth->bindParam(2, $idStaff, PDO::PARAM_INT);
	$sth->execute();
	
	if($sth->rowCount() > 0){
		echo "Email already in the system.";
	}
	else{
		$sql = "UPDATE staff SET email = ?, password = ?, phoneNumber = ?, nextOfKinName = ?, nextOfKinPhoneNumber = ?
                WHERE idStaff = ?
                LIMIT 1;";
		$sth = $DBH->prepare($sql);
		
		$sth->bindParam(1,  $newEmail, PDO::PARAM_INT);
		$sth->bindParam(2,  $newPassword, PDO::PARAM_INT);
		$sth->bindParam(3,  $newPphoneNumber, PDO::PARAM_INT);
		$sth->bindParam(4,  $newNextOfKinName, PDO::PARAM_INT);
		$sth->bindParam(5,  $newNextOfKinPhoneNumber, PDO::PARAM_INT);
		$sth->bindParam(6,  $idStaff, PDO::PARAM_INT);
		
		if($sth->execute()) {
			echo "ok";
		} else {
			echo "Error.";
		}
	}
	
} catch(PDOException $e) {echo $e;}
?>