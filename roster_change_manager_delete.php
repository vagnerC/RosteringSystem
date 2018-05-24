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

$idRoster       = $_GET['id'];
$week           = $_GET['w'];


if($idRoster != "" and $week != ""){
        try{
            $sql = "DELETE FROM roster WHERE idRoster = ? LIMIT 1";
            $sth = $DBH->prepare($sql);
            $sth->bindParam(1, $idRoster, PDO::PARAM_INT);
            if($sth->execute()):
                echo "<script>location.href = 'roster_change_manager.php?week=$week';</script>";
            else:
                echo "ERROR!";
                print_r($sth->errorInfo());
            endif;
        } catch(PDOException $e) {echo $e;}
}
?>