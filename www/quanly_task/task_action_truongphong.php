<?php
session_start();
include_once('../db.php');
check_section();
$ten_nv = $_SESSION['tennv'];
$avatar = $_SESSION['avatar'];
$loainv = update_loainv();
$con = open_database();
    //load task
$error="";
if(isset($_GET['task_id_detail']))
{
    $task_id="";
    $task_name="";
    $nhanvien_id="";
    $deadline ="";
    $trangthai="";
    $tenphongban = "";
    $file_mota_path="";
    $file_mota = "";
    $file_nop_path="";
    $file_nop = "";
    $file_bosung_path="";
    $file_bosung = "";
    $completion_level = "";
    $comment="";
    $late="";

    //lấy thông tin task show vào form
    $task_id_detail=$_GET['task_id_detail'];
    $con = open_database();
    if(!empty($task_id_detail)&& is_numeric($task_id_detail))
    {
        $query = "SELECT * FROM task WHERE task_id=
                        '$task_id_detail'";
        $results = mysqli_query($con, $query);
        if($results==null)
        {
            $error="Lỗi thực thi SQL khi lấy dữ liệu task";
        }
        else
        {
            $count= mysqli_num_rows($results);
            if($count==1)
            {
                $data= $results->fetch_assoc();
                $task_id=$data['task_id'];
                $task_name=$data['tentask'];
                $nhanvien_id=$data['nhanvien_id'];
                $deadline =$data['deadline'];
                $trangthai=$data['trangthai'];
                $tenphongban = $_SESSION['tenphongban'];
                $file_mota_path=$data['file_mota'];
                $file_mota = basename($file_mota_path);
                $file_nop_path=$data['file_nop'];
                $file_nop = basename($file_nop_path);
                $file_bosung_path=$data['file_bosung'];
                $file_bosung = basename($file_bosung_path);
                $completion_level = $data['completion_level'];
            }
            else
            {
                $error="Task không tồn tại";
            }
            $query_history ="SELECT * FROM `history_submit` WHERE history_id = (SELECT max(history_id) from `history_submit` where task_id = '$task_id')";
    
            $result_history = mysqli_query($con, $query_history);
            $count= mysqli_num_rows($result_history);
            $comment="";
            if($count==1)
            {
                $data= $result_history->fetch_assoc();
                $comment=$data['comment'];
            }
            $date=date("Y-m-d");
            $secs = strtotime($deadline) - strtotime($date);
            $days = $secs / 86400; 
            $late = 0;
            if($days<0)
            {
                $late=1;
            }
        }
    }
    else
    {
        $error = "Mã task không hợp lệ";
    } 
}
//reject task
if(isset($_POST['task_id']) && isset($_POST['comment']) && 
isset($_POST['deadline']) && isset($_FILES['file']))
{
    $task_id="";
    $task_name="";
    $nhanvien_id="";
    $deadline ="";
    $trangthai="";
    $tenphongban = "";
    $file_mota_path="";
    $file_mota = "";
    $file_nop_path="";
    $file_nop = "";
    $file_bosung_path="";
    $file_bosung = "";
    $completion_level = "";
    $comment="";
    $late="";
    $history_id="";
    $message="";

    $deadline=$_POST['deadline'];
    $task_id_form=$_POST['task_id'];
    $comment = $_POST['comment'];

    if(empty($task_id_form))
    {
        $error="Vui lòng nhập mã task";
    }
    else if($comment=="")
    {
        $error="Vui lòng nhập lời nhắn cho nhân viên";
    }
    else if(empty($deadline))
    {
        $error="Vui lòng nhập hạn nộp";
    }
    if($error=="")
    {
        $file_bosung = $_FILES['file'];
        $name = $file_bosung['name'];
        $type=$file_bosung['type'];
        $tmp=$file_bosung['tmp_name'];
        $size=$file_bosung['size'];
        $er = $file_bosung['error'];
        
        $file_ext = pathinfo($name,PATHINFO_EXTENSION);
        //thiết lập file nộp
        if($er!="4")
        {
            $file_extension = array("rar","zip","txt","doc","docx","xls","xlsx","jpg","png","mp3","mp4","pdf","png","jpeg");
            if($size > (8*1024*1024))
            {
                $error="File đính kèm lớn hơn 20MB không khả dụng";
            }
            else if(in_array($file_ext,$file_extension)===false)
            {
                $error="Định dạng file không được hệ thống hỗ trợ";
            }
            else
            {
                $file_direc = '/task_bosung_files/bosung_task'.$task_id_form.'.'.$file_ext;
                if(!file_exists('../task_bosung_files')){
                    // Tạo một thư mục mới
                    mkdir('../task_bosung_files/');
                }
                move_uploaded_file($tmp,$_SERVER['DOCUMENT_ROOT']. $file_direc);
                $message=$message." Lưu file thành công. ";
            }
        }
        else
        {
            $file_nop="";
            $error="Vui lòng chọn file bổ sung cho nhân viên";
        }
    }
    //lấy id hiện tại của history
    $query_history ="SELECT * FROM `history_submit` WHERE history_id = (SELECT max(history_id) from `history_submit`)";
    
    $result_history = mysqli_query($con, $query_history);
    $count= mysqli_num_rows($result_history);
    $history_id="";
    if($count==1)
    {
        $data= $result_history->fetch_assoc();
        $history_id=$data['history_id']+1;
    }else if($count==0)
    {
        $history_id=1;
    }
    //kiem tra da quá hạn hay chưa
    $date=date("Y-m-d");
    $secs = strtotime($deadline) - strtotime($date);
    $days = $secs / 86400; 
    $late=0;
    if($days<0)
    {
        $late = 1;
    }
    if($error=="")
    {
        //update task 
        $query_update_task = "update task set file_bosung = '$file_direc',trangthai='Rejected',uutien=5,late=$late,deadline='$deadline' where task_id = $task_id_form";
        $results = mysqli_query($con, $query_update_task);
        if($results!=null)
        {
            $message=$message."Reject thành công.";
        }
        else
        {
            $error = "Submit thất bại";
        }
        //add history
        $date=date("Y-m-d");
        $query_add_history ="INSERT INTO history_submit(history_id, task_id, comment, trangthai, file_submit, date) VALUES ($history_id,$task_id_form,'$comment','Rejected','$file_direc','$date')";
        
        $result_add_history = mysqli_query($con, $query_add_history);
        if(!$result_add_history)
        {
            $error="Lỗi thực thi thêm lịch sử nộp task";
        }
    }
    //lấy thông tin task show vào form
    $query = "SELECT * FROM task WHERE task_id=
    '$task_id_form'";

    $results = mysqli_query($con, $query);
    $count= mysqli_num_rows($results);
    if($count==1)
    {
        $data= $results->fetch_assoc();
        $task_id=$data['task_id'];
        $task_name=$data['tentask'];
        $nhanvien_id=$data['nhanvien_id'];
        $deadline =$data['deadline'];
        $trangthai=$data['trangthai'];
        $tenphongban = $_SESSION['tenphongban'];
        $file_mota_path=$data['file_mota'];
        $file_mota = basename($file_mota_path);
        $file_nop_path=$data['file_nop'];
        $file_nop = basename($file_nop_path);
        $file_bosung_path=$data['file_bosung'];
        $file_bosung = basename($file_bosung_path);
        $completion_level = $data['completion_level'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<title>Chi tiết task</title>
</head>
<body>

    <!-- Page Wrapper -->
    <div class="wrapper">

        <!-- Sidebar -->
        <?php
            include('../page/sidebar.php');
        ?>
        <div id="content">
                <!-- phần thông tin đầu trang -->
                <?php include('../page/header.php');?>
        
                <!-- Tựa đề trang -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 ">Thông tin task</h1>
                    </div>
                </div>
                <!-- Nội dung -->
                <form method="post" action="task_action_truongphong.php" class=" justify-content-center card bg-white shadow-lg mx-auto px-3 pt-3 col-md-6 col-lg-8" enctype="multipart/form-data" onsubmit="return validate_reject_task()">
                <h3 class="text-center">Task</h3>
                <?php
                    if($late==1)
                    {
                        echo '<div class="text-danger font-italic font-weight-bold text-center">(Quá hạn)</div>';
                    }
                    else if($late==0){
                        echo '<div class="text-success font-italic font-weight-bold text-center">(Còn thời gian)</div>';
                    }
                ?>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="task_id">Mã task</label>
                            <input class="form-control" value="<?=$task_id?>" name= "task_id" id="task_id" readonly >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tenphongban">Phòng ban</label>
                            <input class="form-control" value="<?=$tenphongban?>" name= "tenphongban" id="tenphongban" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="deadline">Hạn nộp</label>
                            <input <?php if($trangthai!="Waiting") echo 'disabled' ?> type="date" class="form-control" value="<?=$deadline?>" name= "deadline" id="deadline">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nhanvien_id">Nhân viên phụ trách</label>
                            <input type="text" class="form-control" value="<?=$nhanvien_id?>" name= "nhanvien_id" id="nhanvien_id" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="trangthai">Trạng thái</label>
                            <input class="form-control" value="<?=$trangthai?>" name= "trangthai" id="trangthai" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="task_name">Tên task</label>
                        <input value="<?=$task_name?>" type="text" class="form-control" id="task_name" name="task_name"  placeholder="Nhập tên task..." disabled>
                    </div>
                <div class="form-row text-center">
                    <div class="form-group col-md-4">
                        <label>File mô tả: </label>
                        <?php
                        if($file_mota!="")
                            echo '<a href="../download.php?id='.$file_mota_path.'">'.$file_mota.'</a>';
                        else
                            echo 'Không có';
                        ?>
                    </div>
                    <div class="form-group  col-md-4">
                        <label>File đã nộp: </label>
                        <?php
                        if($file_nop!="")
                            echo '<a href="../download.php?id='.$file_nop_path.'">'.$file_nop.'</a>';
                        else
                            echo 'Không có';
                        ?>
                    </div>
                    <div class="form-group  col-md-4">
                        <label>File bổ sung: </label>
                        <?php
                        if($file_bosung!="")
                            echo '<a href="../download.php?id='.$file_bosung_path.'">'.$file_bosung.'</a>';
                        else
                            echo 'Không có';
                        ?>
                    </div>
                </div>
                    <div class="form-group">
                    <?php
                            if($trangthai=="Waiting")
                            {
                                echo'<label for="comment">Lời nhắn:</label>
                                <textarea onclick="clearErrorMessage()" class="form-control rounded" rows="2.5"  name="comment" id="comment">'.$comment.'</textarea>';
                            }
                            else
                            {
                                echo'<label for="comment">Lời nhắn:</label>
                                <textarea disabled onclick="clearErrorMessage()" class="form-control rounded" rows="2.5"  name="comment" id="comment">'.$comment.'</textarea>';
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                            if($trangthai=="Waiting")
                            {
                                echo'<label>File bổ sung: </label>
                                <div class="custom-file">
                                    <input onchange="update_label_of_fileupload()" onclick="clearErrorMessage()"  type="file" name="file" class="custom-file-input" id="file">
                                    <label class="custom-file-label" for="file">Chọn File</label>
                                </div>';
                            }
                        ?>
                    </div>
                    <div class="form-group"> 
                        <?php
                            if(!empty($error))
                            {
                                echo '<div class="alert text-center alert-danger" id="errorMessage">' . $error .'</div>';
                            }
                            else
                            {
                                echo '<div class="alert text-center alert-danger" id="errorMessage" style="display: none;"></div>';
                            }
                            if(!empty($message))
                            {
                                echo '<div id="successMessage" class="alert alert-success">' . $message .'</div>
                                <a href="../quanly_task/task_action_truongphong.php?task_id_detail='.$task_id.'" class="btn btn-primary btn-block">Reload</a>';
                            }
                            if($trangthai=="New")
                            {
                                echo '<a href="../quanly_task/service_task.php/?cancel_id='.$task_id.'" class="btn btn-danger btn-block">Cancel</a>';
                            }
                            if($trangthai=="Waiting")
                            {
                                echo '<button type="submit" class="btn btn-danger btn-block ">Reject</button>';

                                echo '<a class="btn btn-success btn-block" data-toggle="modal" data-target="#xacnhandanhgia" >Approve</a>';
                            }
                            if($trangthai=="Completed")
                            {
                                echo '<div class="alert alert-success text-center">Đánh giá: '.$completion_level.'</div>';
                            }
                        ?>                    
                        <a class="text-center btn-block" href="history_task.php?task_id=<?=$task_id?>">Lịch sử Task: <?=$task_id?></a>
                    </div>
                </form>
                <?php include('../page/footer.php'); ?>
            <!-- hết nội dung -->
        </div>
    <!-- End of Content Wrapper -->
    </div>

    <!-- Logout Modal-->
    <?php include('../page/logout_modal.php');?>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>
<!-- Modal -->
<div class="modal fade" id="xacnhandanhgia" tabindex="-1" role="dialog" aria-labelledby="xacnhandanhgiaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="xacnhandanhgiaLabel">Đánh giá task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn hãy đánh giá mức độ hoàn thành công việc của nhân viên <b><?=$nhanvien_id?></b> 
                </div>
                <div class="modal-footer">
                    <a href="../quanly_task/service_task.php/?approve_id=<?=$task_id?>&completion_level=Bad" class="btn btn-danger btn-block">Bad</a>
                    <a href="../quanly_task/service_task.php/?approve_id=<?=$task_id?>&completion_level=OK" class="btn btn-warning btn-block">OK</a>
                    <?php
                        if($late==0)
                        {
                            echo '<a href="../quanly_task/service_task.php/?approve_id='.$task_id.'&completion_level=Good" class="btn btn-primary btn-block">Good</a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</html>