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

if(!isset($_GET['id'])){
    header("Location: faculty_notice_history.php");
    exit();
}

$id = intval($_GET['id']);

$result = $conn->query("SELECT * FROM notices WHERE id='$id'");

if($result->num_rows==0){
    die("Notice Not Found");
}

$row = $result->fetch_assoc();

// Convert stored departments into array
$selectedBranches = array_map('trim', explode(",", $row['branch']));

if(isset($_POST['update'])){

    $title = trim($_POST['title']);

    if(isset($_POST['branch'])){
        $branch = implode(",", $_POST['branch']);
    }else{
        $branch = "";
    }

    $year = $_POST['year'];

    $description = trim($_POST['description']);

    $filename = $row['file'];

    // Replace file if faculty uploads a new one
    if(!empty($_FILES['file']['name'])){

        if($filename!="" && file_exists("uploads/notices/".$filename)){
            unlink("uploads/notices/".$filename);
        }

        $filename=time()."_".basename($_FILES['file']['name']);

        move_uploaded_file(
            $_FILES['file']['tmp_name'],
            "uploads/notices/".$filename
        );
    }

    $sql="UPDATE notices SET
        title='$title',
        branch='$branch',
        year='$year',
        description='$description',
        file='$filename',
        updated_date=NOW()
      WHERE id='$id'";

    if($conn->query($sql)){
        $conn->query("DELETE FROM notice_views WHERE notice_id='$id'");
        echo "<script>
        alert('Notice Updated Successfully');
        window.location='faculty_notice_history.php';
        </script>";

        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Edit Notice</title>

<style>

body{
margin:0;
font-family:Arial,Helvetica,sans-serif;
background:#eef3fa;
}

.container{
width:720px;
margin:40px auto;
background:#fff;
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
font-weight:bold;
margin-top:18px;
}

input[type=text],
select,
textarea,
input[type=file]{

width:100%;
padding:10px;
margin-top:6px;
border:1px solid #ccc;
border-radius:6px;
box-sizing:border-box;
font-size:15px;

}

textarea{
height:120px;
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

button{

margin-top:25px;
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

.back{

display:block;
text-align:center;
margin-top:15px;
text-decoration:none;
font-weight:bold;
color:#003366;

}

.current-file{

background:#f4f4f4;
padding:10px;
border-radius:6px;
margin-top:8px;

}

</style>

</head>

<body>

<div class="container">

<h2>Edit Notice</h2>

<form method="post" enctype="multipart/form-data">
<label>Notice Title</label>

<input
type="text"
name="title"
value="<?php echo htmlspecialchars($row['title']); ?>"
required>

<label>Select Department(s)</label>

<div class="checkbox-group">

<label>
<input type="checkbox" name="branch[]" value="CSE"
<?php echo in_array("CSE",$selectedBranches) ? "checked" : ""; ?>>
CSE
</label>

<label>
<input type="checkbox" name="branch[]" value="CSE-AIML"
<?php echo in_array("CSE-AIML",$selectedBranches) ? "checked" : ""; ?>>
CSE-AIML
</label>

<label>
<input type="checkbox" name="branch[]" value="CSE-AIDS"
<?php echo in_array("CSE-AIDS",$selectedBranches) ? "checked" : ""; ?>>
CSE-AIDS
</label>

<label>
<input type="checkbox" name="branch[]" value="IT"
<?php echo in_array("IT",$selectedBranches) ? "checked" : ""; ?>>
IT
</label>

<label>
<input type="checkbox" name="branch[]" value="ECE"
<?php echo in_array("ECE",$selectedBranches) ? "checked" : ""; ?>>
ECE
</label>

<label>
<input type="checkbox" name="branch[]" value="EEE"
<?php echo in_array("EEE",$selectedBranches) ? "checked" : ""; ?>>
EEE
</label>

<label>
<input type="checkbox" name="branch[]" value="MECH"
<?php echo in_array("MECH",$selectedBranches) ? "checked" : ""; ?>>
MECH
</label>

<label>
<input type="checkbox" name="branch[]" value="CIVIL"
<?php echo in_array("CIVIL",$selectedBranches) ? "checked" : ""; ?>>
CIVIL
</label>

</div>

<label>Year</label>

<select name="year" required>

<option value="1" <?php if($row['year']=="1") echo "selected"; ?>>1st Year</option>

<option value="2" <?php if($row['year']=="2") echo "selected"; ?>>2nd Year</option>

<option value="3" <?php if($row['year']=="3") echo "selected"; ?>>3rd Year</option>

<option value="4" <?php if($row['year']=="4") echo "selected"; ?>>4th Year</option>

</select>

<label>Description</label>

<textarea
name="description"
required><?php echo htmlspecialchars($row['description']); ?></textarea>

<label>Current File</label>

<div class="current-file">

<?php
if($row['file']!=""){
    echo $row['file'];
}
else{
    echo "No File Uploaded";
}
?>

</div>

<label>Upload New File (Optional)</label>

<input
type="file"
name="file"
accept=".pdf,.jpg,.jpeg,.png">

<button
type="submit"
name="update">

Update Notice

</button>

</form>

<a href="faculty_notice_history.php" class="back">

← Back to Notice History

</a>

</div>

</body>

</html>