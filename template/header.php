<!DOCTYPE HTML>
<html>
    <head>
       <meta charset="utf-8" />
        <title>Rostering System</title>
        <link rel="stylesheet" type="text/css" href="library/bootstrap.min.css">
              <link rel="icon" href="image/layout/favicon.ico">
              <link rel="stylesheet" type="text/css" href="css/general.css">
              <script type="text/javascript" src="library/jquery-3.3.1.min.js"></script>
              <script type="text/javascript" src="library/validation.min.js"></script>
              <script type="text/javascript" src="library/bootstrap.min.js"></script>
              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
              
              
       </head>
<body class="background">
   
       <header class="header">
              <h1>Rostering<span>System</h1>
       </header>
  <div class="container1">
		<?php 
		if(isset($_SESSION['user_info'])):
            if($_SESSION['user_info']['position'] == "Manager"):
             include (TEMPLATE_PATH . "/menu_manager.php");
		
                include (TEMPLATE_PATH . "/menu_staff.php");
            endif;
        endif;
        ?> 
       </div>
              <div class="boxmain">
              
