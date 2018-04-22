<?php
session_start();
require_once("resource/database.php");

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
endif;

foreach ($_REQUEST as $variable => $value):
    $$variable  = $value;
endforeach;

if($action == "delete"):
    try{
        $sql = "UPDATE message SET showFrom = 'No' WHERE idMessage = ? LIMIT 1;";
        
        $sth = $DBH->prepare($sql);
        
        $sth->bindParam(1, $idMessage, PDO::PARAM_INT);
        
        if($sth->execute()):
            echo "<script>location.href = 'message_archive_sent.php';</script>";
            die();
        else:
        echo "ERROR!";
        print_r($sth->errorInfo());
        endif;
    } catch(PDOException $e) {echo $e;}
endif;
?>