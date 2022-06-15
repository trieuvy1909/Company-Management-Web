<?php
    session_start();
    include_once('../db.php');
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $tenphongban = $_SESSION['tenphongban'];
    $con = open_database();
    $error="";
    $message ="";
    $id_donxinnghi="";
    if(isset($_GET['id']))
    {
        $id_donxinnghi=$_GET['id'];
        if(empty($id_donxinnghi) || !is_numeric($id_donxinnghi))
        {
            $error = "Mã đơn không hợp lệ";
        }
        if($error=="")
        {
            $query = "SELECT * FROM donxinnghi where id_donxinnghi = '$id_donxinnghi'";
            $results = mysqli_query($con, $query);
            if($results==null)
            {
                $error="Lỗi thực thi SQL";
            }
            else
            {
                $data = $results->fetch_assoc();
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
                        <h1 class="h3 mb-0 text-gray-800">Chi tiết đơn xin nghỉ</h1>
                    </div>
                </div>
                <!-- Nội dung -->
                <form method="post" action="create_donxinnghi.php" class=" shadow-lg justify-content-center card bg-white mx-auto px-3 pt-3 col-md-6 col-lg-8" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label >Mã đơn xin nghỉ</label>
                            <input onclick="clearErrorMessage()" class="form-control" value="<?=$id_donxinnghi?>" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label >Phòng ban</label>
                            <input onclick="clearErrorMessage()" class="form-control" value="<?=$data['tenphongban']?>" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Ngày tạo</label>
                            <input type="text" onclick="clearErrorMessage()" class="form-control" value="<?= $data['ngaytaodon']?>"  disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Nhân viên</label>
                            <input type="text" onclick="clearErrorMessage()" class="form-control" value="<?= $data['nhanvien_id'] ?>"  disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label >Số ngày cần nghỉ</label>
                                <input class="form-control" value="<?= $data['songaynghi']?>" onclick="clearErrorMessage()" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label >Trạng thái</label>
                                <input class="form-control" value="<?= $data['trangthai']?>" onclick="clearErrorMessage()" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Lý do</label>
                        <textarea type="text" onclick="clearErrorMessage()" class="form-control" disabled><?= $data['noidung']?></textarea>
                    </div>

                    <div class="form-group">
                        <label>File đính kèm</label>
                        <?php
                        if($data['file_dinhkem']!="")
                            echo '<a href="../download.php?id='.$data['file_dinhkem'].'">'.basename($data['file_dinhkem']).'</a>';
                        else
                            echo 'Không có';
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
                                <a href="../quanly_ngaynghi/create_donxinnghi.php" class="btn btn-primary btn-block">Reload</a>';
                            }
                            else
                            {
                                if($data['trangthai']=="Waiting")
                                {
                                    echo '<a href="../quanly_ngaynghi/service_donxinnghi.php?approve_id='.$id_donxinnghi.'" class="btn btn-primary btn-block">Approve</a>';
                                    echo '<a href="../quanly_ngaynghi/service_donxinnghi.php?refuse_id='.$id_donxinnghi.'&songaynghi='.$data['songaynghi'].'&nhanvien_id='.$data['nhanvien_id'].'" class="btn btn-danger btn-block">Refuse</a>';
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
