<?php
session_start();
require_once("resource/database.php");

$type               = $_POST['type'];
$from               = $_POST['from'];
    $from_array     = explode("/", $from);
    $from_new       = $from_array[2]."-".$from_array[1]."-".$from_array[0];
$to                 = $_POST['to'];
    $to_array       = explode("/", $to);
    $to_new         = $to_array[2]."-".$to_array[1]."-".$to_array[0];
$idStaff            = $_POST['idStaff'];

try{
    $sql = "INSERT INTO request (typeRequest, startDate, finishDate, status, staff_idStaff) VALUES (?, ?, ?, 'Pending', ?);";
    $sth = $DBH->prepare($sql);
    
    $sth->bindParam(1, $type, PDO::PARAM_INT);
    $sth->bindParam(2, $from_new, PDO::PARAM_INT);
    $sth->bindParam(3, $to_new, PDO::PARAM_INT);
    $sth->bindParam(4, $idStaff, PDO::PARAM_INT);
    
    if($sth->execute()) {
        echo "ok";
    } else {
        echo "Error.";
    }
} catch(PDOException $e) {echo $e;}
?>