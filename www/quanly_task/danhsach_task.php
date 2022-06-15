<?php
    include_once('../db.php');
    session_start();
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $con = open_database();
    
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
                        <h1 class="h3 mb-0 text-gray-800">Danh sách task</h1>
                    </div>
                </div>
                <!-- Nội dung -->
                <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách task</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Mã task</th>
                                            <th>Tên task</th>
                                            <th>Mã nhân viên</th>
                                            <th>Tên phòng ban</th>
                                            <th>Hạn nộp</th>
                                            <th>Trạng thái</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
<?php
    $tenphongban = $_SESSION['tenphongban'];
    $username = $_SESSION['username'];

    if($_SESSION['loainv']=='Giám Đốc')
    {
        $query = "SELECT * FROM task ORDER BY uutien asc";
    } 
    else if($_SESSION['loainv']=='Trưởng Phòng')
    {
        $query = "SELECT * FROM task where tenphongban ='$tenphongban' ORDER BY uutien asc";
    }
    else
    {
        $query = "SELECT * FROM task where tenphongban ='$tenphongban' and nhanvien_id ='$username' ORDER BY uutien asc";
    }
    $results = mysqli_query($con, $query);
    $count= mysqli_num_rows($results);
    function mau_trangthai($uutien)
    {
        if($uutien==1)
        {
            return "btn btn-danger";
        }
        if($uutien==2)
        {
            return "btn btn-primary";
        }
        if($uutien==3)
        {
            return "btn btn-secondary";
        }
        if($uutien==4)
        {
            return "btn btn-light";
        }
        if($uutien==5)
        {
            return "btn btn-warning";
        }
        if($uutien==6)
        {
            return "btn btn-success";
        }
    }
        if($count!=0)
        {
                while($data = $results->fetch_assoc())
                {
                    if($_SESSION['loainv']=="Nhân Viên" && $data['trangthai']=="Canceled"){}
                    else
                    {
                        echo'
                        <tr>
                            <td>'.$data['task_id'].'</td>
                            <td>'.$data['tentask'].'</td>
                            <td>'.$data['nhanvien_id'].'</td>
                            <td>'.$data['tenphongban'].'</td>
                            <td>'.$data['deadline'].'</td>
                            <td><a class="'.mau_trangthai($data['uutien']).'" href="#">'.$data['trangthai'].'</a></td>';
                            if($_SESSION['loainv']=='Nhân Viên')
                            {
                                echo '<td><a class="btn btn-info" href="/quanly_task/task_action_nhanvien.php?task_id_detail='.$data['task_id'].'">Detail</a></td>';
                            }
                            if($_SESSION['loainv']=='Trưởng Phòng')
                            { 
                                if($data['trangthai']!="New")
                                {
                                    echo '<td><a class="btn btn-info" href="/quanly_task/task_action_truongphong.php?task_id_detail='.$data['task_id'].'">Detail</a>
                                    <a class="btn btn-danger" href="/quanly_task/delete_task.php?id='.$data['task_id'].'">Delete</a>
                                    
                                    </td>';
                                }
                                else
                                {
                                echo '<td>
                                <a class="btn btn-info" href="/quanly_task/task_action_truongphong.php?task_id_detail='.$data['task_id'].'">Detail</a>
                                <a class="btn btn-danger" href="/quanly_task/delete_task.php?id='.$data['task_id'].'">Delete</a>
                                <a class="btn btn-warning" href="/quanly_task/update_task.php?task_id_detail='.$data['task_id'].'">Update</a>
                                </td>';
                                }
                            }
                            if($_SESSION['loainv']=='Giám Đốc')
                            {
                                echo '<td>Không có</td>';
                            }
                            echo '  
                        </tr>';
                    }
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