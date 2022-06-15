<?php
    session_start();
    if (isset($_SESSION['tennv'])) {
        header('Location: ../index.php');
        exit();
    }
    include('db.php');
    $con = open_database();
    $username="";
    $password="";
    $tennv="";
    $error="";

    if(isset($_POST['username']) && isset($_POST['password']))
    {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        if(!empty($username) && !empty($password))
        {
            $query = "SELECT * FROM nhanvien WHERE username=
                    '$username'";

            $results = mysqli_query($con, $query);
            $count= mysqli_num_rows($results);
            if($count==1)
            {
                    $data= $results->fetch_assoc();
                    if(password_verify($password,$data['password']))
                    {
                            $_SESSION['tennv'] = $data['tennv'];
                            $_SESSION['loainv'] = $data['loainv'];
                            $_SESSION['tenphongban'] = $data['tenphongban'];
                            $_SESSION['username'] = $username;
                            $_SESSION['password'] = $password;
                            $_SESSION['avatar'] = $data['avt'];
                            header("Location: index.php");
                            exit();
                    }
                    else
                    $error="Mật khẩu sai";
            }    
            else
                $error="Tên đăng nhập sai";
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
	<title>Đăng nhập</title>
</head>

<body class="bg-info">
    <div class="container mt-5">

        <!-- Outer Row -->
        <div class="row justify-content-center" >

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img  src="images/img_login.jpg" width="100%" height="100%"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <hr>
                                    <form action="login.php" method="post"  onsubmit="return validateInput()">
                    
                                        <div class="form-group">
                                            <input  value="<?= $username ?>" name="username" id="username" type="text" class="form-control input-lg" placeholder="Enter username..." autofocus onclick="clearErrorMessage()">
                                        </div>
                                        <div class="form-group">
                                            <input name="password" id="password" type="password" class="form-control input-lg" placeholder="Enter password..." onclick="clearErrorMessage()">
                                        </div>
                                        <div class="form-group"> 
                                            <?php
                                                if(!empty($error))
                                                {
                                                    echo '<div class="alert alert-danger" id="errorMessage">' . $error .'</div>';
                                                }
                                                else
                                                {
                                                    echo '<div class="alert alert-danger" id="errorMessage" style="display: none;"></div>';
                                                }
                                            ?>
                                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                                            </div> 
                                            <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
                                        
    </div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
</body>

</html>