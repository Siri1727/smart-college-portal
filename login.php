<?php
session_start();

$conn = new mysqli("localhost","root","","college_portal");

if($conn->connect_error){
    die("Connection failed : ".$conn->connect_error);
}

if(isset($_POST['login'])){

    $username = trim($_POST['reg_no']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // ================= STUDENT LOGIN =================

    if($role=="student"){

        $sql = "SELECT * FROM students
                WHERE reg_no='$username'
                AND password='$password'";

        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)>0){

            $row = mysqli_fetch_assoc($result);

            $_SESSION['role'] = "student";
            $_SESSION['reg_no'] = $row['reg_no'];
            $_SESSION['student_name'] = $row['name'];
            $_SESSION['email'] = $row['email'];

            header("Location: dashboard.php");
            exit();

        }else{

            echo "<script>alert('Invalid Student ID or Password');</script>";

        }

    }

    // ================= FACULTY LOGIN =================

    elseif($role=="faculty"){

        $sql = "SELECT * FROM faculty
                WHERE faculty_id='$username'
                AND password='$password'";

        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)>0){

            $row = mysqli_fetch_assoc($result);

            $_SESSION['role'] = "faculty";
            $_SESSION['faculty_id'] = $row['faculty_id'];
            $_SESSION['faculty_name'] = $row['name'];
            $_SESSION['department'] = $row['department'];
            $_SESSION['email'] = $row['email'];

            header("Location: faculty_dashboard.php");
            exit();

        }else{

            echo "<script>alert('Invalid Faculty ID or Password');</script>";

        }

    }

    // ================= CERTIFICATE VERIFIER LOGIN =================

    elseif($role=="certificate verifier"){

        $sql = "SELECT * FROM certificate_verifier
                WHERE verifier_id='$username'
                AND password='$password'";

        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)>0){

            $row = mysqli_fetch_assoc($result);

            $_SESSION['role'] = "certificate verifier";
            $_SESSION['verifier_login'] = true;
            $_SESSION['verifier_id'] = $row['verifier_id'];
            $_SESSION['verifier_name'] = $row['name'];
            $_SESSION['verifier_email'] = $row['email'];

            header("Location: certificate_dashboard.php");
            exit();

        }else{

            echo "<script>alert('Invalid Certificate Verifier ID or Password');</script>";

        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Smart College Portal | Login</title>

<link rel="stylesheet" href="style.css">

</head>

<body class="login-page">

<div class="top-title">

<h1>Smart College Portal</h1>

<p>
Attendance • Achievements • Academic Excellence
</p>

</div>

<div class="login-card">

<div class="login-left">

<img src="images/login-illustration.jpeg" alt="Login Image">

</div>

<div class="login-right">

<h2>Login</h2>

<p class="subtitle">
Hey enter your details to sign in to your account
</p>

<form method="post">

<input
type="text"
name="reg_no"
placeholder="Enter your username"
required>

<input
type="password"
name="password"
placeholder="Enter your password"
required>

<select name="role" required>

    <option value="">Login as</option>

    <option value="student">
        Student
    </option>

    <option value="faculty">
        Faculty
    </option>

    <option value="certificate verifier">
        Certificate Verifier
    </option>

</select>

<button
    type="submit"
    name="login">

    Login

</button>

</form>

</div>

</div>

<script src="script.js"></script>

</body>
</html>