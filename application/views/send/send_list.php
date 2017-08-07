<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT-->
        <!-- BEGIN PORTLET-->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Gửi email & SMS</span>
                </div>
                <div class="tools">
                        <div class="form-group pull-right m-r-sm">
                            <input type="text" name="to_date" id="to_date" placeholder="đến ngày" class="form-control datepicker" />
                        </div>

                        <div class="form-group pull-right m-r-sm">
                            <input type="text" name="from_date" id="from_date" placeholder="từ ngày" class="form-control datepicker" />
                        </div>
          
                        <a class="btn btn-primary pull-right admin-btn m-r" onclick="load_send_add(1)" href="#send_detail" data-toggle="modal"><i class="fa fa-reply"></i> gửi email</a>
                        <a class="btn btn-primary pull-right admin-btn" onclick="load_send_add(2)" href="#send_detail" data-toggle="modal"><i class="fa fa-send"></i> gửi sms</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="table-container table-responsive">
                            <table class="table table-hover" id="send_list">
                                <thead>
                                <tr role="row" class="heading">
            
                            <th width="120">Ngày gửi</th>
        
                            <th>Gửi tới</th>
            
                            <th>Tiêu đề</th>
            
                            <th width="300">Nội dung</th>
            
                            <th>Ghi chú</th>
        
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


<div id="send_detail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3 class="modal-title"><i class="fa fa-edit"></i> Gửi email & SMS</h3>
            </div>
            <form id="send_form">
                
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->