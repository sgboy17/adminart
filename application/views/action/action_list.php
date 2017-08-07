<div class="container">
    <div class="row">
   
        <div class="col-sm-12 col-md-12 p-t">
            <a class="btn btn-success pull-right" onclick="load_action_add()" href="#action_detail" data-toggle="modal"><i class="fa fa-plus"></i> thêm</a>
            
            
            
            
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
                
        

            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a>Thao tác</a></li>
            </ul>
            
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table id="action_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            
                            
                            <th>Trung tâm</th>
            
                            <th>Object</th>
            
                            <th>Thao tác</th>
            
                            <th>Từ</th>
            
                            <th>đến</th>
            
                            <th>Ghi chú</th>
            
                            <th>Tạo ngày</th>
            
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


<div id="action_detail" class="modal modal-styled fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><i class="fa fa-edit"></i> Thao tác</h3>
			</div>
			<form id="action_form">
				
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->