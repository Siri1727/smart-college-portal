<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

if(
    !isset($_SESSION['verifier_login']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role']!="certificate verifier"
){
    header("Location: certificate_login.php");
    exit();
}

include("db_connect.php");

$verifier_name = $_SESSION['verifier_name'];

$total = 0;
$pending = 0;
$verified = 0;

/* Total Certificates */

$sql = "SELECT COUNT(*) AS total FROM achievements";
$result = mysqli_query($conn,$sql);

if(!$result){
    die("Database Error : ".mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$total = $row['total'];

/* Pending */

$sql = "SELECT COUNT(*) AS total FROM achievements WHERE verified='Pending'";
$result = mysqli_query($conn,$sql);

if(!$result){
    die("Database Error : ".mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$pending = $row['total'];

/* Verified */

$sql = "SELECT COUNT(*) AS total FROM achievements WHERE verified='Verified'";
$result = mysqli_query($conn,$sql);

if(!$result){
    die("Database Error : ".mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$verified = $row['total'];

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

.welcome{
text-align:center;
padding:40px;
color:white;
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
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,.2);
text-align:center;
}

.card h3{
margin-bottom:15px;
color:#003366;
}

.card h1{
font-size:40px;
}

.menu{
width:90%;
margin:50px auto;
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
}

.menu a{
text-decoration:none;
background:#003366;
color:white;
padding:18px;
text-align:center;
border-radius:8px;
font-weight:bold;
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

<h3>Certificate Verifier</h3>

</div>

<div class="welcome">

<h1>Welcome, <?php echo $verifier_name; ?></h1>

<p>Certificate Verification Dashboard</p>

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

<a href="verify_certificates.php">📜 Verify Certificates</a>

<a href="certificate_profile.php">👤 My Profile</a>

<a href="certificate_logout.php">🚪 Logout</a>

</div>

</div>

</body>

</html>