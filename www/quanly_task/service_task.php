<?php
    include_once('../db.php');
    session_start();
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $con = open_database();
    $task_id="";
    
    if(isset($_GET['start_id']))
    {
        if(empty($_GET['start_id']) || !is_numeric($_GET['start_id']))
        {
            die('Mã task không hợp lệ');
        }
        $task_id=$_GET['start_id'];
        $query = "update task set trangthai ='In progress',uutien=2 where task_id = '$task_id'";
        $results = mysqli_query($con, $query);
        if(!$results)
        {
            die('Lỗi thực thi');
        }
        if($loainv=="Trưởng Phòng")
        {
            header("Location: /quanly_task/task_action_truongphong.php?task_id_detail=".$task_id);
            exit();
        }
        else if($loainv=="Nhân Viên")
        {
            header("Location: /quanly_task/task_action_nhanvien.php?task_id_detail=".$task_id);
            exit();
        }
    }

    if(isset($_GET['cancel_id']))
    {
        if(empty($_GET['cancel_id'])|| !is_numeric($_GET['cancel_id']))
        {
            die('Mã task không hợp lệ');
        }
        $task_id=$_GET['cancel_id'];
        $query = "update task set trangthai ='Canceled',uutien=3 where task_id = '$task_id'";
        $results = mysqli_query($con, $query);
        if(!$results)
        {
            die('Lỗi thực thi');
        }
        header("Location: /quanly_task/task_detail.php?task_id_detail=".$task_id);
        exit();
    }
    if(isset($_GET['approve_id'])&&isset($_GET['completion_level']))
    {
        $task_id = $_GET['approve_id'];
        $completion_level = $_GET['completion_level'];
        $query = "SELECT * FROM task WHERE task_id=
        '$task_id'";
        $results = mysqli_query($con, $query);
        $count= mysqli_num_rows($results);
        $late="";
        if($count==1)
        {
            $late = $results->fetch_assoc()['late'];
        }
        if($late==1 && $completion_level=="Good")
        {
            die('Thông tin đánh giá không hợp lệ');
        }
        if(!is_numeric($task_id))
        {
            die('Mã task không hợp lệ');
        }
        if($completion_level!="Good" && $completion_level!="OK" && $completion_level!="Bad")
        {
            die('Thông tin đánh giá không hợp lệ');
        }
        $query_update_task = "update task set completion_level ='$completion_level',trangthai = 'Completed',uutien='6' where task_id = $task_id";
        $results = mysqli_query($con, $query_update_task);
        if($results!=null)
        {
            header("Location: /quanly_task/task_action_truongphong.php?task_id_detail=".$task_id);
            exit();
        }
        else
        {
            die('Lỗi thực thi SQL');
        }
    }
?>