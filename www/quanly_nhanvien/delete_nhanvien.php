<?php
session_start();
include_once('../db.php');
check_section();
if(isset($_GET['username_del']))
{
        $username = $_GET['username_del'];
        $con = open_database();
        $query = "DELETE FROM `nhanvien` WHERE username='$username'";
        $results = mysqli_query($con, $query);
        header("Location: ../index.php");
        exit();
}
?>