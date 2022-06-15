<?php 
$loainv = update_loainv();
    if($loainv=='Giám Đốc')
    {
        include('../page/sidebar_giamdoc.php');
    }
    else if($loainv=='Trưởng Phòng')
    {
        include('../page/sidebar_truongphong.php');
    }
    else if($loainv=="Nhân Viên")
    {
        include('../page/sidebar_nhanvien.php');
    }
?>