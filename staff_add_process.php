<?php
session_start();
require_once("resource/database.php");

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
elseif($_SESSION['user_info']['position'] != "Manager"):
    echo "<script>location.href = 'logout.php';</script>";
    die();
endif;

//Get POST
foreach ($_POST as $variable => $value):
    $$variable  = $value;
endforeach;

//Get Days Available
$dA = "";
foreach ($daysAvailable as $days){
    $dA .= $days." ";
}

//Format dateOfBirth
$dobArray       = explode("/", $dateOfBirth);
$dateOfBirth    = $dobArray[2]."-".$dobArray[1]."-".$dobArray[0];
$password       = "12345";

try{
    $sql = "SELECT idStaff FROM staff WHERE email = ?";
    $sth = $DBH->prepare($sql);
    
    $sth->bindParam(1, $email, PDO::PARAM_INT);
    $sth->execute();
    
    if($sth->rowCount() > 0){
        echo "Email already in the system.";
    }
    else{
        $sql = "INSERT INTO staff (name, surname, dateOfBirth, email, password, phoneNumber, nextOfKinName, nextOfKinPhoneNumber, minHours, maxHours, daysAvailable, position_idPosition) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $sth = $DBH->prepare($sql);
        
        $sth->bindParam(1,  $name, PDO::PARAM_INT);
        $sth->bindParam(2,  $surname, PDO::PARAM_INT);
        $sth->bindParam(3,  $dateOfBirth, PDO::PARAM_INT);
        $sth->bindParam(4,  $email, PDO::PARAM_INT);
        $sth->bindParam(5,  $password, PDO::PARAM_INT);
        $sth->bindParam(6,  $phoneNumber, PDO::PARAM_INT);
        $sth->bindParam(7,  $nextOfKinName, PDO::PARAM_INT);
        $sth->bindParam(8,  $nextOfKinPhoneNumber, PDO::PARAM_INT);
        $sth->bindParam(9,  $minHours, PDO::PARAM_INT);
        $sth->bindParam(10, $maxHours, PDO::PARAM_INT);
        $sth->bindParam(11, $dA, PDO::PARAM_INT);
        $sth->bindParam(12, $position_idPosition, PDO::PARAM_INT);
        
        if($sth->execute()) {
            echo "ok";
        } else {
            echo "Error.";
        }
    }
    
} catch(PDOException $e) {echo $e;}
?>