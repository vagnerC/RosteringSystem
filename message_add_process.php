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

$idStaffFrom = $_SESSION['user_info']['id'];

try{
        $sql = "INSERT INTO message (staffFrom, staffTo, subject, message)
                VALUES (?, ?, ?, ?);";
        $sth = $DBH->prepare($sql);
        
        $sth->bindParam(1,  $idStaffFrom, PDO::PARAM_INT);
        $sth->bindParam(2,  $idStaff, PDO::PARAM_INT);
        $sth->bindParam(3,  $subject, PDO::PARAM_INT);
        $sth->bindParam(4,  $message, PDO::PARAM_INT);
        
        if($sth->execute()) {
            echo "ok";
        } else {
            echo "Error.";
        }
} catch(PDOException $e) {echo $e;}
?>