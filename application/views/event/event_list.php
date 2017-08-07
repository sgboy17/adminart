<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT-->
        <!-- BEGIN PORTLET-->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Sự kiện Marketing</span>
                </div>
                    
                <div class="form-group pull-right m-r-sm">
                    <input type="text" class="form-control" id="search" placeholder="Tìm kiếm">
                </div>

                 <div class="form-group pull-right m-r-sm">
                    <select class="form-control" name="branch_id" id="branch_id">
                        <option value="">- Trung tâm -</option>
                        
                        <?php 
                        $branch_list = $this->branchm->get_items();
                        foreach($branch_list->result() as $row){ ?>
                        <option value="<?php echo $row->branch_id ?>" ><?php echo $row->name ?></option>
                        <?php } ?>
            
                    </select>
                </div>


                <a class="btn btn-success pull-right admin-btn m-r" onclick="load_event_add()" href="#event_detail" data-toggle="modal"><i class="fa fa-plus"></i> Thêm</a>
                <a class="btn btn-danger pull-right admin-btn" href="javascript:void(0)" onclick="delete_event_multiple();"><i class="fa fa-times"></i> Xoá</a>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="table-container table-responsive">
                            <table class="table table-hover" id="event_list">
                                <thead>
                                <tr role="row" class="heading">

                                    <th width="50"><div class="checkbox-list"><label><input type="checkbox" class="check_all" /></label></div></th>
            
                                   <th>Trung tâm</th>
            
                                    <th>Tên sự kiện</th>
                    
                                    <th>Ngày bắt đầu</th>
                    
                                    <th>Ngày kết thúc</th>
                    
                                    <th>Chiết khấu</th>

                                    <!-- <th width="150">Ngày tạo</th>

                                    <th width="150">Ngày sửa</th> -->

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
        <!-- END PORTLET-->
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->

<div id="event_detail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><i class="fa fa-edit"></i> Sự kiện Marketing</h3>
            </div>
            <form id="event_form">

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
