<?php
session_start();

if(
    !isset($_SESSION['verifier_login']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != "certificate verifier"
){
    header("Location: login.php");
    exit();
}

include("db_connect.php");

$verifier_name = $_SESSION['verifier_name'];

$total = 0;
$pending = 0;
$verified = 0;

$result = mysqli_query($conn,"SELECT COUNT(*) AS total FROM achievements");
if($result){
    $row = mysqli_fetch_assoc($result);
    $total = $row['total'];
}

$result = mysqli_query($conn,"SELECT COUNT(*) AS total FROM achievements WHERE verified='Pending'");
if($result){
    $row = mysqli_fetch_assoc($result);
    $pending = $row['total'];
}

$result = mysqli_query($conn,"SELECT COUNT(*) AS total FROM achievements WHERE verified='Verified'");
if($result){
    $row = mysqli_fetch_assoc($result);
    $verified = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Certificate Verifier Dashboard</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:url('images/dashboard_image.jpeg') no-repeat center center/cover;
min-height:100vh;
}

.overlay{
background:rgba(0,0,0,.35);
min-height:100vh;
}

.header{
background:#003366;
color:white;
padding:18px 35px;
display:flex;
justify-content:space-between;
align-items:center;
}

.header h2{
margin:0;
}

.header-right{
display:flex;
align-items:center;
gap:25px;
}

.header-right a{
color:white;
text-decoration:none;
font-weight:bold;
}

.welcome{
text-align:center;
padding:35px;
color:white;
}

.welcome h1{
font-size:38px;
margin-bottom:10px;
}

.cards{
width:90%;
margin:auto;
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:25px;
}

.card{
background:white;
padding:30px;
border-radius:12px;
text-align:center;
box-shadow:0 8px 20px rgba(0,0,0,.2);
}

.card h3{
color:#003366;
margin-bottom:15px;
}

.card h1{
font-size:45px;
}

.menu{
width:50%;
margin:50px auto;
}

.menu a{
display:block;
text-decoration:none;
background:#003366;
color:white;
padding:18px;
text-align:center;
border-radius:10px;
font-size:20px;
font-weight:bold;
transition:.3s;
}

.menu a:hover{
background:#0055aa;
}

</style>

</head>

<body>

<div class="overlay">

<div class="header">

<h2>Smart College Portal</h2>

<div class="header-right">

<span>
Welcome, <b><?php echo $verifier_name; ?></b>
</span>

<a href="certificate_profile.php">
👤 My Profile
</a>

<a href="certificate_logout.php">
🚪 Logout
</a>

</div>

</div>

<div class="welcome">

<h1>Certificate Verification Dashboard</h1>

<p>Verify students' uploaded certificates.</p>

</div>

<div class="cards">

<div class="card">
<h3>Total Certificates</h3>
<h1><?php echo $total; ?></h1>
</div>

<div class="card">
<h3>Pending Certificates</h3>
<h1 style="color:orange;"><?php echo $pending; ?></h1>
</div>

<div class="card">
<h3>Verified Certificates</h3>
<h1 style="color:green;"><?php echo $verified; ?></h1>
</div>

</div>

<div class="menu">

<a href="verify_certificates.php">
📜 Verify Certificates
</a>

</div>

</div>

</body>
</html>