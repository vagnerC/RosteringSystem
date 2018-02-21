<?php
if(isset($_POST['Send'])){
     
    $monday = $_POST['monday'];
    $tuesday = $_POST['tuesday'];
} else {
    $monday = "";
    $tuesday = "";
}


echo "<form method='post' action='teste.php'>";
echo "Monday: <input type='text' name='monday' value='$monday'>";
echo "<br>Tuesday: <input type='text' name='tuesday' value='$tuesday'>";
echo "<br><input type='submit' name='Send' value='Send'>";
echo "</form>";


if(isset($_POST['Send'])){
    
    echo "<br>MONDAY";
    for($i=0; $i<$monday;$i++){
        $value = $i+1;
        echo "<br><input type='text' name='monday_time$i' value='$value'>";
    }
    
    echo "<br>TUESDAY";
    for($i=0; $i<$tuesday;$i++){
        $value = $i+1;
        echo "<br><input type='text' name='tueday_time$i' value='$value'>";
    }
    
}

?>

