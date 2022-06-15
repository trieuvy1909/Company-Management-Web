<?php
    function check_section()
    {
        if (!isset($_SESSION['tennv']) && !isset($_SESSION['username'])) {
            header('Location: ../login.php');
            exit();
        }
        else if($_SESSION['username']==$_SESSION['password'])
        {
            header("Location: ../quanly_canhan/reset_password_first.php");
            exit();
        }
    }
    function open_database()
    {
        $host = 'mysql-server'; // tên mysql server
        $user = 'root';
        $pass = 'root';
        $dbname = 'nhanvien'; // tên databse
        $con = mysqli_connect($host, $user, $pass, $dbname);
        
        if ($con->connect_error) {
            echo '<div class="alert alert-danger">Không thể kết nối database</div>';
            die($con->connect_error);
        }
        return $con;
    }
    function update_loainv()
    {
        $con = open_database();
        $username=$_SESSION['username'];
        $query = "select * from `nhanvien` WHERE username = '$username'";
        $results = mysqli_query($con, $query);
        $count= mysqli_num_rows($results);
        if($count==1)
        {
            $loainv=$results->fetch_assoc()['loainv'];
        }
        return $loainv;
    }
?>
