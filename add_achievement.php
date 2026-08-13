<?php
session_start();
include("db_connect.php");

if(isset($_POST['submit'])){

    // Logged in student's registration number
    $username = $_SESSION['reg_no'];

    $title = $_POST['title'];
    $achievement_type = $_POST['achievement_type'];
    $achievement_date = $_POST['achievement_date'];
    $description = $_POST['description'];

    $fileName = $_FILES['file']['name'];
    $tempName = $_FILES['file']['tmp_name'];

    $folder = "uploads/" . $fileName;

    move_uploaded_file($tempName, $folder);

    $query = "INSERT INTO achievements
(username, title, achievement_type, achievement_date, description, file, verified)
VALUES
(
'$username',
'$title',
'$achievement_type',
'$achievement_date',
'$description',
'$fileName',
'Pending'
)";

    mysqli_query($conn,$query);

    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Achievement | Smart College Portal</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}

.header{
    background:#244d78;
    color:#fff;
    padding:20px 40px;
    font-size:22px;
    font-weight:600;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.back-btn{
    background:#fff;
    color:#244d78;
    padding:8px 15px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    font-weight:500;
}

body{
    background:url('images/dashboard_image.jpeg') no-repeat center center/cover;
    min-height:100vh;
}

.overlay{
    min-height:100vh;
    padding:50px 0;
}

.container{
    width:500px;
    margin:auto;
    background:#fff;
    padding:35px;
    border-radius:15px;
    box-shadow:0 15px 35px rgba(0,0,0,0.1);
}

.container h2{
    text-align:center;
    margin-bottom:25px;
    color:#244d78;
}

.input-group{margin-bottom:20px;}

input, textarea{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:14px;
}

textarea{resize:none;height:100px;}

.char-count{
    text-align:right;
    font-size:12px;
    color:#777;
    margin-top:5px;
}

.drag-area{
    border:2px dashed #244d78;
    border-radius:12px;
    padding:25px;
    text-align:center;
    cursor:pointer;
    color:#244d78;
}

.drag-area input{display:none;}

.file-name{margin-top:10px;font-size:13px;color:#333;}

.preview img{
    width:100%;
    margin-top:15px;
    border-radius:10px;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#244d78;
    color:#fff;
    font-weight:500;
    cursor:pointer;
}

.popup{
    position:fixed;
    top:20px;
    right:-400px;
    background:#28a745;
    color:#fff;
    padding:15px 25px;
    border-radius:8px;
    transition:0.5s;
}

.popup.show{ right:20px; }
</style>
</head>

<body>

<div class="header">
    Smart College Portal | Add Achievement
    <a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
</div>

<div class="overlay">
<div class="container">
<h2>🏆 Add New Achievement</h2>

<form id="achievementForm" method="POST" enctype="multipart/form-data">



<div class="input-group">
    <input type="text" name="title" id="title" placeholder="Achievement Title" required>
</div>

<div class="input-group">

    <select name="achievement_type" required>
        <option value="">Select Achievement Type</option>
        <option value="Internship">Internship</option>
        <option value="Hackathon">Hackathon</option>
        <option value="Workshop">Workshop</option>
        <option value="Certification">Certification</option>
        <option value="Seminar">Seminar</option>
        <option value="Sports">Sports</option>
        <option value="Cultural">Cultural</option>
        <option value="Placement">Placement</option>
        <option value="Other">Other</option>
    </select>
</div>

<div class="input-group">
    <label><b>Achievement Date</b></label>
    <input type="date" name="achievement_date" required>
</div>

<div class="input-group">
    <textarea name="description" id="description" maxlength="200" placeholder="Write description..." required></textarea>
    <div class="char-count"><span id="count">0</span>/200
</div>
</div>

<div class="input-group">
    <div class="drag-area" id="dragArea">
        📂 Drag & Drop Certificate Here or Click to Upload
        <input type="file" name="file" id="fileInput" accept="image/*" required>
    </div>
    <div class="file-name" id="fileName"></div>
    <div class="preview" id="preview"></div>
</div>

<div style="display:flex; gap:10px;">
    <button type="submit" name="submit" style="flex:1;">Add Achievement</button>
    <button type="button" id="cancelBtn" style="flex:1; background:#ff6b6b;">Cancel</button>
</div>

</form>
</div>
</div>

<div class="popup" id="popup">🎉 Achievement Added Successfully!</div>

<script>
const textarea = document.getElementById("description");
const count = document.getElementById("count");
const dragArea = document.getElementById("dragArea");
const fileInput = document.getElementById("fileInput");
const fileName = document.getElementById("fileName");
const preview = document.getElementById("preview");
const form = document.getElementById("achievementForm");
const popup = document.getElementById("popup");
const cancelBtn = document.getElementById("cancelBtn");

textarea.addEventListener("input", ()=>{
    count.textContent = textarea.value.length;
});

dragArea.addEventListener("click", ()=> fileInput.click());

fileInput.addEventListener("change", ()=>{
    const file = fileInput.files[0];
    if(file){
        fileName.textContent = "Selected File: " + file.name;
        const reader = new FileReader();
        reader.onload = function(e){
            preview.innerHTML = `<img src="${e.target.result}">`;
        }
        reader.readAsDataURL(file);
    }
});

cancelBtn.addEventListener("click", ()=>{
    form.reset();
    count.textContent = "0";
    fileName.textContent = "";
    preview.innerHTML = "";
});

<?php if(isset($success)){ ?>
popup.classList.add("show");
setTimeout(()=>{
    popup.classList.remove("show");
    form.reset();
    count.textContent = "0";
    fileName.textContent = "";
    preview.innerHTML = "";
},3000);
<?php } ?>
</script>

</body>
</html>