<?php
    include_once('../db.php');
    session_start();
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $con = open_database();
    $username="";
    $name="";
    $password="";
    $tenphongban="Chọn tên phòng ban";
    $error="";
    $message="";
    $avatar_upload="";
    $avatar_path="";
    if(isset($_POST['username']) && isset($_POST['name'])
    && isset($_POST['password']) && isset($_POST['tenphongban']) && isset($_FILES['file']))
    {
        $username=mysqli_real_escape_string($con,$_POST['username']);
        $name=$_POST['name'];
        $password=$_POST['password'];
        $tenphongban=$_POST['tenphongban'];
        if(empty($username))
        {
            $error ="Vui lòng nhập tên đăng nhập";
        }
        else if(empty($name))
        {
            $error="Vui lòng nhập tên nhân viên";
        }
        else if(empty($password))
        {
            $error = "Vui lòng nhập mật khẩu";
        }
        else if(strlen($password)<6)
        {
            $error = "Mật khẩu không được ít hơn 6 kí tự";
        }
        else if(empty($tenphongban) || $tenphongban=="Chọn tên phòng ban")
        {
            $error = "Vui lòng nhập tên phòng ban";
        }
        if(empty($error))
        {
            $query = "select * from nhanvien where username = '$username'";
            $results = mysqli_query($con, $query);
            $count =  mysqli_num_rows($results);
            if($count==0)
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
                        $avatar_path = '/avatar/'.$username.'.'.$file_ext;
                        $avatar_upload=basename($avatar_path);
                        
                        move_uploaded_file($tmp,$_SERVER['DOCUMENT_ROOT']. $avatar_path);
                        $message="Lưu file thành công. ";
                    }   
                }
                else
                {
                    $error="Vui lòng chọn avatar";
                }
                if(empty($error))
                {
                    $password_hash = password_hash($password,PASSWORD_BCRYPT);
                    $manv = $username;
                    $query = "INSERT INTO `nhanvien`(`manv`, `username`, `password`, `tennv`, `loainv`, `tenphongban`, `avt`, `songaynghi`) VALUES ('$manv','$username','$password_hash','$name','Nhân Viên','$tenphongban','$avatar_upload',0)";
                    $results = mysqli_query($con, $query);
                    
                    if($results==null)
                    {
                        $error = "Lỗi thực thi SQL";
                    }
                    else
                    {
                        $message = "Thêm nhân viên thành công";
                    }
                }
            }
            else
            {
                $error = "Tên đăng nhập đã tồn tại";
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-5">
                        <h1 class="h3 mb-0 text-gray-800">Tạo tài khoản</h1>
                    </div>
                </div>
                <!-- Nội dung -->
                <form method="post" action="create_nhanvien.php" class=" justify-content-center card bg-white shadow-lg mx-auto px-3 pt-3 col-md-6 col-lg-8 mb-5" enctype="multipart/form-data" onsubmit="return validate_create_task()">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập</label>
                        <input onclick="clearErrorMessage()" class="form-control" value="<?=$username?>" name= "username" id="username" placeholder="Nhập tên đăng nhập...">
                    </div>

                    <div class="form-group">
                        <label for="name">Tên nhân viên</label>
                        <input type="text" onclick="clearErrorMessage()" class="form-control" value="<?=$name?>" name= "name" id="name" placeholder="Nhập tên nhân nhân viên...">
                    </div>

                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" onclick="clearErrorMessage()" class="form-control" value="<?=$password?>" name= "password" id="password" placeholder="Nhập mật khẩu...">
                    </div>

                    <div class="form-group">
                        <label for="tenphongban">Tên phòng ban</label>
                        <select id="tenphongban" name="tenphongban" class="custom-select" onclick="clearErrorMessage()">
                                <option selected><?=$tenphongban?></option>
                                <?php
                                    $query = "SELECT * FROM ds_phongban";
                                    $results = mysqli_query($con, $query);
                                    while($data = $results->fetch_assoc())
                                    {
                                        echo '<option value="'.$data['tenphongban'].'">'.$data['tenphongban'].'</option>';
                                    }
                                ?>
                            </select>
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
                                <a href="../index.php" class="btn btn-primary btn-block">Reload</a>';
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