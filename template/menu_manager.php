
<div class="topnav" id="myTopnav">
                <a href="home.php" class="active">Home</a>
                <div class="dropdown">
                  <button class="dropbtn">Staff
                    <i class="fa fa-caret-down"></i>
                  </button>
                  <div class="dropdown-content">
                    <a href="staff_add.php">Add</a>
                    <a href="staff_view.php">View</a>
                  </div>
                </div>
                <div class="dropdown">
                  <button class="dropbtn">Day Off/Holidays
                    <i class="fa fa-caret-down"></i>
                  </button>
                  <div class="dropdown-content">
                    <a href="request_add.php">Request</a>
                    <a href="request_view.php">View</a>
                  </div>
                </div>
                <div class="dropdown">
                  <button class="dropbtn">Roster
                    <i class="fa fa-caret-down"></i>
                  </button>
                  <div class="dropdown-content">
                    <a href="roster_generate.php">Generate</a>
                    <a href="roster_view.php">View</a>
                  </div>
                </div>
                <div class="dropdown">
                  <button class="dropbtn">Message
                    <i class="fa fa-caret-down"></i>
                  </button>
                  <div class="dropdown-content">
                    <a href="message_add.php">New</a>
                    <a href="message_archive.php">Inbox</a>
                  </div>
                </div>
                <a href="logout.php">Log out</a>
                <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
 </div>
            
               
       
<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
</script>