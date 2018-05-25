<?php
session_start();
require_once("template/header.php");

if(!isset($_SESSION['user_info'])):
    echo "<script>location.href = 'index.php';</script>";
    die();
endif;
?>
	<div class="panel-group">
    	<div class="panel panel-default">
        	<div class="panel-heading">Staff</div>
            	<div class="panel-body">
                	<?php 
                	
                    	        echo "<div class='alert alert-warning'>";
                    	        echo "<a href='staff_add.php' class='close'>Go</a>";
                    	        echo "<strong>Add Staff.</strong>";
                    	        echo "</div>"; 

                	?>
		</div>				
	</div>	
	</div>
			


<?php 
require_once("template/footer.php");
?>