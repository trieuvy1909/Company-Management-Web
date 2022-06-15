<div class="modal fade" id="xacnhan_xoatask" tabindex="-1" role="dialog" aria-labelledby="xacnhan_xoatask" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="xacnhan_xoatask">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Sau khi xác nhận task <b><?=$task_id?></b>  sẽ bị xóa khỏi danh sách
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger"  href="/quanly_task/delete_task.php?id=<?=$data['task_id']?>">Delete</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>