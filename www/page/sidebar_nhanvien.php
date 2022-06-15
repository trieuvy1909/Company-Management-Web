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
                    <a href="#menu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Quản lí task</a>
                    <ul class="collapse list-unstyled" id="menu1">
                        <li>
                            <a class="collapse-item" href="../quanly_task/danhsach_task.php">Danh sách Task</a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a href="#menu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Quản lí ngày nghỉ phép</a>
                    <ul class="collapse list-unstyled" id="menu2">
                        <li>
                            <a class="collapse-item" href="../quanly_ngaynghi/create_donxinnghi.php">Tạo đơn</a>
                            <a class="collapse-item" href="../quanly_ngaynghi/donxinnghi_cuatoi.php">Danh sách đơn của tôi</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>