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


/* Faculty Details */

$faculty_id   = $_SESSION['faculty_id'];
$faculty_name = $_SESSION['faculty_name'];
$department   = $_SESSION['department'];



/* Date Details */

$date = date("Y-m-d");

$displayDate = date("d-m-Y");

$day = date("l");



/* Variables */

$semester = "";

$section = "";

$period = "";

$subject = "";

$message = "";

$students = [];



/* Load Students */

if(isset($_POST['load'])){


    $semester = trim($_POST['semester']);

    $section  = trim($_POST['section']);



    if($semester=="" || $section==""){


        $message="Please select Semester and Section.";


    }

    else{


        /*
        Get period and subject
        from faculty_timetable
        */


        $timeTable = $conn->query("

        SELECT period,subject

        FROM faculty_timetable

        WHERE

        faculty_id='$faculty_id'

        AND department='$department'

        AND semester='$semester'

        AND section='$section'

        AND day_name='$day'

        LIMIT 1

        ");




        if($timeTable->num_rows==0){


            $message="No timetable found for today.";


        }

        else{


            $tt = $timeTable->fetch_assoc();


            $period = $tt['period'];

            $subject = $tt['subject'];



            /*
            Duplicate Attendance Check
            */


            $duplicate = $conn->query("

            SELECT id

            FROM attendance

            WHERE

            date='$date'

            AND semester='$semester'

            AND section='$section'

            AND period='$period'

            AND subject='$subject'

            LIMIT 1

            ");



            if($duplicate->num_rows>0){


                $message="Attendance already marked for this class.";


            }

            else{


                /*
                Load Students
                */


                $studentQuery = $conn->query("

                SELECT *

                FROM students

                WHERE

                department='$department'

                AND semester='$semester'

                AND section='$section'

                ORDER BY reg_no

                ");



                while($row=$studentQuery->fetch_assoc()){


                    $students[]=$row;


                }



                if(count($students)==0){


                    $message="No students found.";


                }



            }



        }



    }



}

?>
<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Mark Attendance</title>


<style>


body{

margin:0;

font-family:Arial,Helvetica,sans-serif;

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



.back-btn{

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

max-width:1000px;

margin:30px auto;

background:white;

padding:30px;

border-radius:12px;

box-shadow:0 5px 15px rgba(0,0,0,.2);

}



h3{

text-align:center;

color:#003366;

margin-bottom:25px;

}



.message{

color:red;

font-weight:bold;

text-align:center;

margin-bottom:20px;

}



.info-box{

background:#f8f9fa;

border:1px solid #ddd;

padding:20px;

border-radius:8px;

margin-bottom:25px;

line-height:35px;

}



.filters{

display:grid;

grid-template-columns:1fr 1fr auto;

gap:15px;

margin-top:15px;

}



select{

padding:10px;

font-size:15px;

border-radius:6px;

border:1px solid #ccc;

}



.load-btn{

background:#003366;

color:white;

padding:10px 20px;

border:none;

border-radius:6px;

cursor:pointer;

}



.load-btn:hover{

background:#0055aa;

}



table{

width:100%;

border-collapse:collapse;

margin-top:20px;

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



.save-btn{

margin-top:20px;

width:100%;

padding:12px;

background:#28a745;

color:white;

border:none;

border-radius:6px;

font-size:16px;

cursor:pointer;

}



.save-btn:hover{

background:#218838;

}



.attendance-type{

background:#f8f9fa;

padding:15px;

border-radius:8px;

margin-top:20px;

border:1px solid #ddd;

}


</style>


</head>


<body>


<div class="topbar">


<h2>Mark Attendance</h2>


<button

class="back-btn"

onclick="window.location='faculty_dashboard.php'">

← Back to Dashboard

</button>


</div>



<div class="container">


<h3>Mark Student Attendance</h3>



<?php

if($message!=""){

echo "<div class='message'>$message</div>";

}

?>



<form method="post">


<div class="info-box">


<b>Date :</b>

<?php echo $displayDate; ?>


<br>


<b>Department :</b>

<?php echo $department; ?>


<br><br>



<div class="filters">


<select name="semester" required>


<option value="">Select Semester</option>


<option value="1/1">1/1</option>

<option value="1/2">1/2</option>

<option value="2/1">2/1</option>

<option value="2/2">2/2</option>

<option value="3/1">3/1</option>

<option value="3/2">3/2</option>

<option value="4/1">4/1</option>

<option value="4/2">4/2</option>


</select>




<select name="section" required>


<option value="">Select Section</option>


<option value="A">A</option>

<option value="B">B</option>

<option value="C">C</option>


</select>




<button

type="submit"

name="load"

class="load-btn">

Load Students

</button>



</div>


</div>


</form>
<?php

if(count($students)>0){

?>



<?php
/*
Show Period and Subject
*/
?>

<div class="info-box">


<b>Period :</b>

<?php echo $period; ?>


<br>


<b>Subject :</b>

<?php echo $subject; ?>


</div>





<form method="post" action="save_attendance.php">



<input
type="hidden"
name="attendance_type"
id="attendance_type"
value="present">



<input
type="hidden"
name="semester"
value="<?php echo $semester; ?>">



<input
type="hidden"
name="section"
value="<?php echo $section; ?>">



<input
type="hidden"
name="period"
value="<?php echo $period; ?>">



<input
type="hidden"
name="subject"
value="<?php echo $subject; ?>">






<div class="attendance-type">


<b>Select Attendance Type:</b>


<br><br>


<label>


<input

type="radio"

name="attendance_option"

value="present"

checked

onclick="changeAttendance('present')">


Choose Present Students


</label>



&nbsp;&nbsp;&nbsp;&nbsp;




<label>


<input

type="radio"

name="attendance_option"

value="absent"

onclick="changeAttendance('absent')">


Choose Absent Students


</label>



</div>







<table>



<tr>


<th>S.No</th>

<th>Registration No</th>

<th>Student Name</th>

<th>Select</th>


</tr>





<?php


$sl=1;



foreach($students as $s){


?>



<tr>



<td>

<?php echo $sl++; ?>

</td>





<td>


<?php echo $s['reg_no']; ?>


<input

type="hidden"

name="all_students[]"

value="<?php echo $s['reg_no']; ?>">



</td>






<td>


<?php echo $s['name']; ?>


</td>







<td>


<input

type="checkbox"

name="selected_students[]"

value="<?php echo $s['reg_no']; ?>">



</td>





</tr>



<?php

}


?>





</table>





<button

type="submit"

class="save-btn">


Save Attendance


</button>





</form>



<?php

}

?>
<script>


function changeAttendance(type){


    document.getElementById("attendance_type").value = type;


}



</script>



</div>


</body>


</html>