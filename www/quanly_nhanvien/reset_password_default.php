<?php
    include_once('../db.php');
    session_start();
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $con = open_database();
    $username="";
    if(isset($_GET['username']))
    {
        $username = $_GET['username'];
        if(!empty($username))
        {
            $password_hash = password_hash($username,PASSWORD_BCRYPT);
            $query = "update nhanvien set password = '$password_hash' where username = '$username'";
            $results = mysqli_query($con, $query);
                    
                    if($results==null)
                    {
                        die("Lỗi thực thi SQL");
                    }
                    else
                    {
                        if($username==$_SESSION['username'])
                        {
                            header("Location: ../logout.php");
                            exit();
                        }
                        else{
                            header("Location: /quanly_canhan/profile.php?username_profile=".$username);
                            exit();
                        }
                    }
        }
    }
?>