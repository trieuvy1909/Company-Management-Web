<?php
session_start();
include_once('../db.php');
check_section();
$ten_nv = $_SESSION['tennv'];
$loainv = update_loainv();
$con = open_database();
$avatar = $_SESSION['avatar'];
$avatar_upload_get="";
if(isset($_GET['username_profile']))
{
    $username=$_GET['username_profile'];
}else
{
    $username=$_SESSION['username'];
}
$query = "SELECT * FROM nhanvien WHERE username=
                    '$username'";
$results = mysqli_query($con, $query);
$count= mysqli_num_rows($results);
if($count==1)
    {
        $data= $results->fetch_assoc();
        $avatar_upload_get=$data['avt'];
    }
if(isset($_FILES['file']))
{
    $file = $_FILES['file'];
    $filename = $file['name'];
    $type=$file['type'];
    $tmp=$file['tmp_name'];
    $size=$file['size'];
    $er = $file['error'];
    $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
    if($er!="4")
    {
        $file_extension = array("jpg,jpeg,png,gif");
        if($size > (8*1024*1024))
        {
            $error="File đính kèm lớn hơn 20MB không khả dụng";
        }
        else if($file_ext!= "jpg" && $file_ext!= "jpeg" &&
            $file_ext!= "png" && $file_ext!= "gif")
        {
            $error="Định dạng file không được hệ thống hỗ trợ";
        }
        else
        {
            $avatar_path = '/avatar/'.$_SESSION['username'].'.'.$file_ext;
            $avatar_upload=basename($avatar_path);
                        
            move_uploaded_file($tmp,$_SERVER['DOCUMENT_ROOT']. $avatar_path);
            $message="Lưu file thành công. ";

            $query ="update nhanvien set avt =  '$avatar_upload' where username = '$username'";
            $results = mysqli_query($con, $query);
            
            if($results==null)
            {
                $error = "Lỗi thực thi SQL";
            }
            else
            {
                $message=$message."Đổi thành công.";
                $avatar_upload_get=$avatar_upload;
                $_SESSION['avatar']=$avatar_upload;
            }
        }   
    }
    else
    {
        $error="Vui lòng chọn avatar";
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
	<title>Profile</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
                    </div>
                </div>
                <!-- Nội dung -->
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                    <form method="post" action="profile.php" class="shadow justify-content-center card mx-auto px-3 pt-3 col-md-6 col-lg-8 mb-5 bg-white shadow-lg" enctype="multipart/form-data" onsubmit="return validate_create_task()">
                        <div class="text-center form-group">
                            <img src="../avatar/<?=$avatar_upload_get?>" width="300px" height="300px">
                        </div>

                        <div class="form-group">
                        <label>Upload avatar</label>
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
                            if(!empty($message) && empty($error))
                            {
                                echo '<div id="successMessage" class="alert alert-success">' . $message .'</div>
                                <a href="../quanly_canhan/profile.php" class="btn btn-primary btn-block">Reload</a>';
                            }
                            else
                            {
                                echo '<button type="submit" class="btn btn-primary btn-block">Đổi avatar</button>';
                            }
                        ?>                    
                        </div>
                    </form>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <form class="shadow-lg justify-content-center card bg-white mx-auto px-3 pt-3 col-md-6 col-lg-8 mb-5"  onsubmit="false">
                            <div class="form-group">
                                <label>Mã nhân viên</label>
                                <input class="form-control" value="<?=$data['manv']?>" disabled>
                            </div>
                            <div class="form-group">
                                <label >Tên đăng nhập</label>
                                <input class="form-control" value="<?=$data['username']?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" class="form-control" value="<?=$data['tennv']?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="tenphongban">Tên phòng ban</label>
                                <?php 
                                    if($data['tenphongban']==null) 
                                    echo' <input type="text" class="form-control" value="Không thuộc phòng ban nào" disabled>'; 
                                    else 
                                    echo' <input type="text" class="form-control" value="'.$data['tenphongban'].'" disabled>';
                                ?>                              
                            </div>
                            <div class="form-group">
                                <label>Số ngày đã nghỉ</label>
                                <input type="text" class="form-control" value="<?=$data['songaynghi']?>" disabled>
                            </div>
                            <div class="form-group">
                                <a data-toggle="modal" data-target="#reset_password_Modal" class="btn btn-block btn-danger">Đưa về mật khẩu mặc định</a>
                            </div>
                        </form>
                    </div>
                
                </div>

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