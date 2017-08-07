<div class="container">
    <div class="row">
   
        <div class="col-sm-12 col-md-12 p-t">
            <a class="btn btn-success pull-right" onclick="load_message_add()" href="#message_detail" data-toggle="modal"><i class="fa fa-plus"></i> thêm</a>
            
            
            
            
            <div class="form-group pull-right m-r-sm">
                <select class="form-control" name="center_id" id="center_id">
                    <option value="">- Trung tâm -</option>
                    
                    <?php 
                    $center_list = $this->centerm->get_items();
                    foreach($center_list->result() as $row){ ?>
                    <option value="<?php echo $row->center_id ?>" ><?php echo $row->name ?></option>
                    <?php } ?>
        
                </select>
            </div>
                
            <div class="form-group pull-right m-r-sm">
                <select class="form-control" name="status" id="status">
                    <option value="">- trạng thái -</option>
                    
            		<option value="1" >Active</option>
            
            		<option value="2" >Inactive</option>
            
                </select>
            </div>
                
        

            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a>Thông báo</a></li>
            </ul>
            
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table id="message_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            
                            
                            <th>Trung tâm</th>
            
                            <th>Tiêu đề</th>
            
                            <th>Nội dung</th>
            
                            <th>Ngày bắt đầu</th>
            
                            <th>Ngày kết thúc</th>
            
                            <th>Người tạo</th>
            
                            <th>Trạng thái</th>
            
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


<div id="message_detail" class="modal modal-styled fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><i class="fa fa-edit"></i> Thông báo</h3>
			</div>
			<form id="message_form">
				
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->