<?php
    include_once('../db.php');
    session_start();
    check_section();
    $ten_nv = $_SESSION['tennv'];
    $avatar = $_SESSION['avatar'];
    $loainv = update_loainv();
    $error="";
    $task_id = "";
    $count="";
    $error="";
    $con = open_database();
    if(isset($_GET['task_id']))
    {
        $task_id = $_GET['task_id'];
        if(empty($task_id) || !is_numeric($task_id))
        {
            $error = "Mã task không hợp lệ";
        }
        else
        {
            $query = "SELECT * FROM `history_submit` WHERE task_id = $task_id";
    
            $results = mysqli_query($con, $query);
            $count= mysqli_num_rows($results);
        }
    }
    else
    {
        $error ="Không nhận được mã task";
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
                        <h1 class="h3 mb-0 text-gray-800">Đổi Avtar</h1>
                    </div>
                </div>
                <!-- Nội dung -->
                <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách sự kiện của Task: <?=$task_id?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Mã lịch sử</th>
                                            <th>Mã task</th>
                                            <th>Lời nhắn</th>
                                            <th>Trạng thái</th>
                                            <th>File đã nộp</th>
                                            <th>Ngày</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
<?php
        if(empty($error))
        {
            if($count!=0)
            {
                while($data = $results->fetch_assoc())
                {
                        echo'
                        <tr>
                            <td>'.$data['history_id'].'</td>
                            <td>'.$data['task_id'].'</td>
                            <td>'.$data['comment'].'</td>
                            <td>'.$data['trangthai'].'</td>
                            <td><a href="../download.php?id='.$data['file_submit'].'">'.basename($data['file_submit']).'</a></td>
                            <td>'.$data['date'].'</td>
                        <tr>';
                }
            }
            else
            {
                $error = "Chưa có dữ liệu";
            }
        }      
        if(!empty($error))
        {
            echo'<div class="alert alert-danger text-center" role="alert">
                '.$error.'
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