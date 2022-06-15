<?php
session_start();
if (!isset($_SESSION['tennv']) && !isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
include_once('../db.php');
$avatar = $_SESSION['avatar'];
$ten_nv = $_SESSION['tennv'];
$loainv=update_loainv();
$con = open_database();
$username=$_SESSION['username'];
$password='';
$password_comfirm ='';
$error="";
$message='';

function checkpass($newpasswold, $newpasswold_comfirm)
{
    if ($newpasswold== $newpasswold_comfirm)
        return TRUE;
    return FALSE;
}
if( isset($_POST['newpassword']) && isset($_POST['newpassword_comfirm']))
{
    $password=$_POST['newpassword'];
    $password_comfirm=$_POST['newpassword_comfirm'];

    if (empty($password))
        $error = "Vui lòng nhập mật khẩu mới!";
    else if (empty($_POST['newpassword_comfirm']))
        $error = "Vui lòng xác nhận mật khẩu mới!";
    else if(!checkpass($password,$password_comfirm))
        $error = "Mật khẩu xác nhận không khớp!";
    else if($_SESSION['username']==$password)
        $error = "Trùng mật khẩu cũ";
    else 
    {   
        $password_hash = password_hash($password,PASSWORD_BCRYPT);
                $query=mysqli_query($con,"update nhanvien set password='$password_hash'  where  username='$username'");
                if($query)
                {
                    $message = "Thành công!";
                    session_destroy();
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
	<title>Đổi mật khẩu cho lần đăng nhập đầu tiên</title>
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
                    <h1 class="h3 mb-0 text-gray-800">Trang chủ</h1>
                </div>
            </div>
            <!-- Nội dung -->
            <div class="container" >
                    <div class="row justify-content-center " >
                        <div class="col-md-8 col-lg-6">
                            <h3 class="text-center text-secondary mt-5 mb-3">Đổi mật khẩu</h3>
                            <h6 style="text-align:center;color: red">Vì lý do bảo mật nên bạn vui lòng đổi mật khẩu!</h6>
                            <form action="reset_password_first.php" method="post" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-white shadow-lg">
                            <div class="form-group">
                                    <label for="newpassword">Mật khẩu mới</label>
                                    <input value="<?= $password ?>"  name="newpassword" id="newpassword" type="password" class="form-control input-lg" placeholder="Nhập mật khẩu mới" onclick="clearErrorMessage()">
                                </div>
                                <div class="form-group">
                                    <label for="newpassword_comfirm">Xác nhận mật khẩu</label>
                                    <input value="<?= $password_comfirm ?>" name="newpassword_comfirm" id="newpassword_comfirm" type="password" class="form-control input-lg" placeholder="Nhập lại mật khẩu mới" onclick="clearErrorMessage()">
                                </div>
                            
                                <div class="form-group">
                                    <?php
                                        if(!empty($error))
                                        {
                                            echo '<div class="alert alert-danger" id="errorMessage">' . $error .'</div>';
                                        }
                                        else
                                        {
                                            echo '<div class="alert alert-danger" id="errorMessage" style="display: none;"></div>';
                                        }
                                        if(!empty($message))
                                        {
                                            echo '<div class="alert alert-success">' . $message .'</div>';
                                        }
                                    
                                    if(empty($message))
                                    {
                                        echo '<button type="submit" class="btn btn-primary btn-block">Edit Password</button>';
                                    }
                                    else{
                                        echo '<button href="../login.php" class="btn btn-primary btn-block">Return Login Page</button>';
                                    }
                                    ?>
                                </div>
                            </form>

                        </div>
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