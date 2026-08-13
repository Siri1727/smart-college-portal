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

// Check if notice id is received
if(!isset($_GET['id'])){
    header("Location: faculty_notice_history.php");
    exit();
}

$id = $_GET['id'];

// Get notice details
$result = $conn->query("SELECT * FROM notices WHERE id='$id'");

if($result->num_rows > 0){

    $row = $result->fetch_assoc();

    // Delete uploaded file
    if($row['file'] != "" && file_exists("uploads/notices/".$row['file'])){
        unlink("uploads/notices/".$row['file']);
    }

    // Delete notice from database
    $conn->query("DELETE FROM notices WHERE id='$id'");

    echo "<script>
    alert('Notice Deleted Successfully');
    window.location='faculty_notice_history.php';
    </script>";

}
else{

    echo "<script>
    alert('Notice Not Found');
    window.location='faculty_notice_history.php';
    </script>";

}

$conn->close();
?>