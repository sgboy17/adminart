<!--BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content" >
		<!-- END PAGE CONTENT-->
		<!-- END PORTLET-->
		<div class="row">
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-bar-chart font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">Chi nhánh</span>
					</div>

					<div class="form-group pull-right m-r-sm">
						<input type="text" class="form-control" id="search" placeholder="Tìm kiếm">
					</div>
					
					<div class="form-group pull-right m-r-sm">
						<select class="form-control" name="status" id="status">
							<option value="">- tình trạng -</option>
							<option value="1" >Active</option>
							<option value="2" >Inactive</option>
						</select>
					</div>
					

                    <a class="btn btn-success pull-right admin-btn m-r" onclick="load_branch_add()" href="#branch_detail" data-toggle="modal"><i class="fa fa-plus"></i> thêm</a>

                    <a class="btn btn-danger pull-right admin-btn" href="javascript:void(0)" onclick="delete_branch_multiple();"><i class="fa fa-times"></i> xoá</a>


				</div>


				<div class="portlet-body">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<div class="table-container table-responsive">
								<table class="table table-hover" id="branch_list">
									<thead>
										<tr role="row" class="heading">
											<th width="50"><div class="checkbox-list"><label><input type="checkbox" class="check_all" /></label></div></th>
											<th width="150">Tên chi nhánh</th>
											<th width="400">Địa chỉ</th>
											<th width="100">Số điện thoại</th> 
											<th width="150">Trạng thái</th>
											<!-- <th>Ngày tạo</th>
											<th>Ngày sửa</th> -->
											<th width="150"></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END CONTENT -->


<div id="branch_detail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><i class="fa fa-edit"></i> Thông tin chi nhánh</h3>
            </div>
            <form id="branch_form">
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->