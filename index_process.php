<?php
session_start();
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . "/RosteringSystem/resource/config.php");
require_once(RESOURCE_PATH . "/database.php");

$username 	= $_POST['username'];
$password 	= $_POST['password'];

//$password 	= md5($password.'RosteringSystem2018');

try{
    $sql = "SELECT 
            idStaff,
            nameStaff,
            positionName,
            departmentName
            FROM staff 
            INNER JOIN position ON position_idPosition = idPosition
            INNER JOIN department ON department_idDepartment = idDepartment            
            WHERE email = ? 
            AND password = ?";
    $sth = $DBH->prepare($sql);
    
    $sth->bindParam(1, $username, PDO::PARAM_INT);
    $sth->bindParam(2, $password, PDO::PARAM_INT);
    
    $sth->execute();
    
    if($sth->rowCount() > 0){
        echo "ok";
        
        $rec = $sth->fetch(PDO::FETCH_ASSOC);
        $idStaff            = $rec['idStaff'];
        $nameStaff          = $rec['nameStaff'];
        $positionName       = $rec['positionName'];
        $departmentName     = $rec['departmentName'];
        
        $user_info = array("id"=>$idStaff, "name"=>$nameStaff, "position"=>$positionName, "department"=>$departmentName);
        
        $_SESSION['user_info'] = $user_info;
    }
    else{
        echo "User or Password incorrect.";
    }
    
} catch(PDOException $e) {echo $e;}
?>