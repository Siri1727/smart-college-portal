<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role']!="faculty"){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>Faculty Dashboard | Smart College Portal</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
margin:0;
font-family:Arial, Helvetica, sans-serif;
background:url('images/dashboard_image.jpeg') no-repeat center center fixed;
background-size:cover;
min-height:100vh;
}

/* TOP BAR */

.topbar{
background:#003366;
color:white;
padding:15px 30px;
display:flex;
justify-content:space-between;
align-items:center;
}

.topbar h2{
margin:0;
}

/* PROFILE */

.profile{
position:relative;
cursor:pointer;
}

.profile i{
font-size:28px;
}

.dropdown{
display:none;
position:absolute;
right:0;
top:40px;
background:white;
border-radius:8px;
box-shadow:0 5px 15px rgba(0,0,0,.2);
overflow:hidden;
min-width:150px;
}

.dropdown a{
display:block;
padding:12px;
text-decoration:none;
color:black;
}

.dropdown a:hover{
background:#f2f2f2;
}

/* DASHBOARD */

.dashboard{

display:flex;
justify-content:center;
flex-wrap:wrap;
gap:35px;
margin-top:90px;

}

.card{

width:250px;
background:white;
padding:30px;
border-radius:12px;
text-align:center;
box-shadow:0 10px 20px rgba(0,0,0,.15);
cursor:pointer;
transition:.3s;

}

.card:hover{

transform:translateY(-8px);

}

.icon{

font-size:50px;
color:#2c7be5;
margin-bottom:15px;

}

.card h3{

margin-bottom:10px;

}

.card p{

color:gray;
font-size:14px;

}

</style>

<script>

function toggleMenu(){

var menu=document.getElementById("menu");

if(menu.style.display=="block")
menu.style.display="none";
else
menu.style.display="block";

}

</script>

</head>

<body>

<div class="topbar">

<h2>Smart College Portal | Faculty Dashboard</h2>

<div class="profile" onclick="toggleMenu()">

<i class="fa-solid fa-user-circle"></i>

<div class="dropdown" id="menu">

<a href="faculty_profile.php">Profile</a>

<a href="logout.php">Logout</a>

</div>

</div>

</div>

<!-- DASHBOARD -->

<div class="dashboard">

<!-- Attendance -->

<div class="card" onclick="location.href='mark_attendance.php'">

<i class="fas fa-user-check icon"></i>

<h3>Mark Attendance</h3>

<p>Give attendance to students</p>

</div>



<!-- Post Notice -->

<div class="card" onclick="location.href='post_notice.php'">

<i class="fas fa-bullhorn icon"></i>

<h3>Post Notice</h3>

<p>Post timetables and academic notices</p>

</div>

<!-- Notice History -->

<div class="card" onclick="location.href='faculty_notice_history.php'">

<i class="fas fa-history icon"></i>

<h3>Notice History</h3>

<p>View, Edit & Delete posted notices</p>

</div>

</div>

</body>
</html>