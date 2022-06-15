<?php
    include_once('../db.php');
    session_start();
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $con = open_database();
    $tenphongban="";
    $mota="";
    $sophong="";
    $error ="";
    $message="";
    if(isset($_POST['tenphongban']) && isset($_POST['mota']) && isset($_POST['sophong']))
    {
        $tenphongban=$_POST['tenphongban'];
        $mota=$_POST['mota'];
        $sophong=$_POST['sophong'];

        if(empty($tenphongban))
        {
            $error = "Vui lòng nhập tên phòng ban";
        }
        else if(empty($mota))
        {
            $error = "Vui lòng nhập mô tả";
        }
        else if(empty($sophong) || !is_numeric($sophong))
        {
            $error = "Vui lòng nhập số phòng";
        }
        if($error=="")
        {
            $query = "SELECT * FROM ds_phongban where tenphongban = '$tenphongban'";
            $results = mysqli_query($con, $query);
            $count= mysqli_num_rows($results);
            if($count==1)
            {
                $error="Tên phòng ban này đã tồn tại";
            }
            else
            {
                $query = "INSERT INTO `ds_phongban`(`tenphongban`, `mota`, `sophong`) VALUES ('$tenphongban','$mota',$sophong)";
                $results = mysqli_query($con, $query);
                if($results==null)
                {
                    $error = "Lỗi thực thi SQL";
                }
                else
                {
                    $message = "Thêm phòng ban thành công";
                }
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
	<title>Thêm phòng ban</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Thêm phòng ban</h1>
                    </div>
                </div>
                <!-- Nội dung -->
                <form method="post" action="create_phongban.php" class="shadow-lg justify-content-center card bg-white mx-auto px-3 pt-3 col-md-6 col-lg-8" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="tenphongban">Tên phòng ban</label>
                        <input value="<?=$tenphongban?>" onclick="clearErrorMessage()" type="text" class="form-control" id="tenphongban" name="tenphongban"  placeholder="Nhập tên phòng ban...">
                    </div>

                    <div class="form-group">
                        <label for="mota">Mô tả</label>
                        <textarea onclick="clearErrorMessage()" type="text" class="form-control" id="mota" name="mota"  placeholder="Nhập mô tả..."><?=$mota?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="sophong">Số phòng</label>
                        <input value="<?=$sophong?>" onclick="clearErrorMessage()" type="number" class="form-control" id="sophong" name="sophong"  placeholder="Nhập số phòng...">
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
                                <a href="../quanly_phongban/create_phongban.php" class="btn btn-primary btn-block">Reload</a>';
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