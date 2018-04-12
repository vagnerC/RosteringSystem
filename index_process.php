<?php
session_start();
require_once("resource/database.php");

$username 	= $_POST['username'];
$password 	= $_POST['password'];

//$password 	= md5($password.'RosteringSystem2018');

try{
    $sql = "SELECT 
            idStaff,
            name,
            positionName,
            management,
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
        $nameStaff          = $rec['name'];
        $positionName       = $rec['positionName'];
        $management         = $rec['management'];
        $departmentName     = $rec['departmentName'];
        
        $user_info = array("id"=>$idStaff, "name"=>$nameStaff, "position"=>$positionName, "management"=>$management, "department"=>$departmentName);
        
        $_SESSION['user_info'] = $user_info;
    }
    else{
        echo "User or Password incorrect.";
    }
    
} catch(PDOException $e) {echo $e;}
?>