<div class="container">
    <div class="row">
   
        <div class="col-sm-12 col-md-12 p-t">
            <a class="btn btn-success pull-right" onclick="load_class_hour_add()" href="#class_hour_detail" data-toggle="modal"><i class="fa fa-plus"></i> thêm</a>
            
            
            
            
            <div class="form-group pull-right m-r-sm">
                <select class="form-control" name="room_id" id="room_id">
                    <option value="">- Phòng học -</option>
                    
                    <?php 
                    $room_list = $this->roomm->get_items();
                    foreach($room_list->result() as $row){ ?>
                    <option value="<?php echo $row->room_id ?>" ><?php echo $row->name ?></option>
                    <?php } ?>
        
                </select>
            </div>
                
            <div class="form-group pull-right m-r-sm">
                <select class="form-control" name="class_id" id="class_id">
                    <option value="">- Lớp học -</option>
                    
                    <?php 
                    $class_list = $this->classm->get_items();
                    foreach($class_list->result() as $row){ ?>
                    <option value="<?php echo $row->class_id ?>" ><?php echo $row->name ?></option>
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
                <li class="active"><a>Giờ học</a></li>
            </ul>
            
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table id="class_hour_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            
                            
                            <th>Phòng học</th>
            
                            <th>Lớp học</th>
            
                            <th>Thời gian từ</th>
            
                            <th>Thời gian đến</th>
            
                            <th>Ngày</th>
            
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


<div id="class_hour_detail" class="modal modal-styled fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><i class="fa fa-edit"></i> Giờ học</h3>
			</div>
			<form id="class_hour_form">
				
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->