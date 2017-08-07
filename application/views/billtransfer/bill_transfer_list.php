<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT-->
        <!-- BEGIN PORTLET-->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Phiếu chuyển tiền</span>
                </div>
                        
                <a class="btn btn-info pull-right admin-btn" href="#search_detail" data-toggle="modal"><i class="fa fa-search-plus"></i></a>
    
                <div class="form-group pull-right m-r-sm">
                    <input type="text" class="form-control" id="search" placeholder="Tìm kiếm">
                    <input type="hidden" id="type_search" value="0">
                </div>

                <div class="pull-right m-r">
                    <select class="form-control" id="range_date">
                        <option value="">- Tất cả -</option>
                        <option value="1">Hôm nay</option>
                        <option value="2">Hôm qua</option>
                        <option value="3">Tháng này</option>
                        <option value="4">Tháng trước</option>
                    </select>
                </div>

                <a class="btn btn-success pull-right admin-btn m-r" onclick="load_bill_transfer_add()" href="#bill_transfer_detail" data-toggle="modal"><i class="fa fa-plus"></i> thêm</a>
                <a class="btn btn-danger pull-right admin-btn" href="javascript:void(0)" onclick="delete_bill_transfer_multiple();"><i class="fa fa-times"></i> xoá</a>
                <a class="btn btn-primary pull-right admin-btn" href="javascript:void(0)" onclick="approve_bill_transfer();"><i class="fa fa-check-square-o"></i> duyệt</a>
                <a class="btn btn-warning pull-right admin-btn" href="javascript:void(0)" onclick="unapprove_bill_transfer();"><i class="fa fa-square-o"></i> bỏ duyệt</a>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="table-container table-responsive">
                            <table class="table table-hover" id="bill_transfer_list">
                                <thead>
                                <tr role="row" class="heading">
                                    
                            
                                    <th width="50"><div class="checkbox-list"><label><input type="checkbox" class="check_all" /></label></div></th>
                
                                    <th>Mã phiếu</th>
                    
                                    <th>Ngày chuyển</th>
                    
                                    <th>Chi nhánh thu</th>
                    
                                    <th>Chi nhánh chi</th>
                    
                                    <th>Số tiền chuyển</th>

                                    <th>Trạng thái</th>
                    
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


<div id="bill_transfer_detail" class="modal fade">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3 class="modal-title"><i class="fa fa-edit"></i> Phiếu chuyển tiền</h3>
            </div>
            <form id="bill_transfer_form">
                
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="search_detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3 class="modal-title"><i class="fa fa-search"></i> Tìm kiếm nâng cao</h3>
            </div>
            <div class="modal-body">

                <div class="form-group m-t-sm">
                    <div class="col-md-3">
                        <div class="m-t-sm">Từ ngày:</div>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="from_date" id="from_date" class="form-control datepicker"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-3">
                        <div class="m-t-sm">Đến ngày:</div>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="to_date" id="to_date" class="form-control datepicker"></input>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-3">
                        <div class="m-t-sm">Chi nhánh chi:</div>
                    </div>
                    <div class="col-md-9">
                        <select class="form-control" name="branch_id_outcome" id="branch_id_outcome">
                            <option value="">- tất cả -</option>
                            
                            <?php 
                            $branch_list = $this->branchm->get_items();
                            foreach($branch_list->result() as $row){ ?>
                            <option value="<?php echo $row->branch_id ?>" ><?php echo $row->name ?></option>
                            <?php } ?>
                
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-3">
                        <div class="m-t-sm">Chi nhánh thu:</div>
                    </div>
                    <div class="col-md-9">
                        <select class="form-control" name="branch_id_income" id="branch_id_income">
                            <option value="">- tất cả -</option>
                            
                            <?php 
                            $branch_list = $this->branchm->get_items();
                            foreach($branch_list->result() as $row){ ?>
                            <option value="<?php echo $row->branch_id ?>" ><?php echo $row->name ?></option>
                            <?php } ?>
                
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-3">
                        <div class="m-t-sm">Nhân viên:</div>
                    </div>
                    <div class="col-md-9">
                        <select class="form-control" name="employee_id" id="employee_id">
                            <option value="">- tất cả -</option>
                            
                            <?php 
                            $employee_list = $this->employeem->get_items();
                            foreach($employee_list->result() as $row){ ?>
                            <option value="<?php echo $row->employee_id ?>" ><?php echo $row->name ?></option>
                            <?php } ?>
                
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group m-t-sm">
                    <div class="col-md-3">
                        <div class="m-t-sm">Duyệt:</div>
                    </div>
                    <div class="col-md-9">
                        <select class="form-control" name="status" id="status">
                            <option value="">- tất cả -</option>
                            
                            <option value="-1" >Không duyệt</option>
                    
                            <option value="0" >Chờ duyệt</option>
                    
                            <option value="1" >Đã duyệt</option>
                    
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-info" onclick="bill_transfer_list_filter();"><i class="fa fa-search"></i> tìm</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php if(isset($is_action)&&!empty($is_action)){ ?>
<script>
$(document).ready(function(){
    $('.portlet-title .tools a.btn-success').trigger('click');
});
</script>
<?php } ?>