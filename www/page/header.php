<nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" onclick="thugon_sidebar()" class="btn btn-info">☰</button>
        
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <!-- Nav Item - User Information -->
                <li class="nav-item">
                    <div class="nav-link dropdown-toggle" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo'<span><b>'.$ten_nv.'</b></span>
                            <img class="img-profile rounded-circle width="32" height="32"" src="../avatar/'.$avatar.'">'
                        ?>
                    </div>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow rounded" aria-labelledby="userDropdown">

                        <a class="dropdown-item" href="../quanly_canhan/profile.php">Profile</a>
                        <a class="dropdown-item" href="../quanly_canhan/profile.php?username_profile=<?=$_SESSION['username']?>">Edit Avatar</a>
                        <a class="dropdown-item" href="../quanly_canhan/reset_password.php">Edit Password</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="../Logout.php" data-toggle="modal" data-target="#logoutModal">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>