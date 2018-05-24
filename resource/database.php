<?php
//include_once "https://rosteringsystem.000webhostapp.com/resource/database.php";
//mysql://:@/?reconnect=true

try {
    $host = 'eu-cdbr-west-02.cleardb.net';
    $dbname = 'heroku_6feec79dd608290';
    $user = 'b81b632e126f92';
    $pass = '02e469a3';
    
    # MySQL with PDO_MYSQL
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
} catch(PDOException $e) {echo $e;}
?>