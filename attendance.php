<?php
session_start();

if(!isset($_SESSION['reg_no'])){
    header("Location:login.php");
    exit();
}

$conn = new mysqli("localhost","root","","college_portal");
require_once "mail_config.php";

if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
}

$reg_no=$_SESSION['reg_no'];

/* Student Details */

$sql="SELECT * FROM students WHERE reg_no='$reg_no'";
$result=$conn->query($sql);
$student=$result->fetch_assoc();

$name=$student['name'];
$branch=$student['branch'];
$year=$student['year'];

$email = trim($student['parent_email']);

$alertSent=0;
if(isset($student['attendance_alert_sent'])){
    $alertSent=$student['attendance_alert_sent'];
}

/* Attendance Start Date */

$attendance_start_date="2026-05-19";

$alert_start_date=date(
"Y-m-d",
strtotime($attendance_start_date." +2 months")
);

$today=date("Y-m-d");

/* Default Filter */

$filter="today";
$fromDate="";
$toDate="";
$whereDate="date<=CURDATE()";

/* Apply Filter */

if(isset($_POST['apply'])){

    $filter=$_POST['filter'];

    if($filter=="today"){

        $whereDate="date<=CURDATE()";

    }

    elseif($filter=="month"){

        $whereDate="
        MONTH(date)=MONTH(CURDATE())
        AND
        YEAR(date)=YEAR(CURDATE())
        ";

    }

    elseif($filter=="custom"){

        $fromDate=$_POST['from_date'];
        $toDate=$_POST['to_date'];

        if($fromDate!="" && $toDate!=""){

            $whereDate="
            date BETWEEN
            '$fromDate'
            AND
            '$toDate'
            ";

        }else{

            $whereDate="date<=CURDATE()";

        }

    }

}

/* Subject Wise Attendance */

$sql="

SELECT

subject,

COUNT(*) AS total_periods,

SUM(
CASE
WHEN status='Present'
THEN 1
ELSE 0
END
) AS attended

FROM attendance

WHERE

reg_no='$reg_no'

AND

$whereDate

GROUP BY subject

ORDER BY subject

";

$result=$conn->query($sql);

$attendance=[];

$totalHeld=0;
$totalAttended=0;

while($row=$result->fetch_assoc()){

    $row['percentage']=0;

    if($row['total_periods']>0){

        $row['percentage']=round(

        ($row['attended']/$row['total_periods'])*100,

        2

        );

    }

    $attendance[]=$row;

    $totalHeld+=$row['total_periods'];

    $totalAttended+=$row['attended'];

}

$overall=0;

if($totalHeld>0){

    $overall=round(

    ($totalAttended/$totalHeld)*100,

    2

    );

}
/* -------------------------------
Automatic Email Alert
-------------------------------- */

if(

$today >= $alert_start_date

&&

$overall < 75

&&

$alertSent == 0

){

    if(!empty($email)){

    $mailSent = sendAttendanceMail(

        $email,

        $name,

        $overall

    );

    if($mailSent){

        $conn->query("
            UPDATE students
            SET attendance_alert_sent=1
            WHERE reg_no='$reg_no'
        ");

        $alertSent = 1;
    }

}

    if($mailSent){

        $conn->query("

        UPDATE students

        SET attendance_alert_sent=1

        WHERE reg_no='$reg_no'

        ");

        $alertSent = 1;

    }

}

?>
<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Attendance</title>

<style>

body{

margin:0;
font-family:Arial;
background:#eef3fa;

}

.topbar{

background:#003366;
color:white;
padding:15px 30px;
display:flex;
justify-content:space-between;
align-items:center;

}

.topbar h2{

margin:0;

}

.back{

background:white;
color:#003366;
padding:10px 18px;
border:none;
border-radius:6px;
cursor:pointer;
font-weight:bold;

}

.container{

width:95%;
max-width:1200px;
margin:30px auto;
background:white;
padding:30px;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,.2);

}

h3{

text-align:center;
color:#003366;

}

.filter-box{

display:flex;
justify-content:center;
gap:20px;
flex-wrap:wrap;
margin-top:30px;
margin-bottom:30px;

}

.filter-box label{

font-weight:bold;

}

input[type=date]{

padding:8px;

}

button{

padding:10px 18px;
background:#003366;
color:white;
border:none;
border-radius:6px;
cursor:pointer;

}

button:hover{

background:#0055aa;

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
text-align:center;
border-bottom:1px solid #ddd;

}

.low{

background:#ffd6d6;

}

.summary{

margin-top:30px;
display:flex;
justify-content:space-around;
font-size:18px;
font-weight:bold;

}

.warning{

margin-top:30px;
background:#ffe5e5;
color:red;
padding:18px;
border-left:6px solid red;
border-radius:8px;

}

</style>

</head>

<body>

<div class="topbar">

<h2>

Student Attendance

</h2>

<button
class="back"
onclick="window.location='dashboard.php'">

← Back

</button>

</div>

<div class="container">

<h3>

Attendance Report

</h3>
<form method="post">

<div class="filter-box">

<label>

<input
type="radio"
name="filter"
value="today"
<?php if($filter=="today") echo "checked"; ?>

>

Till Today

</label>

<label>

<input
type="radio"
name="filter"
value="month"
<?php if($filter=="month") echo "checked"; ?>

>

This Month

</label>

<label>

<input
type="radio"
name="filter"
value="custom"
<?php if($filter=="custom") echo "checked"; ?>

>

Custom Range

</label>

<label>

From

</label>

<input
type="date"
name="from_date"
value="<?php echo $fromDate; ?>">

<label>

To

</label>

<input
type="date"
name="to_date"
value="<?php echo $toDate; ?>">

<button
type="submit"
name="apply">

Apply

</button>

</div>

</form>

<table>

<tr>

<th>

Subject

</th>

<th>

Total Periods Held

</th>

<th>

Total Attended

</th>

<th>

Attendance %

</th>

</tr>

<?php

if(count($attendance)>0){

foreach($attendance as $row){

$class="";

if(

$today >= $alert_start_date

&&

$row['percentage'] < 60

){

$class="low";

}

?>

<tr class="<?php echo $class; ?>">

<td>

<?php echo $row['subject']; ?>

</td>

<td>

<?php echo $row['total_periods']; ?>

</td>

<td>

<?php echo $row['attended']; ?>

</td>

<td>

<?php echo $row['percentage']; ?>%

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="4">

No Attendance Records Found

</td>

</tr>

<?php

}

?>

</table>
<div class="summary">

<div>

Total Periods Held

<br><br>

<span style="color:#003366;font-size:22px;">

<?php echo $totalHeld; ?>

</span>

</div>

<div>

Total Attended

<br><br>

<span style="color:green;font-size:22px;">

<?php echo $totalAttended; ?>

</span>

</div>

<div>

Overall Attendance

<br><br>

<span
style="
font-size:22px;
<?php
if(
$today >= $alert_start_date &&
$overall < 75
){
echo "color:red;";
}
else{
echo "color:green;";
}
?>
">

<?php echo $overall; ?>%

</span>

</div>

</div>

<?php

if(

$today >= $alert_start_date

&&

$overall < 75

){

?>

<div class="warning">

⚠ <b>Attendance Shortage Alert</b>

<br><br>

Your attendance is

<b>

<?php echo $overall; ?>%

</b>

which is below the required

<b>75%</b>.

<br><br>

Please attend classes regularly to avoid shortage of attendance.

</div>

<?php

}

/*

--------------------------------------------

One Time Email Alert

(Next Step)

If attendance <75%

AND attendance_alert_sent = 0

↓

Send Email

↓

Update attendance_alert_sent = 1

--------------------------------------------

*/

?>

</div>

</body>

</html>
