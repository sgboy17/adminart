<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT-->
        <!-- BEGIN PORTLET-->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Cấu hình hệ thống</span>
                </div>
                <div class="tools">
                    <a class="btn btn-success pull-right admin-btn" onclick="setting_save()"><i class="fa fa-save"></i> lưu</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">% VAT mặc định:</div>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input id="general_vat" type="text" class="form-control tooltips" data-html="true" data-original-title="Phầm trăm" value="<?php echo $this->settingm->get_setting_value('general','vat',0); ?>">
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">Báo sắp hết hạn trước:</div>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input id="general_expired" type="text" class="form-control tooltips" data-html="true" data-original-title="Số ngày" value="<?php echo $this->settingm->get_setting_value('general','expired',0); ?>">
                                    <span class="input-group-addon">ngày</span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group m-t-sm">
                            <div class="col-md-4">
                                <div class="m-t-sm">Hiện hình hàng hóa:</div>
                            </div>
                            <div class="col-md-8">
                                <select id="general_product_avatar" class="form-control">
                                    <?php $general_product_avatar = $this->settingm->get_setting_value('general','product_avatar',0); ?>
                                    <option value="0" <?php if($general_product_avatar==0) echo 'selected="selected"'; ?>>Không</option>
                                    <option value="1" <?php if($general_product_avatar==1) echo 'selected="selected"'; ?>>Có</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>

                    <hr/>
                    <div class="col-sm-12 col-md-12">
                        <div class="table-container table-responsive">
                            <table class="table table-hover" id="setting_list">
                                <thead>
                                <tr role="row" class="heading">
        
                                    <th>Chứng từ / phiếu / mã</th>
                    
                                    <th>Ký tự cần thêm vào</th>
                    
                                    <th>Số ký tự phát sinh</th>
                                    
                                    <th>Số trước</th>
                    
                                    <th>Theo chi nhánh</th>
        
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
