<?php
    session_start();
    include_once('../db.php');
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $nhanvien_id = $_SESSION['username'];
    $tenphongban = $_SESSION['tenphongban'];
    $ngaytaodon=date("Y/m/d") ;
    $noidung ="";
    $id_donxinnghi="";
    $con = open_database();
    $songaynghi_duocphep="";
    $songaynghi_dadung="";
    $songaynghi="";
    $file="";
    $error="";
    $message="";
    $file_direc="";
    $block="";
    if($loainv == "Trưởng Phòng")
    {
        $songaynghi_duocphep = 15;
    }
    else if($loainv == "Nhân Viên")
    {
        $songaynghi_duocphep = 12;
    }
    $query = "SELECT * FROM `nhanvien` WHERE username = '$nhanvien_id'";
    $results = mysqli_query($con, $query);
    $songaynghi_dadung=$results->fetch_assoc()['songaynghi'];
    $songaynghi = $songaynghi_duocphep - $songaynghi_dadung;
    $query = "select * from donxinnghi where id_donxinnghi = (select max(id_donxinnghi) from donxinnghi)";
    $results = mysqli_query($con, $query);
    
    if($results->num_rows==0)
    {
        $id_donxinnghi=1;
        $id_donxinnghi_truoc=1;
        $trangthai_dontruoc="";
    }else
    {
        $data=$results->fetch_assoc();
        $id_donxinnghi_truoc=$data['id_donxinnghi'];
        $trangthai_dontruoc=$data['trangthai'];
        $id_donxinnghi=$id_donxinnghi_truoc+1;
    }
    $query = "select * from donxinnghi where nhanvien_id = '$nhanvien_id' and id_donxinnghi = (select max(id_donxinnghi) from donxinnghi)";
    $results = mysqli_query($con, $query);
    
    if($results->num_rows==1)
    {
        $data=$results->fetch_assoc();
        $ngayduyetdon_truoc=$data['ngayduyetdon'];
        $date=date("Y-m-d");
        $secs = strtotime($date) - strtotime($ngayduyetdon_truoc);
        $days = $secs / 86400; 
    }
    else if($results->num_rows==0)
    {
        $days = 8; 
    }
    if($trangthai_dontruoc=="Waiting")
    {
        $block=true;
    }

    if(isset($_POST['ngaytaodon']) &&
        isset($_POST['nhanvien_id']) && isset($_POST['noidung']) 
        && isset($_POST['songaynghi']))
    {
        $songaynghi = $_POST['songaynghi'];
        
        $nhanvien_id=$_POST['nhanvien_id'];
        $noidung = $_POST['noidung'];
        $id_donxinnghi=$_POST['id_donxinnghi'];
        if(($nhanvien_id)=="Chọn id nhân viên" || $nhanvien_id=="")
        {
            $error = "Vui lòng chọn nhân viên phụ trách";
        }
        else if($songaynghi=="Hãy chọn ngày nghỉ" || !is_numeric($songaynghi))
        {
            $query = "SELECT * FROM `nhanvien` WHERE username = '$nhanvien_id'";
                        $results = mysqli_query($con, $query);
                        $songaynghi_dadung=$results->fetch_assoc()['songaynghi'];
            $songaynghi = $songaynghi_duocphep - $songaynghi_dadung;
            $error = "Số ngày nghỉ không hợp lệ";
        }
        else if(empty($noidung))
        {
            $error = "Vui lòng nhập lý do";
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
                        $file_direc = '/donxinnghi/' .$id_donxinnghi.'.'.$file_ext;
                        if(!file_exists("../donxinnghi/")){
                            // Tạo một thư mục mới
                            mkdir('../donxinnghi/');
                        }
                        move_uploaded_file($tmp,$_SERVER['DOCUMENT_ROOT']. $file_direc);
                        $message=$message." Lưu file thành công";

                        move_uploaded_file($tmp,$_SERVER['DOCUMENT_ROOT']. $file_direc);
                        //add don xin nghi
                        $query = "INSERT INTO donxinnghi(id_donxinnghi, nhanvien_id, loainv,tenphongban,`noidung`, `trangthai`, `ngaytaodon`, `ngayduyetdon`, `file_dinhkem`,songaynghi) VALUES ($id_donxinnghi,'$nhanvien_id','$loainv','$tenphongban','$noidung','Waiting','$ngaytaodon',null,'$file_direc','$songaynghi')";
                        
                        $results = mysqli_query($con, $query);
                        if($results!=null)
                        {
                            $message = $message. ". Tạo yêu cầu nghỉ thành công";
                        }
                        // update nhanvien
                        $query = "SELECT * FROM `nhanvien` WHERE username = '$nhanvien_id'";
                        $results = mysqli_query($con, $query);
                        $songaynghi_dadung=$results->fetch_assoc()['songaynghi'];
                        $songaynghi_new=$songaynghi_dadung+$songaynghi;
                        $query = "update nhanvien set songaynghi =$songaynghi_new where username = '$nhanvien_id' ";
                        $results = mysqli_query($con, $query);
                    }
                }
                else{
                    $error ="Vui lòng chọn file đính kèm";
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
                        <h1 class="h3 mb-0 text-gray-800">Trang chủ</h1>
                    </div>
                </div>
                <!-- Nội dung -->
                <form method="post" action="create_donxinnghi.php" class="  justify-content-center card mb-5 bg-white shadow-lg mx-auto px-3 pt-3 col-md-6 col-lg-8 " enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="id_donxinnghi">Mã đơn xin nghỉ</label>
                            <input onclick="clearErrorMessage()" class="form-control" value="<?=$id_donxinnghi?>" name= "id_donxinnghi" id="task_iid_donxinnghid" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="tenphongban">Phòng ban</label>
                            <input onclick="clearErrorMessage()" class="form-control" value="<?=$tenphongban?>" name= "tenphongban" id="tenphongban" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="deadline">Ngày tạo</label>
                            <input type="text" onclick="clearErrorMessage()" class="form-control" value="<?= $ngaytaodon?>" name= "ngaytaodon" id="deadline" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="nhanvien_id">Nhân viên</label>
                            <input type="text" onclick="clearErrorMessage()" class="form-control" value="<?= $nhanvien_id ?>" name= "nhanvien_id" id="nhanvien_id" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Số ngày có thể nghỉ</label>
                            <input onclick="clearErrorMessage()" class="form-control" value="<?=$songaynghi_duocphep?>"   disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label >Số ngày đã nghỉ</label>
                            <input onclick="clearErrorMessage()" class="form-control" value="<?=$songaynghi_dadung?>"  disabled>
                        </div>
                        <div class="form-group col-md-4">
                        <label for="songaynghi">Số ngày cần nghỉ</label>
                            <select id="songaynghi" name="songaynghi" class="custom-select" onclick="clearErrorMessage()">
                                <option selected>Hãy chọn ngày nghỉ</option>
                                <?php
                                    if($songaynghi!=0)
                                    {
                                        for ($i = 1; $i <= $songaynghi;$i++)
                                        {
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                        }
                                    }
                                    
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nhanvien_id">Lý do</label>
                            <textarea type="text" onclick="clearErrorMessage()" class="form-control" name= "noidung" id="noidung"><?= $noidung ?></textarea>
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
                                <a href="../quanly_ngaynghi/create_donxinnghi.php" class="btn btn-primary btn-block">Reload</a>';
                            }
                            else
                            {
                                if($block)
                                {
                                    echo '<a type="submit" class="btn btn-primary btn-block disabled">Đang chờ duyệt</a>';
                                }
                                else if($days<7)
                                {
                                    $days = 7 - $days;
                                    echo '<a type="submit" class="btn btn-primary btn-block disabled">Hãy chờ '.$days. ' ngày nữa</a>';
                                }
                                else
                                {
                                    echo '<button type="submit" class="btn btn-primary btn-block">Tạo</button>';
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
