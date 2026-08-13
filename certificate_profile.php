<?php
session_start();

if(!isset($_SESSION['verifier_login'])){
    header("Location: login.php");
    exit();
}

include("db_connect.php");

$verifier_id=$_SESSION['verifier_id'];

$query="SELECT * FROM certificate_verifier WHERE verifier_id='$verifier_id'";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>My Profile</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#eef3f8;
}

.header{

background:#003366;
color:white;
padding:18px 35px;

display:flex;
justify-content:space-between;
align-items:center;

}

.header a{

color:white;
text-decoration:none;
margin-left:25px;
font-weight:bold;

}

.container{

width:500px;
margin:40px auto;

background:white;

padding:35px;

border-radius:12px;

box-shadow:0 5px 15px rgba(0,0,0,.2);

}

.container h2{

text-align:center;
margin-bottom:25px;
color:#003366;

}

table{

width:100%;

}

td{

padding:12px;

font-size:16px;

}

.label{

font-weight:bold;
width:180px;

}

.btn{

display:block;

width:100%;

margin-top:25px;

padding:12px;

background:#003366;

color:white;

text-decoration:none;

text-align:center;

border-radius:8px;

font-size:17px;

}

.btn:hover{

background:#0055aa;

}

</style>

</head>

<body>

<div class="header">

<h2>Certificate Verifier</h2>

<div>

<a href="certificate_dashboard.php">🏠 Dashboard</a>

<a href="certificate_logout.php">🚪 Logout</a>

</div>

</div>

<div class="container">

<h2>My Profile</h2>

<table>

<tr>

<td class="label">

Verifier ID

</td>

<td>

<?php echo $row['verifier_id']; ?>

</td>

</tr>

<tr>

<td class="label">

Name

</td>

<td>

<?php echo $row['name']; ?>

</td>

</tr>

<tr>

<td class="label">

Email

</td>

<td>

<?php echo $row['email']; ?>

</td>

</tr>

<tr>

<td class="label">

Password

</td>

<td>

********

</td>

</tr>

</table>

<a href="edit_certificate_profile.php" class="btn">

✏ Edit Profile

</a>

</div>

</body>
</html>