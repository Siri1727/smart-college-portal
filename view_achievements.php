<?php
session_start();
include("db_connect.php");

if(!isset($_SESSION['reg_no'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['reg_no'];

$query = "SELECT * FROM achievements WHERE username='$username' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Achievements</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

/* SAME BACKGROUND IMAGE - NO DARK OVERLAY */
body{
    min-height:100vh;
    background:url('images/dashboard_image.jpeg') no-repeat center center/cover;
}

/* HEADER SAME AS ADD ACHIEVEMENT */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 50px;
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(8px);
    color:white;
    background:#244d78;
}

.header h2{
    font-weight:600;
}

.back-btn{
    background:rgba(255,255,255,0.25);
    padding:8px 18px;
    border-radius:30px;
    text-decoration:none;
    color:white;
    transition:0.3s;
}

.back-btn:hover{
    background:white;
    color:#244d78;
}

/* PAGE TITLE */
.page-title{
    text-align:center;
    color:black;
    font-size:32px;
    margin:30px 0 40px;
    font-weight:600;
}

/* GRID */
.container{
    width:90%;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
    gap:30px;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(10px);
    border-radius:20px;
    padding:15px;
    color:black;
    box-shadow:0 8px 25px rgba(0,0,0,0.15);
    transition:0.4s;
}

.card:hover{
    transform:translateY(-8px) scale(1.03);
}

/* IMAGE */
.card img{
    width:100%;
    height:200px;
    object-fit:cover;
    border-radius:15px;
    cursor:pointer;
}

/* CONTENT */
.card h3{
    margin-top:12px;
    font-weight:500;
}

.card p{
    font-size:14px;
    margin:8px 0;
}

/* STATUS */
.status{
    display:inline-block;
    padding:6px 15px;
    border-radius:25px;
    font-size:12px;
    font-weight:500;
}

.pending{
    background:#ffc107;
    color:#333;
}

.verified{
    background:#28a745;
    color:white;
}

/* EMPTY MESSAGE */
.empty{
    text-align:center;
    color:white;
    font-size:18px;
    margin-top:40px;
}

/* IMAGE MODAL */
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
    z-index:1000;
}

.modal img{
    max-width:80%;
    max-height:80%;
    border-radius:15px;
}
</style>
</head>

<body>

<div class="header">
    <h2>Smart College Portal</h2>
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

<h1 class="page-title">🏆 My Achievements</h1>

<div class="container">

<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>

    <div class="card">
        <img src="uploads/<?php echo $row['file']; ?>" onclick="openModal(this.src)">
        <h3><?php echo $row['title']; ?></h3>
        <p><?php echo $row['description']; ?></p>

        <span class="status <?php echo strtolower($row['verified']); ?>">
            <?php echo $row['verified']; ?>
        </span>
    </div>

<?php
    }
}else{
    echo "<div class='empty'>No achievements uploaded yet.</div>";
}
?>

</div>

<!-- IMAGE MODAL -->
<div class="modal" id="imageModal" onclick="closeModal()">
    <img id="modalImg">
</div>

<script>
function openModal(src){
    document.getElementById("imageModal").style.display="flex";
    document.getElementById("modalImg").src = src;
}

function closeModal(){
    document.getElementById("imageModal").style.display="none";
}
</script>

</body>
</html>