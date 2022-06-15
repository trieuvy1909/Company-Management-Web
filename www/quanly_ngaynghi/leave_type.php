
<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Danh sách đơn xin nghỉ</b>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">ID</th>
									<th class="">Mã nhân viên</th>
									<th class="">Chức vụ</th>
									<th class="">Tên phòng ban</th>
									<th class="">Trạng thái</th>
									<th class="">Ngày tạo đơn</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$query="";
								$loainv=update_loainv();
								if($loainv=="Giám Đốc")
								{
									$query = "SELECT * FROM `donxinnghi` where loainv ='Trưởng Phòng' order by id_donxinnghi desc;
									";
								}
								else if($loainv=="Trưởng Phòng")
								{
									$query = "SELECT * FROM `donxinnghi` where loainv ='Nhân Viên' order by id_donxinnghi desc;
									";
								}
								$results = mysqli_query($con, $query);
								$count= mysqli_num_rows($results);
								{
									if($count==0)
									{
										echo'<div class="alert alert-primary text-center" role="alert">
                Chưa có dữ liệu
            </div>';
									}
									else
									{
										while($data = $results->fetch_assoc())
										{
											echo'
											<tr>
											<td>'.$data['id_donxinnghi'].'</td>
											<td>'.$data['nhanvien_id'].'</td>
											<td>'.$data['loainv'].'</td>
											<td>'.$data['tenphongban'].'</td>
											<td>'.$data['trangthai'].'</td>
											<td>'.$data['ngaytaodon'].'</td>
											<td><a class="btn btn-info" href="donxinnghi_detail.php?id='.$data['id_donxinnghi'].'">Detail</a></td>
											</tr>';
										}
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<?php include('../page/footer.php');   ?>