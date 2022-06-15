<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách task</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-striped" id="dataTable" width="100%" cellspacing="0">
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
    $loainv = update_loainv();
    if($loainv=='Trưởng Phòng')
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
                    if($loainv=="Nhân Viên" && $data['trangthai']=="Canceled"){}
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
                            if($loainv=='Nhân Viên')
                            {
                                echo '<td><a class="btn btn-info" href="/quanly_task/task_action_nhanvien.php?task_id_detail='.$data['task_id'].'">Detail</a></td>';
                            }
                            if($loainv=='Trưởng Phòng')
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
                            if($loainv=='Giám Đốc')
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