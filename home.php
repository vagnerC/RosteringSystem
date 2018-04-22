<?php
session_start();
require_once("template/header.php");
require_once("resource/database.php");
require_once("calendar.php");

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
endif;
$idStaff = $_SESSION['user_info']['id'];
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
.calendarClass {
    display: block;
    margin-left: auto;
    margin-right: auto;
    padding: 2%;
    width: 90%;
 </style>

	<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading">Welcome <?php echo $_SESSION['user_info']['name'];?></div>
            	<div class="panel-body">
                	<?php 
                	if($_SESSION['user_info']['management'] == "true"):
                    	try{
                    	    $sql = "   SELECT
                    	               typeRequest,
                    	               COUNT(*) AS total
                    	               FROM request
                    	               WHERE status = 'Pending'
                    	               GROUP BY (typeRequest)";
                    	    $sth = $DBH->prepare($sql);
                    	    $sth->execute();
                    	    while ($row = $sth->fetch(PDO::FETCH_OBJ)){
                    	        echo "<div class='alert alert-warning'>";
                    	        echo "<a href='request_view.php?t=$row->typeRequest' class='close'>Go</a>";
                    	        echo "<strong>$row->total</strong> $row->typeRequest request to be approved/disapproved.";
                    	        echo "</div>";
                    	    }
                    	} catch(PDOException $e) {echo $e;}
                else:
                    try{
                        $sql = "  SELECT
                                  idStaff
                                  FROM staff
                                  WHERE password = '12345'
                                  AND idStaff = '$idStaff'";
                        $sth = $DBH->prepare($sql);
                        $sth->execute();
                        $row = $sth->fetch(PDO::FETCH_OBJ);
                        if($sth->rowCount() > 0):
                        echo "<div class='alert alert-warning'>";
                            echo "<a href='my_profile.php' class='close'>Go</a>";
                            echo "<strong>Please change your password.</strong>";
                        echo "</div>";
                        endif;
                    } catch(PDOException $e) {echo $e;}
                	endif;
                	
                	try{
                	    $sql = "   SELECT
                                COUNT(*) total
                                FROM message
                                WHERE staffTo = '$idStaff'
                                and status = 'Not Read'
                                AND showTo = 'Yes'";
                	    $sth = $DBH->prepare($sql);
                	    $sth->execute();
                    $row = $sth->fetch(PDO::FETCH_OBJ);
                        if($row->total > 0):
                	        echo "<div class='alert alert-warning'>";
                	        echo "<a href='message_archive.php' class='close'>Go</a>";
                	        echo "<strong>$row->total</strong> unread messages.";
                	        echo "</div>";
                	    endif;
                	} catch(PDOException $e) {echo $e;}
                	?>
		</div>				
	</div>			

	<div class="">
	<div class="calendarClass">
	<?php 
		echo draw_calendar(date('m'), date('Y'));
	?>
	</div>
	</div>

<?php 
require_once("template/footer.php");
?>