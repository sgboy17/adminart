<div class="container">
    <div class="row">
   
        <div class="col-sm-12 col-md-12 p-t">
            <a class="btn btn-success pull-right" onclick="load_center_add()" href="#center_detail" data-toggle="modal"><i class="fa fa-plus"></i> thêm</a>
            
            
            
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
                
        

            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a>Trung tâm</a></li>
            </ul>
            
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table id="center_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            
                            
                            <th>Tên trung tâm</th>
            
                            <th>địa chỉ trung tâm</th>
            
                            <th>Số điện thoại</th>
            
                            <th>Email</th>
            
                            <th>Ghi chú</th>
            
                            <th>Tình trạng</th>
            
                            <th>Ngày tạo</th>
            
                            <th>Ngày sửa</th>
            
                            <th></th>
        
                        </tr>
                    </thead>             
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div id="center_detail" class="modal modal-styled fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><i class="fa fa-edit"></i> Trung tâm</h3>
			</div>
			<form id="center_form">
				
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->