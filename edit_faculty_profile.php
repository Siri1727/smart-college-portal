<?php
session_start();

if(!isset($_SESSION['faculty_id'])){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost","root","","college_portal");

if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
}

$faculty_id = $_SESSION['faculty_id'];

$sql = "SELECT * FROM faculty WHERE faculty_id='$faculty_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "UPDATE faculty SET
            name='$name',
            department='$department',
            email='$email',
            password='$password'
            WHERE faculty_id='$faculty_id'";

    if($conn->query($sql)){
        echo "<script>
        alert('Profile Updated Successfully');
        window.location='faculty_profile.php';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Faculty Profile</title>

<style>

body{
font-family:Arial;
background:linear-gradient(120deg,#87CEEB,#E6F7FF);
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

.edit-card{
width:420px;
background:white;
padding:30px;
border-radius:12px;
box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.edit-card h2{
text-align:center;
margin-bottom:20px;
}

label{
font-weight:bold;
display:block;
margin-top:10px;
}

input,select{
width:100%;
padding:10px;
margin:8px 0;
border:1px solid #ccc;
border-radius:6px;
box-sizing:border-box;
}

button{
margin-top:10px;
padding:10px 20px;
border:none;
background:#3498db;
color:white;
font-size:15px;
border-radius:6px;
cursor:pointer;
width:100%;
}

button:hover{
background:#2980b9;
}

.back{
background:#555;
}

.back:hover{
background:#333;
}

</style>

</head>

<body>

<div class="edit-card">

<h2>Edit Faculty Profile</h2>

<form method="post">

<label>Faculty ID</label>
<input type="text"
value="<?php echo $row['faculty_id']; ?>"
readonly>

<label>Faculty Name</label>
<input type="text"
name="name"
value="<?php echo $row['name']; ?>"
required>

<label>Department</label>

<select name="department" required>

<option value="CSE" <?php if($row['department']=="CSE") echo "selected"; ?>>CSE</option>

<option value="IT" <?php if($row['department']=="IT") echo "selected"; ?>>IT</option>

<option value="ECE" <?php if($row['department']=="ECE") echo "selected"; ?>>ECE</option>

</select>

<label>Email</label>
<input type="email"
name="email"
value="<?php echo $row['email']; ?>"
required>

<label>Password</label>
<input type="text"
name="password"
value="<?php echo $row['password']; ?>"
required>

<button type="submit" name="update">
Update Profile
</button>

</form>

<button class="back"
onclick="window.location.href='faculty_profile.php'">
Back to Profile
</button>

</div>

</body>
</html>