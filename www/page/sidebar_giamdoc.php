<nav id="sidebar">
            <div class="sidebar-header">
                <h3>Công ty VTD</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="nav-item active">
                    <a><i><?=$loainv?></i></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="../index.php">
                    <span>Trang chủ</span></a>
                </li>

                <li class="nav-item">
                    <a href="#menu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Quản lí nhân viên</a>
                    <ul class="collapse list-unstyled" id="menu1">
                        <li>
                            <a class="collapse-item" href="../quanly_nhanvien/create_nhanvien.php">Thêm nhân viên</a>
                            <a class="collapse-item" href="../index.php">Danh sách nhân viên</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#menu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Quản lí task</a>
                    <ul class="collapse list-unstyled" id="menu2">
                        <li>
                            <a class="collapse-item" href="../quanly_task/danhsach_task.php">Danh sách Task</a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a href="#menu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Quản lí ngày nghỉ phép</a>
                    <ul class="collapse list-unstyled" id="menu3">
                        <li>
                            <a class="collapse-item" href="../quanly_ngaynghi/danhsach_donxinnghi.php">Duyệt đơn nghỉ phép</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#menu4" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Quản lí phòng ban</a>
                    <ul class="collapse list-unstyled" id="menu4">
                        <li>
                            <a class="collapse-item" href="../quanly_phongban/create_phongban.php">Thêm phòng ban</a>
                            <a class="collapse-item" href="../quanly_phongban/danhsach_phongban.php">Danh sách phòng ban</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>