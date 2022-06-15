<?php
    session_start();
    include_once('../db.php');
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $tenphongban = $_SESSION['tenphongban'];
    $con = open_database();
    $file="";
    $error="";
    $message="";
    $file_direc="";
    $query = "select task_id from task where task_id = (select max(task_id) from task)";
    $task_name="";
    $nhanvien_id="Chọn id nhân viên";
    $deadline ="";
    $results = mysqli_query($con, $query);
    if($results->num_rows==0)
    {
        $task_id=1;
    }else
    {
        $task_id=$results->fetch_assoc()['task_id']+1;
    }
    if(isset($_POST['deadline']) && isset($_POST['task_name']) &&
        isset($_POST['nhanvien_id']))
    {
        $deadline = $_POST['deadline'];
        $task_name=$_POST['task_name'];
        $nhanvien_id=$_POST['nhanvien_id'];
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
                        $file_direc = '/tasks_attached_files/task' .$task_id.'.'.$file_ext;
                        if(!file_exists("../tasks_attached_files/")){
                            // Tạo một thư mục mới
                            mkdir('../tasks_attached_files/');
                        }
                        move_uploaded_file($tmp,$_SERVER['DOCUMENT_ROOT']. $file_direc);
                        $message=$message." Lưu file thành công";
                        
                    }
                }

                        move_uploaded_file($tmp,$_SERVER['DOCUMENT_ROOT']. $file_direc);
            $query = "INSERT INTO task(task_id, tentask, nhanvien_id, tenphongban,deadline,file_mota, trangthai, uutien) VALUES ('$task_id','$task_name','$nhanvien_id','$tenphongban','$deadline','$file_direc','New',1)";
            
            $results = mysqli_query($con, $query);
            $message=" Thêm task thành công";
        
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
	<title>Trang chủ</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Create task</h1>
                    </div>
                </div>
                <!-- Nội dung -->
                <form method="post" action="create_task.php" class="  justify-content-center card bg-white shadow-lg mx-auto px-3 pt-3 col-md-6 col-lg-8" enctype="multipart/form-data" onsubmit="return validate_create_task()">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="task_id">Mã task</label>
                            <input onclick="clearErrorMessage()" class="form-control" value="<?=$task_id?>" name= "task_id" id="task_id" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="tenphongban">Phòng ban</label>
                            <input onclick="clearErrorMessage()" class="form-control" value="<?=$tenphongban?>" name= "tenphongban" id="tenphongban" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="deadline">Hạn nộp</label>
                            <input type="date" onclick="clearErrorMessage()" class="form-control" value="<?=$deadline?>" name= "deadline" id="deadline">
                        </div>
                        <div class="form-group col-md-3">
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
                    </div>
                    <div class="form-group">
                        <label for="task_name">Tên task</label>
                        <input value="<?=$task_name?>" onclick="clearErrorMessage()" type="text" class="form-control" id="task_name" name="task_name"  placeholder="Nhập tên task...">
                    </div>

                    <div class="form-group">
                        <label>File đính kèm</label>
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
                                <a href="../quanly_task/create_task.php" class="btn btn-primary btn-block">Reload</a>';
                            }
                            else
                            {
                                echo '<button type="submit" class="btn btn-primary btn-block">Tạo</button>';
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
