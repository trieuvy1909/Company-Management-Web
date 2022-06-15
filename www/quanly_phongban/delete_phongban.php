<?php
    include_once('../db.php');
    session_start();
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $con = open_database();
    $tenphongban="";
    if(isset($_GET['tenphongban']))
    {
        if(empty($_GET['tenphongban']))
        {
            die('Tên phòng ban không hợp lệ');
        }
        $tenphongban=$_GET['tenphongban'];

        $query = "DELETE FROM `ds_phongban` WHERE tenphongban = '$tenphongban'";
        $results = mysqli_query($con, $query);
        if($results==null)
        {
            die('Lỗi thực thi');
        }
        header('Location: ../quanly_phongban/danhsach_phongban.php?tenphongban='.$tenphongban);
        exit();
    }
?>