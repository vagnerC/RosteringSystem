<?php
session_start();
require_once("resource/database.php");

$idRequest      = $_GET['idRequest'];
$status         = $_GET['status'];

if($status == "Delete" and $idRequest != ""):
    try{
        $sql = "DELETE FROM request WHERE idRequest = ? LIMIT 1";
        
        $sth = $DBH->prepare($sql);
        
        $sth->bindParam(1, $idRequest, PDO::PARAM_INT);
        
        if($sth->execute()):
            echo "<script>location.href = 'request_view.php#$idRequest';</script>";
        else:
            echo "ERROR!";
            print_r($sth->errorInfo());
        endif;
    } catch(PDOException $e) {echo $e;}
elseif (($status == "Approved" or $status = "Disapproved") and $idRequest != ""):
    try{
        $sql = "UPDATE request SET status = ? WHERE idRequest = ? LIMIT 1;";
        
        $sth = $DBH->prepare($sql);
        
        $sth->bindParam(1, $status, PDO::PARAM_INT);
        $sth->bindParam(2, $idRequest, PDO::PARAM_INT);
        
        if($sth->execute()):
            echo "<script>location.href = 'request_view.php#$idRequest';</script>";
        else:
            echo "ERROR!";
            print_r($sth->errorInfo());
        endif;
    } catch(PDOException $e) {echo $e;}
endif;
?>