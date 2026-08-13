<?php
session_start();

if(!isset($_SESSION['verifier_login'])){
    header("Location: login.php");
    exit();
}

include("db_connect.php");

$query = "SELECT * FROM achievements WHERE 1";

if(!empty($_GET['type'])){
    $type = mysqli_real_escape_string($conn,$_GET['type']);
    $query .= " AND achievement_type='$type'";
}

if(!empty($_GET['from_date'])){
    $from = $_GET['from_date'];
    $query .= " AND achievement_date >= '$from'";
}

if(!empty($_GET['to_date'])){
    $to = $_GET['to_date'];
    $query .= " AND achievement_date <= '$to'";
}

$query .= " ORDER BY achievement_date DESC,id DESC";

$result = mysqli_query($conn,$query);

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Verify Certificates</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#eef2f7;
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

width:95%;
margin:30px auto;

background:white;

padding:25px;

border-radius:10px;

box-shadow:0 5px 15px rgba(0,0,0,.15);

}

h2{

text-align:center;
margin-bottom:25px;
color:#003366;

}

table{

width:100%;
border-collapse:collapse;

}

th{

background:#003366;

color:white;

padding:12px;

}

td{

padding:12px;

border-bottom:1px solid #ddd;

text-align:center;

}

img{

width:90px;
height:90px;
object-fit:cover;
border-radius:8px;

}

.download{

background:#28a745;
color:white;
padding:8px 14px;
border-radius:6px;
text-decoration:none;

}

.verify{

background:#007bff;
color:white;
padding:8px 14px;
border-radius:6px;
text-decoration:none;

}

.verified{

background:green;
color:white;
padding:8px 14px;
border-radius:6px;
font-weight:bold;

}

.back{

background:#555;
padding:10px 18px;
border-radius:6px;
color:white;
text-decoration:none;

}

</style>

</head>

<body>

<div class="header">

<h2>Certificate Verification</h2>

<div>

<a href="certificate_dashboard.php">🏠 Dashboard</a>

<a href="certificate_profile.php">👤 Profile</a>

<a href="certificate_logout.php">🚪 Logout</a>

</div>

</div>

<div class="container">

<h2>Student Uploaded Certificates</h2>
 
<form method="GET" style="margin-bottom:20px; display:flex; gap:15px; align-items:center; flex-wrap:wrap;">

<select name="type">
    <option value="">All Achievement Types</option>
    <option value="Internship">Internship</option>
    <option value="Hackathon">Hackathon</option>
    <option value="Workshop">Workshop</option>
    <option value="Certification">Certification</option>
    <option value="Seminar">Seminar</option>
    <option value="Sports">Sports</option>
    <option value="Cultural">Cultural</option>
    <option value="Placement">Placement</option>
    <option value="Other">Other</option>
</select>

<label>From</label>
<input type="date" name="from_date">

<label>To</label>
<input type="date" name="to_date">

<input
type="submit"
value="Search"
style="padding:8px 18px;
background:#003366;
color:white;
border:none;
border-radius:6px;
cursor:pointer;">

</form>
<table>

<tr>

<th>ID</th>

<th>Student</th>

<th>Type</th>

<th>Achievement Date</th>

<th>Title</th>

<th>Description</th>

<th>Certificate</th>

<th>Status</th>

<th>Download</th>

<th>Verify</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<?php echo $row['username']; ?>

</td>

<td>

<?php echo $row['achievement_type']; ?>

</td>

<td>

<?php echo date("d-m-Y",strtotime($row['achievement_date'])); ?>

</td>

<td>

<?php echo $row['title']; ?>

</td>

<td>

<?php echo $row['description']; ?>

</td>

<td>

<img src="uploads/<?php echo $row['file']; ?>">

</td>

<td>

<?php echo $row['verified']; ?>

</td>

<td>

<a class="download"

href="uploads/<?php echo $row['file']; ?>"

download>

Download

</a>

</td>

<td>

<?php

if($row['verified']=="Pending")
{

?>

<a

class="verify"

href="verify_certificate.php?id=<?php echo $row['id']; ?>"

onclick="return confirm('Verify this certificate?');">

Verify

</a>

<?php

}
else
{

?>

<span class="verified">

Verified

</span>

<?php

}

?>

</td>

</tr>

<?php

}

?>

</table>

<br>

<a href="certificate_dashboard.php" class="back">

← Back to Dashboard

</a>

</div>

</body>

</html>