<?php
session_start();

if(!isset($_SESSION['reg_no'])){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost","root","","college_portal");

if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
}

$reg_no = $_SESSION['reg_no'];

$sql = "SELECT * FROM students WHERE reg_no='$reg_no'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $branch = $_POST['branch'];
    $year = $_POST['year'];

    $sql = "UPDATE students SET
            name='$name',
            email='$email',
            password='$password',
            branch='$branch',
            year='$year'
            WHERE reg_no='$reg_no'";

    if($conn->query($sql)){

        echo "<script>
        alert('Profile Updated Successfully');
        window.location='profile.php';
        </script>";
        exit();

    }else{
        echo "<script>alert('Update Failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profile</title>

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

input{
width:100%;
padding:10px;
margin:8px 0;
border:1px solid #ccc;
border-radius:6px;
box-sizing:border-box;
}

button{
margin-top:10px;
padding:10px;
width:100%;
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

<h2>Edit Profile</h2>

<form method="post">

<label>Name</label>
<input type="text"
name="name"
value="<?php echo $row['name']; ?>"
required>

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

<label>Branch</label>
<input type="text"
name="branch"
value="<?php echo $row['branch']; ?>"
required>

<label>Year</label>
<input type="text"
name="year"
value="<?php echo $row['year']; ?>"
required>

<button type="submit" name="update">
Update Profile
</button>

</form>

<button class="back"
onclick="window.location.href='profile.php'">
Back to Profile
</button>

</div>

</body>
</html>