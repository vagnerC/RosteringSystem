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

$idStaff       = $_GET['idStaff'];

if($idStaff != ""){
    try{
        $sql = "DELETE FROM staff WHERE idStaff = ? LIMIT 1";
        $sth = $DBH->prepare($sql);
        $sth->bindParam(1, $idStaff, PDO::PARAM_INT);
        if($sth->execute()):
            echo "<script>location.href = 'staff_view.php';</script>";
        else:
        //echo "ERROR!";
        //print_r($sth->errorInfo());
            echo "<script>location.href = 'staff_view.php';</script>";
        endif;
    } catch(PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            echo "<br>ERROSSSSSS";
        }
    }
}
?>