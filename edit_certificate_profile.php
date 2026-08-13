
<?php
session_start();

if(!isset($_SESSION['verifier_login'])){
    header("Location: login.php");
    exit();
}

include("db_connect.php");

$verifier_id = $_SESSION['verifier_id'];

$query = "SELECT * FROM certificate_verifier WHERE verifier_id='$verifier_id'";
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $update = "UPDATE certificate_verifier
               SET
               name='$name',
               email='$email',
               password='$password'
               WHERE verifier_id='$verifier_id'";

    if(mysqli_query($conn,$update)){

        $_SESSION['verifier_name'] = $name;
        $_SESSION['verifier_email'] = $email;

        echo "<script>
        alert('Profile Updated Successfully');
        window.location='certificate_profile.php';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Edit Profile</title>

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

.input-group{

margin-bottom:18px;

}

.input-group label{

display:block;
margin-bottom:8px;
font-weight:bold;

}

.input-group input{

width:100%;
padding:12px;
border:1px solid #ccc;
border-radius:6px;
font-size:15px;

}

button{

width:100%;
padding:12px;
background:#003366;
color:white;
border:none;
border-radius:6px;
font-size:16px;
cursor:pointer;

}

button:hover{

background:#0055aa;

}

</style>

</head>

<body>

<div class="header">

<h2>Certificate Verifier</h2>

<div>

<a href="certificate_dashboard.php">🏠 Dashboard</a>

<a href="certificate_profile.php">👤 Profile</a>

<a href="certificate_logout.php">🚪 Logout</a>

</div>

</div>

<div class="container">

<h2>Edit Profile</h2>

<form method="POST">

<div class="input-group">

<label>Name</label>

<input
type="text"
name="name"
value="<?php echo $row['name']; ?>"
required>

</div>

<div class="input-group">

<label>Email</label>

<input
type="email"
name="email"
value="<?php echo $row['email']; ?>"
required>

</div>

<div class="input-group">

<label>Password</label>

<input
type="text"
name="password"
value="<?php echo $row['password']; ?>"
required>

</div>

<button type="submit" name="update">

Update Profile

</button>

</form>

</div>

</body>

</html>