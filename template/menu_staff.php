<div class="topnav" id="myTopnav">
                <a href="home.php" class="active">Home</a>
                <a href="my_profile.php">My Profile</a>
                <div class="dropdown">
                  <button class="dropbtn">Day Off / Holidays
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
                    <a href="roster_view.php">View</a>
                    <a href="roster_change.php">Change</a>
                  </div>
                </div>
                
                <div class="dropdown">
                  <button class="dropbtn">Message
                    <i class="fa fa-caret-down"></i>
                  </button>
                  <div class="dropdown-content">
                    <a href="message_add.php">New</a>
                    <a href="message_archive.php">Inbox</a>
                    <a href="message_archive_sent.php">Sent</a>
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