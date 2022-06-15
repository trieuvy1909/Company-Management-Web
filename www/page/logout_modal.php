<div class="modal fade" id="logoutModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
        <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Bạn chắc chứ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        Chọn Logout để kết thúc phiên làm việc!
        </div>
        <div class="modal-footer">
            <a class="btn btn-danger btn-block" href="../logout.php">Logout</a>
            <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<div class="modal fade" id="reset_password_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="reset_password_ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
        <div class="modal-header">
            <h5 class="modal-title" id="reset_password_ModalLabel">Bạn chắc chứ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        Sau khi xác nhận mật khẩu của tài khoản sẽ về trạng thái mặc định!
        </div>
        <div class="modal-footer">
            <a class="btn btn-danger btn-block" href="../quanly_nhanvien/reset_password_default.php?username=<?=$data['username']?>">Xác nhận</a>
            <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>