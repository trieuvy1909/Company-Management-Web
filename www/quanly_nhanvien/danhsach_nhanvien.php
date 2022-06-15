<?php
    $query = "SELECT * FROM nhanvien";
    $results = mysqli_query($con, $query);
    $count= mysqli_num_rows($results);
echo'
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách nhân viên</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Mã nhân viên</th>
                                            <th>Tên nhân viên</th>
                                            <th>Loại nhân viên</th>
                                            <th>Phòng ban</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ';
                                        if($count!=0)
                                        {
                                            while($data = $results->fetch_assoc())
                                            {
            if($data['loainv']=='Giám Đốc')
            {
                echo'
                    <tr>
                        <td>'.$data['manv'].'</td>
                        <td>'.$data['tennv'].'</td>
                        <td>'.$data['loainv'].'</td>
                        <td>'.$data['tenphongban'].'</td>
                        <td><a class="btn btn-info" href="/quanly_canhan/profile.php?username_profile='.$data['username'].'">Profile</a>    
                    </tr>';
            }
            else{
                echo'
                    <tr>
                        <td>'.$data['manv'].'</td>
                        <td>'.$data['tennv'].'</td>
                        <td>'.$data['loainv'].'</td>
                        <td>'.$data['tenphongban'].'</td>
                        <td><a class="btn btn-info" href="/quanly_canhan/profile.php?username_profile='.$data['username'].'">Profile</a>
                        <a class="btn btn-danger" href="quanly_nhanvien/delete_nhanvien.php?username_del='.$data['username'].'">Remove</a></td>   
                    </tr>';
                }
                                            }
                                        }
                                        echo'
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>';
?>