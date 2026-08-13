<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role']!="faculty"){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost","root","","college_portal");

if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
}

$faculty_id = $_SESSION['faculty_id'];

// Get Faculty Name
$result = $conn->query("SELECT * FROM faculty WHERE faculty_id='$faculty_id'");
$faculty = $result->fetch_assoc();

$posted_by = $faculty['name'];

// Fetch Notices Posted By This Faculty
$notices = $conn->query("
SELECT *
FROM notices
WHERE posted_by='$posted_by'
ORDER BY COALESCE(updated_date, post_date) DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Notice History</title>

<style>

body{

margin:0;
font-family:Arial,Helvetica,sans-serif;
background:#eef3fa;

}

.container{

width:95%;
margin:40px auto;

}

h2{

text-align:center;
color:#003366;
margin-bottom:25px;

}

table{

width:100%;
border-collapse:collapse;
background:white;
box-shadow:0 5px 15px rgba(0,0,0,.15);

}

th{

background:#003366;
color:white;
padding:14px;

}

td{

padding:12px;
text-align:center;
border-bottom:1px solid #ddd;

}

tr:hover{

background:#f5f5f5;

}

.btn{

padding:8px 14px;
border:none;
border-radius:5px;
cursor:pointer;
color:white;
text-decoration:none;
font-size:14px;
display:inline-block;

}

.edit{

background:#f39c12;

}

.delete{

background:#e74c3c;

}

.back{

display:inline-block;
margin-top:20px;
padding:12px 20px;
background:#003366;
color:white;
text-decoration:none;
border-radius:6px;

}

.back:hover{

background:#0055aa;

}

.file{

font-weight:bold;
color:#27ae60;

}

</style>

</head>

<body>

<div class="container">

<h2>My Posted Notices</h2>

<table>

<tr>

<th>ID</th>

<th>Title</th>

<th>Department</th>

<th>Year</th>

<th>Posted Date</th>

<th>File</th>

<th>Actions</th>

</tr>

<?php
$sl = 1;
while($row = $notices->fetch_assoc()){
?>

<tr>

<td><?php echo $sl++; ?></td>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['branch']; ?></td>

<td><?php echo $row['year']; ?> Year</td>

<td>

<?php
if($row['updated_date'] != NULL){
    echo "Reposted: ".date("d-m-Y",strtotime($row['updated_date']));
}else{
    echo "Posted: ".date("d-m-Y",strtotime($row['post_date']));
}
?>

</td>
<td>

<?php
if($row['file']!=""){
?>

<span class="file">📄 File Uploaded</span>

<?php
}
else{
?>

<span style="color:red;">No File</span>

<?php
}
?>

</td>

<td>

<a
href="edit_notice.php?id=<?php echo $row['id']; ?>"
class="btn edit">

✏ Edit

</a>

<a
href="delete_notice.php?id=<?php echo $row['id']; ?>"
class="btn delete"
onclick="return confirm('Are you sure you want to delete this notice?');">

🗑 Delete

</a>

</td>

</tr>

<?php
}
?>

</table>

<br>

<a href="faculty_dashboard.php" class="back">

← Back to Dashboard

</a>

</div>

</body>

</html>