<!DOCTYPE html>
<html>
<head>
<title> Drop down navigation bar and menu</title>
<style>
body{
margin:0;
background: #f2f2f2f;
}
.nav{
width:100%;
background:#000033;
height:80px;
}
ul{
list-style:none;
padding:0;
margin:0;
position:absolute;
}
ul li {
float:left;
margin-top:20px;
}
ul li a{
width:150px;
color:white;
display:block;
text-decoration:none;
font-size:20px;
text-align:center;
padding:10px;
border-raidus:10px;
font-family:Century Gothic;
font-weight:bold;
}
a:hover{
background:#669900;
}
ul li ul {
background:#000033;
}
ul li ul li{
float:none;
}
ul li ul{
display:none;
}
ul li:hover ul {
display:block;
}
</style>
</head>
<body>
<div class ="nav">
<ul>
<li><a href ="#"> Home</a></li>
<li><a href ="#"> Requests</a></li>
<li><a href ="#"> Messages</a></li>
<li><a href ="#"> Roster</a></li>
<li><a href ="#"> Payments</a>
<ul>
<li><a href ="#"> more 1</a></li>
<li><a href ="#"> more 2</a></li>
<li><a href ="#"> more 3</a></li>
<li><a href ="#"> more 4</a></li>
<li><a href ="#"> More 5</a>


</ul>
</li>
<li><a href ="#"> Settings</a></li>
<li><a href ="#"> Sign Out</a></li>
</ul>
</div>
</body>
</html>