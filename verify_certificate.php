<?php
session_start();

if(!isset($_SESSION['verifier_login'])){
    header("Location: login.php");
    exit();
}

include("db_connect.php");

if(isset($_GET['id'])){

    $id = intval($_GET['id']);

    $sql = "UPDATE achievements
            SET verified='Verified'
            WHERE id='$id'";

    if(mysqli_query($conn,$sql)){

        header("Location: verify_certificates.php?success=1");
        exit();

    }else{

        die("Error : ".mysqli_error($conn));

    }

}else{

    header("Location: verify_certificates.php");
    exit();

}
?>