<?php
    include_once('../db.php');
    session_start();
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $con = open_database();
    $task_id="";
    if(isset($_GET['id']))
    {
        if(empty($_GET['id']))
        {
            die('id task không tồn tại');
        }
        $task_id=$_GET['id'];
        $query = "DELETE FROM `task` WHERE task_id='$task_id'";
        $results = mysqli_query($con, $query);
        if(!$results)
        {
            die('Lỗi thực thi');
        }
        header('Location: ../index.php');
        exit();
    }
?>