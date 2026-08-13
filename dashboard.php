<?php
session_start();

// Redirect if user is not logged in
if(!isset($_SESSION['reg_no'])){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost","root","","college_portal");

if($conn->connect_error){
    die("Connection Failed: ".$conn->connect_error);
}

$reg_no = $_SESSION['reg_no'];

// Get Student Details
$sql = "SELECT * FROM students WHERE reg_no='$reg_no'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Student Branch & Year
$branch = $row['branch'];
$year = $row['year'];

// Check if any notice exists
// Check for unread notices
$hasNotice = false;

$sql = "
SELECT n.id
FROM notices n

LEFT JOIN notice_views v
ON n.id = v.notice_id
AND v.reg_no = '$reg_no'

WHERE
v.id IS NULL

AND n.year='$year'

AND
(
    n.branch='ALL'
    OR FIND_IN_SET('$branch', n.branch)
    OR
    (
        '$branch' LIKE 'CSE-%'
        AND FIND_IN_SET('CSE', n.branch)
    )
)

LIMIT 1
";

$resultNotice = $conn->query($sql);

if($resultNotice && $resultNotice->num_rows > 0){
    $hasNotice = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Dashboard | Smart College Portal</title>

<link rel="stylesheet" href="style.css">

<script src="script.js"></script>

<style>

/* Notice Card Highlight */

.notice-card{

position:relative;

border:3px solid #2c7be5;

box-shadow:0 0 18px rgba(44,123,229,.35);

transition:0.3s;

}

.notice-card:hover{

transform:translateY(-8px);

box-shadow:0 0 25px rgba(44,123,229,.55);

}

/* Notification Bubble */

.notification-dot{

position:absolute;

top:10px;

right:12px;

width:16px;

height:16px;

background:#ff3b30;

border-radius:50%;

border:3px solid white;

animation:pulse 1.5s infinite;

}

/* Bubble Animation */

@keyframes pulse{

0%{

transform:scale(1);

box-shadow:0 0 0 0 rgba(255,59,48,.7);

}

70%{

transform:scale(1.2);

box-shadow:0 0 0 12px rgba(255,59,48,0);

}

100%{

transform:scale(1);

box-shadow:0 0 0 0 rgba(255,59,48,0);

}

}

</style>

</head>

<body class="dashboard-body">

<!-- TOP BAR -->

<div class="topbar">

<h2>Smart College Portal | Dashboard</h2>

<div class="profile" onclick="toggleMenu()">

<img src="images/<?php echo $row['photo'] ? $row['photo'] : 'student.jpg'; ?>" alt="Profile">

<div class="dropdown" id="menu">

<a href="profile.php">Profile</a>

<a href="logout.php">Logout</a>

</div>

</div>

</div>

<!-- DASHBOARD -->

<div class="dashboard">

<div class="card" onclick="location.href='attendance.php'">

<h3>Attendance</h3>

<p>View subject-wise attendance</p>

</div>

<div class="card" onclick="location.href='add_achievement.php'">

<h3>Add Achievement</h3>

<p>Upload certificates & awards</p>

</div>

<div class="card" onclick="location.href='view_achievements.php'">

<h3>My Achievements</h3>

<p>View uploaded achievements</p>

</div>

<!-- Notice Card -->

<div class="card notice-card" onclick="location.href='notice_board.php'">

<?php
if($hasNotice){
?>

<span class="notification-dot"></span>

<?php
}
?>

<h3>Notice Board</h3>

<p>Latest announcements</p>

</div>

</div>

</body>

</html>