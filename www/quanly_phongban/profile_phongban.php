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
    $error1 ="";
    $message1="";
    $error2 ="";
    $message2="";
    $nhanvien_id="Chọn nhân viên";
    if(isset($_GET['tenphongban']))
    {
        $tenphongban=$_GET['tenphongban'];
        if(empty($tenphongban))
        {
            $error1 = "Tên phòng ban không hợp lệ";
        }
        if($error1=="")
        {
                $query = "select * from `ds_phongban` WHERE tenphongban = '$tenphongban'";
                $results = mysqli_query($con, $query);
                $count= mysqli_num_rows($results);
                if($count==1)
                {
                    if($results==null)
                    {
                        $error1 = "Lỗi thực thi SQL";
                    }
                    else
                    {
                        $data=$results->fetch_assoc();
                        $tenphongban = $data['tenphongban'];
                        $mota = $data['mota'];
                        $sophong = $data['sophong'];
                    }
                }
                else
                {
                    $error1 =  "Thông tin không hợp lệ ";
                }
        }
    }
    if(isset($_POST['tenphongban']) && isset($_POST['mota']) && isset($_POST['sophong']))
    {
        $tenphongban=$_POST['tenphongban'];
        $mota=$_POST['mota'];
        $sophong=$_POST['sophong'];

        if(empty($tenphongban))
        {
            $error1 = "Vui lòng nhập tên phòng ban";
        }
        else if(empty($mota))
        {
            $error1 = "Vui lòng nhập mô tả";
        }
        else if(empty($sophong) || !is_numeric($sophong))
        {
            $error1 = "Vui lòng nhập số phòng";
        }
        if($error1=="")
        {
            $query = "UPDATE `ds_phongban` SET `mota`='$mota',`sophong`=$sophong WHERE tenphongban = '$tenphongban'";
                $results = mysqli_query($con, $query);
                if($results==null)
                {
                    $error1 = "Lỗi thực thi SQL";
                }
                else
                {
                    $message1 = "Sửa thông tin phòng ban thành công";
                }
        }
    }

    if(isset($_POST['tenphongban']) && isset($_POST['tentruongphong_hientai']) && isset($_POST['nhanvien_id']))
    {
        $tenphongban=$_POST['tenphongban'];
        $tentruongphong_hientai=$_POST['tentruongphong_hientai'];
        $nhanvien_id=$_POST['nhanvien_id']; 

        if(empty($tenphongban))
        {
            $error2 = "Vui lòng nhập tên phòng ban";
        }

        else if(empty($tentruongphong_hientai))
        {
            $error2 = "Vui lòng nhập tên trưởng phòng hiện tại";
        }
        else if(empty($nhanvien_id)||$nhanvien_id=="Chọn nhân viên")
        {
            $error2 = "Vui lòng chọn nhân viên cần bổ nhiệm";
        }
        if($error2=="")
        {
            if($tentruongphong_hientai!="Chưa được bổ nhiệm")
            {
                $query = "UPDATE `nhanvien` SET `loainv`='Nhân Viên' WHERE manv = '$tentruongphong_hientai'";
                $results = mysqli_query($con, $query);
                if($results==null)
                {
                    $error2 = "Lỗi thực thi SQL khi hạ chức vụ của trưởng phòng ".$tentruongphong_hientai;
                }
                else
                {
                    $message2 = "Hạ chức vụ trưởng phòng hiện tại thành công. ";
                }
            }
        }
        if($error2=="")
        {
            $query = "UPDATE `nhanvien` SET `loainv`='Trưởng Phòng' WHERE manv = '$nhanvien_id'";
            $results = mysqli_query($con, $query);
            if($results==null)
            {
                $error2 = "Lỗi thực thi SQL khi bổ nhiệm chức vụ của trưởng phòng ".$nhanvien_id;
            }
            else
            {
                $message2 = $message2."Bổ nhiệm thành công. ";
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
	<title>Chi tiết phòng ban</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Chi tiết phòng ban</h1>
                    </div>
                </div>
                <!-- Nội dung -->
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <form method="post" action="profile_phongban.php" class="shadow-lg justify-content-center card bg-white mx-auto px-3 pt-3 col-md-6 col-lg-8">
                    <div class="form-group">
                        <label for="tenphongban">Tên phòng ban</label>
                        <input value="<?=$tenphongban?>" onclick="clearErrorMessage()" type="text" class="form-control" id="tenphongban" name="tenphongban"  placeholder="Nhập tên phòng ban..." readonly>
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
                            if(!empty($error1))
                            {
                                echo '<div class="alert text-center alert-danger" id="errorMessage">' . $error1 .'</div>';
                            }
                            else
                            {
                                echo '<div class="alert text-center alert-danger" id="errorMessage" style="display: none;"></div>';
                            }
                            if(!empty($message1)&& empty($error1))
                            {
                                echo '<div id="successMessage" class="alert alert-success">' . $message1 .'</div>
                                <a href="../quanly_phongban/profile_phongban.php?tenphongban='.$tenphongban.'" class="btn btn-primary btn-block">Reload</a>';
                            }
                            else
                            {
                                echo '<button type="submit" class="btn btn-primary btn-block">Sửa</button>';
                            }
                        ?>                    
                    </div>         
                </form>
            </div>
            <div class="col-md-12 col-lg-6">
                <form method="post" action="profile_phongban.php" class="shadow-lg justify-content-center card bg-white mx-auto px-3 pt-3 col-md-6 col-lg-8">
                    <div class="form-group">
                        <label for="tenphongban">Tên phòng ban</label>
                        <input value="<?=$tenphongban?>" onclick="clearErrorMessage()" type="text" class="form-control" id="tenphongban" name="tenphongban"  placeholder="Nhập tên phòng ban..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="tentruongphong_hientai">Trưởng phòng hiện tại</label>
                        <?php
                                    $query = "SELECT * FROM nhanvien WHERE tenphongban=
                                    '$tenphongban' and loainv='Trưởng Phòng'";
                                    $results = mysqli_query($con, $query);
                                    $count= mysqli_num_rows($results);
                                    if($count==1)
                                    {
                                        $tentruongphong_hientai = $results->fetch_assoc()['manv'];
                                    }
                                    else
                                    {
                                        $tentruongphong_hientai = "Chưa được bổ nhiệm";
                                    }
                                ?>
                        <input value="<?=$tentruongphong_hientai?>" onclick="clearErrorMessage()" type="text" class="form-control" id="tentruongphong_hientai" name="tentruongphong_hientai"  readonly>
                    </div>
                    <div class="form-group">
                            <label for="nhanvien_id">Nhân viên được bổ nhiệm</label>
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
                    <div class="form-group"> 
                        <?php
                            if(!empty($error2))
                            {
                                echo '<div class="alert text-center alert-danger" id="errorMessage">' . $error2 .'</div>';
                            }
                            else
                            {
                                echo '<div class="alert text-center alert-danger" id="errorMessage" style="display: none;"></div>';
                            }
                            if(!empty($message2)&& empty($error2))
                            {
                                echo '<div id="successMessage" class="alert alert-success">' . $message2 .'</div>
                                <a href="../quanly_phongban/profile_phongban.php?tenphongban='.$tenphongban.'" class="btn btn-primary btn-block">Reload</a>';
                            }
                            else
                            {
                                echo '<a class="btn btn-primary btn-block" data-toggle="modal" data-target="#bonhiem_truongphong_Modal">Bổ nhiệm</a>';
                            }
                        ?>                    
                    </div>   
<div class="modal fade" id="bonhiem_truongphong_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="bonhiem_truongphong_ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
        <div class="modal-header">
            <h5 class="modal-title" id="bonhiem_truongphong_ModalLabel">Bạn chắc chứ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        Sau khi xác nhận bổ nhiệm thông tin về chức vụ của nhân viên và trưởng phòng sẽ thay đổi!
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-block">Xác nhận</button>
            <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
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