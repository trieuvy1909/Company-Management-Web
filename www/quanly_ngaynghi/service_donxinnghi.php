<?php
    session_start();
    include_once('../db.php');
    check_section();
    $con = open_database();
    $id_donxinnghi="";
    if(isset($_GET['approve_id']))
    {
        $id_donxinnghi=$_GET['approve_id'];
        if(empty($id_donxinnghi) || !is_numeric($id_donxinnghi))
        {
            die("Mã đơn không hợp lệ");
        }
        $ngayduyetdon=date("Y/m/d");
        $query = "UPDATE `donxinnghi` SET `trangthai`='Approved',`ngayduyetdon`='$ngayduyetdon' WHERE id_donxinnghi='$id_donxinnghi'";
        $results = mysqli_query($con, $query);
        if($results==null)
        {
            die('Lỗi thực thi SQL');
        }
        else
        {
            header("Location: /quanly_ngaynghi/donxinnghi_detail.php?id=".$id_donxinnghi);
            exit();
        }
    }

    if(isset($_GET['refuse_id']) && isset($_GET['songaynghi']) && isset($_GET['nhanvien_id']))
    {
        $id_donxinnghi=$_GET['refuse_id'];
        $songaynghi=$_GET['songaynghi'];
        $nhanvien_id=$_GET['nhanvien_id'];
        if(empty($id_donxinnghi) || !is_numeric($id_donxinnghi))
        {
            die("Mã đơn không hợp lệ");
        }
        $query = "SELECT * FROM `nhanvien` WHERE manv = '$nhanvien_id' ";
        $results = mysqli_query($con, $query);
        $songaynghi_dadung = $results->fetch_assoc()['songaynghi'];
        $songaynghi_new = $songaynghi_dadung-$songaynghi;
        $query = "update `nhanvien` set songaynghi=$songaynghi_new WHERE manv = '$nhanvien_id' ";
        $results = mysqli_query($con, $query);
        $ngayduyetdon=date("Y/m/d");
        $query = "UPDATE `donxinnghi` SET `trangthai`='Refused',`ngayduyetdon`='$ngayduyetdon' WHERE id_donxinnghi='$id_donxinnghi'";
        $results = mysqli_query($con, $query);
        if($results==null)
        {
            die('Lỗi thực thi SQL');
        }
        else
        {
            header("Location: /quanly_ngaynghi/donxinnghi_detail.php?id=".$id_donxinnghi);
            exit();
        }
    }
?>