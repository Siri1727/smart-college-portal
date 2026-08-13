<?php
session_start();

if(!isset($_SESSION['faculty_id'])){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost","root","","college_portal");

$faculty_id = $_SESSION['faculty_id'];

$sql = "SELECT * FROM faculty WHERE faculty_id='$faculty_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Faculty Profile</title>

<style>

body{
font-family:Arial;
background:linear-gradient(120deg,#87CEEB,#E6F7FF);
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

.profile-card{
width:420px;
background:white;
padding:30px;
border-radius:12px;
box-shadow:0 10px 25px rgba(6,169,35,0.2);
text-align:center;
}

.profile-card img{
width:120px;
height:120px;
border-radius:50%;
border:4px solid #93c7e9;
margin-bottom:15px;
}

.profile-card h2{
margin:10px 0;
display:flex;
justify-content:center;
align-items:center;
gap:10px;
}

.edit-icon{
font-size:18px;
text-decoration:none;
cursor:pointer;
}

.info{
text-align:left;
margin-top:20px;
}

.info p{
padding:10px;
border-bottom:1px solid #eee;
font-size:16px;
}

button{
margin-top:20px;
padding:10px 20px;
border:none;
background:#3498db;
color:white;
font-size:15px;
border-radius:6px;
cursor:pointer;
}

button:hover{
background:#2980b9;
}

</style>

<script>

function goBack(){

window.location.href="faculty_dashboard.php";

}

</script>

</head>

<body>

<div class="profile-card">

<img src="images/faculty.png" alt="Faculty">

<h2>

<?php echo $row['name']; ?>

<a href="edit_faculty_profile.php" class="edit-icon">
✏️
</a>

</h2>

<div class="info">

<p><b>Faculty ID :</b> <?php echo $row['faculty_id']; ?></p>

<p><b>Department :</b> <?php echo $row['department']; ?></p>

<p><b>Email :</b> <?php echo $row['email']; ?></p>

<p><b>Password :</b> ********</p>

</div>

<button onclick="goBack()">
Back to Dashboard
</button>

</div>

</body>
</html>