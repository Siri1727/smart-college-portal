<?php

require_once "mail_config.php";

$conn = new mysqli("localhost","root","","college_portal");

if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
}

/* Attendance Start Date */
$attendance_start_date = "2026-07-21";

/* Alert Starts After 2 Months */
$alert_start_date = date(
    "Y-m-d",
    strtotime($attendance_start_date." +2 months")
);

$today = date("Y-m-d");

/* Uncomment after testing */
/*
if($today < $alert_start_date){
    exit();
}
*/

/* Test with one student */
$sql = "
SELECT *
FROM students
WHERE reg_no='TEST101'
";

$result = $conn->query($sql);

while($student = $result->fetch_assoc()){

    $reg_no = $student['reg_no'];
    $name   = $student['name'];

    // Parent Email
    $email = trim($student['parent_email']);

    if(empty($email)){
        continue;
    }

    /* Calculate Attendance */

    $att = $conn->query("
        SELECT
            COUNT(*) AS total,
            SUM(CASE WHEN status='Present' THEN 1 ELSE 0 END) AS attended
        FROM attendance
        WHERE reg_no='$reg_no'
    ");

    $row = $att->fetch_assoc();

    $total = $row['total'];
    $attended = $row['attended'];

    if($total == 0){
        continue;
    }

    $percentage = round(($attended/$total)*100,2);

    if($percentage < 75){

        // Send Mail
        $sent = sendAttendanceMail(
            $email,
            $name,
            $percentage
        );

        if($sent){

            $conn->query("
                UPDATE students
                SET attendance_alert_sent=1
                WHERE reg_no='$reg_no'
            ");

            echo "Mail sent successfully to Parent: ".$email;

        }else{

            echo "Mail sending failed.";

        }

    }else{

        echo "Attendance is above 75%. No mail sent.";

    }

}

$conn->close();

?>