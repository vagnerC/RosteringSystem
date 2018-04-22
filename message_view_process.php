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

if($action == "insert"):
  
    try{
            $sql = "INSERT INTO message (staffFrom, staffTo, subject, message)
                    SELECT staffTo, staffFrom, subject, ? FROM message WHERE idMessage = ?";
            $sth = $DBH->prepare($sql);
            
            $sth->bindParam(1,  $message, PDO::PARAM_INT);
            $sth->bindParam(2,  $idMessage, PDO::PARAM_INT);
            
            if($sth->execute()) {
                echo "ok";
            } else {
                echo "Error.";
            }
    } catch(PDOException $e) {echo $e;}
    
elseif($action == "delete"):
    try{
        $sql = "UPDATE message SET showTo = 'No' WHERE idMessage = ? LIMIT 1;";
        
        $sth = $DBH->prepare($sql);
        
        $sth->bindParam(1, $idMessage, PDO::PARAM_INT);
        
        if($sth->execute()):
            echo "<script>location.href = 'message_archive.php';</script>";
            die();
        else:
        echo "ERROR!";
        print_r($sth->errorInfo());
        endif;
    } catch(PDOException $e) {echo $e;}
endif;
?>