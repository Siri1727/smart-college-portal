<?php
session_start();

// Redirect if not logged in
if(!isset($_SESSION['reg_no'])){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost","root","","college_portal");

if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
}

$reg_no = $_SESSION['reg_no'];

// Get Student Details
$sql = "SELECT * FROM students WHERE reg_no='$reg_no'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

$branch = $student['branch'];
$year = $student['year'];

// Fetch Notices
$sql = "SELECT * FROM notices

WHERE year='$year'

AND
(
    branch='ALL'

    OR FIND_IN_SET('$branch',branch)

    OR
    (
        '$branch' LIKE 'CSE-%'
        AND FIND_IN_SET('CSE',branch)
    )
)

ORDER BY COALESCE(updated_date, post_date) DESC";

$notices = $conn->query($sql);

// Mark Notices as Read
if($notices && $notices->num_rows > 0){

    while($notice = $notices->fetch_assoc()){

        $notice_id = $notice['id'];

        $check = $conn->query("
        SELECT *
        FROM notice_views
        WHERE notice_id='$notice_id'
        AND reg_no='$reg_no'
        ");

        if($check->num_rows == 0){

            $conn->query("
            INSERT INTO notice_views(notice_id,reg_no)
            VALUES('$notice_id','$reg_no')
            ");

        }

    }

    // Reset pointer so notices can be displayed again
    $notices->data_seek(0);

}
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>Notice Board | Smart College Portal</title>


<link rel="stylesheet" href="style.css">



<style>


.notice-container{

    width:80%;

    margin:40px auto;

}



.notice-box{

    background:white;

    padding:20px;

    margin-bottom:20px;

    border-radius:10px;

    box-shadow:0 3px 10px #ddd;

}



.notice-box h3{

    color:#1e3a8a;

}



.date{

    color:gray;

    font-size:13px;

}



.download-btn{

    display:inline-block;

    margin-top:15px;

    background:#1e3a8a;

    color:white;

    padding:8px 15px;

    border-radius:5px;

    text-decoration:none;

}



.download-btn:hover{

    opacity:0.8;

}



.no-notice{

    text-align:center;

    font-size:20px;

    color:gray;

}



.back-btn{

    margin:20px;

}



.back-btn a{

    text-decoration:none;

    background:#1e3a8a;

    color:white;

    padding:10px 20px;

    border-radius:5px;

}



</style>


</head>



<body class="dashboard-body">



<!-- TOP BAR -->

<div class="topbar">

<h2>
Smart College Portal | Notice Board
</h2>


</div>




<div class="back-btn">

<a href="dashboard.php">

← Back to Dashboard

</a>


</div>






<div class="notice-container">



<?php


if($notices && $notices->num_rows > 0){



    while($notice = $notices->fetch_assoc()){



?>



<div class="notice-box">



<h3>

<?php echo $notice['title']; ?>

</h3>

<p>
<b>Posted By :</b>
<?php echo htmlspecialchars($notice['posted_by']); ?>
</p>



<p>

<?php echo $notice['description']; ?>

</p>



<p class="date">
<b>Posted :</b>
<?php echo date("d-m-Y h:i A", strtotime($notice['post_date'])); ?>
</p>

<?php
if(!empty($notice['updated_date'])){
?>

<p class="date" style="color:#d35400;">
<b>Reposted :</b>
<?php echo date("d-m-Y h:i A", strtotime($notice['updated_date'])); ?>
</p>

<?php
}
?>





<?php

// Download Button

if(!empty($notice['file'])){


?>



<a class="download-btn"

href="uploads/notices/<?php echo $notice['file']; ?>"

download>


⬇ Download File


</a>



<?php

}


?>





</div>



<?php


    }


}

else{


echo "

<div class='no-notice'>

No Notices Available

</div>

";


}



?>



</div>




</body>

</html>