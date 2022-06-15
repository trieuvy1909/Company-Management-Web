<?php
    session_start();
    include_once('../db.php');
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $nhanvien_id = $_SESSION['username'];
    $tenphongban = $_SESSION['tenphongban'];
    $con = open_database();
    
    $query = "SELECT * FROM donxinnghi where nhanvien_id = '$nhanvien_id'";
    $results = mysqli_query($con, $query);
    $count= mysqli_num_rows($results);
    

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
                        <h1 class="h3 mb-0 text-gray-800">Lịch sử tạo đơn</h1>
                    </div>
        </div>
                <!-- Nội dung -->
                <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn xin nghỉ của tôi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center rounded" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Mã nhân viên</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        if($count>0)
                                        {
                                            while($data=$results->fetch_assoc())
                                            {
                                                
                                                echo '<tr>
                                                <td>'.$data['id_donxinnghi'].'</td>
                                                <td>'.$data['nhanvien_id'].'</td>
                                                <td>'.$data['ngaytaodon'].'</td>
                                                <td>'.$data['trangthai'].'</td>
                                                </tr>';
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo'<div class="alert alert-primary text-center" role="alert">
                                                Chưa có dữ liệu
                                            </div>';
                                        }
                                ?>
                            </tbody>
                        </table>
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
