<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "faculty") {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "college_portal");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$faculty_id = $_SESSION['faculty_id'];

$result = $conn->query("SELECT * FROM faculty WHERE faculty_id='$faculty_id'");
$faculty = $result->fetch_assoc();

if(isset($_POST['post'])){

    $title = trim($_POST['title']);

    if(isset($_POST['branch'])){
        $branch = implode(",", $_POST['branch']);
    }else{
        echo "<script>alert('Please select at least one department');</script>";
        exit();
    }

    $year = $_POST['year'];
    $description = trim($_POST['description']);
    $posted_by = $faculty['name'];

    $filename = "";

    if(isset($_FILES['file']) && $_FILES['file']['name']!=""){

        if($_FILES['file']['error']!=0){
            die("Upload Error : ".$_FILES['file']['error']);
        }

        // Create folder automatically
        if(!file_exists("uploads/notices")){
            mkdir("uploads/notices",0777,true);
        }

        // Safe filename
        $filename = time()."_".basename($_FILES['file']['name']);

        $target = "uploads/notices/".$filename;

        if(move_uploaded_file($_FILES['file']['tmp_name'],$target)){

            // Success

        }else{

            die("Unable to upload file.");

        }

    }

    $sql="INSERT INTO notices
(title,branch,year,description,file,posted_by,post_date,updated_date)
VALUES
(
'$title',
'$branch',
'$year',
'$description',
'$filename',
'$posted_by',
NOW(),
NULL
)";

    if($conn->query($sql)){

        echo "<script>
        alert('Notice Posted Successfully');
        window.location='faculty_dashboard.php';
        </script>";

        exit();

    }else{

        die("Database Error : ".$conn->error);

    }

}
?>
<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Post Notice</title>

<style>

body{
    margin:0;
    font-family:Arial,Helvetica,sans-serif;
    background:#eef3fa;
}

.container{
    width:700px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.2);
}

h2{
    text-align:center;
    color:#003366;
    margin-bottom:25px;
}

label{
    display:block;
    margin-top:15px;
    font-weight:bold;
}

input[type=text],
select,
textarea{
    width:100%;
    padding:10px;
    margin-top:6px;
    border:1px solid #ccc;
    border-radius:6px;
    box-sizing:border-box;
    font-size:15px;
}

textarea{
    height:130px;
    resize:none;
}

.checkbox-group{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:10px;
    margin-top:10px;
}

.checkbox-group label{
    display:flex;
    align-items:center;
    font-weight:normal;
}

.checkbox-group input{
    width:auto;
    margin-right:8px;
}

input[type=file]{
    margin-top:8px;
}

button{
    width:100%;
    padding:12px;
    margin-top:20px;
    background:#003366;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-size:16px;
}

button:hover{
    background:#0055aa;
}

.back{
    display:block;
    text-align:center;
    margin-top:18px;
    text-decoration:none;
    color:#003366;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

<h2>Post Notice</h2>

<form method="post" enctype="multipart/form-data">

<label>Notice Title</label>

<input
type="text"
name="title"
placeholder="Enter Notice Title"
required>

<label>Select Department(s)</label>

<div class="checkbox-group">

<label><input type="checkbox" name="branch[]" value="CSE"> CSE</label>

<label><input type="checkbox" name="branch[]" value="CSE-AIML"> CSE-AIML</label>

<label><input type="checkbox" name="branch[]" value="CSE-AIDS"> CSE-AIDS</label>

<label><input type="checkbox" name="branch[]" value="IT"> IT</label>

<label><input type="checkbox" name="branch[]" value="ECE"> ECE</label>

<label><input type="checkbox" name="branch[]" value="EEE"> EEE</label>

<label><input type="checkbox" name="branch[]" value="MECH"> MECH</label>

<label><input type="checkbox" name="branch[]" value="CIVIL"> CIVIL</label>

<label><input type="checkbox" name="branch[]" value="ALL"> All Departments</label>

</div>

<label>Year</label>

<select name="year" required>

<option value="">Select Year</option>

<option value="1">1st Year</option>

<option value="2">2nd Year</option>

<option value="3">3rd Year</option>

<option value="4">4th Year</option>

</select>

<label>Description</label>

<textarea
name="description"
placeholder="Enter Notice Description"
required></textarea>

<label>Upload PDF / Image</label>

<input
type="file"
name="file"
accept=".pdf,.jpg,.jpeg,.png">

<label>Posted By</label>

<input
type="text"
value="<?php echo htmlspecialchars($faculty['name']); ?>"
readonly>

<button
type="submit"
name="post">

Post Notice

</button>

</form>

<a href="faculty_dashboard.php" class="back">

← Back to Dashboard

</a>

</div>

</body>
</html>