<?php
    include_once('../db.php');
    session_start();
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $con = open_database();
    $task_id_detail="";
    
    $task_id="";
    $task_name="";
    $nhanvien_id="";
    $deadline ="";
    $tenphongban = "";
    $trangthai="";
    $file_mota="";
    $error="";
    $message="";
    $file="";
    //load thông tin task
if(isset($_GET['task_id_detail']))
{
    $task_id_detail=$_GET['task_id_detail'];
    if(!empty($task_id_detail)&&is_numeric($task_id_detail))
    {
        $query = "SELECT * FROM task WHERE task_id=
                        '$task_id_detail'";
        $results = mysqli_query($con, $query);
        if(!$results)
        {
            $error="Lỗi thực thi SQL khi lấy thông tin task";
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
            }
        }
    }
    else
    {
        $error = "Mã task không hợp lệ";
    }
}
//update task
if(isset($_POST['task_id']) &&isset($_POST['deadline']) && isset($_POST['task_name']) && isset($_POST['nhanvien_id']))
{
    $file_mota_path="";
    $task_id_detail=$_POST['task_id'];
    
    //chuẩn bị thông tin điền vào field
    $task_id=$_POST['task_id'];
    $task_name=$_POST['task_name'];
    $nhanvien_id=$_POST['nhanvien_id'];
    $deadline =$_POST['deadline'];
    $tenphongban = $_SESSION['tenphongban'];
    $trangthai = $_POST['trangthai'];
    if(empty($deadline))
    {
        $error = "Vui lòng chọn ngày đến hạn";
    }
    else if(($nhanvien_id)=="Chọn id nhân viên" || $nhanvien_id=="")
    {
        $error = "Vui lòng chọn nhân viên phụ trách";
    }
    else if(empty($task_name))
    {
        $error = "Vui lòng nhập tên task";
    }
    else
    {
        if(isset($_FILES['file']))
        {
            $file = $_FILES['file'];
            $name = $file['name'];
            $type=$file['type'];
            $tmp=$file['tmp_name'];
            $size=$file['size'];
            $er = $file['error'];
            $file_ext = pathinfo($name,PATHINFO_EXTENSION);
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
                        $file_mota_path = '/tasks_attached_files/task' .$task_id.'.'.$file_ext;
                        $file_mota=basename($file_mota_path);
                        move_uploaded_file($tmp,$_SERVER['DOCUMENT_ROOT']. $file_mota_path);
                        $message=$message." Lưu file thành công";
                    }   
            }
            
            $query = "update task set task_id = '$task_id', tentask = '$task_name', nhanvien_id = '$nhanvien_id', tenphongban = '$tenphongban',deadline = '$deadline',file_mota = '$file_mota_path' where task_id = '$task_id'";
            
            $results = mysqli_query($con, $query);
            $message=" Cập nhật task thành công";
        }
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
body>

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
                        <h1 class="h3 mb-0 text-gray-800">Update task</h1>
                    </div>
                </div>
                <!-- Nội dung -->
                <form method="post" action="update_task.php" class="
                justify-content-center card bg-white shadow-lg mx-auto px-3 pt-3 col-md-6 col-lg-8" enctype="multipart/form-data" onsubmit="return validate_create_task()">
                <h3 class="text-center">Task</h3>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="task_id">Mã task</label>
                            <input onclick="clearErrorMessage()" class="form-control" value="<?=$task_id?>" name= "task_id" id="task_id" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tenphongban">Phòng ban</label>
                            <input onclick="clearErrorMessage()" class="form-control" value="<?=$tenphongban?>" name= "tenphongban" id="tenphongban" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="deadline">Hạn nộp</label>
                            <input type="date" onclick="clearErrorMessage()" class="form-control" value="<?=$deadline?>" name= "deadline" id="deadline">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nhanvien_id">Nhân viên phụ trách</label>
                            <select id="nhanvien_id" name="nhanvien_id" class="custom-select" onclick="clearErrorMessage()">
                                <option selected><?=$nhanvien_id?></option>
                                <?php
                                    $query = "SELECT * FROM nhanvien WHERE tenphongban=
                                    '$tenphongban' and loainv='Nhân Viên'";
                                    $results = mysqli_query($con, $query);
                                    while($data = $results->fetch_assoc())
                                    {
                                        echo '<option value="'.$data['manv'].'">'.$data['manv'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="trangthai">Trạng thái</label>
                            <input onclick="clearErrorMessage()" class="form-control" value="<?=$trangthai?>" name= "trangthai" id="trangthai" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="task_name">Tên task</label>
                        <input value="<?=$task_name?>" onclick="clearErrorMessage()" type="text" class="form-control" id="task_name" name="task_name"  placeholder="Nhập tên task...">
                    </div>

                    <div class="form-group">
                        <label>File đính kèm: </label>
                        <?php
                        if($file_mota!="")
                            echo '<a href="../download.php?id='.$file_mota_path.'">'.$file_mota.'</a>';
                        else
                            echo 'Không có';
                        ?>
                        <div class="custom-file">
                            <input onchange="update_label_of_fileupload()" onclick="clearErrorMessage()"  type="file" name="file" class="custom-file-input" id="file">
                            <label class="custom-file-label" for="file">Chọn File</label>
                        </div>
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
                                <a href="../quanly_task/update_task.php?task_id_detail='.$task_id.'" class="btn btn-primary btn-block">Reload</a>';
                            }
                            else
                            {
                                if($trangthai=="New")
                                {
                                    echo '<button type="submit" class="btn btn-primary btn-block">Thay đổi</button>';
                                }
                            }
                        ?>                    
                        
                    </div>
                </form>
                <?php include('../page/footer.php');   ?>
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

</html>