<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT-->
        <!-- BEGIN PORTLET-->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Nhân viên</span>
                </div>
                <div class="tools">
                        
            
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
                
                        <a class="btn btn-info pull-right admin-btn m-r" href="javascript:void(0)" onclick="$('#export_location_form').submit();"><i class="fa fa-globe"></i> xem địa phương</a>
                        <form method="POST" action="" id="export_location_form" style="display:none;">
                            <input name="export_location_column[]" type="hidden" value="country_id|Quốc gia|120" />
                            <input name="export_location_column[]" type="hidden" value="city_id|Thành phố|120" />
                            <input name="export_location_column[]" type="hidden" value="district_id|Quận huyện|120" />
                        </form>
                        <a class="btn btn-primary pull-right admin-btn" href="#import-data" data-toggle="modal"><i class="fa fa-upload"></i> import</a>
                        <a class="btn btn-primary pull-right admin-btn" href="javascript:void(0)" onclick="$('#export_form').submit();"><i class="fa fa-file"></i> export</a>
                        <form method="POST" action="" id="export_form" style="display:none;">
                            <input name="export_column[]" type="hidden" value="code|Mã nhân viên|100" />
                            <input name="export_column[]" type="hidden" value="name|Tên nhân viên|120" />
                            <input name="export_column[]" type="hidden" value="birthday|Ngày sinh|100" />
                            <input name="export_column[]" type="hidden" value="gender|Giới tính|80" />
                            <input name="export_column[]" type="hidden" value="note|Ghi chú|160" />
                            <input name="export_column[]" type="hidden" value="avatar|Hình đại diện|100" />
                            <input name="export_column[]" type="hidden" value="address|Địa chỉ|160" />
                            <input name="export_column[]" type="hidden" value="country_id|Quốc gia|100" />
                            <input name="export_column[]" type="hidden" value="city_id|Thành phố|100" />
                            <input name="export_column[]" type="hidden" value="district_id|Quận huyện|100" />
                            <input name="export_column[]" type="hidden" value="phone_1|Điện thoại|100" />
                            <input name="export_column[]" type="hidden" value="phone_2|Điện thoại 2|100" />
                            <input name="export_column[]" type="hidden" value="email|Email|160" />
                            <input name="export_column[]" type="hidden" value="status|Kích hoạt|100" />
                        </form>
        
                        <a class="btn btn-success pull-right admin-btn" onclick="load_employee_add()" href="#employee_detail" data-toggle="modal"><i class="fa fa-plus"></i> thêm</a>
                        <a class="btn btn-danger pull-right admin-btn" href="javascript:void(0)" onclick="delete_employee_multiple();"><i class="fa fa-times"></i> xoá</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="table-container table-responsive">
                            <table class="table table-hover" id="employee_list">
                                <thead>
                                <tr role="row" class="heading">
                                    
                            
                            <th width="50"><div class="checkbox-list"><label><input type="checkbox" class="check_all" /></label></div></th>
            
                            <th width="200">Tên nhân viên</th>
            
                            <th>SĐT</th>

                            <th>Email</th>
            
                            <th width="150">Tình trạng</th>
            
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


<div id="employee_detail" class="modal fade">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h3 class="modal-title"><i class="fa fa-edit"></i> Nhân viên</h3>
            </div>
            <form id="employee_form">
                
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<div id="import-data" class="modal modal-styled fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><i class="fa fa-upload"></i> Import dữ liệu</h3>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <label>Import: <a></a></label>
                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput"><span class="fileinput-filename"></span></div>
                        <span class="input-group-addon btn btn-default btn-file">
                        <input type="hidden" id="file_table" value="employee" />
                            <span class="fileinput-new" id="file_upload">Chọn file</span>
                        </span>
                    </div>
                    <div class="progress file_upload_progress" style="display:none;">
                      <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width: 5%"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br/>
                <p style="color:green;font-style:italic;text-align:center;">Lưu ý: khi bạn import dữ liệu, tất cả dữ liệu cũ sẽ được giữ lại và trộn với dữ liệu mới!</p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default" data-dismiss="modal" id="close_import">đóng</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->