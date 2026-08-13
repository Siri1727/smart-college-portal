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

$faculty_id = $_SESSION['faculty_id'];

$department = $_SESSION['department'];




/* Check Request */

if(
!isset($_POST['semester']) ||
!isset($_POST['section']) ||
!isset($_POST['period']) ||
!isset($_POST['subject']) ||
!isset($_POST['attendance_type'])
){

    die("Invalid Request");

}




$semester = $_POST['semester'];

$section = $_POST['section'];

$period = $_POST['period'];

$subject = $_POST['subject'];

$attendance_type = $_POST['attendance_type'];




/* Selected Students */

$selected_students = [];


if(isset($_POST['selected_students'])){

    $selected_students = $_POST['selected_students'];

}



$date = date("Y-m-d");





/* Duplicate Attendance Check */


$check = $conn->query("

SELECT id

FROM attendance

WHERE

date='$date'

AND faculty_id='$faculty_id'

AND semester='$semester'

AND section='$section'

AND subject='$subject'

AND period='$period'

LIMIT 1

");



if($check->num_rows > 0){


echo "

<script>

alert('Attendance already marked for this class.');

window.location='mark_attendance.php';

</script>

";


exit();


}






/* Get Students */


$students = $conn->query("

SELECT *

FROM students

WHERE

department='$department'

AND semester='$semester'

AND section='$section'

ORDER BY reg_no

");





if($students->num_rows==0){


echo "

<script>

alert('No students found.');

window.location='mark_attendance.php';

</script>

";


exit();


}







/* Insert Attendance */


while($student=$students->fetch_assoc()){



    $reg_no = $student['reg_no'];

    $name = $student['name'];




    /*
    
    Choose Present Students:
    Selected = Present
    Others = Absent


    Choose Absent Students:
    Selected = Absent
    Others = Present

    */



    if(in_array($reg_no,$selected_students)){


        if($attendance_type=="present"){

            $status="Present";

        }
        else{

            $status="Absent";

        }


    }

    else{


        if($attendance_type=="present"){

            $status="Absent";

        }
        else{

            $status="Present";

        }


    }







    $conn->query("

    INSERT INTO attendance

    (

    reg_no,
    name,
    faculty_id,
    department,
    subject,
    period,
    semester,
    section,
    status,
    date

    )


    VALUES

    (

    '$reg_no',
    '$name',
    '$faculty_id',
    '$department',
    '$subject',
    '$period',
    '$semester',
    '$section',
    '$status',
    '$date'

    )


    ");



}





echo "

<script>

alert('Attendance Saved Successfully.');

window.location='mark_attendance.php';

</script>

";



?>